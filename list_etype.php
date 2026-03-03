<?php
   include "filemanager/head.php";

   // ── Gather event type/price data up front ────────────────────────
   $etypeQuery = $evmulti->query(
       "SELECT * FROM tbl_type_price WHERE sponsore_id=" . $sdata["id"]
   );
   $etypes = [];
   while ($row = $etypeQuery->fetch_assoc()) {
      // Fetch associated event name
      $e = $evmulti->query(
          "SELECT * FROM tbl_event WHERE id=" . $row["event_id"]
      )->fetch_assoc();
      $row['event_title'] = $e ? $e['title'] : 'Unknown Event';
      $etypes[] = $row;
   }

   $totalTypes     = count($etypes);
   $publishedCount = 0;
   $unpublishedCount = 0;
   // Collect unique event names for filter pills
   $eventNames = [];
   foreach ($etypes as $et) {
      if ($et['status'] == 1) {
         $publishedCount++;
      } else {
         $unpublishedCount++;
      }
      if (!in_array($et['event_title'], $eventNames)) {
         $eventNames[] = $et['event_title'];
      }
   }
?>
<link rel="stylesheet" href="assets/css/magicmate-page-etypelist.css">
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
              MAGICMATE EVENT TYPE LIST — Custom Layout
              ═══════════════════════════════════════════════════════ -->
         <div class="mm-etypelist">

            <!-- ── Page Header ─────────────────────────────── -->
            <header class="mm-etypelist__header">
               <div class="mm-etypelist__header-left">
                  <a href="list_event.php" class="mm-etypelist__back-link">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                     Back to Events
                  </a>
                  <h1 class="mm-etypelist__title">Event Types & Pricing</h1>
                  <p class="mm-etypelist__subtitle">Manage ticket types, pricing tiers, and availability for your events.</p>
               </div>
               <div class="mm-etypelist__header-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
               </div>
            </header>

            <!-- ── Stats Bar ───────────────────────────────── -->
            <div class="mm-etypelist__stats-bar">
               <div class="mm-etypelist__stat">
                  <span class="mm-etypelist__stat-dot mm-etypelist__stat-dot--total"></span>
                  <span class="mm-etypelist__stat-value"><?php echo $totalTypes; ?></span>
                  <span class="mm-etypelist__stat-label">Total Types</span>
               </div>
               <span class="mm-etypelist__stat-separator"></span>
               <div class="mm-etypelist__stat">
                  <span class="mm-etypelist__stat-dot mm-etypelist__stat-dot--published"></span>
                  <span class="mm-etypelist__stat-value"><?php echo $publishedCount; ?></span>
                  <span class="mm-etypelist__stat-label">Published</span>
               </div>
               <span class="mm-etypelist__stat-separator"></span>
               <div class="mm-etypelist__stat">
                  <span class="mm-etypelist__stat-dot mm-etypelist__stat-dot--unpublished"></span>
                  <span class="mm-etypelist__stat-value"><?php echo $unpublishedCount; ?></span>
                  <span class="mm-etypelist__stat-label">Unpublished</span>
               </div>
            </div>

            <!-- ── Toolbar: Search + Filters ─────────────── -->
            <div class="mm-etypelist__toolbar">
               <div class="mm-etypelist__search-wrap">
                  <span class="mm-etypelist__search-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                  </span>
                  <input type="text" class="mm-etypelist__search-input" id="mmEtypeSearch" placeholder="Search types or events..." autocomplete="off">
               </div>
               <div class="mm-etypelist__filters">
                  <button type="button" class="mm-etypelist__filter-btn mm-etypelist__filter-btn--active" data-filter="all">
                     All
                     <span class="mm-etypelist__filter-count"><?php echo $totalTypes; ?></span>
                  </button>
                  <button type="button" class="mm-etypelist__filter-btn" data-filter="published">
                     Published
                     <span class="mm-etypelist__filter-count"><?php echo $publishedCount; ?></span>
                  </button>
                  <button type="button" class="mm-etypelist__filter-btn" data-filter="unpublished">
                     Unpublished
                     <span class="mm-etypelist__filter-count"><?php echo $unpublishedCount; ?></span>
                  </button>
               </div>
               <?php if (count($eventNames) > 1) { ?>
               <div class="mm-etypelist__filters mm-etypelist__filters--events">
                  <button type="button" class="mm-etypelist__filter-btn mm-etypelist__filter-btn--event mm-etypelist__filter-btn--active" data-event-filter="all">
                     All Events
                  </button>
                  <?php foreach ($eventNames as $eName) { ?>
                  <button type="button" class="mm-etypelist__filter-btn mm-etypelist__filter-btn--event" data-event-filter="<?php echo htmlspecialchars(strtolower($eName)); ?>">
                     <?php echo htmlspecialchars($eName); ?>
                  </button>
                  <?php } ?>
               </div>
               <?php } ?>
            </div>

            <!-- ── Type/Price Card Grid ─────────────────────── -->
            <div class="mm-etypelist__grid" id="mmEtypeGrid">
               <?php if ($totalTypes === 0) { ?>
                  <!-- Empty State -->
                  <div class="mm-etypelist__empty">
                     <div class="mm-etypelist__empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                     </div>
                     <h3 class="mm-etypelist__empty-title">No event types yet</h3>
                     <p class="mm-etypelist__empty-text">You haven't created any ticket types or pricing tiers. Add one from the event detail page.</p>
                  </div>
               <?php } else {
                  $i = 0;
                  foreach ($etypes as $et) {
                     $i++;
                     $isPublished = $et['status'] == 1;
               ?>
                  <div class="mm-etypelist__card"
                       style="--card-index: <?php echo $i; ?>"
                       data-type-name="<?php echo htmlspecialchars(strtolower($et['type'])); ?>"
                       data-event-name="<?php echo htmlspecialchars(strtolower($et['event_title'])); ?>"
                       data-type-status="<?php echo $isPublished ? 'published' : 'unpublished'; ?>">

                     <!-- Card Top — Price highlight -->
                     <div class="mm-etypelist__card-price-band <?php echo $isPublished ? '' : 'mm-etypelist__card-price-band--muted'; ?>">
                        <span class="mm-etypelist__card-price">
                           <span class="mm-etypelist__card-currency"><?php echo htmlspecialchars($set["currency"]); ?></span><?php echo htmlspecialchars($et["price"]); ?>
                        </span>
                        <span class="mm-etypelist__card-index"><?php echo $i; ?></span>
                     </div>

                     <!-- Card Body -->
                     <div class="mm-etypelist__card-body">
                        <!-- Event name tag -->
                        <span class="mm-etypelist__card-event-tag" title="<?php echo htmlspecialchars($et['event_title']); ?>">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                           <?php echo htmlspecialchars($et['event_title']); ?>
                        </span>

                        <!-- Type name -->
                        <h3 class="mm-etypelist__card-type-name" title="<?php echo htmlspecialchars($et['type']); ?>">
                           <?php echo htmlspecialchars($et['type']); ?>
                        </h3>

                        <!-- Meta row: ticket limit -->
                        <div class="mm-etypelist__card-meta">
                           <div class="mm-etypelist__card-meta-item">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                              <span><?php echo htmlspecialchars($et["tlimit"]); ?> Peoples</span>
                           </div>
                        </div>

                        <!-- Status badge -->
                        <div class="mm-etypelist__card-badges">
                           <?php if ($isPublished) { ?>
                              <span class="mm-etypelist__badge mm-etypelist__badge--published">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                 Published
                              </span>
                           <?php } else { ?>
                              <span class="mm-etypelist__badge mm-etypelist__badge--unpublished">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                 Unpublished
                              </span>
                           <?php } ?>
                        </div>
                     </div>

                     <!-- Card Actions -->
                     <div class="mm-etypelist__card-actions">
                        <a href="add_etype.php?id=<?php echo $et['id']; ?>" class="mm-etypelist__action-btn mm-etypelist__action-btn--edit">
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
            <!-- /.mm-etypelist__grid -->

            <!-- ── Hidden DataTable for JS compatibility ──── -->
            <div style="display:none;">
               <table class="display" id="basic-1">
                  <thead>
                     <tr>
                        <th>Sr No.</th>
                        <th>Event Name</th>
                        <th>Event Type</th>
                        <th>Event Ticket Price</th>
                        <th>Event Ticket Limit</th>
                        <th>Ticket Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                        $i2 = 0;
                        foreach ($etypes as $et) {
                           $i2++;
                     ?>
                     <tr>
                        <td><?php echo $i2; ?></td>
                        <td><?php echo htmlspecialchars($et['event_title']); ?></td>
                        <td><?php echo htmlspecialchars($et['type']); ?></td>
                        <td><?php echo htmlspecialchars($et['price']) . htmlspecialchars($set['currency']); ?></td>
                        <td><?php echo htmlspecialchars($et['tlimit']) . ' Peoples'; ?></td>
                        <td><?php echo $et['status'] == 1 ? '<span class="badge badge-success">Publish</span>' : '<span class="badge badge-danger">Unpublish</span>'; ?></td>
                        <td><a href="add_etype.php?id=<?php echo $et['id']; ?>" class="badge badge-info"><i data-feather="edit-3"></i></a></td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>

         </div>
         <!-- /.mm-etypelist -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
// ── Event Type Search + Filter ──────────────────────────────────
(function() {
   var searchInput    = document.getElementById('mmEtypeSearch');
   var statusBtns     = document.querySelectorAll('.mm-etypelist__filter-btn:not(.mm-etypelist__filter-btn--event)');
   var eventBtns      = document.querySelectorAll('.mm-etypelist__filter-btn--event');
   var grid           = document.getElementById('mmEtypeGrid');
   var currentStatus  = 'all';
   var currentEvent   = 'all';

   if (!searchInput || !grid) return;

   function applyFilters() {
      var query = searchInput.value.toLowerCase().trim();
      var cards = grid.querySelectorAll('.mm-etypelist__card');
      var visibleCount = 0;

      cards.forEach(function(card) {
         var typeName  = card.getAttribute('data-type-name') || '';
         var eventName = card.getAttribute('data-event-name') || '';
         var status    = card.getAttribute('data-type-status') || '';

         var matchesSearch = !query || typeName.indexOf(query) !== -1 || eventName.indexOf(query) !== -1;
         var matchesStatus = currentStatus === 'all' || status === currentStatus;
         var matchesEvent  = currentEvent === 'all' || eventName === currentEvent;

         if (matchesSearch && matchesStatus && matchesEvent) {
            card.style.display = '';
            visibleCount++;
         } else {
            card.style.display = 'none';
         }
      });

      // Handle empty state for filtered results
      var existingNoResult = document.getElementById('mmEtypeNoResult');
      if (existingNoResult) existingNoResult.remove();

      if (visibleCount === 0 && (query || currentStatus !== 'all' || currentEvent !== 'all')) {
         var noResult = document.createElement('div');
         noResult.id = 'mmEtypeNoResult';
         noResult.className = 'mm-etypelist__empty';
         noResult.innerHTML = '<div class="mm-etypelist__empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><h3 class="mm-etypelist__empty-title">No results found</h3><p class="mm-etypelist__empty-text">No event types match your current search or filter. Try adjusting your criteria.</p>';
         grid.appendChild(noResult);
      }
   }

   // Search input handler
   searchInput.addEventListener('input', applyFilters);

   // Status filter button handlers
   statusBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
         statusBtns.forEach(function(b) {
            b.classList.remove('mm-etypelist__filter-btn--active');
         });
         this.classList.add('mm-etypelist__filter-btn--active');
         currentStatus = this.getAttribute('data-filter');
         applyFilters();
      });
   });

   // Event filter button handlers
   eventBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
         eventBtns.forEach(function(b) {
            b.classList.remove('mm-etypelist__filter-btn--active');
         });
         this.classList.add('mm-etypelist__filter-btn--active');
         currentEvent = this.getAttribute('data-event-filter');
         applyFilters();
      });
   });
})();
</script>
<!-- Plugin used-->
</body>
</html>
