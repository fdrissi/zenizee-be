<?php
   include "filemanager/head.php";

   // ── Handle FAQ deletion ────────────────────────────────────
   if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
       $deleteId = (int)$_GET['delete_id'];
       $evmulti->query("DELETE FROM tbl_faq WHERE id=" . $deleteId);
       header("Location: list_faq.php");
       exit;
   }

   // ── Gather all FAQ data up front ───────────────────────────
   $faqQuery = $evmulti->query(
       "SELECT id, question, answer, status FROM tbl_faq ORDER BY id DESC"
   );
   $faqs = [];
   while ($row = $faqQuery->fetch_assoc()) {
       $faqs[] = $row;
   }

   $totalFaqs = count($faqs);
   $publishedCount = 0;
   $unpublishedCount = 0;
   foreach ($faqs as $fq) {
       if ($fq['status'] == 1) {
           $publishedCount++;
       } else {
           $unpublishedCount++;
       }
   }
?>
<link rel="stylesheet" href="assets/css/zenizee-page-faqlist.css">
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

         <!-- ═══════════════════════════════════════════════════════
              ZENIZEE FAQ LIST — Custom Layout
              ═══════════════════════════════════════════════════════ -->
         <div class="mm-faqlist">

            <!-- ── Page Header ─────────────────────────────── -->
            <header class="mm-faqlist__header">
               <div class="mm-faqlist__header-left">
                  <h1 class="mm-faqlist__title">FAQ</h1>
                  <p class="mm-faqlist__subtitle">Manage frequently asked questions for your users.</p>
               </div>
               <a href="add_faq.php" class="mm-faqlist__add-btn">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                  Add FAQ
               </a>
            </header>

            <!-- ── Stats Bar ───────────────────────────────── -->
            <div class="mm-faqlist__stats-bar">
               <div class="mm-faqlist__stat">
                  <span class="mm-faqlist__stat-dot mm-faqlist__stat-dot--total"></span>
                  <span class="mm-faqlist__stat-value"><?php echo $totalFaqs; ?></span>
                  <span class="mm-faqlist__stat-label">Total</span>
               </div>
               <span class="mm-faqlist__stat-separator"></span>
               <div class="mm-faqlist__stat">
                  <span class="mm-faqlist__stat-dot mm-faqlist__stat-dot--published"></span>
                  <span class="mm-faqlist__stat-value"><?php echo $publishedCount; ?></span>
                  <span class="mm-faqlist__stat-label">Published</span>
               </div>
               <span class="mm-faqlist__stat-separator"></span>
               <div class="mm-faqlist__stat">
                  <span class="mm-faqlist__stat-dot mm-faqlist__stat-dot--unpublished"></span>
                  <span class="mm-faqlist__stat-value"><?php echo $unpublishedCount; ?></span>
                  <span class="mm-faqlist__stat-label">Unpublished</span>
               </div>
            </div>

            <!-- ── Search Bar ──────────────────────────────── -->
            <div class="mm-faqlist__search-wrap">
               <span class="mm-faqlist__search-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
               </span>
               <input type="text" class="mm-faqlist__search-input" id="mmFaqSearch" placeholder="Search FAQs..." autocomplete="off">
            </div>

            <!-- ── FAQ Accordion List ──────────────────────── -->
            <div class="mm-faqlist__list" id="mmFaqList">
               <?php if ($totalFaqs === 0) { ?>
                  <!-- Empty State -->
                  <div class="mm-faqlist__empty">
                     <div class="mm-faqlist__empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                     </div>
                     <h3 class="mm-faqlist__empty-title">No FAQs yet</h3>
                     <p class="mm-faqlist__empty-text">Create your first FAQ entry to help users find answers to common questions quickly.</p>
                  </div>
               <?php } else {
                  $i = 0;
                  foreach ($faqs as $fq) {
                     $i++;
                     $isPublished = $fq['status'] == 1;
                     $answerPreview = strip_tags($fq['answer']);
                     if (mb_strlen($answerPreview) > 100) {
                         $answerPreview = mb_substr($answerPreview, 0, 100) . '...';
                     }
               ?>
                  <div class="mm-faqlist__item" style="--item-index: <?php echo $i; ?>" data-faq-question="<?php echo htmlspecialchars(strtolower($fq['question'])); ?>" data-faq-answer="<?php echo htmlspecialchars(strtolower($fq['answer'])); ?>">
                     <!-- Accordion Header (always visible) -->
                     <div class="mm-faqlist__item-header" onclick="mmFaqToggle(this)">
                        <div class="mm-faqlist__item-left">
                           <span class="mm-faqlist__item-index"><?php echo $i; ?></span>
                           <div class="mm-faqlist__item-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                           </div>
                           <div class="mm-faqlist__item-content">
                              <h3 class="mm-faqlist__item-question"><?php echo htmlspecialchars($fq['question']); ?></h3>
                              <p class="mm-faqlist__item-preview"><?php echo htmlspecialchars($answerPreview); ?></p>
                           </div>
                        </div>
                        <div class="mm-faqlist__item-meta">
                           <span class="mm-faqlist__status-badge <?php echo $isPublished ? 'mm-faqlist__status-badge--published' : 'mm-faqlist__status-badge--unpublished'; ?>">
                              <span class="mm-faqlist__status-dot"></span>
                              <?php echo $isPublished ? 'Published' : 'Unpublished'; ?>
                           </span>
                           <span class="mm-faqlist__chevron">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                           </span>
                        </div>
                     </div>

                     <!-- Accordion Body (hidden by default) -->
                     <div class="mm-faqlist__item-body">
                        <div class="mm-faqlist__item-answer">
                           <span class="mm-faqlist__answer-label">Answer</span>
                           <p class="mm-faqlist__answer-text"><?php echo nl2br(htmlspecialchars($fq['answer'])); ?></p>
                        </div>
                        <div class="mm-faqlist__item-actions">
                           <a href="add_faq.php?id=<?php echo $fq['id']; ?>" class="mm-faqlist__action-btn mm-faqlist__action-btn--edit" title="Edit FAQ">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                              <span class="mm-faqlist__action-label">Edit</span>
                           </a>
                           <button type="button" class="mm-faqlist__action-btn mm-faqlist__action-btn--delete" title="Delete FAQ" onclick="event.stopPropagation(); mmFaqConfirmDelete(<?php echo $fq['id']; ?>, '<?php echo addslashes(htmlspecialchars($fq['question'])); ?>')">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                              <span class="mm-faqlist__action-label">Delete</span>
                           </button>
                        </div>
                     </div>
                  </div>
               <?php
                  }
               }
               ?>
            </div>
            <!-- /.mm-faqlist__list -->

         </div>
         <!-- /.mm-faqlist -->

         <!-- ── Delete Confirmation Modal ──────────────── -->
         <div class="mm-faqlist__modal-overlay" id="mmFaqDeleteModal">
            <div class="mm-faqlist__modal">
               <div class="mm-faqlist__modal-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
               </div>
               <h3 class="mm-faqlist__modal-title">Delete FAQ</h3>
               <p class="mm-faqlist__modal-text" id="mmFaqDeleteText">Are you sure you want to delete this FAQ? This action cannot be undone.</p>
               <div class="mm-faqlist__modal-actions">
                  <button type="button" class="mm-faqlist__modal-btn mm-faqlist__modal-btn--cancel" onclick="mmFaqCloseModal()">Cancel</button>
                  <button type="button" class="mm-faqlist__modal-btn mm-faqlist__modal-btn--confirm" id="mmFaqDeleteConfirm">Delete</button>
               </div>
            </div>
         </div>

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
// ── FAQ Accordion Toggle ────────────────────────────────────────
function mmFaqToggle(header) {
   var item = header.closest('.mm-faqlist__item');
   var wasOpen = item.classList.contains('mm-faqlist__item--open');

   // Close all other items
   var allItems = document.querySelectorAll('.mm-faqlist__item--open');
   allItems.forEach(function(openItem) {
      openItem.classList.remove('mm-faqlist__item--open');
   });

   // Toggle the clicked item
   if (!wasOpen) {
      item.classList.add('mm-faqlist__item--open');
   }
}

