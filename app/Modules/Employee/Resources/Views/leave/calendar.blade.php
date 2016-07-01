@extends('admin.main')
@section('content')

<section class="content-header">
    <h1>
         Calander
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Calander
        </li>
    </ol>
</section>
<section class="content">
    <div class="row">

        <div class="col-xs-12">

            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Google Calander</h3>
                </div>

                <div class=" box-body">
                     <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('script')
<script type="text/javascript" src="/js/calendar.js"></script>
<script type="text/javascript">
$(document).ready(function() 
    {
       $('#calendar').fullCalendar({
            defaultDate: '{{date("Y-m-d")}}',
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            events:<?php echo $events;?>,
            eventClick:function( event, jsEvent, view ) {
                console.log(event);
                $(this).attr('data-toggle', 'popover');
                $(this).attr('title', 'Detail');
                $(this).attr('data-content', event.title);
                $(this).attr('data-placement', 'top');
               
                //console.log();
                $('[data-toggle="popover"]').popover();   
                
             }
           }); 
    });
</script>
@endsection
@section('styles')
<link href="/css/fullcalendar.css" rel="stylesheet" />
<style>
.fc-row.fc-rigid {
    overflow: unset !important;
}
.fc-event {
    cursor: pointer;
}
</style>
@endsection