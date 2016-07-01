@extends('admin.main')
@section('content')

 <section class="content-header">
    <h1>
         Assets
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Assets
        </li>
    </ol>
</section>

<section class="content">
  <div class="row">
            <div class="col-xs-12">
            <div id="msg"></div>
               <a href=" {{ URL::route('admin.assets.create')}}" class="btn btn-primary pull-right"> Create New Asset</a>

               <div class="clearfix"></div>
              <div class="box">
                <div class="box-header with-border bot_10px">
                  <h3 class="box-title">Assets listing</h3>

                </div><!-- /.box-header -->
                <div class="box-body ">


                  <div class="nav-tabs-custom">
                      <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_network" data-toggle="tab">Network</a></li>
                        <li><a href="#tab_gateway" data-toggle="tab">Gateway</a></li>
                        <li><a href="#tab_pbx" data-toggle="tab">PBX</a></li>
                        <li><a href="#tab_server" data-toggle="tab">Server</a></li>

                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active table-responsive" id="tab_network">
                          <table class="table table-hover" id="network_dt_table">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Name</th>
                              <th>Manufacture</th>
                              <th>Customer</th>
                              <th>Created at</th>
                               <th>Os</th>
                              <th>Model</th>
                              <th>Actions</th>
                            </tr>

                            </thead>


                          </table>
                        </div><!-- /.tab-pane -->
                        <div class="tab-pane table-responsive" id="tab_gateway">
                          <table class="table table-hover" id="gateway_dt_table">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Name</th>
                              <th>Manufacture</th>
                              <th>Customer</th>
                              <th>Created at</th>

                              <th>Model</th>
                              <th>Actions</th>
                            </tr>

                            </thead>


                          </table>
                        </div><!-- /.tab-pane -->

                        <div class="tab-pane table-responsive" id="tab_pbx">
                          <table class="table table-hover" id="pbx_dt_table">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Name</th>
                              <th>Manufacture</th>
                              <th>Customer</th>
                              <th>OS</th>
                              <th>Created at</th>

                              <th>Hostname</th>
                              <th>Actions</th>
                            </tr>

                            </thead>


                          </table>
                        </div><!-- /.tab-pane -->

                        <div class="tab-pane table-responsive" id="tab_server">
                          <table class="table table-hover" id="server_dt_table">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Name</th>
                              <th>Customer</th>
                              <th>Server type</th>
                              <th>Serial #</th>
                              <th>Created at</th>

                              <th>Host name</th>
                              <th>Actions</th>
                            </tr>

                            </thead>


                          </table>
                        </div><!-- /.tab-pane -->
                      </div><!-- /.tab-content -->
                </div>




                </div><!-- /.box-body -->

              </div><!-- /.box -->
            </div>
          </div>
</section>

 @include('crm::crm.delete_modal_ajax')
 @include('assets::show')
  @include('assets::edit')
@endsection
@section('script')
@parent

<script type="text/javascript" src="/js/form_elements.js"></script>

  <script src="/ckeditor/ckeditor.js"></script>
   <script src="/ckeditor/config.js"></script>
    <script src="/js/select2.full.min.js"></script>

 <script src="/DataTables/datatables.min.js"></script>
  <script>

  @include('assets::ajax_functions')
    $(function() {

    $('#network_dt_table').DataTable({
        processing: true,
        serverSide: true,
        //responsive: true,
        "bAutoWidth": false,
        @if((session('cust_id')!='') && (session('customer_name')!=''))
          ajax: '{!! route('admin.assets.network_index_by_cust',session('cust_id')) !!}',
        @else 
           ajax: '{!! route('admin.assets.network_index') !!}',
        @endif
        
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'manufacture', name: 'manufacture' },
            { data: 'customer', name: 'customer',orderable: false, searchable: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'os', name: 'os' },
            { data: 'model', name: 'model' },
            {data: 'action', name: 'action', orderable: false, searchable: false}

        ]
    });
    $('#gateway_dt_table').DataTable({
        processing: true,
        serverSide: true,
        "bAutoWidth": false,
        @if((session('cust_id')!='') && (session('customer_name')!=''))
          ajax: '{!! route('admin.assets.gateway_index_by_cust',session('cust_id')) !!}',
        @else {
           ajax: '{!! route('admin.assets.gateway_index') !!}',
        @endif
        
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'manufacture', name: 'manufacture' },
            { data: 'customer', name: 'customer',orderable: false, searchable: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'model', name: 'model' },
            { data: 'action', name: 'action', orderable: false, searchable: false}

        ]
    });


    $('#pbx_dt_table').DataTable({
        processing: true,
        serverSide: true,
         "bAutoWidth": false,
         @if((session('cust_id')!='') && (session('customer_name')!=''))
             ajax: '{!! route('admin.assets.pbx_index_by_cust',session('cust_id')) !!}',         
        @else
             ajax: '{!! route('admin.assets.pbx_index') !!}',
        @endif
       
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'manufacture', name: 'manufacture' },
            { data: 'customer', name: 'customer',orderable: false, searchable: false },
            { data: 'os', name: 'os' },
            { data: 'created_at', name: 'created_at' },
            { data: 'host_name', name: 'host_name' },

            {data: 'action', name: 'action', orderable: false, searchable: false}

        ]
    });

    $('#server_dt_table').DataTable({
        processing: true,
        serverSide: true,
        "bAutoWidth": false,
        @if((session('cust_id')!='') && (session('customer_name')!=''))
          ajax: '{!! route('admin.assets.server_index_by_cust',session('cust_id')) !!}',
        @else
            ajax: '{!! route('admin.assets.server_index') !!}',
        @endif
        
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },

            { data: 'customer', name: 'customer',orderable: false, searchable: false },
            { data: 'server_type', name: 'server_type' },
            { data: 'serial_number', name: 'serial_number' },
            { data: 'created_at', name: 'created_at' },
            { data: 'host_name', name: 'host_name' },

            {data: 'action', name: 'action', orderable: false, searchable: false}

        ]
    });



  });


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
    .table-responsive {

        //overflow-x: hidden;
    }
 </style>

 <link href="/css/bootstrap-multiselect.css" rel="stylesheet" />
  <link rel="stylesheet" href="/css/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="/css/select2.min.css">

<style>
    .top-border {
        border-top: 1px solid #f4f4f4;
    }
    .top-10px{
        top: 10px;
    }
    .top-18px{
        top: 18px;
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

</style>
@endsection
