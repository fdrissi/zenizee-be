<?php
   include "filemanager/head.php";

   // ── Gather restriction data up front ──────────────────────────────
   $restQuery = $evmulti->query("SELECT * FROM `tbl_restriction`");
   $restrictions = [];
   while ($row = $restQuery->fetch_assoc()) {
      $restrictions[] = $row;
   }

   $totalRestrictions = count($restrictions);
   $activeCount       = 0;
   $inactiveCount     = 0;
   foreach ($restrictions as $rest) {
      if ($rest['status'] == 1) {
         $activeCount++;
      } else {
         $inactiveCount++;
      }
   }
?>
<link rel="stylesheet" href="assets/css/zenizee-page-restrictlist.css">
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
              ZENIZEE RESTRICTION LIST — Custom Layout
              ═══════════════════════════════════════════════════════ -->
         <div class="mm-restrictlist">

            <!-- ── Page Header ─────────────────────────────── -->
            <header class="mm-restrictlist__header">
               <div class="mm-restrictlist__header-left">
                  <h1 class="mm-restrictlist__title">Restrictions</h1>
                  <p class="mm-restrictlist__subtitle">Manage event restrictions and guidelines.</p>
               </div>
               <div class="mm-restrictlist__header-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
               </div>
            </header>

            <!-- ── Stats Bar ───────────────────────────────── -->
            <div class="mm-restrictlist__stats-bar">
               <div class="mm-restrictlist__stat">
                  <span class="mm-restrictlist__stat-dot mm-restrictlist__stat-dot--total"></span>
                  <span class="mm-restrictlist__stat-value"><?php echo $totalRestrictions; ?></span>
                  <span class="mm-restrictlist__stat-label">Total</span>
               </div>
               <span class="mm-restrictlist__stat-separator"></span>
               <div class="mm-restrictlist__stat">
                  <span class="mm-restrictlist__stat-dot mm-restrictlist__stat-dot--active"></span>
                  <span class="mm-restrictlist__stat-value"><?php echo $activeCount; ?></span>
                  <span class="mm-restrictlist__stat-label">Active</span>
               </div>
               <span class="mm-restrictlist__stat-separator"></span>
               <div class="mm-restrictlist__stat">
                  <span class="mm-restrictlist__stat-dot mm-restrictlist__stat-dot--inactive"></span>
                  <span class="mm-restrictlist__stat-value"><?php echo $inactiveCount; ?></span>
                  <span class="mm-restrictlist__stat-label">Inactive</span>
               </div>
            </div>

            <!-- ── Toolbar: Search + Filters ─────────────── -->
            <div class="mm-restrictlist__toolbar">
               <div class="mm-restrictlist__search-wrap">
                  <span class="mm-restrictlist__search-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                  </span>
                  <input type="text" class="mm-restrictlist__search-input" id="mmRestrictSearch" placeholder="Search restrictions..." autocomplete="off">
               </div>
               <div class="mm-restrictlist__filters">
                  <button type="button" class="mm-restrictlist__filter-btn mm-restrictlist__filter-btn--active" data-filter="all">
                     All
                     <span class="mm-restrictlist__filter-count"><?php echo $totalRestrictions; ?></span>
                  </button>
                  <button type="button" class="mm-restrictlist__filter-btn" data-filter="active">
                     Active
                     <span class="mm-restrictlist__filter-count"><?php echo $activeCount; ?></span>
                  </button>
                  <button type="button" class="mm-restrictlist__filter-btn" data-filter="inactive">
                     Inactive
                     <span class="mm-restrictlist__filter-count"><?php echo $inactiveCount; ?></span>
                  </button>
               </div>
            </div>

            <!-- ── Restriction Grid ──────────────────────────── -->
            <div class="mm-restrictlist__grid" id="mmRestrictGrid">
               <?php if ($totalRestrictions === 0) { ?>
                  <!-- Empty State -->
                  <div class="mm-restrictlist__empty">
                     <div class="mm-restrictlist__empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                     </div>
                     <h3 class="mm-restrictlist__empty-title">No restrictions yet</h3>
                     <p class="mm-restrictlist__empty-text">No restrictions have been added. Create one to apply guidelines to events.</p>
                  </div>
               <?php } else {
                  $i = 0;
                  foreach ($restrictions as $rest) {
                     $i++;
                     $isActive = $rest['status'] == 1;
                     $hasImage = !empty($rest['img']);
               ?>
                  <div class="mm-restrictlist__card"
                       style="--card-index: <?php echo $i; ?>"
                       data-restrict-name="<?php echo htmlspecialchars(strtolower($rest['title'])); ?>"
                       data-restrict-status="<?php echo $isActive ? 'active' : 'inactive'; ?>">

                     <!-- Card Visual — Restriction Image -->
                     <div class="mm-restrictlist__card-visual">
                        <?php if ($hasImage) { ?>
                           <img src="<?php echo htmlspecialchars($rest['img']); ?>"
                                alt="<?php echo htmlspecialchars($rest['title']); ?>"
                                class="mm-restrictlist__card-image"
                                loading="lazy">
                        <?php } else { ?>
                           <div class="mm-restrictlist__card-no-image">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                           </div>
                        <?php } ?>
                        <!-- Status dot -->
                        <span class="mm-restrictlist__status-dot <?php echo $isActive ? 'mm-restrictlist__status-dot--active' : 'mm-restrictlist__status-dot--inactive'; ?>"></span>
                        <!-- Index -->
                        <span class="mm-restrictlist__card-index"><?php echo $i; ?></span>
                     </div>

                     <!-- Card Body -->
                     <div class="mm-restrictlist__card-body">
                        <h3 class="mm-restrictlist__card-name" title="<?php echo htmlspecialchars($rest['title']); ?>">
                           <?php echo htmlspecialchars($rest['title']); ?>
                        </h3>
                        <div class="mm-restrictlist__card-badges">
                           <?php if ($isActive) { ?>
                              <span class="mm-restrictlist__badge mm-restrictlist__badge--active">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                 Active
                              </span>
                           <?php } else { ?>
                              <span class="mm-restrictlist__badge mm-restrictlist__badge--inactive">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                 Inactive
                              </span>
                           <?php } ?>
                        </div>
                     </div>

                     <!-- Card Actions -->
                     <div class="mm-restrictlist__card-actions">
                        <a href="add_restriction.php?id=<?php echo $rest['id']; ?>" class="mm-restrictlist__action-btn mm-restrictlist__action-btn--edit">
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
            <!-- /.mm-restrictlist__grid -->

         </div>
         <!-- /.mm-restrictlist -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
// ── Restriction Search + Filter ─────────────────────────────────────
(function() {
   var searchInput = document.getElementById('mmRestrictSearch');
   var filterBtns  = document.querySelectorAll('.mm-restrictlist__filter-btn');
   var grid        = document.getElementById('mmRestrictGrid');
   var currentFilter = 'all';

   if (!searchInput || !grid) return;

   function applyFilters() {
      var query = searchInput.value.toLowerCase().trim();
      var cards = grid.querySelectorAll('.mm-restrictlist__card');
      var visibleCount = 0;

      cards.forEach(function(card) {
         var name   = card.getAttribute('data-restrict-name') || '';
         var status = card.getAttribute('data-restrict-status') || '';

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
      var existingNoResult = document.getElementById('mmRestrictNoResult');
      if (existingNoResult) existingNoResult.remove();

      if (visibleCount === 0 && (query || currentFilter !== 'all')) {
         var noResult = document.createElement('div');
         noResult.id = 'mmRestrictNoResult';
         noResult.className = 'mm-restrictlist__empty';
         noResult.innerHTML = '<div class="mm-restrictlist__empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><h3 class="mm-restrictlist__empty-title">No results found</h3><p class="mm-restrictlist__empty-text">No restrictions match your current search or filter. Try adjusting your criteria.</p>';
         grid.appendChild(noResult);
      }
   }

   // Search input handler
   searchInput.addEventListener('input', applyFilters);

   // Filter button handlers
   filterBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
         filterBtns.forEach(function(b) {
            b.classList.remove('mm-restrictlist__filter-btn--active');
         });
         this.classList.add('mm-restrictlist__filter-btn--active');
         currentFilter = this.getAttribute('data-filter');
         applyFilters();
      });
   });
})();
</script>
<!-- Plugin used-->
</body>
</html>
