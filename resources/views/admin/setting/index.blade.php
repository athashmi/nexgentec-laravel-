@extends('admin.main')
@section('content')

<section class="content-header">
    <h1>
            Settings
    </h1>
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-gears"></i> Settings
        </li>
    </ol>
</section>

<section class="content">
    <div class="row">

        <div class="col-xs-12">

             @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

            @endif

             @if(session('success'))
            <div class="alert alert-success  alert-dismissable">
           <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <ul>

                    <li>{{ session('success') }}</li>

                </ul>
            </div>

            @endif

            <div class="box">
              <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-gear"></i> Global Settings</h3>
                </div>
                <div class="box-body">

                <div class="col-lg-12">

                      <h4 class="box-title bottom-border padding-bottom-8">Security</h4>


                    <div class="box-body">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                              <li class="active"><a href="#tab_role" data-toggle="tab">Roles</a></li>
                              <li><a href="#tab_permissions" data-toggle="tab">Permissions</a></li>

                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="tab_role">

                              </div><!-- /.tab-pane -->
                              <div class="tab-pane" id="tab_permissions">

                              </div><!-- /.tab-pane -->

                            </div><!-- /.tab-content -->
                      </div>
                    </div><!-- /.box-body -->
                </div>



                 <div class="col-lg-12">

                      <h4 class="box-title bottom-border padding-bottom-8">Ticketing</h4>


                    <div class="box-body">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                              <li class="active"><a href="#ticket_statuses" data-toggle="tab">Statuses</a></li>


                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="ticket_statuses">

                              </div><!-- /.tab-pane -->
                            </div><!-- /.tab-content -->
                      </div>
                    </div><!-- /.box-body -->
                </div>


                <div class="col-lg-12">

                      <h4 class="box-title bottom-border padding-bottom-8">CRM</h4>

                    <div class="box-body">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                              <li class="active"><a href="#tab_rates" data-toggle="tab">Default Rates</a></li>
                             <li ><a href="#tab_billing" data-toggle="tab">Billing period</a></li>
                              <li ><a href="#tab_service_items" data-toggle="tab">Service items</a></li>

                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="tab_rates">

                              </div><!-- /.tab-pane -->

                              <div class="tab-pane" id="tab_billing">

                              </div><!-- /.tab-pane -->
                              <div class="tab-pane" id="tab_service_items">

                              </div>
                            </div><!-- /.tab-content -->
                      </div>
                    </div><!-- /.box-body -->
                </div>
              @if(Auth::user()->hasRole('admin'))
                 <div class="col-lg-12">

                      <h4 class="box-title bottom-border padding-bottom-8">Integrations</h4>

                    <div class="box-body">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                              <li class="active"><a href="#tab_zoho" data-toggle="tab">Zoho Invoices</a></li>


                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="tab_zoho">

                              </div><!-- /.tab-pane -->


                            </div><!-- /.tab-content -->
                      </div>
                    </div><!-- /.box-body -->
                </div>
              @endif


                </div>


                 <div class="box-header with-border top-border bot_10px">
                    <h3 class="box-title"><i class="fa fa-gear"></i> User Settings</h3>
                </div>
                <div class="box-body">

                  <div class="nav-tabs-custom">
                      <ul class="nav nav-tabs">

                        <li class="active"><a href="#tab_profile" data-toggle="tab">Profile</a></li>

                        <li><a href="#tab_email" data-toggle="tab">Email</a></li>

                        <li><a href="#tab_gmail_integration" data-toggle="tab">Gmail Integration</a></li>

                         <li><a href="#tab_date_time" data-toggle="tab">Date/Time format</a></li>

                      </ul>
                      <div class="tab-content">

                        <div class="tab-pane active" id="tab_profile">
                          <div class="box-body table-responsive">
                            <table class="table table-hover" id="dt_table">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Name</th>
                                  <th>Phone</th>

                                  <th>Created at</th>
                                   <th>Mobile</th>
                                  <th>Email</th>
                                  <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->f_name.' '.$user->l_name}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>{{ date($global_date,strtotime($user->created_at)) }}</td>
                                    <td>{{$user->mobile}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-id="{{$user->id}}" id="modaal" data-target="#modal-edit-user">
                                             <i class="fa fa-pencil"></i>Edit</button>
                                    </td>
                                  </tr>
                                </tbody>

                            </table>
                          </div>

                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_email">
                           <div class="col-lg-6">

                              <div class="box box-solid">
                                <div class="box-header with-border border-top ">
                                    <h3 class="box-title">Email Signature</h3>
                                  </div><!-- /.box-header -->
                                  <div class="box-body">

                                          <form id="signature_form">
                                             <div class="form-group">

                                                {!! Form::textarea('signature',null, ['placeholder'=>"",'class'=>"form-control textarea",'id'=>'signature','rows'=>10]) !!}
                                              </div>
                                          </form>
                                           <button type="button" class="btn btn-primary btn-sm pull-right" id="signature_update">Update</button>

                                  </div>
                              </div>
                            </div>

                            <div class="col-lg-6">

                              <div class="box box-solid">
                                <div class="box-header with-border border-top ">
                                    <h3 class="box-title">Email Introduction</h3>
                                  </div><!-- /.box-header -->
                                  <div class="box-body">

                                          <form id="email_intro_form" style="display:block">
                                             <div class="form-group">

                                                {!! Form::textarea('email_intro',null, ['placeholder'=>"",'class'=>"form-control textarea",'id'=>'email_intro','rows'=>10]) !!}
                                              </div>
                                          </form>
                                           <button type="button" class="btn btn-primary btn-sm pull-right" id="email_intro_update">Update</button>

                                  </div>
                              </div>
                            </div>

                        </div><!-- /.tab-pane -->


                        <div class="tab-pane" id="tab_gmail_integration">
                          <div class="col-lg-12">
                            <div class="col-lg-4">

                              <div class="box box-solid">
                                  <div class="box-header with-border border-top ">
                                    <h3 class="box-title">Imap Credentials</h3>
                                  </div><!-- /.box-header -->
                                  <div class="box-body">
                                      <form id="imap_credentials">

                                        <div class="form-group">
                                            <label>Email Address</label>
                                            {!! Form::input('email','gmail_email',null, ['placeholder'=>"Email",'class'=>"form-control"]) !!}
                                            <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
                                        </div>

                                        <div class="form-group">
                                            <label>Gmail Password</label>
                                            {!! Form::input('text','gmail_password',null, ['placeholder'=>"Gmail Password",'class'=>"form-control"]) !!}
                                            <!-- <input placeholder="Email" type="text" name="email" value="{{ old('email') }}" class="form-control"> -->
                                        </div>
                                      </form>

                                   <div class="form-group pull-right">
                                      <button class="btn btn-md btn-success btn-block" id="imap_update">Update</button>
                                      </div>
                                  </div><!-- /.box-body -->
                              </div>

                            </div>
                            <div class="col-lg-4">
                              <div class="box box-solid">
                                <div class="box-header with-border border-top ">
                                    <h3 class="box-title">Gmail SMTP</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                      <form id="smtp_credentials">
                                        <div class="form-group">
                                            <label>Server Address</label>
                                            {!! Form::input('text','server_address',null, ['placeholder'=>"Server address",'class'=>"form-control"]) !!}
                                            <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
                                        </div>

                                        <div class="form-group">
                                            <label>Gmail Address</label>
                                            {!! Form::input('text','smtp_address',null, ['placeholder'=>"Gmail Address",'class'=>"form-control"]) !!}
                                            <!-- <input placeholder="Email" type="text" name="email" value="{{ old('email') }}" class="form-control"> -->
                                        </div>
                                       <div class="form-group">
                                            <label>Gmail Password</label>
                                            {!! Form::input('text','smtp_password',null, ['placeholder'=>"Gmail Password",'class'=>"form-control"]) !!}
                                            <!-- <input placeholder="Email" type="text" name="email" value="{{ old('email') }}" class="form-control"> -->
                                        </div>
                                        <div class="form-group">
                                            <label>Port</label>
                                            {!! Form::input('text','smtp_port',null, ['placeholder'=>"Port",'class'=>"form-control"]) !!}
                                            <!-- <input placeholder="Email" type="text" name="email" value="{{ old('email') }}" class="form-control"> -->
                                        </div>

                                      </form>

                                        <div class="form-group pull-right">
                                          <button  class="btn btn-md btn-success btn-block  " id="smtp_update">Update</button>
                                        </div>
                              </div>
                                  </div>
                            </div>

                            <div class="col-lg-4">
                              <div class="box box-solid">
                                      <div class="box-header with-border border-top ">
                                        <h3 class="box-title">Gmail API credentials</h3>
                                      </div><!-- /.box-header -->
                                        <div class="box-body">
                                        <div id="err_gmail_api"></div>
                                            <form id="gmail_api_credentials">
                                              <div class="form-group">
                                                  <label>Client ID</label>
                                                  {!! Form::input('text','gmail_auth_client_id',null, ['placeholder'=>"Client ID",'class'=>"form-control"]) !!}
                                                  <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
                                              </div>
                                              <div class="form-group">
                                                  <label>Client Secret</label>
                                                  {!! Form::input('text','gmail_auth_client_secret',null, ['placeholder'=>"Client Secret",'class'=>"form-control"]) !!}
                                                  <!-- <input placeholder="Email" type="text" name="email" value="{{ old('email') }}" class="form-control"> -->
                                              </div>


                                            </form>

                                               <div class="form-group pull-right">
                                                  <button class="btn btn-md btn-success btn-block" id="gmail_api_update">Update</button>
                                                  </div>
                                        </div>
                              </div>
                            </div><!-- /.tab-pane -->

                          </div><!-- /.tab-content -->
                        </div>

                          <div class="tab-pane" id="tab_date_time">

                                <form id="date_time">

                                <?php $date_format = ['dd/mm/yyyy|d/m/Y'=>'dd/mm/yyyy',
                                                      'mm/dd/yyyy|m/d/Y'=>'mm/dd/yyyy',
                                                      'dd-mm-yyyy|d-m-Y'=>'dd-mm-yyyy',
                                                      'mm-dd-yyyy|m-d-Y'=>'mm-dd-yyyy'];?>
                                  <div class="form-group col-lg-6">
                                      <label>Date Format</label>
                                     {!! Form::select('date_format', $date_format,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Date Format','id'=>'date_format'])!!}
                                      <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
                                  </div>
                                   <?php $time_format = ['hh:mm:ss'=>'hh:mm:ss',
                                                      'hh:mm:ss am/pm'=>'hh:mm:ss am/pm'];?>
                                  <div class="form-group col-lg-6">
                                      <label>Time Format</label>
                                      {!! Form::select('time_format', $time_format,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Time Format','id'=>'time_format'])!!}
                                  </div>
                                </form>

                                <div class="form-group pull-right">
                                      <button class="btn btn-md btn-success btn-block" id="date_time_update">Update</button>
                                </div>

                          </div>
                         <div class="clearfix"></div>
                      </div>
                  </div>
                </div>
    </div>
    </div>
    </div>
</section>

@include('admin.permissions.delete_modal_ajax_permission')
@include('crm::ticketstatus.delete_modal_ticket_status')
@include('crm::ticketstatus.ajax_create_ticket_status')
@include('admin.roles.ajax_create_role')
@include('admin.roles.ajax_edit_role')
@include('admin.roles.delete_modal_role')

@include('admin.setting.ajax_edit_user')

@include('admin.permissions.ajax_create_permission')
@include('admin.permissions.ajax_edit_permission')


@include('crm::crm.def_rate.ajax_create_rate')
@include('crm::crm.def_rate.delete_modal')


@include('crm::billing.ajax_create_billing')
@include('crm::billing.delete_modal')

@include('crm::ticketstatus.ajax_edit_ticket_status')

@include('crm::zoho.reset_modal_ajax')

@include('crm::service_item.delete_modal_service_item')
@include('crm::service_item.ajax_add')

@endsection
@section('script')
<script type="text/javascript" src="/js/form_elements.js"></script>
<!-- <script src="/js/jquery.dataTables.min.js"></script>  -->
<script src="/DataTables/datatables.min.js"></script>
{{--  <script src="/colorpicker/bootstrap-colorpicker.min.js"></script> --}}
<script src="/ckeditor/ckeditor.js"></script>
   <script src="/ckeditor/config.js"></script>
@endsection

@section('document.ready')
@parent
  $(".colorpicker").colorpicker({
           format:'hex'
        });

    $.get('/admin/role',function(response ) {
    $('#tab_role').html(response);
       },"html"
        );

    $.get('{{ URL::route("admin.tickets.status.list")}}',function(response) {
    $('#ticket_statuses').html(response);
       },"html"
        );

     $.get('/admin/permissions',function(response ) {
        $('#tab_permissions').html(response);
        $('#dt_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.permissions.list') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'display_name', name: 'display_name' },
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}

                ]
            });
$("#dt_table").css("width","100%");
        $('#dt_table_wrapper').addClass('padding-top-40');
          $('.pagination').addClass('pull-right');

            },"html"
        );



         $.get('{{URL::route("admin.crm.default_rates")}}',function(response ) {
            $('#tab_rates').html(response);
               },"html"
        );

        $.get('{{URL::route("admin.billing.index")}}',function(response ) {
            $('#tab_billing').html(response);
               },"html"
        );

  $.get('{{URL::route("admin.crm.zoho_credentials")}}',function(response ) {
            $('#tab_zoho').html(response);

            $( ".edit_zoho" ).click(function() {

               $.ajax({
                      url: "{{ URL::route('admin.crm.zoho_store')}}",
                      //headers: {'X-CSRF-TOKEN': token},
                      type: 'POST',
                      dataType: 'json',
                      data: $('#edit_zoho_form').serialize(),
                      success: function(response){
                      if(response.success)
                      {

                            $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_zoho');

                               $.get('{{URL::route("admin.crm.zoho_credentials")}}',function(response ) {
                                          $('#tab_zoho').html(response);
                                             },"html"
                                      );

                         alert_hide();
                      }

                      }

                  });
             });

               },"html"
        );
        CKEDITOR.replace( 'email_intro', {
            filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
            filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
        } );

