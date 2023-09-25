function openBookModal(title, action, bookData = null) {
  // Set the modal title
  document.querySelector("#addBookModalLabel").textContent = title;

  const saveButton = document.querySelector("#bookSaveBtn");
  saveButton.setAttribute("data-route", action);

  // Clear form fields
  const form = document.querySelector("#addnewbk");
  form.reset();

  if (bookData != null) {
    document.querySelector("#isbn").value = bookData.isbn;
    document.querySelector("#title").value = bookData.title;
    document.querySelector("#author").value = bookData.author;
    document.querySelector("#category").value = bookData.category;
    document.querySelector("#bookprice").value = bookData.bookprice;
    document.querySelector("#yearpublished").value = bookData.yearpublished;
    document.querySelector("#publisher").value = bookData.publisher;
    document.querySelector("#quantity").value = bookData.quantity;
    document.querySelector("#abstract").value = bookData.abstract;

    // Populate the image src attribute
    const img = document.querySelector("#chimg");
    img.src = bookData.image;

    // Disable the ISBN input field
    document.querySelector("#isbn").disabled = true;
  } else {
    // Enable the ISBN input field when adding a new book
    document.querySelector("#isbn").disabled = false;
  }

  // Show the modal
  $("#bookModal").modal("show");
}
//onclick event for saving and updating trigger save button

document.querySelector("#bookSaveBtn").addEventListener("click", function (e) {
  e.preventDefault();
  e.stopPropagation();
  const formData = prepareFormData();
  console.log("uumay");
  if (!formData) return;
  const formInputs = document.querySelector("#addnewbk");

  const route = this.getAttribute("data-route");
  reFetch(
    route,
    "POST",
    (data) => {
      console.log(data, "data");
      if (data.success) {
        formInputs.reset();
        const defaultImage = "booksimg/bookdefault.png";
        const chimg = document.querySelector("#chimg");
        chimg.src = defaultImage;
        $("#bookModal").modal("hide");
        reFetch("./methods2/managebooks.php", "GET", displayManageBooks);
        if (route.includes("insert")) {
          showAlert2(true, data.message, "add");
        } else {
          //check if title exists if so set no changes alert and its message
          if (data.message.title) {
            const { title, text } = data.message;
            showAlert2(true, { title, text }, "noChanges");
          } else {
            showAlert2(true, data.message, "update");
          }
        }

        // Show the modal
      } else {
        // Show an error SweetAlert notification using showAlert2
        if (data.message.includes("already exist")) {
          document.querySelector("#isbn").value = "";
          document.querySelector("#isbn").classList.add("is-invalid");
          showAlert2(false, data.message, "warn");
        } else {
          showAlert2(false, data.message, "warn");
        }
      }
    },
    formData
  );
});

// getting all datas from the form it will be passed to the api
function prepareFormData() {
  const uform = document.querySelector("#addnewbk");
  const formInputs = uform.getElementsByTagName("input");
  const nonFileInputs = Array.from(formInputs).filter(
    (input) => input.type !== "file"
  );

  const formData = new FormData();
  // Flag to track if any input field is empty
  let hasEmptyField = false;
  const abstract = uform.querySelector("textarea"); // Use querySelector to get the first textarea
  const abstractValue = abstract.value || "";
  if (abstractValue.trim() === "") {
    hasEmptyField = true;
    abstract.classList.add("is-invalid");
  } else {
    formData.append(abstract.name, abstractValue);
    abstract.classList.remove("is-invalid");
  }
  for (let input of nonFileInputs) {
    // Loop through input fields to check for empty values
    console.log(input.value);

    if (input.value.trim() === "") {
      hasEmptyField = true;
      input.classList.add("is-invalid");
      input.value = "";
    } else {
      input.classList.remove("is-invalid");
    }
    formData.append(input.name, input.value);
  }

  const bookimgfile = document.querySelector("#filebdata").files;
  if (bookimgfile.length > 0) {
    formData.append("file", bookimgfile[0]);
  }
  // If any field is empty, display an alert and prevent form submission
  if (hasEmptyField) {
    showAlert2(false, "Please fill in all required fields", "warn");
    return false;
  }
  return formData;
}

//deletion of bookdata
function deleteBook(isbn) {
  reFetch(
    `methods2/managebookui.php?isbn=${encodeURIComponent(isbn)}`,
    "DELETE",
    deleteBookData
  );
}

function deleteBookData(data) {
  const bookDeletionMessage = data.message;
  showAlert2(true, `System Message: ${bookDeletionMessage}`);
}

//Function get book data from api
function editBook(isbn) {
  reFetch(
    `methods2/managebookui.php?isbn=${encodeURIComponent(isbn)}`,
    "GET",
    getBookData
  );
}
function getBookData(data) {
  console.log(data);
  openBookModal("Edit Book", "methods2/managebookui.php?action=update", data);
}
//image algo
document
  .querySelector("#filebdata")
  .addEventListener("change", function (event) {
    const fileInput = event.target;
    const file = fileInput.files[0];
    const defaultImage = "booksimg/bookdefault.png";
    const chimg = document.querySelector("#chimg");

    // Define allowed file extensions and maximum file size
    const allowedExtensions = ["jpg", "jpeg", "png"];
    const maxSizeKB = 2 * 1024 * 1024; // 2MB

    if (file) {
      const fileExtension = file.name.split(".").pop().toLowerCase();

      if (!allowedExtensions.includes(fileExtension)) {
        showAlert2(false, "Invalid File Format", "warn");
        fileInput.value = "";

        chimg.src = defaultImage;
        return;
      }

      if (file.size > maxSizeKB) {
        showAlert2(false, "File Size Exceeded", "warn");
        fileInput.value = ""; // Clear the file input
        chimg.src = defaultImage;
        return;
      }
      console.log("heheheh");
      readURL(fileInput);
    } else {
      // Set the default image if no file was selected
      chimg.src = defaultImage;
    }
  });
