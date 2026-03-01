<?php
   include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/magicmate-page-restrictedit.css">
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
                ->query("select * from tbl_restriction where id=" . $_GET["id"])
                ->fetch_assoc();
         ?>

         <div class="mm-restrictedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-restrictedit__header">
               <a href="list_restriction.php" class="mm-restrictedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Restrictions
               </a>
               <h1 class="mm-restrictedit__title">Edit Restriction</h1>
               <p class="mm-restrictedit__subtitle">Update details for <strong><?php echo htmlspecialchars($data["title"]); ?></strong></p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-restrictedit__card">
               <form method="POST" enctype="multipart/form-data" action="" class="mm-restrictedit__form">

                  <!-- Hidden fields -->
                  <input type="hidden" name="type" value="edit_restriction"/>
                  <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>

                  <!-- Section: Restriction Details -->
                  <div class="mm-restrictedit__section">
                     <div class="mm-restrictedit__section-header">
                        <div class="mm-restrictedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div class="mm-restrictedit__section-text">
                           <h2 class="mm-restrictedit__section-title">Restriction Details</h2>
                           <p class="mm-restrictedit__section-desc">Name and description of the restriction</p>
                        </div>
                     </div>

                     <!-- Restriction Name -->
                     <div class="mm-restrictedit__field">
                        <label class="mm-restrictedit__label" for="restrictionTitle">Restriction Name</label>
                        <input
                           type="text"
                           id="restrictionTitle"
                           name="title"
                           class="mm-restrictedit__input"
                           placeholder="Enter restriction name"
                           value="<?php echo htmlspecialchars($data["title"]); ?>"
                           required
                        />
                     </div>
                  </div>

                  <hr class="mm-restrictedit__divider" />

                  <!-- Section: Restriction Image -->
                  <div class="mm-restrictedit__section">
                     <div class="mm-restrictedit__section-header">
                        <div class="mm-restrictedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        </div>
                        <div class="mm-restrictedit__section-text">
                           <h2 class="mm-restrictedit__section-title">Restriction Image</h2>
                           <p class="mm-restrictedit__section-desc">Upload an icon or image for this restriction</p>
                        </div>
                     </div>

                     <div class="mm-restrictedit__field">
                        <div class="mm-restrictedit__upload">
                           <input type="file" name="cat_img" class="mm-restrictedit__upload-input" />
                           <div class="mm-restrictedit__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-restrictedit__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-restrictedit__upload-hint">PNG, SVG or JPG &mdash; square format recommended</p>
                        </div>
                        <?php if (!empty($data['img'])) { ?>
                           <div class="mm-restrictedit__preview">
                              <img src="<?php echo $data['img']; ?>" alt="Current restriction image" class="mm-restrictedit__preview-thumb" />
                              <div class="mm-restrictedit__preview-info">
                                 <span class="mm-restrictedit__preview-label">Current Image</span>
                                 <span class="mm-restrictedit__preview-note">Upload a new file to replace</span>
                              </div>
                           </div>
                        <?php } ?>
                     </div>
                  </div>

                  <hr class="mm-restrictedit__divider" />

                  <!-- Section: Visibility -->
                  <div class="mm-restrictedit__section">
                     <div class="mm-restrictedit__section-header">
                        <div class="mm-restrictedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-restrictedit__section-text">
                           <h2 class="mm-restrictedit__section-title">Status</h2>
                           <p class="mm-restrictedit__section-desc">Control restriction visibility</p>
                        </div>
                     </div>

                     <!-- Status Toggle -->
                     <div class="mm-restrictedit__field">
                        <label class="mm-restrictedit__label">Status</label>
                        <div class="mm-restrictedit__toggle-group">
                           <div class="mm-restrictedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="statusActive"
                                 <?php if ($data["status"] == 1) echo 'checked'; ?>
                                 required
                              />
                              <label for="statusActive" class="mm-restrictedit__toggle-label mm-restrictedit__toggle-label--active">
                                 <span class="mm-restrictedit__toggle-dot mm-restrictedit__toggle-dot--active"></span>
                                 Active
                              </label>
                           </div>
                           <div class="mm-restrictedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="statusInactive"
                                 <?php if ($data["status"] == 0) echo 'checked'; ?>
                              />
                              <label for="statusInactive" class="mm-restrictedit__toggle-label mm-restrictedit__toggle-label--inactive">
                                 <span class="mm-restrictedit__toggle-dot mm-restrictedit__toggle-dot--inactive"></span>
                                 Inactive
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-restrictedit__divider" />

                  <!-- Submit -->
                  <div class="mm-restrictedit__actions">
                     <button type="submit" class="mm-restrictedit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                        Update Restriction
                     </button>
                     <a href="list_restriction.php" class="mm-restrictedit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-restrictedit -->

         <?php } else { ?>

         <div class="mm-restrictedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-restrictedit__header">
               <a href="list_restriction.php" class="mm-restrictedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Restrictions
               </a>
               <h1 class="mm-restrictedit__title">Add Restriction</h1>
               <p class="mm-restrictedit__subtitle">Create a new restriction for your events</p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-restrictedit__card">
               <form method="POST" enctype="multipart/form-data" action="" class="mm-restrictedit__form">

                  <!-- Hidden field -->
                  <input type="hidden" name="type" value="add_restriction"/>

                  <!-- Section: Restriction Details -->
                  <div class="mm-restrictedit__section">
                     <div class="mm-restrictedit__section-header">
                        <div class="mm-restrictedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div class="mm-restrictedit__section-text">
                           <h2 class="mm-restrictedit__section-title">Restriction Details</h2>
                           <p class="mm-restrictedit__section-desc">Name and description of the restriction</p>
                        </div>
                     </div>

                     <!-- Restriction Name -->
                     <div class="mm-restrictedit__field">
                        <label class="mm-restrictedit__label" for="restrictionTitleAdd">Restriction Name</label>
                        <input
                           type="text"
                           id="restrictionTitleAdd"
                           name="title"
                           class="mm-restrictedit__input"
                           placeholder="Enter restriction name"
                           required
                        />
                     </div>
                  </div>

                  <hr class="mm-restrictedit__divider" />

                  <!-- Section: Restriction Image -->
                  <div class="mm-restrictedit__section">
                     <div class="mm-restrictedit__section-header">
                        <div class="mm-restrictedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        </div>
                        <div class="mm-restrictedit__section-text">
                           <h2 class="mm-restrictedit__section-title">Restriction Image</h2>
                           <p class="mm-restrictedit__section-desc">Upload an icon or image for this restriction</p>
                        </div>
                     </div>

                     <div class="mm-restrictedit__field">
                        <div class="mm-restrictedit__upload">
                           <input type="file" name="cat_img" class="mm-restrictedit__upload-input" required />
                           <div class="mm-restrictedit__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-restrictedit__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-restrictedit__upload-hint">PNG, SVG or JPG &mdash; square format recommended</p>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-restrictedit__divider" />

                  <!-- Section: Visibility -->
                  <div class="mm-restrictedit__section">
                     <div class="mm-restrictedit__section-header">
                        <div class="mm-restrictedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-restrictedit__section-text">
                           <h2 class="mm-restrictedit__section-title">Status</h2>
                           <p class="mm-restrictedit__section-desc">Control restriction visibility</p>
                        </div>
                     </div>

                     <!-- Status Toggle -->
                     <div class="mm-restrictedit__field">
                        <label class="mm-restrictedit__label">Status</label>
                        <div class="mm-restrictedit__toggle-group">
                           <div class="mm-restrictedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="statusActiveAdd"
                                 required
                              />
                              <label for="statusActiveAdd" class="mm-restrictedit__toggle-label mm-restrictedit__toggle-label--active">
                                 <span class="mm-restrictedit__toggle-dot mm-restrictedit__toggle-dot--active"></span>
                                 Active
                              </label>
                           </div>
                           <div class="mm-restrictedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="statusInactiveAdd"
                              />
                              <label for="statusInactiveAdd" class="mm-restrictedit__toggle-label mm-restrictedit__toggle-label--inactive">
                                 <span class="mm-restrictedit__toggle-dot mm-restrictedit__toggle-dot--inactive"></span>
                                 Inactive
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-restrictedit__divider" />

                  <!-- Submit -->
                  <div class="mm-restrictedit__actions">
                     <button type="submit" class="mm-restrictedit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M12 5v14M5 12l7-7 7 7"/>
                        </svg>
                        Save Restriction
                     </button>
                     <a href="list_restriction.php" class="mm-restrictedit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-restrictedit -->

         <?php } ?>

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<!-- Plugin used-->
</body>
</html>
