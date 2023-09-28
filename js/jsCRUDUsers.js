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
  console.log(
    data,
    document.querySelector("#profile-container").firstElementChild
  );
  document.querySelector("#profile-container").firstElementChild.src =
    "./" + data.profileImage;
}
