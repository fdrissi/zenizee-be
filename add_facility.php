<?php
   include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/magicmate-page-facilityedit.css">
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
                ->query("select * from tbl_facility where id=" . $_GET["id"])
                ->fetch_assoc();
         ?>

         <div class="mm-facilityedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-facilityedit__header">
               <a href="list_facility.php" class="mm-facilityedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Facilities
               </a>
               <h1 class="mm-facilityedit__title">Edit Facility</h1>
               <p class="mm-facilityedit__subtitle">Update details for <strong><?php echo htmlspecialchars($data["title"]); ?></strong></p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-facilityedit__card">
               <form method="POST" enctype="multipart/form-data" action="" class="mm-facilityedit__form">

                  <!-- Hidden fields -->
                  <input type="hidden" name="type" value="edit_facility"/>
                  <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>

                  <!-- Section: Facility Details -->
                  <div class="mm-facilityedit__section">
                     <div class="mm-facilityedit__section-header">
                        <div class="mm-facilityedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        </div>
                        <div class="mm-facilityedit__section-text">
                           <h2 class="mm-facilityedit__section-title">Facility Details</h2>
                           <p class="mm-facilityedit__section-desc">Name and description of the facility</p>
                        </div>
                     </div>

                     <!-- Facility Name -->
                     <div class="mm-facilityedit__field">
                        <label class="mm-facilityedit__label" for="facilityTitle">Facility Name</label>
                        <input
                           type="text"
                           id="facilityTitle"
                           name="title"
                           class="mm-facilityedit__input"
                           placeholder="Enter facility name"
                           value="<?php echo htmlspecialchars($data["title"]); ?>"
                           required
                        />
                     </div>
                  </div>

                  <hr class="mm-facilityedit__divider" />

                  <!-- Section: Facility Image -->
                  <div class="mm-facilityedit__section">
                     <div class="mm-facilityedit__section-header">
                        <div class="mm-facilityedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        </div>
                        <div class="mm-facilityedit__section-text">
                           <h2 class="mm-facilityedit__section-title">Facility Image</h2>
                           <p class="mm-facilityedit__section-desc">Upload an icon or image for this facility</p>
                        </div>
                     </div>

                     <div class="mm-facilityedit__field">
                        <div class="mm-facilityedit__upload">
                           <input type="file" name="cat_img" class="mm-facilityedit__upload-input" />
                           <div class="mm-facilityedit__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-facilityedit__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-facilityedit__upload-hint">PNG, SVG or JPG &mdash; square format recommended</p>
                        </div>
                        <?php if (!empty($data['img'])) { ?>
                           <div class="mm-facilityedit__preview">
                              <img src="<?php echo $data['img']; ?>" alt="Current facility image" class="mm-facilityedit__preview-thumb" />
                              <div class="mm-facilityedit__preview-info">
                                 <span class="mm-facilityedit__preview-label">Current Image</span>
                                 <span class="mm-facilityedit__preview-note">Upload a new file to replace</span>
                              </div>
                           </div>
                        <?php } ?>
                     </div>
                  </div>

                  <hr class="mm-facilityedit__divider" />

                  <!-- Section: Visibility -->
                  <div class="mm-facilityedit__section">
                     <div class="mm-facilityedit__section-header">
                        <div class="mm-facilityedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-facilityedit__section-text">
                           <h2 class="mm-facilityedit__section-title">Status</h2>
                           <p class="mm-facilityedit__section-desc">Control facility visibility</p>
                        </div>
                     </div>

                     <!-- Status Toggle -->
                     <div class="mm-facilityedit__field">
                        <label class="mm-facilityedit__label">Status</label>
                        <div class="mm-facilityedit__toggle-group">
                           <div class="mm-facilityedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="statusActive"
                                 <?php if ($data["status"] == 1) echo 'checked'; ?>
                                 required
                              />
                              <label for="statusActive" class="mm-facilityedit__toggle-label mm-facilityedit__toggle-label--active">
                                 <span class="mm-facilityedit__toggle-dot mm-facilityedit__toggle-dot--active"></span>
                                 Active
                              </label>
                           </div>
                           <div class="mm-facilityedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="statusInactive"
                                 <?php if ($data["status"] == 0) echo 'checked'; ?>
                              />
                              <label for="statusInactive" class="mm-facilityedit__toggle-label mm-facilityedit__toggle-label--inactive">
                                 <span class="mm-facilityedit__toggle-dot mm-facilityedit__toggle-dot--inactive"></span>
                                 Inactive
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-facilityedit__divider" />

                  <!-- Submit -->
                  <div class="mm-facilityedit__actions">
                     <button type="submit" class="mm-facilityedit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                        Update Facility
                     </button>
                     <a href="list_facility.php" class="mm-facilityedit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-facilityedit -->

         <?php } else { ?>

         <div class="mm-facilityedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-facilityedit__header">
               <a href="list_facility.php" class="mm-facilityedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Facilities
               </a>
               <h1 class="mm-facilityedit__title">Add Facility</h1>
               <p class="mm-facilityedit__subtitle">Create a new facility for your events</p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-facilityedit__card">
               <form method="POST" enctype="multipart/form-data" action="" class="mm-facilityedit__form">

                  <!-- Hidden field -->
                  <input type="hidden" name="type" value="add_facility"/>

                  <!-- Section: Facility Details -->
                  <div class="mm-facilityedit__section">
                     <div class="mm-facilityedit__section-header">
                        <div class="mm-facilityedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        </div>
                        <div class="mm-facilityedit__section-text">
                           <h2 class="mm-facilityedit__section-title">Facility Details</h2>
                           <p class="mm-facilityedit__section-desc">Name and description of the facility</p>
                        </div>
                     </div>

                     <!-- Facility Name -->
                     <div class="mm-facilityedit__field">
                        <label class="mm-facilityedit__label" for="facilityTitleAdd">Facility Name</label>
                        <input
                           type="text"
                           id="facilityTitleAdd"
                           name="title"
                           class="mm-facilityedit__input"
                           placeholder="Enter facility name"
                           required
                        />
                     </div>
                  </div>

                  <hr class="mm-facilityedit__divider" />

                  <!-- Section: Facility Image -->
                  <div class="mm-facilityedit__section">
                     <div class="mm-facilityedit__section-header">
                        <div class="mm-facilityedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        </div>
                        <div class="mm-facilityedit__section-text">
                           <h2 class="mm-facilityedit__section-title">Facility Image</h2>
                           <p class="mm-facilityedit__section-desc">Upload an icon or image for this facility</p>
                        </div>
                     </div>

                     <div class="mm-facilityedit__field">
                        <div class="mm-facilityedit__upload">
                           <input type="file" name="cat_img" class="mm-facilityedit__upload-input" required />
                           <div class="mm-facilityedit__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-facilityedit__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-facilityedit__upload-hint">PNG, SVG or JPG &mdash; square format recommended</p>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-facilityedit__divider" />

                  <!-- Section: Visibility -->
                  <div class="mm-facilityedit__section">
                     <div class="mm-facilityedit__section-header">
                        <div class="mm-facilityedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-facilityedit__section-text">
                           <h2 class="mm-facilityedit__section-title">Status</h2>
                           <p class="mm-facilityedit__section-desc">Control facility visibility</p>
                        </div>
                     </div>

                     <!-- Status Toggle -->
                     <div class="mm-facilityedit__field">
                        <label class="mm-facilityedit__label">Status</label>
                        <div class="mm-facilityedit__toggle-group">
                           <div class="mm-facilityedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="statusActiveAdd"
                                 required
                              />
                              <label for="statusActiveAdd" class="mm-facilityedit__toggle-label mm-facilityedit__toggle-label--active">
                                 <span class="mm-facilityedit__toggle-dot mm-facilityedit__toggle-dot--active"></span>
                                 Active
                              </label>
                           </div>
                           <div class="mm-facilityedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="statusInactiveAdd"
                              />
                              <label for="statusInactiveAdd" class="mm-facilityedit__toggle-label mm-facilityedit__toggle-label--inactive">
                                 <span class="mm-facilityedit__toggle-dot mm-facilityedit__toggle-dot--inactive"></span>
                                 Inactive
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-facilityedit__divider" />

                  <!-- Submit -->
                  <div class="mm-facilityedit__actions">
                     <button type="submit" class="mm-facilityedit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M12 5v14M5 12l7-7 7 7"/>
                        </svg>
                        Save Facility
                     </button>
                     <a href="list_facility.php" class="mm-facilityedit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-facilityedit -->

         <?php } ?>

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<!-- Plugin used-->
</body>
</html>
