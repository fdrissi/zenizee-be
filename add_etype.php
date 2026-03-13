<?php
   include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/zenizee-page-etypeedit.css">
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
                    "select * from  tbl_type_price where id=" .
                        $_GET["id"] .
                        " and sponsore_id=" .
                        $sdata["id"] .
                        ""
                )
                ->fetch_assoc();
            $count = $evmulti->query(
                "select * from tbl_type_price where id=" .
                    $_GET["id"] .
                    " and sponsore_id=" .
                    $sdata["id"] .
                    ""
            )->num_rows;
            if ($count != 0) { ?>

         <div class="mm-etypeedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-etypeedit__header">
               <a href="list_etype.php" class="mm-etypeedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Types &amp; Prices
               </a>
               <h1 class="mm-etypeedit__title">Edit Type &amp; Price</h1>
               <p class="mm-etypeedit__subtitle">Update ticket type details for <strong><?php echo htmlspecialchars($data["type"]); ?></strong></p>
            </header>

            <!-- ── Info Banner ──────────────────────────────── -->
            <div class="mm-etypeedit__info-banner">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
               <span>To categorize an event as "Free", enter <strong>0</strong> as the price.</span>
            </div>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-etypeedit__card">
               <form method="POST" enctype="multipart/form-data" action="" class="mm-etypeedit__form">

                  <!-- Hidden fields -->
                  <input type="hidden" name="type" value="edit_type"/>
                  <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>

                  <!-- Section: Event Selection -->
                  <div class="mm-etypeedit__section">
                     <div class="mm-etypeedit__section-header">
                        <div class="mm-etypeedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div class="mm-etypeedit__section-text">
                           <h2 class="mm-etypeedit__section-title">Event Selection</h2>
                           <p class="mm-etypeedit__section-desc">Choose which event this ticket type belongs to</p>
                        </div>
                     </div>

                     <div class="mm-etypeedit__field">
                        <label class="mm-etypeedit__label" for="eidEdit">Select Event</label>
                        <select name="eid" id="eidEdit" class="mm-etypeedit__select select2-single" required>
                           <option value="" disabled selected>Select Event</option>
                           <?php
                              $cat = $evmulti->query(
                                  "select * from tbl_event where sponsore_id=" . $sdata["id"] . " and event_status='Pending'"
                              );
                              while ($row = $cat->fetch_assoc()) { ?>
                           <option value="<?php echo $row["id"]; ?>" <?php if (
                              $data["event_id"] == $row["id"]
                              ) {
                              echo "selected";
                              } ?>><?php echo $row["title"]; ?></option>
                           <?php }
                              ?>
                        </select>
                     </div>
                  </div>

                  <hr class="mm-etypeedit__divider" />

                  <!-- Section: Type Details -->
                  <div class="mm-etypeedit__section">
                     <div class="mm-etypeedit__section-header">
                        <div class="mm-etypeedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        </div>
                        <div class="mm-etypeedit__section-text">
                           <h2 class="mm-etypeedit__section-title">Type Details</h2>
                           <p class="mm-etypeedit__section-desc">Name and description for this ticket type</p>
                        </div>
                     </div>

                     <!-- Type Name -->
                     <div class="mm-etypeedit__field">
                        <label class="mm-etypeedit__label" for="etypeEdit">Event Type</label>
                        <input
                           type="text"
                           id="etypeEdit"
                           name="etype"
                           class="mm-etypeedit__input"
                           placeholder="Enter Event Type (e.g. VIP, General, Early Bird)"
                           value="<?php echo htmlspecialchars($data["type"]); ?>"
                           required
                        />
                     </div>

                     <!-- Description -->
                     <div class="mm-etypeedit__field">
                        <label class="mm-etypeedit__label" for="descriptionEdit">Type Description</label>
                        <textarea
                           id="descriptionEdit"
                           name="description"
                           class="mm-etypeedit__textarea"
                           rows="6"
                           placeholder="Describe what this ticket type includes..."
                        ><?php echo $data["description"]; ?></textarea>
                     </div>
                  </div>

                  <hr class="mm-etypeedit__divider" />

                  <!-- Section: Pricing -->
                  <div class="mm-etypeedit__section">
                     <div class="mm-etypeedit__section-header">
                        <div class="mm-etypeedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                        </div>
                        <div class="mm-etypeedit__section-text">
                           <h2 class="mm-etypeedit__section-title">Pricing</h2>
                           <p class="mm-etypeedit__section-desc">Set ticket price and availability limits</p>
                        </div>
                     </div>

                     <div class="mm-etypeedit__field-row">
                        <!-- Ticket Price -->
                        <div class="mm-etypeedit__field">
                           <label class="mm-etypeedit__label" for="priceEdit">Ticket Price</label>
                           <input
                              type="number"
                              step="0.01"
                              id="priceEdit"
                              name="price"
                              class="mm-etypeedit__input"
                              placeholder="0.00"
                              value="<?php echo $data["price"]; ?>"
                              required
                           />
                           <span class="mm-etypeedit__hint">Enter 0 for free events</span>
                        </div>

                        <!-- Ticket Limit -->
                        <div class="mm-etypeedit__field">
                           <label class="mm-etypeedit__label" for="tlimitEdit">Ticket Limit</label>
                           <input
                              type="text"
                              id="tlimitEdit"
                              name="tlimit"
                              class="mm-etypeedit__input numberonly"
                              placeholder="e.g. 100"
                              value="<?php echo $data["tlimit"]; ?>"
                              required
                           />
                           <span class="mm-etypeedit__hint">Maximum tickets available</span>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-etypeedit__divider" />

                  <!-- Section: Status -->
                  <div class="mm-etypeedit__section">
                     <div class="mm-etypeedit__section-header">
                        <div class="mm-etypeedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-etypeedit__section-text">
                           <h2 class="mm-etypeedit__section-title">Status</h2>
                           <p class="mm-etypeedit__section-desc">Control ticket type visibility</p>
                        </div>
                     </div>

                     <div class="mm-etypeedit__field">
                        <label class="mm-etypeedit__label">Status</label>
                        <div class="mm-etypeedit__toggle-group">
                           <div class="mm-etypeedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="statusPublishEdit"
                                 <?php if ($data["status"] == 1) echo 'checked'; ?>
                                 required
                              />
                              <label for="statusPublishEdit" class="mm-etypeedit__toggle-label mm-etypeedit__toggle-label--active">
                                 <span class="mm-etypeedit__toggle-dot mm-etypeedit__toggle-dot--active"></span>
                                 Publish
                              </label>
                           </div>
                           <div class="mm-etypeedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="statusUnpublishEdit"
                                 <?php if ($data["status"] == 0) echo 'checked'; ?>
                              />
                              <label for="statusUnpublishEdit" class="mm-etypeedit__toggle-label mm-etypeedit__toggle-label--inactive">
                                 <span class="mm-etypeedit__toggle-dot mm-etypeedit__toggle-dot--inactive"></span>
                                 Unpublish
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-etypeedit__divider" />

                  <!-- Actions -->
                  <div class="mm-etypeedit__actions">
                     <button type="submit" class="mm-etypeedit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                        Update Type &amp; Price
                     </button>
                     <a href="list_etype.php" class="mm-etypeedit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-etypeedit -->

         <?php } else { ?>

         <div class="mm-etypeedit">

            <!-- ── Page Header (fallback — record not found) ── -->
            <header class="mm-etypeedit__header">
               <a href="list_etype.php" class="mm-etypeedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Types &amp; Prices
               </a>
               <h1 class="mm-etypeedit__title">Type &amp; Price Not Found</h1>
               <p class="mm-etypeedit__subtitle">Check Own Type &amp; Price Or Add New Type &amp; Price</p>
            </header>

            <!-- ── Fallback Card ──────────────────────────── -->
            <div class="mm-etypeedit__card">
               <div class="mm-etypeedit__fallback">
                  <div class="mm-etypeedit__fallback-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                  </div>
                  <h3 class="mm-etypeedit__fallback-title">Check Own Type &amp; Price Or Add New Type &amp; Price Of Below Click Button.</h3>
                  <a href="add_etype.php" class="mm-etypeedit__submit mm-etypeedit__submit--inline">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                     Add Type &amp; Price
                  </a>
               </div>
            </div>

         </div>
         <!-- /.mm-etypeedit -->

         <?php }
            } else {
                 ?>

         <div class="mm-etypeedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-etypeedit__header">
               <a href="list_etype.php" class="mm-etypeedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Types &amp; Prices
               </a>
               <h1 class="mm-etypeedit__title">Add Type &amp; Price</h1>
               <p class="mm-etypeedit__subtitle">Create a new ticket type for one of your events</p>
            </header>

            <!-- ── Info Banner ──────────────────────────────── -->
            <div class="mm-etypeedit__info-banner">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
               <span>To categorize an event as "Free", enter <strong>0</strong> as the price.</span>
            </div>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-etypeedit__card">
               <form method="POST" enctype="multipart/form-data" action="" class="mm-etypeedit__form">

                  <!-- Hidden field -->
                  <input type="hidden" name="type" value="add_type"/>

                  <!-- Section: Event Selection -->
                  <div class="mm-etypeedit__section">
                     <div class="mm-etypeedit__section-header">
                        <div class="mm-etypeedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div class="mm-etypeedit__section-text">
                           <h2 class="mm-etypeedit__section-title">Event Selection</h2>
                           <p class="mm-etypeedit__section-desc">Choose which event this ticket type belongs to</p>
                        </div>
                     </div>

                     <div class="mm-etypeedit__field">
                        <label class="mm-etypeedit__label" for="eidAdd">Select Event</label>
                        <select name="eid" id="eidAdd" class="mm-etypeedit__select select2-single" required>
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

                  <hr class="mm-etypeedit__divider" />

                  <!-- Section: Type Details -->
                  <div class="mm-etypeedit__section">
                     <div class="mm-etypeedit__section-header">
                        <div class="mm-etypeedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        </div>
                        <div class="mm-etypeedit__section-text">
                           <h2 class="mm-etypeedit__section-title">Type Details</h2>
                           <p class="mm-etypeedit__section-desc">Name and description for this ticket type</p>
                        </div>
                     </div>

                     <!-- Type Name -->
                     <div class="mm-etypeedit__field">
                        <label class="mm-etypeedit__label" for="etypeAdd">Event Type</label>
                        <input
                           type="text"
                           id="etypeAdd"
                           name="etype"
                           class="mm-etypeedit__input"
                           placeholder="Enter Event Type (e.g. VIP, General, Early Bird)"
                           required
                        />
                     </div>

                     <!-- Description -->
                     <div class="mm-etypeedit__field">
                        <label class="mm-etypeedit__label" for="descriptionAdd">Type Description</label>
                        <textarea
                           id="descriptionAdd"
                           name="description"
                           class="mm-etypeedit__textarea"
                           rows="6"
                           placeholder="Describe what this ticket type includes..."
                        ></textarea>
                     </div>
                  </div>

                  <hr class="mm-etypeedit__divider" />

                  <!-- Section: Pricing -->
                  <div class="mm-etypeedit__section">
                     <div class="mm-etypeedit__section-header">
                        <div class="mm-etypeedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                        </div>
                        <div class="mm-etypeedit__section-text">
                           <h2 class="mm-etypeedit__section-title">Pricing</h2>
                           <p class="mm-etypeedit__section-desc">Set ticket price and availability limits</p>
                        </div>
                     </div>

                     <div class="mm-etypeedit__field-row">
                        <!-- Ticket Price -->
                        <div class="mm-etypeedit__field">
                           <label class="mm-etypeedit__label" for="priceAdd">Ticket Price</label>
                           <input
                              type="number"
                              step="0.01"
                              id="priceAdd"
                              name="price"
                              class="mm-etypeedit__input"
                              placeholder="0.00"
                              required
                           />
                           <span class="mm-etypeedit__hint">Enter 0 for free events</span>
                        </div>

                        <!-- Ticket Limit -->
                        <div class="mm-etypeedit__field">
                           <label class="mm-etypeedit__label" for="tlimitAdd">Ticket Limit</label>
                           <input
                              type="text"
                              id="tlimitAdd"
                              name="tlimit"
                              class="mm-etypeedit__input numberonly"
                              placeholder="e.g. 100"
                              required
                           />
                           <span class="mm-etypeedit__hint">Maximum tickets available</span>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-etypeedit__divider" />

                  <!-- Section: Status -->
                  <div class="mm-etypeedit__section">
                     <div class="mm-etypeedit__section-header">
                        <div class="mm-etypeedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-etypeedit__section-text">
                           <h2 class="mm-etypeedit__section-title">Status</h2>
                           <p class="mm-etypeedit__section-desc">Control ticket type visibility</p>
                        </div>
                     </div>

                     <div class="mm-etypeedit__field">
                        <label class="mm-etypeedit__label">Status</label>
                        <div class="mm-etypeedit__toggle-group">
                           <div class="mm-etypeedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="statusPublishAdd"
                                 required
                              />
                              <label for="statusPublishAdd" class="mm-etypeedit__toggle-label mm-etypeedit__toggle-label--active">
                                 <span class="mm-etypeedit__toggle-dot mm-etypeedit__toggle-dot--active"></span>
                                 Publish
                              </label>
                           </div>
                           <div class="mm-etypeedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="statusUnpublishAdd"
                              />
                              <label for="statusUnpublishAdd" class="mm-etypeedit__toggle-label mm-etypeedit__toggle-label--inactive">
                                 <span class="mm-etypeedit__toggle-dot mm-etypeedit__toggle-dot--inactive"></span>
                                 Unpublish
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-etypeedit__divider" />

                  <!-- Actions -->
                  <div class="mm-etypeedit__actions">
                     <button type="submit" class="mm-etypeedit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M12 5v14M5 12l7-7 7 7"/>
                        </svg>
                        Save Type &amp; Price
                     </button>
                     <a href="list_etype.php" class="mm-etypeedit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-etypeedit -->

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
