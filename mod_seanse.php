<?php
ob_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
include ("dolaczenia/kod_html.php");
if (!isset($_SESSION['login']) or SprawdzRoleUzytkownika('Moderator') == false)
{
    header('Location: index.php');
}

?>
<html lang="pl">
    <head>
        <title>[MOD] Seanse</title>
        <link rel="stylesheet" href="css/glowny.css"/>
        <link rel="stylesheet" href="css/formy.css"/>
        <link rel="stylesheet" href="css/moje_konto.css"/>
        <link rel="stylesheet" href="css/mod_seanse.css"/>
    </head>
    <body>
        <div id="wrapper">
        <?php
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
        Seanse();
        ?>
        </div>
    </body>
</html>
<?php
ob_end_flush();
?>