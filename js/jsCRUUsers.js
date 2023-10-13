function openMemberModal(title, action, userData = null) {
  // Set the modal title
  document.querySelector("#profileModalLabel").textContent = title;

  const saveButton = document.querySelector("#userSaveBtn");
  const passwordPlaceholder = document.querySelector("#memberModal small");

  saveButton.setAttribute("data-route", action);

  // Clear form fields
  const form = document.querySelector("#addNewUser");
  form.reset();
  console.log(userData);
  if (userData != null) {
    document.getElementById("username").value = userData.user_id;
    document.getElementById("firstName").value = userData.Fname;
    document.getElementById("lastName").value = userData.Lname;
    document.getElementById("residenceAddress").value = userData.ResAdrs;
    document.getElementById("officialAddress").value = userData.OfcAdrs;
    document.getElementById("landlineNumber").value = userData.LandlineNo;
    document.getElementById("mobileNumber").value = userData.MobileNo;
    document.getElementById("email").value = userData.Email;
    document.getElementById("genderUsersModal").value = userData.Gender;
    document.getElementById("username").value = userData.username;
    document.getElementById("password").value = "";
    document.getElementById("typeUsersModal").value = userData.type;
    // document.getElementById("status").value = userData.status;

    // Populate the image src attribute
    document.getElementById("profileImageModal").src =
      "./" + userData.profileImage;
    passwordPlaceholder.style.display = "inline-block";

    // Disable the ISBN input field
  } else {
    // Enable the ISBN input field when adding a new book
    const defaultImage = "usersprofileimg/profiledefault.png";
    document.getElementById("profileImageModal").src = "./" + defaultImage;
    passwordPlaceholder.style.display = "none";
  }

  // Show the modal
  $("#memberModal").modal("show");
}

document.querySelector("#userSaveBtn").addEventListener("click", function (e) {
  e.preventDefault();
  e.stopPropagation();
  const formInputs = document.querySelector("#addNewUser");
  const route = this.getAttribute("data-route");
  const formData = prepareFormDataUser(route);
  if (!formData) return;
  reFetch(
    route,
    "POST",
    (data) => {
      console.log(data, "data");
      if (data.success) {
        formInputs.reset();
        const defaultImage = "userprofileimg/profiledefault.png";
        const profileImage = document.getElementById("profileImageModal");
        profileImage.src = defaultImage;
        $("#memberModal").modal("hide");
        reFetch("ajax.php?action=GET_ALL_USER", "GET", displayManageMember); //render all the member

        if (route.includes("INSERT_USER")) {
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
          document.querySelector("#username").value = "";
          document.querySelector("#username").classList.add("is-invalid");
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
function prepareFormDataUser(route) {
  const uform = document.querySelector("#addNewUser");
  const formInputs = uform.getElementsByTagName("input");
  const formSelects = uform.getElementsByTagName("select");

  const nonFileReadOnlyInputs = Array.from(formInputs).filter(
    (input) => !(input.type === "file" || input.name === "readOnly")
  );
  const FormDatas = [...nonFileReadOnlyInputs, ...formSelects];
  console.log(nonFileReadOnlyInputs, "nonFileReadOnlyInputs");

  const formData = new FormData();
  // Flag to track if any input field is empty
  let hasEmptyField = false;
  for (let input of FormDatas) {
    // Loop through input fields to check for empty values
    if (input.value.trim() === "") {
      hasEmptyField = true;
      input.classList.add("is-invalid");
      input.value = "";
    } else {
      input.classList.remove("is-invalid");
    }
    //check if the password of update modal is empty dont append it to the form data
    if (input.name == "password" && route.includes("UPDATE")) {
      console.log("hellow");
      if (input.value.trim() !== "") {
        formData.append(input.name, input.value);
      } else {
        input.classList.remove("is-invalid");
        hasEmptyField = false;
      }
    } else {
      formData.append(input.name, input.value);
    }
  }
  const userImgFile = document.querySelector("#filePInput").files;
  console.log(userImgFile, "userImgFile");
  if (userImgFile.length > 0) {
    formData.append("file", userImgFile[0]);
  }
  // If any field is empty, display an alert and prevent form submission
  if (hasEmptyField) {
    showAlert2(false, "Please fill in all required fields", "warn");
    return false;
  }
  console.log(formData, "formData");
  return formData;
}
// function getUsers() {
//   //displayManageMember
//   reFetch(`ajax.php?action=GET_ALL_USER`, "GET", (data) => {
//     console.log(data);
//   });
// }
// getUsers();
document.addEventListener("DOMContentLoaded", () => {
  const userid = document.querySelector(".userid").dataset.userid;
  getUserProfile(userid, renderProfile);
});
function renderProfile(data) {
  document.querySelector("#profile-container").firstElementChild.src =
    "./" + data.profileImage;
}

//Function get Member data from api
function editMember(id) {
  const user_id = id;
  getUserProfile(user_id, (data) => {
    console.log(data, user_id);
    openMemberModal(
      "Update User Profile",
      `ajax.php?action=UPDATE_USER&user_id=${encodeURIComponent(id)}`,
      data
    );
  });
}
function getUserProfile(id, callback) {
  const formData = new FormData();
  formData.append("userid", id);
  reFetch(`ajax.php?action=GET_USER`, "POST", callback, formData);
}

//image upload logics
document
  .querySelector("#filePInput")
  .addEventListener("change", function (event) {
    const fileInput = event.target;
    const selectedFileName = document.getElementById("selectedFileName");

    if (fileInput.files.length > 0) {
      selectedFileName.value = fileInput.files[0].name;
    } else {
      selectedFileName.value = "";
    }

    const file = fileInput.files[0];
    const defaultImage = "usersprofileimg/profiledefault.png";
    const profileImage = document.querySelector("#profileImageModal");

    // Define allowed file extensions and maximum file size
    const allowedExtensions = ["jpg", "jpeg", "png"];
    const maxSizeKB = 2 * 1024 * 1024; // 2MB

    if (file) {
      const fileExtension = file.name.split(".").pop().toLowerCase();

      if (!allowedExtensions.includes(fileExtension)) {
        showAlert2(false, "Invalid File Format", "warn");
        fileInput.value = "";
        selectedFileName.value = "";

        profileImage.src = defaultImage;
        return;
      }

      if (file.size > maxSizeKB) {
        showAlert2(false, "File Size Exceeded", "warn");
        fileInput.value = ""; // Clear the file input
        profileImage.src = defaultImage;
        selectedFileName.value = "";

        return;
      }
      console.log("heheheh");
      readURL(fileInput, "profileImageModal");
    }
  });
