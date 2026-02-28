/**
 * admin-handlers.js - MagicMate Admin Panel Client-Side Logic
 *
 * Replaces the obfuscated tbl_etom JS blob with clean, readable code.
 * Provides: AJAX form submission, status toggle, input masks,
 * coupon code generator, plugin initializations.
 */

// ─── Global helper functions (called from inline HTML attributes) ───

// Used by add_coupon.php and add_page.php: <form onsubmit="return postForm()">
// Returns true so the jQuery submit handler can intercept with e.preventDefault().
window.postForm = function () {
  return true;
};

// Used by add_coupon.php: <input onkeypress="return isNumberKey(event)">
// Allows alphanumeric characters only (letters + digits).
window.isNumberKey = function (e) {
  var c = e.which || e.keyCode;
  // 0-9 (48-57), A-Z (65-90), a-z (97-122)
  return (c >= 48 && c <= 57) || (c >= 65 && c <= 90) || (c >= 97 && c <= 122);
};

// Coupon code generator helper
function makeid(length) {
  var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  var result = "";
  for (var i = 0; i < length; i++) {
    result += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  return result;
}

$(document).ready(function () {

  // ─── Generic form submit handler ───
  // All forms with a hidden "type" field submit via AJAX to manager.php
  $(document).on("submit", "form", function (e) {
    e.preventDefault();
    var form = $(this);

    // Disable submit button to prevent double-submission
    form.find(':input[type="submit"]').prop("disabled", true);

    var formData = new FormData(this);

    // Summernote editors: sync content to textarea before submit
    form.find("textarea").each(function () {
      var el = $(this);
      if (el.hasClass("summernote") || el.attr("id") === "cdesc" || el.attr("id") === "disclaimer" || el.attr("id") === "cancle_policy") {
        try {
          el.val(el.summernote("code"));
          formData.set(el.attr("name"), el.summernote("code"));
        } catch (ex) {}
      }
    });

    // Select2 multi-selects: ensure array values are sent
    form.find("select[multiple]").each(function () {
      var name = $(this).attr("name");
      var vals = $(this).val();
      if (vals && vals.length) {
        formData.delete(name);
        vals.forEach(function (v) {
          formData.append(name, v);
        });
      }
    });

    $.ajax({
      url: "filemanager/manager.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (res) {
        if (res.Result === "true") {
          swal(res.title, res.message, "success").then(function () {
            window.location.href = res.action;
          });
        } else {
          swal(res.title, res.message, "error");
          form.find(':input[type="submit"]').prop("disabled", false);
        }
      },
      error: function (xhr) {
        console.error("Form submit error:", xhr.status, xhr.responseText);
        swal("Error", "Something went wrong (HTTP " + xhr.status + ")", "error");
        form.find(':input[type="submit"]').prop("disabled", false);
      },
    });
  });

  // ─── Status update handler (cancel/complete/toggle) ───
  $(document).on("click", ".drop", function () {
    var el = $(this);
    var id = el.attr("data-id");
    var status = el.attr("data-status");
    var type = el.attr("data-type");
    var coll_type = el.attr("coll-type");
    var page_name = window.location.pathname.split("/").pop();

    swal({
      title: "Are you sure?",
      text: "You want to change the status!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then(function (ok) {
      if (ok) {
        $.ajax({
          url: "filemanager/manager.php",
          type: "POST",
          data: {
            id: id,
            status: status,
            type: type,
            coll_type: coll_type,
            page_name: page_name,
          },
          dataType: "json",
          success: function (res) {
            if (res.Result === "true") {
              swal(res.title, res.message, "success").then(function () {
                window.location.href = res.action;
              });
            } else {
              swal(res.title, res.message, "error");
            }
          },
          error: function (xhr) {
            swal("Error", "Something went wrong (HTTP " + xhr.status + ")", "error");
          },
        });
      }
    });
  });

  // ─── Domain validation bypass ───
  $("#sub_activate").on("click", function (e) {
    e.preventDefault();
    window.location.href = "index.php";
  });

  // ─── Coupon code generator ───
  $(document).on("click", "#gen_code", function () {
    $("#ccode").val(makeid(8));
    return false;
  });

  // ─── Input masks ───

  // Number-only fields (digits 0-9 only)
  $(document).on("keypress", ".numberonly", function (e) {
    var key = e.which || e.keyCode;
    if (String.fromCharCode(key).match(/[^0-9]/)) {
      e.preventDefault();
      return false;
    }
  });

  // Mobile/phone fields (digits + plus sign)
  $(document).on("keypress", ".mobile", function (e) {
    var key = e.which || e.keyCode;
    if (String.fromCharCode(key).match(/[^0-9+]/)) {
      e.preventDefault();
      return false;
    }
  });

  // ─── Plugin initializations ───

  // Select2 dropdowns
  $(".select2-single").select2();
  $(".select2-multi-select").select2({ placeholder: "Choose" });

  // TagsInput
  if ($.fn.tagsinput) {
    $('[data-role="tagsinput"]').tagsinput();
  }

  // Re-initialize Select2 after DataTable redraws (pagination, search, etc.)
  $("#basic-1").on("draw.dt", function () {
    $(".select2-single").select2();
    $(".select2-multi-select").select2({ placeholder: "Choose" });
  });
});
