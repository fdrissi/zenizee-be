<?php
   include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/magicmate-page-profile.css">
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

         <?php $admindata = $evmulti->query("SELECT * FROM `admin`")->fetch_assoc(); ?>

         <div class="mm-profile">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-profile__header">
               <div class="mm-profile__header-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
               </div>
               <div class="mm-profile__header-text">
                  <h1 class="mm-profile__title">Admin Profile</h1>
                  <p class="mm-profile__subtitle">Manage your login credentials</p>
               </div>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-profile__card">
               <form method="POST" enctype="multipart/form-data" class="mm-profile__form">

                  <!-- Hidden fields -->
                  <input type="hidden" name="type" value="edit_profile"/>
                  <input type="hidden" name="id" value="1"/>

                  <!-- Section: Login Credentials -->
                  <div class="mm-profile__section">
                     <div class="mm-profile__section-header">
                        <div class="mm-profile__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </div>
                        <div class="mm-profile__section-text">
                           <h2 class="mm-profile__section-title">Login Credentials</h2>
                           <p class="mm-profile__section-desc">Update your admin username and password</p>
                        </div>
                     </div>

                     <!-- Username -->
                     <div class="mm-profile__field">
                        <label class="mm-profile__label" for="profileUsername">Username</label>
                        <input
                           type="text"
                           id="profileUsername"
                           name="username"
                           class="mm-profile__input"
                           placeholder="Enter username"
                           value="<?php echo htmlspecialchars($admindata["username"]); ?>"
                           required
                        />
                     </div>

                     <!-- Password -->
                     <div class="mm-profile__field">
                        <label class="mm-profile__label" for="profilePassword">Password</label>
                        <input
                           type="text"
                           id="profilePassword"
                           name="password"
                           class="mm-profile__input"
                           placeholder="Enter password"
                           value="<?php echo htmlspecialchars($admindata["password"]); ?>"
                           required
                        />
                        <div class="mm-profile__callout">
                           <div class="mm-profile__callout-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                           </div>
                           <div class="mm-profile__callout-text">
                              <strong>Security tip:</strong> Make sure to use a strong password to protect your admin account.
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-profile__divider" />

                  <!-- Actions -->
                  <div class="mm-profile__actions">
                     <button type="submit" class="mm-profile__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                        Update Profile
                     </button>
                     <a href="dashboard.php" class="mm-profile__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-profile -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<!-- Plugin used-->
</body>
</html>
