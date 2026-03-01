<?php
   include "filemanager/head.php";

   // ── Handle page deletion ────────────────────────────────────
   if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
       $deleteId = (int)$_GET['delete_id'];
       $evmulti->query("DELETE FROM tbl_page WHERE id=" . $deleteId);
       header("Location: list_page.php");
       exit;
   }

   // ── Gather all page data up front ───────────────────────────
   $pageQuery = $evmulti->query(
       "SELECT id, title, description, status FROM tbl_page ORDER BY id ASC"
   );
   $pages = [];
   while ($row = $pageQuery->fetch_assoc()) {
       $pages[] = $row;
   }

   $totalPages = count($pages);
   $publishedCount = 0;
   $unpublishedCount = 0;
   foreach ($pages as $pg) {
       if ($pg['status'] == 1) {
           $publishedCount++;
       } else {
           $unpublishedCount++;
       }
   }
?>
<link rel="stylesheet" href="assets/css/magicmate-page-pagelist.css">
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
              MAGICMATE PAGE LIST — Custom Layout
              ═══════════════════════════════════════════════════════ -->
         <div class="mm-pagelist">

            <!-- ── Page Header ─────────────────────────────── -->
            <header class="mm-pagelist__header">
               <div class="mm-pagelist__header-left">
                  <h1 class="mm-pagelist__title">Pages</h1>
                  <p class="mm-pagelist__subtitle">Manage your static pages and content blocks.</p>
               </div>
               <a href="add_page.php" class="mm-pagelist__add-btn">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                  Add Page
               </a>
            </header>

            <!-- ── Stats Bar ───────────────────────────────── -->
            <div class="mm-pagelist__stats-bar">
               <div class="mm-pagelist__stat">
                  <span class="mm-pagelist__stat-dot mm-pagelist__stat-dot--total"></span>
                  <span class="mm-pagelist__stat-value"><?php echo $totalPages; ?></span>
                  <span class="mm-pagelist__stat-label">Total</span>
               </div>
               <span class="mm-pagelist__stat-separator"></span>
               <div class="mm-pagelist__stat">
                  <span class="mm-pagelist__stat-dot mm-pagelist__stat-dot--published"></span>
                  <span class="mm-pagelist__stat-value"><?php echo $publishedCount; ?></span>
                  <span class="mm-pagelist__stat-label">Published</span>
               </div>
               <span class="mm-pagelist__stat-separator"></span>
               <div class="mm-pagelist__stat">
                  <span class="mm-pagelist__stat-dot mm-pagelist__stat-dot--unpublished"></span>
                  <span class="mm-pagelist__stat-value"><?php echo $unpublishedCount; ?></span>
                  <span class="mm-pagelist__stat-label">Unpublished</span>
               </div>
            </div>

            <!-- ── Search Bar ──────────────────────────────── -->
            <div class="mm-pagelist__search-wrap">
               <span class="mm-pagelist__search-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
               </span>
               <input type="text" class="mm-pagelist__search-input" id="mmPageSearch" placeholder="Search pages..." autocomplete="off">
            </div>

            <!-- ── Page List ─────────────────────────────── -->
            <div class="mm-pagelist__list" id="mmPageList">
               <?php if ($totalPages === 0) { ?>
                  <!-- Empty State -->
                  <div class="mm-pagelist__empty">
                     <div class="mm-pagelist__empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                     </div>
                     <h3 class="mm-pagelist__empty-title">No pages yet</h3>
                     <p class="mm-pagelist__empty-text">Create your first page to add static content like Terms of Service, Privacy Policy, or About pages.</p>
                  </div>
               <?php } else {
                  $i = 0;
                  foreach ($pages as $pg) {
                     $i++;
                     $isPublished = $pg['status'] == 1;
                     $descriptionPreview = strip_tags($pg['description']);
                     if (mb_strlen($descriptionPreview) > 120) {
                         $descriptionPreview = mb_substr($descriptionPreview, 0, 120) . '...';
                     }
               ?>
                  <div class="mm-pagelist__item" style="--item-index: <?php echo $i; ?>" data-page-name="<?php echo htmlspecialchars(strtolower($pg['title'])); ?>">
                     <!-- Left: Index + Content -->
                     <div class="mm-pagelist__item-left">
                        <span class="mm-pagelist__item-index"><?php echo $i; ?></span>
                        <div class="mm-pagelist__item-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        </div>
                        <div class="mm-pagelist__item-content">
                           <h3 class="mm-pagelist__item-name" title="<?php echo htmlspecialchars($pg['title']); ?>">
                              <?php echo htmlspecialchars($pg['title']); ?>
                           </h3>
                           <?php if (!empty($descriptionPreview)) { ?>
                              <p class="mm-pagelist__item-desc"><?php echo htmlspecialchars($descriptionPreview); ?></p>
                           <?php } ?>
                        </div>
                     </div>

                     <!-- Center: Status Badge -->
                     <div class="mm-pagelist__item-center">
                        <span class="mm-pagelist__status-badge <?php echo $isPublished ? 'mm-pagelist__status-badge--published' : 'mm-pagelist__status-badge--unpublished'; ?>">
                           <span class="mm-pagelist__status-dot"></span>
                           <?php echo $isPublished ? 'Published' : 'Unpublished'; ?>
                        </span>
                     </div>

                     <!-- Right: Actions -->
                     <div class="mm-pagelist__item-actions">
                        <a href="add_page.php?id=<?php echo $pg['id']; ?>" class="mm-pagelist__action-btn mm-pagelist__action-btn--edit" title="Edit page">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                           <span class="mm-pagelist__action-label">Edit</span>
                        </a>
                        <button type="button" class="mm-pagelist__action-btn mm-pagelist__action-btn--delete" title="Delete page" onclick="mmPageConfirmDelete(<?php echo $pg['id']; ?>, '<?php echo addslashes(htmlspecialchars($pg['title'])); ?>')">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                           <span class="mm-pagelist__action-label">Delete</span>
                        </button>
                     </div>
                  </div>
               <?php
                  }
               }
               ?>
            </div>
            <!-- /.mm-pagelist__list -->

         </div>
         <!-- /.mm-pagelist -->

         <!-- ── Delete Confirmation Modal ──────────────── -->
         <div class="mm-pagelist__modal-overlay" id="mmPageDeleteModal">
            <div class="mm-pagelist__modal">
               <div class="mm-pagelist__modal-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
               </div>
               <h3 class="mm-pagelist__modal-title">Delete Page</h3>
               <p class="mm-pagelist__modal-text" id="mmPageDeleteText">Are you sure you want to delete this page? This action cannot be undone.</p>
               <div class="mm-pagelist__modal-actions">
                  <button type="button" class="mm-pagelist__modal-btn mm-pagelist__modal-btn--cancel" onclick="mmPageCloseModal()">Cancel</button>
                  <button type="button" class="mm-pagelist__modal-btn mm-pagelist__modal-btn--confirm" id="mmPageDeleteConfirm">Delete</button>
               </div>
            </div>
         </div>

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
// ── Page Search ─────────────────────────────────────────────────
(function() {
   var searchInput = document.getElementById('mmPageSearch');
   if (!searchInput) return;

   searchInput.addEventListener('input', function() {
      var query = this.value.toLowerCase().trim();
      var items = document.querySelectorAll('.mm-pagelist__item');
      var visibleCount = 0;

      items.forEach(function(item) {
         var name = item.getAttribute('data-page-name') || '';
         if (!query || name.indexOf(query) !== -1) {
            item.style.display = '';
            visibleCount++;
         } else {
            item.style.display = 'none';
         }
      });

      // Show/hide empty state for search
      var list = document.getElementById('mmPageList');
      var existingNoResult = document.getElementById('mmPageNoResult');
      if (existingNoResult) existingNoResult.remove();

      if (visibleCount === 0 && query) {
         var noResult = document.createElement('div');
         noResult.id = 'mmPageNoResult';
         noResult.className = 'mm-pagelist__empty';
         noResult.innerHTML = '<div class="mm-pagelist__empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><h3 class="mm-pagelist__empty-title">No results found</h3><p class="mm-pagelist__empty-text">No pages match your search. Try a different keyword.</p>';
         list.appendChild(noResult);
      }
   });
})();

// ── Delete Confirmation ─────────────────────────────────────────
var mmPageDeleteId = null;

function mmPageConfirmDelete(id, name) {
   mmPageDeleteId = id;
   var modal = document.getElementById('mmPageDeleteModal');
   var text = document.getElementById('mmPageDeleteText');
   text.textContent = 'Are you sure you want to delete "' + name + '"? This action cannot be undone.';
   modal.classList.add('mm-pagelist__modal-overlay--active');
}

function mmPageCloseModal() {
   mmPageDeleteId = null;
   var modal = document.getElementById('mmPageDeleteModal');
   modal.classList.remove('mm-pagelist__modal-overlay--active');
}

// Close modal on overlay click
document.getElementById('mmPageDeleteModal').addEventListener('click', function(e) {
   if (e.target === this) {
      mmPageCloseModal();
   }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
   if (e.key === 'Escape') {
      mmPageCloseModal();
   }
});

// Confirm delete — redirect to self with delete_id param
document.getElementById('mmPageDeleteConfirm').addEventListener('click', function() {
   if (!mmPageDeleteId) return;
   window.location.href = 'list_page.php?delete_id=' + mmPageDeleteId;
});
</script>
<!-- Plugin used-->
</body>
</html>
