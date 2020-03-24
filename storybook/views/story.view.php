<?php
require './views/partials/head.php';
?>

<h1><?=$story[0]->headline ?></h1>
<h2><?=$story[0]->published ?></h2>
<p><?=$story[0]->article ?></p>    
<?php    
require './views/partials/end.php';
?>