CKEDITOR.replace( 'signature', {
            filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
            filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
        } );


        $.get('{{URL::route("admin.setting.get_email_data")}}',function(response ) {
                              //$('#tab_email_signature').html(response);
                              CKEDITOR.instances['signature'].setData(response.signature);
                              CKEDITOR.instances['email_intro'].setData(response.intro_email);
                                 },"json"
                          );


function email_update()
{
    for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();


   // data.signature = $('#signature_form').serialize();
   // data.intro = $('#email_intro_form').serialize();
    //console.log();
      // console.log(data1);
         $.ajax({
                url: "{{ URL::route('admin.setting.update_email_data')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: 'signature='+$('#signature_form').find('textarea').val()+'&intro='+$('#email_intro_form').find('textarea').val(),
                success: function(response){
                if(response.success)
                {

                      $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_email');

                         $.get('{{URL::route("admin.setting.get_email_data")}}',function(response ) {
                                    //$('#tab_email_signature').html(response);
                                    CKEDITOR.instances['signature'].setData(response.signature);
                                    CKEDITOR.instances['email_intro'].setData(response.intro_email);
                                       },"json"
                                );

                   alert_hide();
                }

                }

            });


}


          $.get('{{URL::route("admin.setting.get_date_time")}}',function(response ) {
                  //$('#tab_email_signature').html(response);

                  $('option[value="'+response.config_date+'"]', $('#date_format')).prop('selected', true);

                  $('#date_format').multiselect('refresh');

                  $('option[value="'+response.config_time+'"]', $('#time_format')).prop('selected', true);

                  $('#time_format').multiselect('refresh');

                     },"json"
              );


