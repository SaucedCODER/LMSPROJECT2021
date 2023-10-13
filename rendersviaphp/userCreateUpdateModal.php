<div class="modal fade" id="memberModal" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg bg-body-secondary">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addNewUser" class="needs-validation" novalidate>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 d-flex flex-column align-items-center ">
                                <img width="150" height="150" id='profileImageModal' src="usersprofileimg/profile190001.jpg?1427093655" class="profile-image mb-2 rounded-circle border border-5 border-tertiary " alt="Profile Image" />
                                <div class="input-group btn-outline-info w-auto border border-1 flex-nowrap">
                                    <label class="input-group-btn">
                                        <span class="btn btn-success rounded-0">
                                            Change
                                            <input type="file" id="filePInput" style="display: none" />
                                        </span>
                                    </label>
                                    <input type="text" name='readOnly' class="form-control text-secondary" id="selectedFileName" readonly />
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <h5 class="modal-title col-md-12 fs-2 mb-3" id="profileModalLabel">
                                    Create New User
                                </h5>
                                <div class="mb-3 position-relative">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required />
                                    <div class="valid-tooltip">Looks good!</div>
                                    <div class="invalid-tooltip">
                                        Please provide a valid username.
                                    </div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="password">Password:</label>
                                    <input type="password" class="form-control" id="password" name='password' />
                                    <small class="form-text text-muted fw-light" style="font-size:10px;">
                                        <i>Leave the input blank if you don't want to update the
                                            password.</i>
                                    </small>
                                    <div class="valid-tooltip">Looks good!</div>
                                    <div class="invalid-tooltip">
                                        Please provide a valid password.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 position-relative">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="Fname" placeholder="Enter First Name" required />
                                    <div class="valid-tooltip">Looks good!</div>
                                    <div class="invalid-tooltip">
                                        Please provide a valid first name.
                                    </div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="Lname" placeholder="Enter Last Name" required />
                                    <div class="valid-tooltip">Looks good!</div>
                                    <div class="invalid-tooltip">
                                        Please provide a valid last name.
                                    </div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="Email" placeholder="Enter Email" required />
                                    <div class="valid-tooltip">Looks good!</div>
                                    <div class="invalid-tooltip">
                                        Please provide a valid email.
                                    </div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="genderUsersModal" name="Gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    <div class="valid-tooltip">Looks good!</div>
                                    <div class="invalid-tooltip">
                                        Please select a valid gender.
                                    </div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="typeModal" class="form-label">Type</label>
                                    <select class="form-select" id="typeUsersModal" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="STUDENT">Member</option>
                                        <option value="ADMIN">Admin</option>
                                    </select>
                                    <div class="valid-tooltip">Looks good!</div>
                                    <div class="invalid-tooltip">
                                        Please select a valid gender.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 position-relative">
                                    <label for="residenceAddress" class="form-label">Residence Address</label>
                                    <input type="text" class="form-control" id="residenceAddress" name="ResAdrs" placeholder="Enter Residence Address" required />
                                    <div class="valid-tooltip">Looks good!</div>
                                    <div class="invalid-tooltip">
                                        Please provide a valid residence address.
                                    </div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="officialAddress" class="form-label">Official Address</label>
                                    <input type="text" class="form-control" id="officialAddress" name="OfcAdrs" placeholder="Enter Official Address" required />
                                    <div class="valid-tooltip">Looks good!</div>
                                    <div class="invalid-tooltip">
                                        Please provide a valid official address.
                                    </div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="landlineNumber" class="form-label">Land Line No</label>
                                    <input type="text" class="form-control" id="landlineNumber" name="LandlineNo" placeholder="Enter Land Line No" required />
                                    <div class="valid-tooltip">Looks good!</div>
                                    <div class="invalid-tooltip">
                                        Please provide a valid landline number.
                                    </div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="mobileNumber" class="form-label">Mobile No</label>
                                    <input type="text" class="form-control" id="mobileNumber" name="MobileNo" placeholder="Enter Mobile No" />
                                    <div class="valid-tooltip">Looks good!</div>
                                    <div class="invalid-tooltip">
                                        Please provide a valid mobile number.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-end gap-2">
                        <button type="button" id="userSaveBtn" class="btn btn-primary">
                            SAVE
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            CLOSE
                        </button>
                    </div>

            </div>
            </form>
        </div>
    </div>
</div>