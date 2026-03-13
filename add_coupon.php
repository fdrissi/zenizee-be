<?php
   include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/zenizee-page-couponedit.css">
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
                    "select * from tbl_coupon where id=" .
                        $_GET["id"] .
                        " and sponsore_id=" .
                        $sdata["id"] .
                        ""
                )
                ->fetch_assoc();
            $count = $evmulti->query(
                "select * from tbl_coupon where id=" .
                    $_GET["id"] .
                    " and sponsore_id=" .
                    $sdata["id"] .
                    ""
            )->num_rows;
            if ($count != 0) { ?>

         <div class="mm-couponedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-couponedit__header">
               <a href="list_coupon.php" class="mm-couponedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Coupons
               </a>
               <h1 class="mm-couponedit__title">Edit Coupon</h1>
               <p class="mm-couponedit__subtitle">Update details for <strong><?php echo htmlspecialchars($data["title"]); ?></strong></p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-couponedit__card">
               <form method="post" enctype="multipart/form-data" class="mm-couponedit__form">

                  <!-- Hidden fields -->
                  <input type="hidden" name="type" value="edit_coupon"/>
                  <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>

                  <!-- Section 1: Coupon Identity -->
                  <div class="mm-couponedit__section">
                     <div class="mm-couponedit__section-header">
                        <div class="mm-couponedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        </div>
                        <div class="mm-couponedit__section-text">
                           <h2 class="mm-couponedit__section-title">Coupon Identity</h2>
                           <p class="mm-couponedit__section-desc">Name and subtitle for this coupon</p>
                        </div>
                     </div>

                     <div class="mm-couponedit__row">
                        <!-- Coupon Title -->
                        <div class="mm-couponedit__field">
                           <label class="mm-couponedit__label" for="couponTitle">Coupon Title</label>
                           <input
                              type="text"
                              id="couponTitle"
                              name="title"
                              class="mm-couponedit__input"
                              placeholder="e.g. Summer Sale"
                              value="<?php echo htmlspecialchars($data["title"]); ?>"
                              required
                           />
                        </div>
                        <!-- Coupon Subtitle -->
                        <div class="mm-couponedit__field">
                           <label class="mm-couponedit__label" for="couponSubtitle">Coupon Subtitle</label>
                           <input
                              type="text"
                              id="couponSubtitle"
                              name="subtitle"
                              class="mm-couponedit__input"
                              placeholder="e.g. Limited time offer"
                              value="<?php echo htmlspecialchars($data["subtitle"]); ?>"
                              required
                           />
                        </div>
                     </div>
                  </div>

                  <hr class="mm-couponedit__divider" />

                  <!-- Section 2: Coupon Code -->
                  <div class="mm-couponedit__section">
                     <div class="mm-couponedit__section-header">
                        <div class="mm-couponedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M7 15h0M2 9.5h20"/></svg>
                        </div>
                        <div class="mm-couponedit__section-text">
                           <h2 class="mm-couponedit__section-title">Coupon Code</h2>
                           <p class="mm-couponedit__section-desc">Unique code and expiry date for the coupon</p>
                        </div>
                     </div>

                     <div class="mm-couponedit__row">
                        <!-- Coupon Code with Generate button -->
                        <div class="mm-couponedit__field">
                           <label class="mm-couponedit__label" for="ccode">Coupon Code</label>
                           <div class="mm-couponedit__code-group">
                              <input
                                 type="text"
                                 id="ccode"
                                 name="coupon_code"
                                 class="mm-couponedit__input mm-couponedit__input--code"
                                 placeholder="e.g. SAVE20"
                                 maxlength="8"
                                 onkeypress="return isNumberKey(event)"
                                 oninput="this.value = this.value.toUpperCase()"
                                 value="<?php echo htmlspecialchars($data["coupon_code"]); ?>"
                                 required
                              />
                              <button type="button" id="gen_code" class="mm-couponedit__generate">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M23 4v6h-6M1 20v-6h6"/><path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/></svg>
                                 Generate
                              </button>
                           </div>
                           <span class="mm-couponedit__hint">Max 8 characters, alphanumeric only</span>
                        </div>
                        <!-- Expiry Date -->
                        <div class="mm-couponedit__field">
                           <label class="mm-couponedit__label" for="couponExpiry">Expiry Date</label>
                           <input
                              type="date"
                              id="couponExpiry"
                              name="expire_date"
                              class="mm-couponedit__input"
                              value="<?php echo $data["expire_date"]; ?>"
                              required
                           />
                        </div>
                     </div>
                  </div>

                  <hr class="mm-couponedit__divider" />

                  <!-- Section 3: Coupon Image -->
                  <div class="mm-couponedit__section">
                     <div class="mm-couponedit__section-header">
                        <div class="mm-couponedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        </div>
                        <div class="mm-couponedit__section-text">
                           <h2 class="mm-couponedit__section-title">Coupon Image</h2>
                           <p class="mm-couponedit__section-desc">Upload a banner or icon for this coupon</p>
                        </div>
                     </div>

                     <div class="mm-couponedit__field">
                        <div class="mm-couponedit__upload">
                           <input type="file" name="coupon_img" class="mm-couponedit__upload-input" required />
                           <div class="mm-couponedit__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-couponedit__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-couponedit__upload-hint">PNG, JPG or SVG &mdash; recommended size 400x200</p>
                        </div>
                        <?php if (!empty($data['coupon_img'])) { ?>
                           <div class="mm-couponedit__preview">
                              <img src="<?php echo $data['coupon_img']; ?>" alt="Current coupon image" class="mm-couponedit__preview-thumb" />
                              <div class="mm-couponedit__preview-info">
                                 <span class="mm-couponedit__preview-label">Current Image</span>
                                 <span class="mm-couponedit__preview-note">Upload a new file to replace</span>
                              </div>
                           </div>
                        <?php } ?>
                     </div>
                  </div>

                  <hr class="mm-couponedit__divider" />

                  <!-- Section 4: Pricing -->
                  <div class="mm-couponedit__section">
                     <div class="mm-couponedit__section-header">
                        <div class="mm-couponedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                        </div>
                        <div class="mm-couponedit__section-text">
                           <h2 class="mm-couponedit__section-title">Pricing</h2>
                           <p class="mm-couponedit__section-desc">Minimum order amount and discount value</p>
                        </div>
                     </div>

                     <div class="mm-couponedit__row">
                        <!-- Min Order Amount -->
                        <div class="mm-couponedit__field">
                           <label class="mm-couponedit__label" for="couponMinAmt">Min Order Amount</label>
                           <div class="mm-couponedit__input-wrapper">
                              <span class="mm-couponedit__input-prefix">$</span>
                              <input
                                 type="text"
                                 id="couponMinAmt"
                                 name="min_amt"
                                 class="mm-couponedit__input mm-couponedit__input--prefixed numberonly"
                                 placeholder="0.00"
                                 value="<?php echo htmlspecialchars($data["min_amt"]); ?>"
                                 required
                              />
                           </div>
                           <span class="mm-couponedit__hint">Minimum cart value to apply coupon</span>
                        </div>
                        <!-- Discount Value -->
                        <div class="mm-couponedit__field">
                           <label class="mm-couponedit__label" for="couponVal">Discount Value</label>
                           <div class="mm-couponedit__input-wrapper">
                              <span class="mm-couponedit__input-prefix">$</span>
                              <input
                                 type="text"
                                 id="couponVal"
                                 name="coupon_val"
                                 class="mm-couponedit__input mm-couponedit__input--prefixed numberonly"
                                 placeholder="0.00"
                                 value="<?php echo htmlspecialchars($data["coupon_val"]); ?>"
                                 required
                              />
                           </div>
                           <span class="mm-couponedit__hint">Amount to discount from order total</span>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-couponedit__divider" />

                  <!-- Section 5: Description -->
                  <div class="mm-couponedit__section">
                     <div class="mm-couponedit__section-header">
                        <div class="mm-couponedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        </div>
                        <div class="mm-couponedit__section-text">
                           <h2 class="mm-couponedit__section-title">Description</h2>
                           <p class="mm-couponedit__section-desc">Additional details about this coupon</p>
                        </div>
                     </div>

                     <div class="mm-couponedit__field">
                        <label class="mm-couponedit__label" for="couponDesc">Coupon Description</label>
                        <textarea
                           id="couponDesc"
                           name="description"
                           class="mm-couponedit__textarea"
                           rows="5"
                           placeholder="Describe the coupon terms and conditions..."
                           style="resize: none;"
                        ><?php echo $data["description"]; ?></textarea>
                     </div>
                  </div>

                  <hr class="mm-couponedit__divider" />

                  <!-- Section 6: Status -->
                  <div class="mm-couponedit__section">
                     <div class="mm-couponedit__section-header">
                        <div class="mm-couponedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-couponedit__section-text">
                           <h2 class="mm-couponedit__section-title">Status</h2>
                           <p class="mm-couponedit__section-desc">Control coupon visibility</p>
                        </div>
                     </div>

                     <div class="mm-couponedit__field">
                        <label class="mm-couponedit__label">Status</label>
                        <div class="mm-couponedit__toggle-group">
                           <div class="mm-couponedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="statusPublish"
                                 <?php if ($data["status"] == 1) echo 'checked'; ?>
                                 required
                              />
                              <label for="statusPublish" class="mm-couponedit__toggle-label mm-couponedit__toggle-label--active">
                                 <span class="mm-couponedit__toggle-dot mm-couponedit__toggle-dot--active"></span>
                                 Publish
                              </label>
                           </div>
                           <div class="mm-couponedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="statusUnpublish"
                                 <?php if ($data["status"] == 0) echo 'checked'; ?>
                              />
                              <label for="statusUnpublish" class="mm-couponedit__toggle-label mm-couponedit__toggle-label--inactive">
                                 <span class="mm-couponedit__toggle-dot mm-couponedit__toggle-dot--inactive"></span>
                                 Unpublish
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-couponedit__divider" />

                  <!-- Actions -->
                  <div class="mm-couponedit__actions">
                     <button type="submit" class="mm-couponedit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                        Update Coupon
                     </button>
                     <a href="list_coupon.php" class="mm-couponedit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-couponedit -->

         <?php } else { ?>

         <div class="mm-couponedit">

            <!-- ── Fallback: coupon not found ─────────────── -->
            <header class="mm-couponedit__header">
               <a href="list_coupon.php" class="mm-couponedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Coupons
               </a>
               <h1 class="mm-couponedit__title">Coupon Not Found</h1>
            </header>

            <div class="mm-couponedit__card">
               <div class="mm-couponedit__empty">
                  <div class="mm-couponedit__empty-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                  </div>
                  <h3 class="mm-couponedit__empty-title">Check Own Coupon Or Add New Coupon Of Below Click Button.</h3>
                  <a href="add_coupon.php" class="mm-couponedit__submit mm-couponedit__submit--inline">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                     Add Coupon
                  </a>
               </div>
            </div>

         </div>
         <!-- /.mm-couponedit -->

         <?php }
            } else {
                 ?>

         <div class="mm-couponedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-couponedit__header">
               <a href="list_coupon.php" class="mm-couponedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Coupons
               </a>
               <h1 class="mm-couponedit__title">Add Coupon</h1>
               <p class="mm-couponedit__subtitle">Create a new discount coupon</p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-couponedit__card">
               <form method="post" enctype="multipart/form-data" onsubmit="return postForm()" class="mm-couponedit__form">

                  <!-- Hidden field -->
                  <input type="hidden" name="type" value="add_coupon"/>

                  <!-- Section 1: Coupon Identity -->
                  <div class="mm-couponedit__section">
                     <div class="mm-couponedit__section-header">
                        <div class="mm-couponedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        </div>
                        <div class="mm-couponedit__section-text">
                           <h2 class="mm-couponedit__section-title">Coupon Identity</h2>
                           <p class="mm-couponedit__section-desc">Name and subtitle for this coupon</p>
                        </div>
                     </div>

                     <div class="mm-couponedit__row">
                        <!-- Coupon Title -->
                        <div class="mm-couponedit__field">
                           <label class="mm-couponedit__label" for="couponTitleAdd">Coupon Title</label>
                           <input
                              type="text"
                              id="couponTitleAdd"
                              name="title"
                              class="mm-couponedit__input"
                              placeholder="e.g. Summer Sale"
                              required
                           />
                        </div>
                        <!-- Coupon Subtitle -->
                        <div class="mm-couponedit__field">
                           <label class="mm-couponedit__label" for="couponSubtitleAdd">Coupon Subtitle</label>
                           <input
                              type="text"
                              id="couponSubtitleAdd"
                              name="subtitle"
                              class="mm-couponedit__input"
                              placeholder="e.g. Limited time offer"
                              required
                           />
                        </div>
                     </div>
                  </div>

                  <hr class="mm-couponedit__divider" />

                  <!-- Section 2: Coupon Code -->
                  <div class="mm-couponedit__section">
                     <div class="mm-couponedit__section-header">
                        <div class="mm-couponedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M7 15h0M2 9.5h20"/></svg>
                        </div>
                        <div class="mm-couponedit__section-text">
                           <h2 class="mm-couponedit__section-title">Coupon Code</h2>
                           <p class="mm-couponedit__section-desc">Unique code and expiry date for the coupon</p>
                        </div>
                     </div>

                     <div class="mm-couponedit__row">
                        <!-- Coupon Code with Generate button -->
                        <div class="mm-couponedit__field">
                           <label class="mm-couponedit__label" for="ccodeAdd">Coupon Code</label>
                           <div class="mm-couponedit__code-group">
                              <input
                                 type="text"
                                 id="ccode"
                                 name="coupon_code"
                                 class="mm-couponedit__input mm-couponedit__input--code"
                                 placeholder="e.g. SAVE20"
                                 maxlength="8"
                                 onkeypress="return isNumberKey(event)"
                                 oninput="this.value = this.value.toUpperCase()"
                                 required
                              />
                              <button type="button" id="gen_code" class="mm-couponedit__generate">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M23 4v6h-6M1 20v-6h6"/><path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/></svg>
                                 Generate
                              </button>
                           </div>
                           <span class="mm-couponedit__hint">Max 8 characters, alphanumeric only</span>
                        </div>
                        <!-- Expiry Date -->
                        <div class="mm-couponedit__field">
                           <label class="mm-couponedit__label" for="couponExpiryAdd">Expiry Date</label>
                           <input
                              type="date"
                              id="couponExpiryAdd"
                              name="expire_date"
                              class="mm-couponedit__input"
                              required
                           />
                        </div>
                     </div>
                  </div>

                  <hr class="mm-couponedit__divider" />

                  <!-- Section 3: Coupon Image -->
                  <div class="mm-couponedit__section">
                     <div class="mm-couponedit__section-header">
                        <div class="mm-couponedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        </div>
                        <div class="mm-couponedit__section-text">
                           <h2 class="mm-couponedit__section-title">Coupon Image</h2>
                           <p class="mm-couponedit__section-desc">Upload a banner or icon for this coupon</p>
                        </div>
                     </div>

                     <div class="mm-couponedit__field">
                        <div class="mm-couponedit__upload">
                           <input type="file" name="coupon_img" class="mm-couponedit__upload-input" required />
                           <div class="mm-couponedit__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-couponedit__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-couponedit__upload-hint">PNG, JPG or SVG &mdash; recommended size 400x200</p>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-couponedit__divider" />

                  <!-- Section 4: Pricing -->
                  <div class="mm-couponedit__section">
                     <div class="mm-couponedit__section-header">
                        <div class="mm-couponedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                        </div>
                        <div class="mm-couponedit__section-text">
                           <h2 class="mm-couponedit__section-title">Pricing</h2>
                           <p class="mm-couponedit__section-desc">Minimum order amount and discount value</p>
                        </div>
                     </div>

                     <div class="mm-couponedit__row">
                        <!-- Min Order Amount -->
                        <div class="mm-couponedit__field">
                           <label class="mm-couponedit__label" for="couponMinAmtAdd">Min Order Amount</label>
                           <div class="mm-couponedit__input-wrapper">
                              <span class="mm-couponedit__input-prefix">$</span>
                              <input
                                 type="text"
                                 id="couponMinAmtAdd"
                                 name="min_amt"
                                 class="mm-couponedit__input mm-couponedit__input--prefixed numberonly"
                                 placeholder="0.00"
                                 required
                              />
                           </div>
                           <span class="mm-couponedit__hint">Minimum cart value to apply coupon</span>
                        </div>
                        <!-- Discount Value -->
                        <div class="mm-couponedit__field">
                           <label class="mm-couponedit__label" for="couponValAdd">Discount Value</label>
                           <div class="mm-couponedit__input-wrapper">
                              <span class="mm-couponedit__input-prefix">$</span>
                              <input
                                 type="text"
                                 id="couponValAdd"
                                 name="coupon_val"
                                 class="mm-couponedit__input mm-couponedit__input--prefixed numberonly"
                                 placeholder="0.00"
                                 required
                              />
                           </div>
                           <span class="mm-couponedit__hint">Amount to discount from order total</span>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-couponedit__divider" />

                  <!-- Section 5: Description -->
                  <div class="mm-couponedit__section">
                     <div class="mm-couponedit__section-header">
                        <div class="mm-couponedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        </div>
                        <div class="mm-couponedit__section-text">
                           <h2 class="mm-couponedit__section-title">Description</h2>
                           <p class="mm-couponedit__section-desc">Additional details about this coupon</p>
                        </div>
                     </div>

                     <div class="mm-couponedit__field">
                        <label class="mm-couponedit__label" for="couponDescAdd">Coupon Description</label>
                        <textarea
                           id="couponDescAdd"
                           name="description"
                           class="mm-couponedit__textarea"
                           rows="5"
                           placeholder="Describe the coupon terms and conditions..."
                           style="resize: none;"
                        ></textarea>
                     </div>
                  </div>

                  <hr class="mm-couponedit__divider" />

                  <!-- Section 6: Status -->
                  <div class="mm-couponedit__section">
                     <div class="mm-couponedit__section-header">
                        <div class="mm-couponedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-couponedit__section-text">
                           <h2 class="mm-couponedit__section-title">Status</h2>
                           <p class="mm-couponedit__section-desc">Control coupon visibility</p>
                        </div>
                     </div>

                     <div class="mm-couponedit__field">
                        <label class="mm-couponedit__label">Status</label>
                        <div class="mm-couponedit__toggle-group">
                           <div class="mm-couponedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="statusPublishAdd"
                                 required
                              />
                              <label for="statusPublishAdd" class="mm-couponedit__toggle-label mm-couponedit__toggle-label--active">
                                 <span class="mm-couponedit__toggle-dot mm-couponedit__toggle-dot--active"></span>
                                 Publish
                              </label>
                           </div>
                           <div class="mm-couponedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="statusUnpublishAdd"
                              />
                              <label for="statusUnpublishAdd" class="mm-couponedit__toggle-label mm-couponedit__toggle-label--inactive">
                                 <span class="mm-couponedit__toggle-dot mm-couponedit__toggle-dot--inactive"></span>
                                 Unpublish
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-couponedit__divider" />

                  <!-- Actions -->
                  <div class="mm-couponedit__actions">
                     <button type="submit" class="mm-couponedit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M12 5v14M5 12l7-7 7 7"/>
                        </svg>
                        Save Coupon
                     </button>
                     <a href="list_coupon.php" class="mm-couponedit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-couponedit -->

         <?php } ?>

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<!-- Plugin used-->
</body>
</html>
