<div class="col-lg-12">
  <div class="col-lg-4">
        <strong><i class="fa fa-user margin-r-5"></i>  Customer</strong>
        <p class="text-muted">
            <button class="btn bg-gray-active  btn-sm" type="button">
              <i class="fa fa-user"></i>
                  <span>{{$asset->customer->name}}</span>
              </button>

        </p>
  </div>
  <div class="col-lg-4">
    <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
    <p class="text-muted">@if($asset->location)
        <button class="btn bg-gray-active  btn-sm" type="button">
                  <span>  {{$asset->location->location_name}}</span>
        </button>
        @endif</p>
  </div>

  <div class="col-lg-4">
    <strong> Type</strong>
    <p class="text-muted">{{$asset->asset_type}}
                            </p>
  </div>


<div class="clearfix"></div>
<hr>
</div>


@if($asset->asset_type=='network')
  <div class="col-lg-12">
    <div class="col-lg-4">
      <strong> OS</strong>
      <p class="text-muted">{{$asset->os}}</p>
    </div>


    <div class="col-lg-4">
      <strong><i class="fa fa-building-o margin-r-5"></i> Manufacture</strong>
      <p class="text-muted">{{$asset->manufacture}}
                              </p>
    </div>

    <div class="col-lg-4">
          <strong> Model</strong>
          <p class="text-muted">{{$asset->model}}</p>

    </div>

    <div class="clearfix"></div>
    <hr>

  </div>

    <div class="col-lg-12">

          <div class="col-lg-4">
                <strong> Ip Address</strong>
                <p class="text-muted">{{$asset->ip_address}}</p>
          </div>

          <div class="col-lg-4">
            <strong> User Name</strong>
            <p class="text-muted">{{$asset->user_name}}</p>
          </div>


        <div class="col-lg-4">
          <strong><i class="fa fa-key margin-r-5"></i> Password</strong>
          <p class="text-muted">{{$asset->password}}</p>
        </div>

        <div class="clearfix"></div>
        <hr>

    </div>

    <div class="col-lg-12">
          <div class="col-lg-3">
            <strong> Is Static?</strong>
            <p class="text-muted">@if($asset->is_static==0)<button class="btn bg-danger  btn-sm" type="button">
                                <span>No</span>
                                </button>
                                @elseif($asset->is_static==1)
                                <button class="btn bg-primary  btn-sm" type="button">
                                                      <span>Yes</span>
                                                      </button>
                                @endif
            </p>

          </div>
        @if($asset->is_static==1)
          <div class="col-lg-3">
            <strong><i class="fa fa-map-marker margin-r-5"></i> Static type</strong>
            <p class="text-muted">{{$asset->static_type}}</p>

          </div>
        @endif
        <div class="clearfix"></div>
        <hr>

    </div>

      <div class="col-lg-12">

        <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

        <p>{{$asset->notes}}</p>

        <div class="clearfix"></div>


    </div>

@endif



@if($asset->asset_type=='gateway')
  <div class="col-lg-12">



    <div class="col-lg-4">
      <strong><i class="fa fa-building-o margin-r-5"></i> Manufacture</strong>
      <p class="text-muted">{{$asset->manufacture}}
                              </p>
    </div>

    <div class="col-lg-4">
          <strong> Model</strong>
          <p class="text-muted">{{$asset->model}}</p>

    </div>


    <div class="col-lg-4">
      <strong> LAN Ip Address</strong>
      <p class="text-muted">{{$asset->lan_ip_address}}</p>
    </div>
    <div class="clearfix"></div>
    <hr>

  </div>

    <div class="col-lg-12">

          <div class="col-lg-4">
                <strong> WAN Ip Address</strong>
                <p class="text-muted">{{$asset->wan_ip_address}}</p>
          </div>

          <div class="col-lg-4">
            <strong> SSID</strong>
            <p class="text-muted">{{$asset->ssid}}</p>
          </div>


        <div class="col-lg-4">
          <strong><i class="fa fa-key margin-r-5"></i> Password</strong>
          <p class="text-muted">{{$asset->password}}</p>
        </div>

        <div class="clearfix"></div>
        <hr>

    </div>



      <div class="col-lg-12">

        <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

        <p>{{$asset->notes}}</p>

        <div class="clearfix"></div>


    </div>

