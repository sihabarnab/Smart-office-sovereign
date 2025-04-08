   <!-- Sidebar -->
   <div class="sidebar">

       <!-- Sidebar Menu -->
       <nav class="mt-2">
           <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu"
               data-accordion="false">
               <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
               <li class="nav-item">
                   <a href="{{ route('inventory') }}" class="nav-link">
                       <i class="nav-icon fas fa-tachometer-alt"></i>
                       <p>
                           Dashboard
                       </p>
                   </a>
               </li>

               @php
                   $txt_emp_id = Auth::user()->emp_id;
                   // echo $txt_emp_id;

                   $data_pro_main_mnue = DB::table('pro_main_mnu')
                       ->where('module_id', 4)
                       ->Where('valid', '1')
                       ->orderBy('main_mnu_recordListingID', 'asc')
                       ->get();

               @endphp

               @foreach ($data_pro_main_mnue as $key => $row_data_pro_main_mnue)
                   @php
                       $m_main_mnu_id = $row_data_pro_main_mnue->main_mnu_id;

                       $data_pro_sub_mnu_for_users = DB::table('pro_sub_mnu_for_users')
                           ->where('main_mnu_id', $m_main_mnu_id)
                           ->Where('emp_id', $txt_emp_id)
                           ->where('module_id', 4)
                           ->where('valid', '1')
                           ->groupBy('main_mnu_id')
                           ->first();
                       $txt_main_mnu_title = $row_data_pro_main_mnue->main_mnu_title;
                   @endphp
                   @if ($data_pro_sub_mnu_for_users == null)
                   @else
                       @php
                           $sub_menus = DB::table('pro_sub_mnu')
                               ->where('module_id', 4)
                               ->where('main_mnu_id', $m_main_mnu_id)
                               ->Where('valid', '1')
                               ->orderBy('menu_sl', 'asc')
                               ->get();

                       @endphp
                       <li class="nav-item  <?php foreach ($sub_menus as $sub_menu) {
                           if (request()->routeIs($sub_menu->sub_mnu_link)) {
                               echo ' menu-open ';
                           }
                       } ?> ">
                           <a href="#" class="nav-link <?php foreach ($sub_menus as $sub_menu) {
                               if (request()->routeIs($sub_menu->sub_mnu_link)) {
                                   echo ' active ';
                               }
                           } ?>">

                               <i class="nav-icon far fa-plus-square"></i>
                               <p>{{ $txt_main_mnu_title }}
                                   <i class="fas fa-angle-left right"></i>
                               </p>
                           </a>


                           @foreach ($sub_menus as $key => $sub_menu)
                               @php
                                   $m_sub_mnu_id = $sub_menu->sub_mnu_id;
                                   $data_pro_sub_mnu = DB::table('pro_sub_mnu_for_users')
                                       ->Where('emp_id', $txt_emp_id)
                                       ->where('sub_mnu_id', $m_sub_mnu_id)
                                       ->Where('valid', '1')
                                       ->first();

                                   $txt_sub_mnu_title = $sub_menu->sub_mnu_title;
                                   $txt_sub_mnu_link = $sub_menu->sub_mnu_link;
                               @endphp

                               <ul class="nav-treeview nav-compact">
                                   @if ($data_pro_sub_mnu == null)
                                   @else
                                       <li class="nav-item">
                                           <a href="{{ route($txt_sub_mnu_link) }}"
                                               class="nav-link {{ request()->routeIs($txt_sub_mnu_link) ? 'active' : '' }}">
                                               <i class="far fa-circle nav-icon"></i>
                                               <p>{{ $txt_sub_mnu_title }}</p>
                                           </a>
                                       </li>
                                   @endif
                               </ul>
                           @endforeach

                       </li>
                   @endif
               @endforeach


           </ul>
       </nav>&nbsp;
       <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
