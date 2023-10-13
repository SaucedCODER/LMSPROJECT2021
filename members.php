<?php
include './partials/header.php'
?>
<style>
    .transaction-record {
        background-color: white;

    }

    .century {
        margin: 1rem;
        margin-left: calc(60px + 1rem);
        width: calc(100% - calc(60px + 2rem));
    }

    section {
        margin: 0 auto;
        display: none;
        position: relative;
        color: black;
        min-height: calc(100vh - 2rem);
        height: 100%;
        /* box-shadow: 0 3px 10px rgb(0 0 0 / 20%); */

    }


    .linkbtn {
        cursor: pointer;
    }

    .list-group-item:hover {
        background-color: #f5f5f5;
        /* Change to your desired hover color */
        cursor: pointer;
    }

    .activ {
        display: block;
        z-index: auto;
    }
</style>


<div class="userid" data-userid='<?php echo $UID ?>'></div>



<header class="position-fixed start-0 top-0" style="z-index: 999;">
    <div class="d-flex flex-column flex-shrink-0 sidebar-wrap">
        <a href="/" class="text-decoration-none logo-wrap">
            <div class="icon-wrap"><i class="bi bi-mortarboard-fill"></i></div>
            <span class="text-nowrap overflow-x-hidden">Member Page</span>
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
            <li class="nav-item" data-nav="sandr">
                <a class="nav-link active">
                    <div class="icon-wrap">
                        <i class="bi bi-journal-bookmark-fill"></i>
                    </div>
                    <span class='text-nowrap'>Search and Reserve</span>
                </a>
            </li>
            <li class="nav-item" data-nav="trec">
                <a class="nav-link">
                    <div class="icon-wrap">
                        <i class="bi bi-database-fill"></i>
                    </div>
                    <span class='text-nowrap'>Transaction record</span>
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
                <!-- <li><a class="dropdown-item" href="#" onclick="openBookModal('New Book','methods2/managebookui.php?action=insert')">Create New Book</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li> -->
                <li><a class="dropdown-item" href="#" onclick="editMember('<?php echo $UID ?>')">Profile</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="logout.php?userid=<?php echo $UID ?>">Sign out</a></li>
            </ul>
        </div>
    </div>
</header>


<main class="century">
    <section class="search-reserve activ">
        <?php include './partials/Filterform.php'; ?>
        <!-- search field -->
        <div class="btn-group container position-relative md-outline my-3 container-4categories overflow-hidden overflow-x-auto" role="group" aria-label="Basic radio toggle button group">
        </div>
        <div id="books-collection"></div>
    </section>

    <!-- css loader -->
    <style>
        .loaderss {
            border: 5px solid #eee;
            border-radius: 50%;
            border-top: 5px solid red;
            width: 30px;
            height: 30px;
            -webkit-animation: spin 1s linear infinite;
            /* Safari */
            animation: spin 1s linear infinite;
            margin-top: 5em;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <!-- the last call  -->
    <section class="transaction-record">
        <div class="bg-dark text-light text-center py-5" style='background-image: url("./systemImg/5-dots.webp");'>
            <h1>Transaction Records</h1>
        </div>

        <div class="container mt-4">
            <ul class="nav nav-tabs" id="transactionTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="unsettled-tab" data-toggletab='#unsettled' data-bs-toggle="tab" href="#unsettledTab" role="tab" aria-controls="unsettledTab" aria-selected="true">Unsettled Transactions</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="history-tab" data-bs-toggle="tab" data-toggletab='#history' href="#historyTab" role="tab" aria-controls="historyTab" aria-selected="false">Transaction History</a>
                </li>

            </ul>
            <div class="tab-content" id="transactionTabsContent">
                <!-- Unsettled Transactions Tab -->
                <div class="tab-pane fade show active transaction-report-container p-3" id="unsettledTab" role="tabpanel" aria-labelledby="unsettled-tab">

                </div>
                <!-- Transaction History Tab -->
                <div class="tab-pane fade p-3" id="historyTab" role="tabpanel" aria-labelledby="history-tab">
                    <table id='transactionHistoryUser' class='table table-striped' style='width:100%'>
                        <thead>
                            <th>Transaction No.</th>
                            <th>ISBN</th>
                            <th>Admin Name</th>
                            <th>Transaction Date</th>
                            <th>Transaction Type</th>
                            <th>Status</th>

                        </thead>
                        <tbody id='transactionHistoryContainer'>

                        </tbody>
                    </table>
                </div>
            </div>
    </section>

</main>
<!-- style for modal profile update -->
<style>
    #searchfortranshis {
        padding: .5em 1em;
        font-size: 15px;
        background: whitesmoke;
        color: #222;
        margin: 1rem;
        width: 100%;
        border: 1px solid grey;
    }
