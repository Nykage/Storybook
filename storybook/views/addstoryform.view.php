<?php
require './views/partials/admin_head.php';
if(isset($message)) echo $message;
?>

<form method="post">
    
    <p>
    <label for="headline">Otsikko </label><br>
    <input type="text" name="headline" 
    value="<?php if(isset($_POST["headline"])) echo $_POST["headline"];?>"
    required>
    </p>

    <p>
    <label for="hidedate">Poistuu näkyvistä </label><br>
    <input type="date" name="hidedate" 
    value="<?php if(isset($_POST["hidedate"])) echo $_POST["hidedate"];?>">
    </p>

    <p>
    <label for="article">Sisältö </label><br>
    <textarea rows="12" cols="50" name="article" 
    value="<?php if(isset($_POST["article"])) echo $_POST["article"];?>"
    required></textarea>
    </p>

    <p><input type="hidden" value="<?= $id?>" name="account_id">

    <p>
    <input class="button" type="submit" value="Lisää juttu">
    </p>
    
    </form> 



<?php    
require './views/partials/admin_end.php';
?>