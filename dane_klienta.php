<?php
ob_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
include ("dolaczenia/kod_html.php");

$_SESSION['rezerwacja_w_toku'] = 1;
?>
<html lang="pl">
    <head>
        <title>Rezerwacja</title>
        <link rel="stylesheet" href="css/glowny.css"/>
        <link rel="stylesheet" href="css/formy.css"/>
        <link rel="stylesheet" href="css/rezerwuj.css"/>
    </head>
    <body>
        <?php echo '<center>'; Wiadomosc(); echo '</center>'; ?>
        <div id="wrapper">
        <?php
        Naglowek();
        echo '<center>';
        Tabela_biletow();
        DaneUzytkownika();
        echo '</center>';
        ?>
        </div>
    </body>
</html>
<?php
ob_end_flush();
?>