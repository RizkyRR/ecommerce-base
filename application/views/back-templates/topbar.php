<header class="main-header">

  <!-- Logo -->
  <a href="<?php echo base_url(); ?>admin" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><i class="fa fa-info-circle" aria-hidden="true"></i> <b><?php echo $company['company_name'] ?></b></span>
  </a>

  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- Messages: style can be found in dropdown.less-->
        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-envelope" title="messages"></i>

            <!-- span ini dikondisikan di .js kalo ada pesan merah kalo semua 0 hilangkan label -->
            <span class="label label-danger show-count-incoming-label"></span>

          </a>
          <ul class="dropdown-menu">

            <!-- class count-all-messages dikondisikan di .js -->
            <!-- <li class="header">You have 0 message</li> -->
            <li class="header">
              <div id="show-count-incoming-header"></div>
            </li>

            <li>

              <!-- inner menu: contains the actual data -->
              <ul class="menu">
                <li id="show-count-chat">
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-comment text-aqua"></i> {2} Comment
                  </a>
                </li>
              </ul>

            </li>
            <li class="footer"><a href="#">View all</a></li>
          </ul>
        </li>

        <!-- Notifications: style can be found in dropdown.less -->
        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell" title="notifications stock limit"></i>

            <!-- label set on js -->
            <span class="label label-danger">
              <div id="show-count-stock-limit-label"></div>
            </span>

          </a>
          <ul class="dropdown-menu">

            <!-- header set on js -->
            <li class="header">
              <div id="show-count-stock-limit-header"></div>
            </li>

            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu">
                <li id="show-count-stock-limit">
                </li>
                <!-- <li>
                  <a href="#">
                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                  </a>
                </li> -->
              </ul>
            </li>

            <li class="footer show-view-all-stock"></li>
          </ul>
        </li>

        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo base_url(); ?>image/profile/<?php echo $user['image'] ?>" class="user-image" title="User Image">
            <span class="hidden-xs"><?php echo $user['name'] ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="<?php echo base_url(); ?>image/profile/<?php echo $user['image'] ?>" class="img-circle" title="User Image">

              <p>
                <?php echo $user['name'] ?> - <?php echo $user['role'] ?>
                <small>Member since <?php echo date('d F Y', $user['created_at']) ?></small>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="<?php echo base_url(); ?>user" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a href="<?php echo base_url(); ?>auth/logout" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>

  </nav>
</header>