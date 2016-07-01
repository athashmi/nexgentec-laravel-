@extends('admin.main')
@section('content')


 <section class="content-header">
    <h1>
         Service Items
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
         <li >
           <a href="{{ URL::route('admin.crm.index')}}"> <i class="fa fa-table"></i> Customers</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Service Items
        </li>
    </ol>
</section>



<section class="content">
    <div class="row">

        <div class="col-xs-12">
           <a href=" {{ URL::route('admin.service_item.create')}}" class="btn btn-primary pull-right"> Create New Service Item</a>
           <div class="clearfix"></div>
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title ">Service Items listing</h3>
                </div>

                 <div class="box-body table-responsive">
                      <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Created at</th>
                                 
                                <th>Actions</th>
                            </tr>
                        </thead>
                       <tbody>
                            @foreach ($service_items as $service_item)
                            
                            
                            <tr>
                                <td>{{ $service_item->title }}</td>
                                <td>{{ date('d/m/Y',strtotime($service_item->created_at)) }}</td>
                                <td>
                                       
                                 <button type="button" class="btn btn-danger btn-sm"
                                      data-toggle="modal" data-id="{{$service_item->id}}" id="modaal" data-target="#modal-delete">
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

@include('crm::delete_modal')
@endsection