<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{{ URL::asset('img/avatar.png')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>{{Auth::user()->f_name.' '.Auth::user()->l_name}} </p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
         {{--  <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form> --}}
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">

            <li class="active treeview">
              <a href="/admin/dashboard">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa pull-right"></i>
              </a>
              {{-- <ul class="treeview-menu">
                <li><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                <li class="active"><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
              </ul> --}}
            </li>

          <li>
                <a href="{{ URL::route('admin.setting.all')}}"><i class="fa fa-gears"></i> <span>Settings</span></a>
          </li>

            {{-- <li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Roles & Permissions </span>
                <span class="fa fa-angle-left pull-right"></span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ URL::route('admin.role.index')}}"><i class="fa fa-circle-o"></i> Roles</a></li>
                <li><a href="{{ URL::route('admin.permissions.index')}}"><i class="fa fa-circle-o"></i> Permissions</a></li>

              </ul>
            </li> --}}


            <li>
                <a href="{{ URL::route('admin.employee.index')}}"><i class="fa fa-fw fa-user"></i> <span>Employees</span></a>
            </li>
              @if(Auth::user()->type == 'employee')
                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span> Leaves</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{ URL::route('employee.leave.index')}}"><i class="fa fa-circle-o"></i> List Leaves</a></li>
                    <li><a href="{{ URL::route('employee.leave.create')}}"><i class="fa fa-circle-o"></i> Post Leave</a></li>

                  </ul>
                </li>
              @endif


              @if(Auth::user()->hasRole('admin'))

                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Leaves</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{ URL::route('admin.leave.pending')}}"><i class="fa fa-circle-o"></i> Pending Leaves</a></li>
                    <li><a href="{{ URL::route('admin.leave.rejected')}}"><i class="fa fa-circle-o"></i> Rejected Leaves</a></li>
                    <li><a href="{{ URL::route('admin.leave.calendar')}}"><i class="fa fa-circle-o"></i> Calendar</a></li>

                  </ul>
                </li>
              @endif
              

               @if(Auth::user()->hasRole('admin'))

               {{--  <li class="treeview">
                  <a href="{{ URL::route('admin.crm.zoho_credentials')}}">
                    <i class="fa fa-pie-chart"></i>
                    <span>Zoho credentials</span>

                  </a>
                </li> --}}
              @endif
              @if(Auth::user()->hasRole('technician'))

                <li class="treeview">
                  <a href="{{ URL::route('admin.ticket.list_own')}}">
                    <i class="fa fa-pencil-square-o"></i>
                    <span>Tickets</span>

                  </a>
                </li>
              @endif
               @if(Auth::user()->hasRole('manager') || Auth::user()->hasRole('admin'))

                <li class="treeview">
                  <a href="#">
                    <i class="fa  fa-pencil-square-o"></i>
                    <span>Tickets</span>
                     <i class="fa fa-angle-left pull-right"></i>
                  </a>

                  <ul class="treeview-menu">
                    <li><a href="{{ URL::route('admin.ticket.index')}}"><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href="{{ URL::route('admin.ticket.create')}}"><i class="fa fa-circle-o"></i> Create</a></li>
                  </ul>
                </li>
              @endif
               <li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>CRM</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ URL::route('admin.crm.index')}}"><i class="fa fa-circle-o"></i> Customers</a></li>
                {{--<li><a href="{{ URL::route('admin.service_item.index')}}"><i class="fa fa-circle-o"></i> Service Items</a></li>
                 <li><a href="{{ URL::route('admin.billing.index')}}"><i class="fa fa-circle-o"></i>  Billing Periods</a></li>
                <li><a href="{{ URL::route('admin.crm.default_rates')}}"><i class="fa fa-circle-o"></i> Default Rates</a></li> --}}



              </ul>
            </li>

            <li class="treeview">
                  <a href="#">
                    <i class="fa  fa-database"></i>
                    <span>Assests</span>
                     <i class="fa fa-angle-left pull-right"></i>
                  </a>

                  <ul class="treeview-menu">
                    <li><a href="{{ URL::route('admin.assets.index')}}"><i class="fa fa-circle-o"></i> List</a></li>
                    <li><a href="{{ URL::route('admin.assets.create')}}"><i class="fa fa-circle-o"></i> Create</a></li>
                  </ul>
            </li>

            <li>
                  <a href="{{ URL::route('admin.knowledge.all')}}"><i class="fa fa-gears"></i> <span>Knowledge</span></a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
