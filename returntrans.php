<style>
    .returntrans {
        height: 100%;
    }

    #option {
        margin-right: auto;
        height: 60%;
        font-size: 15px;
        padding: 3px;
    }

    .optionsreturn {
        display: flex;
        align-items: center;

    }

    .returntrans {
        min-height: 100vh;
        margin: 0;
    }

    /* //receipt return transc */
    .recieptreturn {
        border: 2px solid #222;
        width: 80vw;
        height: 90vh;
        display: flex;
        flex-direction: column;
        padding: 5em;
        box-sizing: border-box;


    }

    .recieptreturn table {
        margin-top: .5em;
        border-collapse: collapse;
    }

    .recieptreturn td,
    th {
        padding: 1em;
        font-size: 15px;

    }

    .modalasi {
        box-sizing: border-box;
        padding: 1em;
        width: 100%;
        height: 100%;
        overflow: auto;
    }

    .modalasi table {
        margin-bottom: 3em;
    }

    .recieptreturn th,
    .modalasi th {
        background-color: #222;
        color: #eee;
    }

    .modalasi td {
        font-size: 14px;
    }


    .user-id,
    .user-name {
        font-size: 12px;
    }

    .user-name {
        color: grey;
    }

    .dots {
        height: 7px;
        width: 7px;
        background-color: #eee;
        display: flex;
        border-radius: 50%;
        margin-left: 7px;
        margin-right: 7px;
    }

    #UUserSearchInput,
    #THistorySearchInput {
        border: none;
        outline: none;
        padding-left: 32px;
    }

    #UUserSearchInput:focus,
    #THistorySearchInput:focus {
        border: none;
        box-shadow: none;
    }

    .search-icon {
        top: 6px;
        left: 10px;
    }

    .filter-icon {
        top: 6px;
        right: 10px;
    }

    .processOverlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.1);
        /* Semi-transparent black overlay */
        z-index: 9999;
        /* Ensure the overlay is above other elements */
    }
</style>

<main class="returntrans">

    <div class="container-xxl mt-2">
        <div class="row g-2">
            <div class="col-md-4">
                <!-- Search input for filtering users -->
                <div class="mb-2">
                    <div class="position-relative">
                        <span class="position-absolute search-icon"><i class="bi bi-search"></i></span>
                        <input class="form-control" id="UUserSearchInput" placeholder="Search users" />
                        <!-- <span class="position-absolute filter-icon">
                  <span>Filters <i class="bi bi-chevron-down"></i></span>
              </span> -->
                    </div>
                </div>
                <ul class="list-group mb-2 UUserList listwhoborrow">
                    <!-- List of users with unsettled transactions -->
                </ul>
            </div>

            <!-- Modified HTML structure -->
            <div class="col-md-8">
                <div class="row g-2">
                    <div class="col-md-5">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img width="150" src="usersprofileimg/profiledefault.png" class="imgProfile user-profile-img img-fluid rounded-circle border-1 border-primary-subtle" />
                                    <div class="mt-3">
                                        <h4 data-profiler id="zUsername">UserName/Student ID</h4>
                                        <p class="text-muted font-size-sm" data-profiler id="zUserId">ID:#00000</p>
                                        <button class="btn btn-primary">Status</button>
                                        <button class="btn btn-outline-primary">Message</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card mb-3 h-100">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 fs-6">Full Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary" data-profiler id='zFullName'>-</div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary" data-profiler id='zEmail'>
                                        -
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary" data-profiler id='zPhone'>-</div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-5">
                                        <h6 class="mb-0">Successful Returns:</h6>
                                    </div>
                                    <div class="col-sm-7 text-secondary">
                                        <span>-</span>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary" data-profiler id='zAddress'>-</div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-12">
                                        <a class="btn btn-link" target="__blank" href="https://www.bootdey.com/snippets/view/profile-edit-data-and-skills">Update</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card p-0">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" id="myTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="unsettled-tab" data-bs-toggle="tab" href="#unsettled" role="tab" aria-controls="unsettled" aria-selected="true">Unsettled Transactions</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="history-tab" data-bs-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">Transaction History</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content pt-2 " style="min-height:200px;" id="myTabsContent">
                                <!-- Unsettled Transactions Tab -->
                                <div class="tab-pane fade show active transreport" id="unsettled" role="tabpanel" aria-labelledby="unsettled-tab">
                                    <div class="fs-6 m-2 text-center text-muted">No Unsettle Transaction Found!</div>

                                </div>
                                <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                                    <div class="mb-2">
                                        <div class="position-relative">
                                            <span class="position-absolute search-icon"><i class="bi bi-search"></i></span>
                                            <input class="form-control" id="THistorySearchInput" placeholder="Search history" />
                                        </div>
                                    </div>
                                    <ul class="list-group tHistoryList">
                                        <!-- Complete transaction history entries -->
                                        <li class="list-group-item list-group-item-action">
                                            <div class="row">
                                                <div class="col-12 col-md-4">Book Title 3</div>
                                                <div class="col-6 col-md-1">
                                                    <span class="badge bg-success rounded-pill">Paid</span>
                                                </div>
                                                <div class="col-6 col-md-2">
                                                    <span class="transaction-type">Borrowed</span>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <span class="transaction-date">Jan 5, 2024</span>
                                                </div>
                                                <div class="col-6 col-md-2">
                                                    <span class="transaction-id">#12345</span>
                                                </div>
                                            </div>
                                        </li>

                                        <!-- Add more complete transaction history entries here -->
                                    </ul>
                                </div>
                            </div>
                            <!-- Transaction History Tab -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>



