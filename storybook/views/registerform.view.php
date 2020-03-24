<?php
require './views/partials/head.php';
if(isset($warning)) echo $warning;
?>

<form method="post" action = "/register/">
    
    <p>
    <label for="first_name">Etunimi </label><br>
    <input type="text" name="first_name" 
    value="<?php if(isset($_POST["first_name"])) echo $_POST["first_name"];?>"
    required>
    </p>

    <p>
    <label for="last_name">Sukunimi </label><br>
    <input type="text" name="last_name" 
    value="<?php if(isset($_POST["last_name"])) echo $_POST["last_name"];?>"
    required>
    </p>

    <p>
    <label for="account_name">Käyttäjätunnus </label><br>
    <input type="text" name="account_name" 
    value="<?php if(isset($_POST["account_name"])) echo $_POST["account_name"];?>"
    required>
    </p>

    <p>
    <label for="password1">Salasana</label><br>
    <input type="password" name="password1"></p>

    <p><label for="password2">Salasana uudelleen </label><br>
    <input type="password" name="password2" required>
    </p>

    <p>
    <input class="button" type="submit" value="Rekisteröidy">
    </p>
    
    </form> 





<?php    
require './views/partials/end.php';
?>