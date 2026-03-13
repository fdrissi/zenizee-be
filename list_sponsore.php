<?php
   include "filemanager/head.php";
   define('COM', " and ticket_type ='Completed'");
?>
<link rel="stylesheet" href="assets/css/zenizee-page-orglist.css">
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
              ZENIZEE ORGANIZER LIST — Custom Card Layout
              ═══════════════════════════════════════════════════════ -->
         <div class="mm-orglist">

            <?php
               // ── Gather organizer data up front ──────────────────────────────
               $orgQuery = $evmulti->query("select * from tbl_sponsore");
               $organizers = [];
               while ($row = $orgQuery->fetch_assoc()) {
                  $organizers[] = $row;
               }

               $totalOrgs   = count($organizers);
               $activeCount = 0;
               $inactiveCount = 0;
               foreach ($organizers as $org) {
                  if ($org['status'] == 1) {
                     $activeCount++;
                  } else {
                     $inactiveCount++;
                  }
               }
            ?>

            <!-- ── Page Header ─────────────────────────────── -->
            <header class="mm-orglist__header">
               <div class="mm-orglist__header-left">
                  <h1 class="mm-orglist__title">Organizers</h1>
                  <p class="mm-orglist__subtitle">Manage your event organizers and track their performance.</p>
               </div>
               <div class="mm-orglist__header-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
               </div>
            </header>

            <!-- ── Stats Bar ───────────────────────────────── -->
            <div class="mm-orglist__stats-bar">
               <div class="mm-orglist__stat">
                  <span class="mm-orglist__stat-dot mm-orglist__stat-dot--total"></span>
                  <span class="mm-orglist__stat-value"><?php echo $totalOrgs; ?></span>
                  <span class="mm-orglist__stat-label">Total Organizers</span>
               </div>
               <span class="mm-orglist__stat-separator"></span>
               <div class="mm-orglist__stat">
                  <span class="mm-orglist__stat-dot mm-orglist__stat-dot--active"></span>
                  <span class="mm-orglist__stat-value"><?php echo $activeCount; ?></span>
                  <span class="mm-orglist__stat-label">Active</span>
               </div>
               <span class="mm-orglist__stat-separator"></span>
               <div class="mm-orglist__stat">
                  <span class="mm-orglist__stat-dot mm-orglist__stat-dot--inactive"></span>
                  <span class="mm-orglist__stat-value"><?php echo $inactiveCount; ?></span>
                  <span class="mm-orglist__stat-label">Inactive</span>
               </div>
            </div>

            <!-- ── Toolbar: Search + Filters ─────────────── -->
            <div class="mm-orglist__toolbar">
               <div class="mm-orglist__search-wrap">
                  <span class="mm-orglist__search-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                  </span>
                  <input type="text" class="mm-orglist__search-input" id="mmOrgSearch" placeholder="Search organizers..." autocomplete="off">
               </div>
               <div class="mm-orglist__filters">
                  <button type="button" class="mm-orglist__filter-btn mm-orglist__filter-btn--active" data-filter="all">
                     All
                     <span class="mm-orglist__filter-count"><?php echo $totalOrgs; ?></span>
                  </button>
                  <button type="button" class="mm-orglist__filter-btn" data-filter="active">
                     Active
                     <span class="mm-orglist__filter-count"><?php echo $activeCount; ?></span>
                  </button>
                  <button type="button" class="mm-orglist__filter-btn" data-filter="inactive">
                     Inactive
                     <span class="mm-orglist__filter-count"><?php echo $inactiveCount; ?></span>
                  </button>
               </div>
            </div>

            <!-- ── Organizer Card Grid ────────────────────── -->
            <div class="mm-orglist__grid" id="mmOrgGrid">
               <?php if ($totalOrgs === 0) { ?>
                  <!-- Empty State -->
                  <div class="mm-orglist__empty">
                     <div class="mm-orglist__empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                     </div>
                     <h3 class="mm-orglist__empty-title">No organizers found</h3>
                     <p class="mm-orglist__empty-text">No organizers are registered yet. Add one to get started.</p>
                  </div>
               <?php } else {
                  $i = 0;
                  foreach ($organizers as $row) {
                     $i++;
                     $isActive = $row['status'] == 1;

                     // ── Event counts ──────────────────────────────────────
                     $totalEvents = $evmulti->query(
                        "select * from tbl_event where sponsore_id=" . $row["id"] . ""
                     )->num_rows;

                     $runningEvents = $evmulti->query(
                        "select * from tbl_event where event_status='Pending' and sponsore_id=" . $row["id"] . ""
                     )->num_rows;

                     $completedEvents = $evmulti->query(
                        "select * from tbl_event where event_status='Completed' and sponsore_id=" . $row["id"] . ""
                     )->num_rows;

                     $cancelledEvents = $evmulti->query(
                        "select * from tbl_event where event_status='Cancelled' and sponsore_id=" . $row["id"] . ""
                     )->num_rows;

                     // ── Financial: Total Sales ────────────────────────────
                     $total_earn = $evmulti->query(
                        "select sum(subtotal) as total_amt from tbl_ticket where sponsore_id=" . $row["id"] . COM
                     )->fetch_assoc();
                     $totalSales = empty($total_earn["total_amt"]) ? 0 : number_format((float)$total_earn["total_amt"], 2, ".", "");

                     // ── Financial: Coupon Amount Used ─────────────────────
                     $total_earn = $evmulti->query(
                        "select sum(cou_amt) as total_amt from tbl_ticket where sponsore_id=" . $row["id"] . COM
                     )->fetch_assoc();
                     $couponAmt = empty($total_earn["total_amt"]) ? 0 : number_format((float)$total_earn["total_amt"], 2, ".", "");

                     // ── Financial: Hand Sales ─────────────────────────────
                     $total_earn = $evmulti->query(
                        "select sum(subtotal-cou_amt) as total_amt from tbl_ticket where sponsore_id=" . $row["id"] . COM
                     )->fetch_assoc();
                     $handSales = empty($total_earn["total_amt"]) ? 0 : number_format((float)$total_earn["total_amt"], 2, ".", "");

                     // ── Financial: Commission ─────────────────────────────
                     $total_earn = $evmulti->query(
                        "select sum((subtotal-cou_amt) * commission/100) as total_amt from tbl_ticket where sponsore_id=" . $row["id"] . COM
                     )->fetch_assoc();
                     $commission = empty($total_earn["total_amt"]) ? 0 : number_format((float)$total_earn["total_amt"], 2, ".", "");

                     // ── Payouts: Pending ──────────────────────────────────
                     $total_payout = $evmulti->query(
                        "select sum(amt) as total_payout from payout_setting where status='pending' and owner_id=" . $row["id"] . ""
                     )->fetch_assoc();
                     $payoutPending = empty($total_payout["total_payout"]) ? "0" : $total_payout["total_payout"];

                     // ── Payouts: Completed ────────────────────────────────
                     $total_payout = $evmulti->query(
                        "select sum(amt) as total_payout from payout_setting where status='completed' and owner_id=" . $row["id"] . ""
                     )->fetch_assoc();
                     $payoutCompleted = empty($total_payout["total_payout"]) ? "0" : $total_payout["total_payout"];

                     // ── Remaining Organizer Earning ───────────────────────
                     $total_payout_all = $evmulti->query(
                        "select sum(amt) as total_payout from payout_setting where owner_id=" . $row["id"] . ""
                     )->fetch_assoc();
                     $payouts = empty($total_payout_all["total_payout"]) ? 0 : number_format((float)$total_earn["total_payout"], 2, ".", "");

                     $total_earn_remain = $evmulti->query(
                        "select sum((subtotal-cou_amt) - ((subtotal-cou_amt) * commission/100)) as total_amt from tbl_ticket where sponsore_id=" . $row["id"] . COM
                     )->fetch_assoc();
                     $earns = empty($total_earn_remain["total_amt"]) ? 0 : number_format((float)$total_earn_remain["total_amt"], 2, ".", "");
                     $remainingEarning = number_format((float)$earns - $payouts, 2, ".", "");
               ?>
                  <div class="mm-orglist__card"
                       style="--card-index: <?php echo $i; ?>"
                       data-org-name="<?php echo htmlspecialchars(strtolower($row['title'])); ?>"
                       data-org-status="<?php echo $isActive ? 'active' : 'inactive'; ?>">

                     <!-- Card Visual — Circular Avatar -->
                     <div class="mm-orglist__card-visual">
                        <?php if (!empty($row['img'])) { ?>
                           <img src="<?php echo htmlspecialchars($row['img']); ?>"
                                alt="<?php echo htmlspecialchars($row['title']); ?>"
                                class="mm-orglist__card-avatar"
                                loading="lazy">
                        <?php } else { ?>
                           <div class="mm-orglist__card-no-avatar">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                           </div>
                        <?php } ?>
                        <!-- Status dot -->
                        <span class="mm-orglist__status-dot <?php echo $isActive ? 'mm-orglist__status-dot--active' : 'mm-orglist__status-dot--inactive'; ?>"></span>
                        <!-- Index -->
                        <span class="mm-orglist__card-index"><?php echo $i; ?></span>
                     </div>

                     <!-- Card Body -->
                     <div class="mm-orglist__card-body">
                        <h3 class="mm-orglist__card-name" title="<?php echo htmlspecialchars($row['title']); ?>">
                           <?php echo htmlspecialchars($row['title']); ?>
                        </h3>
                        <?php if (!empty($row['email'])) { ?>
                           <p class="mm-orglist__card-email" title="<?php echo htmlspecialchars($row['email']); ?>">
                              <?php echo htmlspecialchars($row['email']); ?>
                           </p>
                        <?php } else { ?>
                           <p class="mm-orglist__card-email">No email provided</p>
                        <?php } ?>

                        <!-- Metrics grid -->
                        <div class="mm-orglist__metrics">
                           <div class="mm-orglist__metric">
                              <span class="mm-orglist__metric-label">Events</span>
                              <span class="mm-orglist__metric-value"><?php echo $totalEvents; ?></span>
                           </div>
                           <div class="mm-orglist__metric">
                              <span class="mm-orglist__metric-label">Sales</span>
                              <span class="mm-orglist__metric-value"><?php echo $set["currency"] . $totalSales; ?></span>
                           </div>
                           <div class="mm-orglist__metric">
                              <span class="mm-orglist__metric-label">Commission</span>
                              <span class="mm-orglist__metric-value"><?php echo $set["currency"] . $commission; ?></span>
                           </div>
                           <div class="mm-orglist__metric">
                              <span class="mm-orglist__metric-label">Paid Out</span>
                              <span class="mm-orglist__metric-value"><?php echo $set["currency"] . $payoutCompleted; ?></span>
                           </div>
                        </div>

                        <!-- Event counts row -->
                        <div class="mm-orglist__event-counts">
                           <span class="mm-orglist__event-pill mm-orglist__event-pill--running" title="Running / Pending">
                              <?php echo $runningEvents; ?> Running
                           </span>
                           <span class="mm-orglist__event-pill mm-orglist__event-pill--completed" title="Completed">
                              <?php echo $completedEvents; ?> Done
                           </span>
                           <span class="mm-orglist__event-pill mm-orglist__event-pill--cancelled" title="Cancelled">
                              <?php echo $cancelledEvents; ?> Cancelled
                           </span>
                        </div>

                        <!-- Status badge -->
                        <div class="mm-orglist__card-badges">
                           <?php if ($isActive) { ?>
                              <span class="mm-orglist__badge mm-orglist__badge--active">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                 Active
                              </span>
                           <?php } else { ?>
                              <span class="mm-orglist__badge mm-orglist__badge--inactive">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                 Inactive
                              </span>
                           <?php } ?>
                           <span class="mm-orglist__badge mm-orglist__badge--earning" title="Remaining Earning">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                              <?php echo $set["currency"] . $remainingEarning; ?> Remaining
                           </span>
                        </div>
                     </div>

                     <!-- Card Actions -->
                     <div class="mm-orglist__card-actions">
                        <a href="add_sponsore.php?id=<?php echo $row['id']; ?>" class="mm-orglist__action-btn mm-orglist__action-btn--edit">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                           Edit
                        </a>
                     </div>
                  </div>
               <?php
                  }
               }
               ?>
            </div>
            <!-- /.mm-orglist__grid -->

         </div>
         <!-- /.mm-orglist -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
