<?php
   include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/zenizee-page-artistedit.css">
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
                    "select * from tbl_artist
 where id=" .
                        $_GET["id"] .
                        "
  and sponsore_id=" .
                        $sdata["id"] .
                        ""
                )
                ->fetch_assoc();
            $count = $evmulti->query(
                "select * from tbl_artist
 where id=" .
                    $_GET["id"] .
                    "
and sponsore_id=" .
                    $sdata["id"] .
                    ""
            )->num_rows;
            if ($count != 0) { ?>

         <div class="mm-artistedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-artistedit__header">
               <a href="list_artist.php" class="mm-artistedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Artists
               </a>
               <h1 class="mm-artistedit__title">Edit Artist</h1>
               <p class="mm-artistedit__subtitle">Update details for <strong><?php echo htmlspecialchars($data["title"]); ?></strong></p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-artistedit__card">
               <form method="POST" enctype="multipart/form-data" action="" class="mm-artistedit__form">

                  <!-- Hidden fields -->
                  <input type="hidden" name="type" value="edit_artist"/>
                  <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>

                  <!-- Section: Event Selection -->
                  <div class="mm-artistedit__section">
                     <div class="mm-artistedit__section-header">
                        <div class="mm-artistedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div class="mm-artistedit__section-text">
                           <h2 class="mm-artistedit__section-title">Event Selection</h2>
                           <p class="mm-artistedit__section-desc">Choose which event this artist belongs to</p>
                        </div>
                     </div>

                     <div class="mm-artistedit__field">
                        <label class="mm-artistedit__label" for="artistEvent">Select Event</label>
                        <select name="eid" id="artistEvent" class="mm-artistedit__select select2-single" required>
                           <option value="" disabled selected>Select Event</option>
                           <?php
                           $cat = $evmulti->query(
                               "select * from tbl_event where sponsore_id=" . $sdata["id"] . " and event_status='Pending'"
                           );
                           while ($row = $cat->fetch_assoc()) { ?>
                           <option value="<?php echo $row["id"]; ?>" <?php if ($data["eid"] == $row["id"]) { echo "selected"; } ?>><?php echo $row["title"]; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>

                  <hr class="mm-artistedit__divider" />

                  <!-- Section: Artist Details -->
                  <div class="mm-artistedit__section">
                     <div class="mm-artistedit__section-header">
                        <div class="mm-artistedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div class="mm-artistedit__section-text">
                           <h2 class="mm-artistedit__section-title">Artist Details</h2>
                           <p class="mm-artistedit__section-desc">Name and role of the artist</p>
                        </div>
                     </div>

                     <div class="mm-artistedit__field-row">
                        <!-- Artist Name -->
                        <div class="mm-artistedit__field">
                           <label class="mm-artistedit__label" for="artistName">Artist Name</label>
                           <input
                              type="text"
                              id="artistName"
                              name="aname"
                              class="mm-artistedit__input"
                              placeholder="Enter Artist Name"
                              value="<?php echo htmlspecialchars($data["title"]); ?>"
                              required
                           />
                        </div>

                        <!-- Artist Role -->
                        <div class="mm-artistedit__field">
                           <label class="mm-artistedit__label" for="artistRole">Artist Role</label>
                           <input
                              type="text"
                              id="artistRole"
                              name="arole"
                              class="mm-artistedit__input"
                              placeholder="Enter Artist Role"
                              value="<?php echo htmlspecialchars($data["arole"]); ?>"
                              required
                           />
                        </div>
                     </div>
                  </div>

                  <hr class="mm-artistedit__divider" />

                  <!-- Section: Artist Image -->
                  <div class="mm-artistedit__section">
                     <div class="mm-artistedit__section-header">
                        <div class="mm-artistedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        </div>
                        <div class="mm-artistedit__section-text">
                           <h2 class="mm-artistedit__section-title">Artist Image</h2>
                           <p class="mm-artistedit__section-desc">Upload a photo or image for this artist</p>
                        </div>
                     </div>

                     <div class="mm-artistedit__field">
                        <div class="mm-artistedit__upload">
                           <input type="file" name="cat_img" class="mm-artistedit__upload-input" />
                           <div class="mm-artistedit__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-artistedit__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-artistedit__upload-hint">PNG, JPG or WebP &mdash; square format recommended</p>
                        </div>
                        <?php if (!empty($data['img'])) { ?>
                           <div class="mm-artistedit__preview">
                              <img src="<?php echo $data['img']; ?>" alt="Current artist image" class="mm-artistedit__preview-thumb" />
                              <div class="mm-artistedit__preview-info">
                                 <span class="mm-artistedit__preview-label">Current Image</span>
                                 <span class="mm-artistedit__preview-note">Upload a new file to replace</span>
                              </div>
                           </div>
                        <?php } ?>
                     </div>
                  </div>

                  <hr class="mm-artistedit__divider" />

                  <!-- Section: Status -->
                  <div class="mm-artistedit__section">
                     <div class="mm-artistedit__section-header">
                        <div class="mm-artistedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-artistedit__section-text">
                           <h2 class="mm-artistedit__section-title">Status</h2>
                           <p class="mm-artistedit__section-desc">Control artist visibility</p>
                        </div>
                     </div>

                     <div class="mm-artistedit__field">
                        <label class="mm-artistedit__label">Status</label>
                        <div class="mm-artistedit__toggle-group">
                           <div class="mm-artistedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="statusPublish"
                                 <?php if ($data["status"] == 1) echo 'checked'; ?>
                                 required
                              />
                              <label for="statusPublish" class="mm-artistedit__toggle-label mm-artistedit__toggle-label--active">
                                 <span class="mm-artistedit__toggle-dot mm-artistedit__toggle-dot--active"></span>
                                 Publish
                              </label>
                           </div>
                           <div class="mm-artistedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="statusUnpublish"
                                 <?php if ($data["status"] == 0) echo 'checked'; ?>
                              />
                              <label for="statusUnpublish" class="mm-artistedit__toggle-label mm-artistedit__toggle-label--inactive">
                                 <span class="mm-artistedit__toggle-dot mm-artistedit__toggle-dot--inactive"></span>
                                 Unpublish
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-artistedit__divider" />

                  <!-- Actions -->
                  <div class="mm-artistedit__actions">
                     <button type="submit" class="mm-artistedit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                        Update Artist
                     </button>
                     <a href="list_artist.php" class="mm-artistedit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-artistedit -->

         <?php } else { ?>

         <div class="mm-artistedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-artistedit__header">
               <a href="list_artist.php" class="mm-artistedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Artists
               </a>
               <h1 class="mm-artistedit__title">Artist Not Found</h1>
               <p class="mm-artistedit__subtitle">This artist does not exist or does not belong to your account</p>
            </header>

            <!-- ── Fallback Card ──────────────────────────── -->
            <div class="mm-artistedit__card">
               <div class="mm-artistedit__empty">
                  <div class="mm-artistedit__empty-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                  </div>
                  <h3 class="mm-artistedit__empty-title">Check Own Artist Or Add New Artist</h3>
                  <p class="mm-artistedit__empty-desc">The artist you are looking for was not found. You can add a new one below.</p>
                  <a href="add_artist.php" class="mm-artistedit__submit mm-artistedit__submit--inline">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                     </svg>
                     Add Artist
                  </a>
               </div>
            </div>

         </div>
         <!-- /.mm-artistedit -->

         <?php }
         } else { ?>

         <div class="mm-artistedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-artistedit__header">
               <a href="list_artist.php" class="mm-artistedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Artists
               </a>
               <h1 class="mm-artistedit__title">Add Artist</h1>
               <p class="mm-artistedit__subtitle">Create a new artist for your events</p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-artistedit__card">
               <form method="POST" enctype="multipart/form-data" action="" class="mm-artistedit__form">

                  <!-- Hidden field -->
                  <input type="hidden" name="type" value="add_artist"/>

                  <!-- Section: Event Selection -->
                  <div class="mm-artistedit__section">
                     <div class="mm-artistedit__section-header">
                        <div class="mm-artistedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div class="mm-artistedit__section-text">
                           <h2 class="mm-artistedit__section-title">Event Selection</h2>
                           <p class="mm-artistedit__section-desc">Choose which event this artist belongs to</p>
                        </div>
                     </div>

                     <div class="mm-artistedit__field">
                        <label class="mm-artistedit__label" for="artistEventAdd">Select Event</label>
                        <select name="eid" id="artistEventAdd" class="mm-artistedit__select select2-single" required>
                           <option value="" disabled selected>Select Event</option>
                           <?php
                           $cat = $evmulti->query(
                               "select * from tbl_event where sponsore_id=" . $sdata["id"] . " and event_status='Pending'"
                           );
                           while ($row = $cat->fetch_assoc()) { ?>
                           <option value="<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>

                  <hr class="mm-artistedit__divider" />

                  <!-- Section: Artist Details -->
                  <div class="mm-artistedit__section">
                     <div class="mm-artistedit__section-header">
                        <div class="mm-artistedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div class="mm-artistedit__section-text">
                           <h2 class="mm-artistedit__section-title">Artist Details</h2>
                           <p class="mm-artistedit__section-desc">Name and role of the artist</p>
                        </div>
                     </div>

                     <div class="mm-artistedit__field-row">
                        <!-- Artist Name -->
                        <div class="mm-artistedit__field">
                           <label class="mm-artistedit__label" for="artistNameAdd">Artist Name</label>
                           <input
                              type="text"
                              id="artistNameAdd"
                              name="aname"
                              class="mm-artistedit__input"
                              placeholder="Enter Artist Name"
                              required
                           />
                        </div>

                        <!-- Artist Role -->
                        <div class="mm-artistedit__field">
                           <label class="mm-artistedit__label" for="artistRoleAdd">Artist Role</label>
                           <input
                              type="text"
                              id="artistRoleAdd"
                              name="arole"
                              class="mm-artistedit__input"
                              placeholder="Enter Artist Role"
                              required
                           />
                        </div>
                     </div>
                  </div>

                  <hr class="mm-artistedit__divider" />

                  <!-- Section: Artist Image -->
                  <div class="mm-artistedit__section">
                     <div class="mm-artistedit__section-header">
                        <div class="mm-artistedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        </div>
                        <div class="mm-artistedit__section-text">
                           <h2 class="mm-artistedit__section-title">Artist Image</h2>
                           <p class="mm-artistedit__section-desc">Upload a photo or image for this artist</p>
                        </div>
                     </div>

                     <div class="mm-artistedit__field">
                        <div class="mm-artistedit__upload">
                           <input type="file" name="cat_img" class="mm-artistedit__upload-input" required />
                           <div class="mm-artistedit__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-artistedit__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-artistedit__upload-hint">PNG, JPG or WebP &mdash; square format recommended</p>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-artistedit__divider" />

                  <!-- Section: Status -->
                  <div class="mm-artistedit__section">
                     <div class="mm-artistedit__section-header">
                        <div class="mm-artistedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-artistedit__section-text">
                           <h2 class="mm-artistedit__section-title">Status</h2>
                           <p class="mm-artistedit__section-desc">Control artist visibility</p>
                        </div>
                     </div>

                     <div class="mm-artistedit__field">
                        <label class="mm-artistedit__label">Status</label>
                        <div class="mm-artistedit__toggle-group">
                           <div class="mm-artistedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="statusPublishAdd"
                                 required
                              />
                              <label for="statusPublishAdd" class="mm-artistedit__toggle-label mm-artistedit__toggle-label--active">
                                 <span class="mm-artistedit__toggle-dot mm-artistedit__toggle-dot--active"></span>
                                 Publish
                              </label>
                           </div>
                           <div class="mm-artistedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="statusUnpublishAdd"
                              />
                              <label for="statusUnpublishAdd" class="mm-artistedit__toggle-label mm-artistedit__toggle-label--inactive">
                                 <span class="mm-artistedit__toggle-dot mm-artistedit__toggle-dot--inactive"></span>
                                 Unpublish
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-artistedit__divider" />

                  <!-- Actions -->
                  <div class="mm-artistedit__actions">
                     <button type="submit" class="mm-artistedit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M12 5v14M5 12l7-7 7 7"/>
                        </svg>
                        Save Artist
                     </button>
                     <a href="list_artist.php" class="mm-artistedit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-artistedit -->

         <?php } ?>

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<!-- Plugin used-->
</body>
</html>
