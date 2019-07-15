<?php
ob_start();
    include ("dolaczenia/kod_html.php");
    $polaczenie = Polaczenie();
    switch ($_POST['operacja'])
    {
        case 0:
            $sql = "update pokazy set Data = '". $_POST['data'] ."', Film = ". $_POST['film'] .", Sala = ". $_POST['sala'] .", Rodzaj_obrazu = '". $_POST['obraz'] ."', Rodzaj_dzwieku = '". $_POST['dzwiek'] ."' where ID_Pokazu = ". $_POST['pokaz'];
        break;
        case 1:
            $sql = "insert into pokazy values ('','" . $_POST['data'] . "','". $_POST['film'] ."','" . $_POST['sala'] . "','". $_POST['obraz'] ."','" . $_POST['dzwiek'] . "')";
        break;
    }
    $wynik = $polaczenie -> query($sql);
    header ('Location: mod_seanse.php');
    ob_end_flush();
?>