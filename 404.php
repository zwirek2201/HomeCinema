<?php
ob_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
include ("dolaczenia/kod_html.php");
?>
<html lang="pl">
    <head>
        <title>Strona glowna</title>
        <link rel="stylesheet" href="css/glowny.css"/>
        <link rel="stylesheet" href="css/formy.css"/>
        <link rel="stylesheet" href="css/mod_seanse.css"/>
    </head>
    <body>
        <?php echo '<center>'; Wiadomosc(); echo '</center>'; ?>
        <div id="wrapper">
        <?php
        Naglowek();      
        ?>
        <center>
        <div style="
        width: 100%; 
        float: left; 
        background-color: #006699;    
        margin-top: 10px;
        margin-bottom: 10px;
        padding: 5px;
        display: block;
        border-radius: 7px;
        -moz-border-radius: 7px;
        -webkit-border-radius: 7px;
	    box-shadow: 5px 5px 15px #A0A0A0;
	    -moz-box-shadow: 5px 5px 15px #A0A0A0;
	    -webkit-box-shadow: 5px 5px 15px #A0A0A0;" >
        <p class="tekst_potwierdzenia">Strona nie zostala znaleziona</p><br />
        </div>
        </center>
        </div>
    </body>
</html>
<?php
ob_end_flush();
?>