<?php
   include "filemanager/head.php";

   // ── Handle category deletion ────────────────────────────────
   if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
       $deleteId = (int)$_GET['delete_id'];
       $evmulti->query("DELETE FROM tbl_category WHERE id=" . $deleteId);
       header("Location: list_category.php");
       exit;
   }

   // ── Gather all category data up front ────────────────────────
   $catQuery = $evmulti->query(
       "SELECT id, img, cover, title, status FROM tbl_category ORDER BY id ASC"
   );
   $categories = [];
   while ($row = $catQuery->fetch_assoc()) {
       $eventCount = $evmulti->query(
           "SELECT id FROM tbl_event WHERE cid=" . (int)$row["id"]
       )->num_rows;
       $row['event_count'] = $eventCount;
       $categories[] = $row;
   }

   $totalCategories = count($categories);
   $publishedCount = 0;
   $unpublishedCount = 0;
   foreach ($categories as $cat) {
       if ($cat['status'] == 1) {
           $publishedCount++;
       } else {
           $unpublishedCount++;
       }
   }
?>
<link rel="stylesheet" href="assets/css/zenizee-page-catlist.css">
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
              ZENIZEE CATEGORY LIST — Custom Layout
              ═══════════════════════════════════════════════════════ -->
         <div class="mm-catlist">

            <!-- ── Page Header ─────────────────────────────── -->
            <header class="mm-catlist__header">
               <div class="mm-catlist__header-left">
                  <h1 class="mm-catlist__title">Categories</h1>
                  <p class="mm-catlist__subtitle">Manage your event categories and organize your content.</p>
               </div>
               <a href="add_category.php" class="mm-catlist__add-btn">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                  Add Category
               </a>
            </header>

            <!-- ── Stats Bar ───────────────────────────────── -->
            <div class="mm-catlist__stats-bar">
               <div class="mm-catlist__stat">
                  <span class="mm-catlist__stat-dot mm-catlist__stat-dot--total"></span>
                  <span class="mm-catlist__stat-value"><?php echo $totalCategories; ?></span>
                  <span class="mm-catlist__stat-label">Total</span>
               </div>
               <span class="mm-catlist__stat-separator"></span>
               <div class="mm-catlist__stat">
                  <span class="mm-catlist__stat-dot mm-catlist__stat-dot--published"></span>
                  <span class="mm-catlist__stat-value"><?php echo $publishedCount; ?></span>
                  <span class="mm-catlist__stat-label">Published</span>
               </div>
               <span class="mm-catlist__stat-separator"></span>
               <div class="mm-catlist__stat">
                  <span class="mm-catlist__stat-dot mm-catlist__stat-dot--unpublished"></span>
                  <span class="mm-catlist__stat-value"><?php echo $unpublishedCount; ?></span>
                  <span class="mm-catlist__stat-label">Unpublished</span>
               </div>
            </div>

            <!-- ── Search Bar ──────────────────────────────── -->
            <div class="mm-catlist__search-wrap">
               <span class="mm-catlist__search-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
               </span>
               <input type="text" class="mm-catlist__search-input" id="mmCatSearch" placeholder="Search categories..." autocomplete="off">
            </div>

            <!-- ── Category Grid ───────────────────────────── -->
            <div class="mm-catlist__grid" id="mmCatGrid">
               <?php if ($totalCategories === 0) { ?>
                  <!-- Empty State -->
                  <div class="mm-catlist__empty">
                     <div class="mm-catlist__empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                     </div>
                     <h3 class="mm-catlist__empty-title">No categories yet</h3>
                     <p class="mm-catlist__empty-text">Create your first event category to start organizing your events into meaningful groups.</p>
                  </div>
               <?php } else {
                  $i = 0;
                  foreach ($categories as $cat) {
                     $i++;
                     $hasImage = !empty($cat['img']);
                     $isPublished = $cat['status'] == 1;
               ?>
                  <div class="mm-catlist__card" style="--card-index: <?php echo $i; ?>" data-cat-name="<?php echo htmlspecialchars(strtolower($cat['title'])); ?>">
                     <!-- Card Image -->
                     <div class="mm-catlist__card-visual">
                        <?php if ($hasImage) { ?>
                           <img src="<?php echo htmlspecialchars($cat['img']); ?>" alt="<?php echo htmlspecialchars($cat['title']); ?>" class="mm-catlist__card-img" loading="lazy">
                        <?php } else { ?>
                           <div class="mm-catlist__card-no-img">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                           </div>
                        <?php } ?>
                        <!-- Status Badge -->
                        <span class="mm-catlist__status-badge <?php echo $isPublished ? 'mm-catlist__status-badge--published' : 'mm-catlist__status-badge--unpublished'; ?>">
                           <?php echo $isPublished ? 'Published' : 'Unpublished'; ?>
                        </span>
                        <!-- Index -->
                        <span class="mm-catlist__card-index"><?php echo $i; ?></span>
                     </div>

                     <!-- Card Body -->
                     <div class="mm-catlist__card-body">
                        <h3 class="mm-catlist__card-name" title="<?php echo htmlspecialchars($cat['title']); ?>">
                           <?php echo htmlspecialchars($cat['title']); ?>
                        </h3>
                        <div class="mm-catlist__card-meta">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                           <?php echo $cat['event_count']; ?> event<?php echo $cat['event_count'] != 1 ? 's' : ''; ?>
                        </div>
                     </div>

                     <!-- Card Actions -->
                     <div class="mm-catlist__card-actions">
                        <a href="add_category.php?id=<?php echo $cat['id']; ?>" class="mm-catlist__action-btn mm-catlist__action-btn--edit">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                           Edit
                        </a>
                        <span class="mm-catlist__action-spacer"></span>
                        <button type="button" class="mm-catlist__action-btn mm-catlist__action-btn--delete" onclick="mmCatConfirmDelete(<?php echo $cat['id']; ?>, '<?php echo addslashes(htmlspecialchars($cat['title'])); ?>')">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                           Delete
                        </button>
                     </div>
                  </div>
               <?php
                  }
               }
               ?>
            </div>
            <!-- /.mm-catlist__grid -->

         </div>
         <!-- /.mm-catlist -->

         <!-- ── Delete Confirmation Modal ──────────────── -->
         <div class="mm-catlist__modal-overlay" id="mmCatDeleteModal">
            <div class="mm-catlist__modal">
               <div class="mm-catlist__modal-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
               </div>
               <h3 class="mm-catlist__modal-title">Delete Category</h3>
               <p class="mm-catlist__modal-text" id="mmCatDeleteText">Are you sure you want to delete this category? This action cannot be undone.</p>
               <div class="mm-catlist__modal-actions">
                  <button type="button" class="mm-catlist__modal-btn mm-catlist__modal-btn--cancel" onclick="mmCatCloseModal()">Cancel</button>
                  <button type="button" class="mm-catlist__modal-btn mm-catlist__modal-btn--confirm" id="mmCatDeleteConfirm">Delete</button>
               </div>
            </div>
         </div>

      </div>
      <!-- footer start-->
   </div>
