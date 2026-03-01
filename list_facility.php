<?php
   include "filemanager/head.php";

   // ── Gather facility data up front ──────────────────────────────
   $facQuery = $evmulti->query("SELECT * FROM `tbl_facility`");
   $facilities = [];
   while ($row = $facQuery->fetch_assoc()) {
      $facilities[] = $row;
   }

   $totalFacilities = count($facilities);
   $activeCount     = 0;
   $inactiveCount   = 0;
   foreach ($facilities as $fac) {
      if ($fac['status'] == 1) {
         $activeCount++;
      } else {
         $inactiveCount++;
      }
   }
?>
<link rel="stylesheet" href="assets/css/magicmate-page-facilitylist.css">
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
              MAGICMATE FACILITY LIST — Custom Layout
              ═══════════════════════════════════════════════════════ -->
         <div class="mm-facilitylist">

            <!-- ── Page Header ─────────────────────────────── -->
            <header class="mm-facilitylist__header">
               <div class="mm-facilitylist__header-left">
                  <h1 class="mm-facilitylist__title">Facilities</h1>
                  <p class="mm-facilitylist__subtitle">Manage event facilities available to organizers.</p>
               </div>
               <div class="mm-facilitylist__header-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
               </div>
            </header>

            <!-- ── Stats Bar ───────────────────────────────── -->
            <div class="mm-facilitylist__stats-bar">
               <div class="mm-facilitylist__stat">
                  <span class="mm-facilitylist__stat-dot mm-facilitylist__stat-dot--total"></span>
                  <span class="mm-facilitylist__stat-value"><?php echo $totalFacilities; ?></span>
                  <span class="mm-facilitylist__stat-label">Total</span>
               </div>
               <span class="mm-facilitylist__stat-separator"></span>
               <div class="mm-facilitylist__stat">
                  <span class="mm-facilitylist__stat-dot mm-facilitylist__stat-dot--active"></span>
                  <span class="mm-facilitylist__stat-value"><?php echo $activeCount; ?></span>
                  <span class="mm-facilitylist__stat-label">Active</span>
               </div>
               <span class="mm-facilitylist__stat-separator"></span>
               <div class="mm-facilitylist__stat">
                  <span class="mm-facilitylist__stat-dot mm-facilitylist__stat-dot--inactive"></span>
                  <span class="mm-facilitylist__stat-value"><?php echo $inactiveCount; ?></span>
                  <span class="mm-facilitylist__stat-label">Inactive</span>
               </div>
            </div>

            <!-- ── Toolbar: Search + Filters ─────────────── -->
            <div class="mm-facilitylist__toolbar">
               <div class="mm-facilitylist__search-wrap">
                  <span class="mm-facilitylist__search-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                  </span>
                  <input type="text" class="mm-facilitylist__search-input" id="mmFacilitySearch" placeholder="Search facilities..." autocomplete="off">
               </div>
               <div class="mm-facilitylist__filters">
                  <button type="button" class="mm-facilitylist__filter-btn mm-facilitylist__filter-btn--active" data-filter="all">
                     All
                     <span class="mm-facilitylist__filter-count"><?php echo $totalFacilities; ?></span>
                  </button>
                  <button type="button" class="mm-facilitylist__filter-btn" data-filter="active">
                     Active
                     <span class="mm-facilitylist__filter-count"><?php echo $activeCount; ?></span>
                  </button>
                  <button type="button" class="mm-facilitylist__filter-btn" data-filter="inactive">
                     Inactive
                     <span class="mm-facilitylist__filter-count"><?php echo $inactiveCount; ?></span>
                  </button>
               </div>
            </div>

            <!-- ── Facility Grid ──────────────────────────── -->
            <div class="mm-facilitylist__grid" id="mmFacilityGrid">
               <?php if ($totalFacilities === 0) { ?>
                  <!-- Empty State -->
                  <div class="mm-facilitylist__empty">
                     <div class="mm-facilitylist__empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                     </div>
                     <h3 class="mm-facilitylist__empty-title">No facilities yet</h3>
                     <p class="mm-facilitylist__empty-text">No facilities have been added. Create one to make it available to organizers.</p>
                  </div>
               <?php } else {
                  $i = 0;
                  foreach ($facilities as $fac) {
                     $i++;
                     $isActive = $fac['status'] == 1;
                     $hasImage = !empty($fac['img']);
               ?>
                  <div class="mm-facilitylist__card"
                       style="--card-index: <?php echo $i; ?>"
                       data-facility-name="<?php echo htmlspecialchars(strtolower($fac['title'])); ?>"
                       data-facility-status="<?php echo $isActive ? 'active' : 'inactive'; ?>">

                     <!-- Card Visual — Facility Image -->
                     <div class="mm-facilitylist__card-visual">
                        <?php if ($hasImage) { ?>
                           <img src="<?php echo htmlspecialchars($fac['img']); ?>"
                                alt="<?php echo htmlspecialchars($fac['title']); ?>"
                                class="mm-facilitylist__card-image"
                                loading="lazy">
                        <?php } else { ?>
                           <div class="mm-facilitylist__card-no-image">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                           </div>
                        <?php } ?>
                        <!-- Status dot -->
                        <span class="mm-facilitylist__status-dot <?php echo $isActive ? 'mm-facilitylist__status-dot--active' : 'mm-facilitylist__status-dot--inactive'; ?>"></span>
                        <!-- Index -->
                        <span class="mm-facilitylist__card-index"><?php echo $i; ?></span>
                     </div>

                     <!-- Card Body -->
                     <div class="mm-facilitylist__card-body">
                        <h3 class="mm-facilitylist__card-name" title="<?php echo htmlspecialchars($fac['title']); ?>">
                           <?php echo htmlspecialchars($fac['title']); ?>
                        </h3>
                        <div class="mm-facilitylist__card-badges">
                           <?php if ($isActive) { ?>
                              <span class="mm-facilitylist__badge mm-facilitylist__badge--active">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                 Active
                              </span>
                           <?php } else { ?>
                              <span class="mm-facilitylist__badge mm-facilitylist__badge--inactive">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                 Inactive
                              </span>
                           <?php } ?>
                        </div>
                     </div>

                     <!-- Card Actions -->
                     <div class="mm-facilitylist__card-actions">
                        <a href="add_facility.php?id=<?php echo $fac['id']; ?>" class="mm-facilitylist__action-btn mm-facilitylist__action-btn--edit">
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
            <!-- /.mm-facilitylist__grid -->

         </div>
         <!-- /.mm-facilitylist -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
// ── Facility Search + Filter ─────────────────────────────────────
(function() {
   var searchInput = document.getElementById('mmFacilitySearch');
   var filterBtns  = document.querySelectorAll('.mm-facilitylist__filter-btn');
   var grid        = document.getElementById('mmFacilityGrid');
   var currentFilter = 'all';

   if (!searchInput || !grid) return;

   function applyFilters() {
      var query = searchInput.value.toLowerCase().trim();
      var cards = grid.querySelectorAll('.mm-facilitylist__card');
      var visibleCount = 0;

      cards.forEach(function(card) {
         var name   = card.getAttribute('data-facility-name') || '';
         var status = card.getAttribute('data-facility-status') || '';

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
      var existingNoResult = document.getElementById('mmFacilityNoResult');
      if (existingNoResult) existingNoResult.remove();

      if (visibleCount === 0 && (query || currentFilter !== 'all')) {
         var noResult = document.createElement('div');
         noResult.id = 'mmFacilityNoResult';
         noResult.className = 'mm-facilitylist__empty';
         noResult.innerHTML = '<div class="mm-facilitylist__empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><h3 class="mm-facilitylist__empty-title">No results found</h3><p class="mm-facilitylist__empty-text">No facilities match your current search or filter. Try adjusting your criteria.</p>';
         grid.appendChild(noResult);
      }
   }

   // Search input handler
   searchInput.addEventListener('input', applyFilters);

   // Filter button handlers
   filterBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
         filterBtns.forEach(function(b) {
            b.classList.remove('mm-facilitylist__filter-btn--active');
         });
         this.classList.add('mm-facilitylist__filter-btn--active');
         currentFilter = this.getAttribute('data-filter');
         applyFilters();
      });
   });
})();
</script>
<!-- Plugin used-->
</body>
</html>
