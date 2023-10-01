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

    .user-item {
        padding: 10px;
        /* Add padding for spacing */
        margin-bottom: 10px;
        /* Add margin between user items */
        background-color: #f8f9fa;
        /* Add a background color if needed */
        border: 1px solid #dee2e6;
        /* Add a border for separation */
    }

    .user-image {
        max-width: 100px;
        /* Limit the maximum width of the circular image */
    }
</style>

<main class="returntrans">

    <div class="container">
        <div class="row h-100">
            <div class="col-sm-2 col-md-3 ">
                <div class="alert alert-info">
                    <h4>Filter for users who borrowed books and have unsettled penalties</h4>
                    <p>Use the search box below to find users based on their System ID.</p>
                </div>
                <form class="findcontainer findretcontainer">
                    <label for="filterId" class="form-label">Search by System ID:</label>
                    <input type="search" class="filterusers filterusersret form-control" id="filterId" autocomplete="off" placeholder="Enter System ID">
                </form>
                <!-- Rest of your content -->
                <hr>
                <p>Member List:</p>
                <div class="list-items-reservuser listwhoborrow d-flex flex-row flex-nowrap overflow-auto">
                    <!-- User Item 1 -->
                    <div onclick="uniquserbtran(event)" data-userid="190001" class="container user-item me-3">
                        <img data-imgsrc="usersprofileimg/profile190001.jpg" src="usersprofileimg/profile190001.jpg" class="img-fluid rounded-circle user-image-small">
                        <p class="text-center mb-0">ORILLA<br><strong>ID:</strong> 190001</p>
                    </div>
                    <!-- Add more user items as needed -->
                </div>

            </div>
            <div class="col-md-9 ">
                <div class="userdesc">
                    <div class="d-flex justify-content-center align-items-center">
                        <img class="editimgr rounded-circle" style="height: 100px; width: 100px;" src="usersprofileimg/profiledefault.png" alt="User Profile Image">
                    </div>
                    <h1 class="profiler text-center mt-3">User Profile</h1>
                </div>
                <div class="reserve-container transreport text-center">
                    <p>No data found yet...</p>
                </div>
            </div>
        </div>
    </div>

</main>



<!-- modal for addselecteditem RETURN TRANSACTION  -->
<style>
    .addselectedmodalcontainer {
        position: fixed;
        background: rgba(0, 0, 0, 0.4);
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 100;
        display: grid;
        place-items: center;
        transform: scale(0);
        transition: transform 200ms;
    }

    .transactionitems {
        width: 50%;
        height: 70%;
        background: white;
    }

    .tabledataoutput {
        position: fixed;
        background: whitesmoke;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 100;
        display: grid;
        place-items: center;
        transform: scale(0);
        transition: transform 200ms;
    }

    .addselectshow {
        transform: scale(1);
    }

    #rectable,
    #rectable td,
    #rectable th {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
<div class="addselectedmodalcontainer">
    <div class="transactionitems">

    </div>
</div>
<div class="tabledataoutput">

</div>

