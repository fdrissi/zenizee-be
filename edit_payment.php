<?php
   include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/zenizee-page-payedit.css">
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
                ->query("select * from tbl_payment_list where id=" . $_GET["id"])
                ->fetch_assoc();
         ?>

         <div class="mm-payedit">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-payedit__header">
               <a href="payment_list.php" class="mm-payedit__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Payment Gateways
               </a>
               <h1 class="mm-payedit__title">Edit Payment Gateway</h1>
               <p class="mm-payedit__subtitle">Configure settings for <strong><?php echo htmlspecialchars($data["title"]); ?></strong></p>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-payedit__card">
               <form method="POST" enctype="multipart/form-data" class="mm-payedit__form">

                  <!-- Hidden fields -->
                  <input type="hidden" name="type" value="edit_payment"/>
                  <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>

                  <!-- Section: Gateway Identity -->
                  <div class="mm-payedit__section">
                     <div class="mm-payedit__section-header">
                        <div class="mm-payedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                        </div>
                        <div class="mm-payedit__section-text">
                           <h2 class="mm-payedit__section-title">Gateway Identity</h2>
                           <p class="mm-payedit__section-desc">Core information about this payment gateway.</p>
                        </div>
                     </div>

                     <!-- Gateway Name (read-only) -->
                     <div class="mm-payedit__field">
                        <label class="mm-payedit__label">Gateway Name</label>
                        <div class="mm-payedit__readonly">
                           <span class="mm-payedit__readonly-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                           </span>
                           <span class="mm-payedit__readonly-value"><?php echo htmlspecialchars($data["title"]); ?></span>
                           <span class="mm-payedit__readonly-badge">Locked</span>
                        </div>
                        <input type="text" name="cname" value="<?php echo htmlspecialchars($data["title"]); ?>" disabled style="display:none;" />
                     </div>

                     <!-- Subtitle -->
                     <div class="mm-payedit__field">
                        <label class="mm-payedit__label" for="paySubtitle">Subtitle</label>
                        <input
                           type="text"
                           id="paySubtitle"
                           name="ptitle"
                           class="mm-payedit__input"
                           placeholder="e.g. Pay securely with your card"
                           value="<?php echo htmlspecialchars($data["subtitle"]); ?>"
                           required
                        />
                        <span class="mm-payedit__hint">A short description shown to users during checkout.</span>
                     </div>
                  </div>

                  <hr class="mm-payedit__divider" />

                  <!-- Section: Gateway Image -->
                  <div class="mm-payedit__section">
                     <div class="mm-payedit__section-header">
                        <div class="mm-payedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        </div>
                        <div class="mm-payedit__section-text">
                           <h2 class="mm-payedit__section-title">Gateway Image</h2>
                           <p class="mm-payedit__section-desc">Upload a logo or icon for this payment method.</p>
                        </div>
                     </div>

                     <div class="mm-payedit__field">
                        <div class="mm-payedit__upload">
                           <input type="file" name="cat_img" class="mm-payedit__upload-input" />
                           <div class="mm-payedit__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-payedit__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-payedit__upload-hint">PNG, SVG or JPG &mdash; square format recommended</p>
                        </div>
                        <?php if (!empty($data['img'])) { ?>
                           <div class="mm-payedit__preview">
                              <img src="<?php echo $data['img']; ?>" alt="Current gateway image" class="mm-payedit__preview-thumb" />
                              <div class="mm-payedit__preview-info">
                                 <span class="mm-payedit__preview-label">Current Image</span>
                                 <span class="mm-payedit__preview-note">Upload a new file to replace</span>
                              </div>
                           </div>
                        <?php } ?>
                     </div>
                  </div>

                  <hr class="mm-payedit__divider" />

                  <!-- Section: Configuration -->
                  <div class="mm-payedit__section">
                     <div class="mm-payedit__section-header">
                        <div class="mm-payedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                        </div>
                        <div class="mm-payedit__section-text">
                           <h2 class="mm-payedit__section-title">Configuration</h2>
                           <p class="mm-payedit__section-desc">API keys and gateway-specific attributes.</p>
                        </div>
                     </div>

                     <!-- Attributes -->
                     <div class="mm-payedit__field">
                        <label class="mm-payedit__label" for="payAttr">Gateway Attributes</label>
                        <input
                           type="text"
                           id="payAttr"
                           name="p_attr"
                           class="mm-payedit__input"
                           data-role="tagsinput"
                           value="<?php echo htmlspecialchars($data["attributes"]); ?>"
                           required
                        />
                        <?php if ($_GET["id"] == 1) { ?>
                           <div class="mm-payedit__callout">
                              <div class="mm-payedit__callout-icon">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                              </div>
                              <div class="mm-payedit__callout-text">
                                 <strong>PayPal Mode:</strong> Use <code>1</code> for Live PayPal and <code>0</code> for Sandbox PayPal.
                              </div>
                           </div>
                        <?php } else { ?>
                           <span class="mm-payedit__hint">Comma-separated key values for this gateway.</span>
                        <?php } ?>
                     </div>
                  </div>

                  <hr class="mm-payedit__divider" />

                  <!-- Section: Visibility -->
                  <div class="mm-payedit__section">
                     <div class="mm-payedit__section-header">
                        <div class="mm-payedit__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="mm-payedit__section-text">
                           <h2 class="mm-payedit__section-title">Visibility</h2>
                           <p class="mm-payedit__section-desc">Control where and how this gateway appears.</p>
                        </div>
                     </div>

                     <!-- Status Toggle -->
                     <div class="mm-payedit__field">
                        <label class="mm-payedit__label">Status</label>
                        <div class="mm-payedit__toggle-group">
                           <div class="mm-payedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="1"
                                 id="statusPublish"
                                 <?php if ($data["status"] == 1) echo 'checked'; ?>
                                 required
                              />
                              <label for="statusPublish" class="mm-payedit__toggle-label mm-payedit__toggle-label--publish">
                                 <span class="mm-payedit__toggle-dot mm-payedit__toggle-dot--publish"></span>
                                 Published
                              </label>
                           </div>
                           <div class="mm-payedit__toggle-option">
                              <input
                                 type="radio"
                                 name="status"
                                 value="0"
                                 id="statusUnpublish"
                                 <?php if ($data["status"] == 0) echo 'checked'; ?>
                              />
                              <label for="statusUnpublish" class="mm-payedit__toggle-label mm-payedit__toggle-label--unpublish">
                                 <span class="mm-payedit__toggle-dot mm-payedit__toggle-dot--unpublish"></span>
                                 Unpublished
                              </label>
                           </div>
                        </div>
                     </div>

                     <!-- Wallet Visibility Toggle -->
                     <div class="mm-payedit__field">
                        <label class="mm-payedit__label">Show on Wallet</label>
                        <div class="mm-payedit__toggle-group">
                           <div class="mm-payedit__toggle-option">
                              <input
                                 type="radio"
                                 name="p_show"
                                 value="1"
                                 id="walletYes"
                                 <?php if ($data["p_show"] == 1) echo 'checked'; ?>
                                 required
                              />
                              <label for="walletYes" class="mm-payedit__toggle-label mm-payedit__toggle-label--publish">
                                 <span class="mm-payedit__toggle-dot mm-payedit__toggle-dot--publish"></span>
                                 Yes
                              </label>
                           </div>
                           <div class="mm-payedit__toggle-option">
                              <input
                                 type="radio"
                                 name="p_show"
                                 value="0"
                                 id="walletNo"
                                 <?php if ($data["p_show"] == 0) echo 'checked'; ?>
                              />
                              <label for="walletNo" class="mm-payedit__toggle-label mm-payedit__toggle-label--unpublish">
                                 <span class="mm-payedit__toggle-dot mm-payedit__toggle-dot--unpublish"></span>
                                 No
                              </label>
                           </div>
                        </div>
                        <span class="mm-payedit__hint">Allow users to top-up their wallet using this gateway.</span>
                     </div>
                  </div>

                  <hr class="mm-payedit__divider" />

                  <!-- Submit -->
                  <div class="mm-payedit__actions">
                     <button type="submit" class="mm-payedit__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                        Save Changes
                     </button>
                     <a href="payment_list.php" class="mm-payedit__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-payedit -->

         <?php } else { ?>
            <script>window.location.href="payment_list.php";</script>
         <?php } ?>

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<!-- Plugin used-->
</body>
</html>
