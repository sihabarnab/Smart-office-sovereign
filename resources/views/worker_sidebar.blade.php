   <!-- Sidebar -->
   <div class="sidebar">
       <!-- Sidebar Menu -->
       <nav class="mt-2">
           <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu"
               data-accordion="false">
               <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

               <li class="nav-item" style="display: none;">
                   <a data-widget="pushmenu" class="nav-link">
                        <i class="float-right fas fa-window-close"></i>
                   </a>
               </li>

               <li class="nav-item">
                   <a href="{{ route('worker') }}" class="nav-link">
                       <i class="nav-icon fas fa-tachometer-alt"></i>
                       <p>
                           Dashboard
                       </p>
                   </a>
               </li>

               <li class="nav-item">
                   <a href="{{ route('endOfTheDay') }}" class="nav-link">
                    <i class="nav-icon fas fa-hourglass-end"></i>
                       <p>
                        Finish Day
                       </p>
                   </a>
               </li>

               @php
                   $txt_emp_id = Auth::user()->emp_id;
                   // echo $txt_emp_id;

                   $data_pro_main_mnue = DB::table('pro_main_mnu')
                       ->where('module_id', 11)
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
                           ->where('module_id', 11)
                           ->where('valid', '1')
                           ->groupBy('main_mnu_id')
                           ->first();
                       $txt_main_mnu_title = $row_data_pro_main_mnue->main_mnu_title;
                   @endphp
                   @if ($data_pro_sub_mnu_for_users == null)
                   @else
                       <li class="nav-item">
                           <a href="#" class="nav-link">

                               <i class="nav-icon far fa-plus-square"></i>
                               <p>{{ $txt_main_mnu_title }}
                                   <i class="fas fa-angle-left right"></i>
                               </p>
                           </a>
                           @php
                               $sub_menus = DB::table('pro_sub_mnu')
                                   ->where('module_id', 11)
                                   ->where('main_mnu_id', $m_main_mnu_id)
                                   ->Where('valid', '1')
                                   ->orderBy('menu_sl', 'asc')
                                   ->get();

                           @endphp

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
                                           <a href="{{ route($txt_sub_mnu_link) }}" class="nav-link">
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
