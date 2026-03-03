<?php
   include "filemanager/head.php";

   // ── Gather gallery data up front ──────────────────────────────
   $galleryQuery = $evmulti->query("select * from tbl_gallery where sponsore_id=" . $sdata["id"] . "");
   $galleries = [];
   $eventNames = [];
   while ($row = $galleryQuery->fetch_assoc()) {
      $galleries[] = $row;
      // Per-row sub-query to get event name
      $e = $evmulti->query("select * from tbl_event where id=" . $row["eid"] . "")->fetch_assoc();
      $eventNames[$row['id']] = $e ? $e['title'] : 'Unknown Event';
   }

   $totalImages     = count($galleries);
   $publishedCount  = 0;
   $unpublishedCount = 0;
   $eventFilter     = []; // unique event names for filter pills
   foreach ($galleries as $gal) {
      if ($gal['status'] == 1) {
         $publishedCount++;
      } else {
         $unpublishedCount++;
      }
      $eName = $eventNames[$gal['id']] ?? 'Unknown Event';
      if (!in_array($eName, $eventFilter)) {
         $eventFilter[] = $eName;
      }
   }
?>
<link rel="stylesheet" href="assets/css/magicmate-page-gallerylist.css">
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
              HIDDEN DATATABLE — kept for JS compatibility
              ═══════════════════════════════════════════════════════ -->
         <div style="display:none!important;height:0;overflow:hidden;pointer-events:none;" aria-hidden="true">
            <div class="container-fluid">
               <div class="row size-column">
                  <div class="col-sm-12">
                     <div class="card">
                        <div class="card-body">
                           <div class="table-responsive">
                              <table class="display" id="basic-1">
                                 <thead>
                                    <tr>
                                       <th>Sr No.</th>
                                       <th>Gallery Image</th>
                                       <th>Event Name</th>
                                       <th>Gallery Status</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                       $i = 0;
                                       foreach ($galleries as $row) {
                                          $i++;
                                    ?>
                                    <tr>
                                       <td><?php echo $i; ?></td>
                                       <td class="align-middle">
                                          <img src="<?php echo $row["img"]; ?>" width="60" height="60"/>
                                       </td>
                                       <td><?php echo htmlspecialchars($eventNames[$row['id']] ?? ''); ?></td>
                                       <?php if ($row["status"] == 1) { ?>
                                       <td><span class="badge badge-success">Publish</span></td>
                                       <?php } else { ?>
                                       <td><span class="badge badge-danger">Unpublish</span></td>
                                       <?php } ?>
                                       <td style="white-space: nowrap; width: 15%;">
                                          <div class="tabledit-toolbar btn-toolbar" style="text-align: left;">
                                             <div class="btn-group btn-group-sm" style="float: none;">
                                                <a href="add_gallery.php?id=<?php echo $row["id"]; ?>" class="badge badge-info"><i data-feather="edit-3"></i></a>
                                             </div>
                                          </div>
                                       </td>
                                    </tr>
                                    <?php } ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <!-- ═══════════════════════════════════════════════════════
              MAGICMATE GALLERY LIST — Custom Layout
              ═══════════════════════════════════════════════════════ -->
         <div class="mm-gallerylist">

            <!-- ── Page Header ─────────────────────────────── -->
            <header class="mm-gallerylist__header">
               <div class="mm-gallerylist__header-left">
                  <a href="list_event.php" class="mm-gallerylist__back-link">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                     Back to Events
                  </a>
                  <h1 class="mm-gallerylist__title">Event Gallery</h1>
                  <p class="mm-gallerylist__subtitle">Browse and manage gallery images across your events.</p>
               </div>
               <div class="mm-gallerylist__header-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
               </div>
            </header>

            <!-- ── Stats Bar ───────────────────────────────── -->
            <div class="mm-gallerylist__stats-bar">
               <div class="mm-gallerylist__stat">
                  <span class="mm-gallerylist__stat-dot mm-gallerylist__stat-dot--total"></span>
                  <span class="mm-gallerylist__stat-value"><?php echo $totalImages; ?></span>
                  <span class="mm-gallerylist__stat-label">Total Images</span>
               </div>
               <span class="mm-gallerylist__stat-separator"></span>
               <div class="mm-gallerylist__stat">
                  <span class="mm-gallerylist__stat-dot mm-gallerylist__stat-dot--published"></span>
                  <span class="mm-gallerylist__stat-value"><?php echo $publishedCount; ?></span>
                  <span class="mm-gallerylist__stat-label">Published</span>
               </div>
               <span class="mm-gallerylist__stat-separator"></span>
               <div class="mm-gallerylist__stat">
                  <span class="mm-gallerylist__stat-dot mm-gallerylist__stat-dot--unpublished"></span>
                  <span class="mm-gallerylist__stat-value"><?php echo $unpublishedCount; ?></span>
                  <span class="mm-gallerylist__stat-label">Unpublished</span>
               </div>
            </div>

            <!-- ── Toolbar: Search + Filters ─────────────── -->
            <div class="mm-gallerylist__toolbar">
               <div class="mm-gallerylist__search-wrap">
                  <span class="mm-gallerylist__search-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                  </span>
                  <input type="text" class="mm-gallerylist__search-input" id="mmGallerySearch" placeholder="Search by event name..." autocomplete="off">
               </div>
               <div class="mm-gallerylist__filters">
                  <!-- Status filters -->
                  <button type="button" class="mm-gallerylist__filter-btn mm-gallerylist__filter-btn--active" data-filter="all">
                     All
                     <span class="mm-gallerylist__filter-count"><?php echo $totalImages; ?></span>
                  </button>
                  <button type="button" class="mm-gallerylist__filter-btn" data-filter="published">
                     Published
                     <span class="mm-gallerylist__filter-count"><?php echo $publishedCount; ?></span>
                  </button>
                  <button type="button" class="mm-gallerylist__filter-btn" data-filter="unpublished">
                     Unpublished
                     <span class="mm-gallerylist__filter-count"><?php echo $unpublishedCount; ?></span>
                  </button>
               </div>
               <?php if (count($eventFilter) > 1) { ?>
               <div class="mm-gallerylist__filters mm-gallerylist__filters--events">
                  <button type="button" class="mm-gallerylist__filter-btn mm-gallerylist__filter-btn--event mm-gallerylist__filter-btn--active" data-event-filter="all">
                     All Events
                  </button>
                  <?php foreach ($eventFilter as $evName) { ?>
                  <button type="button" class="mm-gallerylist__filter-btn mm-gallerylist__filter-btn--event" data-event-filter="<?php echo htmlspecialchars(strtolower($evName)); ?>">
                     <?php echo htmlspecialchars($evName); ?>
                  </button>
                  <?php } ?>
               </div>
               <?php } ?>
            </div>

            <!-- ── Gallery Grid ──────────────────────────── -->
            <div class="mm-gallerylist__grid" id="mmGalleryGrid">
               <?php if ($totalImages === 0) { ?>
                  <!-- Empty State -->
                  <div class="mm-gallerylist__empty">
                     <div class="mm-gallerylist__empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                     </div>
                     <h3 class="mm-gallerylist__empty-title">No gallery images yet</h3>
                     <p class="mm-gallerylist__empty-text">No gallery images have been added. Add images to your events to build your visual collection.</p>
                  </div>
               <?php } else {
                  $i = 0;
                  foreach ($galleries as $row) {
                     $i++;
                     $isPublished = $row['status'] == 1;
                     $hasImage    = !empty($row['img']);
                     $evName      = $eventNames[$row['id']] ?? 'Unknown Event';
               ?>
                  <div class="mm-gallerylist__card"
                       style="--card-index: <?php echo $i; ?>"
                       data-gallery-event="<?php echo htmlspecialchars(strtolower($evName)); ?>"
                       data-gallery-status="<?php echo $isPublished ? 'published' : 'unpublished'; ?>">

                     <!-- Card Visual — Gallery Image -->
                     <div class="mm-gallerylist__card-visual">
                        <?php if ($hasImage) { ?>
                           <img src="<?php echo htmlspecialchars($row['img']); ?>"
                                alt="Gallery image for <?php echo htmlspecialchars($evName); ?>"
                                class="mm-gallerylist__card-image"
                                loading="lazy">
                        <?php } else { ?>
                           <div class="mm-gallerylist__card-no-image">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                           </div>
                        <?php } ?>
                        <!-- Status badge overlay -->
                        <span class="mm-gallerylist__status-badge <?php echo $isPublished ? 'mm-gallerylist__status-badge--published' : 'mm-gallerylist__status-badge--unpublished'; ?>">
                           <?php echo $isPublished ? 'Published' : 'Unpublished'; ?>
                        </span>
                        <!-- Index -->
                        <span class="mm-gallerylist__card-index"><?php echo $i; ?></span>
                     </div>

                     <!-- Card Footer -->
                     <div class="mm-gallerylist__card-body">
                        <div class="mm-gallerylist__card-info">
                           <span class="mm-gallerylist__event-tag">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                              <?php echo htmlspecialchars($evName); ?>
                           </span>
                        </div>
                        <a href="add_gallery.php?id=<?php echo $row['id']; ?>" class="mm-gallerylist__action-btn mm-gallerylist__action-btn--edit" title="Edit gallery image">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                     </div>
                  </div>
               <?php
                  }
               }
               ?>
            </div>
            <!-- /.mm-gallerylist__grid -->

         </div>
         <!-- /.mm-gallerylist -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
