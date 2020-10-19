<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo base_url(); ?>image/profile/<?php echo $user['image'] ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $user['name'] ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>

      <?php
      $menus = sidebarMenu();
      if (is_array($menus) || is_object($menus)) :
      ?>
        <?php foreach ($menus as $menu) : ?>

          <li class="treeview">
            <a href="#">
              <i class="<?php echo $menu['icon']; ?>"></i> <span><?php echo $menu['menu']; ?></span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <?php
            $menu_id = $menu['id'];
            $submenus = sidebarSubMenu($menu_id);
            if (is_array($submenus) || is_object($submenus)) :
            ?>
              <ul class="treeview-menu">
                <?php foreach ($submenus as $submenu) : ?>

                  <li><a href="<?php echo base_url($submenu['url']); ?>"><i class="fa fa-circle-o"></i> <?php echo $submenu['title']; ?></a></li>

                <?php endforeach; ?>
              </ul>
            <?php endif; ?>

          </li>

        <?php endforeach; ?>
      <?php endif; ?>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>