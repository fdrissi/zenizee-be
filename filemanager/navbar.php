<link rel="stylesheet" href="assets/css/magicmate-header.css">
<div class="page-header mm-header">
  <div class="header-wrapper row m-0">

    <!-- Logo + Sidebar Toggle -->
    <div class="header-logo-wrapper col-auto p-0">
      <div class="logo-wrapper">
        <a href="dashboard.php">
          <img class="img-fluid" src="<?php echo $set['weblogo']; ?>" alt="<?php echo htmlspecialchars($set['webname'] ?? 'MagicMate'); ?>">
        </a>
      </div>
      <div class="toggle-sidebar mm-header__toggle">
        <i class="status_toggle middle sidebar-toggle" data-feather="menu"></i>
      </div>
    </div>

    <!-- Right Side -->
    <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
      <ul class="nav-menus">

        <?php if (isset($_SESSION['stype'])) {
          if ($_SESSION['stype'] == 'sowner') { ?>

            <!-- ── Organizer Profile ── -->
            <li class="profile-nav onhover-dropdown pe-0 py-0">
              <div class="media profile-media">
                <div class="mm-header__avatar">
                  <img class="b-r-10" src="<?php echo $sdata['img']; ?>" width="36" height="36" alt="<?php echo htmlspecialchars($sdata['title']); ?>">
                  <span class="mm-header__avatar-status"></span>
                </div>
                <div class="media-body">
                  <span><?php echo $sdata['title']; ?></span>
                  <p class="mb-0 font-roboto">Organizer <i data-feather="chevron-down"></i></p>
                </div>
                <div class="mm-header__profile-info">
                  <span class="mm-header__profile-name"><?php echo htmlspecialchars($sdata['title']); ?></span>
                  <div class="mm-header__profile-meta">
                    <span class="mm-header__role-badge mm-header__role-badge--organizer">Organizer</span>
                  </div>
                </div>
                <div class="mm-header__chevron">
                  <i data-feather="chevron-down"></i>
                </div>
              </div>

              <ul class="profile-dropdown onhover-show-div">
                <li class="mm-header__dropdown-header-item" style="pointer-events:none;">
                  <div class="mm-header__dropdown-header">
                    <img src="<?php echo $sdata['img']; ?>" alt="">
                    <div>
                      <div class="mm-header__dropdown-name"><?php echo htmlspecialchars($sdata['title']); ?></div>
                      <div class="mm-header__dropdown-role">Organizer</div>
                    </div>
                  </div>
                </li>
                <li>
                  <a href="oprofile.php">
                    <i data-feather="user"></i>
                    <span>Profile</span>
                  </a>
                </li>
                <li class="mm-header__dropdown-separator" role="separator"></li>
                <li class="mm-header__dropdown-logout">
                  <a href="logout.php">
                    <i data-feather="log-out"></i>
                    <span>Log out</span>
                  </a>
                </li>
              </ul>
            </li>

          <?php } else { ?>

            <!-- ── Admin Profile ── -->
            <li class="profile-nav onhover-dropdown pe-0 py-0">
              <div class="media profile-media">
                <div class="mm-header__avatar">
                  <img class="b-r-10" src="images/5.png" width="36" height="36" alt="Admin">
                  <span class="mm-header__avatar-status"></span>
                </div>
                <div class="media-body">
                  <span>Main Admin</span>
                  <p class="mb-0 font-roboto">Admin <i data-feather="chevron-down"></i></p>
                </div>
                <div class="mm-header__profile-info">
                  <span class="mm-header__profile-name">Main Admin</span>
                  <div class="mm-header__profile-meta">
                    <span class="mm-header__role-badge mm-header__role-badge--admin">Admin</span>
                  </div>
                </div>
                <div class="mm-header__chevron">
                  <i data-feather="chevron-down"></i>
                </div>
              </div>

              <ul class="profile-dropdown onhover-show-div">
                <li class="mm-header__dropdown-header-item" style="pointer-events:none;">
                  <div class="mm-header__dropdown-header">
                    <img src="images/5.png" alt="">
                    <div>
                      <div class="mm-header__dropdown-name">Main Admin</div>
                      <div class="mm-header__dropdown-role">Master Admin</div>
                    </div>
                  </div>
                </li>
                <li>
                  <a href="profile.php">
                    <i data-feather="user"></i>
                    <span>Profile</span>
                  </a>
                </li>
                <li>
                  <a href="setting.php">
                    <i data-feather="settings"></i>
                    <span>Settings</span>
                  </a>
                </li>
                <li class="mm-header__dropdown-separator" role="separator"></li>
                <li class="mm-header__dropdown-logout">
                  <a href="logout.php">
                    <i data-feather="log-out"></i>
                    <span>Log out</span>
                  </a>
                </li>
              </ul>
            </li>

          <?php } } ?>

      </ul>
    </div>
    <!-- /.nav-right -->

  </div>
</div>
