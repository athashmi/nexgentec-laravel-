@extends('admin.main')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
              
                  Post Leave
             
                </h1>
                
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-table"></i> Leaves
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        
        <div class="row">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            
                   {!! Form::open(['route' => 'employee.leave.store','method'=>'POST']) !!}
               
            <div class="col-lg-12">
                <div class="page-header">
                    <h3>Leave Details</h3>
                </div>
            </div>
           
            <div class="col-lg-12">
             
                   <input type="hidden" name="user_id" value="{{ Auth::user()->id}}">
                   <div class="form-group col-lg-5">
                        <label>Title</label>
                        {!! Form::input('text','title',null, ['placeholder'=>"Leave Title",'class'=>"form-control"]) !!}
                    </div>
                    <div class="form-group col-lg-5">
                        <label>Leave Type</label>
                        <?php 
                            $leave_type['annual'] = 'Annual';
                            $leave_type['sick'] = 'Sick';
                        ?>

                        {!! Form::select('type', $leave_type,'',['class'=>'form-control multiselect','placeholder' => 'Pick a leave type'])!!}
                            
                    </div>

                   <div class="form-group col-lg-5">
                        <label>Start Date</label>
                        {!! Form::input('text','start_date',null, ['placeholder'=>"Start Date",'class'=>"form-control datepicker",'data-date-format'=>"mm/dd/yyyy"]) !!}
                       
                    <span class="add-on"><i class="icon-calendar"></i></span>
                    </div>
                     <div class="form-group col-lg-5">
                        <label>End Date</label>
                        {!! Form::input('text','end_date',null, ['placeholder'=>"End Date",'class'=>"form-control datepicker",'data-date-format'=>"mm/dd/yyyy"]) !!}
                       
                    <span class="add-on"><i class="icon-calendar"></i></span>
                    </div>
                     
                    
                    <div class="form-group col-lg-10">
                        <label>Comments</label>
                         {!! Form::textarea('comments',null, ['placeholder'=>"Comments",'class'=>"form-control",'rows'=>2]) !!}
                            
                    </div>
                    <div class="form-group col-lg-5">
                     
                      <button type="submit" class="btn btn-lg btn-success btn-block">Add</button>
                    
                    </div>
                </div>
                
            </div>
             <hr>
            {!! Form::close() !!}
        </div>
        <!-- /.row -->
        
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>

@endsection
@section('script')
<script type="text/javascript" src="/js/form_elements.js"></script>
<script type="text/javascript">
$(document).ready(function() 
    {
        $('.multiselect').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: true,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        });
        
     $('.datepicker').datepicker();   
    });
</script>
@endsection