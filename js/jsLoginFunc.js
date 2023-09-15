// login modal codes
const modalcontainer = document.querySelector(".modal-login");
const logbtn = document.querySelector(".loginbtn");
const logclose = document.querySelector("#close-login");

logbtn.addEventListener("click", showmodal);

function showmodal() {
  modalcontainer.classList.add("show-modal");
}

logclose.addEventListener("click", closemodal);

function closemodal(e) {
  e.preventDefault();

  modalcontainer.classList.remove("show-modal");
}

async function onLogin(e) {
  e.preventDefault();
  alertLogin(false);

  const formElement = document.getElementById("login-form");
  const formData = new FormData(formElement);

  try {
    const res = await fetch("loginlogic.php", {
      method: "POST",
      body: formData,
    });

    if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);

    const responseData = await res.json();
    console.log(responseData);
    if (responseData.success) {
      // Redirect to a new page
      window.location.href = responseData.redirect;
    } else {
      alertLogin(true, responseData.message);
    }
  } catch (error) {
    console.error("Error:", error);
    document.querySelector("#errorMess").textContent = error.message;
  }
}
