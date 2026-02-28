$(document).ready(function () {
  // ─── Generic form submit handler ───
  // All forms with a hidden "type" field submit via AJAX to manager.php
  // Forms with file inputs use FormData, others use FormData too (works for both)
  $("form").on("submit", function (e) {
    e.preventDefault();
    var form = $(this);
    var formData = new FormData(this);

    // Summernote editors: sync content to textarea before submit
    form.find("textarea").each(function () {
      var el = $(this);
      if (el.hasClass("summernote") || el.attr("id") === "cdesc" || el.attr("id") === "disclaimer") {
        try { el.val(el.summernote("code")); formData.set(el.attr("name"), el.summernote("code")); } catch (ex) {}
      }
    });

    // Select2 multi-selects: ensure array values are sent
    form.find("select[multiple]").each(function () {
      var name = $(this).attr("name");
      var vals = $(this).val();
      if (vals && vals.length) {
        formData.delete(name);
        vals.forEach(function (v) { formData.append(name, v); });
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
        }
      },
      error: function (xhr) {
        console.error("Form submit error:", xhr.status, xhr.responseText);
        swal("Error", "Something went wrong (HTTP " + xhr.status + ")", "error");
      },
    });
  });

  // ─── Status update handler (cancel/complete/toggle) ───
  $(".drop").on("click", function () {
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
          data: { id: id, status: status, type: type, coll_type: coll_type, page_name: page_name },
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

  // ─── Select2 init ───
  $("select.select2-single").select2();
  $("select.select2-multi-select").select2();
});