<script>
    //variable declarations 
    const userbucket = document.querySelector(".listwhoborrow");
    const userreportscontainer = document.querySelector(".transreport");
    const profiler = document.querySelector(".profiler");
    const editimgr = document.querySelector(".editimgr");
    const findretcontainer = document.querySelector(".findretcontainer");
    const filterusersret = document.querySelector(".filterusersret");
    const transactionitems = document.querySelector(".transactionitems");
    const addselectedmodalcontainer = document.querySelector(".addselectedmodalcontainer");
    const adminsid = document.querySelector(".userid").dataset.userid;
    const tabledataoutput = document.querySelector(".tabledataoutput");
    //cancel button in printable report
    function cancelinprint(e) {
        tabledataoutput.classList.remove("addselectshow");
        addselectedmodalcontainer.classList.remove("addselectshow");
        transactionitems.innerHTML = "";
        tabledataoutput.innerHTML = "";

        //refresh the transaction record
        let id = e.currentTarget.dataset.useridtransNo;

        console.log(id);
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "methods/filterusertransreport.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status == 200) {
                const res = xhr.responseText;
                userreportscontainer.innerHTML = res;
                const stat = document.querySelector(".datasr");
                if (stat.dataset.statusr = "off") {

                    profiler.innerHTML = "Profile";
                    editimgr.src = "usersprofileimg/profiledefault.png";

                }

            } else {
                console.log("failed");
            }
        }
        xhr.send(`userid=${id}`);


    }
    //processing Transaction 
    function selectproccesstransacs(e) {

        const typeotrans = document.querySelector("#option");
        console.log(typeotrans.value);
        const checkbox = Array.from(document.querySelectorAll(".selectitemtransnoADRT"));
        console.log(checkbox);
        console.log(checkbox.length);
        let id = parseInt(e.currentTarget.dataset.useridtrans);
        console.log(id);
        //get all checked items put it in array
        let newarray = checkbox.reduce((total, item) => {
            total.push((item.value));
            return total;
        }, [])

        if (newarray.length > 0) {
            console.log(checkbox.length + "true");
            console.log(newarray, "process");
            const params = `selecteditemstobeprocess=${JSON.stringify(newarray)}&userid=${id}&typeoftrans=${typeotrans.value}&adminid=${adminsid}`;
            const xhrs = new XMLHttpRequest();
            xhrs.open("POST", "methods/typeoftransaction.php", true);

            xhrs.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhrs.onload = function() {
                if (xhrs.status == 200) {

                    const res = xhrs.responseText;


                    tabledataoutput.innerHTML = res;
                    tabledataoutput.classList.add("addselectshow");
                } else {
                    console.log("failed");
                }
                showuserborrow();
            }
            xhrs.send(params);

        }

    }
    //removing selected in modal RT 
    function removelistRTMODAL() {

        const checkbox = Array.from(document.querySelectorAll(".selectitemtransnoADRT"));
        console.log(checkbox);
        console.log(checkbox.length);
        //get all checked items put it in array
        checkbox.forEach(item => {
            if (item.checked) {
                item.parentElement.parentElement.remove();
            }

        })
    }
    // close modal selected items for transaction modal
    function canceladdselected() {
        addselectedmodalcontainer.classList.remove("addselectshow");
        transactionitems.innerHTML = "";
    }
    //selected items for transaction modal

    function selectaddshow(e) {
        const typeotrans = document.querySelector("#option");

        console.log(typeotrans.value);
        const checkbox = Array.from(document.querySelectorAll(".selectitemtransno"));
        console.log(checkbox);
        console.log(checkbox.length);
        let id = parseInt(e.currentTarget.dataset.useridtrans);
        console.log(id);
        //get all checked items put it in array
        let newarray = checkbox.reduce((total, item) => {
            if (item.checked) {
                total.push((item.value));
            }
            return total;
        }, [])

        if (newarray.length > 0) {
            console.log(checkbox.length + "true");
            console.log(newarray, "adddselected");
            const params = `selecteditemstobeprocess=${JSON.stringify(newarray)}&userid=${id}&typeoftrans=${typeotrans.value}`;
            const xhrs = new XMLHttpRequest();

            xhrs.open("POST", "methods/addselectedRT.php", true);

            xhrs.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhrs.onload = function() {
                if (xhrs.status == 200) {

                    const res = xhrs.responseText;
                    transactionitems.innerHTML = res;
                    const trigger = document.querySelector("#triger");
                    console.log(res);
                    console.log(trigger.dataset.trigger);
                    if (trigger.dataset.trigger > 0) {
                        alert(trigger.textContent);
                        trigger.remove();


                    } else {
                        addselectedmodalcontainer.classList.add("addselectshow");
                    }


                } else {
                    console.log("failed");
                }
            }
            xhrs.send(params);

        } else {
            alert("Please Select an Item!")
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

        const targetedid = e.currentTarget.dataset.userid;
        const targetname = e.currentTarget.innerText;
        const imgtarget = e.currentTarget.children[0].dataset.imgsrc;


        console.log(targetedid);
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "methods/filterusertransreport.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status == 200) {
                const res = xhr.responseText;
                userreportscontainer.innerHTML = res;
                profiler.innerHTML = targetname;
                editimgr.src = imgtarget;

            } else {
                console.log("failed");
            }
        }
        xhr.send(`userid=${targetedid}`);

    }
    //search in return transaction facility for finding users transactions hahahahahahahahahahaha!!!   
    findretcontainer.addEventListener('submit', srchretsumbit);
    filterusersret.addEventListener('keyup', searchretkey);

    //key event function for search in ret transaction
    function searchretkey(eve) {
        if (filterusersret.value.length == '') {


            showuserborrow();


        } else {
            srchretsumbit(e)
        }
    }
    //submit event function for search in ret transaction
    function srchretsumbit(e) {

        e.preventDefault();
        seachval = filterusersret.value;

        if (seachval.length > 0) {

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "methods/searchuserforResandtrans.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status == 200) {
                    const res = xhr.responseText;
                    userbucket.innerHTML = res;
                } else {
                    console.log("failed");
                }
            }
            xhr.send(`searchthisuser=${seachval}&table=borrowtran`);

        } else {

        }


    }
</script>