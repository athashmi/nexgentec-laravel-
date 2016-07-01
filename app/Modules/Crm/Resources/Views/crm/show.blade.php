@extends('admin.main')
@section('content')

<section class="content-header">
    <h1 id="h1_title">
           {{$customer->name}}
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i>  <a href="/admin/crm">Customers</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> {{$customer->name}}
        </li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-4">
        <div id="info_msg"></div>
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Info</h3>
              <a  class="btn btn-default btn-sm pull-right" data-id="{{$customer->id}}" href="javascript:;" data-target="#modal-edit-customer-info"   data-toggle="modal"><i class="fa fa-pencil"></i></a>
            </div><!-- /.box-header -->
            <div class="box-body" id="info_bdy">
                <h3 class="profile-username text-center">Customer Scince</h3>
                <p class="text-muted text-center">{{ date('d/m/Y',strtotime($customer->customer_since)) }}</p>
                <ul class="list-group list-group-unbordered" >
                    <li class="list-group-item">
                      <b>Email Domain</b> <a class="pull-right">{{ $customer->email_domain}}</a>
                    </li>
                    <li class="list-group-item">
                      <b>Main Phone</b> <a class="pull-right">{{$customer->main_phone}}</a>
                    </li>
                    <li class="list-group-item">
                      <b>Active ? </b> <a class="pull-right">@if($customer->is_active)
                                                                 <span class="badge btn-success">Yes</span>
                                                            @else
                                                                <span class="badge">No</span>
                                                            @endif 
                                    </a>
                    </li>
                    <li class="list-group-item">
                      <b>Taxable ? </b> <a class="pull-right">@if($customer->is_taxable)
                                                                 <span class="badge btn-success">Yes</span>
                                                            @else
                                                                <span class="badge">No</span>
                                                            @endif 
                                    </a>
                    </li>
                  </ul>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
        <div class="col-md-2 no-gutter">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Tickets</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                 <h3 class="profile-username text-center">Open Tickets</h3>
                <p class="text-muted text-center"><b>0</b></p>

                  <h3 class="profile-username text-center">Open Tickets</h3>
                <p class="text-muted text-center"><b>0</b></p>

                  <h3 class="profile-username text-center">Open Tickets</h3>
                <p class="text-muted text-center"><b>0</b></p>


            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>


        <div class="col-md-6">
            <div class="col-md-12 no-gutter">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Locations</h3>
                   <a  class="btn btn-default btn-sm pull-right" data-id="{{$customer->id}}" href="javascript:;" data-target="#modal-add-new-location"   data-toggle="modal"><i class="fa fa-plus"></i> Add Location</a>
                </div><!-- /.box-header -->
                <div class="box-body" >
                    <table class="table tbl_font">
                        <tbody id="locations_tbl">
                         @foreach($customer->locations as $location)
                            <tr id="location_{{$location->id}}">
                                <td width="50">{{$location->location_name}}</td>
                                <td style="width: 150px; text-align:left;">{{$location->address}}</td>
                                
                                 <td style="width: 100px"> <i class="fa fa-globe"></i>  {{$location->country}}</td>
                                <td style="width: 100px"> <i class="fa fa-phone"></i>  {{$location->phone}}</td>


                                    <td width="22">  <a class="pull-left" href="javascript:;" data-target="#modal-edit-location" id="modaal" data-id="{{$location->id}}"
                                                                 data-toggle="modal"><i class="fa fa-pencil"></i></a>
                                       <a class="pull-right" href="javascript:;" data-target="#modal-delete-loc" id="modaal" data-custid="{{$customer->id}}" data-id="{{$location->id}}" data-toggle="modal"> <i class="fa fa-times-circle"></i></a>                          
                                    </td>
                              {{-- <td>
                                <div class="progress progress-xs">
                                  <div style="width: 55%" class="progress-bar progress-bar-danger"></div>
                                </div>
                              </td>
                              <td><span class="badge bg-red">55%</span></td> --}}
                            </tr>
                        @endforeach
                      </tbody></table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>

            <div class="col-md-12 no-gutter" id="contacts">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Contacts</h3>

                   <a  class="btn btn-default btn-sm pull-right" data-custid="{{$customer->id}}" href="javascript:;" data-target="#modal-add-new-contact"   data-toggle="modal"><i class="fa fa-plus"></i> Add Contact</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                   <table class="table tbl_font">
                        <tbody id="loc_contacts">
                         @foreach($customer->locations as $location)
                         @foreach($location->contacts as $contact)
                            <tr id="loc_contacts_{{$contact->id}}">
                                <td width="50">{{$contact->f_name}} {{$contact->l_name}}</td>
                                <td width="245" style="text-align:left;"> <i class="fa fa-envelope"></i> {{$contact->email}}</td>
                                  <td style="width: 150; text-align:left;"><i class="fa fa-phone"></i>  {{$contact->phone}} <br/>
                                  <i class="fa fa-mobile"></i>  {{$contact->mobile}}</td>
                               
                                <td style="width: 75">  {{$location->location_name}}</td>
                                <td style="width:22"><a  class="pull-left" href="javascript:;" data-target="#modal-edit-contact"  data-id="{{$contact->id}}" data-custid="{{$location->customer_id}}" data-toggle="modal"><i class="fa fa-pencil"></i></a>
                                <a class="pull-right" href="javascript:;"  data-id="{{$contact->id}}" data-successid="loc_contacts_{{$location->id}}" data-locid="{{$location->id}}" data-custid="{{$customer->id}}"  data-target="#modal-delete-cntct" data-toggle="modal" ><i class="fa fa-times-circle"></i></a></td>
                              {{-- <td>
                                <div class="progress progress-xs">
                                  <div style="width: 55%" class="progress-bar progress-bar-danger"></div>
                                </div>
                              </td>
                              <td><span class="badge bg-red">55%</span></td> --}}
                            </tr>
                        @endforeach
                         @endforeach
                      </tbody></table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12" >
            <div class="box" id="service_items_panel">
            <div class="box-header">
              <h3 class="box-title">Service Items</h3>
              <div class="box-tools">
               <div style="width: 150px;" class="input-group">
               <a  class="btn btn-default btn-sm pull-right" data-custid="{{$customer->id}}" href="javascript:;" data-target="#modal-add-new-service-item"   data-toggle="modal"><i class="fa fa-plus"></i> Add New Service Item</a>
               
                  
                </div>
              </div>
            </div><!-- /.box-header -->

            <div class="box-body table-responsive ">
              <table class="table table-hover">
                <tbody id="service_items_table">
                <tr>
                 <th>Title</th>
                    <th>Type</th>

                    <th>Start Date</th>
                     
                    <th>End Date</th>
                    <th>Action</th>
                </tr>
                 @foreach($customer->service_items as $service_item)
                <tr id="service_item_data_{{$service_item->id}}">
                 <td>{{$service_item->title}}</td>
                    <td>{{$service_item->service_type->title}}</td>
                    <td>{{ date($global_date,strtotime($service_item->start_date)) }}</td>
                    <td>{{ date($global_date,strtotime($service_item->end_date)) }}</td>
                    
                    
                    <td>
                    <a  class="btn btn-default btn-sm " data-srvcitemid="{{$service_item->id}}" href="javascript:;" data-target="#modal-add-new-rate"   data-toggle="modal"><i class="fa fa-plus"></i> Add New Rate</a>
                        <a class="btn btn-sm btn-primary" href="javascript:;" data-target="#modal-edit-service-item" id="modaal" data-id="{{$service_item->id}}"  data-servicetid="{{$service_item->service_type_id}}" 
                         data-toggle="modal"><i class="fa fa-pencil"></i> Edit</a>
                        <button data-target="#modal-delete-sitem" id="modaal" data-id="{{$service_item->id}}" data-toggle="modal" data-custid="{{$customer->id}}" class="btn btn-danger btn-sm" type="button">
                        <i class="fa fa-times-circle"></i>
                        Delete
                        </button>
                    </td>
                </tr>
                @endforeach
              </tbody></table>
            </div><!-- /.box-body -->
          </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12" >
            <div class="box" id="rates_panel">
            <div class="box-header">
              <h3 class="box-title">Rates</h3>
            
            </div><!-- /.box-header -->

            <div class="box-body table-responsive ">
              <table class="table table-hover">
                <tbody id="rates_table"><tr>
                    <th>Title</th>

                    <th>Active</th>
                    <th>Service item</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
                 @foreach($customer->service_items as $service_item)
                   @foreach($service_item->rates as $rate)
                    <tr id="service_item_rates_{{$service_item->id}}">
                        <td>{{$rate->title}}</td>
                        <td> @if($rate->status)
                                 <span class="badge btn-success">Active</span>
                            @else
                                <span class="badge">No</span>
                            @endif 
                        </td>
                        <td>{{$service_item->service_type->title}}</td>
                        <td>$ {{$rate->amount}}</td>
                        
                        
                        <td>
                            <a  class="btn btn-primary btn-sm" href="javascript:;" data-target="#modal-edit-rate"  data-id="{{$rate->id}}" data-srcitmid="{{$service_item->id}}" data-toggle="modal"><i class="fa fa-pencil"></i> Edit</a>
                            <a href="javascript:;" class="btn btn-sm btn-danger" data-target="#modal-delete-rate"  data-id="{{$rate->id}}" data-sid="{{$service_item->id}}" data-toggle="modal"><i class="fa fa-times-circle"></i> Delete</a>
                        </td>
                    </tr>
                @endforeach
                @endforeach
              </tbody></table>
            </div><!-- /.box-body -->
          </div>
        </div>
    </div>

