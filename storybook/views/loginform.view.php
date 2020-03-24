<?php
require './views/partials/head.php';
?>

<form action="/login/" method="post">
<h2>Kirjaudu</h2>
<?php if(isset($message)) echo $message;?>
<p>
<label for="account_name">Käyttäjätunnus</label><br>
<input type="text" name="account_name"><br>
</p>

<p>
<label for="password">Salasana</label><br>
<input type="password" name="password"><br>
</p>

<p>
<input class="button" type="submit" value="Kirjaudu">
</p>
</form>


<?php
require './views/partials/end.php';
?>