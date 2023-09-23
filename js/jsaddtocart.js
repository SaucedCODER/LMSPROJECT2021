function addtocart(e) {
  const isUser = e.target.dataset.isuser;
  const bookISBN = e.target.dataset.isbn;
  console.log(typeof isUser);
  if (isUser === "false") {
    handleUserNotLoggedIn();
    return;
  }

  if (bookISBN) {
    const param = new URLSearchParams({
      bookid: bookISBN,
      userid: userid,
    }).toString();

    fetch("methods/addtocart1.php", {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded",
      },
      body: param,
    })
      .then((response) => {
        if (response.ok) {
          return response.json(); // Parse the response as JSON
        } else {
          throw new Error("Request failed");
        }
      })
      .then((res) => {
        console.log(res.message);
        getbookFromCartReq();
        showallcollection();
        if (res.error != null) {
          showAlert2(false, "System Message: " + res.error, "warn");
        } else {
          showAlert2(true, `System Message: Book: ${res.message} `, "add");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        showAlert2(false, "System Message: Request failed");
      });
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

function showAlert2(isSuccess, message, purpose = "default", callback = null) {
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
      case "Delete":
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
            callback || callback();
            Swal.fire("Deleted!", message, "success");
          }
        });
        break;
      default:
        Swal.fire("Successfully", message, "success");
        break;
    }
  }
}
