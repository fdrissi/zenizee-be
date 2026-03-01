<?php
if (isset($_POST["type"]) && in_array($_POST["type"], ["add_category", "edit_category"])) {
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
<link rel="stylesheet" href="assets/css/magicmate-page-catform.css">
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
                  ->query("select * from tbl_category where id=" . $_GET["id"])
                  ->fetch_assoc();
            }
         ?>

         <div class="mm-catform">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-catform__header">
               <a href="category.php" class="mm-catform__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Categories
               </a>
               <h1 class="mm-catform__title"><?php echo $isEdit ? 'Edit Category' : 'Add Category'; ?></h1>
               <p class="mm-catform__subtitle"><?php echo $isEdit ? 'Update the details for this category below.' : 'Create a new category for your events.'; ?></p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-catform__card">
               <form method="post" enctype="multipart/form-data" class="mm-catform__form">

                  <!-- Hidden fields -->
                  <?php if ($isEdit) { ?>
                     <input type="hidden" name="type" value="edit_category"/>
                     <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>
                  <?php } else { ?>
                     <input type="hidden" name="type" value="add_category"/>
                  <?php } ?>

                  <!-- Category Name -->
                  <div class="mm-catform__field">
                     <label class="mm-catform__label" for="catName">Category Name</label>
                     <input
                        type="text"
                        id="catName"
                        name="title"
                        class="mm-catform__input mm-catform__input--lg"
                        placeholder="e.g. Music Festivals, Tech Conferences..."
                        value="<?php echo $isEdit ? htmlspecialchars($data['title']) : ''; ?>"
                        required
                     />
                  </div>

                  <hr class="mm-catform__divider" />

                  <!-- Image Uploads Row -->
                  <div class="mm-catform__row">

                     <!-- Small Icon Upload -->
                     <div class="mm-catform__field">
                        <label class="mm-catform__label">
                           Category Icon
                           <span class="mm-catform__label-hint">(small)</span>
                        </label>
                        <div class="mm-catform__upload mm-catform__upload--compact">
                           <input type="file" name="cat_img" class="mm-catform__upload-input" <?php echo $isEdit ? '' : 'required'; ?> />
                           <div class="mm-catform__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-catform__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-catform__upload-hint">PNG, SVG or JPG recommended</p>
                        </div>
                        <?php if ($isEdit && !empty($data['img'])) { ?>
                           <div class="mm-catform__preview">
                              <img src="<?php echo $data['img']; ?>" alt="Current icon" class="mm-catform__preview-thumb mm-catform__preview-thumb--sm" />
                              <div class="mm-catform__preview-info">
                                 <span class="mm-catform__preview-label">Current Icon</span>
                                 <span class="mm-catform__preview-note">Upload a new file to replace</span>
                              </div>
                           </div>
                        <?php } ?>
                     </div>

                     <!-- Cover Image Upload -->
                     <div class="mm-catform__field">
                        <label class="mm-catform__label">
                           Cover Image
                           <span class="mm-catform__label-hint">(large)</span>
                        </label>
                        <div class="mm-catform__upload mm-catform__upload--compact">
                           <input type="file" name="cover_img" class="mm-catform__upload-input" <?php echo $isEdit ? '' : 'required'; ?> />
                           <div class="mm-catform__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                           </div>
                           <p class="mm-catform__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-catform__upload-hint">1200 x 600px recommended</p>
                        </div>
                        <?php if ($isEdit && !empty($data['cover'])) { ?>
                           <div class="mm-catform__preview">
                              <img src="<?php echo $data['cover']; ?>" alt="Current cover" class="mm-catform__preview-thumb" />
                              <div class="mm-catform__preview-info">
                                 <span class="mm-catform__preview-label">Current Cover</span>
                                 <span class="mm-catform__preview-note">Upload a new file to replace</span>
                              </div>
                           </div>
                        <?php } ?>
                     </div>

                  </div>

                  <hr class="mm-catform__divider" />

                  <!-- Status Toggle -->
                  <div class="mm-catform__field">
                     <label class="mm-catform__label">Status</label>
                     <div class="mm-catform__status-group">
                        <div class="mm-catform__status-option">
                           <input
                              type="radio"
                              name="status"
                              value="1"
                              id="statusPublish"
                              <?php if ($isEdit) { if ($data['status'] == 1) echo 'checked'; } else { echo 'checked'; } ?>
                              required
                           />
                           <label for="statusPublish" class="mm-catform__status-label mm-catform__status-label--publish">
                              <span class="mm-catform__status-dot mm-catform__status-dot--publish"></span>
                              Published
                           </label>
                        </div>
                        <div class="mm-catform__status-option">
                           <input
                              type="radio"
                              name="status"
                              value="0"
                              id="statusUnpublish"
                              <?php if ($isEdit && $data['status'] == 0) echo 'checked'; ?>
                           />
                           <label for="statusUnpublish" class="mm-catform__status-label mm-catform__status-label--unpublish">
                              <span class="mm-catform__status-dot mm-catform__status-dot--unpublish"></span>
                              Unpublished
                           </label>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-catform__divider" />

                  <!-- Submit -->
                  <div class="mm-catform__actions">
                     <button type="submit" class="mm-catform__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <?php if ($isEdit) { ?>
                              <path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                           <?php } else { ?>
                              <path d="M12 5v14M5 12h14"/>
                           <?php } ?>
                        </svg>
                        <?php echo $isEdit ? 'Save Changes' : 'Create Category'; ?>
                     </button>
                     <a href="category.php" class="mm-catform__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-catform -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<!-- Plugin used-->
</body>
</html>
