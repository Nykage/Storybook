<?php
require './views/partials/admin_head.php';
if(isset($message)) echo $message;
?>

<form method="post">
        
    <p>
    <label for="headline">* Otsikko</label><br>
    <input type="text" name="headline" 
    value="<?php if(isset($story[0])) echo $story[0]->headline;?>">
    </p>

    <p>
    <label for="article">* Teksti</label><br>
    <textarea name="article" cols="45" rows="5"><?php if(isset($story[0])) echo $story[0]->article;?>
    </textarea>
    </p>

    <p>
    <label for="hidedate">Poistamispvm (jos et aseta päiväystä, poistuu kahden viikon kuluttua)</label><br>
    <input type="date" name="hidedate" 
    value="<?php if(isset($story)) echo $story[0]->hidedate;?>"><br>

    <input type="hidden" name="id"
    value="<?php if(isset($story[0])) echo $story[0]->story_id;?>">
    
    <p>
    <input class="button" type="submit" value="Muokkaa juttua" name="submitbutton">
    </p>
        
</form>