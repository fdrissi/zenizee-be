<?php
   include "filemanager/head.php";

   // ── Gather payment gateway data up front ──────────────────────
   $payQuery = $evmulti->query(
       "SELECT * FROM `tbl_payment_list` WHERE id NOT IN(3,11)"
   );
   $gateways = [];
   while ($row = $payQuery->fetch_assoc()) {
       $gateways[] = $row;
   }

   $totalGateways = count($gateways);
   $activeCount = 0;
   $inactiveCount = 0;
   foreach ($gateways as $gw) {
       if ($gw['status'] == 1) {
           $activeCount++;
       } else {
           $inactiveCount++;
       }
   }
?>
<link rel="stylesheet" href="assets/css/magicmate-page-paylist.css">
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
              ZENIZEE PAYMENT GATEWAY LIST — Custom Layout
              ═══════════════════════════════════════════════════════ -->
         <div class="mm-paylist">

            <!-- ── Page Header ─────────────────────────────── -->
            <header class="mm-paylist__header">
               <div class="mm-paylist__header-left">
                  <h1 class="mm-paylist__title">Payment Gateways</h1>
                  <p class="mm-paylist__subtitle">Configure and manage payment processing integrations for your platform.</p>
               </div>
               <div class="mm-paylist__header-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
               </div>
            </header>

            <!-- ── Info Notice ────────────────────────────── -->
            <div class="mm-paylist__notice">
               <span class="mm-paylist__notice-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
               </span>
               <p class="mm-paylist__notice-text">
                  The <strong>Wallet</strong> and <strong>Free</strong> payment gateways operate in the background and are not listed here. Please do not enable them separately as it may cause processing errors.
               </p>
            </div>

            <!-- ── Stats Bar ───────────────────────────────── -->
            <div class="mm-paylist__stats-bar">
               <div class="mm-paylist__stat">
                  <span class="mm-paylist__stat-dot mm-paylist__stat-dot--total"></span>
                  <span class="mm-paylist__stat-value"><?php echo $totalGateways; ?></span>
                  <span class="mm-paylist__stat-label">Total</span>
               </div>
               <span class="mm-paylist__stat-separator"></span>
               <div class="mm-paylist__stat">
                  <span class="mm-paylist__stat-dot mm-paylist__stat-dot--active"></span>
                  <span class="mm-paylist__stat-value"><?php echo $activeCount; ?></span>
                  <span class="mm-paylist__stat-label">Active</span>
               </div>
               <span class="mm-paylist__stat-separator"></span>
               <div class="mm-paylist__stat">
                  <span class="mm-paylist__stat-dot mm-paylist__stat-dot--inactive"></span>
                  <span class="mm-paylist__stat-value"><?php echo $inactiveCount; ?></span>
                  <span class="mm-paylist__stat-label">Inactive</span>
               </div>
            </div>

            <!-- ── Toolbar: Search + Filters ─────────────── -->
            <div class="mm-paylist__toolbar">
               <div class="mm-paylist__search-wrap">
                  <span class="mm-paylist__search-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                  </span>
                  <input type="text" class="mm-paylist__search-input" id="mmPaySearch" placeholder="Search gateways..." autocomplete="off">
               </div>
               <div class="mm-paylist__filters">
                  <button type="button" class="mm-paylist__filter-btn mm-paylist__filter-btn--active" data-filter="all">
                     All
                     <span class="mm-paylist__filter-count"><?php echo $totalGateways; ?></span>
                  </button>
                  <button type="button" class="mm-paylist__filter-btn" data-filter="active">
                     Active
                     <span class="mm-paylist__filter-count"><?php echo $activeCount; ?></span>
                  </button>
                  <button type="button" class="mm-paylist__filter-btn" data-filter="inactive">
                     Inactive
                     <span class="mm-paylist__filter-count"><?php echo $inactiveCount; ?></span>
                  </button>
               </div>
            </div>

            <!-- ── Gateway Grid ───────────────────────────── -->
            <div class="mm-paylist__grid" id="mmPayGrid">
               <?php if ($totalGateways === 0) { ?>
                  <!-- Empty State -->
                  <div class="mm-paylist__empty">
                     <div class="mm-paylist__empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                     </div>
                     <h3 class="mm-paylist__empty-title">No payment gateways</h3>
                     <p class="mm-paylist__empty-text">No payment gateways are configured. Add one to start accepting payments.</p>
                  </div>
               <?php } else {
                  $i = 0;
                  foreach ($gateways as $gw) {
                     $i++;
                     $isPublished = $gw['status'] == 1;
                     $showOnWallet = $gw['p_show'] == 1;
                     $hasImage = !empty($gw['img']);
               ?>
                  <div class="mm-paylist__card"
                       style="--card-index: <?php echo $i; ?>"
                       data-pay-name="<?php echo htmlspecialchars(strtolower($gw['title'])); ?>"
                       data-pay-status="<?php echo $isPublished ? 'active' : 'inactive'; ?>">

                     <!-- Card Visual — Gateway Logo -->
                     <div class="mm-paylist__card-visual">
                        <?php if ($hasImage) { ?>
                           <img src="<?php echo htmlspecialchars($gw['img']); ?>"
                                alt="<?php echo htmlspecialchars($gw['title']); ?>"
                                class="mm-paylist__card-logo"
                                loading="lazy">
                        <?php } else { ?>
                           <div class="mm-paylist__card-no-logo">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                           </div>
                        <?php } ?>
                        <!-- Status dot -->
                        <span class="mm-paylist__status-dot <?php echo $isPublished ? 'mm-paylist__status-dot--active' : 'mm-paylist__status-dot--inactive'; ?>"></span>
                        <!-- Index -->
                        <span class="mm-paylist__card-index"><?php echo $i; ?></span>
                     </div>

                     <!-- Card Body -->
                     <div class="mm-paylist__card-body">
                        <h3 class="mm-paylist__card-name" title="<?php echo htmlspecialchars($gw['title']); ?>">
                           <?php echo htmlspecialchars($gw['title']); ?>
                        </h3>
                        <?php if (!empty($gw['subtitle'])) { ?>
                           <p class="mm-paylist__card-subtitle" title="<?php echo htmlspecialchars($gw['subtitle']); ?>">
                              <?php echo htmlspecialchars($gw['subtitle']); ?>
                           </p>
                        <?php } else { ?>
                           <p class="mm-paylist__card-subtitle">No description available</p>
                        <?php } ?>
                        <div class="mm-paylist__card-badges">
                           <!-- Status badge -->
                           <?php if ($isPublished) { ?>
                              <span class="mm-paylist__badge mm-paylist__badge--published">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                 Active
                              </span>
                           <?php } else { ?>
                              <span class="mm-paylist__badge mm-paylist__badge--unpublished">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                 Inactive
                              </span>
                           <?php } ?>
                           <!-- Wallet visibility badge -->
                           <?php if ($showOnWallet) { ?>
                              <span class="mm-paylist__badge mm-paylist__badge--wallet-on">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4z"/></svg>
                                 Wallet
                              </span>
                           <?php } else { ?>
                              <span class="mm-paylist__badge mm-paylist__badge--wallet-off">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4z"/></svg>
                                 No Wallet
                              </span>
                           <?php } ?>
                        </div>
                     </div>

                     <!-- Card Actions -->
                     <div class="mm-paylist__card-actions">
                        <a href="edit_payment.php?id=<?php echo $gw['id']; ?>" class="mm-paylist__action-btn mm-paylist__action-btn--edit">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                           Configure
                        </a>
                     </div>
                  </div>
               <?php
                  }
               }
               ?>
            </div>
            <!-- /.mm-paylist__grid -->

         </div>
         <!-- /.mm-paylist -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
