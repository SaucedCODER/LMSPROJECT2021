function alertLogin(isActive, message = "") {
  document.querySelector("#errorMess").parentElement.style.display = isActive
    ? "block"
    : "none";
  document.querySelector("#errorMess").textContent = message;
  if (isActive) {
    setTimeout(() => {
      document.querySelector("#errorMess").textContent = "";
      document.querySelector("#errorMess").parentElement.style.display = "none";
    }, 5000);
  }
}
