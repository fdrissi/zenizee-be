<?php
   include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/zenizee-page-oprofile.css">
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

         <div class="mm-oprofile">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-oprofile__header">
               <div class="mm-oprofile__header-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
               </div>
               <div class="mm-oprofile__header-text">
                  <h1 class="mm-oprofile__title">My Profile</h1>
                  <p class="mm-oprofile__subtitle">Manage your organizer account details</p>
               </div>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-oprofile__card">
               <form method="POST" enctype="multipart/form-data" action="" class="mm-oprofile__form">

                  <!-- Hidden fields -->
                  <input type="hidden" name="type" value="edit_ownprofile"/>
                  <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>

                  <!-- ── Section 1: Profile Image ───────────── -->
                  <div class="mm-oprofile__section">
                     <div class="mm-oprofile__section-header">
                        <div class="mm-oprofile__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        </div>
                        <div class="mm-oprofile__section-text">
                           <h2 class="mm-oprofile__section-title">Profile Photo</h2>
                           <p class="mm-oprofile__section-desc">Upload your profile picture</p>
                        </div>
                     </div>

                     <div class="mm-oprofile__field">
                        <div class="mm-oprofile__upload">
                           <input type="file" name="cat_img" class="mm-oprofile__upload-input" />
                           <div class="mm-oprofile__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-oprofile__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-oprofile__upload-hint">PNG, JPG or WEBP &mdash; square format recommended</p>
                        </div>
                        <?php if (!empty($sdata['img'])) { ?>
                           <div class="mm-oprofile__preview">
                              <img src="<?php echo htmlspecialchars($sdata['img']); ?>" alt="Current profile photo" class="mm-oprofile__preview-thumb mm-oprofile__preview-thumb--circle" />
                              <div class="mm-oprofile__preview-info">
                                 <span class="mm-oprofile__preview-label">Current Photo</span>
                                 <span class="mm-oprofile__preview-note">Upload a new file to replace</span>
                              </div>
                           </div>
                        <?php } ?>
                     </div>
                  </div>

                  <hr class="mm-oprofile__divider" />

                  <!-- ── Section 2: Personal Information ───── -->
                  <div class="mm-oprofile__section">
                     <div class="mm-oprofile__section-header">
                        <div class="mm-oprofile__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div class="mm-oprofile__section-text">
                           <h2 class="mm-oprofile__section-title">Personal Information</h2>
                           <p class="mm-oprofile__section-desc">Your name and contact details</p>
                        </div>
                     </div>

                     <!-- Full Name -->
                     <div class="mm-oprofile__field">
                        <label class="mm-oprofile__label" for="profileTitle">Full Name</label>
                        <input
                           type="text"
                           id="profileTitle"
                           name="title"
                           class="mm-oprofile__input"
                           placeholder="Enter your full name"
                           value="<?php echo htmlspecialchars($sdata["title"]); ?>"
                           required
                        />
                     </div>

                     <!-- Email Address -->
                     <div class="mm-oprofile__field">
                        <label class="mm-oprofile__label" for="profileEmail">Email Address</label>
                        <input
                           type="email"
                           id="profileEmail"
                           name="email"
                           class="mm-oprofile__input"
                           placeholder="e.g. organizer@example.com"
                           value="<?php echo htmlspecialchars($sdata["email"]); ?>"
                           required
                        />
                        <input type="hidden" name="id" value="1"/>
                     </div>

                     <!-- Phone Number -->
                     <div class="mm-oprofile__field">
                        <label class="mm-oprofile__label" for="profileMobile">Phone Number</label>
                        <input
                           type="text"
                           id="profileMobile"
                           name="mobile"
                           class="mm-oprofile__input numberonly"
                           placeholder="e.g. +1 555 000 0000"
                           value="<?php echo htmlspecialchars($sdata["mobile"]); ?>"
                           required
                        />
                     </div>
                  </div>

                  <hr class="mm-oprofile__divider" />

                  <!-- ── Section 3: Security ────────────────── -->
                  <div class="mm-oprofile__section">
                     <div class="mm-oprofile__section-header">
                        <div class="mm-oprofile__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </div>
                        <div class="mm-oprofile__section-text">
                           <h2 class="mm-oprofile__section-title">Password</h2>
                           <p class="mm-oprofile__section-desc">Update your login password</p>
                        </div>
                     </div>

                     <div class="mm-oprofile__field">
                        <label class="mm-oprofile__label" for="profilePassword">Password</label>
                        <input
                           type="text"
                           id="profilePassword"
                           name="password"
                           class="mm-oprofile__input"
                           placeholder="Enter your password"
                           value="<?php echo htmlspecialchars($sdata["password"]); ?>"
                           required
                        />
                        <div class="mm-oprofile__callout">
                           <div class="mm-oprofile__callout-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                           </div>
                           <div class="mm-oprofile__callout-text">
                              Your <strong>email</strong> and this <strong>password</strong> are used to log in.
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-oprofile__divider" />

                  <!-- ── Actions ────────────────────────────── -->
                  <div class="mm-oprofile__actions">
                     <button type="submit" class="mm-oprofile__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                        Update Profile
                     </button>
                     <a href="dashboard.php" class="mm-oprofile__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-oprofile -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<!-- Plugin used-->
</body>
</html>
