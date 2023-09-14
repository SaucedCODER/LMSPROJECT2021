<?php
session_start();
?>
<?php
include './partials/header.php'

?>

<header>
    <?php
    include './partials/nav.php'
    ?>
    <div class="heading-text" style="padding:5rem 0; ">
        <h2 style="color:dodgerblue; margin:0;text-align:center;font-size:2.5rem;">Welcome to Our School Library</h2>
        <p style="color:#999;text-align:center;">Explore Our Books and Resources Today!</p>
    </div>
</header>



<section class="container px-2" style="margin:0 auto">

    <h1 class="fs-3">BOOK COLLECTION</h1>
    <div class="filtercontainer">
        <?php include './partials/Filterform.php'; ?>
        <!-- search field -->
    </div>
    <div class="btn-group container position-relative md-outline my-3 container-4categories overflow-hidden overflow-x-auto" role="group" aria-label="Basic radio toggle button group">
    </div>
    <div id="books-collection" class="my-3"></div>
</section>

<p class="trackcat" style="visibility:hidden;">All</p>
<!-- Scrollable modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Add to cart</button>
            </div>
        </div>
    </div>
</div>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch static backdrop modal
</button>
<!-- bookmodal -->
<style>
    .donthidemodal {
        transform: scale(1);

    }

    /* modal view books */
    .viewbookcontainer {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.8);
        display: none;
        place-items: center;
        z-index: 99;
    }

    .bookdata {
        background-color: whitesmoke;
        height: 80%;
        width: 80%;
        overflow: auto;
        padding: 2rem;
    }

    .bookdata h5 {
        display: inline;
        font-size: 1.5rem;
        font-family: sans-serif;
        font-weight: bold;
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

    .showmodalbk {
        display: grid;
    }
</style>
<div class="viewbookcontainer"></div>

<script src="./js/search.js" defer></script>
<script src="./js/jsLoginFunc.js" defer></script>

<script>
    <?php
    if (!empty($_GET['action'])) {
        echo "stuckmodal();";
    } else if (isset($_SESSION['message'])) {
        echo "stuckmodal();";
        unset($_SESSION['message']);
    }
    ?>


    // login modal codes ends

    //variable declaration
    const sections = document.querySelectorAll("section");
    const searchandreserve = document.querySelector(".search-reserve");
    const categoriescontainer = document.querySelector(".container-4categories");

    const collection = document.querySelector("#books-collection");


    //click outside other events function for closing of modals
    window.addEventListener('click', () => {

        droplistcontainer.style.display = "none";
    })
    showallcollection();
    //collection
    function showallcollection() {

        const xhr = new XMLHttpRequest();
        xhr.open("GET", "methods/showallbooks.php", true);
        xhr.onload = function() {
            if (xhr.status == 200) {
                const res = xhr.responseText;
                collection.innerHTML = res;
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

                    return `
  <input type="radio" class="btn-check" name="book-categories" id="${e}" autocomplete="off" ${e == 'All'?'checked':''}>
  <label class="btn btn-outline-dark text-nowrap" data-cat="${e}" for="${e}">${e}</label>`

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


        if (e.target.dataset.cat) {
            tracat.innerHTML = e.target.dataset.cat;
            const allbtncat = categoriescontainer.querySelectorAll("label");

            if (e.target.dataset.cat !== "All") {
                console.log('not all');

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
</script>

<?php
include './partials/footer.php'
?>

</body>

</html>