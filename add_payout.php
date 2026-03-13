<?php
   include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/zenizee-page-payoutadd.css">
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

         <div class="mm-payoutadd">

            <!-- ── Page Header ────────────────────────────── -->
            <header class="mm-payoutadd__header">
               <a href="list_epayout.php" class="mm-payoutadd__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to Payout History
               </a>
               <h1 class="mm-payoutadd__title">Request Payout</h1>
               <p class="mm-payoutadd__subtitle">Submit a withdrawal request from your wallet balance</p>
            </header>

            <!-- ── Wallet Summary Cards ─────────────────── -->
            <div class="mm-payoutadd__wallet-bar">
               <div class="mm-payoutadd__wallet-card">
                  <div class="mm-payoutadd__wallet-icon mm-payoutadd__wallet-icon--balance">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                  </div>
                  <div class="mm-payoutadd__wallet-info">
                     <span class="mm-payoutadd__wallet-label">Wallet Balance</span>
                     <span class="mm-payoutadd__wallet-value"><?php
                        $total_earn = $evmulti
                            ->query(
         "select sum((subtotal-cou_amt) - ((subtotal-cou_amt) * commission/100))
as total_amt
from tbl_ticket where sponsore_id=" .
                                    $sdata["id"] .
                                    " and ticket_type ='Completed'"
                            )
                            ->fetch_assoc();
                        $earn = empty($total_earn["total_amt"])
                            ? 0
                            : number_format(
                                (float) $total_earn["total_amt"],
                                2,
                                ".",
                                ""
                            );

                        $total_payout = $evmulti
                            ->query(
                                "select sum(amt) as total_payout from payout_setting
 where owner_id=" .
                                    $sdata["id"] .
                                    ""
                            )
                            ->fetch_assoc();
                        $payout = empty($total_payout["total_payout"])
                            ? "0"
                            : number_format(
                                (float) $total_payout["total_payout"],
                                2,
                                ".",
                                ""
                            );

                        $walletBalance = number_format(
                            (float) $earn - $payout,
                            2,
                            ".",
                            ""
                        );
                        echo $walletBalance . " " . $set["currency"];
                        ?></span>
                  </div>
               </div>
               <div class="mm-payoutadd__wallet-card">
                  <div class="mm-payoutadd__wallet-icon mm-payoutadd__wallet-icon--minimum">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                  </div>
                  <div class="mm-payoutadd__wallet-info">
                     <span class="mm-payoutadd__wallet-label">Min Balance for Withdraw</span>
                     <span class="mm-payoutadd__wallet-value"><?php echo $set["pstore"] . " " . $set["currency"]; ?></span>
                  </div>
               </div>
            </div>

            <!-- ── Form Card ──────────────────────────────── -->
            <div class="mm-payoutadd__card">
               <form method="post" enctype="multipart/form-data" class="mm-payoutadd__form">

                  <!-- Hidden field -->
                  <input type="hidden" name="type" value="add_payout"/>

                  <!-- Section: Payout Amount -->
                  <div class="mm-payoutadd__section">
                     <div class="mm-payoutadd__section-header">
                        <div class="mm-payoutadd__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <div class="mm-payoutadd__section-text">
                           <h2 class="mm-payoutadd__section-title">Payout Amount</h2>
                           <p class="mm-payoutadd__section-desc">Enter the amount you wish to withdraw</p>
                        </div>
                     </div>

                     <div class="mm-payoutadd__field">
                        <label class="mm-payoutadd__label" for="payoutAmount">Amount</label>
                        <input
                           type="number"
                           min="1"
                           step="0.01"
                           id="payoutAmount"
                           name="amt"
                           class="mm-payoutadd__input"
                           placeholder="Enter amount"
                           required
                        />
                        <span class="mm-payoutadd__hint">You cannot request a payout above your available balance.</span>
                     </div>
                  </div>

                  <hr class="mm-payoutadd__divider" />

                  <!-- Section: Payout Method -->
                  <div class="mm-payoutadd__section">
                     <div class="mm-payoutadd__section-header">
                        <div class="mm-payoutadd__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                        </div>
                        <div class="mm-payoutadd__section-text">
                           <h2 class="mm-payoutadd__section-title">Payout Method</h2>
                           <p class="mm-payoutadd__section-desc">Choose how you want to receive your funds</p>
                        </div>
                     </div>

                     <div class="mm-payoutadd__field">
                        <label class="mm-payoutadd__label" for="r_type">Transfer Type</label>
                        <select name="r_type" id="r_type" class="mm-payoutadd__select" required>
                           <option value="">Select Option</option>
                           <option value="UPI">UPI</option>
                           <option value="BANK Transfer">Bank Transfer</option>
                           <option value="Paypal">PayPal</option>
                        </select>
                     </div>
                  </div>

                  <hr class="mm-payoutadd__divider" />

                  <!-- Section: Transfer Details (dynamic) -->
                  <div class="mm-payoutadd__section mm-payoutadd__section--details" id="mmPayoutDetails" style="display:none;">
                     <div class="mm-payoutadd__section-header">
                        <div class="mm-payoutadd__section-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </div>
                        <div class="mm-payoutadd__section-text">
                           <h2 class="mm-payoutadd__section-title">Transfer Details</h2>
                           <p class="mm-payoutadd__section-desc">Provide the details for your selected payout method</p>
                        </div>
                     </div>

                     <!-- UPI Field -->
                     <div class="mm-payoutadd__field div1" style="display:none;">
                        <label class="mm-payoutadd__label" for="upi_id">UPI Address</label>
                        <input
                           type="text"
                           id="upi_id"
                           name="upi_id"
                           class="mm-payoutadd__input"
                           placeholder="Enter UPI address (e.g. name@upi)"
                        />
                     </div>

                     <!-- PayPal Field -->
                     <div class="mm-payoutadd__field div2" style="display:none;">
                        <label class="mm-payoutadd__label" for="paypal_id">PayPal ID</label>
                        <input
                           type="text"
                           id="paypal_id"
                           name="paypal_id"
                           class="mm-payoutadd__input"
                           placeholder="Enter PayPal email or ID"
                        />
                     </div>

                     <!-- Bank Transfer Fields -->
                     <div class="mm-payoutadd__field div3" style="display:none;">
                        <label class="mm-payoutadd__label" for="acc_number">Account Number</label>
                        <input
                           type="text"
                           id="acc_number"
                           name="acc_number"
                           class="mm-payoutadd__input"
                           placeholder="Enter account number"
                        />
                     </div>

                     <div class="mm-payoutadd__field div4" style="display:none;">
                        <label class="mm-payoutadd__label" for="bank_name">Bank Name</label>
                        <input
                           type="text"
                           id="bank_name"
                           name="bank_name"
                           class="mm-payoutadd__input"
                           placeholder="Enter bank name"
                        />
                     </div>

                     <div class="mm-payoutadd__field div5" style="display:none;">
                        <label class="mm-payoutadd__label" for="acc_name">Account Holder Name</label>
                        <input
                           type="text"
                           id="acc_name"
                           name="acc_name"
                           class="mm-payoutadd__input"
                           placeholder="Enter account holder name"
                        />
                     </div>

                     <div class="mm-payoutadd__field div6" style="display:none;">
                        <label class="mm-payoutadd__label" for="ifsc_code">IFSC Code</label>
                        <input
                           type="text"
                           id="ifsc_code"
                           name="ifsc_code"
                           class="mm-payoutadd__input"
                           placeholder="Enter IFSC code"
                        />
                     </div>
                  </div>

                  <!-- Submit -->
                  <div class="mm-payoutadd__actions">
                     <button type="submit" class="mm-payoutadd__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                        Request Payout
                     </button>
                     <a href="list_epayout.php" class="mm-payoutadd__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-payoutadd -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<!-- Plugin used-->