$('#date_time_update').click(function() {

 $.ajax({
                url: "{{ URL::route('admin.setting.update_date_time')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: $('#date_time').serialize(),
                success: function(response){
                if(response.success)
                {

                      $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_date_time');

                          $.get('{{URL::route("admin.setting.get_date_time")}}',function(response ) {

                            $('option[value="'+response.config_date+'"]', $('#date_format')).prop('selected', true);

                            $('#date_format').multiselect('refresh');

                            $('option[value="'+response.config_time+'"]', $('#time_format')).prop('selected', true);

                            $('#time_format').multiselect('refresh');

                               },"json"
                        );

                   alert_hide();
                }

                }

            });
});


$('#signature_update').click(function() {

 email_update();
});

$('#email_intro_update').click(function() {

 email_update();
});

   $('#smtp_update').click(function() {


   $.ajax({
          url: "{{ URL::route('admin.setting.smtp_store')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: $('#smtp_credentials').serialize(),
          success: function(response){
          if(response.success)
          {

                $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_gmail_integration');

                    $.get('{{URL::route("admin.setting.smtp")}}',function(response ) {
                //$('#tab_email_signature').html(response);
               $('#smtp_credentials').find('input[name="server_address"]').val(response.server_address);
               $('#smtp_credentials').find('input[name="smtp_address"]').val(response.gmail_address);
                $('#smtp_credentials').find('input[name="smtp_password"]').val(response.password);
                 $('#smtp_credentials').find('input[name="smtp_port"]').val(response.port);
                   },"json"
            );

             alert_hide();
          }

          }

      });

});


   $('#imap_update').click(function() {


   $.ajax({
          url: "{{ URL::route('admin.setting.imap_store')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: $('#imap_credentials').serialize(),
          success: function(response){
          if(response.success)
          {

                $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_gmail_integration');

                 $.get('{{URL::route("admin.setting.imap")}}',function(response ) {
                  //$('#tab_email_signature').html(response);
                 $('#imap_credentials').find('input[name="gmail_email"]').val(response.imap_email);
                 $('#imap_credentials').find('input[name="gmail_password"]').val(response.imap_password);
                     },"json"
              );

             alert_hide();
          }

          }

      });

});

          $.get('{{URL::route("admin.setting.imap")}}',function(response ) {
                  //$('#tab_email_signature').html(response);
                 $('#imap_credentials').find('input[name="gmail_email"]').val(response.imap_email);
                 $('#imap_credentials').find('input[name="gmail_password"]').val(response.imap_password);
                     },"json"
              );

            $.get('{{URL::route("admin.setting.smtp")}}',function(response ) {
                //$('#tab_email_signature').html(response);
               $('#smtp_credentials').find('input[name="server_address"]').val(response.server_address);
               $('#smtp_credentials').find('input[name="smtp_address"]').val(response.gmail_address);
                $('#smtp_credentials').find('input[name="smtp_password"]').val(response.password);
                 $('#smtp_credentials').find('input[name="smtp_port"]').val(response.port);
                   },"json"
            );
 $('#gmail_api_update').click(function() {
  $('#err_gmail_api').html('');
   $.ajax({
          url: "{{ URL::route('admin.setting.gmail_api_update')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: $('#gmail_api_credentials').serialize(),
          success: function(response){


        popupwindow(response.gmail.auth_url,'api',600,400);

          //console.log(response.gmail.auth_url);
          if(response.success)
          {

              wins
                $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_gmail_integration');



             alert_hide();
          }

          },
            error: function(data){
                var errors = data.responseJSON;
                //console.log(errors);
                var html_error = '<div  class="alert alert-danger"><ul>';
                $.each(errors, function (key, value)
                {
                    html_error +='<li>'+value+'</li>';
                })
                 html_error += "</ul></div>";
            $('#err_gmail_api').html(html_error);
            //$('#raise_msg_div').removeClass('alert-success').addClass('alert-danger').show();

            // Render the errors with js ...
            alert_hide();
          }
      });

});

