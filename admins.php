    <?php
    include './partials/header.php'
    ?>

    <style>
        main {
            max-width: 1120px;
            width: 100%;
            height: auto;
            margin: 1rem auto;
            position: relative;

        }

        section {
            position: absolute;
            display: none;
            inset: 0;
            top: 3rem;
            color: #eee;
        }

        .btncatactive {
            background: black;
            color: white;

        }

        .reservation {
            color: #333;
            text-align: center;
            font-size: 1rem;
        }

        .activ {
            display: block;
            z-index: auto;
        }




        .reservetable {
            width: 100%;
            height: 250px;
            overflow: auto;
            border: 2px solid black;
        }

        .container-4categories {
            margin-left: .4em;
        }

        .linksins {
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 500;
        }


        .active4btn {
            background-color: black;
            color: white;

        }

        /* filter reservationa rea */
        .reservations-container {
            display: flex;
            justify-content: space-between;
            text-align: start;
            background-color: whitesmoke;
            height: 100%;
            margin: 0 calc(60px + 1rem);
            margin-right: 1rem;

        }

        .filter-reserves-container {
            background-color: #222;
            padding: 1rem;
            color: #eee;

        }

        .reserve-container {
            padding: 1rem;
            width: 100%;
            height: 100%;

        }

        .filterusers {
            background-color: transparent;
            border: 1px solid grey;
            padding: .5em;
            width: 100%;
            color: whitesmoke;
        }

        .resultcontainer {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;

        }

        .userdesc {
            background: rgba(0, 0, 0, 0.);
            width: 90%;
            display: flex;
            align-items: center;
            margin: 1em;
        }


        /* 
        century links */
        .century {
            margin: 1rem auto;
            margin-left: calc(60px + 1rem);
            position: relative;
        }

        .borrowtrans {
            box-shadow: 0 3px 10px rgb(0 0 0 / 20%);
        }

        main {
            display: none;
        }

        .linkbtn {
            cursor: pointer;
        }

        .list-group-item:hover {
            background-color: #f5f5f5;
            /* Change to your desired hover color */
            cursor: pointer;
        }
    </style>

    <div class="userid" data-userid='<?php echo $UID ?>'></div>

    <header class="position-fixed start-0 top-0" style="z-index: 999;">
        <div class="d-flex flex-column flex-shrink-0 sidebar-wrap">
            <a href="/" class="text-decoration-none logo-wrap">
                <div class="icon-wrap"><i class="bi bi-mortarboard"></i></div>
                <span class="text-nowrap overflow-x-hidden">Admin Page</span>
            </a>
            <hr class="mb-0" />
            <span href="/" class="text-decoration-none logo-wrap py-4 ">
                <div class="icon-wrap" id="profile-container">
                    <img src="usersprofileimg/profiledefault.png" alt="" width="32" height="32" class="rounded-circle" />
                </div>
                <?php
                include "connection/oopconnection.php";
                $sqll = "SELECT * FROM users where user_id = $UID";
                $res = $conn->query($sqll);
                $rowww = $res->fetch_assoc();
                echo " <span class='d-flex flex-column overflow-x-hidden'><span class='opacity-50'>Welcome</span><span class='text-nowrap '>" . strtoupper($rowww['Fname']) . "</span> </span";
                $conn->close(); ?>
                >

            </span>
            <ul class="nav nav-pills flex-column mb-auto links-container">

                <li>
                    <a href="#" class="nav-link">
                        <div class="icon-wrap">
                            <i class="bi bi-clipboard2-pulse-fill"></i>
                        </div>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item" data-nav="btrans">
                    <a class="nav-link active">
                        <div class="icon-wrap">
                            <i class="bi bi-rocket-takeoff-fill"></i>
                        </div>
                        <span class='text-nowrap'> Borrow Transaction</span>
                    </a>
                </li>
                <li class="nav-item" data-nav="rtrans">
                    <a class="nav-link">
                        <div class="icon-wrap">
                            <i class="bi bi-box-fill"></i>
                        </div>
                        <span class='text-nowrap'>Return Transanction</span>
                    </a>
                </li>
                <li class="nav-item" data-nav="manageMember">
                    <a class="nav-link">
                        <div class="icon-wrap">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <span class='text-nowrap'>Manage Members</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="showPendingAprovalModal()">
                        <div class="icon-wrap">
                            <i class="bi bi-person-fill-check"></i>
                        </div>
                        <span>Approvals</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id='showCart' data-bs-toggle="offcanvas" data-bs-target="#cartCanvas">
                        <div class="icon-wrap position-relative ">
                            <i class="bi bi-cart-fill fs-4" style='color:red;'></i>
                            <span id="cartItemCount" style="font-size: 11px !important;color:white;font-weight:bold; top:47%;" class="position-absolute start-50 translate-middle ">
                            </span>
                        </div>
                        <span class="text-nowrap">Your Cart
                        </span>

                    </a>

                </li>

            </ul>
            <hr />
            <div class="dropdown">
                <a href="#" class="text-decoration-none dropdown-toggle dropdown-wrap" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="icon-wrap">
                        <i class="bi bi-person-circle" style='font-size:20px;'></i>
                    </div>
                    <strong>Your Account </strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="#" onclick="openBookModal('New Book','methods2/managebookui.php?action=insert')">Create New Book</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#" onclick="editMember('<?php echo $UID ?>')">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="logout.php?userid=<?php echo $UID ?>">Sign out</a></li>
                </ul>
            </div>
        </div>
    </header>

    <div class="century">
        <style>
            .manageMemberPage {
                position: relative;
                box-shadow: 0 3px 10px rgb(0 0 0 / 20%);
                min-height: 100vh;
                width: 100vw;
            }

            .manageMemberContents {
                padding: 1rem;
                padding-top: 1rem;
                color: black;
                background-color: #f5f5f5;
                min-height: calc(100vh - 2rem);
            }
        </style>
        <main class="manageMemberPage">
            <!-- manage books -->
            <div class="manageMemberContents">
                <h1 class="f1 m-3 mt-3 fw-bold">Manage Members</h1>

                <button type="button" class="btn btn-primary my-1" onclick="openMemberModal('Create New Member','ajax.php?action=INSERT_USER')"><i class="bi bi-plus-circle"></i> Create New Member</button>
                <table id='tableManageMembers' class="table table-striped" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>User ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Type</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Image</th>
                            <th>User ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </main>
        <main class="borrowtrans activ">
            <div class="links linksins">
                <button class="btnbt active4btn btn btn-outline-dark" data-link="sandr">Manual Entry</button>
                <button class="btnbt btn btn-outline-dark" data-link="trec">Reservations</button>
                <button class="btnbt btn btn-outline-dark" data-link="mbook">Manage Book</button>
            </div>
            <!-- manual Entry AREA -->
            <section class="search-reserve activ">


                <?php include './partials/Filterform.php'; ?>
                <!-- search field -->
                <div class="btn-group container position-relative md-outline my-3 container-4categories overflow-hidden overflow-x-auto" role="group" aria-label="Basic radio toggle button group">
                </div>
                <div id="books-collection"></div>
            </section>
            <!-- end of Manual Entry HTML -->
            <!-- Reservations area -->
            <section class="reservation">
                <div class="reservations-container">
                    <div class="filter-reserves-container">
                        <h2>Filter for book reserves</h2>
                        <form class='findcontainer'>
                            <input type="search" class="filterusers" id="filterdata" autocomplete="off" placeholder="search by id...">
                        </form>
                        <hr>
                        <p>latest user reserves..</p>
                        <div class="list-items-reservuser"></div>

                    </div>
                    <div class="resultcontainer">
                        <div class="userdesc">
                            <img class="editimg" style="margin:2em;height:100px;width:130px;border-radius:10px;" src='usersprofileimg/profiledefault.png'>
                            <h1 class="profilen">Profile</h1>

                        </div>
                        <div class="reserve-container">NO data Found YEt...</div>
                    </div>
                </div>
            </section>
            <!-- ENd of REASERVATION AREa -->
            <!-- manage books -->
            <section class="managebook">
                <button type="button" class="btn btn-primary my-3" onclick="openBookModal('New Book','methods2/managebookui.php?action=insert')"><i class="bi bi-plus-circle"></i> Create Book</button>

                <table id='tableManageBooks' class="table table-striped" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Isbn</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Image</th>
                            <th>Isbn</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>

            </section>
            <!-- manage books ui modals -->
            <style>
                .managebook,
                .reservation,
                .search-reserve {
                    position: static;
                    padding: 1rem;
                    padding-top: 5rem;
                    color: black;
                    background-color: #f5f5f5;
                    min-height: calc(100vh - 2rem);
                }

                #addnewbook {
                    display: flex;
                    margin-left: auto;
                    margin-right: 2rem;

                }

                #bookModal .img-container {
                    max-width: 100%;
                    max-height: 18em;
                    overflow: hidden;
                    text-align: center;
                    /* Optional: Center the image horizontally */
                }

                #bookModal .img-container img {
                    max-width: 100%;
                    height: auto;
                }
            </style>


        </main>

        <?php include './rendersviaphp/userCreateUpdateModal.php'; ?>

        <?php include_once 'returntrans.php'; ?>
    </div>
    <?php include './rendersviaphp/adminModals.php'; ?>


    </div>

    <!-- Admin Approval Modal -->
    <div class="modal fade" id="approvalsModal" tabindex="-1" aria-labelledby="approvalsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="approvalsModalLabel">
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

    <p class="trackcat" style="visibility:hidden;">All</p>
    <?php
    include './partials/footer.php'
    ?>

    <script>
        //image upload show once choose  
        function readURL(input, imgELId) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function(er) {
                    console.log(imgELId);
                    document.querySelector(`#${imgELId}`).src = er.target.result;
                };
                reader.readAsDataURL(input.files[0]);
                console.log('workk');
            }
        }

        //loading 
        window.addEventListener("load", () => {
            setTimeout(() => {
                const cloader = document.querySelector(".containerloader");
                cloader.className += " hide";

            }, 2000);

        });
        //manage books
        const managebook = document.querySelector(".managebook");

        // Function to fetch and display book data
        function reFetch(Route, method, callback, formData = null) {
            const options = {
                method,
            };

            if (formData) {
                options.body = formData;
            }

            fetch(Route, options)
                .then((response) => {
                    if (response.ok) {
                        return response.json(); // Parse the response as JSON
                    } else {
                        throw new Error("Request failed");
                    }
                })
                .then((data) => {
                    // Data contains the response data
                    callback(data);
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        }

        // reFetch("methods2/managebooks.php", displayManageBooks)

        function displayManageBooks(data) {
            // Destroy any existing DataTable (if applicable)
            if ($.fn.dataTable.isDataTable('#tableManageBooks')) {
                const table = $('#tableManageBooks').DataTable();
                table.clear()
                table.destroy()
                console.log(table.table);


                console.log('destroyed');
            }
            // Initialize DataTable
            const table = $('#tableManageBooks').DataTable({
                // DataTable options here
                order: [],
                columnDefs: [{
                    orderable: false,
                    targets: [0, -1] // Disables sorting for the first and last columns
                }],
                language: {
                    paginate: {
                        previous: '<i class="bi bi-chevron-left"></i>',
                        next: '<i class="bi bi-chevron-right"></i>',
                    },
                    //customize number of elements to be displayed
                    lengthMenu: 'Show <select class="form-control input-sm">' +
                        '<option value="10">10</option>' +
                        '<option value="20">20</option>' +
                        '<option value="30">30</option>' +
                        '<option value="40">40</option>' +
                        '<option value="50">50</option>' +
                        '<option value="-1">All</option>' +
                        "</select> Entries",
                },
            });
            // Format data (assuming data is an array of objects)
            const formattedData = data.map(item => [
                `<img class='img-fluid img-thumbnail' style='height:100px;width:100px;' src='./${item.ImageURL}' alt='imgurl:${item.ImageURL}'>`,
                item.ISBN,
                item.Title,
                item.Author,
                // ... other columns as needed
                `<div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="manageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdown">
                        <li><a class="dropdown-item" href="#" onclick="editBook('${item.ISBN}')">Edit</a></li>
                        <li><a class="dropdown-item" href="#" onclick="deleteBook('${item.ISBN}')">Delete</a></li>
                    </ul>
                </div>`
            ]);

            // Populate the DataTable with formatted data
            table.rows.add(formattedData).draw();


        }

        function displayManageMember(data) {
            // Destroy any existing DataTable (if applicable)
            if ($.fn.dataTable.isDataTable('#tableManageMembers')) {
                const table = $('#tableManageMembers').DataTable();
                table.clear()
                table.destroy()
                console.log(table.table);


                console.log('destroyed');
            }
            // Initialize DataTable
            const table = $('#tableManageMembers').DataTable({
                // DataTable options here
                order: [],
                columnDefs: [{
                    orderable: false,
                    targets: [0, -1] // Disables sorting for the first and last columns
                }],
                language: {
                    paginate: {
                        previous: '<i class="bi bi-chevron-left"></i>',
                        next: '<i class="bi bi-chevron-right"></i>',
                    },
                    //customize number of elements to be displayed
                    lengthMenu: 'Show <select class="form-control input-sm">' +
                        '<option value="10">10</option>' +
                        '<option value="20">20</option>' +
                        '<option value="30">30</option>' +
                        '<option value="40">40</option>' +
                        '<option value="50">50</option>' +
                        '<option value="-1">All</option>' +
                        "</select> Entries",
                },
            });
            // Format data (assuming data is an array of objects)
            const formattedData = data.map(item => [
                `<img class='img-fluid img-thumbnail' style='height:100px;width:100px;' src='${item.profileImage}' alt='imgurl:${item.profileImage}'>`,
                item.user_id,
                item.Fname + ' ' + item.Lname,
                item.Email,
                item.Gender,
                item.type,

                // ... other columns as needed
                `<div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="manageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="manageDropdown">
                        <li><a class="dropdown-item" href="#" onclick="editMember('${item.user_id}')">Edit</a></li>
                        <li><a class="dropdown-item" href="#" onclick="deleteMember('${item.user_id}')">Delete</a></li>
                    </ul>
                </div>`
            ]);

            // Populate the DataTable with formatted data
            table.rows.add(formattedData).draw();


        }

        //function xttprequest 
        function xttpreq(phpfilename, send, output) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", phpfilename, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status == 200) {
                    const res = xhr.responseText;
                    if (output) {
                        output.innerHTML = res;

                    } else {
                        console.log(res);
                    }

                    if (output == "alert") {
                        showAlert2(true, res)
                    }

                } else {
                    console.log("failed");
                }
            }

            xhr.send(send);

        }
        //membership approval
        const approvaltBody = document.querySelector("#approvalsModal tbody");
        const approvalAlert = document.querySelector("#approvalsModal .approvalMessage");

        function approve(e) {
            const id = e.currentTarget.dataset.userid;
            let userid = `useridapprove=${id}`;
            xttpreq("methods2/approverejectreg.php", userid, "alert");
            showPendingAprovalModal()
        }

        function deny(e) {
            const id = e.currentTarget.dataset.userid;
            let userid = `useriddeny=${id}`;
            xttpreq("methods2/approverejectreg.php", userid, "alert");
            showPendingAprovalModal()
        }
        //show and close modal events
        function showPendingAprovalModal() {
            // approvalBody
            console.log('asdfsdaf');
            approvaltBody.innerHTML = '';
            reFetch("methods2/shownewregs.php", "GET", ({
                data,
                message
            }) => {
                console.log(data);
                if (data == undefined) {
                    approvalAlert.innerHTML = `  
                    <div class="alert alert-info">
                    <strong>${message}</strong>
                        </div>
                           
                        `;
                } else {
                    data.forEach(user => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td>${user.Fname} ${user.Lname}</td>
                    <td>${user.OfcAdrs}</td>
                    <td>${user.Email}</td>
                    <td>${user.MobileNo}</td>
                    <td><button class="approvebtn btn btn-success" data-userid="${user.user_id}" onclick="approve(event)">Approve</button>
                      <button class="denybtn btn btn-danger"  data-userid="${user.user_id}" onclick="deny(event)">Deny</button></td>

                `;
                        approvaltBody.append(row);
                    })
                }
                $("#approvalsModal").modal("show");
            });
        }


        //variable declarations
        const links = document.querySelector(".links");
        const borrowtrans = document.querySelector(".borrowtrans");
        const btnbt = document.querySelectorAll(".btnbt");
        const sections = document.querySelectorAll("section");
        const searchandreserve = document.querySelector(".search-reserve");
        const trec = document.querySelector(".reservation");
        const cartcontainer = document.querySelector(".e-cart");
        const reservecontainer = document.querySelector(".reserve-container");
        const userid = document.querySelector(".userid").dataset.userid;
        const reservusercontainer = document.querySelector(".list-items-reservuser");
        const profilen = document.querySelector(".profilen");
        const findvalue = document.querySelector("#filterdata");
        const formfind = document.querySelector(".findcontainer");
        const editimg = document.querySelector(".editimg");
        const linkscontainer = document.querySelector(".links-container");
        const navItems = linkscontainer.querySelectorAll(".nav-item");
        const returntrans = document.querySelector(".returntrans");
        const manageMemberPage = document.querySelector(".manageMemberPage");

        const mains = document.querySelectorAll("main");
        console.log(userid);

        //checks if the borrowed book is  overdue 
        function updateRecordStatus() {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "methods/updaterecords.php", true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    const res = xhr.responseText;

                } else {
                    console.log("failed");
                }
            }
            xhr.send();
        }
        updateRecordStatus();

        //navigations btrans and rtrans
        navItems.forEach(item => {
            item.addEventListener("click", onwhatlink);

        });

        function onwhatlink(e) {
            e.stopPropagation();
            console.log(e.currentTarget.dataset.nav);
            if (e.currentTarget.dataset.nav) {
                const btnlinks = linkscontainer.querySelectorAll(".nav-link");
                console.log(btnlinks);
                if (e.currentTarget.firstElementChild.classList.contains("active")) return

                btnlinks.forEach(e => {
                    e.classList.remove("active");
                });
                mains.forEach(e => {
                    e.classList.remove("activ");
                })
                e.currentTarget.firstElementChild.classList.add("active");
                switch (e.currentTarget.dataset.nav) {
                    case "btrans":
                        showallcollection();
                        showcategories();
                        borrowtrans.classList.add("activ");
                        break;
                    case "rtrans":
                        returntrans.classList.add("activ");
                        updateRecordStatus();
                        showuserborrow();
                        break;
                    case "manageMember":
                        manageMemberPage.classList.add("activ");
                        reFetch("ajax.php?action=GET_ALL_USER", "GET", displayManageMember)

                        break;
                    default:
                        showallcollection();
                        showcategories();
                        borrowtrans.classList.add("activ");
                        break;
                }
            }
        }

        //accept reservations of user..
        function lendonreservation(e) {
            const targetid = e.currentTarget.dataset.lenduserid;


            const xhr = new XMLHttpRequest();
            xhr.open("POST", "methods/lendreserve.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status == 200) {
                    const res = xhr.responseText;
                    reservecontainer.innerHTML = res;
                    const bstat = document.querySelector(".resmessage");
                    alert(bstat.textContent);


                } else {
                    console.log("failed");
                }
            }
            xhr.send(`userid=${targetid}`);

        }

        //show the user that have reservations updating every 500ms hahahaha!
        function showlatestreserves() {

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "methods/getuserhavereserves.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status == 200) {
                    const res = xhr.responseText;
                    reservusercontainer.innerHTML = res;

                } else {
                    console.log("failed");
                }
            }
            xhr.send(`table=reserve_record&getfield=date_reserve`);
        }
        showlatestreserves();


        //search in reservation facility for finding users reservations
        formfind.addEventListener('submit', srchuserreserv);
        findvalue.addEventListener('keyup', searchus);

        //key event function for searching
        function searchus(eve) {
            if (findvalue.value.length == '') {
                showlatestreserves();

            } else {
                srchuserreserv(e)
            }
        }
        //submit event function for searching
        function srchuserreserv(e) {

            e.preventDefault();
            seachval = findvalue.value;

            if (seachval.length > 0) {

                const xhr = new XMLHttpRequest();
                xhr.open("POST", "methods/searchuserforResandtrans.php", true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status == 200) {
                        const res = xhr.responseText;
                        reservusercontainer.innerHTML = res;
                    } else {
                        console.log("failed");
                    }
                }
                xhr.send(`searchthisuser=${seachval}&table=reserve_record`);
            } else {

            }
        }
        //making click events for user list in reservations and show specific user reservations
        function uniquserreserve(e) {
            const targetedid = e.currentTarget.dataset.userid;
            const targetname = e.currentTarget.innerText;
            const imgtarget = e.currentTarget.children[0].dataset.imgsrc;
            console.log(targetedid);
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "methods/filterUserReserve.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status == 200) {
                    const res = xhr.responseText;
                    reservecontainer.innerHTML = res;
                    profilen.innerHTML = targetname;
                    editimg.src = imgtarget + `?${Math.floor(Math.random() * 1000)}`;
                } else {
                    console.log("failed");
                }
            }
            xhr.send(`userid=${targetedid}`);
        }
        // removing multiple in user reserve items
        function delselectedinreservation(e) {
            const checkbox = Array.from(document.querySelectorAll(".selectitemreserve"));
            console.log(checkbox);
            console.log(checkbox.length);
            let id = parseInt(e.currentTarget.dataset.ressuserid);
            //get all checked items put it in array

            let newarray = checkbox.reduce((total, item) => {
                if (item.checked) {
                    total.push((item.value));
                }
                return total;
            }, [])
            if (newarray.length > 0) {
                console.log(checkbox.length + "true");
                console.log(newarray);
                const params = `delitemfromreserve=${JSON.stringify(newarray)}&userid=${id}`;
                const xhrs = new XMLHttpRequest();

                xhrs.open("POST", "methods/deletemultiple.php", true);

                xhrs.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                xhrs.onload = function() {
                    if (xhrs.status == 200) {
                        const res = xhrs.responseText;
                        alert("System Message:" + newarray.length + "book/s successfully removed");
                        reservecontainer.innerHTML = res;
                        console.log(res);
                        const checkresitems = document.querySelector(".datas");
                    } else {
                        console.log("failed");
                    }
                }
                xhrs.send(params);
            }
            showlatestreserves()
        }
        //hide and show btn
        const showCartBtn = document.querySelector("#showCart");
        // remove the focus on offcanvas cart it a must 
        bootstrap.Offcanvas.prototype._initializeFocusTrap = function() {
            return {
                activate: function() {},
                deactivate: function() {}
            }
        };

        document.addEventListener("DOMContentLoaded", () => {
            showCartBtn.addEventListener("click", getbookFromCartReq);
        })
        //click outside other events function for closing of modals
        window.addEventListener('click', () => {
            droplistcontainer.style.display = "none";
        })
        //links of two facilities manual entry and reservations
        borrowtrans.addEventListener("click", el => {
            console.log(el.target.dataset.link);

            if (el.target.dataset.link) {
                sections.forEach(e => {
                    e.classList.remove("activ");
                });
                btnbt.forEach(e => {
                    e.classList.remove("active4btn");
                })

                if (el.target.dataset.link == "sandr") {
                    console.log(el.target.dataset.link);
                    showallcollection();
                    showcategories();
                    searchandreserve.classList.add("activ");
                    el.target.classList.add("active4btn");
                } else if (el.target.dataset.link == "trec") {
                    trec.classList.add("activ");
                    el.target.classList.add("active4btn");
                    showlatestreserves();
                } else if (el.target.dataset.link == "mbook") {
                    managebook.classList.add("activ");
                    el.target.classList.add("active4btn");
                    reFetch("methods2/managebooks.php", "GET", displayManageBooks)
                }
            }
        });
    </script>
    </body>

    </html>