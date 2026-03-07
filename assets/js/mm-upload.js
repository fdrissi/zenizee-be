/**
 * mm-upload.js — MagicMate Shared Upload Visual Feedback
 *
 * Works with ANY page that uses the mm-*__upload BEM pattern:
 *   <div class="mm-[page]__upload">
 *     <input type="file" class="mm-[page]__upload-input" />
 *     <div  class="mm-[page]__upload-icon">...</div>
 *     <p    class="mm-[page]__upload-label">...</p>
 *     <p    class="mm-[page]__upload-hint">...</p>
 *   </div>
 *
 * No dependencies. Vanilla JS only.
 */

(function () {
  'use strict';

  // ── Helpers ──────────────────────────────────────────────────────────────

  /**
   * Given any element inside an upload zone, return the zone root
   * (the element whose class ends with __upload, e.g. mm-eventedit__upload).
   */
  function getUploadZone(el) {
    return el.closest('[class*="__upload"]:not([class*="__upload-input"]):not([class*="__upload-icon"]):not([class*="__upload-label"]):not([class*="__upload-hint"])');
  }

  /**
   * True when the class list contains a class that ends with "__upload"
   * and is NOT a sub-element suffix.
   */
  function isUploadZone(el) {
    if (!el || !el.classList) return false;
    return Array.from(el.classList).some(function (c) {
      return /__upload$/.test(c);
    });
  }

  /**
   * Build a truncated display name: up to 40 chars, then "…"
   */
  function truncate(str, max) {
    max = max || 40;
    return str.length > max ? str.slice(0, max - 1) + '\u2026' : str;
  }

  // ── State reset ──────────────────────────────────────────────────────────

  function resetZone(zone, input) {
    // Remove injected elements
    var prev = zone.querySelector('.mm-upload__preview');
    var icon  = zone.querySelector('.mm-upload__file-icon');
    var fname = zone.querySelector('.mm-upload__filename');
    var btn   = zone.querySelector('.mm-upload__remove');
    if (prev)  prev.parentNode.removeChild(prev);
    if (icon)  icon.parentNode.removeChild(icon);
    if (fname) fname.parentNode.removeChild(fname);
    if (btn)   btn.parentNode.removeChild(btn);

    // Remove state classes
    zone.classList.remove('mm-upload--has-file', 'mm-upload--dragover');

    // Re-enable file input overlay
    input.style.pointerEvents = '';

    // Clear the native input value
    input.value = '';
  }

  // ── Render preview ───────────────────────────────────────────────────────

  function renderPreview(zone, input, file) {
    // Mark zone as having a file
    zone.classList.add('mm-upload--has-file');

    // Disable the invisible overlay so remove button is clickable
    input.style.pointerEvents = 'none';

    var isImage = file.type.startsWith('image/');

    if (isImage) {
      // Create <img> with FileReader data-URL
      var img = document.createElement('img');
      img.className = 'mm-upload__preview';
      img.alt = file.name;

      var reader = new FileReader();
      reader.onload = function (e) {
        img.src = e.target.result;
      };
      reader.readAsDataURL(file);

      zone.appendChild(img);
    } else {
      // Non-image: show a generic file icon
      var iconWrap = document.createElement('div');
      iconWrap.className = 'mm-upload__file-icon';
      iconWrap.innerHTML =
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">' +
          '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>' +
          '<polyline points="14 2 14 8 20 8"/>' +
        '</svg>';
      zone.appendChild(iconWrap);
    }

    // Filename label
    var nameEl = document.createElement('p');
    nameEl.className = 'mm-upload__filename';
    nameEl.textContent = truncate(file.name);
    zone.appendChild(nameEl);

    // Remove (×) button
    var removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'mm-upload__remove';
    removeBtn.title = 'Remove file';
    removeBtn.setAttribute('aria-label', 'Remove selected file');
    removeBtn.textContent = '\u00D7'; // ×
    zone.appendChild(removeBtn);

    removeBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      resetZone(zone, input);
    });
  }

  // ── Attach handlers to a single input ────────────────────────────────────

  function initInput(input) {
    var zone = getUploadZone(input);
    if (!zone) return;

    // ── change: file selected via dialog ──
    input.addEventListener('change', function () {
      if (input.files && input.files.length > 0) {
        renderPreview(zone, input, input.files[0]);
      } else {
        resetZone(zone, input);
      }
    });

    // ── drag-over visual feedback ──
    zone.addEventListener('dragover', function (e) {
      e.preventDefault();
      zone.classList.add('mm-upload--dragover');
    });

    zone.addEventListener('dragleave', function (e) {
      // Only remove if we actually left the zone (not a child element)
      if (!zone.contains(e.relatedTarget)) {
        zone.classList.remove('mm-upload--dragover');
      }
    });

    zone.addEventListener('drop', function (e) {
      e.preventDefault();
      zone.classList.remove('mm-upload--dragover');

      var files = e.dataTransfer && e.dataTransfer.files;
      if (!files || files.length === 0) return;

      // Assign dropped file to the input (where browser allows)
      try {
        var dt = new DataTransfer();
        dt.items.add(files[0]);
        input.files = dt.files;
      } catch (err) {
        // DataTransfer not supported — preview only, input stays empty
      }

      renderPreview(zone, input, files[0]);
    });
  }

  // ── Boot ─────────────────────────────────────────────────────────────────

  function init() {
    // Select ALL file inputs whose class contains "__upload-input"
    var inputs = document.querySelectorAll('[class*="__upload-input"][type="file"]');
    inputs.forEach(function (input) {
      initInput(input);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    // DOM already ready (e.g., script placed at bottom of <body>)
    init();
  }

})();