// ── FAQ Search ──────────────────────────────────────────────────
(function() {
   var searchInput = document.getElementById('mmFaqSearch');
   if (!searchInput) return;

   searchInput.addEventListener('input', function() {
      var query = this.value.toLowerCase().trim();
      var items = document.querySelectorAll('.mm-faqlist__item');
      var visibleCount = 0;

      items.forEach(function(item) {
         var question = item.getAttribute('data-faq-question') || '';
         var answer = item.getAttribute('data-faq-answer') || '';
         if (!query || question.indexOf(query) !== -1 || answer.indexOf(query) !== -1) {
            item.style.display = '';
            visibleCount++;
         } else {
            item.style.display = 'none';
         }
      });

      // Show/hide empty state for search
      var list = document.getElementById('mmFaqList');
      var existingNoResult = document.getElementById('mmFaqNoResult');
      if (existingNoResult) existingNoResult.remove();

      if (visibleCount === 0 && query) {
         var noResult = document.createElement('div');
         noResult.id = 'mmFaqNoResult';
         noResult.className = 'mm-faqlist__empty';
         noResult.innerHTML = '<div class="mm-faqlist__empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><h3 class="mm-faqlist__empty-title">No results found</h3><p class="mm-faqlist__empty-text">No FAQs match your search. Try a different keyword.</p>';
         list.appendChild(noResult);
      }
   });
})();

// ── Delete Confirmation ─────────────────────────────────────────
var mmFaqDeleteId = null;

function mmFaqConfirmDelete(id, question) {
   mmFaqDeleteId = id;
   var modal = document.getElementById('mmFaqDeleteModal');
   var text = document.getElementById('mmFaqDeleteText');
   var displayQuestion = question.length > 60 ? question.substring(0, 60) + '...' : question;
   text.textContent = 'Are you sure you want to delete "' + displayQuestion + '"? This action cannot be undone.';
   modal.classList.add('mm-faqlist__modal-overlay--active');
}

function mmFaqCloseModal() {
   mmFaqDeleteId = null;
   var modal = document.getElementById('mmFaqDeleteModal');
   modal.classList.remove('mm-faqlist__modal-overlay--active');
}

// Close modal on overlay click
document.getElementById('mmFaqDeleteModal').addEventListener('click', function(e) {
   if (e.target === this) {
      mmFaqCloseModal();
   }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
   if (e.key === 'Escape') {
      mmFaqCloseModal();
   }
});

// Confirm delete — redirect to self with delete_id param
document.getElementById('mmFaqDeleteConfirm').addEventListener('click', function() {
   if (!mmFaqDeleteId) return;
   window.location.href = 'list_faq.php?delete_id=' + mmFaqDeleteId;
});
</script>
<!-- Plugin used-->
</body>
</html>
