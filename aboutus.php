<?php
session_start();


?>

<?php
include './partials/header.php'
?>
<?php
include './partials/nav.php'
?>

<div style="margin-left:2rem;">


    <h1>About us</h1>
    <h3>What is the purpose of library system? </h3>
    <p>Thus a library is also a system and its various sections/divisions are its components.</p>
    <p>The primary objective of any library system is to collect, store, organize, retrieve and make available the information sources to the information users.</p>


    <h2>Policy</h2>
    <h3> C. Policies
        The system will be operating under following policies:</h3>
    <p>1. Reservation Policy</p>
    <p>a. Only active members can make the reservation of the title</p>
    <p>b. Maximum of three books can be reserved by particular member, unless otherwise a new policy for allowable number of books to be borrowed is approved.</p>
    <p>c. Reservation is valid only for twenty-four (24) hours, unless otherwise a new policy on validity of reservation is approved.
    </p>
    <p>2. Borrowing Policy</p>
    <p>
        a. Only active members can borrow books</p>

</div>


<script src="./js/jsLoginFunc.js" defer></script>

<script>
    <?php
    if (!empty($_GET['action'])) {
        echo "stuckmodal();";
    } else if (isset($_SESSION['message'])) {
        echo "stuckmodal();";
    }
    ?>
</script>
<?php
include './partials/footer.php'
?>
</body>


</html>