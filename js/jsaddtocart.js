function addtocart(e) {
  const isUser = e.target.dataset.isuser;
  const bookISBN = e.target.dataset.isbn;
  console.log(typeof isUser);
  if (isUser === "false") {
    handleUserNotLoggedIn();
    return;
  }

  if (bookISBN) {
    const param = `bookid=${bookISBN}&userid=${userid}`;
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "methods/addtocart1.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
      if (xhr.status === 200) {
        const res = xhr.responseText;
        cartcontainer.innerHTML = res;
        showallcollection();

        const titles = document.querySelector(".currerror");
        if (titles) {
          showAlert2(false, "System Message: " + titles.innerText, "warn");
        } else {
          const title = document.querySelector(".currtitle");
          const checkbox = Array.from(
            document.querySelectorAll(".selectcheck")
          );
          const bookCount = checkbox.length;

          showAlert2(
            true,
            `System Message: Book: ${title.innerText},You have a total of ${bookCount} book/s in your cart`,
            "add"
          );
        }
      } else {
        console.log("Request failed");
        showAlert2(false, "System Message:Request failed");
        ``;
      }
    };

    xhr.send(param);
  }
}

function handleUserNotLoggedIn() {
  const myModalEl = document.getElementById("exampleModal");
  const modal = bootstrap.Modal.getInstance(myModalEl);
  modal.hide();

  if (typeof alertLogin !== "undefined" && alertLogin !== null) {
    alertLogin(true, "Oops! It looks like you're not logged in yet.");
    document.querySelector(".modal-login").classList.add("show-modal");
  }
}

function showAlert2(isSuccess, message, purpose = "default", payload = null) {
  if (!isSuccess) {
    switch (purpose) {
      case "warn":
        Swal.fire({
          icon: "error",
          title: "Warning",
          text: message,
        });
        break;
      default:
        Swal.fire({
          icon: "error",
          title: "Opps",
          text: message,
        });
        break;
    }
  }
  if (isSuccess) {
    if (purpose) {
    }
    switch (purpose) {
      case "add":
        Swal.fire("Successfully Added", message, "success");
        break;
      case "multiDelete":
        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        }).then((result) => {
          if (result.isConfirmed) {
            const { multiDelFunc, params } = payload;
            multiDelFunc(params.newarray, params.userid);
            Swal.fire("Deleted!", message, "success");
          }
        });
        break;

      case "assignment":
        Swal.fire({
          title: "Submit your Github username",
          input: "text",
          inputAttributes: {
            autocapitalize: "off",
          },
          showCancelButton: true,
          confirmButtonText: "Look up",
          showLoaderOnConfirm: true,
          preConfirm: (login) => {
            return fetch(`//api.github.com/users/${login}`)
              .then((response) => {
                if (!response.ok) {
                  throw new Error(response.statusText);
                }
                return response.json();
              })
              .catch((error) => {
                Swal.showValidationMessage(`Request failed: ${error}`);
              });
          },
          allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              title: `${result.value.login}'s avatar`,
              imageUrl: result.value.avatar_url,
            });
          }
        });
        break;
      default:
        Swal.fire("Successfully", message, "success");
        break;
    }
  }
}
