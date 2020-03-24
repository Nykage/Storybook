<?php
//käytä AINA PDO ja prepare -yhdistelmää, estää SQL-injektiot

function sanitize($data) {
  $data = trim($data); //tyhjät pois
  $data = htmlentities($data, ENT_QUOTES, 'UTF-8'); //html-tagit merkkijonoiksi
  return $data;
}


/*vaihtoehto toki filter_var
function sanitize($data) {
    $data = trim($data);
    $data = filter_var($data,FILTER_SANITIZE_STRING));
    return $data;
}
*/

//boolean, palauttaa 1, jos päiväys on todellinen
function isRealDate($date) { 
    if (false === strtotime($date)) { 
        return false;
    } 
    list($year, $month, $day) = explode('-', $date); 
    return checkdate($month, $day, $year);
}

//ja jos päiväys on todellinen, tarkistaa, että se on tämän päivän jälkeen
function isValidDate($hidedate)
{
    if (isRealDate($hidedate)) {
        $hidedate =strtotime($hidedate);
        if($hidedate > time()) return TRUE;
        else return FALSE;
    }
    else {
        return FALSE;
    }
}
?>