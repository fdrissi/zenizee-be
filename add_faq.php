<?php
if (isset($_POST["type"]) && in_array($_POST["type"], ["add_faq", "edit_faq"])) {
    ob_start();
    require __DIR__ . "/filemanager/manager.php";
    $output = ob_get_clean();
    $data = json_decode($output, true);
    if (!empty($data["Result"]) && $data["Result"] === "true" && !empty($data["action"])) {
        header("Location: " . $data["action"]);
        exit;
    }
}
include "filemanager/head.php"; ?>
<link rel="stylesheet" href="assets/css/zenizee-page-faqform.css">
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

         <?php
            $isEdit = isset($_GET["id"]);
            if ($isEdit) {
               $data = $evmulti
                  ->query("select * from tbl_faq where id=" . $_GET["id"])
                  ->fetch_assoc();
            }
         ?>

         <div class="mm-faqform">

            <!-- Page Header -->
            <header class="mm-faqform__header">
               <a href="list_faq.php" class="mm-faqform__back">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  Back to FAQs
               </a>
               <h1 class="mm-faqform__title"><?php echo $isEdit ? 'Edit FAQ' : 'Add FAQ'; ?></h1>
               <p class="mm-faqform__subtitle"><?php echo $isEdit ? 'Update the question and answer for this FAQ entry.' : 'Create a new frequently asked question for your platform.'; ?></p>
            </header>

            <!-- Form Card -->
            <div class="mm-faqform__card">
               <form method="post" enctype="multipart/form-data" class="mm-faqform__form">

                  <!-- Hidden fields -->
                  <?php if ($isEdit) { ?>
                     <input type="hidden" name="type" value="edit_faq"/>
                     <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>
                  <?php } else { ?>
                     <input type="hidden" name="type" value="add_faq"/>
                  <?php } ?>

                  <!-- Question -->
                  <div class="mm-faqform__field">
                     <label class="mm-faqform__label" for="faqQuestion">
                        <svg class="mm-faqform__label-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                        Question
                     </label>
                     <input
                        type="text"
                        id="faqQuestion"
                        name="question"
                        class="mm-faqform__input mm-faqform__input--lg"
                        placeholder="e.g. How do I reset my password?"
                        value="<?php echo $isEdit ? htmlspecialchars($data['question']) : ''; ?>"
                        required
                     />
                  </div>

                  <hr class="mm-faqform__divider" />

                  <!-- Answer -->
                  <div class="mm-faqform__field">
                     <label class="mm-faqform__label" for="faqAnswer">
                        <svg class="mm-faqform__label-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                        </svg>
                        Answer
                     </label>
                     <textarea
                        id="faqAnswer"
                        name="answer"
                        class="mm-faqform__textarea"
                        placeholder="Write a clear, helpful answer..."
                        rows="6"
                        required
                     ><?php echo $isEdit ? htmlspecialchars($data['answer']) : ''; ?></textarea>
                  </div>

                  <hr class="mm-faqform__divider" />

                  <!-- Status Toggle -->
                  <div class="mm-faqform__field">
                     <label class="mm-faqform__label">Status</label>
                     <div class="mm-faqform__status-group">
                        <div class="mm-faqform__status-option">
                           <input
                              type="radio"
                              name="status"
                              value="1"
                              id="statusPublish"
                              <?php if ($isEdit) { if ($data['status'] == 1) echo 'checked'; } else { echo 'checked'; } ?>
                              required
                           />
                           <label for="statusPublish" class="mm-faqform__status-label mm-faqform__status-label--publish">
                              <span class="mm-faqform__status-dot mm-faqform__status-dot--publish"></span>
                              Published
                           </label>
                        </div>
                        <div class="mm-faqform__status-option">
                           <input
                              type="radio"
                              name="status"
                              value="0"
                              id="statusUnpublish"
                              <?php if ($isEdit && $data['status'] == 0) echo 'checked'; ?>
                           />
                           <label for="statusUnpublish" class="mm-faqform__status-label mm-faqform__status-label--unpublish">
                              <span class="mm-faqform__status-dot mm-faqform__status-dot--unpublish"></span>
                              Unpublished
                           </label>
                        </div>
                     </div>
                  </div>

                  <hr class="mm-faqform__divider" />

                  <!-- Submit -->
                  <div class="mm-faqform__actions">
                     <button type="submit" class="mm-faqform__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                           <?php if ($isEdit) { ?>
                              <path d="M17 3a2.83 2.83 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                           <?php } else { ?>
                              <path d="M12 5v14M5 12h14"/>
                           <?php } ?>
                        </svg>
                        <?php echo $isEdit ? 'Save Changes' : 'Create FAQ'; ?>
                     </button>
                     <a href="list_faq.php" class="mm-faqform__cancel">Cancel</a>
                  </div>

               </form>
            </div>

         </div>
         <!-- /.mm-faqform -->

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<!-- Plugin used-->
</body>
</html>
