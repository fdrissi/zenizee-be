<?php
   include "filemanager/head.php";

   // ── Gather payout data up front ──────────────────────────────
   $payoutQuery = $evmulti->query(
       "SELECT * FROM `payout_setting` ORDER BY id DESC"
   );
   $payouts = [];
   while ($row = $payoutQuery->fetch_assoc()) {
       $payouts[] = $row;
   }

   $totalPayouts = count($payouts);
   $pendingCount = 0;
   $completedCount = 0;
   foreach ($payouts as $p) {
       if ($p['status'] == 'pending') {
           $pendingCount++;
       } else {
           $completedCount++;
       }
   }
?>
<link rel="stylesheet" href="assets/css/zenizee-page-payoutlist.css">
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
              ZENIZEE PAYOUT LIST — Custom Layout
              ═══════════════════════════════════════════════════════ -->
         <div class="mm-payoutlist">

            <!-- ── Page Header ─────────────────────────────── -->
            <header class="mm-payoutlist__header">
               <div class="mm-payoutlist__header-left">
                  <h1 class="mm-payoutlist__title">Payouts</h1>
                  <p class="mm-payoutlist__subtitle">Manage organizer payout requests and transfer proofs.</p>
               </div>
               <div class="mm-payoutlist__header-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/><line x1="8" y1="14" x2="8.01" y2="14"/><line x1="12" y1="14" x2="16" y2="14"/></svg>
               </div>
            </header>

            <!-- ── Proof Upload Panel (when ?payout= is set) ─── -->
            <?php if (isset($_GET["payout"])) { ?>
            <div class="mm-payoutlist__upload-panel">
               <div class="mm-payoutlist__upload-panel-header">
                  <div class="mm-payoutlist__upload-panel-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                  </div>
                  <div class="mm-payoutlist__upload-panel-text">
                     <h2 class="mm-payoutlist__upload-panel-title">Complete Payout #<?php echo htmlspecialchars($_GET["payout"]); ?></h2>
                     <p class="mm-payoutlist__upload-panel-desc">Upload a proof or receipt image to mark this payout as completed.</p>
                  </div>
               </div>
               <form class="mm-payoutlist__upload-form" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="type" value="com_payout">
                  <input type="hidden" name="payout_id" value="<?php echo htmlspecialchars($_GET["payout"]); ?>"/>

                  <div class="mm-payoutlist__upload-area" id="mmPayoutDropZone">
                     <input type="file" name="cat_img" class="mm-payoutlist__upload-input" id="mmPayoutFileInput" accept="image/*" required>
                     <div class="mm-payoutlist__upload-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                     </div>
                     <p class="mm-payoutlist__upload-label"><span>Choose file</span> or drag here</p>
                     <p class="mm-payoutlist__upload-hint">PNG, JPG or PDF — proof of payment transfer</p>
                  </div>

                  <div class="mm-payoutlist__upload-actions">
                     <button type="submit" class="mm-payoutlist__upload-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Mark as Completed
                     </button>
                     <a href="list_payout.php" class="mm-payoutlist__upload-cancel">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Cancel
                     </a>
                  </div>
               </form>
            </div>
            <?php } ?>

            <!-- ── Stats Bar ───────────────────────────────── -->
            <div class="mm-payoutlist__stats-bar">
               <div class="mm-payoutlist__stat">
                  <span class="mm-payoutlist__stat-dot mm-payoutlist__stat-dot--total"></span>
                  <span class="mm-payoutlist__stat-value"><?php echo $totalPayouts; ?></span>
                  <span class="mm-payoutlist__stat-label">Total</span>
               </div>
               <span class="mm-payoutlist__stat-separator"></span>
               <div class="mm-payoutlist__stat">
                  <span class="mm-payoutlist__stat-dot mm-payoutlist__stat-dot--pending"></span>
                  <span class="mm-payoutlist__stat-value"><?php echo $pendingCount; ?></span>
                  <span class="mm-payoutlist__stat-label">Pending</span>
               </div>
               <span class="mm-payoutlist__stat-separator"></span>
               <div class="mm-payoutlist__stat">
                  <span class="mm-payoutlist__stat-dot mm-payoutlist__stat-dot--completed"></span>
                  <span class="mm-payoutlist__stat-value"><?php echo $completedCount; ?></span>
                  <span class="mm-payoutlist__stat-label">Completed</span>
               </div>
            </div>

            <!-- ── Toolbar: Search + Filters ─────────────── -->
            <div class="mm-payoutlist__toolbar">
               <div class="mm-payoutlist__search-wrap">
                  <span class="mm-payoutlist__search-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                  </span>
                  <input type="text" class="mm-payoutlist__search-input" id="mmPayoutSearch" placeholder="Search by organizer or amount..." autocomplete="off">
               </div>
               <div class="mm-payoutlist__filters">
                  <button type="button" class="mm-payoutlist__filter-btn mm-payoutlist__filter-btn--active" data-filter="all">
                     All
                     <span class="mm-payoutlist__filter-count"><?php echo $totalPayouts; ?></span>
                  </button>
                  <button type="button" class="mm-payoutlist__filter-btn" data-filter="pending">
                     Pending
                     <span class="mm-payoutlist__filter-count"><?php echo $pendingCount; ?></span>
                  </button>
                  <button type="button" class="mm-payoutlist__filter-btn" data-filter="completed">
                     Completed
                     <span class="mm-payoutlist__filter-count"><?php echo $completedCount; ?></span>
                  </button>
               </div>
            </div>

            <!-- ── Payout Card Grid ────────────────────────── -->
            <div class="mm-payoutlist__grid" id="mmPayoutGrid">
               <?php if ($totalPayouts === 0) { ?>
                  <!-- Empty State -->
                  <div class="mm-payoutlist__empty">
                     <div class="mm-payoutlist__empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                     </div>
                     <h3 class="mm-payoutlist__empty-title">No payout requests</h3>
                     <p class="mm-payoutlist__empty-text">There are no payout requests from organizers yet. They will appear here once submitted.</p>
                  </div>
               <?php } else {
                  $i = 0;
                  foreach ($payouts as $row) {
                     $i++;
                     $vdetails = $evmulti
                         ->query(
                             "select * from tbl_sponsore where id=" . $row["owner_id"] . ""
                         )
                         ->fetch_assoc();
                     $isPending = ($row["status"] == 'pending');
                     $hasProof = !empty($row["proof"]);

                     // Transfer type label and modifier
                     $rtype = $row["r_type"];
                     if ($rtype == "UPI") {
                         $typeMod = 'upi';
                     } elseif ($rtype == "BANK Transfer") {
                         $typeMod = 'bank';
                     } else {
                         $typeMod = 'paypal';
                     }
               ?>
                  <div class="mm-payoutlist__card"
                       style="--card-index: <?php echo $i; ?>"
                       data-payout-name="<?php echo htmlspecialchars(strtolower($vdetails["title"] . " " . $row["amt"])); ?>"
                       data-payout-status="<?php echo $isPending ? 'pending' : 'completed'; ?>">

                     <!-- Card Visual — Amount + Transfer Type -->
                     <div class="mm-payoutlist__card-visual">
                        <div class="mm-payoutlist__card-amount">
                           <span class="mm-payoutlist__card-currency"><?php echo htmlspecialchars($set["currency"]); ?></span>
                           <span class="mm-payoutlist__card-amt-value"><?php echo htmlspecialchars($row["amt"]); ?></span>
                        </div>
                        <span class="mm-payoutlist__type-badge mm-payoutlist__type-badge--<?php echo $typeMod; ?>">
                           <?php if ($rtype == "UPI") { ?>
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                           <?php } elseif ($rtype == "BANK Transfer") { ?>
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                           <?php } else { ?>
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37"/><path d="M7 19c2.667 1.333 6.667 1.333 9.333 0"/></svg>
                           <?php } ?>
                           <?php echo htmlspecialchars($rtype); ?>
                        </span>
                        <!-- Status indicator dot -->
                        <span class="mm-payoutlist__status-dot <?php echo $isPending ? 'mm-payoutlist__status-dot--pending' : 'mm-payoutlist__status-dot--completed'; ?>"></span>
                        <!-- Index -->
                        <span class="mm-payoutlist__card-index"><?php echo $i; ?></span>
                     </div>

                     <!-- Card Body -->
                     <div class="mm-payoutlist__card-body">

                        <!-- Organizer -->
                        <div class="mm-payoutlist__organizer">
                           <span class="mm-payoutlist__organizer-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                           </span>
                           <span class="mm-payoutlist__organizer-name"><?php echo htmlspecialchars($vdetails["title"]); ?></span>
                        </div>

                        <!-- Transfer Details -->
                        <div class="mm-payoutlist__transfer-details">
                           <?php if ($row["r_type"] == "UPI") { ?>
                              <div class="mm-payoutlist__detail-row">
                                 <span class="mm-payoutlist__detail-key">UPI ID</span>
                                 <span class="mm-payoutlist__detail-val"><?php echo htmlspecialchars($row["upi_id"]); ?></span>
                              </div>
                           <?php } elseif ($row["r_type"] == "BANK Transfer") { ?>
                              <div class="mm-payoutlist__detail-row">
                                 <span class="mm-payoutlist__detail-key">Bank Name</span>
                                 <span class="mm-payoutlist__detail-val"><?php echo htmlspecialchars($row["bank_name"]); ?></span>
                              </div>
                              <div class="mm-payoutlist__detail-row">
                                 <span class="mm-payoutlist__detail-key">A/C Number</span>
                                 <span class="mm-payoutlist__detail-val"><?php echo htmlspecialchars($row["acc_number"]); ?></span>
                              </div>
                              <div class="mm-payoutlist__detail-row">
                                 <span class="mm-payoutlist__detail-key">A/C Name</span>
                                 <span class="mm-payoutlist__detail-val"><?php echo htmlspecialchars($row["acc_name"]); ?></span>
                              </div>
                              <div class="mm-payoutlist__detail-row">
                                 <span class="mm-payoutlist__detail-key">IFSC Code</span>
                                 <span class="mm-payoutlist__detail-val"><?php echo htmlspecialchars($row["ifsc"]); ?></span>
                              </div>
                           <?php } else { ?>
                              <div class="mm-payoutlist__detail-row">
                                 <span class="mm-payoutlist__detail-key">PayPal ID</span>
                                 <span class="mm-payoutlist__detail-val"><?php echo htmlspecialchars($row["paypal_id"]); ?></span>
                              </div>
                           <?php } ?>
                           <div class="mm-payoutlist__detail-row">
                              <span class="mm-payoutlist__detail-key">Mobile</span>
                              <span class="mm-payoutlist__detail-val"><?php echo htmlspecialchars($vdetails["ccode"] . $vdetails["mobile"]); ?></span>
                           </div>
                        </div>

                        <!-- Status + Proof thumbnail row -->
                        <div class="mm-payoutlist__card-meta">
                           <?php if ($isPending) { ?>
                              <span class="mm-payoutlist__badge mm-payoutlist__badge--pending">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                 Pending
                              </span>
                           <?php } else { ?>
                              <span class="mm-payoutlist__badge mm-payoutlist__badge--completed">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                 Completed
                              </span>
                           <?php } ?>
                           <?php if ($hasProof) { ?>
                              <div class="mm-payoutlist__proof-thumb">
                                 <img src="<?php echo htmlspecialchars($row["proof"]); ?>" alt="Proof" loading="lazy">
                                 <span class="mm-payoutlist__proof-label">Proof</span>
                              </div>
                           <?php } ?>
                        </div>

                     </div>

                     <!-- Card Actions -->
                     <div class="mm-payoutlist__card-actions">
                        <?php if ($isPending) { ?>
                           <a href="list_payout.php?payout=<?php echo $row["id"]; ?>" class="mm-payoutlist__action-btn mm-payoutlist__action-btn--process">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                              Process Payout
                           </a>
                        <?php } else { ?>
                           <span class="mm-payoutlist__action-btn mm-payoutlist__action-btn--done">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                              Completed
                           </span>
                        <?php } ?>
                     </div>

                  </div>
               <?php
                  }
               }
               ?>
            </div>
            <!-- /.mm-payoutlist__grid -->

         </div>
         <!-- /.mm-payoutlist -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
