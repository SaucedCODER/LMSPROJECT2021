$(document).ready(function () {
  $("#yearpublished").datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    autoclose: true,
    icons: {
      time: "bi bi-clock",
      date: "bi bi-calendar",
      up: "bi bi-caret-up-fill",
      down: "bi bi-caret-down-fill",
      previous: "bi bi-caret-left-fill",
      next: "bi bi-caret-right-fill",
      today: "bi bi-calendar-event",
      clear: "bi bi-trash",
      close: "bi bi-x",
    },
  });

  $("#bookprice").inputmask("currency", {
    radixPoint: ".",
    groupSeparator: ",",
    prefix: "₱ ",
    autoUnmask: true,
    rightAlign: false,
  });
});
