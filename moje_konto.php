<?php
ob_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
include ("dolaczenia/kod_html.php");

if (!isset($_SESSION['login']))
{
    header('Location: index.php');
}
?>
<html lang="pl">
    <head>
        <title>Moje konto</title>
        <link rel="stylesheet" href="css/glowny.css"/>
        <link rel="stylesheet" href="css/formy.css"/>
        <link rel="stylesheet" href="css/moje_konto.css"/>
    </head>
    <body>
        <?php echo '<center>'; Wiadomosc(); echo '</center>'; ?>
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
        Premiery(4,false);
        Filmy(4,true);
        ?>
        </div>
    </body>
</html>
<?php
ob_end_flush();
?>