// ── Organizer Search + Filter ─────────────────────────────────────
(function() {
   var searchInput = document.getElementById('mmOrgSearch');
   var filterBtns  = document.querySelectorAll('.mm-orglist__filter-btn');
   var grid        = document.getElementById('mmOrgGrid');
   var currentFilter = 'all';

   if (!searchInput || !grid) return;

   function applyFilters() {
      var query = searchInput.value.toLowerCase().trim();
      var cards = grid.querySelectorAll('.mm-orglist__card');
      var visibleCount = 0;

      cards.forEach(function(card) {
         var name   = card.getAttribute('data-org-name') || '';
         var status = card.getAttribute('data-org-status') || '';

         var matchesSearch = !query || name.indexOf(query) !== -1;
         var matchesFilter = currentFilter === 'all' || status === currentFilter;

         if (matchesSearch && matchesFilter) {
            card.style.display = '';
            visibleCount++;
         } else {
            card.style.display = 'none';
         }
      });

      // Dynamic empty state for filtered results
      var existingNoResult = document.getElementById('mmOrgNoResult');
      if (existingNoResult) existingNoResult.remove();

      if (visibleCount === 0 && (query || currentFilter !== 'all')) {
         var noResult = document.createElement('div');
         noResult.id = 'mmOrgNoResult';
         noResult.className = 'mm-orglist__empty';
         noResult.innerHTML = '<div class="mm-orglist__empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><h3 class="mm-orglist__empty-title">No results found</h3><p class="mm-orglist__empty-text">No organizers match your search or filter. Try adjusting your criteria.</p>';
         grid.appendChild(noResult);
      }
   }

   // Search input handler
   searchInput.addEventListener('input', applyFilters);

   // Filter button handlers
   filterBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
         filterBtns.forEach(function(b) {
            b.classList.remove('mm-orglist__filter-btn--active');
         });
         this.classList.add('mm-orglist__filter-btn--active');
         currentFilter = this.getAttribute('data-filter');
         applyFilters();
      });
   });
})();
</script>
<!-- Plugin used-->
</body>
</html>
