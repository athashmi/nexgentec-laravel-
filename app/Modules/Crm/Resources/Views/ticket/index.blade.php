@extends('admin.main')
@section('content')

 <section class="content-header">
    <h1>
         Tickets
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Tickets
        </li>
    </ol>
</section>

<section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div id="msg"></div>
               <a href=" {{ URL::route('admin.ticket.create')}}" class="btn btn-primary pull-right"> Create New Ticket</a>

              {{--  <a href="javascript:;"  onclick="import_emails()"  class="btn btn-primary pull-left"> <i class="fa fa-download"></i> Import Emails</a>
               <img id="load_img_z" src="{{asset('img/loader.gif')}}" style="display:none" />  --}}

               <div class="clearfix"></div>
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Tickets listing</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table class="table table-hover" id="dt_table">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Created By</th>
                        <th>Customer info</th>
                        <th>Created on</th>
                        <th>Status</th>
                        <th>Assigned to</th>
                        <th>Priority</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                  </table>
                  <div class="col-xs-12">
                  </div>

                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
</section>

 @include('crm::ticket.delete_modal')
@endsection
@section('script')
<!-- <script src="/js/jquery.dataTables.min.js"></script>  -->
 <script src="/DataTables/datatables.min.js"></script>
  <script>


     function import_emails()
    {
      //console.log(id);
      $('#load_img_z').show();
       $.get(APP_URL+'/admin/crm/ticket/getEmails',function( response ) {
              //console.log(response);
              if(response.success)
              {
                $('#msg').html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');
                $('#load_img_z').hide();
              }

              if(response.error)
              {
                $('#msg').html('<div  class="alert alert-danger"><ul><li>'+response.error_msg+'</li></ul></div>');
                $('#load_img_z').hide();
              }
                //$('#service_items_table').html(response.html_contents);
                },"json"
            );

       alert_hide();
      //setTimeout("location.reload(true);",10000);
    }
    $(function () {

      $('.pagination').addClass('pull-right');


      $('#dt_table').DataTable({
        processing: true,
        serverSide: true,
       @if((session('cust_id')!='') && (session('customer_name')!=''))
         ajax: '{!! route('admin.ticket.data_index_by_cust',session('cust_id')) !!}',
       @else
        ajax: '{!! route('admin.ticket.data_index') !!}',

        @endif
        columns: [

            { data: 'id', name: 'id' },
            { data: 'title', name: 'title' },
            { data: 'created_by', name: 'created_by' , orderable: false, searchable: false},
            { data: 'customer_info', name: 'customer_info' , orderable: false, searchable: false},
            { data: 'created_at', name: 'created_at' },
            { data: 'status', name: 'ticket_status_id',searchable: false},
            { data: 'assigned_to', name: 'assigned_to' , orderable: false, searchable: false},
            { data: 'priority', name: 'priority' },
            {data: 'action', name: 'action', orderable: false, searchable: false}

        ]
    });
    });

  </script>
@endsection
@section('styles')
  <!-- <link rel="stylesheet" href="/css/jquery.dataTables.min.css"> -->
  <link rel="stylesheet" href="/DataTables/datatables.min.css">
 <style>
 .bot_10px{
        margin-bottom: 10px;
    }

 </style>
@endsection
