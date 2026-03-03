<?php
   include "filemanager/head.php";

   // ── Gather coupon data up front ──────────────────────────────
   $couponQuery = $evmulti->query(
       "SELECT * FROM tbl_coupon WHERE sponsore_id=" .
           $sdata["id"] .
           " ORDER BY id DESC"
   );
   $coupons = [];
   while ($row = $couponQuery->fetch_assoc()) {
      $coupons[] = $row;
   }

   $totalCoupons  = count($coupons);
   $activeCount   = 0;
   $inactiveCount = 0;
   foreach ($coupons as $c) {
      if ($c['status'] == 1) {
         $activeCount++;
      } else {
         $inactiveCount++;
      }
   }
?>
<link rel="stylesheet" href="assets/css/magicmate-page-couponlist.css">
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
              MAGICMATE COUPON LIST — Custom Layout
              ═══════════════════════════════════════════════════════ -->
         <div class="mm-couponlist">

            <!-- ── Page Header ─────────────────────────────── -->
            <header class="mm-couponlist__header">
               <div class="mm-couponlist__header-left">
                  <a href="list_event.php" class="mm-couponlist__back-link">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                     Back to Events
                  </a>
                  <h1 class="mm-couponlist__title">Coupons</h1>
                  <p class="mm-couponlist__subtitle">Create and manage discount coupons for your events.</p>
               </div>
               <div class="mm-couponlist__header-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0 0 4h4v-4h-4z"/></svg>
               </div>
            </header>

            <!-- ── Stats Bar ───────────────────────────────── -->
            <div class="mm-couponlist__stats-bar">
               <div class="mm-couponlist__stat">
                  <span class="mm-couponlist__stat-dot mm-couponlist__stat-dot--total"></span>
                  <span class="mm-couponlist__stat-value"><?php echo $totalCoupons; ?></span>
                  <span class="mm-couponlist__stat-label">Total Coupons</span>
               </div>
               <span class="mm-couponlist__stat-separator"></span>
               <div class="mm-couponlist__stat">
                  <span class="mm-couponlist__stat-dot mm-couponlist__stat-dot--active"></span>
                  <span class="mm-couponlist__stat-value"><?php echo $activeCount; ?></span>
                  <span class="mm-couponlist__stat-label">Active</span>
               </div>
               <span class="mm-couponlist__stat-separator"></span>
               <div class="mm-couponlist__stat">
                  <span class="mm-couponlist__stat-dot mm-couponlist__stat-dot--inactive"></span>
                  <span class="mm-couponlist__stat-value"><?php echo $inactiveCount; ?></span>
                  <span class="mm-couponlist__stat-label">Inactive</span>
               </div>
            </div>

            <!-- ── Toolbar: Search + Filters ─────────────── -->
            <div class="mm-couponlist__toolbar">
               <div class="mm-couponlist__search-wrap">
                  <span class="mm-couponlist__search-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                  </span>
                  <input type="text" class="mm-couponlist__search-input" id="mmCouponSearch" placeholder="Search coupons..." autocomplete="off">
               </div>
               <div class="mm-couponlist__filters">
                  <button type="button" class="mm-couponlist__filter-btn mm-couponlist__filter-btn--active" data-filter="all">
                     All
                     <span class="mm-couponlist__filter-count"><?php echo $totalCoupons; ?></span>
                  </button>
                  <button type="button" class="mm-couponlist__filter-btn" data-filter="active">
                     Active
                     <span class="mm-couponlist__filter-count"><?php echo $activeCount; ?></span>
                  </button>
                  <button type="button" class="mm-couponlist__filter-btn" data-filter="inactive">
                     Inactive
                     <span class="mm-couponlist__filter-count"><?php echo $inactiveCount; ?></span>
                  </button>
               </div>
            </div>

            <!-- ── Coupon Grid ──────────────────────────────── -->
            <div class="mm-couponlist__grid" id="mmCouponGrid">
               <?php if ($totalCoupons === 0) { ?>
                  <!-- Empty State -->
                  <div class="mm-couponlist__empty">
                     <div class="mm-couponlist__empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0 0 4h4v-4h-4z"/></svg>
                     </div>
                     <h3 class="mm-couponlist__empty-title">No coupons yet</h3>
                     <p class="mm-couponlist__empty-text">You haven't created any coupons. Add one to offer discounts to your attendees.</p>
                  </div>
               <?php } else {
                  $i = 0;
                  foreach ($coupons as $row) {
                     $i++;
                     $isActive  = $row['status'] == 1;
                     $hasImage  = !empty($row['coupon_img']);
                     $expiryDate = date_format(date_create($row["cdate"]), "d-m-Y");
                     $searchable = strtolower($row['title'] . ' ' . $row['coupon_code']);
               ?>
                  <div class="mm-couponlist__card"
                       style="--card-index: <?php echo $i; ?>"
                       data-coupon-search="<?php echo htmlspecialchars($searchable); ?>"
                       data-coupon-status="<?php echo $isActive ? 'active' : 'inactive'; ?>">

                     <!-- Coupon Voucher Top — decorative edge -->
                     <div class="mm-couponlist__card-top">
                        <!-- Coupon Image / Visual -->
                        <div class="mm-couponlist__card-visual">
                           <?php if ($hasImage) { ?>
                              <img src="<?php echo htmlspecialchars($row['coupon_img']); ?>"
                                   alt="<?php echo htmlspecialchars($row['title']); ?>"
                                   class="mm-couponlist__card-image"
                                   loading="lazy">
                           <?php } else { ?>
                              <div class="mm-couponlist__card-no-image">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0 0 4h4v-4h-4z"/></svg>
                              </div>
                           <?php } ?>
                        </div>

                        <!-- Status badge -->
                        <?php if ($isActive) { ?>
                           <span class="mm-couponlist__badge mm-couponlist__badge--active">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                              Published
                           </span>
                        <?php } else { ?>
                           <span class="mm-couponlist__badge mm-couponlist__badge--inactive">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                              Unpublished
                           </span>
                        <?php } ?>
                     </div>

                     <!-- Card Body -->
                     <div class="mm-couponlist__card-body">
                        <h3 class="mm-couponlist__card-title" title="<?php echo htmlspecialchars($row['title']); ?>">
                           <?php echo htmlspecialchars($row['title']); ?>
                        </h3>
                        <?php if (!empty($row['subtitle'])) { ?>
                           <p class="mm-couponlist__card-subtitle"><?php echo htmlspecialchars($row['subtitle']); ?></p>
                        <?php } ?>

                        <!-- Coupon Code — prominent display -->
                        <div class="mm-couponlist__code-wrap">
                           <span class="mm-couponlist__code-label">Code</span>
                           <span class="mm-couponlist__code"><?php echo htmlspecialchars($row['coupon_code']); ?></span>
                        </div>
                     </div>

                     <!-- Perforation divider -->
                     <div class="mm-couponlist__perforation"></div>

                     <!-- Card Footer — Details + Action -->
                     <div class="mm-couponlist__card-footer">
                        <div class="mm-couponlist__details">
                           <div class="mm-couponlist__detail">
                              <span class="mm-couponlist__detail-label">Discount</span>
                              <span class="mm-couponlist__detail-value mm-couponlist__detail-value--discount"><?php echo htmlspecialchars($row['coupon_val']); ?></span>
                           </div>
                           <div class="mm-couponlist__detail">
                              <span class="mm-couponlist__detail-label">Min. Order</span>
                              <span class="mm-couponlist__detail-value"><?php echo htmlspecialchars($row['min_amt']); ?></span>
                           </div>
                           <div class="mm-couponlist__detail">
                              <span class="mm-couponlist__detail-label">Expires</span>
                              <span class="mm-couponlist__detail-value"><?php echo $expiryDate; ?></span>
                           </div>
                        </div>
                        <div class="mm-couponlist__card-actions">
                           <a href="add_coupon.php?id=<?php echo $row['id']; ?>" class="mm-couponlist__action-btn mm-couponlist__action-btn--edit">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                              Edit
                           </a>
                        </div>
                     </div>
                  </div>
               <?php
                  }
               }
               ?>
            </div>
            <!-- /.mm-couponlist__grid -->

            <!-- ── Hidden DataTable for JS compatibility ──── -->
            <div style="display:none;">
               <table class="display" id="basic-1">
                  <thead>
                     <tr>
                        <th>Sr No.</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Code</th>
                        <th>Expired Date</th>
                        <th>Min Amount</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                        $i2 = 0;
                        foreach ($coupons as $row) {
                           $i2++;
                     ?>
                     <tr>
                        <td><?php echo $i2; ?></td>
                        <td class="align-middle">
                           <img src="<?php echo $row["coupon_img"]; ?>" width="60" height="60" alt=""/>
                        </td>
                        <td><?php echo $row["title"]; ?></td>
                        <td><?php echo $row["subtitle"]; ?></td>
                        <td><?php echo $row["coupon_code"]; ?></td>
                        <td><?php
                           $date = date_create($row["cdate"]);
                           echo date_format($date, "d-m-Y");
                        ?></td>
                        <td><?php echo $row["min_amt"]; ?></td>
                        <td><?php echo $row["coupon_val"]; ?></td>
                        <?php if ($row["status"] == 1) { ?>
                        <td><span class="badge badge-success">Publish</span></td>
                        <?php } else { ?>
                        <td><span class="badge badge-danger">Unpublish</span></td>
                        <?php } ?>
                        <td style="white-space: nowrap; width: 15%;">
                           <div class="tabledit-toolbar btn-toolbar" style="text-align: left;">
                              <div class="btn-group btn-group-sm" style="float: none;">
                                 <a href="add_coupon.php?id=<?php echo $row["id"]; ?>" class="badge badge-info"><i data-feather="edit-3"></i></a>
                              </div>
                           </div>
                        </td>
                     </tr>
                     <?php
                        }
                     ?>
                  </tbody>
               </table>
            </div>

         </div>
         <!-- /.mm-couponlist -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
