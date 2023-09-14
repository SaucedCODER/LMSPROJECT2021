//book modal area

const modalbook = document.querySelector(".modal-body");

function viewbookev(e) {
  if (e.currentTarget.dataset.bookuniq) {
    const abc = e.currentTarget.dataset.bookuniq;
    console.log(abc);
    openbookmodal();
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "methods2/viewbookdetail.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
      if (xhr.status == 200) {
        const res = xhr.responseText;
        modalbook.innerHTML = res;
      } else {
        console.log("failed");
      }
    };
    xhr.send(`isbn=${abc}`);
  }
}

function openbookmodal() {
  modalbook.classList.add("showmodalbk");
}

function closebookmodal(e) {
  e.preventDefault();
  document.body.style.overflow = "auto";

  modalbook.classList.remove("showmodalbk");
}
