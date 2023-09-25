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
(() => {
  "use strict";

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll(".needs-validation");
  // Loop over them and prevent submission
  Array.from(forms).forEach((form) => {
    form.addEventListener(
      "submit",
      (event) => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add("was-validated");
      },
      false
    );
  });
})();
