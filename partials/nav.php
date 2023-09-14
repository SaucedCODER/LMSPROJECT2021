<style>
    .modal-login {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.8);
        display: grid;
        place-items: center;
        transform: scale(0);
        z-index: 99;
    }

    .modal-login form {
        width: 150px;

        border: 1px solid hsl(0, 0%, 40%);

        background: hsl(0, 0%, 20%);

        outline: 2px solid hsl(0, 0%, 60%);

        /* #4 AND INFINITY!!! (CSS3 only) */
        box-shadow:
            0 0 0 5px hsl(0, 0%, 80%),
            0 0 0 8px hsl(0, 0%, 90%);
        background-color: rgba(0, 0, 0, 0.9);
        display: flex;
        width: 300px;
        height: 420px;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        align-items: center;

    }

    .modal-login form p {
        font-size: 35px;
        color: whitesmoke;
    }

    .fletter {
        font-size: 3rem;
        line-height: 70px;
        margin-right: 2px;
        color: blue;
    }


    .links-container {
        margin-left: auto;
    }

    .links-container a,
    .links-container button {
        text-decoration: none;
        font-size: 17px;
        font-weight: normal;
        color: whitesmoke;
        margin: 0em 1rem;
        position: relative;

    }

    .links-container a::before {
        content: '';
        height: 2px;
        background-color: whitesmoke;
        position: absolute;
        bottom: 0px;
        left: 0;
        right: 0;
        transform: scale(0);
        transition: all 170ms;

    }

    .links-container a:hover:not(.active)::before {
        transform: scale(1);
        background-color: #999;
    }

    .links-container a.actives::before {
        transform: scale(1);
    }



    /* show modal */
    .show-modal {
        transform: scale(1);
        transition: all 200ms;
    }
</style>

<div class="header-nav">
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>

    <nav class="navbar navbar-expand-md bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand fs-4 text-light" href="#">Library Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-1 links-container">
                    <li class="nav-item">
                        <a class="nav-link <?php if ($currentPage == 'index.php') echo "actives"; ?>" aria-current="page" href="index.php">Book Collection</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($currentPage == 'aboutus.php') echo "actives"; ?>" href="aboutus.php">About us</a>
                    </li>
                    <li class="nav-item">
                        <button type="submit" class="btn btn-primary loginbtn" name="submit-btn">Login <i class="bi bi-box-arrow-in-right ms-1 fs-5"></i></button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <div class="modal-login">

        <form action="loginlogic.php" method="post">
            <div style="color:yellowgreen;width:200px;"><span style="color:white;margin-right:2px;font-size:20px;">*</span><?php if (isset($_SESSION['message'])) {

                                                                                                                                echo $_SESSION['message'];
                                                                                                                            } ?></div>
            <p><span class="fletter">L</span>ogIn</p>
            <div class="form-floating  mb-3">
                <input type="text" autocomplete="off" name="username" class="form-control" id="floatingInput" placeholder="ex. 190123, 199999, 19****, etc." required pattern="^\S{5,}$" title="Username must be at least 5 characters long and should not contain spaces">
                <label for="floatingInput">Student ID</label>
            </div>
            <div class="form-floating">
                <input type="password" autocomplete="off" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>


            <div class="mt-3">
                <button type="submit" class="btn btn-primary" name="submit-btn">Submit</button>
                <button type="button" class="btn btn-secondary" id="close-login">Close</button>
            </div>


            <a href="registrationform.php" style="color:yellowgreen;margin-top:1em;">Click here to register</a>
        </form>

    </div>

</div>