</style>



<p class="trackcat" style="visibility:hidden;">All</p>


<?php include './rendersviaphp/userCreateUpdateModal.php'; ?>

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
        }
    }

    //class="userid"
    const userid = document.querySelector(".userid").dataset.userid;
    //load window
    window.addEventListener("load", () => {
        setTimeout(() => {
            const cloader = document.querySelector(".containerloader");
            cloader.classList.add("d-none");

        }, 2000);

    });
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

    //transaction records
    const transTabContainer = document.querySelector("#transactionTabs");
    const transactionreport = document.querySelector(".transaction-report");
    const transactionhistory = document.querySelector(".transaction-history");
    const transactionrecordcontainer = document.querySelector("#unsettledTab");
    const transactionhisontainer = document.querySelector("#historyTab");
    const transactionlinkbtn = document.querySelectorAll(".transaction-record button");


    transTabContainer.addEventListener("click", (e) => {
        console.log(e.target);
        if (e.target.dataset.toggletab) {
            const btndata = e.target.dataset.toggletab;
            console.log(btndata, e.target.classList.contains("active"));

            if (btndata == "#unsettled") {
                showalltranrecord();
            }
            if (btndata == "#history") {
                console.log('history');

                showhistoryjpeg();
            }
        }
    })

    //show transaction history
    async function showhistoryjpeg() {
        console.log('itworked');
        const res = await fetch(`methods2/showtranshistory.php?userid=${userid}`)
        console.log(res);
        const data = await res.json();
        let tab = '';
        data.forEach(e => {
            tab += `
            <tr>
            <td>${e.TransactionNo}</td>
            <td>${e.ISBN}</td>
            <td>${e.AdminName}</td>
            <td>${e.TransactionDate}</td>
            <td>${e.TransactionType}</td>
            <td>${e.Status}</td>
            </tr>
            `;
        })
        document.querySelector('#transactionHistoryContainer').innerHTML = tab;
        $("#transactionHistoryUser").DataTable({
            "bDestroy": true,
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
        })
    }
    //search transaction history

    // function stranshist(e) {
    //     e.preventDefault();
    //     const searchvalth = document.querySelector("#searchhisform input");
    //     let findthis = searchvalth.value;
    //     xttpreq("methods2/showtranshistory.php", `find=${findthis}`, transactionhisontainer)

    // }
    //Member transaction reports
    function showalltranrecord() {

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "methods/showtransactionrecords.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status == 200) {
                const res = xhr.responseText;
                transactionrecordcontainer.innerHTML = res;

            } else {
                console.log("failed");
            }
        }
        xhr.send(`userid=${userid}`);
    }
    showalltranrecord();

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
                    console.log(res, output);
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
    //variable declaration

    const links = document.querySelector(".links-container");
    const sections = document.querySelectorAll("section");
    const searchandreserve = document.querySelector(".search-reserve");
    const trec = document.querySelector(".transaction-record");
    const cartcontainer = document.querySelector(".e-cart");

    console.log(userid);


    //reserve sellected item btn 
    function reserveitems() {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "methods/reservebookuser.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {

            if (xhr.status == 200) {
                const res = xhr.responseText;
                cartcontainer.innerHTML = res;
                alert(res);
            }
        }
        xhr.send(`userid=${userid}`);
    }

    //click outside other events function for closing of modals
    // window.addEventListener('click', () => {
    //     droplistcontainer.style.display = "none";
    // })


    //navigations reserve and transaction records 
    const linkscontainer = document.querySelector(".links-container");
    const navItems = linkscontainer.querySelectorAll(".nav-item");
    const sectionZ = document.querySelectorAll(".century section");
    navItems.forEach(item => {
        item.addEventListener("click", onwhatlink);

    });

    function onwhatlink(e) {
        e.stopPropagation();
        console.log(e.currentTarget);
        if (e.currentTarget.dataset.nav) {
            const btnlinks = linkscontainer.querySelectorAll("header .nav-link");
            console.log(btnlinks);
            if (e.currentTarget.firstElementChild.classList.contains("active")) return

            btnlinks.forEach(e => {
                e.classList.remove("active");
            });
            sectionZ.forEach(e => {
                e.classList.remove("activ");
            })
            e.currentTarget.firstElementChild.classList.add("active");
            switch (e.currentTarget.dataset.nav) {
                case "sandr":
                    showallcollection();
                    showcategories();
                    searchandreserve.classList.add("activ");
                    break;
                case "trec":
                    trec.classList.add("activ");
                    showalltranrecord();
                    break;
            }
        }
    }

    //removing selected items in cart function
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
</script>
</body>

</html>