<?php
   include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/magicmate-page-userlist.css">
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
              ZENIZEE USER LIST — Custom Card Layout
              ═══════════════════════════════════════════════════════ -->
         <div class="mm-userlist">

            <?php
               // ── Gather user data up front ──────────────────────────────
               $userQuery = $evmulti->query("SELECT * FROM `tbl_user`");
               $users = [];
               while ($row = $userQuery->fetch_assoc()) {
                  $users[] = $row;
               }

               $totalUsers   = count($users);
               $activeCount  = 0;
               $inactiveCount = 0;
               $totalWallet  = 0;
               foreach ($users as $u) {
                  if ($u['status'] == 1) {
                     $activeCount++;
                  } else {
                     $inactiveCount++;
                  }
                  $totalWallet += floatval($u['wallet']);
               }
               $totalWalletFormatted = number_format($totalWallet, 2, '.', '');
            ?>

            <!-- ── Page Header ─────────────────────────────── -->
            <header class="mm-userlist__header">
               <div class="mm-userlist__header-left">
                  <h1 class="mm-userlist__title">Users</h1>
                  <p class="mm-userlist__subtitle">Manage registered users, track status and wallet balances.</p>
               </div>
               <div class="mm-userlist__header-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
               </div>
            </header>

            <!-- ── Stats Bar ───────────────────────────────── -->
            <div class="mm-userlist__stats-bar">
               <div class="mm-userlist__stat">
                  <span class="mm-userlist__stat-dot mm-userlist__stat-dot--total"></span>
                  <span class="mm-userlist__stat-value"><?php echo $totalUsers; ?></span>
                  <span class="mm-userlist__stat-label">Total Users</span>
               </div>
               <span class="mm-userlist__stat-separator"></span>
               <div class="mm-userlist__stat">
                  <span class="mm-userlist__stat-dot mm-userlist__stat-dot--active"></span>
                  <span class="mm-userlist__stat-value"><?php echo $activeCount; ?></span>
                  <span class="mm-userlist__stat-label">Active</span>
               </div>
               <span class="mm-userlist__stat-separator"></span>
               <div class="mm-userlist__stat">
                  <span class="mm-userlist__stat-dot mm-userlist__stat-dot--inactive"></span>
                  <span class="mm-userlist__stat-value"><?php echo $inactiveCount; ?></span>
                  <span class="mm-userlist__stat-label">Inactive</span>
               </div>
               <span class="mm-userlist__stat-separator"></span>
               <div class="mm-userlist__stat">
                  <span class="mm-userlist__stat-dot mm-userlist__stat-dot--wallet"></span>
                  <span class="mm-userlist__stat-value"><?php echo $set["currency"] . $totalWalletFormatted; ?></span>
                  <span class="mm-userlist__stat-label">Total Wallet</span>
               </div>
            </div>

            <!-- ── Toolbar: Search + Filters ─────────────── -->
            <div class="mm-userlist__toolbar">
               <div class="mm-userlist__search-wrap">
                  <span class="mm-userlist__search-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                  </span>
                  <input type="text" class="mm-userlist__search-input" id="mmUserSearch" placeholder="Search users by name, email or phone..." autocomplete="off">
               </div>
               <div class="mm-userlist__filters">
                  <button type="button" class="mm-userlist__filter-btn mm-userlist__filter-btn--active" data-filter="all">
                     All
                     <span class="mm-userlist__filter-count"><?php echo $totalUsers; ?></span>
                  </button>
                  <button type="button" class="mm-userlist__filter-btn" data-filter="active">
                     Active
                     <span class="mm-userlist__filter-count"><?php echo $activeCount; ?></span>
                  </button>
                  <button type="button" class="mm-userlist__filter-btn" data-filter="inactive">
                     Inactive
                     <span class="mm-userlist__filter-count"><?php echo $inactiveCount; ?></span>
                  </button>
               </div>
            </div>

            <!-- ── User Card Grid ───────────────────────────── -->
            <div class="mm-userlist__grid" id="mmUserGrid">
               <?php if ($totalUsers === 0) { ?>
                  <!-- Empty State -->
                  <div class="mm-userlist__empty">
                     <div class="mm-userlist__empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                     </div>
                     <h3 class="mm-userlist__empty-title">No users found</h3>
                     <p class="mm-userlist__empty-text">No users have registered yet.</p>
                  </div>
               <?php } else {
                  $i = 0;
                  foreach ($users as $row) {
                     $i++;
                     $isActive = $row['status'] == 1;
               ?>
                  <div class="mm-userlist__card"
                       style="--card-index: <?php echo $i; ?>"
                       data-user-name="<?php echo htmlspecialchars(strtolower($row['name'])); ?>"
                       data-user-email="<?php echo htmlspecialchars(strtolower($row['email'])); ?>"
                       data-user-mobile="<?php echo htmlspecialchars($row['mobile']); ?>"
                       data-user-status="<?php echo $isActive ? 'active' : 'inactive'; ?>">

                     <!-- Card Visual -- Circular Avatar -->
                     <div class="mm-userlist__card-visual">
                        <?php if (!empty($row['pro_pic'])) { ?>
                           <img src="<?php echo htmlspecialchars($row['pro_pic']); ?>"
                                alt="<?php echo htmlspecialchars($row['name']); ?>"
                                class="mm-userlist__card-avatar"
                                loading="lazy">
                        <?php } else { ?>
                           <div class="mm-userlist__card-no-avatar">
                              <?php
                                 // Generate initials from name
                                 $nameParts = explode(' ', trim($row['name']));
                                 $initials = strtoupper(substr($nameParts[0], 0, 1));
                                 if (count($nameParts) > 1) {
                                    $initials .= strtoupper(substr(end($nameParts), 0, 1));
                                 }
                              ?>
                              <span class="mm-userlist__card-initials"><?php echo $initials; ?></span>
                           </div>
                        <?php } ?>
                        <!-- Status dot -->
                        <span class="mm-userlist__status-dot <?php echo $isActive ? 'mm-userlist__status-dot--active' : 'mm-userlist__status-dot--inactive'; ?>"></span>
                        <!-- Index -->
                        <span class="mm-userlist__card-index"><?php echo $i; ?></span>
                     </div>

                     <!-- Card Body -->
                     <div class="mm-userlist__card-body">
                        <h3 class="mm-userlist__card-name" title="<?php echo htmlspecialchars($row['name']); ?>">
                           <?php echo htmlspecialchars($row['name']); ?>
                        </h3>

                        <!-- Contact info -->
                        <div class="mm-userlist__card-contact">
                           <?php if (!empty($row['email'])) { ?>
                              <p class="mm-userlist__card-email" title="<?php echo htmlspecialchars($row['email']); ?>">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                 <?php echo htmlspecialchars($row['email']); ?>
                              </p>
                           <?php } ?>
                           <?php if (!empty($row['mobile'])) { ?>
                              <p class="mm-userlist__card-phone" title="<?php echo htmlspecialchars($row['ccode'] . ' ' . $row['mobile']); ?>">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                                 <?php echo htmlspecialchars($row['ccode'] . ' ' . $row['mobile']); ?>
                              </p>
                           <?php } ?>
                        </div>

                        <!-- Details grid -->
                        <div class="mm-userlist__details">
                           <div class="mm-userlist__detail">
                              <span class="mm-userlist__detail-label">Joined</span>
                              <span class="mm-userlist__detail-value"><?php echo date('M d, Y', strtotime($row['reg_date'])); ?></span>
                           </div>
                           <div class="mm-userlist__detail">
                              <span class="mm-userlist__detail-label">Wallet</span>
                              <span class="mm-userlist__detail-value mm-userlist__detail-value--wallet"><?php echo $set["currency"] . $row["wallet"]; ?></span>
                           </div>
                           <div class="mm-userlist__detail">
                              <span class="mm-userlist__detail-label">Refer Code</span>
                              <span class="mm-userlist__detail-value mm-userlist__detail-value--code"><?php echo $row['refercode']; ?></span>
                           </div>
                           <div class="mm-userlist__detail">
                              <span class="mm-userlist__detail-label">Parent Code</span>
                              <span class="mm-userlist__detail-value"><?php echo !empty($row['parentcode']) ? $row['parentcode'] : '&mdash;'; ?></span>
                           </div>
                        </div>

                        <!-- Status + Action -->
                        <div class="mm-userlist__card-footer">
                           <?php if ($isActive) { ?>
                              <span class="mm-userlist__badge mm-userlist__badge--active">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                 Active
                              </span>
                           <?php } else { ?>
                              <span class="mm-userlist__badge mm-userlist__badge--inactive">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                 Inactive
                              </span>
                           <?php } ?>

                           <?php if ($row["status"] == 1) { ?>
                              <span data-id="<?php echo $row["id"]; ?>" data-status="0" data-type="update_status"
                                 coll-type="userstatus" class="drop mm-userlist__toggle-btn mm-userlist__toggle-btn--deactivate">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                 Deactivate
                              </span>
                           <?php } else { ?>
                              <span data-id="<?php echo $row["id"]; ?>" data-status="1" data-type="update_status"
                                 coll-type="userstatus" class="drop mm-userlist__toggle-btn mm-userlist__toggle-btn--activate">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                 Activate
                              </span>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
               <?php
                  }
               }
               ?>
            </div>
            <!-- /.mm-userlist__grid -->

            <!-- ── Hidden DataTable (preserves JS dependency) ── -->
            <div class="mm-userlist__hidden-table">
               <table class="display" id="basic-1">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($users as $row) { ?>
                     <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo htmlspecialchars($row["name"]); ?></td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>

         </div>
         <!-- /.mm-userlist -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
// ── User Search + Filter ─────────────────────────────────────
(function() {
   var searchInput = document.getElementById('mmUserSearch');
   var filterBtns  = document.querySelectorAll('.mm-userlist__filter-btn');
   var grid        = document.getElementById('mmUserGrid');
   var currentFilter = 'all';

   if (!searchInput || !grid) return;

   function applyFilters() {
      var query = searchInput.value.toLowerCase().trim();
      var cards = grid.querySelectorAll('.mm-userlist__card');
      var visibleCount = 0;

      cards.forEach(function(card) {
         var name   = card.getAttribute('data-user-name') || '';
         var email  = card.getAttribute('data-user-email') || '';
         var mobile = card.getAttribute('data-user-mobile') || '';
         var status = card.getAttribute('data-user-status') || '';

         var matchesSearch = !query || name.indexOf(query) !== -1 || email.indexOf(query) !== -1 || mobile.indexOf(query) !== -1;
         var matchesFilter = currentFilter === 'all' || status === currentFilter;

         if (matchesSearch && matchesFilter) {
            card.style.display = '';
            visibleCount++;
         } else {
            card.style.display = 'none';
         }
      });

      // Dynamic empty state for filtered results
      var existingNoResult = document.getElementById('mmUserNoResult');
      if (existingNoResult) existingNoResult.remove();

      if (visibleCount === 0 && (query || currentFilter !== 'all')) {
         var noResult = document.createElement('div');
         noResult.id = 'mmUserNoResult';
         noResult.className = 'mm-userlist__empty';
         noResult.innerHTML = '<div class="mm-userlist__empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><h3 class="mm-userlist__empty-title">No results found</h3><p class="mm-userlist__empty-text">No users match your search or filter. Try adjusting your criteria.</p>';
         grid.appendChild(noResult);
      }
   }

   // Search input handler
   searchInput.addEventListener('input', applyFilters);

   // Filter button handlers
   filterBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
         filterBtns.forEach(function(b) {
            b.classList.remove('mm-userlist__filter-btn--active');
         });
         this.classList.add('mm-userlist__filter-btn--active');
         currentFilter = this.getAttribute('data-filter');
         applyFilters();
      });
   });
})();
</script>
<!-- Plugin used-->
</body>
</html>
