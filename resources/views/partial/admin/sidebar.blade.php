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

                        @can('order_access')
                        <!-- Order-->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/orders')) is_active @endif" href="{{ route('orders.index') }}" aria-expanded="false">
                                <i class="mr-3 fas fa-tachometer-alt fa-fw" aria-hidden="true"></i>
                                <span class="hide-menu">Orders</span>
                            </a>
                        </li>
                        @endcan

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


        <!-- Time Slot management Start -->


        {{--
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
    --}}  

    <!-- Category Management -->
    {{--
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
--}}  

<!-- Category management EOC -->

{{--
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

--}}  

<!-- Multiple Banner Management -->

@canany(['banner_multiple_access','banner_multiple_create'])
<li class="sidebar-item">
    <a class="sidebar-link has-arrow waves-effect waves-dark selected" href="javascript:void(0)" aria-expanded="false">
        <i class="mr-3 mdi mdi-account" aria-hidden="true"></i>
        <span class="hide-menu">Multiple Banner</span>
    </a>
    <ul aria-expanded="false" class="collapse first-level
    @if(request()->is('admin/banner-multiples/trash') || request()->is('admin/banner-multiples/*')) in @endif
    @if(request()->is('admin/banner-multiples') || request()->is('admin/banner-multiples/*')) in @endif
    @if(request()->is('admin/banner-multiples') || request()->is('admin/banner-multiples/*')) in @endif
    ">
    @can('timeslot_access')
    <li class="sidebar-item">
        <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/banner-multiples')) is_active @endif" href="{{ route('banner-multiples.index') }}" aria-expanded="false">
            <i class="mr-3 mdi mdi-account-multiple" aria-hidden="true"></i>
            <span class="hide-menu">Multiple Banner List</span>
        </a>
    </li>
    @endcan
    @can('banner_multiple_create')
    <li class="sidebar-item">
        <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/banner-multiples/create')) is_active @endif" href="{{ route('banner-multiples.create') }}" aria-expanded="false">
            <i class="mr-3 mdi mdi-star" aria-hidden="false"></i>
            <span class="hide-menu">Add Multiple</span>
        </a>
    </li>
    @endcan
    @can('banner_multiple_access')
    <li class="sidebar-item">
        <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/banner-multiple/trash')) is_active @endif" href="{{ route('banner-multiples.trash') }}" aria-expanded="false">
            <i class="mr-3 mdi mdi-key" aria-hidden="false"></i>
            <span class="hide-menu">Trash Multiple Banner</span>
        </a>
    </li>
    @endcan
</ul>
</li>
@endcanany

<!-- Multiple Banner management EOC -->


<!-- Single Banner Management -->

@canany(['banner_single_access'])
<li class="sidebar-item">
    <a class="sidebar-link has-arrow waves-effect waves-dark selected" href="javascript:void(0)" aria-expanded="false">
        <i class="mr-3 mdi mdi-account" aria-hidden="true"></i>
        <span class="hide-menu">Single Banner</span>
    </a>
    <ul aria-expanded="false" class="collapse first-level
    @if(request()->is('admin/banner-singles/*')) in @endif
    @if(request()->is('admin/banner-singles') || request()->is('admin/banner-singles/*')) in @endif
    @if(request()->is('admin/banner-singles') || request()->is('admin/banner-singles/*')) in @endif
    ">
    @can('banner_single_access')
    <li class="sidebar-item">
        <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/banner-singles')) is_active @endif" href="{{ route('banner-singles.index') }}" aria-expanded="false">
            <i class="mr-3 mdi mdi-account-multiple" aria-hidden="true"></i>
            <span class="hide-menu">Banner</span>
        </a>
    </li>
    @endcan   
</ul>
</li>
@endcanany

<!-- Single Banner management EOC -->




<!-- Contact Us Management -->

@canany(['banner_single_access'])
<li class="sidebar-item">
    <a class="sidebar-link has-arrow waves-effect waves-dark selected" href="javascript:void(0)" aria-expanded="false">
        <i class="mr-3 mdi mdi-account" aria-hidden="true"></i>
        <span class="hide-menu">Contact Us</span>
    </a>
    <ul aria-expanded="false" class="collapse first-level
    @if(request()->is('admin/contact-us/*')) in @endif
    @if(request()->is('admin/contact-us/index')) in @endif">
    @can('banner_single_access')
    <li class="sidebar-item">
        <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/contact-us/index')) is_active @endif" href="{{ route('contact-us.index') }}" aria-expanded="false">
            <i class="mr-3 mdi mdi-account-multiple" aria-hidden="true"></i>
            <span class="hide-menu">Contact us list</span>
        </a>
    </li>
    @endcan   
</ul>
</li>
@endcanany

<!-- Contact Us management EOC -->




</ul>

</nav>
<!-- End Sidebar navigation -->
</div>
<!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
