<?php
// Access the stored username
$isAdminMem = ($_SESSION['userRole'] == 'admins.php' || $_SESSION['userRole'] == 'members.php');;
?>
<div class="offcanvas offcanvas-end e-cart" style='z-index:3000' id="cartCanvas" aria-labelledby="cartCanvasLabel">
</div>

<!-- jquery cdn Link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- bootstrap js cdn Link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<!--SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.28/dist/sweetalert2.all.min.js" integrity="sha256-Cci6HROOxRjlhukr+AVya7ZcZnNZkLzvB7ccH/5aDic=" crossorigin="anonymous"></script>
<!-- Data Table JS -->

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- Timepicker JS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- input mask JS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
<!-- dropzone file upload JS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<?php if ($isAdminMem) {
    echo '
        <script src="./js/jsforloader.js" defer></script>
        <script src="./js/jsCartFunc.js" defer></script>
        <script src="./js/jsDataTables.js" defer></script>
        <script src="./js/jsUtils.js" defer></script>
        <script src="./js/jsCRUDBooks.js" defer></script>
        <script src="./js/jsCRUDUsers.js" defer></script>
        ';
} else {
    echo '  <script src="./js/showalertlogin.js" defer></script>';
} ?>

<script src="./js/viewbookmodal.js" defer></script>
<script src="./js/categoriesbutton.js" defer></script>
<script src="./js/search.js" defer></script>
<script src="./js/showcollection.js" defer></script>
<script src="./js/jsaddtocart.js" defer></script>