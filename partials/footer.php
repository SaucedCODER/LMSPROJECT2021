<?php
// Access the stored username
$isAdminMem = ($_SESSION['userRole'] == 'admins.php' || $_SESSION['userRole'] == 'members.php');
?>
<div class="offcanvas offcanvas-end e-cart" style='z-index:3000' id="cartCanvas" aria-labelledby="cartCanvasLabel">
</div>

<!-- Modal Profile-->
<!-- <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg bg-body-secondary">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row row-cols-md-2">
                    <div class="col-md-12 col-lg-5 p-5 d-flex justify-content-start align-items-center flex-column">
                        <img src="usersprofileimg/profile190001.jpg?1427093655" class="profile-image mb-5" alt="Profile Image" />
                        <div class="input-group btn-outline-info">
                            <label class="input-group-btn">
                                <span class="btn btn-success rounded-0">
                                    Change
                                    <input type="file" id="filePInput" style="display: none" />
                                </span>
                            </label>
                            <input type="text" class="form-control text-secondary" id="selectedFileName" readonly />
                        </div>
                    </div>

                    <form class="col-md-12 col-lg-7 row row-sm-1 row-cols-md-2">
                        <h5 class="modal-title col-md-12 fs-2 my-3" id="profileModalLabel">
                            My Profile
                        </h5>
                        <div class="form-group">
                            <label for="firstName">First Name:</label>
                            <input type="text" class="form-control" id="firstName" value="ZEUS MIGUEL" />
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name:</label>
                            <input type="text" class="form-control" id="lastName" value="ORILLA" />
                        </div>
                        <div class="form-group">
                            <label for="idNumber">ID No:</label>
                            <input type="text" class="form-control" id="idNumber" value="190001" />
                        </div>
                        <div class="form-group">
                            <label for="residenceAddress">Residence Address:</label>
                            <input type="text" class="form-control" id="residenceAddress" value="asdfsa" />
                        </div>
                        <div class="form-group">
                            <label for="officialAddress">Official Address:</label>
                            <input type="text" class="form-control" id="officialAddress" value="adsf" />
                        </div>
                        <div class="form-group">
                            <label for="landlineNumber">Land Line No:</label>
                            <input type="text" class="form-control" id="landlineNumber" value="0" />
                        </div>
                        <div class="form-group">
                            <label for="mobileNumber">Mobile No:</label>
                            <input type="text" class="form-control" id="mobileNumber" value="2147483647" />
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <input type="text" class="form-control" id="gender" value="male" />
                        </div>
                    </form>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button class="btn btn-primary" data-userid="190001" onclick="editmyacc(event)">
                    Update
                </button>
            </div>
        </div>
    </div>
</div> -->

<!-- Admin Approval Modal -->
<div class="modal fade" id="approvalsModal" tabindex="-1" aria-labelledby="approvalsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approvalsModalLabel">
                    Admin Approvals
                </h5>
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <!-- Check if the list is empty and display a message -->
                <div class="approvalMessage"></div>
                <!-- Display a table of new user registrations if not empty -->
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Address</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example data, replace with actual user registration data -->
                        <!-- Add user rows here -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <!-- Close button -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- jquery cdn Link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- bootstrap js cdn Link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<!--SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.28/dist/sweetalert2.all.min.js" integrity="sha256-Cci6HROOxRjlhukr+AVya7ZcZnNZkLzvB7ccH/5aDic=" crossorigin="anonymous"></script>
<!-- Data Table JS -->

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- Timepicker JS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- input mask JS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
<!-- dropzone file upload JS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<?php if ($isAdminMem) {
    echo '
        <script src="./js/jsforloader.js" defer></script>
        <script src="./js/jsCartFunc.js" defer></script>
        <script src="./js/jsDataTables.js" defer></script>
        <script src="./js/jsUtils.js" defer></script>
        <script src="./js/jsCRUDBooks.js" defer></script>
        <script src="./js/jsCRUDUsers.js" defer></script>
        ';
} else {
    echo '  <script src="./js/showalertlogin.js" defer></script>';
} ?>

<script src="./js/viewbookmodal.js" defer></script>
<script src="./js/categoriesbutton.js" defer></script>
<script src="./js/search.js" defer></script>
<script src="./js/showcollection.js" defer></script>
<script src="./js/jsaddtocart.js" defer></script>