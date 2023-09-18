<?php
include './partials/header.php'
?>
<style>
    main {
        max-width: 900px;
        width: 100%;
        height: auto;
        margin: 1em auto;
        box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
        position: relative;

    }

    section {
        width: 100%;
        height: auto;
        padding-top: 2em;
        position: absolute;
        top: 0;
        background: whitesmoke;
        color: white;
        display: none;

        border-radius: 10px;
        box-shadow: 0px 1px 4px grey;
    }

    .transaction-record {
        background-color: whitesmoke;
        color: #333;
        text-align: center;
        font-size: 1em;
        min-height: 100vh;
        max-height: auto;
        padding: 2em;
        display: none;
    }

    nav {
        /* background-color: #4D0404; */
        background-color: rgb(41, 41, 41);
        box-sizing: border-box;
        width: 100%;
        padding: .1em 1em;
        color: white;
        box-shadow: 0px 1px 4px lightblue;
        height: 60px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .links-container {
        margin-left: auto;
        margin-right: 3em;


    }

    .links-container a {
        text-decoration: none;
        font-size: 17px;
        font-weight: normal;
        color: whitesmoke;
        margin: 0em .3em;
        padding: .2em;
        cursor: pointer;
        position: relative;

    }

    .links-container a::before {
        content: '';
        height: 1px;
        width: 100%;
        background-color: white;
        position: absolute;

        bottom: 0px;
        transform: scale(0);
        transition: all 170ms;

    }

    .links-container a:hover:not(.active)::before {

        transform: scale(1);
    }

    .links-container a.active::before {
        transform: scale(1);
    }

    main .active {
        display: block;
        z-index: 99;
    }

    .e-cart {
        color: black;
        background: whitesmoke;
        display: none;
        grid-template-columns: 1fr 1fr;
        padding: 0em 1em 1em 1em;
        grid-gap: .3em;



    }

    .filtercontainer {
        display: flex;
        justify-content: center;
    }


    .cartno {
        grid-column: 1 / 3;
        background: black;
        /* color: rgb(161, 0, 9); */
        color: #eee;
        display: flex;
        border-top: 5px solid lightblue;
    }

    button {
        padding: .6em;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 13px;
        margin: 3px 1px;
        transition-duration: 0.4s;
        cursor: pointer;
        background-color: whitesmoke;
        color: black;
        border: 2px solid lightblue;
    }

    button:hover {
        background-color: lightblue;
        color: black;
    }

    .buttondel {
        display: flex;
        flex-direction: column;

        justify-content: center;
    }

    .tablecart {

        width: 40vw;
        border: 3px lightblue solid;
        overflow: auto;
        height: 300px;

    }

    .tablecart table {
        width: 100%;
    }

    table {
        border-collapse: collapse;

    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 10px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }


    .show {
        padding: .2em .5em;
        width: 64px;

    }

    .container-4categories {
        margin-left: .4em;
    }

    /* my account area  */
    .Yaccount {
        margin-right: 1em;
        height: 35px;

        cursor: pointer;
    }

    .containerprofile {
        display: flex;
        background: transparent;
        width: 100%;
        height: 100%;
        border-radius: 10px;
        padding: .2em;
        box-sizing: border-box;
        color: white;
        align-items: center;
        gap: 3px;
        transition: all 150ms;
    }

    .containerprofile:hover {
        background: #111;
    }

    .containerprofile p {
        margin: 0 .5em;
    }

    .containerprofile img {
        border-radius: 50%;
        height: 30px;
        width: 30px;

    }

    .activenew {
        display: block;
    }
</style>


<div class="userid" data-userid='<?php echo $UID ?>'></div>

<nav>
    <?php
    include "connection/oopconnection.php";
    $sqll = "SELECT * FROM users where user_id = $UID";
    $res = $conn->query($sqll) or die($conn->error);
    $rowww = $res->fetch_assoc();

    echo "<h1 style='color:whitesmoke';>Welcome " . strtoupper($rowww['Fname']) . "
                </h1>";

    $conn->close(); ?>

    <div class="links-container">

        <a class="linkbtn active" data-link="sandr">Search and Reserve</a>
        <a class="linkbtn" data-link="trec">Transaction record</a>



    </div>
    <div class="Yaccount">
        my account
    </div>
    <a href="logout.php?userid=<?php echo $UID ?>">Logout</a>
</nav>



<main>
    <section class="search-reserve active">

        <h2 class="cartno" style="box-sizing:border-box;padding: .5em;"> E-Cart////// <button class="show">show</button></h2>
        <div class="e-cart">

        </div>
        <h1 class="cartno" style="padding:1em 0em;padding-left:2em; margin:0;">BOOK COLLECTION</h1>
        <div class="filtercontainer">
            <?php include './partials/Filterform.php'; ?>
            <!-- search field -->
        </div>
        <div class="container-4categories"></div>
        <div id="books-collection"></div>
    </section>
    <style>
        table {
            width: 80%;
            background: none;
        }

        th,
        td {
            border-bottom: 1px lightblue solid;
            font-size: 16px;
            color: black;
        }

        th {
            background: #222;
            color: #eee;
            text-align: center;
        }

        .trecord {
            display: none;
        }

        .activ {
            background-color: lightblue;
            color: black;
        }
    </style>
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
        <button class="transactionlinkrbtn activ" data-transrc='treports'>Transaction reports</button>
        <button class="transactionlinkhbtn" data-transrc='thistory' onclick='showhistoryjpeg()'>Transaction history</button>
        <div class="trecord transaction-report active">

            <div class=" transaction-report-container ">

            </div>

        </div>
        <div class=" trecord transaction-history">

            <div class=" transaction-history-container sameas ">
                <div class="loaderss"></div>
            </div>

        </div>
    </section>



</main>
<!-- style for modal profile update -->
<style>
    .reservetable {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

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

    .modalmyaccount {
        position: relative;
        width: 50%;
        height: 75%;
        display: grid;
        place-items: center;
        background-color: black;
        color: grey;
        padding: 1em;
    }

    .containerdet {

        width: 80%;
        height: 90%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-auto-rows: minmax(auto, 45px);
        justify-content: center;
    }

    .modalmyaccount img {
        height: 100px;

        grid-column: 1 / -1;
        box-shadow: 0px 2px 10px #333;
    }

    .updatebtncontainer {
        position: absolute;
        bottom: 1em;
        right: 1em;
        background: lightblue;
        padding: 0px 2px;
        border-radius: 5px;

    }

    .updatebtncontainer button {
        padding: 4px;
    }

    .modalmyaccount input {
        background: transparent;
        border: 1px solid rgb(38, 38, 38);
        color: grey;
        display: block;
        padding: 4px;
        width: 80%;
    }

    .showmodalmyacc {
        transform: scale(1);
    }

    #filedata {
        margin: 0;
        width: 40%;
    }

    #searchfortranshis {
        padding: .5em 1em;
        font-size: 15px;
        background: whitesmoke;
        color: #222;
        margin: 1rem;
        width: 30em;
        border: 1px solid grey;
    }

    .sameas {

        display: flex;
        flex-direction: column;
        align-items: center;
    }
