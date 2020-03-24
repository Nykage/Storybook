<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Vieraskirja</title>

<meta name="keywords" content="sivukoe, CSS3, HTML5">
<meta name="author" content="Leena Järvenkylä-Niemi">
<meta name="description" content="Vieraskirja">
<link rel="stylesheet" type="text/css" href="<?= "/public/css/style.css" ?>">
</head>
<body>
<header>

<div id="kotisivulinkki">
<a class="kotilinkki" href="/admin/">vieraskirja - ylläpito</a>
</div>

<nav>
<a class="navilinkki" href="/addstory/">lisää juttu</a>
<a class="navilinkki" href="/edituser/<?= $user->getId();?>">muokkaa omia tietoja</a>
<a class="navilinkki" href="/editpassword/<?= $user->getId() ?>">vaihda salasana</a>
<a class="navilinkki" href="/logout/">kirjaudu ulos</a>
</nav>

</header><!--ylaosa loppuu-->

<div id="keskiosa">
<div id="teksti">