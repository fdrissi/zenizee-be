<?php
   include "filemanager/head.php";
?>
<link rel="stylesheet" href="assets/css/magicmate-page-eventlist.css">
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
              ZENIZEE EVENT LIST — Custom Card Layout
              ═══════════════════════════════════════════════════════ -->
         <div class="mm-eventlist">

            <?php
               // ── Gather all events for the logged-in organizer ──
               $eventQuery = $evmulti->query(
                  "select * from tbl_event where sponsore_id=" . $sdata["id"] . ""
               );
               $events = [];
               while ($erow = $eventQuery->fetch_assoc()) {
                  // Fetch category name
                  $ctname = $evmulti->query(
                     "SELECT title FROM `tbl_category` where id=" . $erow["cid"] . ""
                  )->fetch_assoc();
                  $erow['_category'] = isset($ctname['title']) ? $ctname['title'] : 'Uncategorized';

                  // Fetch tickets sold
                  $bn = $evmulti->query(
                     "select sum(`total_ticket`) as book_ticket from tbl_ticket where eid=" .
                     $erow["id"] . "  and ticket_type!='Cancelled'"
                  )->fetch_assoc();
                  $erow['_tickets_sold'] = empty($bn["book_ticket"]) ? 0 : intval($bn["book_ticket"]);

                  $events[] = $erow;
               }

               // ── Calculate stats ──
               $totalEvents    = count($events);
               $publishedCount = 0;
               $pendingCount   = 0;
               $totalTickets   = 0;
               $categories     = [];

               foreach ($events as $ev) {
                  if ($ev['status'] == 1) $publishedCount++;
                  if ($ev['event_status'] == 'Pending') $pendingCount++;
                  $totalTickets += $ev['_tickets_sold'];
                  $cat = $ev['_category'];
                  if (!isset($categories[$cat])) $categories[$cat] = 0;
                  $categories[$cat]++;
               }
            ?>

            <!-- ── Back link ─────────────────────────────────── -->
            <a href="index.php" class="mm-eventlist__back">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
               Back to Dashboard
            </a>

            <!-- ── Page Header ─────────────────────────────── -->
            <header class="mm-eventlist__header">
               <div class="mm-eventlist__header-left">
                  <h1 class="mm-eventlist__title">My Events</h1>
                  <p class="mm-eventlist__subtitle">Manage your events, track ticket sales, and update event statuses.</p>
               </div>
               <div class="mm-eventlist__header-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
               </div>
            </header>

            <!-- ── Stats Bar ───────────────────────────────── -->
            <div class="mm-eventlist__stats-bar">
               <div class="mm-eventlist__stat">
                  <span class="mm-eventlist__stat-dot mm-eventlist__stat-dot--total"></span>
                  <span class="mm-eventlist__stat-value"><?php echo $totalEvents; ?></span>
                  <span class="mm-eventlist__stat-label">Total Events</span>
               </div>
               <span class="mm-eventlist__stat-separator"></span>
               <div class="mm-eventlist__stat">
                  <span class="mm-eventlist__stat-dot mm-eventlist__stat-dot--published"></span>
                  <span class="mm-eventlist__stat-value"><?php echo $publishedCount; ?></span>
                  <span class="mm-eventlist__stat-label">Published</span>
               </div>
               <span class="mm-eventlist__stat-separator"></span>
               <div class="mm-eventlist__stat">
                  <span class="mm-eventlist__stat-dot mm-eventlist__stat-dot--pending"></span>
                  <span class="mm-eventlist__stat-value"><?php echo $pendingCount; ?></span>
                  <span class="mm-eventlist__stat-label">Pending</span>
               </div>
               <span class="mm-eventlist__stat-separator"></span>
               <div class="mm-eventlist__stat">
                  <span class="mm-eventlist__stat-dot mm-eventlist__stat-dot--tickets"></span>
                  <span class="mm-eventlist__stat-value"><?php echo $totalTickets; ?></span>
                  <span class="mm-eventlist__stat-label">Tickets Sold</span>
               </div>
            </div>

            <!-- ── Toolbar: Search + Filters ─────────────── -->
            <div class="mm-eventlist__toolbar">
               <div class="mm-eventlist__search-wrap">
                  <span class="mm-eventlist__search-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                  </span>
                  <input type="text" class="mm-eventlist__search-input" id="mmEventSearch" placeholder="Search events..." autocomplete="off">
               </div>
               <div class="mm-eventlist__filters">
                  <!-- Status filter group -->
                  <div class="mm-eventlist__filter-group">
                     <button type="button" class="mm-eventlist__filter-btn mm-eventlist__filter-btn--active" data-filter="all" data-filter-group="status">
                        All
                        <span class="mm-eventlist__filter-count"><?php echo $totalEvents; ?></span>
                     </button>
                     <button type="button" class="mm-eventlist__filter-btn" data-filter="Pending" data-filter-group="event_status">
                        Pending
                        <span class="mm-eventlist__filter-count"><?php
                           $pc = 0; foreach ($events as $ev) { if ($ev['event_status'] == 'Pending') $pc++; }
                           echo $pc;
                        ?></span>
                     </button>
                     <button type="button" class="mm-eventlist__filter-btn" data-filter="Completed" data-filter-group="event_status">
                        Completed
                        <span class="mm-eventlist__filter-count"><?php
                           $cc = 0; foreach ($events as $ev) { if ($ev['event_status'] == 'Completed') $cc++; }
                           echo $cc;
                        ?></span>
                     </button>
                     <button type="button" class="mm-eventlist__filter-btn" data-filter="Cancelled" data-filter-group="event_status">
                        Cancelled
                        <span class="mm-eventlist__filter-count"><?php
                           $xc = 0; foreach ($events as $ev) { if ($ev['event_status'] == 'Cancelled') $xc++; }
                           echo $xc;
                        ?></span>
                     </button>
                  </div>

                  <span class="mm-eventlist__filter-divider"></span>

                  <!-- Publish filter group -->
                  <div class="mm-eventlist__filter-group">
                     <button type="button" class="mm-eventlist__filter-btn" data-filter="published" data-filter-group="publish">
                        Published
                        <span class="mm-eventlist__filter-count"><?php echo $publishedCount; ?></span>
                     </button>
                     <button type="button" class="mm-eventlist__filter-btn" data-filter="unpublished" data-filter-group="publish">
                        Unpublished
                        <span class="mm-eventlist__filter-count"><?php echo $totalEvents - $publishedCount; ?></span>
                     </button>
                  </div>

                  <?php if (count($categories) > 1) { ?>
                  <span class="mm-eventlist__filter-divider"></span>

                  <!-- Category filter group -->
                  <div class="mm-eventlist__filter-group">
                     <?php foreach ($categories as $catName => $catCount) { ?>
                        <button type="button" class="mm-eventlist__filter-btn" data-filter="<?php echo htmlspecialchars($catName); ?>" data-filter-group="category">
                           <?php echo htmlspecialchars($catName); ?>
                           <span class="mm-eventlist__filter-count"><?php echo $catCount; ?></span>
                        </button>
                     <?php } ?>
                  </div>
                  <?php } ?>
               </div>
            </div>

            <!-- ── Event Card Grid ──────────────────────────── -->
            <div class="mm-eventlist__grid" id="mmEventGrid">
               <?php if ($totalEvents === 0) { ?>
                  <!-- Empty State -->
                  <div class="mm-eventlist__empty">
                     <div class="mm-eventlist__empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                     </div>
                     <h3 class="mm-eventlist__empty-title">No events found</h3>
                     <p class="mm-eventlist__empty-text">You haven't created any events yet. Create your first event to get started.</p>
                  </div>
               <?php } else {
                  $i = 0;
                  foreach ($events as $row) {
                     $i++;
                     $isPublished = $row['status'] == 1;
                     $eventStatus = $row['event_status'];
                     $ticketsSold = $row['_tickets_sold'];
                     $categoryName = $row['_category'];
               ?>
                  <div class="mm-eventlist__card"
                       style="--card-index: <?php echo $i; ?>"
                       data-event-name="<?php echo htmlspecialchars(strtolower($row['title'])); ?>"
                       data-event-status="<?php echo htmlspecialchars($eventStatus); ?>"
                       data-publish-status="<?php echo $isPublished ? 'published' : 'unpublished'; ?>"
                       data-category="<?php echo htmlspecialchars($categoryName); ?>">

                     <!-- Card Image Banner -->
                     <div class="mm-eventlist__card-image-wrap">
                        <?php if (!empty($row['img'])) { ?>
                           <img src="<?php echo htmlspecialchars($row['img']); ?>"
                                alt="<?php echo htmlspecialchars($row['title']); ?>"
                                class="mm-eventlist__card-image"
                                loading="lazy">
                        <?php } else { ?>
                           <div class="mm-eventlist__card-no-image">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                           </div>
                        <?php } ?>
                        <!-- Index -->
                        <span class="mm-eventlist__card-index"><?php echo $i; ?></span>
                        <!-- Category badge on image -->
                        <span class="mm-eventlist__card-category"><?php echo htmlspecialchars($categoryName); ?></span>
                     </div>

                     <!-- Card Body -->
                     <div class="mm-eventlist__card-body">
                        <h3 class="mm-eventlist__card-name" title="<?php echo htmlspecialchars($row['title']); ?>">
                           <?php echo htmlspecialchars($row['title']); ?>
                        </h3>

                        <!-- Date / Time -->
                        <div class="mm-eventlist__card-datetime">
                           <span class="mm-eventlist__card-date">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                              <?php echo htmlspecialchars($row['sdate']); ?>
                           </span>
                           <span class="mm-eventlist__card-time">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                              <?php echo date("g:i A", strtotime($row["stime"])) . " - " . date("g:i A", strtotime($row["etime"])); ?>
                           </span>
                        </div>

                        <!-- Tickets Sold Metric -->
                        <div class="mm-eventlist__card-metric">
                           <div class="mm-eventlist__card-metric-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                           </div>
                           <div class="mm-eventlist__card-metric-info">
                              <span class="mm-eventlist__card-metric-value"><?php echo intval($ticketsSold); ?></span>
                              <span class="mm-eventlist__card-metric-label">Tickets Sold</span>
                           </div>
                        </div>

                        <!-- Status Badges -->
                        <div class="mm-eventlist__card-badges">
                           <?php if ($isPublished) { ?>
                              <span class="mm-eventlist__badge mm-eventlist__badge--published">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                 Published
                              </span>
                           <?php } else { ?>
                              <span class="mm-eventlist__badge mm-eventlist__badge--unpublished">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                 Unpublished
                              </span>
                           <?php } ?>

                           <?php if ($eventStatus == 'Pending') { ?>
                              <span class="mm-eventlist__badge mm-eventlist__badge--pending">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                 Pending
                              </span>
                           <?php } elseif ($eventStatus == 'Completed') { ?>
                              <span class="mm-eventlist__badge mm-eventlist__badge--completed">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                 Completed
                              </span>
                           <?php } else { ?>
                              <span class="mm-eventlist__badge mm-eventlist__badge--cancelled">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                 Cancelled
                              </span>
                           <?php } ?>
                        </div>
                     </div>

                     <!-- Card Actions -->
                     <div class="mm-eventlist__card-actions">
                        <a href="add_event.php?id=<?php echo $row['id']; ?>" class="mm-eventlist__action-btn mm-eventlist__action-btn--edit">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                           Edit
                        </a>
                        <a href="list_tickets.php?id=<?php echo $row['id']; ?>" class="mm-eventlist__action-btn mm-eventlist__action-btn--tickets">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                           Tickets
                        </a>
                        <span class="mm-eventlist__action-spacer"></span>
                        <a data-id="<?php echo $row['id']; ?>" data-status="Completed" data-type="update_status"
                           coll-type="com_game"
                           href="javascript:void(0);" class="drop mm-eventlist__action-btn mm-eventlist__action-btn--complete"
                           data-bs-toggle="tooltip" data-bs-placement="top"
                           data-bs-title="Complete Event">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                           Complete
                        </a>
                        <a data-id="<?php echo $row['id']; ?>" data-status="Cancelled" data-type="update_status"
                           coll-type="can_game"
                           href="javascript:void(0);" class="drop mm-eventlist__action-btn mm-eventlist__action-btn--cancel"
                           data-bs-toggle="tooltip" data-bs-placement="top"
                           data-bs-title="Cancel Event">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                           Cancel
                        </a>
                     </div>
                  </div>
               <?php
                  }
               }
               ?>
            </div>
            <!-- /.mm-eventlist__grid -->

            <!-- ── Hidden DataTable (preserves JS dependency) ── -->
            <div class="mm-eventlist__hidden-table">
               <table class="display" id="basic-1">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($events as $row) { ?>
                     <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo htmlspecialchars($row["title"]); ?></td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>

         </div>
         <!-- /.mm-eventlist -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
// ── Event Search + Filter ─────────────────────────────────────
(function() {
   var searchInput = document.getElementById('mmEventSearch');
   var filterBtns  = document.querySelectorAll('.mm-eventlist__filter-btn');
   var grid        = document.getElementById('mmEventGrid');
   var currentFilter = 'all';
   var currentFilterGroup = 'status';

   if (!searchInput || !grid) return;

   function applyFilters() {
      var query = searchInput.value.toLowerCase().trim();
      var cards = grid.querySelectorAll('.mm-eventlist__card');
      var visibleCount = 0;

      cards.forEach(function(card) {
         var name          = card.getAttribute('data-event-name') || '';
         var eventStatus   = card.getAttribute('data-event-status') || '';
         var publishStatus = card.getAttribute('data-publish-status') || '';
         var category      = card.getAttribute('data-category') || '';

         var matchesSearch = !query || name.indexOf(query) !== -1;
         var matchesFilter = true;

         if (currentFilter !== 'all') {
            if (currentFilterGroup === 'event_status') {
               matchesFilter = eventStatus === currentFilter;
            } else if (currentFilterGroup === 'publish') {
               matchesFilter = publishStatus === currentFilter;
            } else if (currentFilterGroup === 'category') {
               matchesFilter = category === currentFilter;
            }
         }

         if (matchesSearch && matchesFilter) {
            card.style.display = '';
            visibleCount++;
         } else {
            card.style.display = 'none';
         }
      });

      // Dynamic empty state for filtered results
      var existingNoResult = document.getElementById('mmEventNoResult');
      if (existingNoResult) existingNoResult.remove();

      if (visibleCount === 0 && (query || currentFilter !== 'all')) {
         var noResult = document.createElement('div');
         noResult.id = 'mmEventNoResult';
         noResult.className = 'mm-eventlist__empty';
         noResult.innerHTML = '<div class="mm-eventlist__empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><h3 class="mm-eventlist__empty-title">No results found</h3><p class="mm-eventlist__empty-text">No events match your search or filter. Try adjusting your criteria.</p>';
         grid.appendChild(noResult);
      }
   }

   // Search input handler
   searchInput.addEventListener('input', applyFilters);

   // Filter button handlers
   filterBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
         filterBtns.forEach(function(b) {
            b.classList.remove('mm-eventlist__filter-btn--active');
         });
         this.classList.add('mm-eventlist__filter-btn--active');
         currentFilter = this.getAttribute('data-filter');
         currentFilterGroup = this.getAttribute('data-filter-group');
         applyFilters();
      });
   });
})();
</script>
<!-- Plugin used-->
</body>
</html>
