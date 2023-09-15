//function of addtocartbtns

function addtocart(e) {
  if (!e.target.dataset.isUser) {
    const myModalEl = document.getElementById("exampleModal");
    const modal = bootstrap.Modal.getInstance(myModalEl);
    modal.hide();
    alertLogin(true, "Oops! It looks like you're not logged in yet.");
    document.querySelector(".modal-login").classList.add("show-modal");
    return;
  }
  if (e.target.dataset.isbn) {
    const bookid = e.target.dataset.isbn;
    console.log(bookid);
    const param = `bookid=${bookid}&userid=${userid}`;
    const xhrs = new XMLHttpRequest();
    xhrs.open("POST", "methods/addtocart1.php", true);

    xhrs.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhrs.onload = function () {
      if (xhrs.status == 200) {
        const res = xhrs.responseText;

        cartcontainer.innerHTML = res;
        const checkbox = Array.from(document.querySelectorAll(".selectcheck"));
        showAllCollection();
        const titles = document.querySelector(".currerror");
        if (titles) {
          alert("System Message:" + titles.innerText);
        } else {
          const title = document.querySelector(".currtitle");

          alert(
            "System Message: Book:" +
              title.innerText +
              " ... successfully added to your cart, Total of " +
              checkbox.length +
              " book/s"
          );
        }
      } else {
        console.log("failed");
      }
    };
    xhrs.send(param);
  }
}