function popupwindow(url, title, w, h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}

$('.multiselect').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        });



  $.get('{{URL::route("admin.service_item.index")}}',function(response ) {
    $('#tab_service_items').html(response);
       },"html"
        );
@endsection
@section('styles')
@parent
<!-- <link rel="stylesheet" href="/css/jquery.dataTables.min.css"/> -->
<link rel="stylesheet" href="/DataTables/datatables.min.css">
 <link href="/css/bootstrap-multiselect.css" rel="stylesheet" />
  {{-- <link rel="stylesheet" href="/colorpicker/bootstrap-colorpicker.min.css"/> --}}
   <link rel="stylesheet" href="/css/bootstrap3-wysihtml5.min.css"/>

<style>

.nav-tabs-custom {

    box-shadow: 0 1px 1px 1px rgba(0, 0, 0, 0.1) !important;

}
.bottom-border {
    border-bottom: 1px solid #f4f4f4;
}
.padding-bottom-8{
    padding-bottom: 8px;
}
.padding-top-10{
  padding-top: 10px;
}
.padding-top-40{
  padding-top: 40px;
}



    .top-border {
        border-top: 1px solid #f4f4f4;
    }
    .top-10px{
        top: 10px;
    }
    .bot_10px{
        margin-bottom: 10px;
    }

    .relative{
        position: relative;
    }
    .left-15px{
        left: 15px;
    }

   .border-top {
    border-top: 1px solid #f4f4f4;
}
</style>
@endsection