// ── Payment Gateway Search + Filter ─────────────────────────────
(function() {
   var searchInput = document.getElementById('mmPaySearch');
   var filterBtns = document.querySelectorAll('.mm-paylist__filter-btn');
   var grid = document.getElementById('mmPayGrid');
   var currentFilter = 'all';

   if (!searchInput || !grid) return;

   function applyFilters() {
      var query = searchInput.value.toLowerCase().trim();
      var cards = grid.querySelectorAll('.mm-paylist__card');
      var visibleCount = 0;

      cards.forEach(function(card) {
         var name = card.getAttribute('data-pay-name') || '';
         var status = card.getAttribute('data-pay-status') || '';

         var matchesSearch = !query || name.indexOf(query) !== -1;
         var matchesFilter = currentFilter === 'all' || status === currentFilter;

         if (matchesSearch && matchesFilter) {
            card.style.display = '';
            visibleCount++;
         } else {
            card.style.display = 'none';
         }
      });

      // Handle empty state for filtered results
      var existingNoResult = document.getElementById('mmPayNoResult');
      if (existingNoResult) existingNoResult.remove();

      if (visibleCount === 0 && (query || currentFilter !== 'all')) {
         var noResult = document.createElement('div');
         noResult.id = 'mmPayNoResult';
         noResult.className = 'mm-paylist__empty';
         noResult.innerHTML = '<div class="mm-paylist__empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><h3 class="mm-paylist__empty-title">No results found</h3><p class="mm-paylist__empty-text">No payment gateways match your current search or filter. Try adjusting your criteria.</p>';
         grid.appendChild(noResult);
      }
   }

   // Search input handler
   searchInput.addEventListener('input', applyFilters);

   // Filter button handlers
   filterBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
         // Remove active class from all
         filterBtns.forEach(function(b) {
            b.classList.remove('mm-paylist__filter-btn--active');
         });
         // Add active to clicked
         this.classList.add('mm-paylist__filter-btn--active');
         currentFilter = this.getAttribute('data-filter');
         applyFilters();
      });
   });
})();
</script>
<!-- Plugin used-->
</body>
</html>
