@extends('admin.main')
@section('content')

<section class="content-header">
    <h1>
         Add Default Rate
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
            <i class="fa fa-table"></i>Default Rate
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

           <div class="clearfix"></div>
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Add Rate</h3>
                </div>

                 <div class="box-body">

                   {!! Form::open(['route' => 'admin.crm.default_rate.store','method'=>'POST','id'=>'form_validate']) !!}
               
                    <div class="col-lg-12"> 

                        <div class="col-lg-3"> 
                         &nbsp;
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Title</label>
                            {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}
                        </div>
                      </div>
                       <div class="col-lg-12"> 

                        <div class="col-lg-3"> 
                         &nbsp;
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Amount</label>
                            {!! Form::input('text','amount',null, ['placeholder'=>"0.00",'class'=>"form-control"]) !!}
                        </div>
                      </div>
                    <div class="col-lg-12"> 

                        <div class="col-lg-3"> 
                         &nbsp;
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group col-lg-5">
                                <button type="submit" class="btn btn-lg btn-success btn-block">Add</button>
                            </div>
                        </div>
                    </div>
               
                    
                  
           
            {!! Form::close() !!}
                 </div>
            </div>
        </div>
    </div>
</section>


@endsection
