<?php

// Access the stored username
$isAdminMem = $_SESSION['isAdminMem'];
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<!-- Scrollable modal -->

<?php if ($isAdminMem) {
    echo '
        <script src="./js/jsforloader.js" defer></script>
        ';
} else {
    echo '  <script src="./js/showalertlogin.js" defer></script>';
} ?>

<script src="./js/viewbookmodal.js" defer></script>

<script src="./js/jsaddtocart.js" defer></script>
<script src="./js/categoriesbutton.js" defer></script>
<script src="./js/search.js" defer></script>
<script src="./js/showcollection.js" defer></script>