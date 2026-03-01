<?php
   include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/magicmate-page-orgedit.css">
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

         <?php if (isset($_GET["id"])) {
            $data = $evmulti
                ->query("select * from tbl_sponsore where id=" . $_GET["id"] . "")
                ->fetch_assoc();
         ?>

         <div class="mm-orgedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-orgedit__header">
               <a href="list_sponsore.php" class="mm-orgedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Organizers
               </a>
               <h1 class="mm-orgedit__title">Edit Organizer</h1>
               <p class="mm-orgedit__subtitle">Update profile for <strong><?php echo htmlspecialchars($data["title"]); ?></strong></p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-orgedit__card">
               <form method="POST" enctype="multipart/form-data" action="" class="mm-orgedit__form">

                  <!-- Hidden fields -->
                  <input type="hidden" name="type" value="edit_sponsore"/>
                  <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>

                  <!-- ── Section 1: Identity ─────────────────── -->
                  <div class="mm-orgedit__section">
                     <div class="mm-orgedit__section-header">
                        <div class="mm-orgedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div class="mm-orgedit__section-text">
                           <h2 class="mm-orgedit__section-title">Organizer Identity</h2>
                           <p class="mm-orgedit__section-desc">Basic information about the organizer</p>
                        </div>
                     </div>

                     <!-- Organizer Name (read-only in edit mode) -->
                     <div class="mm-orgedit__field">
                        <label class="mm-orgedit__label">Organizer Name</label>
                        <div class="mm-orgedit__readonly">
                           <span class="mm-orgedit__readonly-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                           </span>
                           <span class="mm-orgedit__readonly-value"><?php echo htmlspecialchars($data["title"]); ?></span>
                           <span class="mm-orgedit__readonly-badge">Locked</span>
                        </div>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($data["title"]); ?>" style="display:none;" required />
                     </div>

                     <!-- Email Address -->
                     <div class="mm-orgedit__field">
                        <label class="mm-orgedit__label" for="orgEmail">Email Address</label>
                        <input
                           type="text"
                           id="orgEmail"
                           name="email"
                           class="mm-orgedit__input"
                           placeholder="e.g. organizer@example.com"
                           value="<?php echo htmlspecialchars($data["email"]); ?>"
                           required
                        />
                     </div>

                     <!-- Phone Number -->
                     <div class="mm-orgedit__field">
                        <label class="mm-orgedit__label" for="orgMobile">Phone Number</label>
                        <input
                           type="text"
                           id="orgMobile"
                           name="mobile"
                           class="mm-orgedit__input mobile"
                           placeholder="e.g. +1 555 000 0000"
                           value="<?php echo htmlspecialchars($data["mobile"]); ?>"
                           required
                        />
                     </div>
                  </div>

                  <hr class="mm-orgedit__divider" />

                  <!-- ── Section 2: Profile Image ───────────── -->
                  <div class="mm-orgedit__section">
                     <div class="mm-orgedit__section-header">
                        <div class="mm-orgedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        </div>
                        <div class="mm-orgedit__section-text">
                           <h2 class="mm-orgedit__section-title">Profile Image</h2>
                           <p class="mm-orgedit__section-desc">Upload the organizer's profile photo</p>
                        </div>
                     </div>

                     <div class="mm-orgedit__field">
                        <div class="mm-orgedit__upload">
                           <input type="file" name="cat_img" class="mm-orgedit__upload-input" />
                           <div class="mm-orgedit__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-orgedit__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-orgedit__upload-hint">PNG, JPG or WEBP &mdash; square format recommended</p>
                        </div>
                        <?php if (!empty($data['img'])) { ?>
                           <div class="mm-orgedit__preview">
                              <img src="<?php echo htmlspecialchars($data['img']); ?>" alt="Current organizer photo" class="mm-orgedit__preview-thumb mm-orgedit__preview-thumb--circle" />
                              <div class="mm-orgedit__preview-info">
                                 <span class="mm-orgedit__preview-label">Current Photo</span>
                                 <span class="mm-orgedit__preview-note">Upload a new file to replace</span>
                              </div>
                           </div>
                        <?php } ?>
                     </div>
                  </div>

                  <hr class="mm-orgedit__divider" />

                  <!-- ── Section 3: Credentials ─────────────── -->
                  <div class="mm-orgedit__section">
                     <div class="mm-orgedit__section-header">
                        <div class="mm-orgedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </div>
                        <div class="mm-orgedit__section-text">
                           <h2 class="mm-orgedit__section-title">Login Credentials</h2>
                           <p class="mm-orgedit__section-desc">Set the organizer's login password</p>
                        </div>
                     </div>

                     <div class="mm-orgedit__field">
                        <label class="mm-orgedit__label" for="orgPassword">Password</label>
                        <input
                           type="text"
                           id="orgPassword"
                           name="password"
                           class="mm-orgedit__input"
                           placeholder="Enter password"
                           value="<?php echo htmlspecialchars($data["password"]); ?>"
                           required
                        />
                        <div class="mm-orgedit__callout">
                           <div class="mm-orgedit__callout-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                           </div>
                           <div class="mm-orgedit__callout-text">
                              The organizer will use their <strong>email</strong> and this <strong>password</strong> to log in to the app.
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-orgedit__divider" />

                  <!-- ── Section 4: Commission ──────────────── -->
                  <div class="mm-orgedit__section">
                     <div class="mm-orgedit__section-header">
                        <div class="mm-orgedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="19" y1="5" x2="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/></svg>
                        </div>
                        <div class="mm-orgedit__section-text">
                           <h2 class="mm-orgedit__section-title">Commission Rate</h2>
                           <p class="mm-orgedit__section-desc">Platform commission on organizer's ticket sales</p>
                        </div>
                     </div>

                     <div class="mm-orgedit__field">
                        <label class="mm-orgedit__label" for="orgCommission">Commission Percentage</label>
                        <div class="mm-orgedit__input-suffix-wrap">
                           <input
                              type="number"
                              id="orgCommission"
                              name="commission"
                              step="0.01"
                              min="0"
                              max="100"
                              class="mm-orgedit__input mm-orgedit__input--suffix"
                              placeholder="e.g. 10.00"
                              value="<?php echo htmlspecialchars($data["commission"]); ?>"
                              required
                           />
                           <span class="mm-orgedit__input-suffix">%</span>
                        </div>
                        <div class="mm-orgedit__callout">
                           <div class="mm-orgedit__callout-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                           </div>
                           <div class="mm-orgedit__callout-text">
                              This percentage will be deducted from each <strong>completed ticket sale</strong> made through this organizer's events.
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-orgedit__divider" />

                  <!-- ── Section 5: Visibility ──────────────── -->
                  <div class="mm-orgedit__section">
                     <div class="mm-orgedit__section-header">
                        <div class="mm-orgedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-orgedit__section-text">
                           <h2 class="mm-orgedit__section-title">Account Status</h2>
                           <p class="mm-orgedit__section-desc">Control whether this organizer account is active</p>
                        </div>
                     </div>

                     <div class="mm-orgedit__field">
                        <label class="mm-orgedit__label">Status</label>
                        <div class="mm-orgedit__toggle-group">
                           <div class="mm-orgedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="statusActive"
                                 <?php if ($data["status"] == 1) echo 'checked'; ?>
                                 required
                              />
                              <label for="statusActive" class="mm-orgedit__toggle-label mm-orgedit__toggle-label--publish">
                                 <span class="mm-orgedit__toggle-dot mm-orgedit__toggle-dot--publish"></span>
                                 Active
                              </label>
                           </div>
                           <div class="mm-orgedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="statusInactive"
                                 <?php if ($data["status"] == 0) echo 'checked'; ?>
                              />
                              <label for="statusInactive" class="mm-orgedit__toggle-label mm-orgedit__toggle-label--unpublish">
                                 <span class="mm-orgedit__toggle-dot mm-orgedit__toggle-dot--unpublish"></span>
                                 Inactive
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-orgedit__divider" />

                  <!-- ── Actions ────────────────────────────── -->
                  <div class="mm-orgedit__actions">
                     <button type="submit" class="mm-orgedit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                        Update Organizer
                     </button>
                     <a href="list_sponsore.php" class="mm-orgedit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-orgedit -->

         <?php } else { ?>

         <div class="mm-orgedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-orgedit__header">
               <a href="list_sponsore.php" class="mm-orgedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Organizers
               </a>
               <h1 class="mm-orgedit__title">Add Organizer</h1>
               <p class="mm-orgedit__subtitle">Create a new organizer account on the platform</p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-orgedit__card">
               <form method="POST" enctype="multipart/form-data" action="" class="mm-orgedit__form">

                  <!-- Hidden field -->
                  <input type="hidden" name="type" value="add_sponsore"/>

                  <!-- ── Section 1: Identity ─────────────────── -->
                  <div class="mm-orgedit__section">
                     <div class="mm-orgedit__section-header">
                        <div class="mm-orgedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div class="mm-orgedit__section-text">
                           <h2 class="mm-orgedit__section-title">Organizer Identity</h2>
                           <p class="mm-orgedit__section-desc">Basic information about the organizer</p>
                        </div>
                     </div>

                     <!-- Organizer Name -->
                     <div class="mm-orgedit__field">
                        <label class="mm-orgedit__label" for="addOrgTitle">Organizer Name</label>
                        <input
                           type="text"
                           id="addOrgTitle"
                           name="title"
                           class="mm-orgedit__input"
                           placeholder="Enter organizer name"
                           required
                        />
                     </div>

                     <!-- Email Address -->
                     <div class="mm-orgedit__field">
                        <label class="mm-orgedit__label" for="addOrgEmail">Email Address</label>
                        <input
                           type="text"
                           id="addOrgEmail"
                           name="email"
                           class="mm-orgedit__input"
                           placeholder="e.g. organizer@example.com"
                           required
                        />
                     </div>

                     <!-- Phone Number -->
                     <div class="mm-orgedit__field">
                        <label class="mm-orgedit__label" for="addOrgMobile">Phone Number</label>
                        <input
                           type="text"
                           id="addOrgMobile"
                           name="mobile"
                           class="mm-orgedit__input mobile"
                           placeholder="e.g. +1 555 000 0000"
                           required
                        />
                     </div>
                  </div>

                  <hr class="mm-orgedit__divider" />

                  <!-- ── Section 2: Profile Image ───────────── -->
                  <div class="mm-orgedit__section">
                     <div class="mm-orgedit__section-header">
                        <div class="mm-orgedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        </div>
                        <div class="mm-orgedit__section-text">
                           <h2 class="mm-orgedit__section-title">Profile Image</h2>
                           <p class="mm-orgedit__section-desc">Upload the organizer's profile photo</p>
                        </div>
                     </div>

                     <div class="mm-orgedit__field">
                        <div class="mm-orgedit__upload">
                           <input type="file" name="cat_img" class="mm-orgedit__upload-input" required />
                           <div class="mm-orgedit__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-orgedit__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-orgedit__upload-hint">PNG, JPG or WEBP &mdash; square format recommended</p>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-orgedit__divider" />

                  <!-- ── Section 3: Credentials ─────────────── -->
                  <div class="mm-orgedit__section">
                     <div class="mm-orgedit__section-header">
                        <div class="mm-orgedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </div>
                        <div class="mm-orgedit__section-text">
                           <h2 class="mm-orgedit__section-title">Login Credentials</h2>
                           <p class="mm-orgedit__section-desc">Set the organizer's login password</p>
                        </div>
                     </div>

                     <div class="mm-orgedit__field">
                        <label class="mm-orgedit__label" for="addOrgPassword">Password</label>
                        <input
                           type="password"
                           id="addOrgPassword"
                           name="password"
                           class="mm-orgedit__input"
                           placeholder="Enter a secure password"
                           required
                        />
                        <div class="mm-orgedit__callout">
                           <div class="mm-orgedit__callout-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                           </div>
                           <div class="mm-orgedit__callout-text">
                              The organizer will use their <strong>email</strong> and this <strong>password</strong> to log in to the app.
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-orgedit__divider" />

                  <!-- ── Section 4: Commission ──────────────── -->
                  <div class="mm-orgedit__section">
                     <div class="mm-orgedit__section-header">
                        <div class="mm-orgedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="19" y1="5" x2="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/></svg>
                        </div>
                        <div class="mm-orgedit__section-text">
                           <h2 class="mm-orgedit__section-title">Commission Rate</h2>
                           <p class="mm-orgedit__section-desc">Platform commission on organizer's ticket sales</p>
                        </div>
                     </div>

                     <div class="mm-orgedit__field">
                        <label class="mm-orgedit__label" for="addOrgCommission">Commission Percentage</label>
                        <div class="mm-orgedit__input-suffix-wrap">
                           <input
                              type="number"
                              id="addOrgCommission"
                              name="commission"
                              step="0.01"
                              min="0"
                              max="100"
                              class="mm-orgedit__input mm-orgedit__input--suffix"
                              placeholder="e.g. 10.00"
                              required
                           />
                           <span class="mm-orgedit__input-suffix">%</span>
                        </div>
                        <div class="mm-orgedit__callout">
                           <div class="mm-orgedit__callout-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                           </div>
                           <div class="mm-orgedit__callout-text">
                              This percentage will be deducted from each <strong>completed ticket sale</strong> made through this organizer's events.
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-orgedit__divider" />

                  <!-- ── Section 5: Visibility ──────────────── -->
                  <div class="mm-orgedit__section">
                     <div class="mm-orgedit__section-header">
                        <div class="mm-orgedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-orgedit__section-text">
                           <h2 class="mm-orgedit__section-title">Account Status</h2>
                           <p class="mm-orgedit__section-desc">Control whether this organizer account is active</p>
                        </div>
                     </div>

                     <div class="mm-orgedit__field">
                        <label class="mm-orgedit__label">Status</label>
                        <div class="mm-orgedit__toggle-group">
                           <div class="mm-orgedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="addStatusActive"
                                 checked
                                 required
                              />
                              <label for="addStatusActive" class="mm-orgedit__toggle-label mm-orgedit__toggle-label--publish">
                                 <span class="mm-orgedit__toggle-dot mm-orgedit__toggle-dot--publish"></span>
                                 Active
                              </label>
                           </div>
                           <div class="mm-orgedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="addStatusInactive"
                              />
                              <label for="addStatusInactive" class="mm-orgedit__toggle-label mm-orgedit__toggle-label--unpublish">
                                 <span class="mm-orgedit__toggle-dot mm-orgedit__toggle-dot--unpublish"></span>
                                 Inactive
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-orgedit__divider" />

                  <!-- ── Actions ────────────────────────────── -->
                  <div class="mm-orgedit__actions">
                     <button type="submit" class="mm-orgedit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                        Save Organizer
                     </button>
                     <a href="list_sponsore.php" class="mm-orgedit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-orgedit -->

         <?php } ?>

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<!-- Plugin used-->
</body>
</html>
