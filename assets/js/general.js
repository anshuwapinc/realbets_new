$(document).ready(function () {
  initTables();

  $(".sidebar-toggle").click(function () {
    if ($("#body").hasClass("sidebar-collapse")) {
      settogglenavigation("sidebar-collapse");
    } else {
      settogglenavigation("sidebar-collapsenon");
    }
    // window.location.href=base_url+"users/dashboard";
  });
});
function settogglenavigation(getvalue) {
  $.ajax({
    url: base_url + "users/settogglenavigation",
    type: "post",
    data: { setdefaulttoggle: getvalue },
    success: function (data) {},
    error: function (xhr, desc, err) {},
  });
}
function initTables() {
  $("table.dyntable:visible").each(function (i, ele) {
    var ele = $(ele);
    var source = ele.attr("source");
    var jsonStr = ele.attr("jsonInfo");
    var max_rows = ele.attr("max_rows");
    ele.dataTable({
      searchable: true,
      pageLength: 10,
      sortable: true,
      serverSide: true,
      processing: true,
      pagingType: "full_numbers",
      ajax: source,
      // order: [[0, "asc"]],
      columns: eval(jsonStr),
      dom: "lBfrtip",
      responsive:true,
      buttons: [
        {
          extend: "copyHtml5",
          exportOptions: {
            columns: ":visible",
          },
        },
        {
          extend: "excelHtml5",
          exportOptions: {
            columns: ":visible",
          },
        },
        {
          extend: "pdfHtml5",
          exportOptions: {
            columns: ":visible",
          },
        },
        "colvis",
      ],
    });

    ele.dataTable().fnFilterOnReturn();
  });
}

function timer_contdown(times) {
  var countDownDate = new Date(times).getTime();
  // Update the count down every 1 second
  var x = setInterval(function () {
    // Get today's date and time
    var now = new Date().getTime();
    // Find the distance between now and the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor(
      (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
    );
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Output the result in an element with id="demo"
    document.getElementById("timer1").innerHTML =
      days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
    // If the count down is over, write some text

    if (distance < 300000) {
      $(".payment_block_offer").show();
      $("#after-five").html(minutes + "min " + seconds + "sek ");
    }

    if (distance < 0) {
      clearInterval(x);
      document.getElementById("timer1").innerHTML = "EXPIRED";
      document.getElementById("after-five").innerHTML = "EXPIRED";
    }
  }, 1000);
}