// ── Payout Search + Filter ───────────────────────────────────────
(function() {
   var searchInput = document.getElementById('mmPayoutSearch');
   var filterBtns = document.querySelectorAll('.mm-payoutlist__filter-btn');
   var grid = document.getElementById('mmPayoutGrid');
   var currentFilter = 'all';

   if (!searchInput || !grid) return;

   function applyFilters() {
      var query = searchInput.value.toLowerCase().trim();
      var cards = grid.querySelectorAll('.mm-payoutlist__card');
      var visibleCount = 0;

      cards.forEach(function(card) {
         var name = card.getAttribute('data-payout-name') || '';
         var status = card.getAttribute('data-payout-status') || '';

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
      var existingNoResult = document.getElementById('mmPayoutNoResult');
      if (existingNoResult) existingNoResult.remove();

      if (visibleCount === 0 && (query || currentFilter !== 'all')) {
         var noResult = document.createElement('div');
         noResult.id = 'mmPayoutNoResult';
         noResult.className = 'mm-payoutlist__empty';
         noResult.innerHTML = '<div class="mm-payoutlist__empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><h3 class="mm-payoutlist__empty-title">No results found</h3><p class="mm-payoutlist__empty-text">No payout requests match your current search or filter. Try adjusting your criteria.</p>';
         grid.appendChild(noResult);
      }
   }

   // Search input handler
   searchInput.addEventListener('input', applyFilters);

   // Filter button handlers
   filterBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
         filterBtns.forEach(function(b) {
            b.classList.remove('mm-payoutlist__filter-btn--active');
         });
         this.classList.add('mm-payoutlist__filter-btn--active');
         currentFilter = this.getAttribute('data-filter');
         applyFilters();
      });
   });

   // ── Drag-and-drop upload zone ──────────────────────────────
   var dropZone = document.getElementById('mmPayoutDropZone');
   var fileInput = document.getElementById('mmPayoutFileInput');

   if (dropZone && fileInput) {
      dropZone.addEventListener('click', function(e) {
         if (e.target !== fileInput) fileInput.click();
      });

      dropZone.addEventListener('dragover', function(e) {
         e.preventDefault();
         dropZone.classList.add('mm-payoutlist__upload-area--drag');
      });

      dropZone.addEventListener('dragleave', function() {
         dropZone.classList.remove('mm-payoutlist__upload-area--drag');
      });

      dropZone.addEventListener('drop', function(e) {
         e.preventDefault();
         dropZone.classList.remove('mm-payoutlist__upload-area--drag');
         var files = e.dataTransfer.files;
         if (files.length > 0) {
            fileInput.files = files;
            var label = dropZone.querySelector('.mm-payoutlist__upload-label');
            if (label) label.innerHTML = '<span>' + files[0].name + '</span>';
         }
      });

      fileInput.addEventListener('change', function() {
         if (fileInput.files.length > 0) {
            var label = dropZone.querySelector('.mm-payoutlist__upload-label');
            if (label) label.innerHTML = '<span>' + fileInput.files[0].name + '</span>';
         }
      });
   }
})();
</script>
<!-- Plugin used-->
</body>
</html>
