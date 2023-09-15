const collection = document.querySelector("#books-collection");
showallcollection();
//collection
function showallcollection() {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "./methods/showallbooks.php", true);
  xhr.onload = function () {
    if (xhr.status == 200) {
      const res = xhr.responseText;
      collection.innerHTML = res;
    } else {
      console.log("failed");
    }
  };
  xhr.send();
}
