<?php
class Story 
{
    private $story_id;
    private $headline;
    private $article;
    private $published;
    private $hidedate;

    
    public function __construct()
    {
        $this->story_id = NULL;
        $this->headline = NULL;
        $this->article = NULL;
        $this->published = NULL;
        $this->hidedate = NULL;
    }
    
    
    public static function get_last_five_stories_and_name()
    {
        global $db;
        
        try 
        {
            $statement = $db->prepare("SELECT stories.story_id,stories.headline,stories.article,stories.published,stories.hidedate,stories.account_id,users.account_name FROM stories INNER JOIN users ON stories.account_id= users.account_id ORDER BY stories.published desc LIMIT 5;");
            
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS);
        }
        catch (PDOException $e)
        {
              /* Exception (SQL error) */
              echo $e->getMessage();
              return FALSE;
        }    
     }


    public static function getStoryById($id)
    {
        global $db;
        
        try  {
            $statement = $db->prepare("SELECT * FROM stories WHERE story_id = ?");
            $statement->execute(array($id));
                    return $statement->fetchAll(PDO::FETCH_CLASS);
        }
        catch (PDOException $e)
        {
          /* Exception (SQL error) */
          echo $e->getMessage();
          return FALSE;
        }
    }

    public static function get_stories_by_id($id)
    {
        global $db;
        
        try 
        {
            $statement = $db->prepare("SELECT story_id,headline,article,published,hidedate FROM stories WHERE account_id = $id ORDER BY published desc;");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS);
        }
        catch (PDOException $e)
        {
          /* Exception (SQL error) */
          echo $e->getMessage();
          return FALSE;
        }    
    }

    //$data = array($headline,$article, $published,$hidedate)
    //tarkista ja anna kontrollerissa arvot
    public static function add_story($data)
    {
        global $db;
        
        try {
            $sql ="INSERT INTO stories(headline,article,hidedate,published,account_id) VALUES (?,?,?,?,?)";
            $statement=$db->prepare($sql);
            $statement->execute($data);
        }
        catch (PDOException $e)
        {
          echo $e->getMessage();
          return FALSE;
        }
        return TRUE;
    }

    public static function edit_story($data)
    {
        global $db;
        
        //Array of values for the PDO statement 
        $sql_vars = array();
        
        // Edit query 
        $sql = 'UPDATE stories SET ';

        if (!is_null($data["headline"]))
        {
          $sql .= 'headline = ?, ';
          $sql_vars[] = $data["headline"];
        }
        
        if (!is_null($data["article"]))
        {
          $sql .= 'article = ?, ';
          $sql_vars[] = $data["article"];
        }
        
        if (!is_null($data["hidedate"]))
        {
          $sql .= 'hidedate = ?, ';
          $sql_vars[] = $data["hidedate"];
        }
        
        $published = date('Y-m-j');
        $sql.= 'published = ?, ';
        $sql_vars[] = $published;
        
        $sql = mb_substr($sql, 0, -2) . ' WHERE (story_id = ?)';
        $sql_vars[] = $data["story_id"];
        
        if (count($sql_vars) == 0)
        {
          /* Nothing to change */
          return TRUE;
        }

        
        try
        {
          /* Execute query */
          $st = $db->prepare($sql);
          $st->execute($sql_vars);
        }
        catch (PDOException $e)
        {
          /* Exception (SQL error) */
          echo $e->getMessage();
          return FALSE;
        }
        
        /* If no exception occurs, return true */
        return TRUE;        
    }
    
    public static function delete_story($id)
    {
        global $db;
        
        try {
            $statement = $db->prepare("DELETE FROM stories WHERE story_id = ?");
            $statement->execute(array($id));
        }
        catch (PDOException $e)
        {
         /* Exception (SQL error) */
          echo $e->getMessage();
          return FALSE;
        }
        return TRUE;
    }
}
?>