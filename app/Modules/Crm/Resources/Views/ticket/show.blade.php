@extends('admin.main')
@section('content')

<section class="content-header">
    <h1>
         Detail ticket view
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li>
            <i class="fa fa-pencil-square-o"></i>  <a href=" {{ URL::route('admin.ticket.index')}}">Tickets</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> {{$ticket->title}}
        </li>
    </ol>
</section>
 
<section class="content">


<div class="row">
  <div class="col-md-12">
    <div id="msg_info"></div>
              
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Info</h3>
        
      </div><!-- /.box-header -->
      <div class="box-body table-responsive">
        <table class="table table-hover table-bordered">
          <tr>
            <th>Subject</th>
            <th>Customer Info</th>
            <th>Assigned Users</th>
            <th>Priority</th>
            <th>Status</th>
           
          </tr>
          <tr>
          <td>
            {{$ticket->title}}
          </td>
            <td>
              <div id="customer_info" class="pull-left"> 
                <p class="btn bg-gray-active  btn-sm">
                
                  <span>@if($ticket->customer)
                          <a href="{{URL::route('admin.crm.show',$ticket->customer->id)}}"><i class="fa fa-user"></i> {{ $ticket->customer->name }}</a>
                        @elseif($ticket->email)
                             <i class="fa fa-envelope"></i> {{ $ticket->email }}
                        @endif
                  </span>
                  <a class="btn btn-xs" href="javascript:;" data-target="#modal-delete-assign-customer" id="modaal"  data-tid="{{$ticket->id}}" data-toggle="modal"><i class="fa fa-times"></i></a>
                </p>  
                  @if($ticket->location)
                   <button type="button" class="btn bg-gray-active  btn-sm">
                    <i class="fa fa-map-marker"></i> 
                      <span>{{ $ticket->location->location_name }}</span>
                  </button>
                  @endif
                  @if($ticket->location)
                   <button type="button" class="btn bg-gray-active  btn-sm">
                    <i class="fa  fa-gears"></i> 
                      <span>{{ $ticket->service_item->title }}</span>
                  </button>
                 @endif
              </div>
                <a class="pull-right btn btn-lg" href="javascript:;" data-target="#modal-edit-customer-info" id="modaal" data-id="{{$ticket->id}}" data-toggle="modal"><i class="fa fa-pencil"></i></a>
            </td>
            <td>
              <div id="assigned_users" class="pull-left"> 
                @if($ticket->assigned_to)
                @foreach($ticket->assigned_to as $employee)
                 <p class="btn bg-gray-active  btn-sm">
                    
                        <i class="fa fa-user"></i>  
                        <span>{{ $users[$employee->email] }}</span>
                      <a class="btn btn-xs" href="javascript:;" data-target="#modal-delete-assign-user" id="modaal" data-uid="{{$employee->id}}" data-tid="{{$ticket->id}}" data-toggle="modal"><i class="fa fa-times"></i></a>  
                    </p>
                    @endforeach
                 @endif
              </div>
              <a class="pull-right btn btn-lg" href="javascript:;" data-target="#modal-edit-assign-users" id="modaal" data-id="{{$ticket->id}}" data-toggle="modal"><i class="fa fa-pencil"></i></a>
            </td>
            <td>
              <?php 
                $btn_class =  '';
                if($ticket->priority == 'low')
                  $btn_class = 'bg-gray';
                if($ticket->priority == 'normal')
                  $btn_class = 'bg-blue';
                if($ticket->priority == 'high')
                  $btn_class = 'bg-green';
                if($ticket->priority == 'urgent')
                  $btn_class = 'bg-yellow';
                if($ticket->priority == 'critical')
                  $btn_class = 'bg-red';
              ?>
              <div id="priority">
                <button type="button" class="btn {{$btn_class}}  btn-sm">
                  <span>{{$ticket->priority}}</span>
                </button>
                <a class="pull-right btn btn-lg" href="javascript:;" data-target="#modal-edit-priority-status" id="modaal" data-id="{{$ticket->id}}" data-toggle="modal"><i class="fa fa-pencil"></i></a>
              </div>
            </td>

            <td>
              <div id="status">
              <button style="background-color:{{$ticket->status->color_code}}" class="btn   btn-sm" type="button">
                                 
                                    <span>{{$ticket->status->title}}</span>
                                </button>
              
                <a class="pull-right btn btn-lg" href="javascript:;" data-target="#modal-edit-priority-status" id="modaal" data-id="{{$ticket->id}}" data-toggle="modal"><i class="fa fa-pencil"></i></a>
              </div>
            </td>
          </tr>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>


  <div class="col-md-12" id="time_line_ticket">

    <!-- The time line -->
    <ul class="timeline">
      <!-- timeline time label -->
      <li class="time-label">
        <span class="bg-green">
          {{ date('d M. Y', strtotime($ticket->entered_date))}}
        </span>
      </li>
      <!-- /.timeline-label -->
      <!-- timeline item -->
      <li>
        <i class="fa fa-envelope bg-blue"></i>
        <div class="timeline-item">
          <span class="time"><i class="fa fa-clock-o"></i>  {{ date('h:i A', strtotime($ticket->entered_time))}}</span>
          <h3 class="timeline-header"><a href="#">@if($ticket->customer)
               {{ $ticket->customer->name }}
                @elseif($ticket->email)
                 {{ $ticket->sender_name }}@endif</a> sent an email</h3>
          <div class="timeline-body">
            <?php echo urldecode($ticket->body);?>
           </div>

            <div class="timeline-footer">
            @if($ticket->type=='email')
             <a class="btn btn-primary btn-xs " href="javascript:" onclick="add_func('{{$ticket->id}}','reply')"><i class="fa fa-mail-reply"></i> Reply</a>
              <a class="btn btn-primary btn-xs " href="javascript:" onclick="add_func('{{$ticket->id}}','note')"> Add Note</a>
              {{-- <a class="btn btn-danger btn-xs">Delete</a> --}}
            @endif
          </div>
        </div>
      </li>

      @if(count($ticket->attachments)!=0)
      <li>
        <i class="fa fa-paperclip bg-blue"></i>
        <div class="timeline-item">
         
          <h3 class="timeline-header"><a href="#">Attachments</a></h3>
          <div class="timeline-body">
            @foreach($ticket->attachments as $attachment)
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 ff"> 
              @if(basename($attachment->type)=='pdf')
              <img class="img-responsive margin" src="{{url('/')."/img/pdf.jpg"}}" />
                  <div class="overlay" style="display:none">
                    <a class="btn btn-md btn-primary iframe" href="{{url('/')."/attachments/$attachment->name"}}">
                      <i class="fa fa-eye"></i>
                    </a>
                  </div>
              @else
                <img class="img-responsive margin" src="{{url('/')."/attachments/$attachment->name"}}" />
                  <div class="overlay" style="display:none">
                    <a class="btn btn-md btn-primary fancybox" href="{{url('/')."/attachments/$attachment->name"}}">
                      <i class="fa fa-eye"></i>
                    </a>
                  </div>
               @endif 
            </div>
              @endforeach
           </div>
           <div class="clearfix"></div>
        </div>
      </li>
      @endif
     
      @foreach($responses as $date => $response_record)
        {{-- //if ticket type is email then compare the ticket received with response created/received date --}}
        @if($date != date('Y-m-d',strtotime($ticket->entered_date)))
          <li class="time-label">
            <span class="bg-green">
              {{ date('d M. Y', strtotime($date))}}
            </span>
          </li>
        @endif

        @foreach($response_record as $response)
         @if($response->response_type=='response')
          <li>
            <i class="fa fa-comments bg-yellow"></i>
            <div class="timeline-item">
              <span class="time"><i class="fa fa-clock-o"></i> @if($response->sender_type=='customer')
              {{ date('h:i A', strtotime($response->entered_time))}}
              @else
              {{ date('h:i A', strtotime($response->entered_time))}}
              @endif </span>
              <h3 class="timeline-header"><a href="#">
              @if($response->sender_type=='customer')
                  @if($ticket->customer)
                    {{ $ticket->customer->name }}
                  @elseif($ticket->email)
                    {{ $ticket->sender_name }}
                  @endif
              @else
              
                 {{ $response->responder->f_name.' '.$response->responder->l_name}}

              @endif</a> Responded</h3>
              <div class="timeline-body">
                {!! html_entity_decode($response->body) !!}
              </div>
                <div class="timeline-footer">
            @if($response->sender_type=='customer')
              <a class="btn btn-primary btn-xs " href="javascript:" onclick="add_func('{{$ticket->id}}','reply')"><i class="fa fa-mail-reply"></i> Reply</a>
              <a class="btn btn-primary btn-xs " href="javascript:" onclick="add_func('{{$ticket->id}}','note')"><i class="fa fa-sticky-note"></i> &nbsp;&nbsp; Add Note</a>
              {{-- <a class="btn btn-danger btn-xs">Delete</a> --}}
            @endif
          </div>
            </div>
          </li> 
          @endif
          @if($response->response_type=='note')
            <li>
              <i class="fa fa-sticky-note bg-blue"></i>
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 
                  {{ date('h:i A', strtotime($response->entered_time))}}
                </span>
                <h3 class="timeline-header"><a href="#">
               
                   {{ $response->responder->f_name.' '.$response->responder->l_name}}

               </a> Added Note</h3>
                <div class="timeline-body">
                  {!! html_entity_decode($response->body) !!}
                </div>
                <div class="timeline-footer">
               
                </div>
              </div>
            </li> 
          @endif   
        @endforeach
       @endforeach
      <li>
        <i class="fa fa-clock-o bg-gray"></i>
      </li>
    </ul>
  </div> 
  </div> 

    <div class="row top-10px" style="display:none" id="response_div">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border top-border bot_10px">
              <h3 class="box-title"></h3>
            </div>
            <div class="box-body">
              <form action="#" method="POST" id="response_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                 <input type="hidden" name="response_flag" value="reply">

                <div class="form-group col-lg-12" id="from">
                   <div class="input-group">
                      <span class="input-group-addon"><b>From :</b> </span>
                      <input type="text"  class="form-control" value="{{' <'.Config::get('google.email_address').'>'}}" disabled>
                    </div>
                </div>
                <div class="form-group col-lg-12">
                   <div class="col-lg-3">
                     <a href="javascript:" onclick="add_cc()" id="a_cc">Add Cc</a>&nbsp; | &nbsp;
                     <a href="javascript:" onclick="add_bcc()" id="a_bcc">Add Bcc</a>
                    </div>
                </div>
                  <div class="form-group col-lg-12" id="cc" style="display:none">
                    <div class="input-group">
                      <span class="input-group-addon"><b>Cc :</b> </span>
                      <input type="hidden" class="form-control ">

                       {!! Form::select('cc[]', $users,$assigned_users,['class'=>'select2','multiple'=>'','style'=>"width: 100%;"])!!}    
                    </div>
                  </div>
                  <div class="form-group col-lg-12" id="bcc" style="display:none">
                    <div class="input-group">
                      <span class="input-group-addon"><b>Bcc :</b> </span>
                      <input type="hidden" class="form-control ">
                      {!! Form::select('bcc[]', $users,$assigned_users,['class'=>'select2','multiple'=>'','style'=>"width: 100%;"])!!}
                    </div>
                  </div>
                <div class="form-group col-lg-12">
                  {!! Form::textarea('body',null, ['placeholder'=>"Ticket descriptions",'class'=>"form-control textarea",'id'=>'response','rows'=>20]) !!}
                </div>
              </form>  
            
              <div class="col-lg-12"> 
                  <div class="form-group col-lg-6 pull-right">
                     <img id="load_img_z" src="{{asset('img/loader.gif')}}" style="display:none" /> <a class="btn btn-lg btn-info pull-right" onclick="addResponse('response_form')" >Save</a>
                  </div>
              </div>
            </div>
          </div><!-- /.box -->
        </div>
    </div>
    <div class="row top-10px" style="display:none" id="note_div">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border top-border bot_10px">
              <h3 class="box-title"></h3>
              <a class="btn btn-primary btn-xs pull-right" href="javascript:" onclick="mark_duplicate()"><i class="fa fa-copy"></i> Mark as Duplicate</a>
            </div>
            <div class="box-body">
              <form action="#" method="POST" id="note_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                 <input type="hidden" name="response_flag" value="note">
                  <div class="form-group col-lg-12" id="duplicate" style="display:none">
                    <div class="input-group">
                      <span class="input-group-addon"><b>Original Ticket :</b> </span>
                      <input type="hidden" class="form-control ">

                       {!! Form::select('original_ticket', $tickets,'',['class'=>'select2 single','placeholder'=>'Select original','style'=>"width: 100%;"])!!}    
                    </div>
                  </div>
                <div class="form-group col-lg-12">
                  {!! Form::textarea('body',null, ['placeholder'=>"Note detail",'class'=>"form-control textarea",'id'=>'note','rows'=>20]) !!}
                </div>
              </form>  
              <div class="col-lg-12"> 
                  <div class="form-group col-lg-6 pull-right">
                     <img id="load_img_z" src="{{asset('img/loader.gif')}}" style="display:none" /> <a class="btn btn-lg btn-info pull-right" onclick="addResponse('note_form')" >Save</a>
                  </div>
              </div>
            </div>
          </div><!-- /.box -->
        </div>
    </div>
</section>

@include('crm::ticket.edit_assigned_users_modal')
@include('crm::ticket.delete_modal_assign_user')
@include('crm::ticket.delete_modal_assign_customer')
@include('crm::ticket.edit_customer_info_modal')
@include('crm::ticket.edit_priority_status_modal')
@endsection
@section('script')
<script type="text/javascript" src="/js/form_elements.js"></script>
<script src="/ckeditor/ckeditor.js"></script>
   <script src="/ckeditor/config.js"></script> 
      <script src="/fancybox/jquery.fancybox.js?v=2.1.5"></script> 
   <script src="/js/select2.full.min.js"></script>

  <script>
  $(document).ready(function() 
    {
    CKEDITOR.replace( 'response', {
              filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
              filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
              height: '40em'
          } );
    CKEDITOR.replace( 'note', {
              filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
              filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
              height: '40em'
          } );

    $('.fancybox').fancybox();

    $("a.iframe").fancybox({
      
      'type': 'iframe'
      });

    $('.ff').hover(function() {
      $(this).addClass('bb');
      $(this).children('img').css({ opacity: 0.8 });
      $(this).children('.overlay').show();
    }, function() {
      /* Stuff to do when the mouse leaves the element */
      $(this).removeClass('bb');
      $(this).children('img').css({ opacity:1 });
      $(this).children('.overlay').hide();
    });

    $('.multiselect').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control'
            
        });


    $(".select2").select2({
          tags: true
        });
    $(".single").select2();


    } );


