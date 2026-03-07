<?php
   include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/magicmate-page-galleryedit.css">
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
                ->query(
                    "select * from tbl_gallery where id=" .
                        $_GET["id"] .
                        " and sponsore_id=" .
                        $sdata["id"] .
                        ""
                )
                ->fetch_assoc();
            $count = $evmulti->query(
                "select * from tbl_gallery where id=" .
                    $_GET["id"] .
                    " and sponsore_id=" .
                    $sdata["id"] .
                    ""
            )->num_rows;
            if ($count != 0) { ?>

         <div class="mm-galleryedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-galleryedit__header">
               <a href="list_gallery.php" class="mm-galleryedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Gallery
               </a>
               <h1 class="mm-galleryedit__title">Edit Gallery Image</h1>
               <p class="mm-galleryedit__subtitle">Update the gallery image and settings</p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-galleryedit__card">
               <form method="POST" enctype="multipart/form-data" action="" class="mm-galleryedit__form">

                  <!-- Hidden fields -->
                  <input type="hidden" name="type" value="edit_gallery"/>
                  <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>

                  <!-- Section: Event Selection -->
                  <div class="mm-galleryedit__section">
                     <div class="mm-galleryedit__section-header">
                        <div class="mm-galleryedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div class="mm-galleryedit__section-text">
                           <h2 class="mm-galleryedit__section-title">Event Selection</h2>
                           <p class="mm-galleryedit__section-desc">Choose which event this image belongs to</p>
                        </div>
                     </div>

                     <div class="mm-galleryedit__field">
                        <label class="mm-galleryedit__label" for="galleryEventEdit">Select Event</label>
                        <select name="eid" id="galleryEventEdit" class="mm-galleryedit__select select2-single" required>
                           <option value="" disabled selected>Select Event</option>
                           <?php
                              $cat = $evmulti->query(
                                  "select * from tbl_event where sponsore_id=" . $sdata["id"] . " and event_status='Pending'"
                              );
                              while ($row = $cat->fetch_assoc()) { ?>
                           <option value="<?php echo $row["id"]; ?>" <?php if (
                              $data["eid"] == $row["id"]
                              ) {
                              echo "selected";
                              } ?>><?php echo $row["title"]; ?></option>
                           <?php }
                              ?>
                        </select>
                     </div>
                  </div>

                  <hr class="mm-galleryedit__divider" />

                  <!-- Section: Gallery Image -->
                  <div class="mm-galleryedit__section">
                     <div class="mm-galleryedit__section-header">
                        <div class="mm-galleryedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        </div>
                        <div class="mm-galleryedit__section-text">
                           <h2 class="mm-galleryedit__section-title">Gallery Image</h2>
                           <p class="mm-galleryedit__section-desc">Upload a new image to replace the current one</p>
                        </div>
                     </div>

                     <div class="mm-galleryedit__field">
                        <div class="mm-galleryedit__upload">
                           <input type="file" name="cat_img" class="mm-galleryedit__upload-input" />
                           <div class="mm-galleryedit__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-galleryedit__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-galleryedit__upload-hint">PNG, JPG or WebP &mdash; landscape format recommended</p>
                        </div>
                        <?php if (!empty($data['img'])) { ?>
                           <div class="mm-galleryedit__preview">
                              <img src="<?php echo $data['img']; ?>" alt="Current gallery image" class="mm-galleryedit__preview-thumb" />
                              <div class="mm-galleryedit__preview-info">
                                 <span class="mm-galleryedit__preview-label">Current Image</span>
                                 <span class="mm-galleryedit__preview-note">Upload a new file to replace</span>
                              </div>
                           </div>
                        <?php } ?>
                     </div>
                  </div>

                  <hr class="mm-galleryedit__divider" />

                  <!-- Section: Status -->
                  <div class="mm-galleryedit__section">
                     <div class="mm-galleryedit__section-header">
                        <div class="mm-galleryedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-galleryedit__section-text">
                           <h2 class="mm-galleryedit__section-title">Status</h2>
                           <p class="mm-galleryedit__section-desc">Control gallery image visibility</p>
                        </div>
                     </div>

                     <div class="mm-galleryedit__field">
                        <label class="mm-galleryedit__label">Status</label>
                        <div class="mm-galleryedit__toggle-group">
                           <div class="mm-galleryedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="statusPublish"
                                 <?php if ($data["status"] == 1) echo 'checked'; ?>
                                 required
                              />
                              <label for="statusPublish" class="mm-galleryedit__toggle-label mm-galleryedit__toggle-label--active">
                                 <span class="mm-galleryedit__toggle-dot mm-galleryedit__toggle-dot--active"></span>
                                 Publish
                              </label>
                           </div>
                           <div class="mm-galleryedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="statusUnpublish"
                                 <?php if ($data["status"] == 0) echo 'checked'; ?>
                              />
                              <label for="statusUnpublish" class="mm-galleryedit__toggle-label mm-galleryedit__toggle-label--inactive">
                                 <span class="mm-galleryedit__toggle-dot mm-galleryedit__toggle-dot--inactive"></span>
                                 Unpublish
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-galleryedit__divider" />

                  <!-- Submit -->
                  <div class="mm-galleryedit__actions">
                     <button type="submit" class="mm-galleryedit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                        Update Gallery
                     </button>
                     <a href="list_gallery.php" class="mm-galleryedit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-galleryedit -->

         <?php } else { ?>

         <div class="mm-galleryedit">

            <!-- ── Fallback: Not Found ─────────────────────── -->
            <header class="mm-galleryedit__header">
               <a href="list_gallery.php" class="mm-galleryedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Gallery
               </a>
               <h1 class="mm-galleryedit__title">Gallery Not Found</h1>
               <p class="mm-galleryedit__subtitle">This gallery image was not found or does not belong to you</p>
            </header>

            <div class="mm-galleryedit__card">
               <div class="mm-galleryedit__empty">
                  <div class="mm-galleryedit__empty-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                  </div>
                  <h3 class="mm-galleryedit__empty-title">Check Own Gallery Or Add New Gallery</h3>
                  <p class="mm-galleryedit__empty-desc">The gallery item you are looking for could not be found. You can browse your gallery or add a new image.</p>
                  <a href="add_gallery.php" class="mm-galleryedit__empty-action">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                     Add Gallery
                  </a>
               </div>
            </div>

         </div>
         <!-- /.mm-galleryedit -->

         <?php }
            } else {
                 ?>

         <div class="mm-galleryedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-galleryedit__header">
               <a href="list_gallery.php" class="mm-galleryedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Gallery
               </a>
               <h1 class="mm-galleryedit__title">Add Gallery Image</h1>
               <p class="mm-galleryedit__subtitle">Upload a new image to the event gallery</p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-galleryedit__card">
               <form method="POST" enctype="multipart/form-data" action="" class="mm-galleryedit__form">

                  <!-- Hidden field -->
                  <input type="hidden" name="type" value="add_gallery"/>

                  <!-- Section: Event Selection -->
                  <div class="mm-galleryedit__section">
                     <div class="mm-galleryedit__section-header">
                        <div class="mm-galleryedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div class="mm-galleryedit__section-text">
                           <h2 class="mm-galleryedit__section-title">Event Selection</h2>
                           <p class="mm-galleryedit__section-desc">Choose which event this image belongs to</p>
                        </div>
                     </div>

                     <div class="mm-galleryedit__field">
                        <label class="mm-galleryedit__label" for="galleryEventAdd">Select Event</label>
                        <select name="eid" id="galleryEventAdd" class="mm-galleryedit__select select2-single" required>
                           <option value="" disabled selected>Select Event</option>
                           <?php
                              $cat = $evmulti->query(
                                  "select * from tbl_event where sponsore_id=" . $sdata["id"] . " and event_status='Pending'"
                              );
                              while ($row = $cat->fetch_assoc()) { ?>
                           <option value="<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                           <?php }
                              ?>
                        </select>
                     </div>
                  </div>

                  <hr class="mm-galleryedit__divider" />

                  <!-- Section: Gallery Image -->
                  <div class="mm-galleryedit__section">
                     <div class="mm-galleryedit__section-header">
                        <div class="mm-galleryedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        </div>
                        <div class="mm-galleryedit__section-text">
                           <h2 class="mm-galleryedit__section-title">Gallery Image</h2>
                           <p class="mm-galleryedit__section-desc">Upload an image for the event gallery</p>
                        </div>
                     </div>

                     <div class="mm-galleryedit__field">
                        <div class="mm-galleryedit__upload">
                           <input type="file" name="cat_img" class="mm-galleryedit__upload-input" required />
                           <div class="mm-galleryedit__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-galleryedit__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-galleryedit__upload-hint">PNG, JPG or WebP &mdash; landscape format recommended</p>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-galleryedit__divider" />

                  <!-- Section: Status -->
                  <div class="mm-galleryedit__section">
                     <div class="mm-galleryedit__section-header">
                        <div class="mm-galleryedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-galleryedit__section-text">
                           <h2 class="mm-galleryedit__section-title">Status</h2>
                           <p class="mm-galleryedit__section-desc">Control gallery image visibility</p>
                        </div>
                     </div>

                     <div class="mm-galleryedit__field">
                        <label class="mm-galleryedit__label">Status</label>
                        <div class="mm-galleryedit__toggle-group">
                           <div class="mm-galleryedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="statusPublishAdd"
                                 required
                              />
                              <label for="statusPublishAdd" class="mm-galleryedit__toggle-label mm-galleryedit__toggle-label--active">
                                 <span class="mm-galleryedit__toggle-dot mm-galleryedit__toggle-dot--active"></span>
                                 Publish
                              </label>
                           </div>
                           <div class="mm-galleryedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="statusUnpublishAdd"
                              />
                              <label for="statusUnpublishAdd" class="mm-galleryedit__toggle-label mm-galleryedit__toggle-label--inactive">
                                 <span class="mm-galleryedit__toggle-dot mm-galleryedit__toggle-dot--inactive"></span>
                                 Unpublish
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-galleryedit__divider" />

                  <!-- Submit -->
                  <div class="mm-galleryedit__actions">
                     <button type="submit" class="mm-galleryedit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M12 5v14M5 12l7-7 7 7"/>
                        </svg>
                        Save Gallery Image
                     </button>
                     <a href="list_gallery.php" class="mm-galleryedit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-galleryedit -->

         <?php
            } ?>

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<!-- Plugin used-->
</body>
</html>
