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
            z-index: 99;
        }

        .e-cart {
            color: black;
            background: whitesmoke;
            display: none;
            grid-template-columns: 1fr 1fr;
            padding: 0em 1em 1em 1em;
            grid-gap: 1em;


        }

        .filtercontainer {
            display: flex;
            justify-content: center;
        }

        .selectcheck {
            display: block;
            cursor: pointer;
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
            border: 2px lightblue solid;
            overflow: auto;
            height: 300px;
        }

        .reservetable {
            width: 100%;
            height: 250px;
            overflow: auto;
            border: 2px solid black;
        }

        table {
            width: 100%;
            border-collapse: collapse;

            font-size: 12px;

        }


        td,
        th {
            color: #222;
            text-align: left;
            padding: .3em;
        }

        tr:nth-child(even) {
            background-color: lightblue;
        }

        .selectcheck {
            margin: auto;
        }

        .cart-toggle-container {
            margin-top: 1rem;
            display: flex;
            gap: 1rem;
            justify-content: space-between;
            align-items: center;
            background: black;
            padding: 0 1rem;
            /* color: rgb(161, 0, 9); */
            color: #eee;
            border-top: 1px solid lightblue;
        }

        .cart-toggle-container h2 {
            font-size: 1rem;
        }

        .container-4categories {
            margin-left: .4em;
        }

        .linksins {
            position: absolute;
            top: 0;
            left: 1%;

            z-index: 500;
        }

        .active4btn {
            background-color: #555555;
            color: white;

        }

        /* filter reservationa rea */
        .reservations-container {
            display: flex;
            justify-content: space-between;
            margin: 1em;
            height: 90vh;
            text-align: start;
            background-color: whitesmoke;

        }

        .filter-reserves-container {
            width: 40%;
            background-color: #222;
            padding: 1em;
            color: grey;

        }

        .reserve-container {
            padding: 1em;
            width: 85%;
            height: 60%;
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

        /* list users design */
        .main-container {
            display: flex;
            border: 3px solid lightblue;
            flex-direction: column;
            align-items: flex-start;
            padding: 1em;
            height: 400px;

        }

        .container {
            display: flex;
            width: 100%;
            border-bottom: 1px solid grey;
            height: 40px;
            align-items: center;
            cursor: pointer;
        }

        .container img {
            height: 30px;
            width: 40px;
            border-radius: 50%;
            margin: 0em 1em;
        }


        /* navigation styles */
        nav {
            /* background-color: #4D0404; */
            background-color: rgb(41, 41, 41);
            box-sizing: border-box;
            width: 100%;
            padding: 2em 1em;
            color: white;
            box-shadow: 0px 1px 4px grey;
            height: 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav i {
            color: green;
            margin: 0 1em;
            cursor: pointer;
        }

        nav i:hover {
            color: aqua;

        }

        .links-container {
            margin-left: auto;
            margin-right: 1.2em;
            display: flex;

        }

        .links-container a {
            text-decoration: none;
            font-size: 17px;
            font-weight: normal;
            color: whitesmoke;
            margin: 0em .3em;
            padding: .2em;

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

        /* 
        century links */
        .century {
            width: 75vw;
            height: auto;
            margin: 1em auto;
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
    </style>


    <div class="userid" data-userid='<?php echo $UID ?>'></div>

    <nav>
        <?php
        include "connection/oopconnection.php";
        $sqll = "SELECT * FROM users where user_id = $UID";
        $res = $conn->query($sqll);
        $rowww = $res->fetch_assoc();

        echo "<h1 style='color:whitesmoke';>Welcome " . strtoupper($rowww['Fname']) . "
            </h1>";

        $conn->close(); ?>
        <div class="links-container">
            <a class="linkbtn active" data-nav="btrans">Borrow Transactions</a>
            <a class="linkbtn" data-nav="rtrans">Return Transactions</a>

        </div>
        <i class="reg">Approvals</i>
        <a href="logout.php?userid=<?php echo $UID ?>">Logout</a>

    </nav>

    <div class="century">
        <main class="borrowtrans activ">
            <div class="links linksins">
                <button class="btnbt active4btn" data-link="sandr">Manual Entry</button>
                <button class="btnbt" data-link="trec">Reservations</button>
                <button class="btnbt" data-link="mbook">Manage Book</button>
            </div>
            <!-- manual Entry AREA -->
            <section class="search-reserve activ">
                <div class="cart-toggle-container">
                    <h2>Book Cart | </h2>
                    <button class="show">View</button>
                </div>

                <div class="e-cart">

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
                <h1>manage books</h1>

            </section>
            <!-- manage books ui modals -->
            <style>
                .managebook {
                    padding: 1em;
                }

                #addnewbook {
                    display: flex;
                    margin-left: auto;
                    margin-right: 2em;
                    background-color: #1664e0;
                    color: #eee;

                }

                #addnewbook:hover {
                    background-color: #003282;


                }

                .managemodal {
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

                .managemodalitem {
                    position: relative;
                    width: 85%;
                    height: 80%;
                    display: grid;
                    place-items: center;
                    grid-template-columns: 2fr 1fr;
                    background-color: #eee;
                    color: grey;
                    padding: 1em;
                    padding: 2em;
                    box-sizing: border-box;
                }

                .managemodalitem form {
                    display: flex;
                    align-items: center;
                    flex-direction: column;
                    width: 90%;
                }

                .managemodalitem input {
                    padding: .5em;
                    border: none;
                    margin: .3rem;
                    width: 100%;
                }

                .managemodalitem button {
                    width: 7em;
                    margin: .3em auto;
                }

                .modalofdel {
                    background: whitesmoke;
                    padding: 1em;
                }

                .managebookrows img {
                    width: 50px;
                }
            </style>
            <!-- add book modal -->
            <div class="managemodal addmanagemodal">
                <div class="managemodalitem addmanagemodalitem">

                    <form id="addnewbk" onsubmit="addnewbookfunc(event)" method="POST">
                        <h2>ADD NEW BOOK</h2>
                        <hr>
                        <input type="text" name="isbn" placeholder="Enter Isbn" autocomplete="off" required>
                        <input type="text" name="title" placeholder="Enter Title" autocomplete="off" required>
                        <input type="text" name="author" placeholder="Enter Author" autocomplete="off" required>
                        <input type="text" name="abstract" placeholder="Enter Abstract" autocomplete="off" required>
                        <input type="text" name="category" placeholder="Enter category" autocomplete="off" required>
                        <input type="text" name="bookprice" placeholder="Enter Book Price" autocomplete="off" required>
                        <input type="text" name="yearpublished" placeholder="Enter Year Published" autocomplete="off" required>
                        <input type="text" name="publisher" placeholder="Enter Publisher" autocomplete="off" required>
                        <input type="text" name="quantity" placeholder="quantity" autocomplete="off" required>
                        <button type="submit" name="insert">SAVE</button>
                        <input type='hidden' name='bookinsert' value='addthisbook'>
                        <button onclick="closeaddmodalbk()">CLOSE</button>
                    </form>

                    <form class="imgbbookcontainer">
                        <img id='chimg' style="height:18em;" src="booksimg/bookdefault.png" alt="book">
                        <input id='filebdata' onchange="readURL(this)" type='file' name='file'>
                    </form>


                </div>
            </div>
            <!-- update book modal -->
            <div class="managemodal editmanagemodal">
                <div class="managemodalitem editmanagemodalitem">

                </div>
            </div>
            <!-- modal delete confirm modal-->
            <div class="managemodal deletemodalmangebook">
                <div class="modalofdel">
                    <h3>Are you sure you want to delete this book?</h3>
                    <button onclick="managebdel(event)" id="confirmationdelmb">Yes, Delete</button>
                    <button onclick="closeconfirmdelmodal()">Cancel</button>
                </div>
            </div>


            <!-- CLOSE manage books ui modals -->

            <!-- lend modal html codes -->



            <!-- end of lend modal -->


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

            .closebtn {
                font-size: 40px;
                color: black;
                position: absolute;
                right: 1em;
                cursor: pointer;
                transition: all 100ms;
            }

            .closebtn:hover {
                transform: scale(1.3);
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: lightblue;
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

        //show all in manage book
        xttpreq("methods2/managebooks.php", "", managebook);


        //add manage book 
        const addmanagemodal = document.querySelector(".addmanagemodal");
        const addmanagemodalitem = document.querySelector(".addmanagemodalitem");
        const confirmdelmb = document.querySelector(".deletemodalmangebook");

        function addnewbookfunc(e) {
            e.preventDefault();
            let uform = document.querySelector("#addnewbk");

            const formInputs = uform.getElementsByTagName("input");
            let formData = new FormData();
            for (let input of formInputs) {
                formData.append(input.name, input.value);
            }

            const bookfileform = document.querySelector(".imgbbookcontainer");
            const bookimgfile = document.querySelector("#filebdata").files;

            if (bookimgfile.length > 0) {
                formData.append("file", bookimgfile[0]);
            }

            xttpreqformdata("methods2/managebookui.php", formData, "alert");
            for (let input of formInputs) {
                input.value = "";
                bookfileform.reset();
            }


            setTimeout(() => {
                xttpreq("methods2/managebooks.php", "", managebook);
                addmanagemodal.classList.remove("showmodalreg");

            }, 1000);

        }

        function addnewbookshowmodal() {
            addmanagemodal.classList.add("showmodalreg");
            document.querySelector("#chimg").src = "booksimg/bookdefault.png";

        }

        function closeaddmodalbk(e) {
            addmanagemodal.classList.remove("showmodalreg");
        }


        //edit manage book
        const editmanagemodal = document.querySelector(".editmanagemodal");
        const editmanagemodalitem = document.querySelector(".editmanagemodalitem");

        function managebedit(e) {
            let send = `mbkedit=${e.currentTarget.dataset.edit}`;
            xttpreq("methods2/managebookui.php", send, editmanagemodalitem);
            editmanagemodal.classList.add("showmodalreg");
        }
        //update book from database
        function updatebook(e) {
            e.preventDefault();
            let uform = document.querySelector("#bookdataupdate");
            const formInputs = uform.getElementsByTagName("input");


            let formData = new FormData();
            for (let input of formInputs) {
                formData.append(input.name, input.value);
            }
            const bookimgfile = document.querySelector("#filebdataubook").files;

            if (bookimgfile.length > 0) {
                formData.append("file", bookimgfile[0]);

            }

            xttpreqformdata("methods2/managebookui.php", formData, "alert")
            setTimeout(() => {
                xttpreq("methods2/managebooks.php", "", managebook);
                editmanagemodal.classList.remove("showmodalreg");
            }, 1000);

        }
        //close in update modal
        function closeeditmodalbk(e) {
            e.preventDefault();
            editmanagemodal.classList.remove("showmodalreg");
        }

        //del manage book 
        function delfstage(e) {
            const confirmdelmbput = document.querySelector("#confirmationdelmb");
            let isbn = e.currentTarget.dataset.del;
            confirmdelmbput.dataset.del = isbn;
            confirmdelmb.classList.add("showmodalreg");
        }
        //close modal delete
        function closeconfirmdelmodal(e) {

            confirmdelmb.classList.remove("showmodalreg");
        }
        //for confirmation of delete
        function managebdel(e) {

            let send = `mbkdel=${e.currentTarget.dataset.del}`;

            xttpreq("methods2/managebookui.php", send, "alert");
            setTimeout(() => {
                xttpreq("methods2/managebooks.php", "", managebook);
                confirmdelmb.classList.remove("showmodalreg");
            }, 1000);


        }

        //membership approval
        const tabcon = document.querySelector(".tabcon");
        //xttp request forms 
        function xttpreqformdata(phpfilename, send, output) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", phpfilename, true);
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



        //modal manual entry lend to book user

        function lendshowmodal() {

            Swal.fire({
                title: 'Lookup User',
                text: 'Please enter the user System ID:',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Lookup',
                cancelButtonText: 'Cancel',
                showLoaderOnConfirm: true,
                preConfirm: (lendtoid) => {
                    // You can add input validation here if needed
                    const userId = <?php echo $UID; ?>;
                    const formData = new FormData();
                    formData.append('lendtouserid', lendtoid);
                    formData.append('userid', userId);
                    return fetch(`methods/manualentrylend.php`, {
                            method: 'POST',
                            body: formData,
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText);
                            }
                            return response.json(); // Assuming the response is JSON
                        }).then(response => {
                            console.log(response);
                            if (response.error !== null) {
                                throw new Error(response.error);
                            }
                            return response
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Lookup failed: ${error.message}`);
                        });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {

                    const {
                        data,
                        cart_count,
                        toLendId
                    } = result.value;

                    Swal.fire({
                        title: 'Confirm User',
                        html: `
                        Found User:<br>
                        Full Name: ${data.full_name}<br>
                        Student ID: ${data.student_id}<br>
                        <br>
                        Do you want to lend (${cart_count}) book(s) to this user?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Lend Books',
                        cancelButtonText: 'Cancel'
                    }).then((confirmation) => {
                        if (confirmation.isConfirmed) {
                            const userId = <?php echo $UID; ?>;
                            const formData = new FormData();
                            formData.append('lendtouserid', toLendId);
                            formData.append('userid', userId);
                            fetch('methods/confirmationlend.php', {
                                    method: 'POST',
                                    body: formData,
                                })
                                .then((response) => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json(); // Assuming the response is plain text
                                })
                                .then(response => {
                                    console.log(response);
                                    if (response.error !== null) {
                                        throw new Error(response.error);
                                    }
                                    return response
                                })
                                .then((res) => {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Your work has been saved',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    showallcollection();
                                })
                                .catch((error) => {
                                    console.error('Fetch error:', error);
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: error.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                });

                        }
                    });
                }
            });

        }



        //lend the books by getting the id of user then pass it to the borrowers transactions 
        function lendgetidconfirm(e) {
            console.log('confirming');
            e.preventDefault();
            const userSysId = confrmcontainer.dataset.uuserid;
            console.log(userSysId);
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "methods/confirmationlend.php", true);

            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status == 200) {
                    const res = xhr.responseText;
                    cartcontainer.innerHTML = res;
                    confrmcontainer.classList.remove("lendshowmodal");
                    console.log(res);
                    showallcollection();

                } else {
                    console.log("failed");
                }
            }
            xhr.send(`lendtouserid=${userSysId}&userid=<?php echo $UID ?>&confirm=ok`);

        }
        //searrching 
        function lendgetid(e) {
            console.log('searching');
            const userSysId = input;

            function sendLendingRequest(userSysId) {
                fetch(`methods/manualentrylend.php?lendtouserid=${userSysId}&userid=<?php echo $UID ?>`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Request failed with status: ${response.status}`);
                        }

                        confrmcontainer.innerHTML = response.text();
                        setTimeout(() => {
                            errorhandler.innerHTML = '';
                        }, 3000);
                        console.log(response.text());

                        const lenderror = document.querySelector(".lenderror");
                        errorhandler.innerHTML = lenderror.dataset.lenderr;
                        errval = lenderror.dataset.lenderr;

                        if (errval == "*") {
                            confrmcontainer.dataset.uuserid = userSysId;
                            confrmcontainer.classList.add("lendshowmodal");
                            lendmodalcontainer.classList.remove("lendshowmodal");
                        }

                        lendto.value = "";
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }


        }

        //navigations btrans and rtrans
        linkscontainer.addEventListener("click", onwhatlink);

        function onwhatlink(e) {
            console.log(e.target.dataset.nav);
            if (e.target.dataset.nav) {
                const btnlinks = Array.from(linkscontainer.children);

                btnlinks.forEach(e => {
                    e.classList.remove("active");
                });
                mains.forEach(e => {
                    e.classList.remove("activ");
                })
                e.target.classList.add("active");
                if (e.target.dataset.nav == "btrans") {
                    showallcollection();
                    showcategories();
                    borrowtrans.classList.add("activ");
                } else if (e.target.dataset.nav == "rtrans") {
                    returntrans.classList.add("activ");
                    updateRecordStatus();
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
                    if (showandhide.innerText == 'View') {
                        showandhide.innerText = `Hide`;
                        cartcontainer.style.display = `grid`;

                    } else {
                        showandhide.innerText = `View`;
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
                }
            }
        });

        //removing selected items from cart function
        function getallchecks() {

            const checkbox = Array.from(document.querySelectorAll(".selectcheck"));
            console.log(checkbox);
            console.log(checkbox.length);
            //get all checked items
            let newarray = checkbox.reduce((total, item) => {
                if (item.checked) {
                    total.push((item.value));
                }
                return total;
            }, [])

            const multiDelFunc = (newarray, userid) => {
                const params = `deleteitemsfromcart=${JSON.stringify(newarray)}&userid=${userid}`;
                const xhrs = new XMLHttpRequest();
                xhrs.open("POST", "methods/deletemultiple.php", true);

                xhrs.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                xhrs.onload = function() {
                    if (xhrs.status == 200) {
                        const res = xhrs.responseText;

                        cartcontainer.innerHTML = res;

                    } else {
                        console.log("failed");
                    }
                }
                xhrs.send(params);
            }

            if (newarray.length > 0) {
                console.log(checkbox.length + "true");

                console.log(newarray);
                showAlert2(true, "System Message: Items Removed: " + newarray.length + " books have been successfully removed from your cart.", "multiDelete", {
                    multiDelFunc,
                    params: {
                        newarray,
                        userid
                    }
                });

            }



        }
    </script>
    </body>

    </html>