</style>

<!-- Modal for my account -->
<div class="modalacccontainer">
    <div class="modalmyaccount"></div>

</div>


<p class="trackcat" style="visibility:hidden;">All</p>



<!-- bookmodal -->
<style>
    /* show modal */
    .show-modal {
        transform: scale(1);
        transition: all 200ms;
    }

    /* modal view books */
    .viewbookcontainer {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        place-items: center;
        z-index: 100000;
    }

    .bookdata {
        background-color: whitesmoke;
        height: 90%;
        width: 95%;
        overflow: auto;
        padding: 1em;
        box-sizing: border-box;
    }

    .bookdata h5 {
        display: inline;
        font-size: 24px;
        font-family: sans-serif;
    }

    .bookdata span {
        font-size: 22px;

    }

    .bookdata img {
        width: 300px;
        height: 320px;
        background: burlywood;
    }

    .bookdata .intro {
        display: flex;
        gap: 1em;
    }

    .bookdata a {
        font-size: 23px;
        color: navy;
        background: rgba(0, 0, 0, 0.2);
        padding: .5em;
        border-radius: 10px;
    }

    .showmodalbk {
        display: grid;
    }
</style>
<div class="viewbookcontainer">


</div>
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
    //showpassword
    function toggleshowpass() {
        const spass = document.getElementById("password");
        if (spass.type === "password") {
            spass.type = "text";
        } else {
            spass.type = "password";
        }
    }
    //class="userid"
    const userid = document.querySelector(".userid").dataset.userid;
    //load window
    window.addEventListener("load", () => {
        setTimeout(() => {
            const cloader = document.querySelector(".containerloader");
            cloader.className += " hide";

        }, 2000);

    });
    //transaction records
    const transacrecord = document.querySelector(".transaction-record");
    const transactionreport = document.querySelector(".transaction-report");
    const transactionhistory = document.querySelector(".transaction-history");
    const transactionrecordcontainer = document.querySelector(".transaction-report-container");


    const transactionhisontainer = document.querySelector(".transaction-history-container");

    const transactionlinkbtn = document.querySelectorAll(".transaction-record button");
    const trecord = document.querySelectorAll(".trecord");

    transacrecord.addEventListener("click", (e) => {
        console.log(e.target.dataset.transrc);
        if (e.target.dataset.transrc) {
            const btndata = e.target.dataset.transrc;
            transactionlinkbtn.forEach(e => {
                e.classList.remove("activ");
            })
            trecord.forEach(e => {
                e.classList.remove("active");
            })
            e.target.classList.add("activ");
            if (btndata == "thistory") {

                transactionhistory.classList.add("active");
            } else {
                transactionreport.classList.add("active");
            }
        }
    })

    //show transaction history
    function showhistoryjpeg() {
        setTimeout(() => {
            xttpreq("methods2/showtranshistory.php", `userid=${userid}`, transactionhisontainer)
        }, 1500)


    }
    //search transaction history

    function stranshist(e) {
        e.preventDefault();
        const searchvalth = document.querySelector("#searchhisform input");

        let findthis = searchvalth.value;
        xttpreq("methods2/showtranshistory.php", `find=${findthis}`, transactionhisontainer)

    }
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

    const mainid = document.querySelector(".userid");
    const containeruserdetails = document.querySelector(".modalmyaccount");
    const containermyacc = document.querySelector(".modalacccontainer");
    const Yaccount = document.querySelector(".Yaccount");


    function doneediting(e) {
        updateprofile();
        // update details
        const ids = e.currentTarget.dataset.userid;
        const Fname = document.querySelector("#Fname").value;
        const Lname = document.querySelector("#Lname").value;
        const ResAdrs = document.querySelector("#ResAdrs").value;
        const OfcAdrs = document.querySelector("#OfcAdrs").value;
        const LandlineNo = document.querySelector("#LandlineNo").value;
        const MobileNo = document.querySelector("#MobileNo").value;
        const username = document.querySelector("#username").value;
        const password = document.querySelector("#password").value;

        const xml = new XMLHttpRequest();
        xml.open("POST", "methods/showaccount.php", true);
        xml.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xml.onload = function() {
            if (xml.status == 200) {
                const res = xml.responseText;
                console.log(res);
                alert(res);
                xttpreq("methods/showaccount.php", "useridshowdetails=<?= $UID ?>", containeruserdetails)
                xttpreq("methods/showaccount.php", "userid=<?= $UID ?>", Yaccount)

            } else {
                console.log("failed");
            }

        }
        xml.send(`accid=${ids}& fname=${Fname}&lname=${Lname}&resid=${ResAdrs}&ofcAdrs=${OfcAdrs}&landlineNo=${LandlineNo}&MobileNo=${MobileNo}&username=${username}&password=${password}`);



    }

    function updateprofile() {
        //update profile pic
        const files = document.querySelector("#filedata").files;
        if (files.length > 0) {

            let formData = new FormData();
            formData.append("file", files[0]);
            formData.append("userid", mainid.dataset.userid);
            console.log(formData);
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "methods/profileuploads.php", true);
            xhr.onload = function() {
                if (xhr.status == 200) {

                    const res = xhr.responseText;

                    xttpreq("methods/showaccount.php", "useridshowdetails=<?= $UID ?>", containeruserdetails)
                    xttpreq("methods/showaccount.php", "userid=<?= $UID ?>", Yaccount)

                } else {
                    console.log("failed");
                }

            }
            xhr.send(formData);
        }
    }
    //edit profile
    function editmyacc(e) {
        const id = e.currentTarget.dataset.userid;



        const xhr = new XMLHttpRequest();
        xhr.open("POST", "methods/showaccount.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status == 200) {
                const res = xhr.responseText;
                containeruserdetails.innerHTML = res;


            } else {
                console.log("failed");
            }

        }
        xhr.send(`useriduserupdate=<?= $UID ?>`);


    }

    //close and open modal 
    Yaccount.addEventListener("click", () => {
        containermyacc.classList.add("showmodalmyacc");

    })

    function closemodal() {
        containermyacc.classList.remove("showmodalmyacc");
    }
    // show account details
    xttpreq("methods/showaccount.php", "useridshowdetails=<?= $UID ?>", containeruserdetails)

    // show account profile pic & username
    xttpreq("methods/showaccount.php", "userid=<?= $UID ?>", Yaccount)

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
                    console.log(res);
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
    const categoriescontainer = document.querySelector(".container-4categories");
    const trec = document.querySelector(".transaction-record");
    const cartcontainer = document.querySelector(".e-cart");

    const cartcheckbox = document.querySelectorAll(".selectcheck");


    console.log(cartcheckbox);
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


    //hide and show btn
    const showandhide = document.querySelector(".show");
    showandhide.addEventListener("click", showhide);

    function showhide() {


        const xhr = new XMLHttpRequest();
        xhr.open("POST", "methods/getbookfromcart.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {

            if (xhr.status == 200) {
                const res = xhr.responseText;
                cartcontainer.innerHTML = res;
                if (showandhide.innerText == 'show') {
                    showandhide.innerText = `hide`;
                    cartcontainer.style.display = `grid`;
                } else {
                    showandhide.innerText = `show`;
                    cartcontainer.style.display = `none`;
                }

            } else {
                console.log("failed");
            }
        }
        xhr.send(`userid=${userid}`);


    }

    //click outside other events function for closing of modals
    window.addEventListener('click', () => {

        droplistcontainer.style.display = "none";
    })

    //links of two facilities 
    links.addEventListener("click", el => {
        console.log(el.target.dataset.link);

        if (el.target.dataset.link) {
            const btnlinks = Array.from(links.children);

            btnlinks.forEach(e => {
                e.classList.remove("active");
            });
            sections.forEach(e => {
                e.classList.remove("active");
            })

            el.target.classList.add("active");
            if (el.target.dataset.link == "sandr") {
                console.log("sandr active");
                showallcollection();

                searchandreserve.classList.add("active");
            } else if (el.target.dataset.link == "trec") {
                trec.classList.add("active");
                console.log("tra active");
                showalltranrecord();
                transacrecord.classList.add("active");
            }
        }
    });


    showallcollection();
    //collection
    function showallcollection() {

        const xhr = new XMLHttpRequest();
        xhr.open("GET", "methods/showallbooks.php", true);
        xhr.onload = function() {
            if (xhr.status == 200) {
                const res = xhr.responseText;
                console.log(collection.innerHTML = res);

            } else {
                console.log("failed");
            }
        }
        xhr.send();
    }

    //for filter category buttons
    function showcategories() {
        const xhrs = new XMLHttpRequest();
        xhrs.open("GET", "methods/getcollectionjson.php", true);

        xhrs.onload = function() {
            if (xhrs.status == 200) {
                const res = JSON.parse(xhrs.responseText);
                console.log(res);

                const categories = getcategories(res);

                let outputcat = categories.map(e => {
                    if (e == "All") {
                        return `<button data-cat="${e}"class="btncatactive">${e}</button>`
                    } else {
                        return `<button data-cat="${e}">${e}</button>`
                    }

                }).join("");
                categoriescontainer.innerHTML = outputcat;


            } else {
                console.log("failed");
            }

        }
        xhrs.send();
    }
    showcategories();


    //click events for categories
    categoriescontainer.addEventListener("click", filtercat)

    function filtercat(e) {

        console.log(e.target.dataset.cat);
        if (e.target.dataset.cat) {
            const allbtncat = categoriescontainer.querySelectorAll("button");

            tracat.innerHTML = e.target.dataset.cat;
            allbtncat.forEach(e => {
                e.classList.remove("btncatactive");
            })
            if (e.target.dataset.cat !== "All") {
                e.target.classList.add("btncatactive");
                const param = `category=${e.target.dataset.cat}`;
                const xhrs = new XMLHttpRequest();
                xhrs.open("POST", "methods/filtercategories.php", true);

                xhrs.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                xhrs.onload = function() {
                    if (xhrs.status == 200) {
                        const res = xhrs.responseText;


                        collection.innerHTML = res;


                    } else {

                        console.log("failed");
                    }

                }
                xhrs.send(param);
            } else {
                e.target.classList.add("btncatactive");
                showallcollection();
            }
        }

    }
    //show button category
    function getcategories(items) {
        const categorylist = items.reduce((total, item) => {
            if (!total.includes(item.category)) {
                total.push(item.category);
            }
            return total;
        }, ["All"])

        return categorylist;
    }
    //add evetlisteners to addtocartbtns
    collection.addEventListener("click", addtocart);

    //removing selected items in cart function

    function getallchecks() {

        const checkbox = Array.from(document.querySelectorAll(".selectcheck"));
        console.log(checkbox);
        console.log(checkbox.length);
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

            const params = `deleteitemsfromcart=${JSON.stringify(newarray)}&userid=${userid}`;
            const xhrs = new XMLHttpRequest();
            xhrs.open("POST", "methods/deletemultiple.php", true);

            xhrs.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhrs.onload = function() {
                if (xhrs.status == 200) {
                    const res = xhrs.responseText;
                    alert("System Message:" + newarray.length + "book/s successfully removed");
                    cartcontainer.innerHTML = res;

                } else {
                    console.log("failed");
                }
            }
            xhrs.send(params);
        }

    }
    //function of addtocartbtns

    function addtocart(e) {

        if (e.target.dataset.isbn) {

            const bookid = e.target.dataset.isbn;

            console.log(bookid);
            const param = `bookid=${bookid}&userid=${mainid.dataset.userid}`;
            const xhrs = new XMLHttpRequest();
            xhrs.open("POST", "methods/addtocart1.php", true);

            xhrs.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhrs.onload = function() {
                if (xhrs.status == 200) {
                    const res = xhrs.responseText;
                    showallcollection();
                    cartcontainer.innerHTML = res;
                    const checkbox = Array.from(document.querySelectorAll(".selectcheck"));

                    const titles = document.querySelector(".currerror");
                    if (titles) {
                        alert("System Message:" + titles.innerText);
                    } else {
                        const title = document.querySelector(".currtitle");
                        alert("System Message: Book:" + title.innerText + " ... successfully added to your cart, Total of " + checkbox.length + " book/s");
                    }


                } else {
                    console.log("failed");
                }

            }
            xhrs.send(param);

        }



    }
    //book modal area

    const modalbook = document.querySelector(".viewbookcontainer");

    function viewbookev(e) {

        if (e.currentTarget.dataset.bookuniq && !e.target.dataset.isbn) {
            const abc = e.currentTarget.dataset.bookuniq;
            console.log(abc);
            openbookmodal();
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "methods2/viewbookdetail.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status == 200) {
                    const res = xhr.responseText;
                    modalbook.innerHTML = res;
                } else {
                    console.log("failed");
                }
            }
            xhr.send(`isbn=${abc}`);
        }
    }

    function openbookmodal() {
        modalbook.classList.add("showmodalbk");
    }

    function closebookmodal(e) {
        e.preventDefault();
        modalbook.classList.remove("showmodalbk");
    }
</script>
</body>

</html>