<?php
   include "filemanager/head.php";

   // ── Gather artist data up front ──────────────────────────────
   $artistQuery = $evmulti->query("select * from tbl_artist where sponsore_id=" . $sdata["id"] . "");
   $artists = [];
   $eventNames = [];
   while ($row = $artistQuery->fetch_assoc()) {
      $artists[] = $row;
      // Per-row sub-query to get event name
      $e = $evmulti->query("select * from tbl_event where id=" . $row["eid"] . "")->fetch_assoc();
      $eventNames[$row['id']] = $e ? $e['title'] : 'Unknown Event';
   }

   $totalArtists     = count($artists);
   $publishedCount   = 0;
   $unpublishedCount = 0;
   $eventFilter      = []; // unique event names for filter pills
   foreach ($artists as $art) {
      if ($art['status'] == 1) {
         $publishedCount++;
      } else {
         $unpublishedCount++;
      }
      $eName = $eventNames[$art['id']] ?? 'Unknown Event';
      if (!in_array($eName, $eventFilter)) {
         $eventFilter[] = $eName;
      }
   }
?>
<link rel="stylesheet" href="assets/css/zenizee-page-artistlist.css">
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
                                       <th>Artist Image</th>
                                       <th>Event Name</th>
                                       <th>Artist Name</th>
                                       <th>Artist Role</th>
                                       <th>Cover Status</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody></tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <!-- ═══════════════════════════════════════════════════════
              ZENIZEE ARTIST LIST — Custom Layout
              ═══════════════════════════════════════════════════════ -->
         <div class="mm-artistlist">

            <!-- ── Page Header ─────────────────────────────── -->
            <header class="mm-artistlist__header">
               <div class="mm-artistlist__header-left">
                  <a href="list_event.php" class="mm-artistlist__back-link">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                     Back to Events
                  </a>
                  <h1 class="mm-artistlist__title">Event Artists</h1>
                  <p class="mm-artistlist__subtitle">Manage artists and performers for your events.</p>
               </div>
               <div class="mm-artistlist__header-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
               </div>
            </header>

            <!-- ── Stats Bar ───────────────────────────────── -->
            <div class="mm-artistlist__stats-bar">
               <div class="mm-artistlist__stat">
                  <span class="mm-artistlist__stat-dot mm-artistlist__stat-dot--total"></span>
                  <span class="mm-artistlist__stat-value"><?php echo $totalArtists; ?></span>
                  <span class="mm-artistlist__stat-label">Total Artists</span>
               </div>
               <span class="mm-artistlist__stat-separator"></span>
               <div class="mm-artistlist__stat">
                  <span class="mm-artistlist__stat-dot mm-artistlist__stat-dot--published"></span>
                  <span class="mm-artistlist__stat-value"><?php echo $publishedCount; ?></span>
                  <span class="mm-artistlist__stat-label">Published</span>
               </div>
               <span class="mm-artistlist__stat-separator"></span>
               <div class="mm-artistlist__stat">
                  <span class="mm-artistlist__stat-dot mm-artistlist__stat-dot--unpublished"></span>
                  <span class="mm-artistlist__stat-value"><?php echo $unpublishedCount; ?></span>
                  <span class="mm-artistlist__stat-label">Unpublished</span>
               </div>
            </div>

            <!-- ── Toolbar: Search + Filters ─────────────── -->
            <div class="mm-artistlist__toolbar">
               <div class="mm-artistlist__search-wrap">
                  <span class="mm-artistlist__search-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                  </span>
                  <input type="text" class="mm-artistlist__search-input" id="mmArtistSearch" placeholder="Search artists..." autocomplete="off">
               </div>
               <div class="mm-artistlist__filters">
                  <button type="button" class="mm-artistlist__filter-btn mm-artistlist__filter-btn--active" data-filter="all">
                     All
                     <span class="mm-artistlist__filter-count"><?php echo $totalArtists; ?></span>
                  </button>
                  <button type="button" class="mm-artistlist__filter-btn" data-filter="published">
                     Published
                     <span class="mm-artistlist__filter-count"><?php echo $publishedCount; ?></span>
                  </button>
                  <button type="button" class="mm-artistlist__filter-btn" data-filter="unpublished">
                     Unpublished
                     <span class="mm-artistlist__filter-count"><?php echo $unpublishedCount; ?></span>
                  </button>
               </div>
            </div>

            <!-- ── Event Filter Pills ───────────────────── -->
            <?php if (count($eventFilter) > 1) { ?>
            <div class="mm-artistlist__event-filters">
               <span class="mm-artistlist__event-filters-label">By Event:</span>
               <button type="button" class="mm-artistlist__event-pill mm-artistlist__event-pill--active" data-event="all">All Events</button>
               <?php foreach ($eventFilter as $evName) { ?>
                  <button type="button" class="mm-artistlist__event-pill" data-event="<?php echo htmlspecialchars(strtolower($evName)); ?>">
                     <?php echo htmlspecialchars($evName); ?>
                  </button>
               <?php } ?>
            </div>
            <?php } ?>

            <!-- ── Artist Grid ──────────────────────────── -->
            <div class="mm-artistlist__grid" id="mmArtistGrid">
               <?php if ($totalArtists === 0) { ?>
                  <!-- Empty State -->
                  <div class="mm-artistlist__empty">
                     <div class="mm-artistlist__empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
                     </div>
                     <h3 class="mm-artistlist__empty-title">No artists yet</h3>
                     <p class="mm-artistlist__empty-text">No artists have been added to your events. Add an artist to showcase performers.</p>
                  </div>
               <?php } else {
                  $i = 0;
                  foreach ($artists as $art) {
                     $i++;
                     $isPublished = $art['status'] == 1;
                     $hasImage    = !empty($art['img']);
                     $eventName   = $eventNames[$art['id']] ?? 'Unknown Event';
               ?>
                  <div class="mm-artistlist__card"
                       style="--card-index: <?php echo $i; ?>"
                       data-artist-name="<?php echo htmlspecialchars(strtolower($art['title'])); ?>"
                       data-artist-role="<?php echo htmlspecialchars(strtolower($art['arole'])); ?>"
                       data-artist-status="<?php echo $isPublished ? 'published' : 'unpublished'; ?>"
                       data-artist-event="<?php echo htmlspecialchars(strtolower($eventName)); ?>">

                     <!-- Card Avatar -->
                     <div class="mm-artistlist__card-avatar-wrap">
                        <?php if ($hasImage) { ?>
                           <img src="<?php echo htmlspecialchars($art['img']); ?>"
                                alt="<?php echo htmlspecialchars($art['title']); ?>"
                                class="mm-artistlist__card-avatar"
                                loading="lazy">
                        <?php } else { ?>
                           <div class="mm-artistlist__card-no-avatar">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                           </div>
                        <?php } ?>
                        <!-- Status indicator -->
                        <span class="mm-artistlist__avatar-status <?php echo $isPublished ? 'mm-artistlist__avatar-status--published' : 'mm-artistlist__avatar-status--unpublished'; ?>"></span>
                     </div>

                     <!-- Card Body -->
                     <div class="mm-artistlist__card-body">
                        <h3 class="mm-artistlist__card-name" title="<?php echo htmlspecialchars($art['title']); ?>">
                           <?php echo htmlspecialchars($art['title']); ?>
                        </h3>
                        <span class="mm-artistlist__card-role"><?php echo htmlspecialchars($art['arole']); ?></span>

                        <div class="mm-artistlist__card-meta">
                           <!-- Event tag -->
                           <span class="mm-artistlist__card-event-tag" title="<?php echo htmlspecialchars($eventName); ?>">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                              <?php echo htmlspecialchars($eventName); ?>
                           </span>

                           <!-- Status badge -->
                           <?php if ($isPublished) { ?>
                              <span class="mm-artistlist__badge mm-artistlist__badge--published">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                 Published
                              </span>
                           <?php } else { ?>
                              <span class="mm-artistlist__badge mm-artistlist__badge--unpublished">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                 Unpublished
                              </span>
                           <?php } ?>
                        </div>
                     </div>

                     <!-- Card Actions -->
                     <div class="mm-artistlist__card-actions">
                        <a href="add_artist.php?id=<?php echo $art['id']; ?>" class="mm-artistlist__action-btn mm-artistlist__action-btn--edit">
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
            <!-- /.mm-artistlist__grid -->

         </div>
         <!-- /.mm-artistlist -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
// ── Artist Search + Filter ─────────────────────────────────────
(function() {
   var searchInput  = document.getElementById('mmArtistSearch');
   var filterBtns   = document.querySelectorAll('.mm-artistlist__filter-btn');
   var eventPills   = document.querySelectorAll('.mm-artistlist__event-pill');
   var grid         = document.getElementById('mmArtistGrid');
   var currentFilter = 'all';
   var currentEvent  = 'all';

   if (!searchInput || !grid) return;

   function applyFilters() {
      var query = searchInput.value.toLowerCase().trim();
      var cards = grid.querySelectorAll('.mm-artistlist__card');
      var visibleCount = 0;

      cards.forEach(function(card) {
         var name   = card.getAttribute('data-artist-name') || '';
         var role   = card.getAttribute('data-artist-role') || '';
         var status = card.getAttribute('data-artist-status') || '';
         var event  = card.getAttribute('data-artist-event') || '';

         var matchesSearch = !query || name.indexOf(query) !== -1 || role.indexOf(query) !== -1;
         var matchesFilter = currentFilter === 'all' || status === currentFilter;
         var matchesEvent  = currentEvent === 'all' || event === currentEvent;

         if (matchesSearch && matchesFilter && matchesEvent) {
            card.style.display = '';
            visibleCount++;
         } else {
            card.style.display = 'none';
         }
      });

      // Handle empty state for filtered results
      var existingNoResult = document.getElementById('mmArtistNoResult');
      if (existingNoResult) existingNoResult.remove();

      if (visibleCount === 0 && (query || currentFilter !== 'all' || currentEvent !== 'all')) {
         var noResult = document.createElement('div');
         noResult.id = 'mmArtistNoResult';
         noResult.className = 'mm-artistlist__empty';
         noResult.innerHTML = '<div class="mm-artistlist__empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><h3 class="mm-artistlist__empty-title">No results found</h3><p class="mm-artistlist__empty-text">No artists match your current search or filter. Try adjusting your criteria.</p>';
         grid.appendChild(noResult);
      }
   }

   // Search input handler
   searchInput.addEventListener('input', applyFilters);

   // Status filter button handlers
   filterBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
         filterBtns.forEach(function(b) {
            b.classList.remove('mm-artistlist__filter-btn--active');
         });
         this.classList.add('mm-artistlist__filter-btn--active');
         currentFilter = this.getAttribute('data-filter');
         applyFilters();
      });
   });

   // Event pill handlers
   eventPills.forEach(function(pill) {
      pill.addEventListener('click', function() {
         eventPills.forEach(function(p) {
            p.classList.remove('mm-artistlist__event-pill--active');
         });
         this.classList.add('mm-artistlist__event-pill--active');
         currentEvent = this.getAttribute('data-event');
         applyFilters();
      });
   });
})();
</script>
<!-- Plugin used-->
</body>
</html>
