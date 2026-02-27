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
<!-- login page start-->
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-5"><img class="bg-img-cover bg-center" src="images/bg.jpg" alt="looginpage"></div>
      <div class="col-xl-7 p-0">
         <div class="login-card login-dark">
            <div>
               <div><a class="logo text-center" href="javascript:void(0);">
                <img class="img-fluid for-light" src="<?php echo $set[
                  "weblogo"
                  ]; ?>" alt="looginpage"><img class="img-fluid for-dark" src="<?php echo $set[
                  "weblogo"
                  ]; ?>" alt="looginpage"></a></div>
               <div class="login-main">
                  <form class="theme-form">
                     <h4>Sign in to account</h4>
                     <p>Enter your email & password to login</p>
                     <div class="form-group">
                        <label class="col-form-label">Email Address</label>
                        <input class="form-control" type="text" name="username" required="" placeholder="CSCODETECH">
                        <input type="hidden" name="type" value="login"/>
                     </div>
                     <div class="form-group">
                        <label class="col-form-label">Password</label>
                        <div class="form-input position-relative">
                           <input class="form-control" type="password"
                            name="password" required="" placeholder="*********">
                           <div class="show-hide"><span class="show">                         </span></div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>Type?</label>
                        <select class="form-control" name="stype" required>
                           <option value="">Select A Type</option>
                           <option value="mowner">Master Admin</option>
                           <option value="sowner">Organizer Panel</option>
                        </select>
                     </div>
                     <div class="form-group mb-0">
                        <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php include "filemanager/script.php"; ?>
</div>
</body>
</html>
