<?php
   include "filemanager/head.php";

   // ── Gather cover data up front ──────────────────────────────
   $coverQuery = $evmulti->query("SELECT * FROM tbl_cover WHERE sponsore_id=" . $sdata["id"]);
   $covers = [];
   $eventCache = [];
   while ($row = $coverQuery->fetch_assoc()) {
      $covers[] = $row;
      // Cache event lookups to avoid repeated queries
      $eid = $row["eid"];
      if (!isset($eventCache[$eid])) {
         $eResult = $evmulti->query("SELECT * FROM tbl_event WHERE id=" . $eid);
         $eventCache[$eid] = $eResult->fetch_assoc();
      }
   }

   $totalCovers    = count($covers);
   $publishedCount = 0;
   $unpublishedCount = 0;
   $eventNames = [];
   foreach ($covers as $c) {
      if ($c['status'] == 1) {
         $publishedCount++;
      } else {
         $unpublishedCount++;
      }
      // Collect unique event names for filter pills
      $eid = $c['eid'];
      if (isset($eventCache[$eid]) && !empty($eventCache[$eid]['title'])) {
         $eName = $eventCache[$eid]['title'];
         if (!isset($eventNames[$eid])) {
            $eventNames[$eid] = $eName;
         }
      }
   }
?>
<link rel="stylesheet" href="assets/css/magicmate-page-coverlist.css">
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
              MAGICMATE COVER LIST — Custom Layout
              ═══════════════════════════════════════════════════════ -->
         <div class="mm-coverlist">

            <!-- ── Page Header ─────────────────────────────── -->
            <header class="mm-coverlist__header">
               <div class="mm-coverlist__header-left">
                  <a href="list_event.php" class="mm-coverlist__back-link">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                     Back to Events
                  </a>
                  <h1 class="mm-coverlist__title">Cover Images</h1>
                  <p class="mm-coverlist__subtitle">Manage cover images for your events.</p>
               </div>
               <div class="mm-coverlist__header-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
               </div>
            </header>

            <!-- ── Stats Bar ───────────────────────────────── -->
            <div class="mm-coverlist__stats-bar">
               <div class="mm-coverlist__stat">
                  <span class="mm-coverlist__stat-dot mm-coverlist__stat-dot--total"></span>
                  <span class="mm-coverlist__stat-value"><?php echo $totalCovers; ?></span>
                  <span class="mm-coverlist__stat-label">Total Images</span>
               </div>
               <span class="mm-coverlist__stat-separator"></span>
               <div class="mm-coverlist__stat">
                  <span class="mm-coverlist__stat-dot mm-coverlist__stat-dot--published"></span>
                  <span class="mm-coverlist__stat-value"><?php echo $publishedCount; ?></span>
                  <span class="mm-coverlist__stat-label">Published</span>
               </div>
               <span class="mm-coverlist__stat-separator"></span>
               <div class="mm-coverlist__stat">
                  <span class="mm-coverlist__stat-dot mm-coverlist__stat-dot--unpublished"></span>
                  <span class="mm-coverlist__stat-value"><?php echo $unpublishedCount; ?></span>
                  <span class="mm-coverlist__stat-label">Unpublished</span>
               </div>
            </div>

            <!-- ── Toolbar: Search + Filters ─────────────── -->
            <div class="mm-coverlist__toolbar">
               <div class="mm-coverlist__search-wrap">
                  <span class="mm-coverlist__search-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                  </span>
                  <input type="text" class="mm-coverlist__search-input" id="mmCoverSearch" placeholder="Search by event name..." autocomplete="off">
               </div>
               <div class="mm-coverlist__filters" id="mmCoverFilters">
                  <button type="button" class="mm-coverlist__filter-btn mm-coverlist__filter-btn--active" data-filter="all">
                     All
                     <span class="mm-coverlist__filter-count"><?php echo $totalCovers; ?></span>
                  </button>
                  <button type="button" class="mm-coverlist__filter-btn" data-filter="published">
                     Published
                     <span class="mm-coverlist__filter-count"><?php echo $publishedCount; ?></span>
                  </button>
                  <button type="button" class="mm-coverlist__filter-btn" data-filter="unpublished">
                     Unpublished
                     <span class="mm-coverlist__filter-count"><?php echo $unpublishedCount; ?></span>
                  </button>
                  <?php if (count($eventNames) > 1) { ?>
                     <span class="mm-coverlist__filter-divider"></span>
                     <?php foreach ($eventNames as $eid => $eName) { ?>
                        <button type="button" class="mm-coverlist__filter-btn" data-filter="event-<?php echo $eid; ?>">
                           <?php echo htmlspecialchars($eName); ?>
                        </button>
                     <?php } ?>
                  <?php } ?>
               </div>
            </div>

            <!-- ── Cover Grid ──────────────────────────────── -->
            <div class="mm-coverlist__grid" id="mmCoverGrid">
               <?php if ($totalCovers === 0) { ?>
                  <!-- Empty State -->
                  <div class="mm-coverlist__empty">
                     <div class="mm-coverlist__empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                     </div>
                     <h3 class="mm-coverlist__empty-title">No cover images yet</h3>
                     <p class="mm-coverlist__empty-text">No cover images have been added for your events. Add one from the event editor.</p>
                  </div>
               <?php } else {
                  $i = 0;
                  foreach ($covers as $row) {
                     $i++;
                     $isPublished = $row['status'] == 1;
                     $hasImage = !empty($row['img']);
                     $eid = $row['eid'];
                     $eventTitle = isset($eventCache[$eid]) ? $eventCache[$eid]['title'] : 'Unknown Event';
               ?>
                  <div class="mm-coverlist__card"
                       style="--card-index: <?php echo $i; ?>"
                       data-cover-event="<?php echo htmlspecialchars(strtolower($eventTitle)); ?>"
                       data-cover-status="<?php echo $isPublished ? 'published' : 'unpublished'; ?>"
                       data-cover-eid="<?php echo $eid; ?>">

                     <!-- Card Visual — Cover Image (landscape) -->
                     <div class="mm-coverlist__card-visual">
                        <?php if ($hasImage) { ?>
                           <img src="<?php echo htmlspecialchars($row['img']); ?>"
                                alt="Cover for <?php echo htmlspecialchars($eventTitle); ?>"
                                class="mm-coverlist__card-image"
                                loading="lazy">
                        <?php } else { ?>
                           <div class="mm-coverlist__card-no-image">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                           </div>
                        <?php } ?>
                        <!-- Status badge overlay -->
                        <span class="mm-coverlist__status-badge <?php echo $isPublished ? 'mm-coverlist__status-badge--published' : 'mm-coverlist__status-badge--unpublished'; ?>">
                           <?php if ($isPublished) { ?>
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                              Published
                           <?php } else { ?>
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                              Unpublished
                           <?php } ?>
                        </span>
                        <!-- Index -->
                        <span class="mm-coverlist__card-index"><?php echo $i; ?></span>
                     </div>

                     <!-- Card Body -->
                     <div class="mm-coverlist__card-body">
                        <div class="mm-coverlist__card-event-tag">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                           <span class="mm-coverlist__card-event-name" title="<?php echo htmlspecialchars($eventTitle); ?>">
                              <?php echo htmlspecialchars($eventTitle); ?>
                           </span>
                        </div>
                     </div>

                     <!-- Card Actions -->
                     <div class="mm-coverlist__card-actions">
                        <a href="add_cover.php?id=<?php echo $row['id']; ?>" class="mm-coverlist__action-btn mm-coverlist__action-btn--edit">
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
            <!-- /.mm-coverlist__grid -->

            <!-- ── Hidden DataTable (JS compatibility) ───── -->
            <div style="display:none;">
               <table class="display" id="basic-1">
                  <thead>
                     <tr>
                        <th>Sr No.</th>
                        <th>Cover Image</th>
                        <th>Event Name</th>
                        <th>Cover Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                        $i2 = 0;
                        foreach ($covers as $row) {
                           $i2++;
                           $eid = $row['eid'];
                           $eventTitle = isset($eventCache[$eid]) ? $eventCache[$eid]['title'] : '';
                     ?>
                     <tr>
                        <td><?php echo $i2; ?></td>
                        <td><img src="<?php echo htmlspecialchars($row['img']); ?>" width="60" height="60" alt=""/></td>
                        <td><?php echo htmlspecialchars($eventTitle); ?></td>
                        <?php if ($row['status'] == 1) { ?>
                        <td><span class="badge badge-success">Publish</span></td>
                        <?php } else { ?>
                        <td><span class="badge badge-danger">Unpublish</span></td>
                        <?php } ?>
                        <td>
                           <a href="add_cover.php?id=<?php echo $row['id']; ?>" class="badge badge-info"><i data-feather="edit-3"></i></a>
                        </td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>

         </div>
         <!-- /.mm-coverlist -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
// ── Cover Search + Filter ─────────────────────────────────────
(function() {
   var searchInput = document.getElementById('mmCoverSearch');
   var filterBtns  = document.querySelectorAll('.mm-coverlist__filter-btn');
   var grid        = document.getElementById('mmCoverGrid');
   var currentFilter = 'all';

   if (!searchInput || !grid) return;

   function applyFilters() {
      var query = searchInput.value.toLowerCase().trim();
      var cards = grid.querySelectorAll('.mm-coverlist__card');
      var visibleCount = 0;

      cards.forEach(function(card) {
         var eventName = card.getAttribute('data-cover-event') || '';
         var status    = card.getAttribute('data-cover-status') || '';
         var eid       = card.getAttribute('data-cover-eid') || '';

         var matchesSearch = !query || eventName.indexOf(query) !== -1;
         var matchesFilter = currentFilter === 'all'
            || status === currentFilter
            || currentFilter === 'event-' + eid;

         if (matchesSearch && matchesFilter) {
            card.style.display = '';
            visibleCount++;
         } else {
            card.style.display = 'none';
         }
      });

      // Handle empty state for filtered results
      var existingNoResult = document.getElementById('mmCoverNoResult');
      if (existingNoResult) existingNoResult.remove();

      if (visibleCount === 0 && (query || currentFilter !== 'all')) {
         var noResult = document.createElement('div');
         noResult.id = 'mmCoverNoResult';
         noResult.className = 'mm-coverlist__empty';
         noResult.innerHTML = '<div class="mm-coverlist__empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><h3 class="mm-coverlist__empty-title">No results found</h3><p class="mm-coverlist__empty-text">No cover images match your current search or filter. Try adjusting your criteria.</p>';
         grid.appendChild(noResult);
      }
   }

   // Search input handler
   searchInput.addEventListener('input', applyFilters);

   // Filter button handlers
   filterBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
         filterBtns.forEach(function(b) {
            b.classList.remove('mm-coverlist__filter-btn--active');
         });
         this.classList.add('mm-coverlist__filter-btn--active');
         currentFilter = this.getAttribute('data-filter');
         applyFilters();
      });
   });
})();
</script>
<!-- Plugin used-->
</body>
</html>
