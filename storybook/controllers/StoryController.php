<?php

require './database/models/story.php';


class StoryController 
{
    protected $story;
    
    public function __construct()
    {
        $this->story = new Story();
    }
    
    public static function index()
    {
        $stories = Story::get_last_five_stories_and_name();
        require './views/index.view.php';
    }

    public static function readStory($id)
    {
        $story = Story::getStoryById($id);
        require './views/story.view.php';
    }
    
    public function admin($user)
    {
        $id = $user->getId();
        $stories = Story::get_stories_by_id($id);
        require './views/admin.view.php';
    }

    public function getAddStory($user)
    {
        $id = $user->getId();
        require './views/addstoryform.view.php';
    }
    
    public function postAddStory($user)
    {
        require './helpers/helper.php';
        $id = $user->getId();
        echo $id;

        if(isset($_POST['headline'],$_POST['article'])) {
            
            //Checking input
            $headline=sanitize($_POST['headline']);
            $article = sanitize($_POST['article']);
            if(isset($_POST['hidedate']) && isValidDate($_POST['hidedate'])) $hidedate=$_POST['hidedate'];
            else {
                $hidedate = strtotime(date('Y-m-j')) + 1209600;
                $hidedate = date('Y-m-j',$hidedate);
            }
            $published=date('Y-m-j');
            
            // and adding to database
            $data = array($headline,$article,$hidedate,$published,$id);
            if(Story::add_Story($data)) $message="Uusi juttusi on lisätty";
            
            // preparing the view
            $stories = Story::get_stories_by_id($id);
            require './views/admin.view.php';    
            }
            
        else { 
            $message = "Tarkista pakolliset kentät";
            require './views/addstoryform.view.php';
        }
    }

    public function getEditStory($id,$user)
    {
        $story = Story::getStoryById($id);
        require './views/editstoryform.view.php';
    }
    
    public function postEditStory($user)
    {
        $account_id = $user->getId();
        require './helpers/helper.php';
        
        if(isset($_POST['id'])) {
            
            //Checking input
            $story_id=$_POST["id"];
            
            if(isset($_POST["headline"])) $headline=sanitize($_POST['headline']);
            else $headline=NULL;
            
            if(isset($_POST["article"]))$article = sanitize($_POST['article']);
            else $article =NULL;
            
            if(isset($_POST['hidedate']) && isValidDate($_POST['hidedate'])) $hidedate=$_POST['hidedate'];
            else {
                $hidedate = strtotime(date('Y-m-j')) + 1209600;
                $hidedate = date('Y-m-j',$hidedate);
            }

            $published=date('Y-m-j');
            
            // and adding to database
            $data = array('story_id'=>$story_id, 'headline'=>$headline,'article'=>$article,'hidedate'=>$hidedate,'account_id'=>$account_id);
            if(Story::edit_story($data)) $message="Juttuasi on muutettu";
            
            // preparing the view
            $stories = Story::get_stories_by_id($account_id);
            require './views/admin.view.php';    
        }
            
        else { 
            $message = "Tarkista pakolliset kentät";
            require './views/addstoryform.view.php';
        }                
    }

    public static function deleteStory($id,$user)
    {
        if(Story::delete_story($id)) $message = "Juttu on poistettu";
        else $message ="Jutun poistaminen ei onnistu";

        // preparing the view
        $account_id = $user->getId();
        $stories = Story::get_stories_by_id($account_id);
        require './views/admin.view.php';
    }
}
?>