// ── Gallery Search + Filter ─────────────────────────────────────
(function() {
   var searchInput  = document.getElementById('mmGallerySearch');
   var filterBtns   = document.querySelectorAll('.mm-gallerylist__filter-btn:not(.mm-gallerylist__filter-btn--event)');
   var eventBtns    = document.querySelectorAll('.mm-gallerylist__filter-btn--event');
   var grid         = document.getElementById('mmGalleryGrid');
   var currentFilter = 'all';
   var currentEvent  = 'all';

   if (!searchInput || !grid) return;

   function applyFilters() {
      var query = searchInput.value.toLowerCase().trim();
      var cards = grid.querySelectorAll('.mm-gallerylist__card');
      var visibleCount = 0;

      cards.forEach(function(card) {
         var eventName = card.getAttribute('data-gallery-event') || '';
         var status    = card.getAttribute('data-gallery-status') || '';

         var matchesSearch = !query || eventName.indexOf(query) !== -1;
         var matchesFilter = currentFilter === 'all' || status === currentFilter;
         var matchesEvent  = currentEvent === 'all' || eventName === currentEvent;

         if (matchesSearch && matchesFilter && matchesEvent) {
            card.style.display = '';
            visibleCount++;
         } else {
            card.style.display = 'none';
         }
      });

      // Handle empty state for filtered results
      var existingNoResult = document.getElementById('mmGalleryNoResult');
      if (existingNoResult) existingNoResult.remove();

      if (visibleCount === 0 && (query || currentFilter !== 'all' || currentEvent !== 'all')) {
         var noResult = document.createElement('div');
         noResult.id = 'mmGalleryNoResult';
         noResult.className = 'mm-gallerylist__empty';
         noResult.innerHTML = '<div class="mm-gallerylist__empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><h3 class="mm-gallerylist__empty-title">No results found</h3><p class="mm-gallerylist__empty-text">No gallery images match your current search or filter. Try adjusting your criteria.</p>';
         grid.appendChild(noResult);
      }
   }

   // Search input handler
   searchInput.addEventListener('input', applyFilters);

   // Status filter button handlers
   filterBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
         filterBtns.forEach(function(b) {
            b.classList.remove('mm-gallerylist__filter-btn--active');
         });
         this.classList.add('mm-gallerylist__filter-btn--active');
         currentFilter = this.getAttribute('data-filter');
         applyFilters();
      });
   });

   // Event filter button handlers
   eventBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
         eventBtns.forEach(function(b) {
            b.classList.remove('mm-gallerylist__filter-btn--active');
         });
         this.classList.add('mm-gallerylist__filter-btn--active');
         currentEvent = this.getAttribute('data-event-filter');
         applyFilters();
      });
   });
})();
</script>
<!-- Plugin used-->
</body>
</html>
