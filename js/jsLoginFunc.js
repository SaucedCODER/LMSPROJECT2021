// login modal codes
const modalcontainer = document.querySelector(".modal-login");
const logbtn = document.querySelector(".loginbtn");
const logclose = document.querySelector("#close-login");

logbtn.addEventListener("click", showmodal);

function showmodal() {
  modalcontainer.classList.add("show-modal");
}

function stuckmodal() {
  modalcontainer.classList.add("donthidemodal");
}

logclose.addEventListener("click", closemodal);

function closemodal(e) {
  e.preventDefault();

  modalcontainer.classList.remove("show-modal");

  modalcontainer.classList.remove("donthidemodal");
}
