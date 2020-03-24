<?php
require "./database/db.php";

$sql ="CREATE TABLE IF NOT EXISTS users (
  account_id int(10) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  last_name varchar(30),
  first_name varchar(30),
  account_name varchar(255) NOT NULL,
  account_passwd varchar(255) NOT NULL,
  account_reg_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  account_enabled tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$statement = $db->query($sql);
if($statement!=FALSE) echo "Taulu users lisätty!<br>";


$sql ="CREATE TABLE IF NOT EXISTS account_sessions (
  session_id varchar(255) PRIMARY KEY NOT NULL,
  account_id int(10) UNSIGNED NOT NULL,
  login_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

$statement = $db->query($sql);
if($statement!=FALSE) echo "Taulu sessions lisätty!<br>";

$sql = "CREATE TABLE IF NOT EXISTS stories (
   story_id int(10) AUTO_INCREMENT PRIMARY KEY NOT NULL,
   headline varchar(100),
   article text,
   hidedate date NOT NULL,
   published date,
   account_id int(10)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

$statement = $db->query($sql);
if($statement!=FALSE) echo "Vierasavain on lisätty!<br>";

   
   
$sql="ALTER TABLE stories ADD CONSTRAINT foreigner FOREIGN KEY (account_id) REFERENCES users(account_id)";
$statement = $db->query($sql);
if($statement!=FALSE) echo "Vierasavain on lisätty!<br>";
?>