<div class="modal fade" id="processModal" tabindex="-1" aria-labelledby="processModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content transactionitems">

        </div>

    </div>
</div>


<div class="tabledataoutput" id="invoice-POS" style='display:none;'>

</div>

<script>
    //variable declarations 
    const userbucket = document.querySelector(".listwhoborrow");
    const userreportscontainer = document.querySelector(".transreport");
    const imgProfileEL = document.querySelector(".imgProfile");

    const transactionitems = document.querySelector(".transactionitems");
    const adminsid = document.querySelector(".userid").dataset.userid;
    const tabledataoutput = document.querySelector(".tabledataoutput");

    function handlePrint() {
        $('.tabledataoutput').printThis({
            removeInline: true,
            loadCSS: 'http://localhost/librarysystemprojectMain/css/invoice.css',
            importCSS: false,
        });
    };
    document.getElementById("processModal").addEventListener("hidden.bs.modal", function(event) {
        // Code to execute when the modal is closed
        const id = document.querySelector("#zUserId").dataset.currprofileid;
        console.log("Modal closed", id);
        showuserborrow();
        uniquserbtran(id)
    });

    //processing Transaction 
    function selectproccesstransacs(e) {
        const processBtn = e.currentTarget;
        const overlay = document.getElementById("processOverlay");
        const printBtn = document.getElementById("printTransacBtn");
        const confirmBox = document.getElementById("confirmBox");
        const processModalLabel = document.getElementById("processModalLabel");

        processBtn.innerHTML = `<i class="bi bi-hourglass-top fa fa-spin"></i> Processing`;
        processBtn.disabled = true;
        overlay.style.display = "block";


        const data = Array.from(document.querySelectorAll("[data-transNo]"));
        console.log(data);
        console.log(data.length);
        let id = parseInt(e.currentTarget.dataset.useridtrans);
        console.log(id);
        //get all checked items put it in array
        let newarray = data.reduce((total, item) => {
            const transType = item.dataset.transtype
            const transNo = item.dataset.transno
            total.push({
                transNo,
                transType
            });
            return total;
        }, [])

        if (newarray.length > 0) {
            console.log(data.length + "true");
            console.log(newarray, "process");
            const params = `selecteditemstobeprocess=${JSON.stringify(newarray)}&userid=${id}&adminid=${adminsid}`;
            const xhrs = new XMLHttpRequest();
            xhrs.open("POST", "methods/typeoftransaction.php", true);

            xhrs.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhrs.onload = function() {
                setTimeout(function() {
                    overlay.style.display = "none";
                    if (xhrs.status == 200) {
                        console.log("success on transaction");
                        const res = xhrs.responseText;
                        console.log(res);
                        tabledataoutput.innerHTML = res;
                        printBtn.classList.remove('d-none')
                        processBtn.classList.add('d-none')
                        confirmBox.classList.add('d-none')
                        processModalLabel.textContent = 'Transaction Success'
                        processModalLabel.classList.add('text-success')

                    } else {
                        processBtn.innerHTML = 'Process All';
                        processModalLabel.textContent = 'Transaction Failed'
                        processModalLabel.classList.add('text-danger')
                        console.log("failed");
                    }

                }, 3000);

            }
            xhrs.send(params);

        }

    }

    function handleConfirmCheckbox(e) {
        const confirmCheckbox = e.currentTarget;
        const processButton = document.getElementById('processTransBtn');
        processButton.disabled = confirmCheckbox.checked ? false : true;
    }
    //selected items for transaction modal

    function selectaddshow(e) {
        const checkbox = Array.from(document.querySelectorAll(".selectitemtransno"));
        let id = parseInt(e.currentTarget.dataset.useridtrans);
        //get all checked items put it in array
        let transInfo = checkbox.reduce((total, item) => {
            if (item.checked) {
                const transType = item.parentElement.parentElement.querySelector('#transType').value || null
                total.push({
                    transNo: item.value,
                    transType
                });
            }
            return total;
        }, [])

        if (transInfo.length > 0) {
            console.log(checkbox.length + "true");
            console.log(transInfo, "adddselected");
            const params = `selecteditemstobeprocess=${JSON.stringify(transInfo)}&userid=${id}`;
            const xhrs = new XMLHttpRequest();

            xhrs.open("POST", "methods/addselectedRT.php", true);

            xhrs.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhrs.onload = function() {
                if (xhrs.status == 200) {

                    const res = xhrs.responseText;
                    transactionitems.innerHTML = res;
                    $('#processModal').modal('show');


                } else {
                    console.log("failed");
                }
            }
            xhrs.send(params);

        } else {
            showAlert2(false, "Please Select an Item!", 'warn')

        }

    }
    //show the users with borrowed books and unpaid penalties updating every 500ms hahahaha!
    function showuserborrow() {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "methods/getuserhavereserves.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status == 200) {
                const res = xhr.responseText;
                userbucket.innerHTML = res;

            } else {
                console.log("failed");
            }
        }
        xhr.send(`table=borrowtran&getfield=DateBorrowed`);
    }

    showuserborrow();


    //click function for list of users found in borrowed books and unpaid penalties
    function uniquserbtran(e) {
        // username user_id Fullname email phoone address
        const imgProfileEL = document.querySelector(".imgProfile");
        const ProfilesEL = document.querySelectorAll("[data-profiler]");

        const targetedid = e.currentTarget?.dataset.userid ?? e;
        const imgtarget = e.currentTarget?.children[0].children[0].dataset.imgsrc ?? null;


        console.log(targetedid, imgtarget);
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "methods/filterusertransreport.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status == 200) {
                const res = xhr.responseText;
                userreportscontainer.innerHTML = res;
                getUserProfile(targetedid, (data) => {
                    //set the profile data
                    ProfilesEL[0].textContent = data.username;
                    ProfilesEL[1].textContent = "#" + targetedid;
                    ProfilesEL[1].dataset.currprofileid = targetedid;
                    ProfilesEL[2].textContent = data.Fname + " " + data.Lname;
                    ProfilesEL[3].textContent = data.Email;
                    ProfilesEL[4].textContent = data.MobileNo;
                    ProfilesEL[5].textContent = data.OfcAdrs;
                })
                if (imgtarget != null) {
                    imgProfileEL.src = imgtarget;
                }


            } else {
                console.log("failed");
            }
        }
        xhr.send(`userid=${targetedid}`);

    }

    // Function to perform user search
    function searchFeatureNew(e, searchClass) {
        const searchTerm = e.target.value.toLowerCase();
        const ListItems =
            document.querySelectorAll(`${searchClass} .list-group-item`) || [];
        if (ListItems.length <= 0) return;
        ListItems.forEach((item) => {
            const userName = item.textContent.toLowerCase().trim();

            if (userName.includes(searchTerm)) {
                item.classList.remove("d-none");
            } else {
                item.classList.add("d-none");
            }
        });
        const span = document.createElement("span");
        const spanExists =
            document.querySelector(`${searchClass} span.text-muted`) == undefined;
        const itemsDisplayed = Array.from(ListItems).filter(
            (e) => !e.classList.contains("d-none")
        );
        if (itemsDisplayed.length <= 0 && spanExists) {
            span.textContent = "No Item Found";
            span.classList.add("text-muted");
            document.querySelector(`${searchClass}`).append(span);
            return;
        }
        if (itemsDisplayed.length > 0) {
            !spanExists
                ?
                document.querySelector(`${searchClass} span.text-muted`).remove() :
                "";
        }
    }

    function selectAllUnsettled(e) {
        const isChecked = e.currentTarget.checked;
        document.querySelectorAll(".transreport .form-check-input").forEach((checkbox) => {
            checkbox.checked = isChecked;
        });
    };
    // Event listener for the search button
    document
        .getElementById("UUserSearchInput")
        .addEventListener("keyup", (e) => {
            searchFeatureNew(e, ".UUserList");
        });
    document
        .getElementById("THistorySearchInput")
        .addEventListener("keyup", (e) => {
            searchFeatureNew(e, ".tHistoryList");
        });
</script>