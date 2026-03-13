<?php
   include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/zenizee-page-coveredit.css">
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
                    "select * from tbl_cover where id=" .
                        $_GET["id"] .
                        " and sponsore_id=" .
                        $sdata["id"] .
                        ""
                )
                ->fetch_assoc();
            $count = $evmulti->query(
                "select * from tbl_cover where id=" .
                    $_GET["id"] .
                    " and sponsore_id=" .
                    $sdata["id"] .
                    ""
            )->num_rows;
            if ($count != 0) { ?>

         <div class="mm-coveredit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-coveredit__header">
               <a href="list_cover.php" class="mm-coveredit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Cover Images
               </a>
               <h1 class="mm-coveredit__title">Edit Cover Image</h1>
               <p class="mm-coveredit__subtitle">Update cover image for your event</p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-coveredit__card">
               <form method="POST" enctype="multipart/form-data" action="" class="mm-coveredit__form">

                  <!-- Hidden fields -->
                  <input type="hidden" name="type" value="edit_cover"/>
                  <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>

                  <!-- Section: Event Selection -->
                  <div class="mm-coveredit__section">
                     <div class="mm-coveredit__section-header">
                        <div class="mm-coveredit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div class="mm-coveredit__section-text">
                           <h2 class="mm-coveredit__section-title">Event Selection</h2>
                           <p class="mm-coveredit__section-desc">Choose which event this cover image belongs to</p>
                        </div>
                     </div>

                     <!-- Select Event -->
                     <div class="mm-coveredit__field">
                        <label class="mm-coveredit__label" for="coverEventEdit">Select Event</label>
                        <select name="eid" id="coverEventEdit" class="mm-coveredit__select select2-single" required>
                           <option value="" disabled>Select Event</option>
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

                  <hr class="mm-coveredit__divider" />

                  <!-- Section: Cover Image -->
                  <div class="mm-coveredit__section">
                     <div class="mm-coveredit__section-header">
                        <div class="mm-coveredit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        </div>
                        <div class="mm-coveredit__section-text">
                           <h2 class="mm-coveredit__section-title">Cover Image</h2>
                           <p class="mm-coveredit__section-desc">Upload a new cover image to replace the current one</p>
                        </div>
                     </div>

                     <div class="mm-coveredit__field">
                        <div class="mm-coveredit__upload">
                           <input type="file" name="cat_img" class="mm-coveredit__upload-input" />
                           <div class="mm-coveredit__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-coveredit__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-coveredit__upload-hint">PNG, JPG or WebP &mdash; landscape format recommended</p>
                        </div>
                        <?php if (!empty($data['img'])) { ?>
                           <div class="mm-coveredit__preview">
                              <img src="<?php echo $data['img']; ?>" alt="Current cover image" class="mm-coveredit__preview-thumb" />
                              <div class="mm-coveredit__preview-info">
                                 <span class="mm-coveredit__preview-label">Current Image</span>
                                 <span class="mm-coveredit__preview-note">Upload a new file to replace</span>
                              </div>
                           </div>
                        <?php } ?>
                     </div>
                  </div>

                  <hr class="mm-coveredit__divider" />

                  <!-- Section: Status -->
                  <div class="mm-coveredit__section">
                     <div class="mm-coveredit__section-header">
                        <div class="mm-coveredit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-coveredit__section-text">
                           <h2 class="mm-coveredit__section-title">Status</h2>
                           <p class="mm-coveredit__section-desc">Control cover image visibility</p>
                        </div>
                     </div>

                     <!-- Status Toggle -->
                     <div class="mm-coveredit__field">
                        <label class="mm-coveredit__label">Status</label>
                        <div class="mm-coveredit__toggle-group">
                           <div class="mm-coveredit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="statusPublish"
                                 <?php if ($data["status"] == 1) echo 'checked'; ?>
                                 required
                              />
                              <label for="statusPublish" class="mm-coveredit__toggle-label mm-coveredit__toggle-label--active">
                                 <span class="mm-coveredit__toggle-dot mm-coveredit__toggle-dot--active"></span>
                                 Publish
                              </label>
                           </div>
                           <div class="mm-coveredit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="statusUnpublish"
                                 <?php if ($data["status"] == 0) echo 'checked'; ?>
                              />
                              <label for="statusUnpublish" class="mm-coveredit__toggle-label mm-coveredit__toggle-label--inactive">
                                 <span class="mm-coveredit__toggle-dot mm-coveredit__toggle-dot--inactive"></span>
                                 Unpublish
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-coveredit__divider" />

                  <!-- Submit -->
                  <div class="mm-coveredit__actions">
                     <button type="submit" class="mm-coveredit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                        Update Cover Image
                     </button>
                     <a href="list_cover.php" class="mm-coveredit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-coveredit -->

         <?php } else { ?>

         <div class="mm-coveredit">

            <!-- ── Fallback: Not Found ────────────────────── -->
            <header class="mm-coveredit__header">
               <a href="list_cover.php" class="mm-coveredit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Cover Images
               </a>
               <h1 class="mm-coveredit__title">Cover Image Not Found</h1>
               <p class="mm-coveredit__subtitle">The requested cover image could not be located</p>
            </header>

            <div class="mm-coveredit__card">
               <div class="mm-coveredit__empty">
                  <div class="mm-coveredit__empty-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                  </div>
                  <h3 class="mm-coveredit__empty-title">Check Own Cover Images Or Add New Cover Images</h3>
                  <p class="mm-coveredit__empty-desc">The cover image you are looking for does not exist or does not belong to you.</p>
                  <a href="add_cover.php" class="mm-coveredit__empty-btn">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                     Add Cover Image
                  </a>
               </div>
            </div>

         </div>
         <!-- /.mm-coveredit -->

         <?php }
            } else {
                 ?>

         <div class="mm-coveredit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-coveredit__header">
               <a href="list_cover.php" class="mm-coveredit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Cover Images
               </a>
               <h1 class="mm-coveredit__title">Add Cover Image</h1>
               <p class="mm-coveredit__subtitle">Upload a new cover image for your event</p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-coveredit__card">
               <form method="POST" enctype="multipart/form-data" action="" class="mm-coveredit__form">

                  <!-- Hidden field -->
                  <input type="hidden" name="type" value="add_cover"/>

                  <!-- Section: Event Selection -->
                  <div class="mm-coveredit__section">
                     <div class="mm-coveredit__section-header">
                        <div class="mm-coveredit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div class="mm-coveredit__section-text">
                           <h2 class="mm-coveredit__section-title">Event Selection</h2>
                           <p class="mm-coveredit__section-desc">Choose which event this cover image belongs to</p>
                        </div>
                     </div>

                     <!-- Select Event -->
                     <div class="mm-coveredit__field">
                        <label class="mm-coveredit__label" for="coverEventAdd">Select Event</label>
                        <select name="eid" id="coverEventAdd" class="mm-coveredit__select select2-single" required>
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

                  <hr class="mm-coveredit__divider" />

                  <!-- Section: Cover Image -->
                  <div class="mm-coveredit__section">
                     <div class="mm-coveredit__section-header">
                        <div class="mm-coveredit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        </div>
                        <div class="mm-coveredit__section-text">
                           <h2 class="mm-coveredit__section-title">Cover Image</h2>
                           <p class="mm-coveredit__section-desc">Upload a cover image for the selected event</p>
                        </div>
                     </div>

                     <div class="mm-coveredit__field">
                        <div class="mm-coveredit__upload">
                           <input type="file" name="cat_img" class="mm-coveredit__upload-input" required />
                           <div class="mm-coveredit__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-coveredit__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-coveredit__upload-hint">PNG, JPG or WebP &mdash; landscape format recommended</p>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-coveredit__divider" />

                  <!-- Section: Status -->
                  <div class="mm-coveredit__section">
                     <div class="mm-coveredit__section-header">
                        <div class="mm-coveredit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-coveredit__section-text">
                           <h2 class="mm-coveredit__section-title">Status</h2>
                           <p class="mm-coveredit__section-desc">Control cover image visibility</p>
                        </div>
                     </div>

                     <!-- Status Toggle -->
                     <div class="mm-coveredit__field">
                        <label class="mm-coveredit__label">Status</label>
                        <div class="mm-coveredit__toggle-group">
                           <div class="mm-coveredit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="statusPublishAdd"
                                 required
                              />
                              <label for="statusPublishAdd" class="mm-coveredit__toggle-label mm-coveredit__toggle-label--active">
                                 <span class="mm-coveredit__toggle-dot mm-coveredit__toggle-dot--active"></span>
                                 Publish
                              </label>
                           </div>
                           <div class="mm-coveredit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="statusUnpublishAdd"
                              />
                              <label for="statusUnpublishAdd" class="mm-coveredit__toggle-label mm-coveredit__toggle-label--inactive">
                                 <span class="mm-coveredit__toggle-dot mm-coveredit__toggle-dot--inactive"></span>
                                 Unpublish
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-coveredit__divider" />

                  <!-- Submit -->
                  <div class="mm-coveredit__actions">
                     <button type="submit" class="mm-coveredit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M12 5v14M5 12l7-7 7 7"/>
                        </svg>
                        Save Cover Image
                     </button>
                     <a href="list_cover.php" class="mm-coveredit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-coveredit -->

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