<div class="row">
  <div class="col-lg-12" >
    <div class="box" id="rates_panel">
      <div class="box-header">
        <h3 class="box-title">Expenses And Income</h3>
      
      </div><!-- /.box-header -->

      <div class="box-body table-responsive " >
        <div id="container" style="width:100%;margin: 0 auto">
        </div>
      </div>
    </div>
  </div>
</div>


</section>




<!-- /#page-wrapper -->
@include('crm::crm.location.ajax_edit_location_modal')
@include('crm::crm.contact.ajax_edit_contact_modal')
@include('crm::crm.info.ajax_edit_customer_info_modal')

@include('crm::crm.location.ajax_add_location_modal')
@include('crm::crm.contact.ajax_add_contact_modal')

@include('crm::crm.service_item.ajax_edit_service_item_modal')
@include('crm::crm.rate.ajax_edit_rate_modal')

@include('crm::crm.rate.ajax_add_new_rate_modal')

@include('crm::crm.service_item.ajax_add_new_service_item_modal')

@include('crm::crm.contact.delete_modal_ajax')

@include('crm::crm.location.delete_modal_ajax')

@include('crm::crm.rate.delete_modal_ajax')
@include('crm::crm.service_item.delete_modal_ajax')

@endsection
@section('styles')
<link href="/css/bootstrap-multiselect.css" rel="stylesheet" />
<link href="/css/datepicker.css" rel="stylesheet" />
<style>
.badge.btn-success {
    background-color: #5cb85c;
}
.padding_l_r_20{
padding: 0 20px;
}

