<?php

echo '<div class="form-group">
        <label>Gender:</label>
        <input type="radio" name="gender" value="Male"> Male
        <input type="radio" name="gender" value="Female"> Female<br>';

if ((isset($_SESSION["signup_data"]["gender"]) &&
  isset($_SESSION["errors_signup"]["empty_gender"]))) {
  echo   '<small>' . $_SESSION["errors_signup"]["empty_gender"] . '</small>';
}

echo '</div>';
