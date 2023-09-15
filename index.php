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


<!-- bookmodal -->

<div class="viewbookcontainer"></div>

<script src="./js/jsLoginFunc.js" defer></script>


<?php
include './partials/footer.php'
?>

</body>

</html>