</div>
<?php include "filemanager/script.php"; ?>
<script>
// ── Category Search ─────────────────────────────────────────────
(function() {
   var searchInput = document.getElementById('mmCatSearch');
   if (!searchInput) return;

   searchInput.addEventListener('input', function() {
      var query = this.value.toLowerCase().trim();
      var cards = document.querySelectorAll('.mm-catlist__card');
      var visibleCount = 0;

      cards.forEach(function(card) {
         var name = card.getAttribute('data-cat-name') || '';
         if (!query || name.indexOf(query) !== -1) {
            card.style.display = '';
            visibleCount++;
         } else {
            card.style.display = 'none';
         }
      });

      // Show/hide empty state for search
      var grid = document.getElementById('mmCatGrid');
      var existingNoResult = document.getElementById('mmCatNoResult');
      if (existingNoResult) existingNoResult.remove();

      if (visibleCount === 0 && query) {
         var noResult = document.createElement('div');
         noResult.id = 'mmCatNoResult';
         noResult.className = 'mm-catlist__empty';
         noResult.innerHTML = '<div class="mm-catlist__empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div><h3 class="mm-catlist__empty-title">No results found</h3><p class="mm-catlist__empty-text">No categories match your search. Try a different keyword.</p>';
         grid.appendChild(noResult);
      }
   });
})();

// ── Delete Confirmation ─────────────────────────────────────────
var mmCatDeleteId = null;

function mmCatConfirmDelete(id, name) {
   mmCatDeleteId = id;
   var modal = document.getElementById('mmCatDeleteModal');
   var text = document.getElementById('mmCatDeleteText');
   text.textContent = 'Are you sure you want to delete "' + name + '"? This action cannot be undone.';
   modal.classList.add('mm-catlist__modal-overlay--active');
}

function mmCatCloseModal() {
   mmCatDeleteId = null;
   var modal = document.getElementById('mmCatDeleteModal');
   modal.classList.remove('mm-catlist__modal-overlay--active');
}

// Close modal on overlay click
document.getElementById('mmCatDeleteModal').addEventListener('click', function(e) {
   if (e.target === this) {
      mmCatCloseModal();
   }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
   if (e.key === 'Escape') {
      mmCatCloseModal();
   }
});

// Confirm delete — redirect to self with delete_id param
document.getElementById('mmCatDeleteConfirm').addEventListener('click', function() {
   if (!mmCatDeleteId) return;
   window.location.href = 'list_category.php?delete_id=' + mmCatDeleteId;
});
</script>
<!-- Plugin used-->
</body>
</html>
