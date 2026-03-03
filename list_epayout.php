<?php
   include "filemanager/head.php";

   // ── Gather payout data up front ──────────────────────────────
   $payoutQuery = $evmulti->query(
       "SELECT * FROM `payout_setting` where owner_id=" . $sdata["id"] . ""
   );
   $payouts = [];
   while ($row = $payoutQuery->fetch_assoc()) {
      $payouts[] = $row;
   }

   $totalPayouts   = count($payouts);
   $pendingCount   = 0;
   $completedCount = 0;
   $rejectedCount  = 0;
   $totalAmount    = 0;
   foreach ($payouts as $p) {
      $totalAmount += (float) $p['amt'];
      $status = strtolower($p['status']);
      if ($status === 'completed' || $status === 'complete' || $status === 'approved') {
         $completedCount++;
      } elseif ($status === 'rejected' || $status === 'cancelled') {
         $rejectedCount++;
      } else {
         $pendingCount++;
      }
   }
?>
<link rel="stylesheet" href="assets/css/magicmate-page-epayoutlist.css">
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
              MAGICMATE PAYOUT HISTORY — Custom Layout
              ═══════════════════════════════════════════════════════ -->
         <div class="mm-epayoutlist">

            <!-- ── Page Header ─────────────────────────────── -->
            <header class="mm-epayoutlist__header">
               <div class="mm-epayoutlist__header-left">
                  <h1 class="mm-epayoutlist__title">Payout History</h1>
                  <p class="mm-epayoutlist__subtitle">Track your withdrawal requests and their status.</p>
               </div>
               <div class="mm-epayoutlist__header-actions">
                  <a href="add_payout.php" class="mm-epayoutlist__add-btn">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                     New Request
                  </a>
               </div>
            </header>

            <!-- ── Stats Bar ───────────────────────────────── -->
            <div class="mm-epayoutlist__stats-bar">
               <div class="mm-epayoutlist__stat">
                  <span class="mm-epayoutlist__stat-dot mm-epayoutlist__stat-dot--total"></span>
                  <span class="mm-epayoutlist__stat-value"><?php echo $totalPayouts; ?></span>
                  <span class="mm-epayoutlist__stat-label">Total</span>
               </div>
               <span class="mm-epayoutlist__stat-separator"></span>
               <div class="mm-epayoutlist__stat">
                  <span class="mm-epayoutlist__stat-dot mm-epayoutlist__stat-dot--pending"></span>
                  <span class="mm-epayoutlist__stat-value"><?php echo $pendingCount; ?></span>
                  <span class="mm-epayoutlist__stat-label">Pending</span>
               </div>
               <span class="mm-epayoutlist__stat-separator"></span>
               <div class="mm-epayoutlist__stat">
                  <span class="mm-epayoutlist__stat-dot mm-epayoutlist__stat-dot--completed"></span>
                  <span class="mm-epayoutlist__stat-value"><?php echo $completedCount; ?></span>
                  <span class="mm-epayoutlist__stat-label">Completed</span>
               </div>
               <span class="mm-epayoutlist__stat-separator"></span>
               <div class="mm-epayoutlist__stat">
                  <span class="mm-epayoutlist__stat-dot mm-epayoutlist__stat-dot--amount"></span>
                  <span class="mm-epayoutlist__stat-value"><?php echo number_format((float) $totalAmount, 2, '.', ''); ?></span>
                  <span class="mm-epayoutlist__stat-label"><?php echo $set["currency"]; ?> Requested</span>
               </div>
            </div>

            <!-- ── Toolbar: Search + Filters ─────────────── -->
            <div class="mm-epayoutlist__toolbar">
               <div class="mm-epayoutlist__search-wrap">
                  <span class="mm-epayoutlist__search-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                  </span>
                  <input type="text" class="mm-epayoutlist__search-input" id="mmPayoutSearch" placeholder="Search payouts..." autocomplete="off">
               </div>
               <div class="mm-epayoutlist__filters">
                  <button type="button" class="mm-epayoutlist__filter-btn mm-epayoutlist__filter-btn--active" data-filter="all">
                     All
                     <span class="mm-epayoutlist__filter-count"><?php echo $totalPayouts; ?></span>
                  </button>
                  <button type="button" class="mm-epayoutlist__filter-btn" data-filter="pending">
                     Pending
                     <span class="mm-epayoutlist__filter-count"><?php echo $pendingCount; ?></span>
                  </button>
                  <button type="button" class="mm-epayoutlist__filter-btn" data-filter="completed">
                     Completed
                     <span class="mm-epayoutlist__filter-count"><?php echo $completedCount; ?></span>
                  </button>
               </div>
            </div>

            <!-- ── Hidden DataTable for JS compatibility ─── -->
            <div style="display:none;">
               <table class="display" id="basic-1">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Transfer Photo</th>
                        <th>Amount</th>
                        <th>Transfer Details</th>
                        <th>Transfer Type</th>
                        <th>Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                        $si = 0;
                        foreach ($payouts as $row) {
                           $si++;
                     ?>
                     <tr>
                        <td><?php echo $si; ?></td>
                        <?php if ($row["proof"] == "") { ?>
                        <td></td>
                        <?php } else { ?>
                        <td><img src="<?php echo $row["proof"]; ?>" width="70" height="80" alt=""/></td>
                        <?php } ?>
                        <td><?php echo $row["amt"] . " " . $set["currency"]; ?></td>
                        <?php if ($row["r_type"] == "UPI") { ?>
                        <td><?php echo $row["upi_id"]; ?></td>
                        <?php } elseif ($row["r_type"] == "BANK Transfer") { ?>
                        <td><?php echo "Bank Name: " .
                           $row["bank_name"] .
                           "<br>" .
                           "A/C No: " .
                           $row["acc_number"] .
                           "<br>" .
                           "A/C Name: " .
                           $row["receipt_name"] .
                           "<br>" .
                           "IFSC CODE: " .
                           $row["ifsc"] .
                           "<br>"; ?></td>
                        <?php } else { ?>
                        <td><?php echo $row["paypal_id"]; ?></td>
                        <?php } ?>
                        <td><?php echo $row["r_type"]; ?></td>
                        <td><span class="badge badge-success"><?php echo ucfirst($row["status"]); ?></span></td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>

            <!-- ── Payout Grid ──────────────────────────────── -->
            <div class="mm-epayoutlist__grid" id="mmPayoutGrid">
               <?php if ($totalPayouts === 0) { ?>
                  <!-- Empty State -->
                  <div class="mm-epayoutlist__empty">
                     <div class="mm-epayoutlist__empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                     </div>
                     <h3 class="mm-epayoutlist__empty-title">No payouts yet</h3>
                     <p class="mm-epayoutlist__empty-text">You have not made any payout requests. Submit one to start withdrawing your earnings.</p>
                     <a href="add_payout.php" class="mm-epayoutlist__empty-action">Request Payout</a>
                  </div>
               <?php } else {
                  $i = 0;
                  foreach ($payouts as $row) {
                     $i++;
                     $statusRaw = strtolower($row['status']);
                     if ($statusRaw === 'completed' || $statusRaw === 'complete' || $statusRaw === 'approved') {
                        $statusClass = 'completed';
                        $statusLabel = 'Completed';
                     } elseif ($statusRaw === 'rejected' || $statusRaw === 'cancelled') {
                        $statusClass = 'rejected';
                        $statusLabel = 'Rejected';
                     } else {
                        $statusClass = 'pending';
                        $statusLabel = ucfirst($row['status']);
                     }

                     // Build transfer detail string for search
                     $detailStr = '';
                     if ($row["r_type"] == "UPI") {
                        $detailStr = $row["upi_id"];
                     } elseif ($row["r_type"] == "BANK Transfer") {
                        $detailStr = $row["bank_name"] . ' ' . $row["acc_number"];
                     } else {
                        $detailStr = $row["paypal_id"];
                     }
               ?>
                  <div class="mm-epayoutlist__card"
                       style="--card-index: <?php echo $i; ?>"
                       data-payout-type="<?php echo htmlspecialchars(strtolower($row['r_type'])); ?>"
                       data-payout-status="<?php echo $statusClass; ?>"
                       data-payout-search="<?php echo htmlspecialchars(strtolower($row['amt'] . ' ' . $row['r_type'] . ' ' . $detailStr)); ?>">

                     <!-- Card Top: Amount + Status -->
                     <div class="mm-epayoutlist__card-top">
                        <div class="mm-epayoutlist__card-amount">
                           <span class="mm-epayoutlist__card-currency"><?php echo $set["currency"]; ?></span>
                           <span class="mm-epayoutlist__card-value"><?php echo number_format((float) $row["amt"], 2, '.', ''); ?></span>
                        </div>
                        <span class="mm-epayoutlist__badge mm-epayoutlist__badge--<?php echo $statusClass; ?>">
                           <?php if ($statusClass === 'completed') { ?>
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                           <?php } elseif ($statusClass === 'rejected') { ?>
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                           <?php } else { ?>
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                           <?php } ?>
                           <?php echo $statusLabel; ?>
                        </span>
                     </div>

                     <!-- Card Body: Transfer details -->
                     <div class="mm-epayoutlist__card-body">
                        <!-- Transfer Type -->
                        <div class="mm-epayoutlist__card-row">
                           <span class="mm-epayoutlist__card-row-label">Method</span>
                           <span class="mm-epayoutlist__card-row-value">
                              <span class="mm-epayoutlist__method-tag">
                                 <?php if ($row["r_type"] == "UPI") { ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                                 <?php } elseif ($row["r_type"] == "BANK Transfer") { ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                                 <?php } else { ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                 <?php } ?>
                                 <?php echo htmlspecialchars($row["r_type"]); ?>
                              </span>
                           </span>
                        </div>

                        <!-- Transfer Details -->
                        <div class="mm-epayoutlist__card-row">
                           <span class="mm-epayoutlist__card-row-label">Details</span>
                           <span class="mm-epayoutlist__card-row-value mm-epayoutlist__card-row-value--detail">
                              <?php if ($row["r_type"] == "UPI") { ?>
                                 <?php echo htmlspecialchars($row["upi_id"]); ?>
                              <?php } elseif ($row["r_type"] == "BANK Transfer") { ?>
                                 <span class="mm-epayoutlist__detail-line"><?php echo htmlspecialchars($row["bank_name"]); ?></span>
                                 <span class="mm-epayoutlist__detail-line mm-epayoutlist__detail-line--sub">A/C: <?php echo htmlspecialchars($row["acc_number"]); ?></span>
                                 <span class="mm-epayoutlist__detail-line mm-epayoutlist__detail-line--sub"><?php echo htmlspecialchars($row["receipt_name"]); ?></span>
                              <?php } else { ?>
                                 <?php echo htmlspecialchars($row["paypal_id"]); ?>
                              <?php } ?>
                           </span>
                        </div>
                     </div>

                     <!-- Card Footer: Proof image if available -->
                     <?php if (!empty($row["proof"])) { ?>
                     <div class="mm-epayoutlist__card-footer">
                        <div class="mm-epayoutlist__proof">
                           <img src="<?php echo htmlspecialchars($row["proof"]); ?>" alt="Transfer proof" class="mm-epayoutlist__proof-img" loading="lazy"/>
                           <span class="mm-epayoutlist__proof-label">Transfer Proof</span>
                        </div>
                     </div>
                     <?php } ?>
                  </div>
               <?php
                  }
               }
               ?>
            </div>
            <!-- /.mm-epayoutlist__grid -->

         </div>
         <!-- /.mm-epayoutlist -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
// ── Payout Search + Filter ─────────────────────────────────────
(function() {
   var searchInput = document.getElementById('mmPayoutSearch');
   var filterBtns  = document.querySelectorAll('.mm-epayoutlist__filter-btn');
   var grid        = document.getElementById('mmPayoutGrid');
   var currentFilter = 'all';

   if (!searchInput || !grid) return;

   function applyFilters() {
      var query = searchInput.value.toLowerCase().trim();
      var cards = grid.querySelectorAll('.mm-epayoutlist__card');
      var visibleCount = 0;

      cards.forEach(function(card) {
         var search = card.getAttribute('data-payout-search') || '';
         var status = card.getAttribute('data-payout-status') || '';

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
      var existingNoResult = document.getElementById('mmPayoutNoResult');
      if (existingNoResult) existingNoResult.remove();

      if (visibleCount === 0 && (query || currentFilter !== 'all')) {
         var noResult = document.createElement('div');
         noResult.id = 'mmPayoutNoResult';
         noResult.className = 'mm-epayoutlist__empty';
         noResult.innerHTML = '<div class="mm-epayoutlist__empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><h3 class="mm-epayoutlist__empty-title">No results found</h3><p class="mm-epayoutlist__empty-text">No payouts match your current search or filter. Try adjusting your criteria.</p>';
         grid.appendChild(noResult);
      }
   }

   // Search input handler
   searchInput.addEventListener('input', applyFilters);

   // Filter button handlers
   filterBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
         filterBtns.forEach(function(b) {
            b.classList.remove('mm-epayoutlist__filter-btn--active');
         });
         this.classList.add('mm-epayoutlist__filter-btn--active');
         currentFilter = this.getAttribute('data-filter');
         applyFilters();
      });
   });
})();
</script>
<!-- Plugin used-->
</body>
</html>
