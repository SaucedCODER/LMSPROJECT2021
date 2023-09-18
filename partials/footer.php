<?php

// Access the stored username
$isAdminMem = ($_SESSION['userRole'] == 'admins.php' || $_SESSION['userRole'] == 'members.php');;
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.28/dist/sweetalert2.all.min.js" integrity="sha256-Cci6HROOxRjlhukr+AVya7ZcZnNZkLzvB7ccH/5aDic=" crossorigin="anonymous"></script>
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