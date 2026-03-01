<?php
   include "filemanager/head.php";
   define('SELC', 'select * from tbl_event where sponsore_id=');

   // ── Gather all data up front ──────────────────────────────────
   $isOwner = isset($_SESSION["stype"]) && $_SESSION["stype"] == "sowner";
   $currency = $set["currency"] ?? '$';
   $adminName = $isOwner ? ($sdata["title"] ?? 'Organizer') : 'Admin';
   $hour = (int) date('G');
   $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');

   // Current date for the welcome area
   $dateDisplay = date('l, F j, Y');

   if ($isOwner) {
      $ownerId = $sdata["id"];
      $totalEvents     = $evmulti->query(SELC . $ownerId)->num_rows;
      $completedEvents = $evmulti->query(SELC . $ownerId . " and event_status='Completed'")->num_rows;
      $cancelledEvents = $evmulti->query(SELC . $ownerId . " and event_status='Cancelled'")->num_rows;
      $runningEvents   = $evmulti->query(SELC . $ownerId . " and event_status='Pending'")->num_rows;
      $totalCovers     = $evmulti->query("select * from tbl_cover where sponsore_id=" . $ownerId)->num_rows;
      $totalGallery    = $evmulti->query("select * from tbl_gallery where sponsore_id=" . $ownerId)->num_rows;
      $totalArtists    = $evmulti->query("select * from tbl_artist where sponsore_id=" . $ownerId)->num_rows;
      $totalCoupons    = $evmulti->query("select * from tbl_coupon where sponsore_id=" . $ownerId)->num_rows;

      $t = $evmulti->query("select sum(`total_ticket`) as totaltic from tbl_ticket where sponsore_id=" . $ownerId . " and ticket_type!='Cancelled'")->fetch_assoc();
      $totalTickets = empty($t["totaltic"]) ? 0 : $t["totaltic"];

      $total_earn = $evmulti->query("select sum((subtotal-cou_amt) - ((subtotal-cou_amt) * commission/100)) as total_amt from tbl_ticket where sponsore_id=" . $ownerId . " and ticket_type ='Completed'")->fetch_assoc();
      $earn = empty($total_earn["total_amt"]) ? 0 : number_format((float) $total_earn["total_amt"], 2, ".", "");

      $total_payout = $evmulti->query("select sum(amt) as total_payout from payout_setting where owner_id=" . $ownerId)->fetch_assoc();
      $payout = empty($total_payout["total_payout"]) ? 0 : number_format((float) $total_payout["total_payout"], 2, ".", "");

      $afterPayout = number_format((float) $earn - $payout, 2, ".", "");
   } else {
      $totalCategories = $evmulti->query("select * from tbl_category")->num_rows;
      $totalEvents     = $evmulti->query("select * from tbl_event")->num_rows;
      $completedEvents = $evmulti->query("select * from tbl_event where event_status='Completed'")->num_rows;
      $cancelledEvents = $evmulti->query("select * from tbl_event where event_status='Cancelled'")->num_rows;
      $runningEvents   = $evmulti->query("select * from tbl_event where event_status='Pending'")->num_rows;
      $totalPages      = $evmulti->query("select * from tbl_page")->num_rows;
      $totalFaq        = $evmulti->query("select * from tbl_faq")->num_rows;
      $totalGateways   = $evmulti->query("select * from tbl_payment_list")->num_rows;
      $totalOrganizers = $evmulti->query("select * from tbl_sponsore")->num_rows;
      $totalFacilities = $evmulti->query("select * from tbl_facility")->num_rows;
      $totalRestrict   = $evmulti->query("select * from tbl_restriction")->num_rows;
      $totalUsers      = $evmulti->query("select * from tbl_user")->num_rows;

      $total_earn = $evmulti->query("select sum((subtotal-cou_amt) * commission/100) as total_amt from tbl_ticket where ticket_type ='Completed'")->fetch_assoc();
      $earn = empty($total_earn["total_amt"]) ? 0 : number_format((float) $total_earn["total_amt"], 2, ".", "");

      $total_payout_pending = $evmulti->query("select sum(amt) as total_payout from payout_setting where status='pending'")->fetch_assoc();
      $pendingPayout = empty($total_payout_pending["total_payout"]) ? "0" : $total_payout_pending["total_payout"];

      $total_payout_completed = $evmulti->query("select sum(amt) as total_payout from payout_setting where status='completed'")->fetch_assoc();
      $completedPayout = empty($total_payout_completed["total_payout"]) ? "0" : $total_payout_completed["total_payout"];
   }
