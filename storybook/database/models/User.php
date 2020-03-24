<?php
// Modified from https://alexwebdevelop.com/user-authentication/
class User {
    
    private $id; //KIRJAUTUNEEN KÄYTTÄJÄN id TAI null
    private $name; //Kirjautuneen käyttäjän account_name tai NULL
    private $last_name;
    private $first_name;
    private $account_passwd;
    
    public function __construct() // Alustetaan arvoiksi NULL
    {
        $this->id = NULL;
        $this->name = NULL;
        $this->last_name = NULL;
        $this-> first_name = NULL;
    }

    public function __destruct() //tuhoaja - ei toteutettu
    {
        
    }    

    public function addAccount(string $last_name,string $first_name,string $name, string $passwd): int
    {
        global $db;
        
        if (!is_null($this->getIdFromName($name,$db))) //tarkistaa, ettei kenelläkä'än muulla ole samaa nimeä
        {
            throw new Exception('User name not available');
        }

        $sql = 'INSERT INTO users (last_name,first_name,account_name, account_passwd) VALUES (:last_name, :first_name, :name, :passwd)';
        $values = array(':last_name' => $last_name, ':first_name' => $first_name, ':name' => $name, ':passwd' => $passwd);
        try
        {
            $res = $db->prepare($sql);
            $res->execute($values);
        }
        catch (PDOException $e) //If there is a PDO exception, throw a standard exception
        {
           throw new Exception('Database query error');
        }
        return $db->lastInsertId();        //palauttaa uuden id:n
    }
    
    
    public function getIdFromName(string $name): ?int  //jos jollakulla käyttäjällä on sama nimi, palauttaa sen id:n, muuten NULL
    {
        global $db;
                
        $id = NULL;/* Alustaa palautusarvon - jos ei onnistu, palauttaa NULL */
    
        $query = 'SELECT account_id FROM users WHERE (account_name = :name)';//    Hakee ID:tä
        $values = array(':name' => $name);
        try
        {
            $res = $db->prepare($query);
            $res->execute($values);
        }
        catch (PDOException $e) // jos tulee virhe, palauttaa standardi-ilmoituksen
        {
           throw new Exception('Database query error');
        }
        $row = $res->fetch(PDO::FETCH_ASSOC);

        if (is_array($row)) //         There is a result: get it's ID 
        {
            $id = intval($row['account_id'], 10);
        }
        return $id;
    }

    public function login(string $name, string $passwd): bool
    {
        global $db;
                
        /* Look for the account in the db. Note: the account must be enabled (account_enabled = 1) */
        $query = 'SELECT * FROM users WHERE (account_name = :name) AND (account_enabled = 1)';
        
        /* Values array for PDO */
        $values = array(':name' => $name);
        try
        {
            $res = $db->prepare($query);
            $res->execute($values);
        }
        catch (PDOException $e)
        {
           /* If there is a PDO exception, throw a standard exception */
           throw new Exception('Database query error');
        }
        
        $row = $res->fetch(PDO::FETCH_ASSOC);
        
        /* If there is a result, we must check if the password matches using password_verify() */
        if (is_array($row))
        {
            if (password_verify($passwd, $row['account_passwd']))
            {
                /* Authentication succeeded. Set the class properties (id and name) */
                $this->id = intval($row['account_id'], 10);
                $this->name = $name;
                
                /* Register the current Sessions on the database */
                $this->registerLoginSession($db);
                
                /* Finally, Return TRUE */
                return TRUE;
            }
        }
        /* If we are here, it means the authentication failed: return FALSE */
        return FALSE;
    }

    /* Saves the current Session ID with the account ID */
    private function registerLoginSession($db)
    {
        /* Check that a Session has been started */
        if (session_status() == PHP_SESSION_ACTIVE)
        {
            /* Poista vanha istunto, jolla on sama id kuin nykyisellä*/
            $query = 'DELETE FROM account_sessions WHERE (session_id =:sid)';
            $values = array(':sid' => session_id());
            try
            {
                $res = $db->prepare($query);
                $res->execute($values);
            }
            catch (PDOException $e)
            {
               throw new Exception('Database query error');
            }
            /* Lisää nykyisen istunnon id*/
            $query = "INSERT INTO account_sessions(session_id, account_id) VALUES (:sid, :id)";
            $values = array('sid' => session_id(),':id' =>$this->id);
            try
            {
                $res = $db->prepare($query);
                $res->execute($values);
            }
            catch (PDOException $e)
            {
               throw new Exception('Database query error');
            }
        }
    }

    public function logout()
    {
        global $db;
        
        if (session_status() == PHP_SESSION_ACTIVE)
        {
            /* Delete query */
            $query = 'DELETE FROM account_sessions WHERE (session_id = :sid)';
            $values = array(':sid' => session_id());
            try
            {
                $res = $db->prepare($query);
                $res->execute($values);
            }
            catch (PDOException $e)
            {
               throw new Exception('Database query error');
            }
        }
        
        $this->id = NULL;
        $this->name = NULL;
    }

    public function sessionLogin()
    {
        global $db;
        
        if (session_status() == PHP_SESSION_ACTIVE)
        {
            $query = 
            
            "SELECT * FROM account_sessions, users WHERE (account_sessions.session_id = :sid) AND (account_sessions.login_time >= (NOW() - INTERVAL 7 DAY)) AND (account_sessions.account_id = users.account_id) AND (users.account_enabled = 1)";
            
            $values = array(':sid' => session_id());
            
            try
            {
                $res = $db->prepare($query);
                $res->execute($values);
            }
            catch (PDOException $e)
            {
               throw new Exception('Database query error');
            }
            
            $row = $res->fetch(PDO::FETCH_ASSOC);

            if (is_array($row))
            {
                /* Authentication succeeded. Set the class properties (id and name) and return TRUE*/
                $this->id = intval($row['account_id'], 10);
                $this->name = $row['account_name'];
                
                return TRUE;
            }
        }
        
        /* If we are here, the authentication failed */
        return FALSE;
    }

    public function getId()
    {
        return $this->id;
    }
}
?>