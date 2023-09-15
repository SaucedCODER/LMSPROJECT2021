const tracat = document.querySelector(".trackcat");
const select = document.querySelector("#select");
const searchform = document.querySelector(".filter-search");

const input = document.querySelector("#search");
const droplistcontainer = document.querySelector(".searchdroplist");

input.addEventListener("keyup", search);
droplistcontainer.addEventListener("click", autocomplete);
searchform.addEventListener("submit", submitsearch);

function submitsearch(e) {
  e.preventDefault();
  console.log(tracat.textContent);
  if (input.value.length >= 0) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "trysearch2.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
      if (xhr.status == 200) {
        const res = xhr.responseText;
        collection.innerHTML = res;
        console.log(res);
      } else {
        console.log("failed");
      }
    };

    xhr.send(
      `search=${input.value}&select=${select.value}&category=${tracat.textContent}`
    );
  }
}

function search(e) {
  if (input.value.length >= 0) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "trysearch.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
      if (xhr.status == 200) {
        const res = xhr.responseText;

        droplistcontainer.innerHTML = res;
        if (res != "") {
          droplistcontainer.style.display = "block";
        } else {
          droplistcontainer.style.display = "none";
        }
      } else {
        console.log("failed");
      }
    };
    console.log(tracat.textContent);
    xhr.send(
      `search=${input.value}&select=${select.value}&category=${tracat.textContent}`
    );
  }
}

function autocomplete(e) {
  if (e.target.dataset.listid) {
    input.value = e.target.textContent;
    droplistcontainer.style.display = "none";
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "trysearch2.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
      if (xhr.status == 200) {
        const res = xhr.responseText;
        collection.innerHTML = res;
        console.log(res);
      } else {
        console.log("failed");
      }
    };
    xhr.send(
      `search=${input.value}&select=${select.value}&category=${tracat.textContent}`
    );
  }
}
//end of search area
