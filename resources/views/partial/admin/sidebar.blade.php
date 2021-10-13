        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- <li class="nav-devider"></li> -->
                        <!-- <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span class="hide-menu">Dashboard</span></li> -->

                        @can('admin_panel_access')
                        <!-- dashboard-->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin')) is_active @endif" href="{{ route('home') }}" aria-expanded="false">
                                <i class="mr-3 fas fa-tachometer-alt fa-fw" aria-hidden="true"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        @endcan


                                    <!-- Time Slot Management -->
            @canany(['timeslot_access','timeslot_create'])
            <li class="sidebar-item">
                <a class="sidebar-link has-arrow waves-effect waves-dark selected" href="javascript:void(0)" aria-expanded="false">
                    <i class="mr-3 mdi mdi-account" aria-hidden="true"></i>
                    <span class="hide-menu">Orders </span>
                </a>
                <ul aria-expanded="false" class="collapse first-level                
                @if(request()->is('admin/orders') || request()->is('admin/orders/*')) in @endif
                @if(request()->is('admin/orders') || request()->is('admin/orders/*')) in @endif
                ">
                @can('timeslot_access')
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/orders/index')) is_active @endif" href="{{ route('orders.index') }}" aria-expanded="false">
                        <i class="mr-3 mdi mdi-account-multiple" aria-hidden="true"></i>
                        <span class="hide-menu">Order List</span>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany

        <!-- Time Slot management EOC -->



                        @canany(['users_access','roles_access','permissions_access'])
                        <li class="sidebar-item">

                            <a class="sidebar-link has-arrow waves-effect waves-dark selected" href="javascript:void(0)" aria-expanded="false">

                                <i class="mr-3 mdi mdi-account" aria-hidden="true"></i>
                                <span class="hide-menu">Users Management</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level
                            @if(request()->is('admin/users') || request()->is('admin/users/*')) in @endif
                            @if(request()->is('admin/roles') || request()->is('admin/roles/*')) in @endif
                            @if(request()->is('admin/permissions') || request()->is('admin/permissions/*')) in @endif
                            ">
                            @can('users_access')
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/users') || request()->is('admin/users/*')) is_active @endif" href="{{ route('users.index') }}" aria-expanded="false">
                                    <i class="mr-3 mdi mdi-account-multiple" aria-hidden="true"></i>
                                    <span class="hide-menu">Users</span>
                                </a>
                            </li>
                            @endcan

                            @can('technician_access')
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/technicians') || request()->is('admin/technicians/*')) is_active @endif" href="{{ route('technicians.index') }}" aria-expanded="false">
                                    <i class="mr-3 mdi mdi-account-multiple" aria-hidden="true"></i>
                                    <span class="hide-menu">Technicians</span>
                                </a>
                            </li>
                            @endcan

                            @can('roles_access')
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/roles') || request()->is('admin/roles/*')) is_active @endif" href="{{ route('roles.index') }}" aria-expanded="false">
                                    <i class="mr-3 mdi mdi-star" aria-hidden="false"></i>
                                    <span class="hide-menu">Roles</span>
                                </a>
                            </li>
                            @endcan

                            @can('permissions_access')
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/permissions') || request()->is('admin/permissions/*')) is_active @endif" href="{{ route('permissions.index') }}" aria-expanded="false">
                                    <i class="mr-3 mdi mdi-key" aria-hidden="false"></i>
                                    <span class="hide-menu">Permissions</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany
                    


                    <!-- Category Management -->
                    @canany(['category_access','category_create'])
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark selected" href="javascript:void(0)" aria-expanded="false">
                            <i class="mr-3 mdi mdi-account" aria-hidden="true"></i>
                            <span class="hide-menu">Category Master</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level
                        @if(request()->is('admin/categories/trash') || request()->is('admin/categories/*')) in @endif
                        @if(request()->is('admin/categories') || request()->is('admin/categories/*')) in @endif
                        @if(request()->is('admin/categories') || request()->is('admin/categories/*')) in @endif
                        ">
                        @can('category_access')
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/categories/index')) is_active @endif" href="{{ route('categories.index') }}" aria-expanded="false">
                                <i class="mr-3 mdi mdi-account-multiple" aria-hidden="true"></i>
                                <span class="hide-menu">Category List</span>
                            </a>
                        </li>
                        @endcan
                        @can('category_create')
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/categories/create')) is_active @endif" href="{{ route('categories.create') }}" aria-expanded="false">
                                <i class="mr-3 mdi mdi-star" aria-hidden="false"></i>
                                <span class="hide-menu">Add Category</span>
                            </a>
                        </li>
                        @endcan
                        @can('category_access')
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/categories/trash')) is_active @endif" href="{{ route('categories.trash') }}" aria-expanded="false">
                                <i class="mr-3 mdi mdi-key" aria-hidden="false"></i>
                                <span class="hide-menu">Trash Category</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                <!-- Category management EOC -->


                <!-- Service Management -->
                @canany(['service_access','service_create'])
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark selected" href="javascript:void(0)" aria-expanded="false">
                        <i class="mr-3 mdi mdi-account" aria-hidden="true"></i>
                        <span class="hide-menu">Service Master</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level
                    @if(request()->is('admin/services/trash') || request()->is('admin/services/*')) in @endif
                    @if(request()->is('admin/services') || request()->is('admin/services/*')) in @endif
                    @if(request()->is('admin/services') || request()->is('admin/services/*')) in @endif
                    ">
                    @can('service_access')
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/services/list')) is_active @endif" href="{{ route('services.index') }}" aria-expanded="false">
                            <i class="mr-3 mdi mdi-account-multiple" aria-hidden="true"></i>
                            <span class="hide-menu">Service List</span>
                        </a>
                    </li>
                    @endcan
                    @can('service_create')
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/services/create')) is_active @endif" href="{{ route('services.create') }}" aria-expanded="false">
                            <i class="mr-3 mdi mdi-star" aria-hidden="false"></i>
                            <span class="hide-menu">Add Service</span>
                        </a>
                    </li>
                    @endcan
                    @can('service_access')
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/services/trash')) is_active @endif" href="{{ route('services.trash') }}" aria-expanded="false">
                            <i class="mr-3 mdi mdi-key" aria-hidden="false"></i>
                            <span class="hide-menu">Trash Service</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            <!-- Service management EOC -->



            <!-- Time Slot Management -->
            @canany(['timeslot_access','timeslot_create'])
            <li class="sidebar-item">
                <a class="sidebar-link has-arrow waves-effect waves-dark selected" href="javascript:void(0)" aria-expanded="false">
                    <i class="mr-3 mdi mdi-account" aria-hidden="true"></i>
                    <span class="hide-menu">Time Slot Master</span>
                </a>
                <ul aria-expanded="false" class="collapse first-level
                @if(request()->is('admin/timeslots/trash') || request()->is('admin/timeslots/*')) in @endif
                @if(request()->is('admin/timeslots') || request()->is('admin/timeslots/*')) in @endif
                @if(request()->is('admin/timeslots') || request()->is('admin/timeslots/*')) in @endif
                ">
                @can('timeslot_access')
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/timeslots')) is_active @endif" href="{{ route('timeslots.index') }}" aria-expanded="false">
                        <i class="mr-3 mdi mdi-account-multiple" aria-hidden="true"></i>
                        <span class="hide-menu">Time Slot List</span>
                    </a>
                </li>
                @endcan
                @can('timeslot_create')
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/timeslots/create')) is_active @endif" href="{{ route('timeslots.create') }}" aria-expanded="false">
                        <i class="mr-3 mdi mdi-star" aria-hidden="false"></i>
                        <span class="hide-menu">Add Time Slot</span>
                    </a>
                </li>
                @endcan
                @can('service_access')
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/timeslot/trash')) is_active @endif" href="{{ route('timeslots.trash') }}" aria-expanded="false">
                        <i class="mr-3 mdi mdi-key" aria-hidden="false"></i>
                        <span class="hide-menu">Trash Time Slot</span>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany

        <!-- Time Slot management EOC -->



        {{-- <li class="sidebar-item selected"> <a class="sidebar-link has-arrow waves-effect waves-dark active" href="javascript:void(0)" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home feather-icon"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg><span class="hide-menu">Dashboard <span class="badge badge-pill badge-success">5</span></span></a>
            <ul aria-expanded="false" class="collapse first-level in">
                <li class="sidebar-item"><a href="index.html" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Modern Dashboard  </span></a></li>
                <li class="sidebar-item active"><a href="index2.html" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Awesome Dashboard </span></a></li>
                <li class="sidebar-item"><a href="index3.html" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Classy Dashboard </span></a></li>
                <li class="sidebar-item"><a href="index4.html" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Analytical Dashboard </span></a></li>
                <li class="sidebar-item"><a href="index5.html" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Minimal Dashboard </span></a></li>
            </ul>
        </li> --}}

    </ul>

</nav>
<!-- End Sidebar navigation -->
</div>
<!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
