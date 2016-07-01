@extends('admin.main')
@section('content')

 <section class="content-header">
    <h1>
         Customers
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Customers
        </li>
    </ol>
</section>

<section class="content">
  <div class="row">
            <div class="col-xs-12">
            <div id="msg"></div>
               <a href=" {{ URL::route('admin.crm.create')}}" class="btn btn-primary pull-right"> Create New Customer</a>
                @if(Auth::user()->hasRole('admin'))
               <a href="javascript:;"  onclick="import_zoho()"  class="btn btn-primary pull-left"> <i class="fa fa-download"></i> Import Zoho Customers</a>
               <img id="load_img_z" src="{{asset('img/loader.gif')}}" style="display:none" />
               @endif
               <div class="clearfix"></div>
              <div class="box">
                <div class="box-header with-border bot_10px">
                  <h3 class="box-title">Customers listing</h3>
                {{--   <div class="box-tools">
                    <div class="input-group" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Search">
                      <div class="input-group-btn">
                        <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </div> --}}
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table class="table table-hover" id="dt_table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Phone</th>

                      <th>Created at</th>
                       <th>Contact</th>
                      <th>Locations</th>
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

 @include('crm::crm.delete_modal_ajax')
@endsection
@section('script')
 <!-- <script src="/js/jquery.dataTables.min.js"></script>  -->
 <script src="/DataTables/datatables.min.js"></script>
  <script>
    $(function() {
    $('#dt_table').DataTable({
        processing: true,
        serverSide: true,
      "bAutoWidth": false,
        ajax: '{!! route('admin.crm.data_index') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'main_phone', name: 'main_phone' },
            { data: 'created_at', name: 'created_at' },
            { data: 'contact', name: 'contact', orderable: false, searchable: false },
            { data: 'locations', name: 'locations' , orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}

        ]
    });
  });


    function export_zoho(id)
    {
      //console.log(id);
      $('#load_img').show();
       $.get(APP_URL+'/admin/crm/ajax_customer_export_zoho/'+id,function( response ) {
              //console.log(response);
              if(response.success)
              {
                $('#msg').html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');
                $('#load_img').hide();
              }

              if(response.error)
              {
                $('#msg').html('<div  class="alert alert-danger"><ul><li>'+response.error_msg+'</li></ul></div>');
                $('#load_img').hide();
              }
                //$('#service_items_table').html(response.html_contents);
                },"json"
            );

       alert_hide();
    }




    function import_zoho()
    {
      //console.log(id);
      $('#load_img_z').show();
       $.get(APP_URL+'/admin/crm/zoho_get_contacts',function( response ) {
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
      setTimeout("location.reload(true);",10000);
    }

    $(function () {

      $('.pagination').addClass('pull-right');
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
