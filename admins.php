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
            background: whitesmoke;
            color: white;
            display: none;
            inset: 0;
            top: 3rem;
        }

        .btncatactive {
            background: black;
            color: white;

        }

        .reservation {
            background-color: whitesmoke;
            color: #333;
            text-align: center;
            font-size: 1rem;
        }

        .activ {
            display: block;
            z-index: auto;
        }


        .filtercontainer {
            display: flex;
            justify-content: center;
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

        #showCart {
            margin-left: auto;
            display: inline-block;
        }

        .active4btn {
            background-color: #555555;
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
            background: #eee;

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
            <a href="/" class="text-decoration-none logo-wrap py-4 ">
                <div class="icon-wrap">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle" />
                </div>
                <?php
                include "connection/oopconnection.php";
                $sqll = "SELECT * FROM users where user_id = $UID";
                $res = $conn->query($sqll);
                $rowww = $res->fetch_assoc();
                echo " <span class='d-flex flex-column overflow-x-hidden'><span class='opacity-50'>Welcome</span><span class='text-nowrap '>" . strtoupper($rowww['Fname']) . "</span> </span";
                $conn->close(); ?>
                >

            </a>
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
                            <i class="bi bi-cart-plus"></i>
                        </div>
                        <span class='text-nowrap'> Borrow Transaction</span>
                    </a>
                </li>
                <li class="nav-item" data-nav="rtrans">
                    <a class="nav-link">
                        <div class="icon-wrap">
                            <i class="bi bi-calendar-fill"></i>
                        </div>
                        <span class='text-nowrap'>Return Transanction</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link reg">
                        <div class="icon-wrap">
                            <i class="bi bi-person-fill-check"></i>
                        </div>
                        <span>Approvals</span>
                    </a>
                </li>
            </ul>
            <hr />
            <div class="dropdown">
                <a href="#" class="text-decoration-none dropdown-toggle dropdown-wrap" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="icon-wrap">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <strong>Your Account </strong>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="#" onclick="openBookModal('New Book','methods2/managebookui.php?action=insert')">Create New Book</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="logout.php?userid=<?php echo $UID ?>">Sign out</a></li>
                </ul>
            </div>
        </div>
    </header>



    <div class="century">
        <main class="borrowtrans activ">
            <div class="links linksins">
                <button class="btnbt active4btn" data-link="sandr">Manual Entry</button>
                <button class="btnbt" data-link="trec">Reservations</button>
                <button class="btnbt" data-link="mbook">Manage Book</button>
            </div>
            <!-- manual Entry AREA -->
            <section class="search-reserve activ">

                <!-- Shopping cart icon to open the off-canvas cart -->
                <button type="button" id='showCart' class="btn btn-primary position-relative" data-bs-toggle="offcanvas" data-bs-target="#cartCanvas">
                    <i class="bi bi-cart-fill"></i> View Cart
                    <span id="cartItemCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </button>

                <div class="offcanvas offcanvas-end e-cart" id="cartCanvas" aria-labelledby="cartCanvasLabel">
                </div>
                <h1 style="padding:1em 0em;padding-left:2em; margin:0;color:black;">BOOK COLLECTION</h1>
                <div class="filtercontainer">
                    <?php include './partials/Filterform.php'; ?>
                    <!-- search field -->
                </div>
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
                            <img class="editimg" style="margin:2em;height:100px;width:130px;border-radius:10px;" src='usersprofileimg/profiledefault.jpg'>
                            <h1 class="profilen">Profile</h1>

                        </div>
                        <div class="reserve-container">NO data Found YEt...</div>


                    </div>

                </div>
            </section>
            <!-- ENd of REASERVATION AREa -->
            <!-- manage books -->
            <section class="managebook">
                <button type="button" class="btn btn-primary" onclick="openBookModal('New Book','methods2/managebookui.php?action=insert')"><i class="bi bi-plus-circle"></i> Create Book</button>
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
                    color: #333;
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
            <!-- add book modal -->

            <!-- Modal Create/update Book-->
            <div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addBookModalLabel">Create BOOK</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addnewbk" class="needs-validation" novalidate>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="imgbbookcontainer">
                                                <div class="img-container">
                                                    <img id="chimg" src="booksimg/bookdefault.png" alt="book">
                                                </div>
                                                <input id="filebdata" type="file" name="file" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="mb-3 position-relative">
                                                <label for="isbn" class="form-label">ISBN</label>
                                                <input type="text" class="form-control" id="isbn" name="isbn" placeholder="Enter ISBN" required>
                                                <div class="valid-tooltip">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-tooltip">
                                                    Please provide a valid ISBN.
                                                </div>
                                            </div>
                                            <div class="mb-3 position-relative">
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required>
                                                <div class="valid-tooltip">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-tooltip">
                                                    Please provide a valid title.
                                                </div>
                                            </div>
                                            <div class="mb-3 position-relative">
                                                <label for="author" class="form-label">Author</label>
                                                <input type="text" class="form-control" id="author" name="author" placeholder="Enter Author" required>
                                                <div class="valid-tooltip">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-tooltip">
                                                    Please provide a valid author name.
                                                </div>
                                            </div>
                                            <div class="mb-3 position-relative">
                                                <label for="category" class="form-label">Category</label>
                                                <input type="text" class="form-control" id="category" name="category" placeholder="Enter Category" required>
                                                <div class="valid-tooltip">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-tooltip">
                                                    Please provide a valid category.
                                                </div>
                                            </div>
                                            <div class="mb-3 ">
                                                <label for="bookprice" class="form-label">Book Price (in Pesos)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₱</span>
                                                    <input type="text" class="form-control" id="bookprice" name="bookprice" placeholder="Enter Book Price" required>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <!-- Add validation for other input fields -->
                                            <div class="mb-3 ">
                                                <label for="yearpublished" class="form-label">Year Published</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                                    <input type="text" class="form-control" id="yearpublished" name="yearpublished" data-toggle="datepicker" placeholder="Select Year Published" required>
                                                </div>

                                            </div>
                                            <div class="mb-3 position-relative">
                                                <label for="publisher" class="form-label">Publisher</label>
                                                <input type="text" class="form-control" id="publisher" name="publisher" placeholder="Enter Publisher" required>
                                                <div class="valid-tooltip">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-tooltip">
                                                    Please provide a valid publisher.
                                                </div>
                                            </div>
                                            <div class="mb-3 position-relative">
                                                <label for="quantity" class="form-label">Quantity</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity" required>
                                                <div class="valid-tooltip">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-tooltip">
                                                    Please provide a valid quantity.
                                                </div>
                                            </div>
                                            <div class="mb-3 position-relative">
                                                <label for="abstract" class="form-label">Abstract</label>
                                                <textarea class="form-control" id="abstract" name="abstract" placeholder="Enter Abstract" required></textarea>
                                                <div class="valid-tooltip">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-tooltip">
                                                    Please provide a valid abstract.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="bookSaveBtn" class="btn btn-primary">SAVE</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>


        </main>
        <!-- modal for new registrations!! -->
        <style>
            .modalacccontainer {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.8);
                display: grid;
                place-items: center;
                transform: scale(0);
                transition: transform 100ms;
                z-index: 1000;
            }

            .modalregistrationbody {
                position: relative;
                width: 85%;
                height: 75%;

                background-color: #eee;
                color: grey;
                padding: 1em;
                border-radius: 10px;
            }

            .showmodalreg {
                transform: scale(1);

            }

            .tabcon {
                width: 100%;
                height: 80%;
                overflow: auto;

            }
        </style>

        <div class="modalacccontainer">
            <div class="modalregistrationbody">
                <div class="closebtn">&times</div>
                <h3>Pending registration list..</h3>
                <div class="tabcon">
                </div>
            </div>

        </div>

        <!-- end of modal for registrations -->
        <?php include 'returntrans.php'; ?>

    </div>

    <p class="trackcat" style="visibility:hidden;">All</p>
    <?php
    include './partials/footer.php'
    ?>

    <script>
        //image upload show once choose  
        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function(er) {
                    document.querySelector("#chimg").src = er.target.result;
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
                    console.error("Error:", error.message);
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
                        alert(res);
                    }

                } else {
                    console.log("failed");
                }
            }

            xhr.send(send);

        }
        //membership approval
        const tabcon = document.querySelector(".tabcon");

        function approve(e) {
            const id = e.currentTarget.dataset.userid;
            let userid = `useridapprove=${id}`;
            xttpreq("methods2/approverejectreg.php", userid, "alert");

            setTimeout(() => {
                xttpreq("methods2/shownewregs.php", "", tabcon);
            }, 200);
        }

        function deny(e) {
            const id = e.currentTarget.dataset.userid;
            let userid = `useriddeny=${id}`;
            xttpreq("methods2/approverejectreg.php", userid, "alert");
            setTimeout(() => {
                xttpreq("methods2/shownewregs.php", "", tabcon);
            }, 200);

        }
        //show and close modal events
        const reg = document.querySelector(".reg");
        const closebtn = document.querySelector(".closebtn");

        const modalacccontainer = document.querySelector(".modalacccontainer");

        reg.addEventListener("click", () => {
            modalacccontainer.classList.add("showmodalreg");
            xttpreq("methods2/shownewregs.php", "", tabcon);
        })
        closebtn.addEventListener("click", () => {
            modalacccontainer.classList.remove("showmodalreg");
        })
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