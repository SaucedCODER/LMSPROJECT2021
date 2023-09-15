//book modal area

function viewbookev(e) {
  const modalbook = document.querySelector(".modal-content");
  console.log("");
  if (e.currentTarget.dataset.bookuniq) {
    const abc = e.currentTarget.dataset.bookuniq;
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
  console.log(e);
}
