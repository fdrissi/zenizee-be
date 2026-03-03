<?php
include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/magicmate-page-eventedit.css">
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
                              "select * from tbl_event where id=" .
                                  $_GET["id"] .
                                  " and sponsore_id=" .
                                  $sdata["id"] .
                                  ""
                          )
                          ->fetch_assoc();
                      $count = $evmulti->query(
                          "select * from tbl_event where id=" .
                              $_GET["id"] .
                              " and sponsore_id=" .
                              $sdata["id"] .
                              ""
                      )->num_rows;
                      if ($count != 0) { ?>

         <div class="mm-eventedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-eventedit__header">
               <a href="list_event.php" class="mm-eventedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Events
               </a>
               <h1 class="mm-eventedit__title">Edit Event</h1>
               <p class="mm-eventedit__subtitle">Update details for <strong><?php echo htmlspecialchars($data["title"]); ?></strong></p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-eventedit__card">
               <form method="post" enctype="multipart/form-data" class="mm-eventedit__form">

                  <!-- Hidden fields -->
                  <input type="hidden" name="type" value="edit_event"/>
                  <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>

                  <!-- ── Section 1: Basic Info ─────────────────── -->
                  <div class="mm-eventedit__section">
                     <div class="mm-eventedit__section-header">
                        <div class="mm-eventedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </div>
                        <div class="mm-eventedit__section-text">
                           <h2 class="mm-eventedit__section-title">Basic Information</h2>
                           <p class="mm-eventedit__section-desc">The event name displayed to attendees</p>
                        </div>
                     </div>

                     <div class="mm-eventedit__field">
                        <label class="mm-eventedit__label" for="editTitle">Event Name</label>
                        <input
                           type="text"
                           id="editTitle"
                           name="title"
                           class="mm-eventedit__input"
                           placeholder="Enter event name"
                           value="<?php echo htmlspecialchars($data["title"]); ?>"
                           required
                        />
                     </div>
                  </div>

                  <hr class="mm-eventedit__divider" />

                  <!-- ── Section 2: Event Images ───────────────── -->
                  <div class="mm-eventedit__section">
                     <div class="mm-eventedit__section-header">
                        <div class="mm-eventedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        </div>
                        <div class="mm-eventedit__section-text">
                           <h2 class="mm-eventedit__section-title">Event Images</h2>
                           <p class="mm-eventedit__section-desc">Upload the event thumbnail and cover image</p>
                        </div>
                     </div>

                     <div class="mm-eventedit__row mm-eventedit__row--2">
                        <!-- Event Image -->
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label">Event Image</label>
                           <div class="mm-eventedit__upload">
                              <input type="file" name="cat_img" class="mm-eventedit__upload-input" />
                              <div class="mm-eventedit__upload-icon">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                              </div>
                              <p class="mm-eventedit__upload-label"><span>Choose file</span> or drag here</p>
                              <p class="mm-eventedit__upload-hint">PNG, JPG or WEBP</p>
                           </div>
                           <?php if (!empty($data['img'])) { ?>
                              <div class="mm-eventedit__preview">
                                 <img src="<?php echo htmlspecialchars($data['img']); ?>" alt="Current event image" class="mm-eventedit__preview-thumb" />
                                 <div class="mm-eventedit__preview-info">
                                    <span class="mm-eventedit__preview-label">Current Image</span>
                                    <span class="mm-eventedit__preview-note">Upload a new file to replace</span>
                                 </div>
                              </div>
                           <?php } ?>
                        </div>

                        <!-- Cover Image -->
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label">Cover Image</label>
                           <div class="mm-eventedit__upload">
                              <input type="file" name="cover_img" class="mm-eventedit__upload-input" />
                              <div class="mm-eventedit__upload-icon">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                              </div>
                              <p class="mm-eventedit__upload-label"><span>Choose file</span> or drag here</p>
                              <p class="mm-eventedit__upload-hint">PNG, JPG or WEBP &mdash; landscape recommended</p>
                           </div>
                           <?php if (!empty($data['cover_img'])) { ?>
                              <div class="mm-eventedit__preview">
                                 <img src="<?php echo htmlspecialchars($data['cover_img']); ?>" alt="Current cover image" class="mm-eventedit__preview-thumb" />
                                 <div class="mm-eventedit__preview-info">
                                    <span class="mm-eventedit__preview-label">Current Cover</span>
                                    <span class="mm-eventedit__preview-note">Upload a new file to replace</span>
                                 </div>
                              </div>
                           <?php } ?>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-eventedit__divider" />

                  <!-- ── Section 3: Date & Time ────────────────── -->
                  <div class="mm-eventedit__section">
                     <div class="mm-eventedit__section-header">
                        <div class="mm-eventedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div class="mm-eventedit__section-text">
                           <h2 class="mm-eventedit__section-title">Date &amp; Time</h2>
                           <p class="mm-eventedit__section-desc">When does the event start and end?</p>
                        </div>
                     </div>

                     <div class="mm-eventedit__row mm-eventedit__row--3">
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="editSdate">Start Date</label>
                           <input
                              type="date"
                              id="editSdate"
                              name="sdate"
                              class="mm-eventedit__input"
                              value="<?php echo $data["sdate"]; ?>"
                              required
                           />
                        </div>
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="editStime">Start Time</label>
                           <input
                              type="time"
                              id="editStime"
                              name="stime"
                              class="mm-eventedit__input"
                              value="<?php echo $data["stime"]; ?>"
                              required
                           />
                        </div>
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="editEtime">End Time</label>
                           <input
                              type="time"
                              id="editEtime"
                              name="etime"
                              class="mm-eventedit__input"
                              value="<?php echo $data["etime"]; ?>"
                              required
                           />
                        </div>
                     </div>
                  </div>

                  <hr class="mm-eventedit__divider" />

                  <!-- ── Section 4: Tags & Media ───────────────── -->
                  <div class="mm-eventedit__section">
                     <div class="mm-eventedit__section-header">
                        <div class="mm-eventedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        </div>
                        <div class="mm-eventedit__section-text">
                           <h2 class="mm-eventedit__section-title">Tags &amp; Media</h2>
                           <p class="mm-eventedit__section-desc">Add searchable tags and video links (optional)</p>
                        </div>
                     </div>

                     <div class="mm-eventedit__row mm-eventedit__row--2">
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="editTags">Tags</label>
                           <input
                              type="text"
                              id="editTags"
                              name="tags"
                              data-role="tagsinput"
                              value="<?php echo $data["tags"]; ?>"
                           />
                        </div>
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="editVurls">Video URLs</label>
                           <input
                              type="text"
                              id="editVurls"
                              name="vurls"
                              data-role="tagsinput"
                              value="<?php echo $data["vurls"]; ?>"
                           />
                        </div>
                     </div>
                  </div>

                  <hr class="mm-eventedit__divider" />

                  <!-- ── Section 5: Location ───────────────────── -->
                  <div class="mm-eventedit__section">
                     <div class="mm-eventedit__section-header">
                        <div class="mm-eventedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div class="mm-eventedit__section-text">
                           <h2 class="mm-eventedit__section-title">Location</h2>
                           <p class="mm-eventedit__section-desc">Search or drag the map marker to set the venue</p>
                        </div>
                     </div>

                     <!-- Map -->
                     <div class="mm-eventedit__field">
                        <input id="searchInput" class="mm-eventedit__map-search" type="text" placeholder="Search for a location..." />
                        <div class="mm-eventedit__map-wrap">
                           <div class="map" id="map"></div>
                        </div>
                     </div>

                     <div class="mm-eventedit__row mm-eventedit__row--2">
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="lat">Latitude</label>
                           <input
                              type="text"
                              id="lat"
                              name="latitude"
                              class="mm-eventedit__input mm-eventedit__input--readonly"
                              placeholder="Set via map"
                              value="<?php echo $data["latitude"]; ?>"
                              required
                              readonly
                           />
                        </div>
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="lng">Longitude</label>
                           <input
                              type="text"
                              id="lng"
                              name="longtitude"
                              class="mm-eventedit__input mm-eventedit__input--readonly"
                              placeholder="Set via map"
                              value="<?php echo $data["longtitude"]; ?>"
                              required
                              readonly
                           />
                        </div>
                     </div>

                     <div class="mm-eventedit__row mm-eventedit__row--2">
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="editPname">Place Name</label>
                           <input
                              type="text"
                              id="editPname"
                              name="pname"
                              class="mm-eventedit__input"
                              placeholder="Enter place name"
                              value="<?php echo htmlspecialchars($data["place_name"]); ?>"
                              required
                           />
                        </div>
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="editCity">City</label>
                           <input
                              type="text"
                              id="editCity"
                              name="city"
                              class="mm-eventedit__input"
                              placeholder="Enter city"
                              value="<?php echo htmlspecialchars($data["city"]); ?>"
                              required
                           />
                        </div>
                     </div>

                     <div class="mm-eventedit__field">
                        <label class="mm-eventedit__label" for="location">Full Address</label>
                        <textarea
                           id="location"
                           name="address"
                           class="mm-eventedit__textarea"
                           rows="4"
                           placeholder="Enter the full venue address"
                           required
                        ><?php echo $data["address"]; ?></textarea>
                     </div>
                  </div>

                  <hr class="mm-eventedit__divider" />

                  <!-- ── Section 6: Classification ─────────────── -->
                  <div class="mm-eventedit__section">
                     <div class="mm-eventedit__section-header">
                        <div class="mm-eventedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                        </div>
                        <div class="mm-eventedit__section-text">
                           <h2 class="mm-eventedit__section-title">Classification</h2>
                           <p class="mm-eventedit__section-desc">Categorize the event and set facilities and restrictions</p>
                        </div>
                     </div>

                     <div class="mm-eventedit__field">
                        <label class="mm-eventedit__label">Category</label>
                        <select name="cid" class="select2-single" required>
                           <option value="">Select Category</option>
                           <?php
                           $cat = $evmulti->query("select * from tbl_category");
                           while ($row = $cat->fetch_assoc()) { ?>
                           <option value="<?php echo $row["id"]; ?>" <?php if ($data["cid"] == $row["id"]) { echo "selected"; } ?>><?php echo $row["title"]; ?></option>
                           <?php } ?>
                        </select>
                     </div>

                     <div class="mm-eventedit__row mm-eventedit__row--2">
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label">Facilities</label>
                           <select name="facility_id[]" class="select2-multi-select" multiple>
                              <?php
                              $cat = $evmulti->query("select * from tbl_facility");
                              $people = explode(",", $data["facility_id"]);
                              while ($row = $cat->fetch_assoc()) { ?>
                              <option value="<?php echo $row["id"]; ?>" <?php if (in_array($row["id"], $people)) { echo "selected"; } ?>><?php echo $row["title"]; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label">Restrictions</label>
                           <select name="restict_id[]" class="select2-multi-select" multiple>
                              <?php
                              $cat = $evmulti->query("select * from tbl_restriction");
                              $people = explode(",", $data["restict_id"]);
                              while ($row = $cat->fetch_assoc()) { ?>
                              <option value="<?php echo $row["id"]; ?>" <?php if (in_array($row["id"], $people)) { echo "selected"; } ?>><?php echo $row["title"]; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-eventedit__divider" />

                  <!-- ── Section 7: Content ────────────────────── -->
                  <div class="mm-eventedit__section">
                     <div class="mm-eventedit__section-header">
                        <div class="mm-eventedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        </div>
                        <div class="mm-eventedit__section-text">
                           <h2 class="mm-eventedit__section-title">Content</h2>
                           <p class="mm-eventedit__section-desc">Rich text description and disclaimer for the event</p>
                        </div>
                     </div>

                     <div class="mm-eventedit__field">
                        <label class="mm-eventedit__label">Description</label>
                        <textarea class="summernote" rows="5" id="cdesc" name="cdesc" required><?php echo $data["description"]; ?></textarea>
                     </div>

                     <div class="mm-eventedit__field">
                        <label class="mm-eventedit__label">Disclaimer</label>
                        <textarea class="summernote" rows="5" id="disclaimer" name="disclaimer" required><?php echo $data["disclaimer"]; ?></textarea>
                     </div>
                  </div>

                  <hr class="mm-eventedit__divider" />

                  <!-- ── Section 8: Status ─────────────────────── -->
                  <div class="mm-eventedit__section">
                     <div class="mm-eventedit__section-header">
                        <div class="mm-eventedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-eventedit__section-text">
                           <h2 class="mm-eventedit__section-title">Publish Status</h2>
                           <p class="mm-eventedit__section-desc">Control whether this event is visible to attendees</p>
                        </div>
                     </div>

                     <div class="mm-eventedit__field">
                        <label class="mm-eventedit__label">Status</label>
                        <div class="mm-eventedit__toggle-group">
                           <div class="mm-eventedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="editStatusPublish"
                                 <?php if ($data["status"] == 1) echo 'checked'; ?>
                                 required
                              />
                              <label for="editStatusPublish" class="mm-eventedit__toggle-label mm-eventedit__toggle-label--publish">
                                 <span class="mm-eventedit__toggle-dot mm-eventedit__toggle-dot--publish"></span>
                                 Publish
                              </label>
                           </div>
                           <div class="mm-eventedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="editStatusUnpublish"
                                 <?php if ($data["status"] == 0) echo 'checked'; ?>
                              />
                              <label for="editStatusUnpublish" class="mm-eventedit__toggle-label mm-eventedit__toggle-label--unpublish">
                                 <span class="mm-eventedit__toggle-dot mm-eventedit__toggle-dot--unpublish"></span>
                                 Unpublish
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-eventedit__divider" />

                  <!-- ── Actions ────────────────────────────── -->
                  <div class="mm-eventedit__actions">
                     <button type="submit" class="mm-eventedit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                        Update Event
                     </button>
                     <a href="list_event.php" class="mm-eventedit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-eventedit -->

         <?php } else { ?>

         <!-- ── Fallback: Event not found ──────────────── -->
         <div class="mm-eventedit">

            <header class="mm-eventedit__header">
               <a href="list_event.php" class="mm-eventedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Events
               </a>
               <h1 class="mm-eventedit__title">Event Not Found</h1>
            </header>

            <div class="mm-eventedit__card">
               <div class="mm-eventedit__fallback">
                  <div class="mm-eventedit__fallback-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                  </div>
                  <h3 class="mm-eventedit__fallback-title">Check Own Event</h3>
                  <p class="mm-eventedit__fallback-text">This event was not found or does not belong to your account. You can add a new event instead.</p>
                  <a href="add_event.php" class="mm-eventedit__fallback-btn">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                     Add Event
                  </a>
               </div>
            </div>

         </div>
         <!-- /.mm-eventedit -->

         <?php }
         } else { ?>

         <!-- ══════════════════════════════════════════════
              ADD MODE
              ══════════════════════════════════════════════ -->

         <div class="mm-eventedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-eventedit__header">
               <a href="list_event.php" class="mm-eventedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Events
               </a>
               <h1 class="mm-eventedit__title">Add Event</h1>
               <p class="mm-eventedit__subtitle">Create a new event on the platform</p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-eventedit__card">
               <form method="post" enctype="multipart/form-data" class="mm-eventedit__form">

                  <!-- Hidden field -->
                  <input type="hidden" name="type" value="add_events"/>

                  <!-- ── Section 1: Basic Info ─────────────────── -->
                  <div class="mm-eventedit__section">
                     <div class="mm-eventedit__section-header">
                        <div class="mm-eventedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </div>
                        <div class="mm-eventedit__section-text">
                           <h2 class="mm-eventedit__section-title">Basic Information</h2>
                           <p class="mm-eventedit__section-desc">The event name displayed to attendees</p>
                        </div>
                     </div>

                     <div class="mm-eventedit__field">
                        <label class="mm-eventedit__label" for="addTitle">Event Name</label>
                        <input
                           type="text"
                           id="addTitle"
                           name="title"
                           class="mm-eventedit__input"
                           placeholder="Enter event name"
                           required
                        />
                     </div>
                  </div>

                  <hr class="mm-eventedit__divider" />

                  <!-- ── Section 2: Event Images ───────────────── -->
                  <div class="mm-eventedit__section">
                     <div class="mm-eventedit__section-header">
                        <div class="mm-eventedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        </div>
                        <div class="mm-eventedit__section-text">
                           <h2 class="mm-eventedit__section-title">Event Images</h2>
                           <p class="mm-eventedit__section-desc">Upload the event thumbnail and cover image</p>
                        </div>
                     </div>

                     <div class="mm-eventedit__row mm-eventedit__row--2">
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label">Event Image</label>
                           <div class="mm-eventedit__upload">
                              <input type="file" name="cat_img" class="mm-eventedit__upload-input" required />
                              <div class="mm-eventedit__upload-icon">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                              </div>
                              <p class="mm-eventedit__upload-label"><span>Choose file</span> or drag here</p>
                              <p class="mm-eventedit__upload-hint">PNG, JPG or WEBP</p>
                           </div>
                        </div>

                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label">Cover Image</label>
                           <div class="mm-eventedit__upload">
                              <input type="file" name="cover_img" class="mm-eventedit__upload-input" required />
                              <div class="mm-eventedit__upload-icon">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                              </div>
                              <p class="mm-eventedit__upload-label"><span>Choose file</span> or drag here</p>
                              <p class="mm-eventedit__upload-hint">PNG, JPG or WEBP &mdash; landscape recommended</p>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-eventedit__divider" />

                  <!-- ── Section 3: Date & Time ────────────────── -->
                  <div class="mm-eventedit__section">
                     <div class="mm-eventedit__section-header">
                        <div class="mm-eventedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div class="mm-eventedit__section-text">
                           <h2 class="mm-eventedit__section-title">Date &amp; Time</h2>
                           <p class="mm-eventedit__section-desc">When does the event start and end?</p>
                        </div>
                     </div>

                     <div class="mm-eventedit__row mm-eventedit__row--3">
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="addSdate">Start Date</label>
                           <input
                              type="date"
                              id="addSdate"
                              name="sdate"
                              class="mm-eventedit__input"
                              required
                           />
                        </div>
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="addStime">Start Time</label>
                           <input
                              type="time"
                              id="addStime"
                              name="stime"
                              class="mm-eventedit__input"
                              required
                           />
                        </div>
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="addEtime">End Time</label>
                           <input
                              type="time"
                              id="addEtime"
                              name="etime"
                              class="mm-eventedit__input"
                              required
                           />
                        </div>
                     </div>
                  </div>

                  <hr class="mm-eventedit__divider" />

                  <!-- ── Section 4: Tags & Media ───────────────── -->
                  <div class="mm-eventedit__section">
                     <div class="mm-eventedit__section-header">
                        <div class="mm-eventedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        </div>
                        <div class="mm-eventedit__section-text">
                           <h2 class="mm-eventedit__section-title">Tags &amp; Media</h2>
                           <p class="mm-eventedit__section-desc">Add searchable tags and video links (optional)</p>
                        </div>
                     </div>

                     <div class="mm-eventedit__row mm-eventedit__row--2">
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="addTags">Tags</label>
                           <input
                              type="text"
                              id="addTags"
                              name="tags"
                              data-role="tagsinput"
                           />
                        </div>
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="addVurls">Video URLs</label>
                           <input
                              type="text"
                              id="addVurls"
                              name="vurls"
                              data-role="tagsinput"
                           />
                        </div>
                     </div>
                  </div>

                  <hr class="mm-eventedit__divider" />

                  <!-- ── Section 5: Location ───────────────────── -->
                  <div class="mm-eventedit__section">
                     <div class="mm-eventedit__section-header">
                        <div class="mm-eventedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div class="mm-eventedit__section-text">
                           <h2 class="mm-eventedit__section-title">Location</h2>
                           <p class="mm-eventedit__section-desc">Search or drag the map marker to set the venue</p>
                        </div>
                     </div>

                     <!-- Map -->
                     <div class="mm-eventedit__field">
                        <input id="searchInput" class="mm-eventedit__map-search" type="text" placeholder="Search for a location..." />
                        <div class="mm-eventedit__map-wrap">
                           <div class="map" id="map"></div>
                        </div>
                     </div>

                     <div class="mm-eventedit__row mm-eventedit__row--2">
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="lat">Latitude</label>
                           <input
                              type="text"
                              id="lat"
                              name="latitude"
                              class="mm-eventedit__input mm-eventedit__input--readonly"
                              placeholder="Set via map"
                              required
                              readonly
                           />
                        </div>
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="lng">Longitude</label>
                           <input
                              type="text"
                              id="lng"
                              name="longtitude"
                              class="mm-eventedit__input mm-eventedit__input--readonly"
                              placeholder="Set via map"
                              required
                              readonly
                           />
                        </div>
                     </div>

                     <div class="mm-eventedit__row mm-eventedit__row--2">
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="addPname">Place Name</label>
                           <input
                              type="text"
                              id="addPname"
                              name="pname"
                              class="mm-eventedit__input"
                              placeholder="Enter place name"
                              required
                           />
                        </div>
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label" for="addCity">City</label>
                           <input
                              type="text"
                              id="addCity"
                              name="city"
                              class="mm-eventedit__input"
                              placeholder="Enter city"
                              required
                           />
                        </div>
                     </div>

                     <div class="mm-eventedit__field">
                        <label class="mm-eventedit__label" for="location">Full Address</label>
                        <textarea
                           id="location"
                           name="address"
                           class="mm-eventedit__textarea"
                           rows="4"
                           placeholder="Enter the full venue address"
                           required
                        ></textarea>
                     </div>

                     <div class="mm-eventedit__callout">
                        <div class="mm-eventedit__callout-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                        </div>
                        <div class="mm-eventedit__callout-text">
                           Select a marker on the map and drag it to set coordinates, or search for an address directly. <strong>Tags</strong> and <strong>Video URLs</strong> are optional.
                        </div>
                     </div>
                  </div>

                  <hr class="mm-eventedit__divider" />

                  <!-- ── Section 6: Classification ─────────────── -->
                  <div class="mm-eventedit__section">
                     <div class="mm-eventedit__section-header">
                        <div class="mm-eventedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                        </div>
                        <div class="mm-eventedit__section-text">
                           <h2 class="mm-eventedit__section-title">Classification</h2>
                           <p class="mm-eventedit__section-desc">Categorize the event and set facilities and restrictions</p>
                        </div>
                     </div>

                     <div class="mm-eventedit__field">
                        <label class="mm-eventedit__label">Category</label>
                        <select name="cid" class="select2-single" required>
                           <option value="" disabled selected>Select Category</option>
                           <?php
                           $cat = $evmulti->query("select * from tbl_category");
                           while ($row = $cat->fetch_assoc()) { ?>
                           <option value="<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                           <?php } ?>
                        </select>
                     </div>

                     <div class="mm-eventedit__row mm-eventedit__row--2">
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label">Facilities</label>
                           <select name="facility_id[]" class="select2-multi-select" multiple>
                              <?php
                              $cat = $evmulti->query("select * from tbl_facility");
                              while ($row = $cat->fetch_assoc()) { ?>
                              <option value="<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                        <div class="mm-eventedit__field">
                           <label class="mm-eventedit__label">Restrictions</label>
                           <select name="restict_id[]" class="select2-multi-select" multiple>
                              <?php
                              $cat = $evmulti->query("select * from tbl_restriction");
                              while ($row = $cat->fetch_assoc()) { ?>
                              <option value="<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-eventedit__divider" />

                  <!-- ── Section 7: Content ────────────────────── -->
                  <div class="mm-eventedit__section">
                     <div class="mm-eventedit__section-header">
                        <div class="mm-eventedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        </div>
                        <div class="mm-eventedit__section-text">
                           <h2 class="mm-eventedit__section-title">Content</h2>
                           <p class="mm-eventedit__section-desc">Rich text description and disclaimer for the event</p>
                        </div>
                     </div>

                     <div class="mm-eventedit__field">
                        <label class="mm-eventedit__label">Description</label>
                        <textarea class="summernote" rows="5" id="cdesc" name="cdesc" required></textarea>
                     </div>

                     <div class="mm-eventedit__field">
                        <label class="mm-eventedit__label">Disclaimer</label>
                        <textarea class="summernote" rows="5" id="disclaimer" name="disclaimer" required></textarea>
                     </div>
                  </div>

                  <hr class="mm-eventedit__divider" />

                  <!-- ── Section 8: Status ─────────────────────── -->
                  <div class="mm-eventedit__section">
                     <div class="mm-eventedit__section-header">
                        <div class="mm-eventedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-eventedit__section-text">
                           <h2 class="mm-eventedit__section-title">Publish Status</h2>
                           <p class="mm-eventedit__section-desc">Control whether this event is visible to attendees</p>
                        </div>
                     </div>

                     <div class="mm-eventedit__field">
                        <label class="mm-eventedit__label">Status</label>
                        <div class="mm-eventedit__toggle-group">
                           <div class="mm-eventedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="addStatusPublish"
                                 checked
                                 required
                              />
                              <label for="addStatusPublish" class="mm-eventedit__toggle-label mm-eventedit__toggle-label--publish">
                                 <span class="mm-eventedit__toggle-dot mm-eventedit__toggle-dot--publish"></span>
                                 Publish
                              </label>
                           </div>
                           <div class="mm-eventedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="addStatusUnpublish"
                              />
                              <label for="addStatusUnpublish" class="mm-eventedit__toggle-label mm-eventedit__toggle-label--unpublish">
                                 <span class="mm-eventedit__toggle-dot mm-eventedit__toggle-dot--unpublish"></span>
                                 Unpublish
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-eventedit__divider" />

                  <!-- ── Actions ────────────────────────────── -->
                  <div class="mm-eventedit__actions">
                     <button type="submit" class="mm-eventedit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Add Event
                     </button>
                     <a href="list_event.php" class="mm-eventedit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-eventedit -->

         <?php } ?>

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script type="text/javascript"
   src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyDZQPb2cuTOdunZdBXOVw9Rt8JhRPZydhg">
</script>
<script>
   /* script */
   function initialize() {
<?php if (isset($_GET["id"])) {
   $elat = !empty($data["latitude"]) ? $data["latitude"] : "0";
   $elng = !empty($data["longtitude"]) ? $data["longtitude"] : "0";
?>
var latlng = new google.maps.LatLng(<?php echo $elat; ?>,<?php echo $elng; ?>);
<?php } else { ?>
      var latlng = new google.maps.LatLng(28.5355161,77.39102649999995);
<?php } ?>
       var map = new google.maps.Map(document.getElementById('map'), {
         center: latlng,
         zoom: 13
       });
       var marker = new google.maps.Marker({
         map: map,
         position: latlng,
         draggable: true,
         anchorPoint: new google.maps.Point(0, -29)
      });
       var input = document.getElementById('searchInput');
       map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
       var geocoder = new google.maps.Geocoder();
       var autocomplete = new google.maps.places.Autocomplete(input);
       autocomplete.bindTo('bounds', map);
       var infowindow = new google.maps.InfoWindow();
       autocomplete.addListener('place_changed', function() {
           infowindow.close();
           marker.setVisible(false);
           var place = autocomplete.getPlace();
           if (!place.geometry) {
               window.alert("Autocomplete's returned place contains no geometry");
               return;
           }
           // If the place has a geometry, then present it on a map.
           if (place.geometry.viewport) {
               map.fitBounds(place.geometry.viewport);
           } else {
               map.setCenter(place.geometry.location);
               map.setZoom(17);
           }
           marker.setPosition(place.geometry.location);
           marker.setVisible(true);
           bindDataToForm(place.formatted_address,place.geometry.location.lat(),place.geometry.location.lng());
           infowindow.setContent(place.formatted_address);
           infowindow.open(map, marker);
       });

       google.maps.event.addListener(marker, 'dragend', function(event) {
           // Always update lat/lng from marker position, even if geocoding fails
           document.getElementById('lat').value = this.getPosition().lat();
           document.getElementById('lng').value = this.getPosition().lng();

           // Try to reverse geocode for the address (may fail without Geocoding API billing)
           geocoder.geocode({'latLng': this.getPosition()}, function(results, status) {
           if (status == google.maps.GeocoderStatus.OK) {
             if (results[0]) {
                 document.getElementById('location').value = results[0].formatted_address;
                 infowindow.setContent(results[0].formatted_address);
                 infowindow.open(map, marker);
             }
           }
           });
       });
   }
   function bindDataToForm(address,lat,lng){
      document.getElementById('location').value = address;
      document.getElementById('lat').value = lat;
      document.getElementById('lng').value = lng;
   }
   google.maps.event.addDomListener(window, 'load', initialize);
</script>
<style type="text/css">
   #map
   {
   width: 100%; height: 300px;
   }
   .input-controls {
   margin-top: 10px;
   border: 1px solid transparent;
   border-radius: 2px 0 0 2px;
   box-sizing: border-box;
   -moz-box-sizing: border-box;
   height: 32px;
   outline: none;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
   }
   #searchInput {
   background-color: #fff;
   font-family: Roboto;
   font-size: 15px;
   font-weight: 300;
   margin-left: 12px;
   padding: 0 11px 0 13px;
   text-overflow: ellipsis;
   width: 50%;
   }
   #searchInput:focus {
   border-color: #4d90fe;
   }
</style>
<!-- Plugin used-->
</body>
</html>
