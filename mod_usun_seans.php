<?php
ob_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
include ("dolaczenia/kod_html.php");
if ($_GET['o'] == 'true')
{
    UsunSeans($_GET['id']);
    header ('Location: mod_seanse.php');
}
else if ($_GET['o'] == 'false')
{
    header ('Location: mod_seanse.php');
}
?>
<html>
    <head>
        <title>[MOD] Usun seans</title>
        <link rel="stylesheet" href="css/glowny.css"/>
        <link rel="stylesheet" href="css/formy.css"/>
        <link rel="stylesheet" href="css/moje_konto.css"/>
        <link rel="stylesheet" href="css/mod_seanse.css"/>
    </head>
    <body>
        <div id="wrapper">
        <center>
        <?php
        $liczba_rezerwacji = 0;
        
        $polaczenie = Polaczenie();
        $sql = 'select count(Siedzenie) as Liczba from rezerwacje join szczegoly_rezerwacji on rezerwacje.ID_Rezerwacji = szczegoly_rezerwacji.Rezerwacja where rezerwacje.Pokaz = ' . $_GET['id'];
        $wynik = $polaczenie -> query($sql);
        
        echo '<div id="potwierdzenie_container">';
        
        while(($rekord = $wynik -> fetch_assoc()) != null)
        {
            $liczba_rezerwacji = $rekord['Liczba'];
        }
        
        if($liczba_rezerwacji == 0)
        {
            echo '
            <p class="tekst_potwierdzenia">Czy na pewno chcesz usunac ten seans?</p>
            <div>
            <center>
            <table style="width: 320px;">
            <tr>
            <td align="center"><a href="mod_usun_seans.php?id='. $_GET['id'] .'&o=true"><div class="potwierdzenie_przycisk"><p class="tekst_potwierdzenia">TAK</p></div></a></td>
            <td align="center"><a href="mod_usun_seans.php?id='. $_GET['id'] .'&o=false"><div class="potwierdzenie_przycisk"><p class="tekst_potwierdzenia">NIE</p></div></a></td>
            </tr>
            </table>
            </div>
            </div>
            </center>
            </div>
            ';
        }
        else
        {
            echo '
            <p class="tekst_potwierdzenia">Nie mozna usunac seansu, na ktory zarezerwowane sa miejsca ('. $liczba_rezerwacji . ')</p>
            <div>
            <a href="mod_seanse.php"><div class="potwierdzenie_przycisk"><p class="tekst_potwierdzenia">Powrot</p></div></a>
            </div>
            </div>
            ';
        }
    echo '
    </div>
    </body>
    </html>
    ';
ob_end_flush();
?>