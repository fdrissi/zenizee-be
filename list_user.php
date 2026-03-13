<?php
   include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/zenizee-page-userlist.css">
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

               // ── Gather admin data ──────────────────────────────────────
               $adminQuery = $evmulti->query("SELECT * FROM `admin`");
               $admins = [];
               while ($row = $adminQuery->fetch_assoc()) {
                  $admins[] = $row;
               }
               $adminCount = count($admins);

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
               $totalAll = $totalUsers + $adminCount;
            ?>

            <!-- ── Page Header ─────────────────────────────── -->
            <header class="mm-userlist__header">
               <div class="mm-userlist__header-left">
                  <h1 class="mm-userlist__title">Users & Admins</h1>
                  <p class="mm-userlist__subtitle">Manage registered users and admin accounts.</p>
               </div>
               <button type="button" class="mm-userlist__add-admin-btn" id="mmAddAdminBtn">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                  Add Admin
               </button>
            </header>

            <!-- ── Stats Bar ───────────────────────────────── -->
            <div class="mm-userlist__stats-bar">
               <div class="mm-userlist__stat">
                  <span class="mm-userlist__stat-dot mm-userlist__stat-dot--total"></span>
                  <span class="mm-userlist__stat-value"><?php echo $totalAll; ?></span>
                  <span class="mm-userlist__stat-label">Total</span>
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
                  <span class="mm-userlist__stat-dot mm-userlist__stat-dot--admin"></span>
                  <span class="mm-userlist__stat-value"><?php echo $adminCount; ?></span>
                  <span class="mm-userlist__stat-label">Admins</span>
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
                  <input type="text" class="mm-userlist__search-input" id="mmUserSearch" placeholder="Search by name, email or phone..." autocomplete="off">
               </div>
               <div class="mm-userlist__filters">
                  <button type="button" class="mm-userlist__filter-btn mm-userlist__filter-btn--active" data-filter="all">
                     All
                     <span class="mm-userlist__filter-count"><?php echo $totalAll; ?></span>
                  </button>
                  <button type="button" class="mm-userlist__filter-btn" data-filter="user">
                     Users
                     <span class="mm-userlist__filter-count"><?php echo $totalUsers; ?></span>
                  </button>
                  <button type="button" class="mm-userlist__filter-btn" data-filter="admin">
                     Admins
                     <span class="mm-userlist__filter-count"><?php echo $adminCount; ?></span>
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
               <?php if ($totalAll === 0) { ?>
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

                  // ── Admin Cards ──────────────────────────────────
                  foreach ($admins as $adminRow) {
                     $i++;
                     $adminUsername = $adminRow['username'] ?? 'Admin';
                     $adminInitials = strtoupper(substr($adminUsername, 0, 2));
                  ?>
                  <div class="mm-userlist__card mm-userlist__card--admin"
                       style="--card-index: <?php echo $i; ?>"
                       data-user-name="<?php echo htmlspecialchars(strtolower($adminUsername)); ?>"
                       data-user-email=""
                       data-user-mobile=""
                       data-user-status="active"
                       data-user-type="admin">

                     <!-- Card Visual -->
                     <div class="mm-userlist__card-visual mm-userlist__card-visual--admin">
                        <div class="mm-userlist__card-no-avatar mm-userlist__card-no-avatar--admin">
                           <span class="mm-userlist__card-initials"><?php echo $adminInitials; ?></span>
                        </div>
                        <span class="mm-userlist__card-index"><?php echo $i; ?></span>
                     </div>

                     <!-- Card Body -->
                     <div class="mm-userlist__card-body">
                        <h3 class="mm-userlist__card-name" title="<?php echo htmlspecialchars($adminUsername); ?>">
                           <?php echo htmlspecialchars($adminUsername); ?>
                        </h3>

                        <div class="mm-userlist__card-contact">
                           <p class="mm-userlist__card-email">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                              System Administrator
                           </p>
                        </div>

                        <div class="mm-userlist__card-footer">
                           <span class="mm-userlist__badge mm-userlist__badge--admin">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                              Admin
                           </span>
                           <span class="mm-userlist__edit-btn mm-userlist__edit-admin-btn"
                                 data-id="<?php echo $adminRow['id']; ?>"
                                 data-username="<?php echo htmlspecialchars($adminUsername); ?>">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                              Edit
                           </span>
                        </div>
                     </div>
                  </div>
                  <?php }

                  // ── User Cards ──────────────────────────────────
                  foreach ($users as $row) {
                     $i++;
                     $isActive = $row['status'] == 1;
               ?>
                  <div class="mm-userlist__card"
                       style="--card-index: <?php echo $i; ?>"
                       data-user-name="<?php echo htmlspecialchars(strtolower($row['name'])); ?>"
                       data-user-email="<?php echo htmlspecialchars(strtolower($row['email'])); ?>"
                       data-user-mobile="<?php echo htmlspecialchars($row['mobile']); ?>"
                       data-user-status="<?php echo $isActive ? 'active' : 'inactive'; ?>"
                       data-user-type="user">

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

                        <!-- Status + Actions -->
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

                           <span class="mm-userlist__edit-btn"
                                 data-id="<?php echo $row['id']; ?>"
                                 data-name="<?php echo htmlspecialchars($row['name']); ?>"
                                 data-email="<?php echo htmlspecialchars($row['email']); ?>"
                                 data-mobile="<?php echo htmlspecialchars($row['mobile']); ?>"
                                 data-wallet="<?php echo $row['wallet']; ?>"
                                 data-status="<?php echo $row['status']; ?>">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                              Edit
                           </span>

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

            <!-- ── Edit User Modal ───────────────────────────── -->
            <div class="mm-userlist__modal-overlay" id="mmUserEditOverlay">
               <div class="mm-userlist__modal">
                  <div class="mm-userlist__modal-header">
                     <h2 class="mm-userlist__modal-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                        Edit User
                     </h2>
                     <button type="button" class="mm-userlist__modal-close" id="mmUserEditClose">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                     </button>
                  </div>
                  <form method="POST" class="mm-userlist__edit-form">
                     <input type="hidden" name="type" value="edit_user"/>
                     <input type="hidden" name="id" id="editUserId"/>

                     <div class="mm-userlist__form-row">
                        <div class="mm-userlist__form-group">
                           <label class="mm-userlist__form-label" for="editUserName">Full Name</label>
                           <input type="text" name="name" id="editUserName" class="mm-userlist__form-input" placeholder="Enter name" required/>
                        </div>
                        <div class="mm-userlist__form-group">
                           <label class="mm-userlist__form-label" for="editUserEmail">Email</label>
                           <input type="email" name="email" id="editUserEmail" class="mm-userlist__form-input" placeholder="Enter email"/>
                        </div>
                     </div>

                     <div class="mm-userlist__form-row">
                        <div class="mm-userlist__form-group">
                           <label class="mm-userlist__form-label" for="editUserMobile">Mobile</label>
                           <input type="text" name="mobile" id="editUserMobile" class="mm-userlist__form-input mobile" placeholder="Enter mobile"/>
                        </div>
                        <div class="mm-userlist__form-group">
                           <label class="mm-userlist__form-label" for="editUserWallet">Wallet Balance</label>
                           <input type="text" name="wallet" id="editUserWallet" class="mm-userlist__form-input" placeholder="0.00"/>
                        </div>
                     </div>

                     <div class="mm-userlist__form-group">
                        <label class="mm-userlist__form-label" for="editUserStatus">Status</label>
                        <select name="status" id="editUserStatus" class="mm-userlist__form-input">
                           <option value="1">Active</option>
                           <option value="0">Inactive</option>
                        </select>
                     </div>

                     <div class="mm-userlist__modal-actions">
                        <button type="button" class="mm-userlist__modal-btn mm-userlist__modal-btn--cancel" id="mmUserEditCancel">Cancel</button>
                        <button type="submit" class="mm-userlist__modal-btn mm-userlist__modal-btn--save">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                           Save Changes
                        </button>
                     </div>
                  </form>
               </div>
            </div>

            <!-- ── Add Admin Modal ──────────────────────────── -->
            <div class="mm-userlist__modal-overlay" id="mmAddAdminOverlay">
               <div class="mm-userlist__modal">
                  <div class="mm-userlist__modal-header">
                     <h2 class="mm-userlist__modal-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                        Add New Admin
                     </h2>
                     <button type="button" class="mm-userlist__modal-close" id="mmAddAdminClose">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                     </button>
                  </div>
                  <form method="POST" class="mm-userlist__edit-form" id="mmAddAdminForm">
                     <input type="hidden" name="type" value="create_admin"/>

                     <div class="mm-userlist__form-group">
                        <label class="mm-userlist__form-label" for="addAdminUsername">Username</label>
                        <input type="text" name="username" id="addAdminUsername" class="mm-userlist__form-input" placeholder="Enter admin username" required/>
                     </div>

                     <div class="mm-userlist__form-row">
                        <div class="mm-userlist__form-group">
                           <label class="mm-userlist__form-label" for="addAdminPassword">Password</label>
                           <input type="password" name="password" id="addAdminPassword" class="mm-userlist__form-input" placeholder="Enter password" required/>
                        </div>
                        <div class="mm-userlist__form-group">
                           <label class="mm-userlist__form-label" for="addAdminConfirm">Confirm Password</label>
                           <input type="password" name="confirm_password" id="addAdminConfirm" class="mm-userlist__form-input" placeholder="Re-enter password" required/>
                        </div>
                     </div>

                     <div class="mm-userlist__modal-actions">
                        <button type="button" class="mm-userlist__modal-btn mm-userlist__modal-btn--cancel" id="mmAddAdminCancel">Cancel</button>
                        <button type="submit" class="mm-userlist__modal-btn mm-userlist__modal-btn--save">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                           Create Admin
                        </button>
                     </div>
                  </form>
               </div>
            </div>

            <!-- ── Edit Admin Modal ─────────────────────────── -->
            <div class="mm-userlist__modal-overlay" id="mmEditAdminOverlay">
               <div class="mm-userlist__modal">
                  <div class="mm-userlist__modal-header">
                     <h2 class="mm-userlist__modal-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                        Edit Admin
                     </h2>
                     <button type="button" class="mm-userlist__modal-close" id="mmEditAdminClose">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                     </button>
                  </div>
                  <form method="POST" class="mm-userlist__edit-form" id="mmEditAdminForm">
                     <input type="hidden" name="type" value="edit_admin"/>
                     <input type="hidden" name="id" id="editAdminId"/>

                     <div class="mm-userlist__form-group">
                        <label class="mm-userlist__form-label" for="editAdminUsername">Username</label>
                        <input type="text" name="username" id="editAdminUsername" class="mm-userlist__form-input" placeholder="Enter username" required/>
                     </div>

                     <div class="mm-userlist__form-row">
                        <div class="mm-userlist__form-group">
                           <label class="mm-userlist__form-label" for="editAdminPassword">New Password</label>
                           <input type="password" name="new_password" id="editAdminPassword" class="mm-userlist__form-input" placeholder="Leave blank to keep current"/>
                        </div>
                        <div class="mm-userlist__form-group">
                           <label class="mm-userlist__form-label" for="editAdminConfirm">Confirm Password</label>
                           <input type="password" name="confirm_password" id="editAdminConfirm" class="mm-userlist__form-input" placeholder="Re-enter new password"/>
                        </div>
                     </div>

                     <div class="mm-userlist__modal-actions">
                        <button type="button" class="mm-userlist__modal-btn mm-userlist__modal-btn--cancel" id="mmEditAdminCancel">Cancel</button>
                        <button type="submit" class="mm-userlist__modal-btn mm-userlist__modal-btn--save">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                           Save Changes
                        </button>
                     </div>
                  </form>
               </div>
            </div>

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
// ── User Search + Filter + Edit Modal ─────────────────────────
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
         var type   = card.getAttribute('data-user-type') || 'user';

         var matchesSearch = !query || name.indexOf(query) !== -1 || email.indexOf(query) !== -1 || mobile.indexOf(query) !== -1;

         var matchesFilter;
         if (currentFilter === 'all') {
            matchesFilter = true;
         } else if (currentFilter === 'user') {
            matchesFilter = type === 'user';
         } else if (currentFilter === 'admin') {
            matchesFilter = type === 'admin';
         } else if (currentFilter === 'active') {
            matchesFilter = status === 'active' && type === 'user';
         } else if (currentFilter === 'inactive') {
            matchesFilter = status === 'inactive' && type === 'user';
         } else {
            matchesFilter = true;
         }

         if (matchesSearch && matchesFilter) {
            card.style.display = '';
            visibleCount++;
         } else {
            card.style.display = 'none';
         }
      });

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

   searchInput.addEventListener('input', applyFilters);

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

   // ── Edit Modal ─────────────────────────────────────────────
   var overlay = document.getElementById('mmUserEditOverlay');

   $(document).on('click', '.mm-userlist__card:not(.mm-userlist__card--admin) .mm-userlist__edit-btn', function() {
      var el = $(this);
      $('#editUserId').val(el.data('id'));
      $('#editUserName').val(el.data('name'));
      $('#editUserEmail').val(el.data('email'));
      $('#editUserMobile').val(el.data('mobile'));
      $('#editUserWallet').val(el.data('wallet'));
      $('#editUserStatus').val(String(el.data('status')));
      overlay.classList.add('mm-userlist__modal-overlay--active');
   });

   $('#mmUserEditClose, #mmUserEditCancel').on('click', function() {
      overlay.classList.remove('mm-userlist__modal-overlay--active');
   });

   $(overlay).on('click', function(e) {
      if (e.target === overlay) {
         overlay.classList.remove('mm-userlist__modal-overlay--active');
      }
   });

   // ── Edit Admin Modal ─────────────────────────────────────────
   var editAdminOverlay = document.getElementById('mmEditAdminOverlay');

   $(document).on('click', '.mm-userlist__edit-admin-btn', function() {
      var el = $(this);
      $('#editAdminId').val(el.data('id'));
      $('#editAdminUsername').val(el.data('username'));
      $('#editAdminPassword').val('');
      $('#editAdminConfirm').val('');
      editAdminOverlay.classList.add('mm-userlist__modal-overlay--active');
   });

   $('#mmEditAdminClose, #mmEditAdminCancel').on('click', function() {
      editAdminOverlay.classList.remove('mm-userlist__modal-overlay--active');
   });

   $(editAdminOverlay).on('click', function(e) {
      if (e.target === editAdminOverlay) {
         editAdminOverlay.classList.remove('mm-userlist__modal-overlay--active');
      }
   });

   // Client-side validation for edit admin form
   var editAdminForm = document.getElementById('mmEditAdminForm');
   if (editAdminForm) {
      editAdminForm.addEventListener('submit', function(e) {
         var pw = document.getElementById('editAdminPassword').value;
         var confirm = document.getElementById('editAdminConfirm').value;

         if (pw || confirm) {
            if (pw !== confirm) {
               e.preventDefault();
               e.stopImmediatePropagation();
               swal('Password Mismatch', 'New password and confirmation do not match.', 'error');
               return false;
            }
            if (pw.length < 4) {
               e.preventDefault();
               e.stopImmediatePropagation();
               swal('Password Too Short', 'Password must be at least 4 characters.', 'error');
               return false;
            }
         }
      });
   }

   // ── Add Admin Modal ──────────────────────────────────────────
   var addAdminOverlay = document.getElementById('mmAddAdminOverlay');

   $('#mmAddAdminBtn').on('click', function() {
      $('#addAdminUsername').val('');
      $('#addAdminPassword').val('');
      $('#addAdminConfirm').val('');
      addAdminOverlay.classList.add('mm-userlist__modal-overlay--active');
   });

   $('#mmAddAdminClose, #mmAddAdminCancel').on('click', function() {
      addAdminOverlay.classList.remove('mm-userlist__modal-overlay--active');
   });

   $(addAdminOverlay).on('click', function(e) {
      if (e.target === addAdminOverlay) {
         addAdminOverlay.classList.remove('mm-userlist__modal-overlay--active');
      }
   });

   // Client-side validation for add admin form
   var addAdminForm = document.getElementById('mmAddAdminForm');
   if (addAdminForm) {
      addAdminForm.addEventListener('submit', function(e) {
         var pw = document.getElementById('addAdminPassword').value;
         var confirm = document.getElementById('addAdminConfirm').value;

         if (pw !== confirm) {
            e.preventDefault();
            e.stopImmediatePropagation();
            swal('Password Mismatch', 'Password and confirmation do not match.', 'error');
            return false;
         }

         if (pw.length < 4) {
            e.preventDefault();
            e.stopImmediatePropagation();
            swal('Password Too Short', 'Password must be at least 4 characters.', 'error');
            return false;
         }
      });
   }
})();
</script>
<!-- Plugin used-->
</body>
</html>