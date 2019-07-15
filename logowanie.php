<?php
ob_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();

include ("dolaczenia/kod_html.php");
if(isset($_SESSION['login']))
{
    header('Location: moje_konto.php');
}

$error = array();
if (isset($_POST['loguj']))
{
    //Poprawnosc loginu
    if(empty($_POST['login']))
    {
        $error[] = 'Uzupełnij login!';
    }
    else
    {
        $login = $_POST['login'];
    }
    
    //Poprawnosc hasla
    if(empty($_POST['haslo']))
    {
        $error[] = 'Uzupełnij hasło!';
    }
    else
    {
        $haslo = md5(mysql_real_escape_string($_POST['haslo']));
    }
    
    if(empty($error))
    {
        $polaczenie = Polaczenie();
        $sql = "select * from uzytkownicy where Login = '$login' and Haslo = '$haslo'";
        $wynik = $polaczenie -> query($sql);
        
        if(mysqli_num_rows($wynik) == 0)
        {
            $sql2 = "select * from uzytkownicy_tymczasowi where Login = '$login' and Haslo = '$haslo'";
            $wynik2 = $polaczenie -> query($sql2);
            
            if(mysqli_num_rows($wynik2) == 0)
            {
                $error_message = '<span class="error">Login lub hasło niepoprawne!</span></br></br>';
            }
            else
            {
                $error_message = '<span class="error">Konto nie jest aktywne!</span></br></br>';
            }
            
        }
        else
        {
            while($rekord = $wynik ->fetch_assoc())
            {
                $_SESSION['login'] = $rekord['ID_Uzytkownika'];
                Header('Location: moje_konto.php');
            }
        }
    }
    else
    {
        $error_message = '<span class="error">';
        foreach ($error as $key => $values)
        {
            $error_message.= "$values</br>";
        }
        $error_message.= '</span></br>';
    }
}
?>
<html lang="pl">
    <head>
        <title>Logowanie</title>
        <link rel="stylesheet" href="css/glowny.css"/>
        <link rel="stylesheet" href="css/formy.css"/>
        <link rel="stylesheet" href="css/rejestracja.css"/>
    </head>
    <body>
        <?php echo '<center>'; Wiadomosc(); echo '</center>'; ?>
        <div id="wrapper">
        <?php
        Naglowek();
        ?>
            <aside id="left_side">
                <img src="obrazy/rejestracja_baner.jpg" width="420"/>
            </aside>
            <section id="right_side">
                <form id="generalform" class="container" method="post" action="">
                    <h3>Zaloguj sie:</h3>
                    <?php echo $error_message;?>
                    <div class="field">
                        <label for="nazwa_uzytkownika">Login:</label>
                        <input type="text" class="input" id="login" name="login" maxlength="20" <?php echo 'value="' . $_POST['login'] . '"'; ?>/>
                    </div>
                    <br />
                    <div class="field">
                        <label for="haslo">Hasło:</label>
                        <input type="password" class="input" id="haslo" name="haslo" maxlength="20"/>
                    </div>
                    <input type="submit" class="button" value="Loguj!" name="loguj"/>
                </form>
            </section>
        </div>
    </body>
</html>
<?php
ob_end_flush();
?>