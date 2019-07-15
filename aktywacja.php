<?php
ob_start();
include ("dolaczenia/kod_html.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
    if(isset($_SESSION['login']))
    {
        header('Location: moje_konto.php');
    }
    
    $polaczenie = Polaczenie();
    $sql = "select * from uzytkownicy_tymczasowi where Email = '" . $_GET['email'] . "' and Kod_aktywacyjny = '" . $_GET['kod'] . "'";
    $wynik = $polaczenie -> query($sql);
        
    if(mysqli_num_rows($wynik) == 0)
    {
        header('Location: index.php?wiadomosc=2');
    }
    else
    {
        while(($rekord = $wynik -> fetch_assoc()) != null)
        {
            $sql2 = "insert into uzytkownicy (ID_Uzytkownika, Login, Email, Haslo, Rola) values ('','" . $rekord['Login'] . "','" . $rekord['Email'] . "','" . $rekord['Haslo'] . "','Uzytkownik')";
            $sql3 = "delete from uzytkownicy_tymczasowi where Email = '" . $_GET['email'] . "' and Kod_aktywacyjny = '" . $_GET['kod'] . "'";
            $wynik2 = $polaczenie -> query($sql2);
            $wynik3 = $polaczenie -> query($sql3);
        }
        header('Location: logowanie.php?wiadomosc=8');
    }
    ob_end_flush();
?>