h3.panel-title.pull-left {
    width: 65%;
}

@media (min-width: 992px) {
  .modal-dialog {
    width: 930px !important;
    }
}
.no-gutter{
    padding-left: 0px;
    padding-right: 0px;
}

.tbl_font {
    font-size: 14px;
    font-weight: 100;
}
</style>

@endsection
@section('script')
<script type="text/javascript" src="/js/form_elements.js"></script>
<script type="text/javascript" src="/js/highcharts.js"></script>
<script type="text/javascript" src="/js/jquery.inputmask.js"></script>

<script type="text/javascript">
    $(document).ready(function() 
    {

      $('.multiselect').multiselect({
                  enableFiltering: true,
                  includeSelectAllOption: true,
                  maxHeight: 400,
                  dropUp: false,
                  buttonClass: 'form-control',
                  onChange: function(option, checked, select) {
                      //alert($('#multiselect').val());
                  }
                });


      $.get(APP_URL+'/admin/crm/zoho_get_expenses/{{$customer->zohoid}}',function( response ) {


        //console.log(response);

        $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Expenses And Income'
        },
        subtitle: {
            text: 'Source: Zoho Invoice'
        },
        xAxis: {
            categories: [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Amount'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Expense',
            data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

        }, {
            name: 'Income',
            data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

        }]
        });

      });


       
       });
      </script>

@endsection