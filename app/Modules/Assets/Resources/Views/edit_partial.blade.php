
<form id="edit_asset">
<div class="col-lg-12">
  <div class="form-group col-lg-6">
       <label>Name</label>
       {!! Form::input('text','name',$asset->name, ['placeholder'=>"Name",'class'=>"form-control"]) !!}
       <input type="hidden" name="asset_id" value="{{$asset->id}}">
   </div>

     <div class="form-group col-lg-6">
       <label>Customer</label>

      {!! Form::select('customer', $customers,$asset->customer->id,['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','onChange'=>'load_service_items(this.value)', 'id'=>'customers_select'])!!}
     </div>

     <div class="form-group col-lg-6">
       <label>Location</label>
      <?php //$locations = [];?>
      {!! Form::select('location', $locations,$asset->location->id,['class'=>'form-control multiselect','placeholder' => 'Pick a Location', 'id'=>'locations'])!!}
     </div>

            <?php $asset_types = ['network'=>'Network',
                                   'gateway' => 'Gateway',
                                   'pbx'=>'PBX',
                                   'server'=>'Server'];?>
            <div class="form-group col-lg-6">
             <label>Asset Type</label>

            {!! Form::select('asset_type', $asset_types,$asset->asset_type,['class'=>'form-control multiselect','placeholder' => 'Pick Asset Type','onChange'=>'cahnge_asset_view(this.value)', 'id'=>'asset_type'])!!}
           </div>



<div class="clearfix"></div>



  			<div class="box-header with-border top-border bot_10px">
                      <h3 class="box-title">Asset Detail</h3>
                    </div>

                    <div class="box-body" >
                    <div id="target_div">
                    </div>
                    </div>
                    <div class="clearfix"></div>
</div>

</form>

