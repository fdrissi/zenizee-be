<link rel="stylesheet" href="assets/css/magicmate-header.css">
<div class="page-header mm-header">
  <div class="header-wrapper row m-0">

    <!-- Logo + Sidebar Toggle -->
    <div class="header-logo-wrapper col-auto p-0">
      <div class="logo-wrapper">
        <a href="dashboard.php">
          <img class="img-fluid" src="<?php echo $set['weblogo']; ?>" alt="">
        </a>
      </div>
      <div class="toggle-sidebar">
        <i class="status_toggle middle sidebar-toggle" data-feather="menu"></i>
      </div>
    </div>

    <!-- Right Side -->
    <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
      <ul class="nav-menus">

        <?php if (isset($_SESSION['stype'])) {
          if ($_SESSION['stype'] == 'sowner') { ?>

            <li class="profile-nav onhover-dropdown pe-0 py-0">
              <div class="media profile-media">
                <img class="b-r-10" src="<?php echo $sdata['img']; ?>" width="36" height="36" alt="">
                <div class="media-body"><span><?php echo htmlspecialchars($sdata['title']); ?></span>
                  <p class="mb-0 font-roboto">Organizer <i data-feather="chevron-down"></i></p>
                </div>
              </div>
              <ul class="profile-dropdown onhover-show-div">
                <li><a href="oprofile.php"><i data-feather="user"></i><span>Profile</span></a></li>
                <li><a href="logout.php"><i data-feather="log-out"></i><span>Log out</span></a></li>
              </ul>
            </li>

          <?php } else { ?>

            <li class="profile-nav onhover-dropdown pe-0 py-0">
              <div class="media profile-media">
                <img class="b-r-10" src="images/5.png" width="36" height="36" alt="">
                <div class="media-body"><span>Main Admin</span>
                  <p class="mb-0 font-roboto">Admin <i data-feather="chevron-down"></i></p>
                </div>
              </div>
              <ul class="profile-dropdown onhover-show-div">
                <li><a href="profile.php"><i data-feather="user"></i><span>Profile</span></a></li>
                <li><a href="setting.php"><i data-feather="settings"></i><span>Settings</span></a></li>
                <li><a href="logout.php"><i data-feather="log-out"></i><span>Log out</span></a></li>
              </ul>
            </li>

          <?php } } ?>

      </ul>
    </div>

  </div>
</div>
