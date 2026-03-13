<?php
   include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/zenizee-page-profile.css">
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

         <?php $admindata = $evmulti->query("SELECT * FROM `admin` WHERE username='" . mysqli_real_escape_string($evmulti, $_SESSION["evename"]) . "'")->fetch_assoc(); ?>

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
                  <input type="hidden" name="id" value="<?php echo $admindata['id']; ?>"/>

                  <!-- Section: Username -->
                  <div class="mm-profile__section">
                     <div class="mm-profile__section-header">
                        <div class="mm-profile__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div class="mm-profile__section-text">
                           <h2 class="mm-profile__section-title">Username</h2>
                           <p class="mm-profile__section-desc">Your admin login username</p>
                        </div>
                     </div>

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
                  </div>

                  <hr class="mm-profile__divider" />

                  <!-- Section: Change Password -->
                  <div class="mm-profile__section">
                     <div class="mm-profile__section-header">
                        <div class="mm-profile__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        </div>
                        <div class="mm-profile__section-text">
                           <h2 class="mm-profile__section-title">Change Password</h2>
                           <p class="mm-profile__section-desc">Verify your current password to set a new one</p>
                        </div>
                     </div>

                     <!-- Current Password -->
                     <div class="mm-profile__field">
                        <label class="mm-profile__label" for="profileCurrentPassword">Current Password</label>
                        <div class="mm-profile__input-wrap">
                           <input
                              type="password"
                              id="profileCurrentPassword"
                              name="current_password"
                              class="mm-profile__input"
                              placeholder="Enter your current password"
                              required
                           />
                           <button type="button" class="mm-profile__toggle-pw" data-target="profileCurrentPassword" aria-label="Toggle password visibility">
                              <svg class="mm-profile__pw-show" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                              <svg class="mm-profile__pw-hide" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                           </button>
                        </div>
                     </div>

                     <!-- New Password -->
                     <div class="mm-profile__field">
                        <label class="mm-profile__label" for="profileNewPassword">New Password</label>
                        <div class="mm-profile__input-wrap">
                           <input
                              type="password"
                              id="profileNewPassword"
                              name="new_password"
                              class="mm-profile__input"
                              placeholder="Enter new password"
                              required
                           />
                           <button type="button" class="mm-profile__toggle-pw" data-target="profileNewPassword" aria-label="Toggle password visibility">
                              <svg class="mm-profile__pw-show" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                              <svg class="mm-profile__pw-hide" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                           </button>
                        </div>
                     </div>

                     <!-- Confirm New Password -->
                     <div class="mm-profile__field">
                        <label class="mm-profile__label" for="profileConfirmPassword">Confirm New Password</label>
                        <div class="mm-profile__input-wrap">
                           <input
                              type="password"
                              id="profileConfirmPassword"
                              name="confirm_password"
                              class="mm-profile__input"
                              placeholder="Re-enter new password"
                              required
                           />
                           <button type="button" class="mm-profile__toggle-pw" data-target="profileConfirmPassword" aria-label="Toggle password visibility">
                              <svg class="mm-profile__pw-show" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                              <svg class="mm-profile__pw-hide" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                           </button>
                        </div>
                     </div>

                     <div class="mm-profile__callout">
                        <div class="mm-profile__callout-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div class="mm-profile__callout-text">
                           <strong>Security tip:</strong> Use a strong password with a mix of letters, numbers and symbols.
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
<script>
(function() {
   // ── Password visibility toggle ──────────────────────────────
   document.querySelectorAll('.mm-profile__toggle-pw').forEach(function(btn) {
      btn.addEventListener('click', function() {
         var input = document.getElementById(this.getAttribute('data-target'));
         if (!input) return;
         var isPassword = input.type === 'password';
         input.type = isPassword ? 'text' : 'password';
         this.classList.toggle('mm-profile__toggle-pw--visible', isPassword);
      });
   });

   // ── Client-side password match validation ───────────────────
   var form = document.querySelector('.mm-profile__form');
   if (form) {
      form.addEventListener('submit', function(e) {
         var newPw = document.getElementById('profileNewPassword').value;
         var confirmPw = document.getElementById('profileConfirmPassword').value;

         if (newPw !== confirmPw) {
            e.preventDefault();
            e.stopImmediatePropagation();
            swal('Password Mismatch', 'New password and confirmation do not match.', 'error');
            return false;
         }

         if (newPw.length < 4) {
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