{{-- =================================================================================================--}}
	@if($asset->asset_type=='network')
	   	<div id="network_div" style="display:none;">
	        <div class="form-group col-lg-4">
	            <label>Manufacture</label>
	            {!! Form::input('text','manufacture',$asset->manufacture, ['placeholder'=>"Manufacture",'class'=>"form-control"]) !!}
	        </div>

	        <div class="form-group col-lg-4">
	            <label>OS</label>
	            {!! Form::input('text','os',$asset->os, ['placeholder'=>"OS",'class'=>"form-control"]) !!}
	        </div>
	        <div class="form-group col-lg-4">
	            <label>Model</label>
	            {!! Form::input('text','model',$asset->model, ['placeholder'=>"Model",'class'=>"form-control"]) !!}
	        </div>
	        <div class="form-group col-lg-4">
	            <label>Ip Address</label>
	            {!! Form::input('text','ip_address',$asset->ip_address, ['placeholder'=>"IP Address",'class'=>"form-control"]) !!}
	        </div>
	        <div class="form-group col-lg-4">
	            <label>User Name</label>
	            {!! Form::input('text','user_name',$asset->user_name, ['placeholder'=>"User Name",'class'=>"form-control"]) !!}
	        </div>
	        <div class="form-group col-lg-4">
	            <label>Password</label>
	            {!! Form::input('text','password',$asset->password, ['placeholder'=>"Password",'class'=>"form-control"]) !!}
	        </div>
	        <div class="form-group col-lg-4">
	            <label>Is Static?</label>
	            <?php $is_static = ['1'=>'Yes',
	                                '0' =>'No'];?>
	            {!! Form::select('is_static', $is_static,$asset->is_static,['class'=>'form-control','placeholder' => 'Is Static?', 'id'=>'is_static','onChange'=>'show_static_type(this.value)'])!!}
	        </div>

	        <div class="form-group col-lg-4"   style=" @if($asset->is_static==0) {{'display:none'}}" @endif id="static_type">
	            <div class="form-group col-lg-6">
	                <div class="radio top-18px">
	                    <label>
	                        <input type="radio" name="static_type" id="dhcp" value="dhcp" @if($asset->static_type=='dhcp') {{'checked="checked"'}}
	                        @endif>


	                            <span>DHCP</span>

	                    </label>
	                </div>
	            </div>

	            <div class="form-group col-lg-6">
	                <div class="radio top-18px">
	                    <label>
	                        <input type="radio" name="static_type" id="local" value="local"  @if($asset->static_type=='local') {{'checked="checked"'}}
	                        @endif >


	                        <span>Local</span>

	                    </label>
	                </div>
	            </div>

	        </div>

	        <div class="form-group col-lg-12">
	            <label>Notes</label>
	            {!! Form::textarea('notes',$asset->notes, ['placeholder'=>"Notes",'class'=>"form-control textarea",'id'=>'network_notes','rows'=>10]) !!}
	        </div>
	    </div>
	@endif
               
	@if($asset->asset_type=='gateway')
	   <div id="gateway_div" style="display:none;">
	        <div class="form-group col-lg-4">
	            <label>Manufacture</label>
	            {!! Form::input('text','manufacture',$asset->manufacture, ['placeholder'=>"Manufacture",'class'=>"form-control"]) !!}
	        </div>

	        <div class="form-group col-lg-4">
	            <label>Model</label>
	            {!! Form::input('text','model',$asset->model, ['placeholder'=>"Model",'class'=>"form-control"]) !!}
	        </div>
	        <div class="form-group col-lg-4">
	            <label>LAN Ip Address</label>
	            {!! Form::input('text','lan_ip_address',$asset->lan_ip_address, ['placeholder'=>"LAN IP Address",'class'=>"form-control"]) !!}
	        </div>
	        <div class="form-group col-lg-4">
	            <label>WAN Ip Address</label>
	            {!! Form::input('text','wan_ip_address',$asset->wan_ip_address, ['placeholder'=>"WAN IP Address",'class'=>"form-control"]) !!}
	        </div>
	         <div class="form-group col-lg-4">
	            <label>SSID</label>
	            {!! Form::input('text','ssid',$asset->ssid, ['placeholder'=>"SSID",'class'=>"form-control"]) !!}
	        </div>
	        <div class="form-group col-lg-4">
	            <label>Password</label>
	            {!! Form::input('text','password',$asset->password, ['placeholder'=>"Password",'class'=>"form-control"]) !!}
	        </div>
	        <div class="form-group col-lg-12">
	            <label>Notes</label>
	            {!! Form::textarea('notes',$asset->notes, ['placeholder'=>"Notes",'class'=>"form-control textarea",'id'=>'gateway_notes','rows'=>10]) !!}
	        </div>
	  </div>
	@endif
	@if($asset->asset_type=='pbx')
	    <div id="pbx_div" style="display:none;">
            <div class="form-group col-lg-4">
                <label>Manufacture</label>
                {!! Form::input('text','manufacture',$asset->manufacture, ['placeholder'=>"Manufacture",'class'=>"form-control"]) !!}
            </div>
             <div class="form-group col-lg-4">
                <label>OS</label>
                {!! Form::input('text','os',$asset->os, ['placeholder'=>"OS",'class'=>"form-control"]) !!}
            </div>
            <div class="form-group col-lg-4">
                <label>Host name</label>
                {!! Form::input('text','host_name',$asset->host_name, ['placeholder'=>"Host Name",'class'=>"form-control"]) !!}
            </div>
            <div class="form-group col-lg-4">
                <label>Admin GUI Address</label>
                {!! Form::input('text','admin_gui_address',$asset->admin_gui_address, ['placeholder'=>"Admin GUI Address",'class'=>"form-control"]) !!}
            </div>
            <div class="form-group col-lg-4">
                <label>Ip Address</label>
                {!! Form::input('text','ip_address',$asset->ip_address, ['placeholder'=>"IP Address",'class'=>"form-control"]) !!}
            </div>
             <div class="form-group col-lg-4">
                <label>User Name</label>
                {!! Form::input('text','user_name',$asset->user_name, ['placeholder'=>"User Name",'class'=>"form-control"]) !!}
            </div>
            <div class="form-group col-lg-4">
                <label>Password</label>
                {!! Form::input('text','password',$asset->password, ['placeholder'=>"Password",'class'=>"form-control"]) !!}
            </div>
            <div class="form-group col-lg-4">
                <label>Hosted/Onsite</label>
                {!! Form::input('text','hosted',$asset->hosted, ['placeholder'=>"Hosted/Onsite",'class'=>"form-control"]) !!}
            </div>
	    </div>
	@endif
	@if($asset->asset_type=='server')
 

        <div id="server_div" style="display:none;">
           <div class="form-group col-lg-4">
                <label>Type</label>
                <?php $server_type = ['physical'=>'Physical',
                                    'virtual' =>'Virtual'];?>
                {!! Form::select('server_type', $server_type,$asset->server_type,['class'=>'form-control','placeholder' => 'Server Type', 'id'=>'server_type','onChange'=>'cahnge_server_type(this.value)'])!!}
            </div>

             <div class="form-group col-lg-4" id="virtual_types" style=" @if($asset->server_type=='physical'){{'display:none'}} @endif">
                <label>Virtual Type?</label>
                <?php $virtual_type = ['vmware'=>'VMWare',
                                    'proxmox' =>'Proxmox',
                                    'hyperv' =>'HyperV',
                                    'other' =>'Other'];?>
                {!! Form::select('virtual_type', $virtual_type,$asset->virtual_server_type,['class'=>'form-control','placeholder' => 'Virtual Server Type', 'id'=>'virtual_server_type'])!!}
            </div>


            <div class="form-group col-lg-4">
                <label>Ip Address</label>
                {!! Form::input('text','ip_address',$asset->ip_address, ['placeholder'=>"IP Address",'class'=>"form-control"]) !!}
            </div>

             <div class="form-group col-lg-4">
                <label>Serial Number</label>
                {!! Form::input('text','serial_number',$asset->serial_number, ['placeholder'=>"Serial Number",'class'=>"form-control"]) !!}
            </div>
             <div class="form-group col-lg-3">
                <label>Host Name</label>
                {!! Form::input('text','host_name',$asset->host_name, ['placeholder'=>"Host Name",'class'=>"form-control"]) !!}
            </div>
           <div class="form-group col-lg-9">
            <label>Roles</label>
             <?php $roles = ['vmware'=>'VMWare',
                              'active_directory' =>'Active Directory',
                              'primary_domain_controller' =>'Primary Domain Controller',
                              'secondary_domai_controller' =>'Secondary Domain Controller',
                              'rdp_server' =>' RDP Server',
                              'Application_server' =>'Application Server',
                              'emr_server' =>'EMR Server',
                              'dhcp_server' =>'DHCP Server',
                              'dns_erver' =>'DNS Server'];

                              $roles_selected = json_decode($asset->roles);?>

                 {!! Form::select('roles[]', $roles,$roles_selected,['class'=>'select2','multiple'=>'','style'=>"width: 100%;"])!!}

            </div>


            <div class="form-group col-lg-12">
                <label>Notes</label>
                {!! Form::textarea('notes',$asset->notes, ['placeholder'=>"Notes",'class'=>"form-control textarea",'id'=>'server_notes','rows'=>10]) !!}
            </div>
  		</div>
  	@endif
{{-- =================================================================================================--}}



<!-- <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>
<p>
  <span class="label label-danger">UI Design</span>
  <span class="label label-success">Coding</span>
  <span class="label label-info">Javascript</span>
  <span class="label label-warning">PHP</span>
  <span class="label label-primary">Node.js</span>
</p> -->
  <div class="clearfix"></div>
