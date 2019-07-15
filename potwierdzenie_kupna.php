<?php
ob_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
if($_SESSION['rezerwacja_w_toku'] == 0)
{
    header('Location: seans.php?id=' . $_POST['seans']);
}
include ("dolaczenia/kod_html.php");

?>
<html lang="pl">
    <head>
        <title>Potwierdzenie zakupu</title>
        <link rel="stylesheet" href="css/glowny.css"/>
        <link rel="stylesheet" href="css/formy.css"/>
        <link rel="stylesheet" href="css/rezerwuj.css"/>
    </head>
    <body>
        <?php echo '<center>'; Wiadomosc(); echo '</center>'; ?>
        <div id="wrapper">
        <?php
        Naglowek();
        PotwierdzenieKupna();
        ?>
        </div>
    </body>
</html>
<?php
ob_end_flush();
?>