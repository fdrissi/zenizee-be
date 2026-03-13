<?php
   include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/zenizee-page-settings.css">
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

         <div class="mm-settings">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-settings__header">
               <div class="mm-settings__header-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
               </div>
               <div class="mm-settings__header-text">
                  <h1 class="mm-settings__title">Settings</h1>
                  <p class="mm-settings__subtitle">Configure your platform settings and integrations</p>
               </div>
            </header>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-settings__card">
               <form method="POST" enctype="multipart/form-data" class="mm-settings__form">

                  <!-- Hidden fields -->
                  <input type="hidden" name="type" value="edit_setting"/>
                  <input type="hidden" name="id" value="1"/>

                  <!-- ═══════════════════════════════════════
                       Section 1: General Settings
                  ════════════════════════════════════════ -->
                  <div class="mm-settings__section mm-settings__section--anim-1">
                     <div class="mm-settings__section-header">
                        <div class="mm-settings__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20"/></svg>
                        </div>
                        <div class="mm-settings__section-text">
                           <h2 class="mm-settings__section-title">General Settings</h2>
                           <p class="mm-settings__section-desc">Basic platform configuration</p>
                        </div>
                     </div>

                     <!-- Platform Name -->
                     <div class="mm-settings__field">
                        <label class="mm-settings__label" for="settingWebname">Platform Name</label>
                        <input
                           type="text"
                           id="settingWebname"
                           name="webname"
                           class="mm-settings__input"
                           placeholder="Enter platform name"
                           value="<?php echo htmlspecialchars($set["webname"]); ?>"
                           required
                        />
                     </div>

                     <!-- Platform Logo -->
                     <div class="mm-settings__field">
                        <label class="mm-settings__label">Platform Logo</label>
                        <div class="mm-settings__upload">
                           <input type="file" name="weblogo" class="mm-settings__upload-input" accept="image/*" />
                           <div class="mm-settings__upload-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/></svg>
                           </div>
                           <p class="mm-settings__upload-label"><span>Choose file</span> or drag here</p>
                           <p class="mm-settings__upload-hint">PNG, SVG or JPG &mdash; square format recommended</p>
                        </div>
                        <?php if (!empty($set['weblogo'])) { ?>
                           <div class="mm-settings__preview">
                              <img src="<?php echo htmlspecialchars($set['weblogo']); ?>" alt="Current platform logo" class="mm-settings__preview-thumb" />
                              <div class="mm-settings__preview-info">
                                 <span class="mm-settings__preview-label">Current Logo</span>
                                 <span class="mm-settings__preview-note">Upload a new file to replace</span>
                              </div>
                           </div>
                        <?php } ?>
                     </div>

                     <!-- Timezone -->
                     <div class="mm-settings__field">
                        <label class="mm-settings__label" for="settingTimezone">Timezone</label>
                        <select
                           id="settingTimezone"
                           name="timezone"
                           class="mm-settings__input mm-settings__select select2-single"
                           required
                        >
                           <option value="">Select Timezone</option>
                           <?php
                              $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
                              $limit = count($tzlist);
                           ?>
                           <?php for ($k = 0; $k < $limit; $k++) { ?>
                           <option value="<?php echo $tzlist[$k]; ?>" <?php if ($tzlist[$k] == $set["timezone"]) { echo "selected"; } ?>><?php echo $tzlist[$k]; ?></option>
                           <?php } ?>
                        </select>
                     </div>

                     <!-- Currency -->
                     <div class="mm-settings__field">
                        <label class="mm-settings__label" for="settingCurrency">Currency Symbol</label>
                        <input
                           type="text"
                           id="settingCurrency"
                           name="currency"
                           class="mm-settings__input"
                           placeholder="e.g. $, €, ₹"
                           value="<?php echo htmlspecialchars($set["currency"]); ?>"
                           required
                        />
                        <span class="mm-settings__hint">e.g. $, €, ₹</span>
                     </div>

                     <!-- Minimum Payout Amount -->
                     <div class="mm-settings__field">
                        <label class="mm-settings__label" for="settingPstore">Minimum Payout Amount</label>
                        <input
                           type="text"
                           id="settingPstore"
                           name="pstore"
                           class="mm-settings__input numberonly"
                           placeholder="Enter minimum payout amount"
                           value="<?php echo htmlspecialchars($set["pstore"]); ?>"
                           required
                        />
                        <span class="mm-settings__hint">Minimum amount organizers can request for payout</span>
                     </div>
                  </div>

                  <!-- ═══════════════════════════════════════
                       Section 2: Push Notifications
                  ════════════════════════════════════════ -->
                  <div class="mm-settings__section mm-settings__section--anim-2">
                     <div class="mm-settings__section-header">
                        <div class="mm-settings__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                        </div>
                        <div class="mm-settings__section-text">
                           <h2 class="mm-settings__section-title">Push Notifications</h2>
                           <p class="mm-settings__section-desc">OneSignal configuration for mobile apps</p>
                        </div>
                     </div>

                     <!-- Info callout -->
                     <div class="mm-settings__callout">
                        <div class="mm-settings__callout-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                        </div>
                        <div class="mm-settings__callout-text">
                           Configure OneSignal credentials for push notifications to user and organizer apps
                        </div>
                     </div>

                     <!-- User App sub-group -->
                     <div class="mm-settings__subgroup">
                        <span class="mm-settings__subgroup-label">User App</span>
                        <div class="mm-settings__field">
                           <label class="mm-settings__label" for="settingOneKey">App ID</label>
                           <input
                              type="text"
                              id="settingOneKey"
                              name="one_key"
                              class="mm-settings__input mm-settings__input--mono"
                              placeholder="OneSignal App ID"
                              value="<?php echo htmlspecialchars($set["one_key"]); ?>"
                              required
                           />
                        </div>
                        <div class="mm-settings__field">
                           <label class="mm-settings__label" for="settingOneHash">REST API Key</label>
                           <input
                              type="text"
                              id="settingOneHash"
                              name="one_hash"
                              class="mm-settings__input mm-settings__input--mono"
                              placeholder="OneSignal REST API Key"
                              value="<?php echo htmlspecialchars($set["one_hash"]); ?>"
                              required
                           />
                        </div>
                     </div>

                     <!-- Organizer App sub-group -->
                     <div class="mm-settings__subgroup">
                        <span class="mm-settings__subgroup-label">Organizer App</span>
                        <div class="mm-settings__field">
                           <label class="mm-settings__label" for="settingSKey">App ID</label>
                           <input
                              type="text"
                              id="settingSKey"
                              name="s_key"
                              class="mm-settings__input mm-settings__input--mono"
                              placeholder="OneSignal App ID"
                              value="<?php echo htmlspecialchars($set["s_key"]); ?>"
                              required
                           />
                        </div>
                        <div class="mm-settings__field">
                           <label class="mm-settings__label" for="settingSHash">REST API Key</label>
                           <input
                              type="text"
                              id="settingSHash"
                              name="s_hash"
                              class="mm-settings__input mm-settings__input--mono"
                              placeholder="OneSignal REST API Key"
                              value="<?php echo htmlspecialchars($set["s_hash"]); ?>"
                              required
                           />
                        </div>
                     </div>
                  </div>

                  <!-- ═══════════════════════════════════════
                       Section 3: SMS Provider
                  ════════════════════════════════════════ -->
                  <div class="mm-settings__section mm-settings__section--anim-3">
                     <div class="mm-settings__section-header">
                        <div class="mm-settings__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        </div>
                        <div class="mm-settings__section-text">
                           <h2 class="mm-settings__section-title">SMS Configuration</h2>
                           <p class="mm-settings__section-desc">OTP and messaging settings</p>
                        </div>
                     </div>

                     <!-- SMS Provider -->
                     <div class="mm-settings__field">
                        <label class="mm-settings__label" for="settingSmsType">SMS Provider</label>
                        <select
                           id="settingSmsType"
                           name="sms_type"
                           class="mm-settings__input mm-settings__select select2-single"
                        >
                           <option value="">Select SMS provider</option>
                           <option value="Msg91" <?php if ($set['sms_type'] == 'Msg91') { echo 'selected'; } ?>>Msg91</option>
                           <option value="Twilio" <?php if ($set['sms_type'] == 'Twilio') { echo 'selected'; } ?>>Twilio</option>
                        </select>
                     </div>

                     <!-- OTP Auth Toggle -->
                     <div class="mm-settings__field">
                        <label class="mm-settings__label">Require OTP on Signup</label>
                        <div class="mm-settings__toggle-group">
                           <div class="mm-settings__toggle-option">
                              <input
                                 type="radio"
                                 name="otp_auth"
                                 value="Yes"
                                 id="otpAuthYes"
                                 <?php if ($set['otp_auth'] == 'Yes') echo 'checked'; ?>
                              />
                              <label for="otpAuthYes" class="mm-settings__toggle-label mm-settings__toggle-label--yes">
                                 <span class="mm-settings__toggle-dot mm-settings__toggle-dot--yes"></span>
                                 Yes
                              </label>
                           </div>
                           <div class="mm-settings__toggle-option">
                              <input
                                 type="radio"
                                 name="otp_auth"
                                 value="No"
                                 id="otpAuthNo"
                                 <?php if ($set['otp_auth'] == 'No') echo 'checked'; ?>
                              />
                              <label for="otpAuthNo" class="mm-settings__toggle-label mm-settings__toggle-label--no">
                                 <span class="mm-settings__toggle-dot mm-settings__toggle-dot--no"></span>
                                 No
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- ═══════════════════════════════════════
                       Section 4: Msg91 Credentials
                  ════════════════════════════════════════ -->
                  <div class="mm-settings__section mm-settings__section--anim-4">
                     <div class="mm-settings__section-header">
                        <div class="mm-settings__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 11-7.778 7.778 5.5 5.5 0 017.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
                        </div>
                        <div class="mm-settings__section-text">
                           <h2 class="mm-settings__section-title">Msg91 Configuration</h2>
                           <p class="mm-settings__section-desc">Msg91 SMS gateway credentials</p>
                        </div>
                     </div>

                     <!-- Auth Key -->
                     <div class="mm-settings__field">
                        <label class="mm-settings__label" for="settingAuthKey">Authentication Key</label>
                        <input
                           type="text"
                           id="settingAuthKey"
                           name="auth_key"
                           class="mm-settings__input mm-settings__input--mono"
                           placeholder="Msg91 Auth Key"
                           value="<?php echo htmlspecialchars($set['auth_key']); ?>"
                           required
                        />
                     </div>

                     <!-- OTP Template ID -->
                     <div class="mm-settings__field">
                        <label class="mm-settings__label" for="settingOtpId">OTP Template ID</label>
                        <input
                           type="text"
                           id="settingOtpId"
                           name="otp_id"
                           class="mm-settings__input mm-settings__input--mono"
                           placeholder="Msg91 OTP Template ID"
                           value="<?php echo htmlspecialchars($set['otp_id']); ?>"
                           required
                        />
                     </div>
                  </div>

                  <!-- ═══════════════════════════════════════
                       Section 5: Twilio Credentials
                  ════════════════════════════════════════ -->
                  <div class="mm-settings__section mm-settings__section--anim-5">
                     <div class="mm-settings__section-header">
                        <div class="mm-settings__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.6 10.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012.5 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.47a16 16 0 006.07 6.07l1.83-1.83a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                        </div>
                        <div class="mm-settings__section-text">
                           <h2 class="mm-settings__section-title">Twilio Configuration</h2>
                           <p class="mm-settings__section-desc">Twilio SMS gateway credentials</p>
                        </div>
                     </div>

                     <!-- Account SID -->
                     <div class="mm-settings__field">
                        <label class="mm-settings__label" for="settingAccId">Account SID</label>
                        <input
                           type="text"
                           id="settingAccId"
                           name="acc_id"
                           class="mm-settings__input mm-settings__input--mono"
                           placeholder="Twilio Account SID"
                           value="<?php echo htmlspecialchars($set['acc_id']); ?>"
                           required
                        />
                     </div>

                     <!-- Auth Token -->
                     <div class="mm-settings__field">
                        <label class="mm-settings__label" for="settingAuthToken">Auth Token</label>
                        <input
                           type="text"
                           id="settingAuthToken"
                           name="auth_token"
                           class="mm-settings__input mm-settings__input--mono"
                           placeholder="Twilio Auth Token"
                           value="<?php echo htmlspecialchars($set['auth_token']); ?>"
                           required
                        />
                     </div>

                     <!-- Phone Number -->
                     <div class="mm-settings__field">
                        <label class="mm-settings__label" for="settingTwilioNumber">Phone Number</label>
                        <input
                           type="text"
                           id="settingTwilioNumber"
                           name="twilio_number"
                           class="mm-settings__input mm-settings__input--mono"
                           placeholder="+1234567890"
                           value="<?php echo htmlspecialchars($set['twilio_number']); ?>"
                           required
                        />
                        <span class="mm-settings__hint">Include country code, e.g. +1234567890</span>
                     </div>
                  </div>

                  <!-- ═══════════════════════════════════════
                       Section 6: Rewards & Tax
                  ════════════════════════════════════════ -->
                  <div class="mm-settings__section mm-settings__section--anim-6">
                     <div class="mm-settings__section-header">
                        <div class="mm-settings__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>
                        </div>
                        <div class="mm-settings__section-text">
                           <h2 class="mm-settings__section-title">Rewards &amp; Tax</h2>
                           <p class="mm-settings__section-desc">Referral program and tax configuration</p>
                        </div>
                     </div>

                     <!-- Rewards two-column grid -->
                     <div class="mm-settings__rewards-grid">
                        <!-- Sign-up Credit -->
                        <div class="mm-settings__field">
                           <label class="mm-settings__label" for="settingScredit">Sign-up Credit</label>
                           <input
                              type="text"
                              id="settingScredit"
                              name="scredit"
                              class="mm-settings__input numberonly"
                              placeholder="0"
                              value="<?php echo htmlspecialchars($set["scredit"]); ?>"
                              required
                           />
                           <span class="mm-settings__hint">Credit given to new users on sign-up</span>
                        </div>

                        <!-- Referral Credit -->
                        <div class="mm-settings__field">
                           <label class="mm-settings__label" for="settingRcredit">Referral Credit</label>
                           <input
                              type="text"
                              id="settingRcredit"
                              name="rcredit"
                              class="mm-settings__input numberonly"
                              placeholder="0"
                              value="<?php echo htmlspecialchars($set["rcredit"]); ?>"
                              required
                           />
                           <span class="mm-settings__hint">Credit given when a referred user signs up</span>
                        </div>
                     </div>

                     <!-- Tax Rate -->
                     <div class="mm-settings__field">
                        <label class="mm-settings__label" for="settingTax">Tax Rate</label>
                        <div class="mm-settings__input-suffix-wrap">
                           <input
                              type="number"
                              id="settingTax"
                              name="tax"
                              class="mm-settings__input mm-settings__input--suffix"
                              step="0.01"
                              min="0"
                              max="100"
                              placeholder="0.00"
                              value="<?php echo htmlspecialchars($set["tax"]); ?>"
                              required
                           />
                           <span class="mm-settings__input-badge">%</span>
                        </div>
                        <span class="mm-settings__hint">Applied to all ticket purchases</span>
                     </div>
                  </div>

                  <!-- Submit -->
                  <div class="mm-settings__actions">
                     <button type="submit" class="mm-settings__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Save Settings
                     </button>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-settings -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<!-- Plugin used-->
</body>
</html>
