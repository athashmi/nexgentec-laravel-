@extends('admin.main')
@section('content')


<section class="content-header">
    <h1>
         Employees
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Employees
        </li>
    </ol>
</section>
<section class="content">
        <div class="row">

            <div class="col-xs-12">
                <a href=" {{ URL::route('admin.employee.create')}}" class="btn btn-primary pull-right"> Create Employee</a>
                <div class="clearfix"></div>

                <div class="box">
                    <div class="box-header">
                      <h3 class="box-title">Employee listing</h3>
                    {{--   <div class="box-tools">
                        <div class="input-group" style="width: 150px;">
                          <input type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Search">
                          <div class="input-group-btn">
                            <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                          </div>
                        </div>
                      </div> --}}
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>

                                    <th>Created at</th>
                                     <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                
                                
                                <tr>
                                    <td>{{ $employee->f_name }} {{ $employee->l_name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ date('d/m/Y',strtotime($employee->created_at)) }}</td>
                                    <td><?php if($employee->roles)
                                                {
                                                    foreach( $employee->roles as $role )
                                                    {
                                                    echo $role->display_name;
                                                    //dd($role->display_name);
                                                    }
                                                }?>
                                    </td>
                                    <td>
                                    
                                    <a href="{{ URL::route('admin.employee.edit',$employee->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                                    
                                     @if(Auth::user()->id != $employee->id)
                                     <button type="button" class="btn btn-danger btn-sm"
                                          data-toggle="modal" data-id="{{$employee->id}}" id="modaal" data-target="#modal-delete">
                                            <i class="fa fa-times-circle"></i>
                                            Delete
                                        </button>
                                     @endif  
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
@endsection