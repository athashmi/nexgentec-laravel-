<?php
namespace App\Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Http\Employee;
use App\Modules\Employee\Http\Leave;
use App\Modules\Employee\Http\Requests\LeavePostRequest;

use App\Services\GoogleCalendar;
use App\Model\Role;
use App\Model\User;
use Auth;
class LeaveController extends Controller
{
	private $controller = 'leave';
    

	 public function index()
    {
      //dd(Auth::user());
       
        $controller = $this->controller;
        $route_delete = 'employee.leave.destroy';
        $leaves = Leave::where('user_id',Auth::user()->id)->get();
      

        return view('employee::leave.index_user_leaves',compact('leaves','controller','route_delete'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {      
         
        return view('employee::leave.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeavePostRequest $request)
    {
    	//dd(date( "Y-m-d",strtotime($request->hire_date)));
        //dd($request->all());

        $leave = new Leave;
       	$leave->start_date = date( "Y-m-d",strtotime($request->start_date));
        $leave->end_date   = date( "Y-m-d",strtotime($request->end_date));
        $leave->comments   = $request->comments;
        $leave->title   = $request->title;
        $leave->type   = $request->type;
        $leave->user_id   = Auth::user()->id;

        
        $leave->save();
        
        
      	return redirect()->intended('admin/employee/leave'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    public function destroy(Request $request)
    {
        //dd($id);
        //dd($request->id);
        $id = $request->id;
        $leave = Leave::findorFail($id);
        $leave->delete();
        //Session::flash('flash_message', 'User successfully deleted!');
        return redirect()->intended('admin/employee/leave');
    }

    function listLeaves()
    {
         $leaves = Leave::all();
         //dd($leaves);
          $route_delete = 'employee.leave.destroy';
         return view('employee::leave.index_all_leaves',compact('leaves','route_delete'));
    }
    function listPendingLeaves()
    {
         $leaves = Leave::where('status','pending')->with(['user', 'user.roles'])->get();
         //dd($leaves[0]->user->roles);
          $route_delete = 'employee.leave.destroy';
         return view('employee::leave.index_all_leaves',compact('leaves','route_delete'));
    }
    function listRejectedLeaves()
    {
         $leaves = Leave::where('status','rejected')->with(['user', 'user.roles'])->get();
         //dd($leaves[0]->user->roles);
          $route_delete = 'employee.leave.destroy';
         return view('employee::leave.index_all_leaves',compact('leaves','route_delete'));
    }

    function showCalendar()
    {

        $calendar   = new GoogleCalendar;
        
        //$result     = $calendar->get();
        $events_result     = $calendar->eventList();
       //dd($events_result);
        $events_arr = [];
         //while(true) {
        foreach ($events_result->getItems() as $event) 
        {
            //dd($event->organizer);
            //$calendar->eventDelete($event->getId());
            if($event->start->getDatetime()!=NULL)
            {
                $events_arr[] = ['title'=>$event->getSummary(),
                             'start'=>$event->start->getDatetime(),
                             'end'=>$event->end->getDatetime()];
            }
            else
            {
                 $events_arr[] = ['title'=>$event->getSummary(),
                             'start'=>$event->start->getDate(),
                             'end'=>$event->end->getDate()];
            }
        }
        
        $events = json_encode($events_arr);
          /*$pageToken = $events->getNextPageToken();
          if ($pageToken) {
            $optParams = array('pageToken' => $pageToken);
            $events = $service->events->listEvents('primary', $optParams);
          } else {
            break;
          }*/
        //}
         //$leaves = Leave::all();
         //dd($leaves);
          //$route_delete = 'employee.leave.destroy';
         return view('employee::leave.calendar',compact('events','route_delete'));
    }


    public function postCalander(Request $request)
    {
        //dd($request->leave_id);
        $leave  = Leave::where('id', $request->leave_id)->with('user')->first();
        //dd($leave->user->f_name);
        $calendar   = new GoogleCalendar;
        //dd($leave->user->employee);
        //$result     = $calendar->get();

        $post = $calendar->eventPost(array(
              'summary' => $leave->user->f_name.' '.$leave->user->l_name.'('.$leave->user->roles[0]->display_name.') Leave: '.$leave->title,
              'location' => '',
              'visibility' => 'private',
              'description' => $leave->comments,
              'start' => array(
                'date' => $leave->start_date,
                'timeZone' => $leave->user->employee->time_zone,
              ),
              'end' => array(
                'date' => $leave->end_date,
                'timeZone' => $leave->user->employee->time_zone,
              ),
              'attendees' => array(
                array('email' => $leave->user->email),
                array('email' => Auth::user()->email),
              ),
              'reminders' => array(
                'useDefault' => FALSE,
                'overrides' => array(
                  array('method' => 'email', 'minutes' => 24 * 60),
                  array('method' => 'popup', 'minutes' => 10),
                ),
              ),
            ));
            //dd($post->id);

            if($post)
            {

                $leave_update = Leave::where('id',$request->leave_id)->first();
                $leave_update->status = 'approved';
                $leave_update->google_post = 1;
                $leave_update->google_id = $post->id;
                $leave_update->approved_by = Auth::user()->id;
                $leave_update->save();
            }

        $arr['success'] = 'Leave approved and posted to google calendar sussessfully';
        return json_encode($arr);
        exit;
            //exit;
        //return redirect()->intended('admin/employee/leave/calendar');
    }

    function rejectLeave(Request $request)
    {
        //dd($request->all());
        $leave_update = Leave::where('id',$request->id)->first();
        $leave_update->status = 'rejected';
        $leave_update->approved_by = Auth::user()->id;
        $leave_update->save();
         $arr['success'] = 'Leave rejected sussessfully';
        return json_encode($arr);
       exit;
        //return redirect()->intended('admin/employee/leave/pending_leaves');
    }
}
