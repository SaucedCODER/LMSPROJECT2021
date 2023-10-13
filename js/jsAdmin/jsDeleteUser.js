//deletion of Member
function deleteMember(id) {
  console.log("deletion of userData From DB");
  showAlert2(true, false, "Delete", () =>
    reFetch(
      `ajax.php?action=DELETE_USER&user_id=${encodeURIComponent(id)}`,
      "DELETE",
      deleteUserData
    )
  );
}

function deleteUserData(data) {
  const UserDeletionMessage = data.message;
  Swal.fire("Deleted!", UserDeletionMessage, "success");
  reFetch("ajax.php?action=GET_ALL_USER", "GET", displayManageMember); //render all the member
}
