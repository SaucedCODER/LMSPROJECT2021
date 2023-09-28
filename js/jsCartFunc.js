//multi modal manual entry lend to book user

function lendshowmodal() {
  if (document.getElementById("emptyCartMessage") !== null) {
    Swal.fire({
      icon: "error",
      title: "Empty Cart",
      text: "Your lending cart is empty. Please add books to your cart to proceed with lending.",
      confirmButtonText: "OK",
    });
    throw new Error(
      "Your lending cart is empty. Please add books to your cart to proceed with lending."
    );
  }

  Swal.fire({
    title: "Lookup User",
    text: "Please enter the user System ID:",
    input: "text",
    inputAutoTrim: false,
    inputAttributes: {
      autocapitalize: "off",
    },
    showCancelButton: true,
    confirmButtonText: "Lookup",
    cancelButtonText: "Cancel",
    showLoaderOnConfirm: true,
    inputValidator: (value) => {
      if (!value) {
        return "Please enter a System ID";
      }
    },
    preConfirm: (lendtoid) => {
      const userId = userid;
      const formData = new FormData();
      formData.append("lendtouserid", lendtoid);
      formData.append("userid", userId);
      return fetch(`methods/manualentrylend.php`, {
        method: "POST",
        body: formData,
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error(response.statusText);
          }
          return response.json(); // Assuming the response is JSON
        })
        .then((response) => {
          console.log(response);
          if (response.error !== null) {
            throw new Error(response.error);
          }
          return response;
        })
        .catch((error) => {
          Swal.showValidationMessage(`Lookup failed: ${error.message}`);
        });
    },
    allowOutsideClick: () => !Swal.isLoading(),
  }).then((result) => {
    if (result.isConfirmed) {
      const { data, cart_count, toLendId } = result.value;

      Swal.fire({
        title: "Confirm User",
        html: `
                Found User:<br>
                Full Name: ${data.full_name}<br>
                Student ID: ${data.student_id}<br>
                <br>
                Do you want to lend (${cart_count}) book(s) to this user?`,
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Lend Books",
        cancelButtonText: "Cancel",
      }).then((confirmation) => {
        if (confirmation.isConfirmed) {
          const userId = userid;
          const formData = new FormData();
          formData.append("lendtouserid", toLendId);
          formData.append("userid", userId);
          fetch("methods/confirmationlend.php", {
            method: "POST",
            body: formData,
          })
            .then((response) => {
              if (!response.ok) {
                throw new Error("Network response was not ok");
              }
              return response.json(); // Assuming the response is plain text
            })
            .then((response) => {
              console.log(response);
              if (response.error !== null) {
                throw new Error(response.error);
              }
              return response;
            })
            .then((res) => {
              Swal.fire({
                position: "top-end",
                icon: "success",
                title: res.message,
                showConfirmButton: false,
                timer: 2000,
              });
              showallcollection();
              closeOffcanvas();
            })
            .catch((error) => {
              console.error("Fetch error:", error);
              Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Oops...",
                text: error.message,
                confirmButtonText: "OK",
              });
            });
        }
      });
    }
  });
}

//removing selected items from cart
function getallchecks() {
  const checkbox = Array.from(document.querySelectorAll(".selectcheck"));
  console.log(checkbox);
  console.log(checkbox.length);
  //get all checked items
  let newarray = checkbox.reduce((total, item) => {
    if (item.checked) {
      total.push(item.value);
    }
    return total;
  }, []);

  const toDeleteFunc = (newarray, userid) => {
    const params = `deleteitemsfromcart=${JSON.stringify(
      newarray
    )}&userid=${userid}`;
    const xhrs = new XMLHttpRequest();
    xhrs.open("POST", "methods/deletemultiple.php", true);

    xhrs.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhrs.onload = function () {
      if (xhrs.status == 200) {
        const res = xhrs.responseText;
        cartcontainer.innerHTML = res;
        updateCounterCart();
      } else {
        console.log("failed");
      }
    };
    xhrs.send(params);
  };

  if (newarray.length > 0) {
    console.log(checkbox.length + "true");

    console.log(newarray);
    showAlert2(
      true,
      "System Message: Items Removed: " +
        newarray.length +
        " books have been successfully removed from your cart.",
      "Delete",
      () => toDeleteFunc(newarray, userid)
    );
  }
}

// initial run to see how many items in cart/
getbookFromCartReq();
//get book from cart in the database
function getbookFromCartReq() {
  fetch("methods/getbookfromcart.php", {
    method: "POST",
    headers: {
      "Content-type": "application/x-www-form-urlencoded",
    },
    body: `userid=${userid}`,
  })
    .then((response) => {
      if (response.status === 200) {
        return response.text();
      } else {
        throw new Error("Request failed");
      }
    })
    .then((res) => {
      cartcontainer.innerHTML = res;
      updateCounterCart();
    })
    .catch((error) => {
      console.log("failed", error);
    });
}
//toggle checkbox Cart
function toggleCheckboxCart(checkboxId) {
  const checkbox = document.getElementById(checkboxId);
  if (checkbox) {
    checkbox.checked = !checkbox.checked;
  }
}
//close cart offcanvas
function closeOffcanvas() {
  $("#cartCanvas").offcanvas("hide");
}
function updateCounterCart() {
  const cartCounter = document.getElementById("cartItemCount");

  const cartUl = document.getElementById("cartItems").children;
  if (cartUl[0].id == "emptyCartMessage")
    return (cartCounter.textContent = "0");
  cartCounter.textContent = cartUl.length;
}
