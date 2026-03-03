<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

   include "filemanager/head.php";
   if (isset($_SESSION["evename"])) { ?>
<script>
   window.location.href="dashboard.php";
</script>
<?php } ?>
<!-- Zenizee Login — per-page stylesheet -->
<link rel="stylesheet" href="assets/css/magicmate-page-login.css">

<!-- Mark body for standalone login page styling -->
<script>document.body.classList.add('mm-login-page');</script>

<!-- login page start -->
<div class="mm-login">
  <div class="mm-login__wrapper">

    <!-- Branding -->
    <div class="mm-login__brand">
      <?php if (!empty($set["weblogo"])): ?>
        <a href="javascript:void(0);">
          <img class="mm-login__logo" src="<?php echo $set["weblogo"]; ?>" alt="Zenizee">
        </a>
      <?php else: ?>
        <span class="mm-login__brand-text">Zenizee</span>
      <?php endif; ?>
    </div>

    <!-- Card -->
    <div class="mm-login__card">
      <h4 class="mm-login__title">Sign in to account</h4>
      <p class="mm-login__subtitle">Enter your credentials to access the admin panel</p>

      <form class="theme-form" autocomplete="off">
        <input type="hidden" name="type" value="login"/>

        <!-- Email / Username -->
        <div class="mm-login__group">
          <label class="mm-login__label" for="mm-login-username">Email Address</label>
          <div class="mm-login__input-wrap">
            <input
              class="mm-login__input"
              id="mm-login-username"
              type="text"
              name="username"
              required
              placeholder="admin@zenizee.com"
              autocomplete="username"
            >
            <span class="mm-login__input-icon">
              <!-- Feather: mail -->
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-10 7L2 7"/></svg>
            </span>
          </div>
        </div>

        <!-- Password -->
        <div class="mm-login__group">
          <label class="mm-login__label" for="mm-login-password">Password</label>
          <div class="mm-login__input-wrap">
            <input
              class="mm-login__input"
              id="mm-login-password"
              type="password"
              name="password"
              required
              placeholder="*********"
              autocomplete="current-password"
            >
            <span class="mm-login__input-icon">
              <!-- Feather: lock -->
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
            </span>
            <button type="button" class="mm-login__pw-toggle" id="mm-pw-toggle" aria-label="Toggle password visibility">
              <!-- Feather: eye -->
              <svg id="mm-pw-icon-show" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              <!-- Feather: eye-off (hidden by default) -->
              <svg id="mm-pw-icon-hide" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
            </button>
          </div>
        </div>

        <!-- Account Type -->
        <div class="mm-login__group">
          <label class="mm-login__label" for="mm-login-stype">Account Type</label>
          <div class="mm-login__input-wrap">
            <select
              class="mm-login__select"
              id="mm-login-stype"
              name="stype"
              required
            >
              <option value="">Select a type</option>
              <option value="mowner">Master Admin</option>
              <option value="sowner">Organizer Panel</option>
            </select>
            <span class="mm-login__input-icon">
              <!-- Feather: shield -->
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </span>
          </div>
        </div>

        <!-- Submit -->
        <div class="mm-login__group mm-login__group--submit">
          <button class="mm-login__submit" type="submit">Sign In</button>
        </div>
      </form>
    </div>

    <!-- Footer -->
    <div class="mm-login__footer">
      &copy; <?php echo date('Y'); ?> <?php echo !empty($set['webname']) ? htmlspecialchars($set['webname']) : 'Zenizee'; ?>. All rights reserved.
    </div>

  </div>
</div>

<?php include "filemanager/script.php"; ?>

<!-- Password toggle (standalone, no dependency on Cuba's script.js show-hide) -->
<script>
(function() {
  var toggle = document.getElementById('mm-pw-toggle');
  var input  = document.getElementById('mm-login-password');
  var iconShow = document.getElementById('mm-pw-icon-show');
  var iconHide = document.getElementById('mm-pw-icon-hide');
  if (!toggle || !input) return;

  toggle.addEventListener('click', function() {
    var isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    iconShow.style.display = isPassword ? 'none' : 'block';
    iconHide.style.display = isPassword ? 'block' : 'none';
  });

  // On form submit, revert password field to type=password (security)
  var form = toggle.closest('form');
  if (form) {
    form.addEventListener('submit', function() {
      input.type = 'password';
      iconShow.style.display = 'block';
      iconHide.style.display = 'none';
    });
  }
})();
</script>
</body>
</html>
