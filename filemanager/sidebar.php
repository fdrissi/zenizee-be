<link rel="stylesheet" href="assets/css/magicmate-sidebar.css">
<?php
   if (!isset($_SESSION["evename"])) {
?>
<script>
   window.location.href="/";
</script>
<?php
   }

   // ── Determine current page for active state ──
   $mm_current_page = basename($_SERVER['PHP_SELF']);

   if ($_SESSION["stype"] == "mowner") { ?>
<!-- ═══════════════════════════════════════════════════════════════
     MAGICMATE SIDEBAR — Master Admin
     ═══════════════════════════════════════════════════════════════ -->
<div class="sidebar-wrapper mm-sidebar" sidebar-layout="stroke-svg">
   <div class="mm-sidebar__inner">

      <!-- ── Logo Area ──────────────────────────────────────── -->
      <div class="logo-wrapper mm-sidebar__logo">
         <a href="dashboard.php" class="mm-sidebar__logo-link">
            <img class="img-fluid for-light mm-sidebar__logo-img" src="<?php echo $set["weblogo"]; ?>" alt="MagicMate">
            <img class="img-fluid for-dark mm-sidebar__logo-img" src="<?php echo $set["weblogo"]; ?>" alt="MagicMate">
         </a>
         <div class="back-btn"><i class="fa fa-angle-left"></i></div>
         <div class="toggle-sidebar mm-sidebar__toggle">
            <i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
         </div>
      </div>
      <div class="logo-icon-wrapper mm-sidebar__logo-collapsed">
         <a href="dashboard.php"><img class="img-fluid" src="<?php echo $set["weblogo"]; ?>" width="50px" alt="MagicMate"></a>
      </div>

      <!-- ── Navigation ─────────────────────────────────────── -->
      <nav class="sidebar-main mm-sidebar__nav" aria-label="Main navigation">
         <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
         <div id="sidebar-menu">
            <ul class="sidebar-links mm-sidebar__menu" id="simple-bar">

               <!-- Back button (mobile) -->
               <li class="back-btn">
                  <a href="dashboard.php"><img class="img-fluid" src="<?php echo $set["weblogo"]; ?>" alt="MagicMate"></a>
                  <div class="mobile-back text-end">
                     <span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                  </div>
               </li>

               <!-- ── Section: General ─────────────────────── -->
               <li class="sidebar-main-title mm-sidebar__section">
                  <div>
                     <h6 class="mm-sidebar__section-label">General</h6>
                  </div>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title link-nav mm-sidebar__link <?php echo ($mm_current_page === 'dashboard.php') ? 'mm-sidebar__link--active' : ''; ?>" href="dashboard.php">
                     <i data-feather="home" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">Dashboard</span>
                  </a>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title mm-sidebar__link <?php echo in_array($mm_current_page, ['add_category.php','list_category.php']) ? 'mm-sidebar__link--active' : ''; ?>" href="javascript:void(0);">
                     <i data-feather="list" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">Category</span>
                  </a>
                  <ul class="sidebar-submenu mm-sidebar__submenu">
                     <li class="mm-sidebar__submenu-item"><a href="add_category.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'add_category.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">Add Category</a></li>
                     <li class="mm-sidebar__submenu-item"><a href="list_category.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'list_category.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">List Category</a></li>
                  </ul>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title mm-sidebar__link <?php echo in_array($mm_current_page, ['add_page.php','list_page.php']) ? 'mm-sidebar__link--active' : ''; ?>" href="javascript:void(0);">
                     <i data-feather="book-open" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">Pages</span>
                  </a>
                  <ul class="sidebar-submenu mm-sidebar__submenu">
                     <li class="mm-sidebar__submenu-item"><a href="add_page.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'add_page.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">Add Pages</a></li>
                     <li class="mm-sidebar__submenu-item"><a href="list_page.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'list_page.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">List Pages</a></li>
                  </ul>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title mm-sidebar__link <?php echo in_array($mm_current_page, ['add_faq.php','list_faq.php']) ? 'mm-sidebar__link--active' : ''; ?>" href="javascript:void(0);">
                     <i data-feather="help-circle" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">FAQ</span>
                  </a>
                  <ul class="sidebar-submenu mm-sidebar__submenu">
                     <li class="mm-sidebar__submenu-item"><a href="add_faq.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'add_faq.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">Add FAQ</a></li>
                     <li class="mm-sidebar__submenu-item"><a href="list_faq.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'list_faq.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">List FAQ</a></li>
                  </ul>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title link-nav mm-sidebar__link <?php echo ($mm_current_page === 'payment_list.php') ? 'mm-sidebar__link--active' : ''; ?>" href="payment_list.php">
                     <i data-feather="database" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">Payment List</span>
                  </a>
               </li>

               <!-- ── Section: Sponsors & Payout ──────────── -->
               <li class="sidebar-main-title mm-sidebar__section">
                  <div>
                     <h6 class="mm-sidebar__section-label">Sponsors & Payout</h6>
                  </div>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title mm-sidebar__link <?php echo in_array($mm_current_page, ['add_sponsore.php','list_sponsore.php']) ? 'mm-sidebar__link--active' : ''; ?>" href="javascript:void(0);">
                     <i data-feather="speaker" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">Organizer</span>
                  </a>
                  <ul class="sidebar-submenu mm-sidebar__submenu">
                     <li class="mm-sidebar__submenu-item"><a href="add_sponsore.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'add_sponsore.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">Add Organizer</a></li>
                     <li class="mm-sidebar__submenu-item"><a href="list_sponsore.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'list_sponsore.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">List Organizer</a></li>
                  </ul>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title link-nav mm-sidebar__link <?php echo ($mm_current_page === 'list_payout.php') ? 'mm-sidebar__link--active' : ''; ?>" href="list_payout.php">
                     <i data-feather="file-plus" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">Payout List</span>
                  </a>
               </li>

               <!-- ── Section: Facility & Restriction ─────── -->
               <li class="sidebar-main-title mm-sidebar__section">
                  <div>
                     <h6 class="mm-sidebar__section-label">Facility & Restriction</h6>
                  </div>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title mm-sidebar__link <?php echo in_array($mm_current_page, ['add_facility.php','list_facility.php']) ? 'mm-sidebar__link--active' : ''; ?>" href="javascript:void(0);">
                     <i data-feather="globe" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">Event Facility</span>
                  </a>
                  <ul class="sidebar-submenu mm-sidebar__submenu">
                     <li class="mm-sidebar__submenu-item"><a href="add_facility.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'add_facility.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">Add Facility</a></li>
                     <li class="mm-sidebar__submenu-item"><a href="list_facility.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'list_facility.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">List Facility</a></li>
                  </ul>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title mm-sidebar__link <?php echo in_array($mm_current_page, ['add_restriction.php','list_restriction.php']) ? 'mm-sidebar__link--active' : ''; ?>" href="javascript:void(0);">
                     <i data-feather="shield-off" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">Event Restriction</span>
                  </a>
                  <ul class="sidebar-submenu mm-sidebar__submenu">
                     <li class="mm-sidebar__submenu-item"><a href="add_restriction.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'add_restriction.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">Add Restriction</a></li>
                     <li class="mm-sidebar__submenu-item"><a href="list_restriction.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'list_restriction.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">List Restriction</a></li>
                  </ul>
               </li>

               <!-- ── Section: User ───────────────────────── -->
               <li class="sidebar-main-title mm-sidebar__section">
                  <div>
                     <h6 class="mm-sidebar__section-label">User</h6>
                  </div>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title link-nav mm-sidebar__link <?php echo ($mm_current_page === 'list_user.php') ? 'mm-sidebar__link--active' : ''; ?>" href="list_user.php">
                     <i data-feather="users" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">User List</span>
                  </a>
               </li>

            </ul>
         </div>
         <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
      </nav>

      <!-- ── Sidebar Footer ─────────────────────────────────── -->
      <div class="mm-sidebar__footer">
         <div class="mm-sidebar__footer-brand">
            <span class="mm-sidebar__footer-dot"></span>
            <span class="mm-sidebar__footer-text">Powered by MagicMate</span>
         </div>
         <span class="mm-sidebar__footer-version">v2.0</span>
      </div>

   </div>
</div>

<?php } else { ?>
<!-- ═══════════════════════════════════════════════════════════════
     MAGICMATE SIDEBAR — Organizer
     ═══════════════════════════════════════════════════════════════ -->
<div class="sidebar-wrapper mm-sidebar" sidebar-layout="stroke-svg">
   <div class="mm-sidebar__inner">

      <!-- ── Logo Area ──────────────────────────────────────── -->
      <div class="logo-wrapper mm-sidebar__logo">
         <a href="dashboard.php" class="mm-sidebar__logo-link">
            <img class="img-fluid for-light mm-sidebar__logo-img" src="<?php echo $set["weblogo"]; ?>" alt="MagicMate">
            <img class="img-fluid for-dark mm-sidebar__logo-img" src="<?php echo $set["weblogo"]; ?>" alt="MagicMate">
         </a>
         <div class="back-btn"><i class="fa fa-angle-left"></i></div>
         <div class="toggle-sidebar mm-sidebar__toggle">
            <i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
         </div>
      </div>
      <div class="logo-icon-wrapper mm-sidebar__logo-collapsed">
         <a href="dashboard.php"><img class="img-fluid" src="<?php echo $set["weblogo"]; ?>" width="50px" alt="MagicMate"></a>
      </div>

      <!-- ── Navigation ─────────────────────────────────────── -->
      <nav class="sidebar-main mm-sidebar__nav" aria-label="Main navigation">
         <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
         <div id="sidebar-menu">
            <ul class="sidebar-links mm-sidebar__menu" id="simple-bar">

               <!-- Back button (mobile) -->
               <li class="back-btn">
                  <a href="dashboard.php"><img class="img-fluid" src="<?php echo $set["weblogo"]; ?>" alt="MagicMate"></a>
                  <div class="mobile-back text-end">
                     <span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                  </div>
               </li>

               <!-- ── Section: General ─────────────────────── -->
               <li class="sidebar-main-title mm-sidebar__section">
                  <div>
                     <h6 class="mm-sidebar__section-label">General</h6>
                  </div>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title link-nav mm-sidebar__link <?php echo ($mm_current_page === 'dashboard.php') ? 'mm-sidebar__link--active' : ''; ?>" href="dashboard.php">
                     <i data-feather="home" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">Dashboard</span>
                  </a>
               </li>

               <!-- ── Section: Event ──────────────────────── -->
               <li class="sidebar-main-title mm-sidebar__section">
                  <div>
                     <h6 class="mm-sidebar__section-label">Event</h6>
                  </div>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title mm-sidebar__link <?php echo in_array($mm_current_page, ['add_event.php','list_event.php']) ? 'mm-sidebar__link--active' : ''; ?>" href="javascript:void(0);">
                     <i data-feather="cast" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">Event</span>
                  </a>
                  <ul class="sidebar-submenu mm-sidebar__submenu">
                     <li class="mm-sidebar__submenu-item"><a href="add_event.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'add_event.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">Add Event</a></li>
                     <li class="mm-sidebar__submenu-item"><a href="list_event.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'list_event.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">List Event</a></li>
                  </ul>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title mm-sidebar__link <?php echo in_array($mm_current_page, ['add_etype.php','list_etype.php']) ? 'mm-sidebar__link--active' : ''; ?>" href="javascript:void(0);">
                     <i data-feather="cast" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">Event Type & Price</span>
                  </a>
                  <ul class="sidebar-submenu mm-sidebar__submenu">
                     <li class="mm-sidebar__submenu-item"><a href="add_etype.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'add_etype.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">Add Price</a></li>
                     <li class="mm-sidebar__submenu-item"><a href="list_etype.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'list_etype.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">List Price</a></li>
                  </ul>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title mm-sidebar__link <?php echo in_array($mm_current_page, ['add_cover.php','list_cover.php']) ? 'mm-sidebar__link--active' : ''; ?>" href="javascript:void(0);">
                     <i data-feather="image" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">Cover Images</span>
                  </a>
                  <ul class="sidebar-submenu mm-sidebar__submenu">
                     <li class="mm-sidebar__submenu-item"><a href="add_cover.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'add_cover.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">Add Cover</a></li>
                     <li class="mm-sidebar__submenu-item"><a href="list_cover.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'list_cover.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">List Cover</a></li>
                  </ul>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title mm-sidebar__link <?php echo in_array($mm_current_page, ['add_gallery.php','list_gallery.php']) ? 'mm-sidebar__link--active' : ''; ?>" href="javascript:void(0);">
                     <i data-feather="image" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">Event Gallery</span>
                  </a>
                  <ul class="sidebar-submenu mm-sidebar__submenu">
                     <li class="mm-sidebar__submenu-item"><a href="add_gallery.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'add_gallery.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">Add Gallery</a></li>
                     <li class="mm-sidebar__submenu-item"><a href="list_gallery.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'list_gallery.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">List Gallery</a></li>
                  </ul>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title mm-sidebar__link <?php echo in_array($mm_current_page, ['add_artist.php','list_artist.php']) ? 'mm-sidebar__link--active' : ''; ?>" href="javascript:void(0);">
                     <i data-feather="users" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">Event Artist</span>
                  </a>
                  <ul class="sidebar-submenu mm-sidebar__submenu">
                     <li class="mm-sidebar__submenu-item"><a href="add_artist.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'add_artist.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">Add Artist</a></li>
                     <li class="mm-sidebar__submenu-item"><a href="list_artist.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'list_artist.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">List Artist</a></li>
                  </ul>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title mm-sidebar__link <?php echo in_array($mm_current_page, ['add_coupon.php','list_coupon.php']) ? 'mm-sidebar__link--active' : ''; ?>" href="javascript:void(0);">
                     <i data-feather="gift" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">Event Coupon</span>
                  </a>
                  <ul class="sidebar-submenu mm-sidebar__submenu">
                     <li class="mm-sidebar__submenu-item"><a href="add_coupon.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'add_coupon.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">Add Coupon</a></li>
                     <li class="mm-sidebar__submenu-item"><a href="list_coupon.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'list_coupon.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">List Coupon</a></li>
                  </ul>
               </li>

               <!-- ── Section: Payout ─────────────────────── -->
               <li class="sidebar-main-title mm-sidebar__section">
                  <div>
                     <h6 class="mm-sidebar__section-label">Payout</h6>
                  </div>
               </li>

               <li class="sidebar-list mm-sidebar__item">
                  <a class="sidebar-link sidebar-title mm-sidebar__link <?php echo in_array($mm_current_page, ['add_payout.php','list_epayout.php']) ? 'mm-sidebar__link--active' : ''; ?>" href="javascript:void(0);">
                     <i data-feather="file-plus" class="mm-sidebar__icon"></i>
                     <span class="mm-sidebar__label">Payout</span>
                  </a>
                  <ul class="sidebar-submenu mm-sidebar__submenu">
                     <li class="mm-sidebar__submenu-item"><a href="add_payout.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'add_payout.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">Add Payout</a></li>
                     <li class="mm-sidebar__submenu-item"><a href="list_epayout.php" class="mm-sidebar__submenu-link <?php echo ($mm_current_page === 'list_epayout.php') ? 'mm-sidebar__submenu-link--active' : ''; ?>">List Payout</a></li>
                  </ul>
               </li>

            </ul>
         </div>
         <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
      </nav>

      <!-- ── Sidebar Footer ─────────────────────────────────── -->
      <div class="mm-sidebar__footer">
         <div class="mm-sidebar__footer-brand">
            <span class="mm-sidebar__footer-dot"></span>
            <span class="mm-sidebar__footer-text">Powered by MagicMate</span>
         </div>
         <span class="mm-sidebar__footer-version">v2.0</span>
      </div>

   </div>
</div>
<?php } ?>
