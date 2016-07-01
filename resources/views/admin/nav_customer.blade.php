<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{{ URL::asset('img/avatar.png')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>{{session('customer_name')}} </p>
             
            </div>
          </div>
         
          <ul class="sidebar-menu">

            <li class="active treeview">
              <a href="/admin/dashboard">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa pull-right"></i>
              </a>
             
            </li>

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
