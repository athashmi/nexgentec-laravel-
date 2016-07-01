@extends('admin.main')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
               
                   {{$customer->name}}
                
                </h1>
                
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="#">Crm</a>
                    </li>
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="{{ URL::route('admin.crm.index')}}">Customers</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-table"></i> {{$customer->name}}
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        
        <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">26</div>
                                        <div>New Comments!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">12</div>
                                        <div>New Tasks!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">124</div>
                                        <div>New Orders!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">13</div>
                                        <div>Support Tickets!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
        </div>
   
        <div class="row">
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Info</h3>
                    </div>
                    <div class="panel-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item">
                            @if($customer->is_active)
                                 <span class="badge btn-success">active</span>
                            @else
                                <span class="badge">In active</span>
                            @endif 
                              {{--   <button class="btn btn-xs btn-success" type="button">Success</button> --}}
                               {{--  <i class="fa fa-fw fa-calendar"></i> --}} Status
                            </a>
                            <a href="#" class="list-group-item">
                                <span class="badge">{{ date('d/m/Y',strtotime($customer->customer_since)) }}</span>
                                {{-- <i class="fa fa-fw fa-comment"></i> --}} Customer Since
                            </a>
                            <a href="#" class="list-group-item">
                                <span class="badge">{{$customer->main_phone}}</span>
                                {{-- <i class="fa fa-fw fa-truck"></i> --}} Main Phone
                            </a>
                      
                        </div>
                       {{--  <div class="text-right">
                            <a href="#">View All Activity <i class="fa fa-arrow-circle-right"></i></a>
                        </div> --}}
                    </div>
                </div>
            </div>
             <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Locations</h3>
                    </div>
                    <div class="panel-body">
                        @foreach($customer->locations as $location)
                        <div class="col-lg-12">
                           <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">{{$location->location_name}}</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="list-group">
                                        <a href="#" class="list-group-item">
                                        @if($location->default)
                                             <span class="badge btn-success">Yes</span>
                                        @else
                                            <span class="badge">No</span>
                                        @endif 
                                          {{--   <button class="btn btn-xs btn-success" type="button">Success</button> --}}
                                           {{--  <i class="fa fa-fw fa-calendar"></i> --}} Default
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge">{{$location->country}}</span>
                                            {{-- <i class="fa fa-fw fa-comment"></i> --}} Country
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge">{{$location->city}}</span>
                                            {{-- <i class="fa fa-fw fa-comment"></i> --}} City
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge">{{$location->zip}}</span>
                                            {{-- <i class="fa fa-fw fa-comment"></i> --}} Zip
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge">{{$location->phone}}</span>
                                            {{-- <i class="fa fa-fw fa-comment"></i> --}} Phone
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge">{{$location->country}}</span>
                                            {{-- <i class="fa fa-fw fa-comment"></i> --}} Country
                                        </a>
                                  
                                    </div>
                                    
                             @foreach($location->contacts as $contact)
                            <div class="col-lg-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">{{$contact->title}}</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="list-group">
                                        <a href="#" class="list-group-item">
                                        @if($contact->is_poc)
                                             <span class="badge btn-success">Yes</span>
                                        @else
                                            <span class="badge">No</span>
                                        @endif 
                                          {{--   <button class="btn btn-xs btn-success" type="button">Success</button> --}}
                                           {{--  <i class="fa fa-fw fa-calendar"></i> --}} Is POC
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge">{{$contact->f_name}} {{$contact->l_name}}</span>
                                            {{-- <i class="fa fa-fw fa-comment"></i> --}} Name
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge">{{$contact->email}}</span>
                                            {{-- <i class="fa fa-fw fa-comment"></i> --}} Email
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge">{{$contact->mobile}}</span>
                                            {{-- <i class="fa fa-fw fa-comment"></i> --}} Mobile
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <span class="badge">{{$contact->phone}}</span>
                                            {{-- <i class="fa fa-fw fa-comment"></i> --}} Phone
                                        </a>
                                        
                                  
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        @endforeach

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
        </div>
       {{--  <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-danger"  id="raise_msg_div" style="display:none">
                    <ul id="raise_errors">
                    </ul>
                </div>
                <div class="page-header">
                    <h3>Raises</h3>
                </div>
                @include('employee::admin.raise_listing')
                <hr>
                @include('employee::admin.raise_form')
            </div>
        </div> --}}
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

@endsection
<style>
.badge.btn-success {
    background-color: #5cb85c;
}
</style>