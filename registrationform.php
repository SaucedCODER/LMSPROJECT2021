<?php
error_reporting(0);
include "connection/oopconnection.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title></title>
</head>
<style media="screen">
  * {
    margin: 0;
    padding: 0;

    font-family: sans-serif;
  }

  body {
    height: 100vh;
    margin: 0;
    display: grid;
    place-items: center;
    background: #222;
  }

  .form-container {
    font-size: 1em;
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-auto-rows: minmax(auto, 60px);
    padding: 50px;
    color: white;
    background-color: #222;
    text-align: start;
    width: 50vw;
    height: 60vh;

  }

  .form-container input {
    background-color: transparent;
    color: whitesmoke;
    padding: .5em;
    border: 1px grey solid;
    margin: 2px;
  }

  .bordermalupet {
    padding: 1rem;
    position: relative;
    background: linear-gradient(to right, rgb(245, 32, 35), teal);
    padding: 3px;
    z-index: 3;

  }

  .gender {
    display: flex;
    align-items: center;
    color: gray;
    margin: 2px;
  }

  h1 {
    background-color: #222;
    text-align: center;
    color: grey;
    padding-top: 1em;
  }

  a {
    text-decoration: none;
    color: white;
  }

  .btnsl {
    background-color: transparent;
    width: 100%;
    padding: .5em;
    color: white;
    cursor: pointer;
    border: none;
  }

  .btnsl:hover {
    background-color: grey;
    color: white;
  }

  .btnlog-container {
    margin-top: 2em;
    grid-column: 2 / 3;
    display: flex;
    height: 50px;
    background-color: transparent;
    border: 2px solid grey;
  }

  .createup {
    grid-column: 1 / -1;
    padding: 1em;
  }

  .cup {
    grid-column: 1 / -1;
  }
</style>


<body>
  <div class="bordermalupet">
    <h1>Sign up For Free!</h1>

    <form class="form-container" action="signupforfree.php" method="post">
      <input type="text" name="first" autocomplete="off" placeholder="First Name" value='<?= $_GET["first"]; ?>' required>
      <input type="text" name="last" autocomplete="off" placeholder="Last Name" value='<?= $_GET["last"]; ?>' required>
      <input type="email" name="email" autocomplete="off" placeholder="G-mail" value='<?= $_GET["email"]; ?>' required>
      <input type="text" name="resad" autocomplete="off" placeholder="Residence Adress" value='<?= $_GET["resad"]; ?>' required>
      <input type="text" name="OfficialAdress" autocomplete="off" placeholder="OfficialAdress" value='<?= $_GET["OfficialAdress"]; ?>' required>
      <input type="text" name="Mobile_no" autocomplete="off" placeholder="Mobile_no" value='<?= $_GET["Mobile_no"]; ?>' required>
      <input type="text" name="Landlineno" autocomplete="off" placeholder="Landlineno" value='<?= $_GET["Landlineno"]; ?>' required>
      <div class="gender" data-gender='<?php $_GET['gender'] ?>'>
        Male
        <input id='male' type="radio" name="gender" value="male" autocomplete="off" required>
        Female
        <input id='female' type="radio" name="gender" value="female" autocomplete="off" required>
      </div>
      <div class="createup"></div>
      <input class="cup sid" type="text" autocomplete="off" name="uid" placeholder="Student ID." value='<?= $_GET["uid"]; ?>' required>
      <input class="cup cuper" type="password" autocomplete="off" name="pwd" placeholder="New Password" value='<?= $_GET["pwd"]; ?>' required>
      <input class="cup cuper" type="password" name="pwd-repeat" placeholder="Confirm password" value='<?= $_GET["pwd-repeat"]; ?>' required>
      <div class="btnlog-container">
        <button type="submit" name="submit-signup" class="signbtn btnsl">SIGNUP</button>
        <button class="logbtn btnsl"><a href="/">Go Back to Home Page</a></button>

      </div>
      </table>
    </form>
  </div>

</body>
<?php if (isset($_GET['gender'])) {
?>

  <script>
    const inputs = document.querySelectorAll("input");

    const whatgender = document.querySelector(".gender");
    const malex = document.querySelector("#male");
    const femalex = document.querySelector("#female");
    const error = document.querySelectorAll(".cuper");

    error.forEach(e => {
      e.style.border = "2px solid red";

    })

    if (whatgender.dataset.gender == "male") {
      malex.checked = true;

    } else {
      femalex.checked = true;
    }
    inputs.forEach(e => {
      if (e.value.length > 0) {
        e.style.border = "2px solid teal";

      } else {
        e.style.border = "2px solid red";

      }
    })

    <?php
    if ($_GET['error'] == "pwdnotmatch") {
    ?>
      alert('PASSWORD NOT MATCH!!');

    <?php
    } else {
    ?>
      alert('INVALID STUDENT ID!!');

    <?php
    } ?>
  </script>
<?php } ?>


</html>