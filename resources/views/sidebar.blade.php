    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="./index.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Module
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            
            <ul class="nav nav-treeview nav-compact">
            @php
            $txt_emp_id=Auth::user()->emp_id;
            // echo $txt_emp_id;

            $data_pro_module_user=DB::table('pro_module_user')->Where('emp_id',$txt_emp_id)->where('valid','1')->get();
            
            @endphp

            @foreach($data_pro_module_user as $key=>$row_pro_module_user)
            @php
            $txt_module_id=$row_pro_module_user->module_id;

            $data_pro_module=DB::table('pro_module')->where('module_id',$txt_module_id)->Where('valid','1')->first();

            $txt_module_name=$data_pro_module->module_name;
            $txt_module_link=$data_pro_module->module_link;
            @endphp

              <li class="nav-item">
                <a href="{{ route($txt_module_link) }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ $txt_module_name }}</p>
                </a>
              </li>
              @endforeach
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->