// ── Coupon Search + Filter ─────────────────────────────────────
(function() {
   var searchInput = document.getElementById('mmCouponSearch');
   var filterBtns  = document.querySelectorAll('.mm-couponlist__filter-btn');
   var grid        = document.getElementById('mmCouponGrid');
   var currentFilter = 'all';

   if (!searchInput || !grid) return;

   function applyFilters() {
      var query = searchInput.value.toLowerCase().trim();
      var cards = grid.querySelectorAll('.mm-couponlist__card');
      var visibleCount = 0;

      cards.forEach(function(card) {
         var search = card.getAttribute('data-coupon-search') || '';
         var status = card.getAttribute('data-coupon-status') || '';

         var matchesSearch = !query || search.indexOf(query) !== -1;
         var matchesFilter = currentFilter === 'all' || status === currentFilter;

         if (matchesSearch && matchesFilter) {
            card.style.display = '';
            visibleCount++;
         } else {
            card.style.display = 'none';
         }
      });

      // Handle empty state for filtered results
      var existingNoResult = document.getElementById('mmCouponNoResult');
      if (existingNoResult) existingNoResult.remove();

      if (visibleCount === 0 && (query || currentFilter !== 'all')) {
         var noResult = document.createElement('div');
         noResult.id = 'mmCouponNoResult';
         noResult.className = 'mm-couponlist__empty';
         noResult.innerHTML = '<div class="mm-couponlist__empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><h3 class="mm-couponlist__empty-title">No results found</h3><p class="mm-couponlist__empty-text">No coupons match your current search or filter. Try adjusting your criteria.</p>';
         grid.appendChild(noResult);
      }
   }

   // Search input handler
   searchInput.addEventListener('input', applyFilters);

   // Filter button handlers
   filterBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
         filterBtns.forEach(function(b) {
            b.classList.remove('mm-couponlist__filter-btn--active');
         });
         this.classList.add('mm-couponlist__filter-btn--active');
         currentFilter = this.getAttribute('data-filter');
         applyFilters();
      });
   });
})();
</script>
<!-- Plugin used-->
</body>
</html>
