function openBookModal(title, action, bookData = null) {
  // Set the modal title
  document.querySelector("#addBookModalLabel").textContent = title;

  // Set the form action (e.g., 'addnewbookfunc' for adding, 'updatebookfunc' for updating)
  document.querySelector("#addnewbk").setAttribute("onsubmit", action);

  // Clear form fields
  const form = document.querySelector("#addnewbk");
  form.reset();

  if (bookData) {
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

//Function deletion book data from api
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
  openBookModal("Edit Book", "methods2/manageboookui.php?action=update", data);
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
    const maxSizeKB = 100 * 1024; // 100KB

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