function mark_duplicate()
{

  $('#duplicate').show();
}
    function add_func(ticket_id,response_type)
    {
      $("html, body").animate({ scrollTop: $(document).height() }, 1000);
      

      if(response_type =='reply')
      {
        $('#response_div').find('h3.box-title').html('Add Reply');
        $('#response_div').show();
        $('#note_div').hide();
       
      }
      if(response_type =='note')
      {
        $('#note_div').find('h3.box-title').html('Add Note');
         
        $('#note_div').show();
        $('#response_div').hide();

      }
       


    }

    function add_cc()
    {
      
     
     $('#cc').html($('#cc_select').html());
     $('#cc').show();
    }

    function add_bcc()
    {
      $('#bcc').html($('#bcc_select').html());
      $('#bcc').show();
      
    }


  function addResponse(form_id)
  {
      for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
$('#load_img_z').show();

    //{{URL::route('admin.ticket.add_response')}}
     $.ajax({
        url: "{{ URL::route('admin.ticket.add_response')}}",
        //headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: $('#'+form_id).serialize(),
        success: function(response){
         $('#msg').html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');
        $('#msg').removeClass('alert-danger').addClass('alert-success').show(); 
        //location.reload(); 
        $('#time_line_ticket').html(response.html_content);
       
        CKEDITOR.instances['note'].setData('');
         CKEDITOR.instances['response'].setData('');
         $('#load_img_z').hide();
         alert_hide(); 
      }
    });

  }
  </script>
@endsection
@section('styles')
<link href="/css/bootstrap-multiselect.css" rel="stylesheet" />
  <link rel="stylesheet" href="/css/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="/fancybox/jquery.fancybox.css?v=2.1.5">
  <link rel="stylesheet" href="/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5">
 <link rel="stylesheet" href="/css/select2.min.css">
  
  
<style>
.info>dd, .info>dt {
    line-height: 3;
}

.top-border {
        border-top: 1px solid #f4f4f4;
    }
    .top-10px{
        top: 10px;
        position: relative;
    }
    .bot_10px{
        margin-bottom: 10px;
    }

    .margin-right10{
      margin-right: 10px;
    }

.bb {
    background: rgba(0, 0, 0, 0.7) none repeat scroll 0 0;
   
    opacity: 1;
    cursor: pointer;
    overflow: visible;
}
.btn.fancybox {
    color: #000;
    font-size: 30px;
    left: 50%;
    margin-left: -15px;
    margin-top: -15px;
    position: absolute;
    top: 50%;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #3c8dbc;
    border-color: #367fa9;
    color: #fff;
    padding: 1px 10px;
}
</style>
@endsection
