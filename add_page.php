<?php
if (isset($_POST["type"]) && in_array($_POST["type"], ["add_page", "edit_page"])) {
    ob_start();
    require __DIR__ . "/filemanager/manager.php";
    $output = ob_get_clean();
    $data = json_decode($output, true);
    if (!empty($data["Result"]) && $data["Result"] === "true" && !empty($data["action"])) {
        header("Location: " . $data["action"]);
        exit;
    }
}
include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/magicmate-page-pageform.css">
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

         <?php
            $isEdit = isset($_GET["id"]);
            if ($isEdit) {
               $data = $evmulti
                  ->query("select * from tbl_page where id=" . $_GET["id"])
                  ->fetch_assoc();
            }
         ?>

         <div class="mm-pageform">

            <!-- Page Header -->
            <header class="mm-pageform__header">
               <a href="list_page.php" class="mm-pageform__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Pages
               </a>
               <h1 class="mm-pageform__title"><?php echo $isEdit ? 'Edit Page' : 'Add Page'; ?></h1>
               <p class="mm-pageform__subtitle"><?php echo $isEdit ? 'Update the content and settings for this page.' : 'Create a new page with rich content for your platform.'; ?></p>
            </header>

            <!-- Form Card -->
            <div class="mm-pageform__card">
               <form method="post" enctype="multipart/form-data" onsubmit="return postForm()" class="mm-pageform__form">

                  <!-- Hidden fields -->
                  <?php if ($isEdit) { ?>
                     <input type="hidden" name="type" value="edit_page"/>
                     <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>
                  <?php } else { ?>
                     <input type="hidden" name="type" value="add_page"/>
                  <?php } ?>

                  <!-- Page Title -->
                  <div class="mm-pageform__field">
                     <label class="mm-pageform__label" for="pageTitle">Page Title</label>
                     <input
                        type="text"
                        id="pageTitle"
                        name="ctitle"
                        class="mm-pageform__input mm-pageform__input--lg"
                        placeholder="e.g. Terms of Service, Privacy Policy, About Us..."
                        value="<?php echo $isEdit ? htmlspecialchars($data['title']) : ''; ?>"
                        required
                     />
                  </div>

                  <hr class="mm-pageform__divider" />

                  <!-- Page Content (Summernote) -->
                  <div class="mm-pageform__field">
                     <label class="mm-pageform__label" for="cdesc">
                        Page Content
                        <span class="mm-pageform__label-hint">(rich text)</span>
                     </label>
                     <div class="mm-pageform__editor-wrap">
                        <textarea class="summernote" rows="5" id="cdesc" name="cdesc"><?php echo $isEdit ? $data['description'] : ''; ?></textarea>
                     </div>
                  </div>

                  <hr class="mm-pageform__divider" />

                  <!-- Status Toggle -->
                  <div class="mm-pageform__field">
                     <label class="mm-pageform__label">Status</label>
                     <div class="mm-pageform__status-group">
                        <div class="mm-pageform__status-option">
                           <input
                              type="radio"
                              name="cstatus"
                              value="1"
                              id="statusPublish"
                              <?php if ($isEdit) { if ($data['status'] == 1) echo 'checked'; } else { echo 'checked'; } ?>
                              required
                           />
                           <label for="statusPublish" class="mm-pageform__status-label mm-pageform__status-label--publish">
                              <span class="mm-pageform__status-dot mm-pageform__status-dot--publish"></span>
                              Published
                           </label>
                        </div>
                        <div class="mm-pageform__status-option">
                           <input
                              type="radio"
                              name="cstatus"
                              value="0"
                              id="statusUnpublish"
                              <?php if ($isEdit && $data['status'] == 0) echo 'checked'; ?>
                           />
                           <label for="statusUnpublish" class="mm-pageform__status-label mm-pageform__status-label--unpublish">
                              <span class="mm-pageform__status-dot mm-pageform__status-dot--unpublish"></span>
                              Unpublished
                           </label>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-pageform__divider" />

                  <!-- Submit -->
                  <div class="mm-pageform__actions">
                     <button type="submit" class="mm-pageform__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <?php if ($isEdit) { ?>
                              <path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                           <?php } else { ?>
                              <path d="M12 5v14M5 12h14"/>
                           <?php } ?>
                        </svg>
                        <?php echo $isEdit ? 'Save Changes' : 'Create Page'; ?>
                     </button>
                     <a href="list_page.php" class="mm-pageform__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-pageform -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<!-- Plugin used-->
</body>
</html>
