<?php
ob_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
if(isset($_SESSION['login']) == true)
{
    header('Location: moje_konto.php');
}
include ("dolaczenia/kod_html.php");
?>
<html lang="pl">
    <head>
        <title>Strona glowna</title>
        <link rel="stylesheet" href="css/glowny.css"/>
        <link rel="stylesheet" href="css/formy.css"/>
    </head>
    <body>
        <?php echo '<center>'; Wiadomosc(); echo '</center>'; ?>
        <div id="wrapper">
        <?php
        Naglowek();
        Premiery(5,false);
        Filmy(5,true)        
        ?>
        </div>
    </body>
</html>
<?php
ob_end_flush();
?>