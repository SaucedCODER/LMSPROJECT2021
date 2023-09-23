//for filter category buttons
const categoriescontainer = document.querySelector(".container-4categories");
function showcategories() {
  const xhrs = new XMLHttpRequest();
  xhrs.open("GET", "methods/getcollectionjson.php", true);

  xhrs.onload = function () {
    if (xhrs.status == 200) {
      const res = JSON.parse(xhrs.responseText);

      const categories = getcategories(res);

      let outputcat = categories
        .map((e) => {
          return `
<input type="radio" class="btn-check" name="book-categories" id="${e}" autocomplete="off" ${
            e == "All" ? "checked" : ""
          }>
<label class="btn btn-outline-dark text-nowrap" data-cat="${e}" for="${e}">${e}</label>`;
        })
        .join("");
      categoriescontainer.innerHTML = outputcat;
    } else {
      console.log("failed");
    }
  };
  xhrs.send();
}
showcategories();

//click events for categories
categoriescontainer.addEventListener("click", filtercat);

function filtercat(e) {
  if (e.target.dataset.cat) {
    tracat.innerHTML = e.target.dataset.cat;
    const allbtncat = categoriescontainer.querySelectorAll("label");

    if (e.target.dataset.cat !== "All") {
      console.log("not all");

      const param = `category=${e.target.dataset.cat}`;
      const xhrs = new XMLHttpRequest();
      xhrs.open("POST", "methods/filtercategories.php", true);

      xhrs.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
      );

      xhrs.onload = function () {
        if (xhrs.status == 200) {
          const res = xhrs.responseText;
          collection.innerHTML = res;
        } else {
          console.log("failed");
        }
      };
      xhrs.send(param);
    } else {
      showallcollection();
    }
  }
}

//show button category
function getcategories(items) {
  const categorylist = items.reduce(
    (total, item) => {
      if (!total.includes(item.category)) {
        total.push(item.category);
      }
      return total;
    },
    ["All"]
  );

  return categorylist;
}
