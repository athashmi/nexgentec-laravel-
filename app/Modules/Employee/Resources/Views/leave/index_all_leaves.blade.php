@extends('admin.main')
@section('content')


<section class="content-header">
    <h1>
         Leaves
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Leaves
        </li>
    </ol>
</section>

<section class="content">
    <div class="row">

        <div class="col-xs-12">
            <div class="alert alert-danger"  id="msg_div" style="display:none">
                <ul id="msgs">
                </ul>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Leaves Listing</h3>
                </div>

                <div class=" box-body box-body table-responsive">

                   
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Posted by</th>
                                <th>Position</th>
                                <th>Start Date</th>

                                <th>End Date</th>
                                <th>Created at</th>
                                <th>Leave Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leaves as $leave)
                            
                            
                            <tr>
                                <td>{{ $leave->title }}</td>
                                <td>{{ $leave->user->f_name.' '.$leave->user->l_name }}</td>
                                <td>{{ $leave->user->roles[0]->display_name }}</td>
                                <td>{{ date('d/m/Y',strtotime($leave->start_date)) }}</td>
                                <td>{{ date('d/m/Y',strtotime($leave->end_date)) }}</td>
                                <td>{{ date('d/m/Y',strtotime($leave->created_at ))}}</td>
                                <td>{{ $leave->type }}</td>
                                <td>
                                    @if($leave->status == 'pending')
                                        <button class="btn btn-sm btn-warning" type="button">Pending</button>
                                    @elseif($leave->status == 'approved')
                                        <button class="btn btn-sm btn-success" type="button">Approved</button>
                                    @elseif($leave->status == 'rejected')
                                        <button class="btn btn-sm btn-danger" type="button">Rejected</button>

                                    @endif
                                </td>
                                
                                <td>
                                
                               {{--  <a href="{{ URL::route('employee.leave.edit',$leave->id)}}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Edit</a> --}}
                                @if($leave->status == 'pending')
                                
                                <img id="load_img" src="{{asset('img/loader.gif')}}" style="display:none" />

                                <button type="button" class="btn btn-success btn-sm"
                                       data-id="{{$leave->id}}" id="approve{{$leave->id}}"onclick="approve('{{$leave->id}}')">
                                        {{-- <i class="fa fa-times-circle"></i> --}}
                                        Approve
                                </button>

                                <button type="button" class="btn btn-danger btn-sm"
                                      data-id="{{$leave->id}}" id="modaal-hide{{$leave->id}}"  data-toggle="modal" data-target="#modal-reject">
                                        <i class="fa fa-times-circle"></i>
                                        Reject
                                </button> 
                                 @endif
                                <button type="button" class="btn btn-danger btn-sm"
                                      data-toggle="modal" data-id="{{$leave->id}}" id="modaal" data-target="#modal-delete">
                                        <i class="fa fa-times-circle"></i>
                                        Delete
                                </button>

                                
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                
                </div>
            </div>
        </div>
    </div>
</section>

@include('employee::delete_modal')
@include('employee::reject_modal_ajax')
@endsection
@section('script')
@parent
<script type="text/javascript">
$(document).ready(function()  {
    $('#modal-reject').on('show.bs.modal', function(e) 
      {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');
        //populate the textbox
        $(e.currentTarget).find('input[name="id"]').val(Id);
      });
    });
function approve(leave_id)
{
    var objId = $(this).attr('id'); 
    //e.preventDefault();
    $('#load_img').show();
    $.ajax({
        url: "{{ URL::route('admin.leave.posttocalendar')}}",
        type: 'POST',
        dataType: 'json',
        data: 'leave_id='+leave_id,
        success: function(response){
            $('#load_img').hide();
            //consol.log(response);

            $('#msgs').html(response.success);
            $('#msg_div').removeClass('alert-danger').addClass('alert-success').show(); 
            $('#'+objId).parents('tr').hide();
        
        },
        error: function(data){
            var errors = data.responseJSON;
            //console.log(errors);
            var html_error = '';
            $.each(errors, function (key, value) 
            {
                html_error +='<li>'+value+'</li>';
            })
        $('#msgs').html(html_error);
        $('#msg_div').removeClass('alert-success').addClass('alert-danger').show();
        
        // Render the errors with js ...
      }
    });
}

$(".reject_ajax").click(function(e){
    var objId = $(this).attr('id'); 
       // alert('fff');
      $('#load_img').show();
      $.ajax({
        url: "{{ URL::route('admin.leave.reject_leave')}}",
        //headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: $('#reject_form').serialize(),
        success: function(response){
            //alert('fff');
            //$(this).modal('hide');
            $('#load_img').hide();
            $('#msgs').html(response.success);
            $('#msg_div').removeClass('alert-danger').addClass('alert-success').show();
            //$('#modaal-hide').parents('tr').hide();
            //console.log($(this).parent().parent());
            //$('#'+objId).parents('tr').hide(); 
       location.reload(); 
      }
    });
    e.preventDefault();
  });
</script>
@endsection