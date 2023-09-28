function openMemberModal(title, action, userData = null) {
  // Set the modal title
  document.querySelector("#addBookModalLabel").textContent = title;

  const saveButton = document.querySelector("#bookSaveBtn");
  saveButton.setAttribute("data-route", action);

  // Clear form fields
  const form = document.querySelector("#addnewbk");
  form.reset();

  if (userData != null) {
    document.getElementById("userId").value = profileData.user_id;
    document.getElementById("firstName").value = profileData.Fname;
    document.getElementById("lastName").value = profileData.Lname;
    document.getElementById("residenceAddress").value = profileData.ResAdrs;
    document.getElementById("officialAddress").value = profileData.OfcAdrs;
    document.getElementById("landlineNumber").value = profileData.LandlineNo;
    document.getElementById("mobileNumber").value = profileData.MobileNo;
    document.getElementById("email").value = profileData.Email;
    document.getElementById("gender").value = profileData.Gender;
    document.getElementById("SystemId").value = profileData.username;
    document.getElementById("password").value = "";
    document.getElementById("type").value = profileData.type;
    document.getElementById("status").value = profileData.status;
    document.getElementById("profileImage").value = profileData.profileImage;

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

function getUserProfile() {
  const userid = document.querySelector(".userid").dataset.userid;
  const formData = new FormData();
  formData.append("userid", userid);
  reFetch(`ajax.php?action=GET_USER`, "POST", renderProfile, formData);
}
document.addEventListener("DOMContentLoaded", () => {
  getUserProfile();
});
function renderProfile(data) {
  document.querySelector("#profile-container").firstElementChild.src =
    "./" + data.profileImage;
}
function getUsers() {
  //displayManageMember
  reFetch(`ajax.php?action=GET_ALL_USER`, "GET", (data) => {
    console.log(data);
    // data.forEach((element) => {
    //   console.log(element.Email);
    // });
  });
}
getUsers();
document
  .getElementById("filePInput")
  .addEventListener("change", function (event) {
    const fileInput = event.target;
    const selectedFileName = document.getElementById("selectedFileName");

    if (fileInput.files.length > 0) {
      selectedFileName.value = fileInput.files[0].name;
    } else {
      selectedFileName.value = "";
    }
  });

// document
//   .querySelector("#filebdata")
//   .addEventListener("change", function (event) {
//     const fileInput = event.target;
//     const file = fileInput.files[0];
//     const defaultImage = "booksimg/bookdefault.png";
//     const chimg = document.querySelector("#chimg");

//     // Define allowed file extensions and maximum file size
//     const allowedExtensions = ["jpg", "jpeg", "png"];
//     const maxSizeKB = 2 * 1024 * 1024; // 2MB

//     if (file) {
//       const fileExtension = file.name.split(".").pop().toLowerCase();

//       if (!allowedExtensions.includes(fileExtension)) {
//         showAlert2(false, "Invalid File Format", "warn");
//         fileInput.value = "";

//         chimg.src = defaultImage;
//         return;
//       }

//       if (file.size > maxSizeKB) {
//         showAlert2(false, "File Size Exceeded", "warn");
//         fileInput.value = ""; // Clear the file input
//         chimg.src = defaultImage;
//         return;
//       }
//       console.log("heheheh");
//       readURL(fileInput);
//     } else {
//       // Set the default image if no file was selected
//       chimg.src = defaultImage;
//     }
//   });
