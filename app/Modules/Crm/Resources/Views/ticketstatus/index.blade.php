@extends('admin.main')
@section('content')

 <section class="content-header">
    <h1>
         Ticket Status
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Ticket Status
        </li>
    </ol>
</section>
 
<section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div id="msg"></div>
               <a href=" {{ URL::route('admin.ticket.status.create')}}" class="btn btn-primary pull-right"> Create New Status</a>
             
             {{--   <a href="javascript:;"  onclick="import_emails()"  class="btn btn-primary pull-left"> <i class="fa fa-download"></i> Import Emails</a>
               <img id="load_img_z" src="{{asset('img/loader.gif')}}" style="display:none" /> --}}
              
               <div class="clearfix"></div>
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Ticket status listing</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table class="table table-hover" id="dt_table">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Color</th>
                        <th>Created on</th>
                        <th>Actions</th>
                      </tr>
                    </thead>

                    <tbody>
                            @foreach ($statuses as $status)
                            
                            
                            <tr>
                                <td>{{ $status->id }}</td>
                                <td>{{ $status->title }}</td>
                                
                                <td>
                                  <div class="color-palette-set">
                                    <div class="color-palette" style="background-color:{{ $status->color_code }}"><span>&nbsp;</span></div>
                                  </div>
                                </td>
                                <td>{{ date('d/m/Y',strtotime($status->created_at)) }}</td>
                                <td>
                                        
                                        <a href="{{ URL::route('admin.ticket.status.edit',$status->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                                        <!-- <button type="submit" class="btn btn-xs btn-danger">Delete</button> -->
                                        <button type="button" class="btn btn-danger btn-sm"
                                              data-toggle="modal" data-id="{{$status->id}}" id="modaal" data-target="#modal-delete-ticket-status">
                                        <i class="fa fa-times-circle"></i>
                                        Delete
                                      </button>
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
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
<script src="/js/jquery.dataTables.min.js"></script> 
  <script>
    $(function () {

      $('.pagination').addClass('pull-right');
    
    }); 

  </script>
@endsection
@section('styles')
  <link rel="stylesheet" href="/css/jquery.dataTables.min.css">
 <style>
 .bot_10px{
        margin-bottom: 10px;
    }

 </style>
@endsection