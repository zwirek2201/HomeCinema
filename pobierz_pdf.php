<?php
ob_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
if(isset($_GET['pdf']))
{
    include ("dolaczenia/kod_html.php");
    echo '
    <html>
    <head>
        <title>[MOD] Seanse</title>
        <link rel="stylesheet" href="css/rezerwuj.css"/>
        <link rel="stylesheet" href="css/glowny.css"/>
        <link rel="stylesheet" href="css/formy.css"/>
        <link rel="stylesheet" href="css/moje_konto.css"/>
        <link rel="stylesheet" href="css/mod_seanse.css"/>
    </head>
    <body>
        <div id="wrapper">
        ';
        Naglowek();
        echo '
            <aside id="main_aside">
             ';
        if(SprawdzRoleUzytkownika('Moderator') == true)
        {
        MenuModeratora();
        }
        MenuBoczne();
        echo '
        </aside>
             ';
    echo '
    <div id="pokazy_container">
    <center>
    <p class="potwierdzenie">Mozesz pobrac pdf<br><a target="_blank" href="pdf/index.php?pdf='. $_GET['pdf'] .'">TUTAJ</a></p>
    </center>
    </div>
    </div>
    </body>
    </html>
    ';
}
else
{
    header('Location: index.php');
}
ob_end_flush();
?>