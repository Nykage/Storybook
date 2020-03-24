<?php
require './views/partials/admin_head.php';
if(isset($message)) echo $message;
if(!empty($stories)) {
    
    foreach($stories as $story) {?>
    <h1><a href="/adminstory/
    <?=$story->story_id ?>
    ">
    <?=$story->headline ?></a></h1>
    <h2><?=$story->published ?></h2>
    <p><?=$story->article ?></p>
    <p><a href="/editstory/<?=$story->story_id?>">Muokkaa</a></p>
    <p><a href="/deletestory/<?=$story->story_id?>">Poista</a></p>
    <?php
    }
}

require './views/partials/admin_end.php';
?>