@extends('admin.main')
@section('content')

<section class="content-header">
    <h1>
       @if(!empty($status))
           Edit status
        @else
          Add New status
        @endif
    </h1>
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
           
             @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">statuss listing</h3>
                
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="col-lg-6">
                          @if(!empty($status))
                               {!! Form::model($status, ['route' => ['admin.ticket.status.update', $status->id], 'method'=>'PUT']) !!}
                            @else
                               {!! Form::open(['route' => 'admin.ticket.status.store','method'=>'POST']) !!}
                            @endif
                            
                               
                                <div class="form-group">
                                    <label>Title</label>
                                    {!! Form::input('text','title',null, ['placeholder'=>"title",'class'=>"form-control"]) !!}
                                    <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
                                </div>
                                
                                <div class="form-group">
                                    <label>Color</label>
                                    <div class="input-group colorpicker">
                                      {!! Form::input('text','color_code',null, ['placeholder'=>"color code",'class'=>"form-control"]) !!}
                                     <div class="input-group-addon"><i></i></div>
                                    </div>
                                </div>
                               

                               
                            
                                 @if(!empty($status))
                                  <button type="submit" class="btn btn-lg btn-success btn-block">Update</button>
                                 @else
                                  <button type="submit" class="btn btn-lg btn-success btn-block">Add</button>
                                 @endif
                                
                           
                            {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>        
 
@endsection
@section('script')
<script type="text/javascript" src="/js/form_elements.js"></script>
 <script src="/colorpicker/bootstrap-colorpicker.min.js"></script>
<script type="text/javascript">
$(document).ready(function() 
    {
         var color ='';
        <?php if(!empty($status)){ ?>
            color = '{{ $status->color_code}}';

       <?php }?>
        $(".colorpicker").colorpicker({
            color:color,
            format:'hex',
        });
        $('#multiselect').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        });
         
        
    });
</script>
@endsection
@section('styles')
    <link href="/css/bootstrap-multiselect.css" rel="stylesheet" />
    <link rel="stylesheet" href="/colorpicker/bootstrap-colorpicker.min.css"/>
   
@endsection