@endif


@if($asset->asset_type=='pbx')
  <div class="col-lg-12">

    <div class="col-lg-4">
      <strong><i class="fa fa-building-o margin-r-5"></i> Manufacture</strong>
      <p class="text-muted">{{$asset->manufacture}}
                              </p>
    </div>

    <div class="col-lg-4">
          <strong> OS</strong>
          <p class="text-muted">{{$asset->os}}</p>

    </div>


    <div class="col-lg-4">
      <strong>Ip Address</strong>
      <p class="text-muted">{{$asset->ip_address}}</p>
    </div>
    <div class="clearfix"></div>
    <hr>

  </div>

    <div class="col-lg-12">

          <div class="col-lg-4">
                <strong> Host Name</strong>
                <p class="text-muted">{{$asset->host_name}}</p>
          </div>

          <div class="col-lg-4">
            <strong>Admin GUI Address</strong>
            <p class="text-muted">{{$asset->admin_gui_address}}</p>
          </div>




        <div class="clearfix"></div>
        <hr>

    </div>
    <div class="col-lg-12">

          <div class="col-lg-4">
                <strong> User Name</strong>
                <p class="text-muted">{{$asset->user_name}}</p>
          </div>




        <div class="col-lg-4">
          <strong><i class="fa fa-key margin-r-5"></i> Password</strong>
          <p class="text-muted">{{$asset->password}}</p>
        </div>
        <div class="col-lg-4">
          <strong>Hosted/Onsite</strong>
          <p class="text-muted">{{$asset->hosted}}</p>
        </div>

        <div class="clearfix"></div>

    </div>



@endif

@if($asset->asset_type=='server')
  <div class="col-lg-12">

    <div class="col-lg-4">
      <strong> Server Type</strong>
      <p class="text-muted">{{$asset->server_type}}
                              </p>
    </div>
    @if($asset->server_type=='virtual')
    <div class="col-lg-4">
          <strong> Virtual Type</strong>
          <p class="text-muted">{{$asset->virtual_server_type}}</p>

    </div>
    @endif

    <div class="col-lg-4">
      <strong>Ip Address</strong>
      <p class="text-muted">{{$asset->ip_address}}</p>
    </div>
    <div class="clearfix"></div>
    <hr>

  </div>

    <div class="col-lg-12">

          <div class="col-lg-4">
                <strong> Host Name</strong>
                <p class="text-muted">{{$asset->host_name}}</p>
          </div>

          <div class="col-lg-4">
            <strong> Serial Number</strong>
            <p class="text-muted">{{$asset->serial_number}}</p>
          </div>




        <div class="clearfix"></div>
        <hr>

    </div>
    <div class="col-lg-12">

      <strong><i class="fa fa-users margin-r-5"></i> Roles</strong>
      <p>
        <?php $roles = json_decode($asset->roles);?>
        @foreach ($roles as $role)
          <span class="label label-success">{{$role}}</span>
        @endforeach

      </p>

      <div class="clearfix"></div>
      <hr>

  </div>

  <div class="col-lg-12">

    <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

    <p>{{$asset->notes}}</p>

    <div class="clearfix"></div>


  </div>


@endif

<!-- <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>
<p>
  <span class="label label-danger">UI Design</span>
  <span class="label label-success">Coding</span>
  <span class="label label-info">Javascript</span>
  <span class="label label-warning">PHP</span>
  <span class="label label-primary">Node.js</span>
</p> -->
  <div class="clearfix"></div>