?>
<!-- loader ends-->
<!-- tap on top starts-->
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<!-- tap on tap ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
   <!-- Page Header Start-->
   <?php include "filemanager/navbar.php"; ?>
   <!-- Page Header Ends -->
   <!-- Page Body Start-->
   <div class="page-body-wrapper">
      <!-- Page Sidebar Start-->
      <?php include "filemanager/sidebar.php"; ?>
      <!-- Page Sidebar Ends-->
      <div class="page-body">

         <!-- ═══════════════════════════════════════════════════════
              ZENIZEE DASHBOARD — Custom Layout
              ═══════════════════════════════════════════════════════ -->
         <div class="mm-dash">

            <!-- ── Welcome Banner ─────────────────────────────── -->
            <section class="mm-dash__welcome">
               <div class="mm-dash__welcome-text">
                  <h1 class="mm-dash__greeting"><?php echo $greeting; ?>, <?php echo htmlspecialchars($adminName); ?></h1>
                  <p class="mm-dash__date"><?php echo $dateDisplay; ?></p>
                  <p class="mm-dash__subtitle">Here is what is happening with your events today.</p>
               </div>
               <div class="mm-dash__welcome-visual">
                  <div class="mm-dash__welcome-orb"></div>
                  <div class="mm-dash__welcome-orb mm-dash__welcome-orb--secondary"></div>
               </div>
            </section>

            <?php if ($isOwner) { ?>

            <!-- ══════════ ORGANIZER DASHBOARD ══════════ -->

            <!-- ── Hero Metrics (3 big cards) ─────────── -->
            <section class="mm-dash__hero-row">
               <div class="mm-dash__hero-card mm-dash__hero-card--primary">
                  <div class="mm-dash__hero-label">Total Earning</div>
                  <div class="mm-dash__hero-value"><?php echo $earn; ?><span class="mm-dash__hero-currency"><?php echo $currency; ?></span></div>
                  <div class="mm-dash__hero-icon"><i data-feather="trending-up"></i></div>
               </div>
               <div class="mm-dash__hero-card mm-dash__hero-card--accent">
                  <div class="mm-dash__hero-label">Total Payout</div>
                  <div class="mm-dash__hero-value"><?php echo $payout; ?><span class="mm-dash__hero-currency"><?php echo $currency; ?></span></div>
                  <div class="mm-dash__hero-icon"><i data-feather="credit-card"></i></div>
               </div>
               <div class="mm-dash__hero-card mm-dash__hero-card--muted">
                  <div class="mm-dash__hero-label">After Payout</div>
                  <div class="mm-dash__hero-value"><?php echo $afterPayout; ?><span class="mm-dash__hero-currency"><?php echo $currency; ?></span></div>
                  <div class="mm-dash__hero-icon"><i data-feather="pocket"></i></div>
               </div>
            </section>

            <!-- ── Event Stats (4 compact cards) ──────── -->
            <section class="mm-dash__stats-grid mm-dash__stats-grid--4">
               <div class="mm-dash__stat-card">
                  <div class="mm-dash__stat-top">
                     <span class="mm-dash__stat-icon mm-dash__stat-icon--blue"><i data-feather="calendar"></i></span>
                  </div>
                  <div class="mm-dash__stat-value"><?php echo $totalEvents; ?></div>
                  <div class="mm-dash__stat-label">Total Events</div>
               </div>
               <div class="mm-dash__stat-card">
                  <div class="mm-dash__stat-top">
                     <span class="mm-dash__stat-icon mm-dash__stat-icon--green"><i data-feather="check-circle"></i></span>
                  </div>
                  <div class="mm-dash__stat-value"><?php echo $completedEvents; ?></div>
                  <div class="mm-dash__stat-label">Completed</div>
               </div>
               <div class="mm-dash__stat-card">
                  <div class="mm-dash__stat-top">
                     <span class="mm-dash__stat-icon mm-dash__stat-icon--amber"><i data-feather="clock"></i></span>
                  </div>
                  <div class="mm-dash__stat-value"><?php echo $runningEvents; ?></div>
                  <div class="mm-dash__stat-label">Running</div>
               </div>
               <div class="mm-dash__stat-card">
                  <div class="mm-dash__stat-top">
                     <span class="mm-dash__stat-icon mm-dash__stat-icon--red"><i data-feather="x-circle"></i></span>
                  </div>
                  <div class="mm-dash__stat-value"><?php echo $cancelledEvents; ?></div>
                  <div class="mm-dash__stat-label">Cancelled</div>
               </div>
            </section>

            <!-- ── Secondary Stats (5 minimal items) ──── -->
            <section class="mm-dash__secondary-row">
               <div class="mm-dash__mini-stat">
                  <span class="mm-dash__mini-dot mm-dash__mini-dot--purple"></span>
                  <div class="mm-dash__mini-info">
                     <span class="mm-dash__mini-value"><?php echo $totalTickets; ?></span>
                     <span class="mm-dash__mini-label">Tickets Sold</span>
                  </div>
               </div>
               <div class="mm-dash__mini-stat">
                  <span class="mm-dash__mini-dot mm-dash__mini-dot--blue"></span>
                  <div class="mm-dash__mini-info">
                     <span class="mm-dash__mini-value"><?php echo $totalCovers; ?></span>
                     <span class="mm-dash__mini-label">Cover Images</span>
                  </div>
               </div>
               <div class="mm-dash__mini-stat">
                  <span class="mm-dash__mini-dot mm-dash__mini-dot--green"></span>
                  <div class="mm-dash__mini-info">
                     <span class="mm-dash__mini-value"><?php echo $totalGallery; ?></span>
                     <span class="mm-dash__mini-label">Gallery</span>
                  </div>
               </div>
               <div class="mm-dash__mini-stat">
                  <span class="mm-dash__mini-dot mm-dash__mini-dot--amber"></span>
                  <div class="mm-dash__mini-info">
                     <span class="mm-dash__mini-value"><?php echo $totalArtists; ?></span>
                     <span class="mm-dash__mini-label">Artists</span>
                  </div>
               </div>
               <div class="mm-dash__mini-stat">
                  <span class="mm-dash__mini-dot mm-dash__mini-dot--pink"></span>
                  <div class="mm-dash__mini-info">
                     <span class="mm-dash__mini-value"><?php echo $totalCoupons; ?></span>
                     <span class="mm-dash__mini-label">Coupons</span>
                  </div>
               </div>
            </section>

            <?php } else { ?>

            <!-- ══════════ ADMIN DASHBOARD ══════════ -->

            <!-- ── Hero Metrics (3 big cards) ─────────── -->
            <section class="mm-dash__hero-row">
               <div class="mm-dash__hero-card mm-dash__hero-card--primary">
                  <div class="mm-dash__hero-label">Total Revenue</div>
                  <div class="mm-dash__hero-value"><?php echo $earn; ?><span class="mm-dash__hero-currency"><?php echo $currency; ?></span></div>
                  <div class="mm-dash__hero-icon"><i data-feather="trending-up"></i></div>
               </div>
               <div class="mm-dash__hero-card mm-dash__hero-card--accent">
                  <div class="mm-dash__hero-label">Pending Payouts</div>
                  <div class="mm-dash__hero-value"><?php echo $pendingPayout; ?><span class="mm-dash__hero-currency"><?php echo $currency; ?></span></div>
                  <div class="mm-dash__hero-icon"><i data-feather="clock"></i></div>
               </div>
               <div class="mm-dash__hero-card mm-dash__hero-card--muted">
                  <div class="mm-dash__hero-label">Completed Payouts</div>
                  <div class="mm-dash__hero-value"><?php echo $completedPayout; ?><span class="mm-dash__hero-currency"><?php echo $currency; ?></span></div>
                  <div class="mm-dash__hero-icon"><i data-feather="check-circle"></i></div>
               </div>
            </section>

            <!-- ── Event Stats (4 compact cards) ──────── -->
            <section class="mm-dash__stats-grid mm-dash__stats-grid--4">
               <div class="mm-dash__stat-card">
                  <div class="mm-dash__stat-top">
                     <span class="mm-dash__stat-icon mm-dash__stat-icon--blue"><i data-feather="calendar"></i></span>
                  </div>
                  <div class="mm-dash__stat-value"><?php echo $totalEvents; ?></div>
                  <div class="mm-dash__stat-label">Total Events</div>
               </div>
               <div class="mm-dash__stat-card">
                  <div class="mm-dash__stat-top">
                     <span class="mm-dash__stat-icon mm-dash__stat-icon--green"><i data-feather="check-circle"></i></span>
                  </div>
                  <div class="mm-dash__stat-value"><?php echo $completedEvents; ?></div>
                  <div class="mm-dash__stat-label">Completed</div>
               </div>
               <div class="mm-dash__stat-card">
                  <div class="mm-dash__stat-top">
                     <span class="mm-dash__stat-icon mm-dash__stat-icon--amber"><i data-feather="clock"></i></span>
                  </div>
                  <div class="mm-dash__stat-value"><?php echo $runningEvents; ?></div>
                  <div class="mm-dash__stat-label">Running</div>
               </div>
               <div class="mm-dash__stat-card">
                  <div class="mm-dash__stat-top">
                     <span class="mm-dash__stat-icon mm-dash__stat-icon--red"><i data-feather="x-circle"></i></span>
                  </div>
                  <div class="mm-dash__stat-value"><?php echo $cancelledEvents; ?></div>
                  <div class="mm-dash__stat-label">Cancelled</div>
               </div>
            </section>

            <!-- ── Platform Overview (2-col asymmetric) ── -->
            <section class="mm-dash__overview">
               <div class="mm-dash__overview-main">
                  <h2 class="mm-dash__section-title">Platform Overview</h2>
                  <div class="mm-dash__overview-grid">
                     <div class="mm-dash__ov-item">
                        <div class="mm-dash__ov-icon"><i data-feather="grid"></i></div>
                        <div class="mm-dash__ov-data">
                           <span class="mm-dash__ov-num"><?php echo $totalCategories; ?></span>
                           <span class="mm-dash__ov-label">Categories</span>
                        </div>
                     </div>
                     <div class="mm-dash__ov-item">
                        <div class="mm-dash__ov-icon"><i data-feather="users"></i></div>
                        <div class="mm-dash__ov-data">
                           <span class="mm-dash__ov-num"><?php echo $totalUsers; ?></span>
                           <span class="mm-dash__ov-label">Users</span>
                        </div>
                     </div>
                     <div class="mm-dash__ov-item">
                        <div class="mm-dash__ov-icon"><i data-feather="mic"></i></div>
                        <div class="mm-dash__ov-data">
                           <span class="mm-dash__ov-num"><?php echo $totalOrganizers; ?></span>
                           <span class="mm-dash__ov-label">Organizers</span>
                        </div>
                     </div>
                     <div class="mm-dash__ov-item">
                        <div class="mm-dash__ov-icon"><i data-feather="credit-card"></i></div>
                        <div class="mm-dash__ov-data">
                           <span class="mm-dash__ov-num"><?php echo $totalGateways; ?></span>
                           <span class="mm-dash__ov-label">Gateways</span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="mm-dash__overview-side">
                  <h2 class="mm-dash__section-title">Configuration</h2>
                  <ul class="mm-dash__config-list">
                     <li class="mm-dash__config-item">
                        <span class="mm-dash__config-label">Pages</span>
                        <span class="mm-dash__config-value"><?php echo $totalPages; ?></span>
                     </li>
                     <li class="mm-dash__config-item">
                        <span class="mm-dash__config-label">FAQ Entries</span>
                        <span class="mm-dash__config-value"><?php echo $totalFaq; ?></span>
                     </li>
                     <li class="mm-dash__config-item">
                        <span class="mm-dash__config-label">Facilities</span>
                        <span class="mm-dash__config-value"><?php echo $totalFacilities; ?></span>
                     </li>
                     <li class="mm-dash__config-item">
                        <span class="mm-dash__config-label">Restrictions</span>
                        <span class="mm-dash__config-value"><?php echo $totalRestrict; ?></span>
                     </li>
                  </ul>
               </div>
            </section>

            <?php } ?>

         </div>
         <!-- /.mm-dash -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<!-- Plugin used-->
</body>
</html>
