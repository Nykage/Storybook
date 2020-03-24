<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/storybook/views/partials/head.php';

if(isset($message)) echo $message;

if(!empty($stories)) {
    foreach($stories as $story) {?>
        <h1><a href="./story/
        <?=$story->story_id ?>
        ">
        <?=$story->headline ?></a></h1>
        <h2><?=$story->published ?></h2>
        <h2><?=$story->account_name ?></h2>
        <p><?=$story->article ?></p>    
        <?php    
    }
}

require_once $_SERVER['DOCUMENT_ROOT'].'/storybook/views/partials/end.php';
?>