<script>
   // ── Payout Type Toggle (preserves original jQuery logic) ──
   $("#upi_id").hide();
   $("#paypal_id").hide();
   $("#acc_number").hide();
   $("#bank_name").hide();
   $("#acc_name").hide();
   $("#ifsc_code").hide();
   $(".div1").hide();
   $(".div2").hide();
   $(".div3").hide();
   $(".div4").hide();
   $(".div5").hide();
   $(".div6").hide();

   $(document).on('change','#r_type',function(e) {
   var val = $(this).val();
   var detailsSection = document.getElementById('mmPayoutDetails');
   if(val == '') {
   detailsSection.style.display = 'none';
   $("#upi_id").hide();
   $("#paypal_id").hide();
   $("#acc_number").hide();
   $("#bank_name").hide();
   $("#acc_name").hide();
   $("#ifsc_code").hide();
   $(".div1").hide();
   $(".div2").hide();
   $(".div3").hide();
   $(".div4").hide();
   $(".div5").hide();
   $(".div6").hide();
   } else if(val == 'UPI') {
   detailsSection.style.display = '';
   $("#upi_id").show();
   $("#paypal_id").hide();
   $("#acc_number").hide();
   $("#bank_name").hide();
   $("#acc_name").hide();
   $("#ifsc_code").hide();
   $(".div1").show();
   $(".div2").hide();
   $(".div3").hide();
   $(".div4").hide();
   $(".div5").hide();
   $(".div6").hide();

   $('#upi_id').attr('required', 'required');
   $("#paypal_id").removeAttr("required");
   $("#acc_number").removeAttr("required");
   $("#bank_name").removeAttr("required");
   $("#acc_name").removeAttr("required");
   $("#ifsc_code").removeAttr("required");
   } else if(val == 'Paypal') {
   detailsSection.style.display = '';
   $("#upi_id").hide();
   $("#paypal_id").show();
   $("#acc_number").hide();
   $("#bank_name").hide();
   $("#acc_name").hide();
   $("#ifsc_code").hide();
   $(".div1").hide();
   $(".div2").show();
   $(".div3").hide();
   $(".div4").hide();
   $(".div5").hide();
   $(".div6").hide();

   $('#paypal_id').attr('required', 'required');
   $("#upi_id").removeAttr("required");
   $("#acc_number").removeAttr("required");
   $("#bank_name").removeAttr("required");
   $("#acc_name").removeAttr("required");
   $("#ifsc_code").removeAttr("required");
   } else  {
   detailsSection.style.display = '';
   $("#upi_id").hide();
   $("#paypal_id").hide();
   $("#acc_number").show();
   $("#bank_name").show();
   $("#acc_name").show();
   $("#ifsc_code").show();
   $(".div1").hide();
   $(".div2").hide();
   $(".div3").show();
   $(".div4").show();
   $(".div5").show();
   $(".div6").show();
   $('#acc_number').attr('required', 'required');
   $('#bank_name').attr('required', 'required');
   $('#acc_name').attr('required', 'required');
   $('#ifsc_code').attr('required', 'required');
   $("#upi_id").removeAttr("required");
   $("#paypal_id").removeAttr("required");
   }
   });
</script>
</body>
</html>
