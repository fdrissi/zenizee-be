<?php
   include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/magicmate-page-ticketlist.css">
<!-- loader ends-->
<!-- tap on top starts-->
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<!-- tap on tap ends-->
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

         <!-- ===============================================================
              ZENIZEE TICKET LIST -- Custom Card Layout
              =============================================================== -->
         <div class="mm-ticketlist">

            <?php
               $checkownerevent = $evmulti->query(
                   "select * from tbl_event where id=" .
                       $_GET["id"] .
                       " and sponsore_id=" .
                       $sdata["id"] .
                       ""
               )->num_rows;

               if ($checkownerevent != 0) {
                  // -- Fetch event info for header --
                  $eventInfo = $evmulti->query(
                     "SELECT title FROM `tbl_event` where id=" . $_GET["id"]
                  )->fetch_assoc();
                  $eventTitle = isset($eventInfo['title']) ? $eventInfo['title'] : 'Event';

                  // -- Fetch all tickets for this event --
                  $city = $evmulti->query(
                      "select * from tbl_ticket where eid=" .
                          $_GET["id"] .
                          " and sponsore_id=" .
                          $sdata["id"] .
                          ""
                  );

                  $tickets = [];
                  while ($row = $city->fetch_assoc()) {
                     // Fetch event name
                     $eve = $evmulti->query(
                        "SELECT title FROM `tbl_event` where id=" . $row["eid"]
                     )->fetch_assoc();
                     $row['_event_title'] = isset($eve['title']) ? $eve['title'] : '';

                     // Fetch customer name
                     $user = $evmulti->query(
                        "SELECT name FROM `tbl_user` where id=" . $row["uid"]
                     )->fetch_assoc();
                     $row['_customer_name'] = isset($user['name']) ? $user['name'] : 'Unknown';

                     // Fetch payment method
                     $pdata = $evmulti->query(
                        "select title from tbl_payment_list where id=" . $row["p_method_id"]
                     )->fetch_assoc();
                     $row['_payment_title'] = isset($pdata['title']) ? $pdata['title'] : '';

                     $tickets[] = $row;
                  }

                  // -- Calculate stats --
                  $totalTickets    = count($tickets);
                  $bookedCount     = 0;
                  $completedCount  = 0;
                  $cancelledCount  = 0;
                  $totalRevenue    = 0;
                  $totalQty        = 0;
                  $totalCommissionAmt = 0;
                  $totalOrgEarnings   = 0;

                  foreach ($tickets as $tk) {
                     if ($tk['ticket_type'] == 'Booked')    $bookedCount++;
                     if ($tk['ticket_type'] == 'Completed') $completedCount++;
                     if ($tk['ticket_type'] == 'Cancelled') $cancelledCount++;
                     $totalRevenue += floatval($tk['total_amt']);
                     $totalQty     += intval($tk['total_ticket']);
                     $commPct = floatval($tk['commission']);
                     $base = floatval($tk['subtotal']) - floatval($tk['cou_amt']);
                     $commAmt = $base * $commPct / 100;
                     $totalCommissionAmt += $commAmt;
                     $totalOrgEarnings += ($base - $commAmt);
                  }
            ?>

            <!-- -- Back link ----------------------------------------- -->
            <a href="list_event.php" class="mm-ticketlist__back">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
               Back to Events
            </a>

            <!-- -- Page Header --------------------------------------- -->
            <header class="mm-ticketlist__header">
               <div class="mm-ticketlist__header-left">
                  <h1 class="mm-ticketlist__title">Ticket List</h1>
                  <p class="mm-ticketlist__subtitle">Viewing tickets for <strong><?php echo htmlspecialchars($eventTitle); ?></strong> &mdash; manage bookings, track payments, and review customer feedback.</p>
               </div>
               <div class="mm-ticketlist__header-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
               </div>
            </header>

            <!-- -- Stats Bar ----------------------------------------- -->
            <div class="mm-ticketlist__stats-bar">
               <div class="mm-ticketlist__stat">
                  <span class="mm-ticketlist__stat-dot mm-ticketlist__stat-dot--total"></span>
                  <span class="mm-ticketlist__stat-value"><?php echo $totalTickets; ?></span>
                  <span class="mm-ticketlist__stat-label">Total Tickets</span>
               </div>
               <span class="mm-ticketlist__stat-separator"></span>
               <div class="mm-ticketlist__stat">
                  <span class="mm-ticketlist__stat-dot mm-ticketlist__stat-dot--booked"></span>
                  <span class="mm-ticketlist__stat-value"><?php echo $bookedCount; ?></span>
                  <span class="mm-ticketlist__stat-label">Booked</span>
               </div>
               <span class="mm-ticketlist__stat-separator"></span>
               <div class="mm-ticketlist__stat">
                  <span class="mm-ticketlist__stat-dot mm-ticketlist__stat-dot--completed"></span>
                  <span class="mm-ticketlist__stat-value"><?php echo $completedCount; ?></span>
                  <span class="mm-ticketlist__stat-label">Completed</span>
               </div>
               <span class="mm-ticketlist__stat-separator"></span>
               <div class="mm-ticketlist__stat">
                  <span class="mm-ticketlist__stat-dot mm-ticketlist__stat-dot--cancelled"></span>
                  <span class="mm-ticketlist__stat-value"><?php echo $cancelledCount; ?></span>
                  <span class="mm-ticketlist__stat-label">Cancelled</span>
               </div>
               <span class="mm-ticketlist__stat-separator"></span>
               <div class="mm-ticketlist__stat">
                  <span class="mm-ticketlist__stat-dot mm-ticketlist__stat-dot--revenue"></span>
                  <span class="mm-ticketlist__stat-value"><?php echo number_format($totalOrgEarnings, 2) . $set["currency"]; ?></span>
                  <span class="mm-ticketlist__stat-label">Your Earnings</span>
               </div>
               <span class="mm-ticketlist__stat-separator"></span>
               <div class="mm-ticketlist__stat">
                  <span class="mm-ticketlist__stat-dot mm-ticketlist__stat-dot--commission"></span>
                  <span class="mm-ticketlist__stat-value"><?php echo number_format($totalCommissionAmt, 2) . $set["currency"]; ?></span>
                  <span class="mm-ticketlist__stat-label">Commission</span>
               </div>
            </div>

            <!-- -- Toolbar: Search + Filters ------------------------- -->
            <div class="mm-ticketlist__toolbar">
               <div class="mm-ticketlist__search-wrap">
                  <span class="mm-ticketlist__search-icon">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                  </span>
                  <input type="text" class="mm-ticketlist__search-input" id="mmTicketSearch" placeholder="Search by customer, ticket ID..." autocomplete="off">
               </div>
               <div class="mm-ticketlist__filters">
                  <div class="mm-ticketlist__filter-group">
                     <button type="button" class="mm-ticketlist__filter-btn mm-ticketlist__filter-btn--active" data-filter="all" data-filter-group="status">
                        All
                        <span class="mm-ticketlist__filter-count"><?php echo $totalTickets; ?></span>
                     </button>
                     <button type="button" class="mm-ticketlist__filter-btn" data-filter="Booked" data-filter-group="ticket_type">
                        Booked
                        <span class="mm-ticketlist__filter-count"><?php echo $bookedCount; ?></span>
                     </button>
                     <button type="button" class="mm-ticketlist__filter-btn" data-filter="Completed" data-filter-group="ticket_type">
                        Completed
                        <span class="mm-ticketlist__filter-count"><?php echo $completedCount; ?></span>
                     </button>
                     <button type="button" class="mm-ticketlist__filter-btn" data-filter="Cancelled" data-filter-group="ticket_type">
                        Cancelled
                        <span class="mm-ticketlist__filter-count"><?php echo $cancelledCount; ?></span>
                     </button>
                  </div>
               </div>
            </div>

            <!-- -- Ticket Card Grid ---------------------------------- -->
            <div class="mm-ticketlist__grid" id="mmTicketGrid">
               <?php if ($totalTickets === 0) { ?>
                  <!-- Empty State -->
                  <div class="mm-ticketlist__empty">
                     <div class="mm-ticketlist__empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                     </div>
                     <h3 class="mm-ticketlist__empty-title">No tickets yet</h3>
                     <p class="mm-ticketlist__empty-text">No tickets have been booked for this event. Tickets will appear here once customers make bookings.</p>
                  </div>
               <?php } else {
                  $i = 0;
                  foreach ($tickets as $row) {
                     $i++;
                     $ticketType    = $row['ticket_type'];
                     $paymentTitle  = $row['_payment_title'];
                     $customerName  = $row['_customer_name'];
                     $eventName     = $row['_event_title'];
                     $ticketQty     = intval($row['total_ticket']);
                     $hasReview     = $row['is_review'] != 0;
               ?>
                  <div class="mm-ticketlist__card"
                       style="--card-index: <?php echo $i; ?>"
                       data-ticket-id="<?php echo $row['id']; ?>"
                       data-customer="<?php echo htmlspecialchars(strtolower($customerName)); ?>"
                       data-ticket-type="<?php echo htmlspecialchars($ticketType); ?>">

                     <!-- Card Header: Ticket ID + Status Badge -->
                     <div class="mm-ticketlist__card-header">
                        <div class="mm-ticketlist__card-header-left">
                           <span class="mm-ticketlist__card-index"><?php echo $i; ?></span>
                           <div class="mm-ticketlist__card-id-wrap">
                              <span class="mm-ticketlist__card-id-label">Ticket</span>
                              <span class="mm-ticketlist__card-id">#<?php echo $row['id']; ?></span>
                           </div>
                        </div>
                        <?php if ($ticketType == 'Booked') { ?>
                           <span class="mm-ticketlist__badge mm-ticketlist__badge--booked">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                              Booked
                           </span>
                        <?php } elseif ($ticketType == 'Completed') { ?>
                           <span class="mm-ticketlist__badge mm-ticketlist__badge--completed">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                              Completed
                           </span>
                        <?php } else { ?>
                           <span class="mm-ticketlist__badge mm-ticketlist__badge--cancelled">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                              Cancelled
                           </span>
                        <?php } ?>
                     </div>

                     <!-- Card Body -->
                     <div class="mm-ticketlist__card-body">
                        <!-- Customer -->
                        <div class="mm-ticketlist__card-row mm-ticketlist__card-row--customer">
                           <div class="mm-ticketlist__card-row-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                           </div>
                           <div class="mm-ticketlist__card-row-content">
                              <span class="mm-ticketlist__card-row-label">Customer</span>
                              <span class="mm-ticketlist__card-row-value"><?php echo htmlspecialchars($customerName); ?></span>
                           </div>
                        </div>

                        <!-- Event Type -->
                        <div class="mm-ticketlist__card-row">
                           <div class="mm-ticketlist__card-row-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                           </div>
                           <div class="mm-ticketlist__card-row-content">
                              <span class="mm-ticketlist__card-row-label">Ticket Type</span>
                              <span class="mm-ticketlist__card-row-value"><?php echo htmlspecialchars($row['type']); ?></span>
                           </div>
                        </div>

                        <!-- Quantity -->
                        <div class="mm-ticketlist__card-row">
                           <div class="mm-ticketlist__card-row-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="23 7 16 12 23 17 23 7"/></svg>
                           </div>
                           <div class="mm-ticketlist__card-row-content">
                              <span class="mm-ticketlist__card-row-label">Quantity</span>
                              <span class="mm-ticketlist__card-row-value"><?php echo $ticketQty . ($ticketQty == 1 ? ' Ticket' : ' Tickets'); ?></span>
                           </div>
                        </div>

                        <!-- Pricing breakdown -->
                        <div class="mm-ticketlist__card-pricing">
                           <div class="mm-ticketlist__card-price-row">
                              <span class="mm-ticketlist__card-price-label">Price</span>
                              <span class="mm-ticketlist__card-price-value"><?php echo $row['price'] . $set['currency']; ?></span>
                           </div>
                           <div class="mm-ticketlist__card-price-row">
                              <span class="mm-ticketlist__card-price-label">Subtotal</span>
                              <span class="mm-ticketlist__card-price-value"><?php echo $row['subtotal'] . $set['currency']; ?></span>
                           </div>
                           <?php if (floatval($row['cou_amt']) > 0) { ?>
                           <div class="mm-ticketlist__card-price-row mm-ticketlist__card-price-row--discount">
                              <span class="mm-ticketlist__card-price-label">Coupon</span>
                              <span class="mm-ticketlist__card-price-value">-<?php echo $row['cou_amt'] . $set['currency']; ?></span>
                           </div>
                           <?php } ?>
                           <?php if (floatval($row['tax']) > 0) { ?>
                           <div class="mm-ticketlist__card-price-row">
                              <span class="mm-ticketlist__card-price-label">Tax</span>
                              <span class="mm-ticketlist__card-price-value"><?php echo $row['tax'] . $set['currency']; ?></span>
                           </div>
                           <?php } ?>
                           <?php if (floatval($row['wall_amt']) > 0) { ?>
                           <div class="mm-ticketlist__card-price-row mm-ticketlist__card-price-row--discount">
                              <span class="mm-ticketlist__card-price-label">Wallet</span>
                              <span class="mm-ticketlist__card-price-value">-<?php echo $row['wall_amt'] . $set['currency']; ?></span>
                           </div>
                           <?php } ?>
                           <div class="mm-ticketlist__card-price-row mm-ticketlist__card-price-row--total">
                              <span class="mm-ticketlist__card-price-label">Total</span>
                              <span class="mm-ticketlist__card-price-value"><?php echo $row['total_amt'] . $set['currency']; ?></span>
                           </div>
                           <?php
                              $cardCommPct = floatval($row['commission']);
                              $cardBase = floatval($row['subtotal']) - floatval($row['cou_amt']);
                              $cardCommAmt = $cardBase * $cardCommPct / 100;
                              $cardNetEarn = $cardBase - $cardCommAmt;
                           ?>
                           <?php if ($cardCommPct > 0) { ?>
                           <div class="mm-ticketlist__card-price-row mm-ticketlist__card-price-row--commission">
                              <span class="mm-ticketlist__card-price-label">Commission (<?php echo intval($cardCommPct); ?>%)</span>
                              <span class="mm-ticketlist__card-price-value">-<?php echo number_format($cardCommAmt, 2) . $set['currency']; ?></span>
                           </div>
                           <?php } ?>
                           <div class="mm-ticketlist__card-price-row mm-ticketlist__card-price-row--earnings">
                              <span class="mm-ticketlist__card-price-label">Your Earnings</span>
                              <span class="mm-ticketlist__card-price-value"><?php echo number_format($cardNetEarn, 2) . $set['currency']; ?></span>
                           </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mm-ticketlist__card-row">
                           <div class="mm-ticketlist__card-row-icon mm-ticketlist__card-row-icon--payment">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                           </div>
                           <div class="mm-ticketlist__card-row-content">
                              <span class="mm-ticketlist__card-row-label">Payment</span>
                              <span class="mm-ticketlist__card-row-value"><?php echo htmlspecialchars($paymentTitle); ?><?php
                                 if ($paymentTitle != "Wallet" && $paymentTitle != "Free" && !empty($row['transaction_id'])) {
                                    echo '<span class="mm-ticketlist__card-txn">' . htmlspecialchars($row['transaction_id']) . '</span>';
                                 }
                              ?></span>
                           </div>
                        </div>

                        <!-- Cancel comment (if cancelled) -->
                        <?php if ($ticketType == 'Cancelled' && !empty($row['cancle_comment'])) { ?>
                        <div class="mm-ticketlist__card-cancel-note">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                           <span><?php echo htmlspecialchars($row['cancle_comment']); ?></span>
                        </div>
                        <?php } ?>

                        <!-- Review -->
                        <?php if ($hasReview) { ?>
                        <div class="mm-ticketlist__card-review">
                           <div class="mm-ticketlist__card-review-stars">
                              <?php for ($s = 1; $s <= 5; $s++) { ?>
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mm-ticketlist__star <?php echo $s <= intval($row['total_star']) ? 'mm-ticketlist__star--filled' : ''; ?>"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                              <?php } ?>
                           </div>
                           <?php if (!empty($row['review_comment'])) { ?>
                           <p class="mm-ticketlist__card-review-text">"<?php echo htmlspecialchars($row['review_comment']); ?>"</p>
                           <?php } ?>
                        </div>
                        <?php } else { ?>
                        <div class="mm-ticketlist__card-no-review">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                           <span>No review yet</span>
                        </div>
                        <?php } ?>
                     </div>
                  </div>
               <?php
                  }
               }
               ?>
            </div>
            <!-- /.mm-ticketlist__grid -->

            <!-- -- Hidden DataTable (preserves JS dependency) -- -->
            <div class="mm-ticketlist__hidden-table">
               <table class="display" id="basic-1">
                  <thead>
                     <tr>
                        <th>Sr No.</th>
                        <th>Ticket Id.</th>
                        <th>Event Name</th>
                        <th>Customer Name</th>
                        <th>Event Type</th>
                        <th>Event Price</th>
                        <th>Event Subtotal</th>
                        <th>Event Coupon Amount</th>
                        <th>Total Tickets</th>
                        <th>Tax</th>
                        <th>Wallet Amount</th>
                        <th>Total Amount</th>
                        <th>Payment?</th>
                        <th>Status</th>
                        <th>Cancel Comment</th>
                        <th>Review</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                        $ti = 0;
                        foreach ($tickets as $row) {
                           $ti++;
                     ?>
                     <tr>
                        <td><?php echo $ti; ?></td>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo htmlspecialchars($row["_event_title"]); ?></td>
                        <td><?php echo htmlspecialchars($row["_customer_name"]); ?></td>
                        <td><?php echo $row["type"]; ?></td>
                        <td><?php echo $row["price"] . $set["currency"]; ?></td>
                        <td><?php echo $row["subtotal"] . $set["currency"]; ?></td>
                        <td><?php echo $row["cou_amt"] . $set["currency"]; ?></td>
                        <td><?php echo $row["total_ticket"]; ?></td>
                        <td><?php echo $row["tax"] . $set["currency"]; ?></td>
                        <td><?php echo $row["wall_amt"] . $set["currency"]; ?></td>
                        <td><?php echo $row["total_amt"] . $set["currency"]; ?></td>
                        <td><?php
                           if ($row["_payment_title"] == "Wallet" || $row["_payment_title"] == "Free") {
                              echo $row["_payment_title"];
                           } else {
                              echo $row["_payment_title"] . " " . $row["transaction_id"];
                           }
                        ?></td>
                        <td><?php echo $row["ticket_type"]; ?></td>
                        <td><?php echo $row["cancle_comment"]; ?></td>
                        <td><?php
                           if ($row["is_review"] == 0) {
                              echo "Review Not Done!";
                           } else {
                              echo $row["total_star"] . "-" . $row["review_comment"];
                           }
                        ?></td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>

            <?php } else { ?>

            <!-- -- Not owner / empty state -- -->
            <a href="list_event.php" class="mm-ticketlist__back">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
               Back to Events
            </a>

            <header class="mm-ticketlist__header">
               <div class="mm-ticketlist__header-left">
                  <h1 class="mm-ticketlist__title">Ticket List</h1>
                  <p class="mm-ticketlist__subtitle">Check your own event tickets or create a new event.</p>
               </div>
               <div class="mm-ticketlist__header-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
               </div>
            </header>

            <div class="mm-ticketlist__empty">
               <div class="mm-ticketlist__empty-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
               </div>
               <h3 class="mm-ticketlist__empty-title">No access</h3>
               <p class="mm-ticketlist__empty-text">Check your own event tickets or add a new event to get started.</p>
               <a href="add_event.php" class="mm-ticketlist__empty-btn">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                  Add Event
               </a>
            </div>

            <?php } ?>

         </div>
         <!-- /.mm-ticketlist -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
// -- Ticket Search + Filter -----------------------------------------------
(function() {
   var searchInput = document.getElementById('mmTicketSearch');
   var filterBtns  = document.querySelectorAll('.mm-ticketlist__filter-btn');
   var grid        = document.getElementById('mmTicketGrid');
   var currentFilter = 'all';
   var currentFilterGroup = 'status';

   if (!searchInput || !grid) return;

   function applyFilters() {
      var query = searchInput.value.toLowerCase().trim();
      var cards = grid.querySelectorAll('.mm-ticketlist__card');
      var visibleCount = 0;

      cards.forEach(function(card) {
         var customer   = card.getAttribute('data-customer') || '';
         var ticketId   = card.getAttribute('data-ticket-id') || '';
         var ticketType = card.getAttribute('data-ticket-type') || '';

         var matchesSearch = !query || customer.indexOf(query) !== -1 || ticketId.indexOf(query) !== -1;
         var matchesFilter = true;

         if (currentFilter !== 'all') {
            if (currentFilterGroup === 'ticket_type') {
               matchesFilter = ticketType === currentFilter;
            }
         }

         if (matchesSearch && matchesFilter) {
            card.style.display = '';
            visibleCount++;
         } else {
            card.style.display = 'none';
         }
      });

      // Dynamic empty state for filtered results
      var existingNoResult = document.getElementById('mmTicketNoResult');
      if (existingNoResult) existingNoResult.remove();

      if (visibleCount === 0 && (query || currentFilter !== 'all')) {
         var noResult = document.createElement('div');
         noResult.id = 'mmTicketNoResult';
         noResult.className = 'mm-ticketlist__empty';
         noResult.innerHTML = '<div class="mm-ticketlist__empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><h3 class="mm-ticketlist__empty-title">No results found</h3><p class="mm-ticketlist__empty-text">No tickets match your search or filter. Try adjusting your criteria.</p>';
         grid.appendChild(noResult);
      }
   }

   // Search input handler
   searchInput.addEventListener('input', applyFilters);

   // Filter button handlers
   filterBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
         filterBtns.forEach(function(b) {
            b.classList.remove('mm-ticketlist__filter-btn--active');
         });
         this.classList.add('mm-ticketlist__filter-btn--active');
         currentFilter = this.getAttribute('data-filter');
         currentFilterGroup = this.getAttribute('data-filter-group');
         applyFilters();
      });
   });
})();
</script>
<!-- Plugin used-->
</body>
</html>
