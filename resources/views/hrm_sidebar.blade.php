   <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('hrm') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          @php
          $txt_emp_id=Auth::user()->emp_id;
          // echo $txt_emp_id;

          $data_pro_sub_mnu_for_users=DB::table('pro_sub_mnu_for_users')->Where('emp_id',$txt_emp_id)->where('module_id','2')->where('valid','1')->groupBy('main_mnu_id')->get();
          
          @endphp

          @foreach($data_pro_sub_mnu_for_users as $key=>$row_pro_sub_mnu_for_users)
          @php
          $m_main_mnu_id=$row_pro_sub_mnu_for_users->main_mnu_id;

          $data_pro_main_mnu=DB::table('pro_main_mnu')->where('main_mnu_id',$m_main_mnu_id)->Where('valid','1')->first();

          $txt_main_mnu_title=$data_pro_main_mnu->main_mnu_title;
          @endphp

          <li class="nav-item">
            <a href="#" class="nav-link">

              <i class="nav-icon far fa-plus-square"></i>
              <p>{{ $txt_main_mnu_title }}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            @php
            $data_pro_sub_mnu_for_users_02=DB::table('pro_sub_mnu_for_users')->where('main_mnu_id',$m_main_mnu_id)->Where('emp_id',$txt_emp_id)->where('module_id','2')->where('valid','1')->get();
            
            
            @endphp

            @foreach($data_pro_sub_mnu_for_users_02 as $key=>$row_pro_sub_mnu_for_users_02)

            @php
            $m_sub_mnu_id=$row_pro_sub_mnu_for_users_02->sub_mnu_id;
            $data_pro_sub_mnu=DB::table('pro_sub_mnu')->where('sub_mnu_id',$m_sub_mnu_id)->Where('valid','1')->first();

            $txt_sub_mnu_title=$data_pro_sub_mnu->sub_mnu_title;
            $txt_sub_mnu_link=$data_pro_sub_mnu->sub_mnu_link;
            @endphp

            <ul class="nav-treeview nav-compact">
              <li class="nav-item">
                <a href="{{ route($txt_sub_mnu_link) }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ $txt_sub_mnu_title }}</p>
                </a>
              </li>
            </ul>
            @endforeach

          </li>
          @endforeach


        </ul>
      </nav>&nbsp;
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
