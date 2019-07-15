<?php
ob_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
if(isset($_SESSION['login']))
{
    header('Location: moje_konto.php');
}
include ("dolaczenia/kod_html.php");

$error = array();
if (isset($_POST['rejestruj']))
{
    //Poprawnosc loginu
    if(empty($_POST['login']))
    {
        $error[] = 'Uzupełnij login!';
    }
    else if(!ctype_alnum($_POST['login']))
    {
        $error[] = 'Niepoprawny format loginu!';
    }
    else
    {
        $login = $_POST['login'];
    }
    
    //Poprawnosc adresu e-mail
    if(empty($_POST['e_mail']))
    {
        $error[] = 'Uzupełnij adres e-mail!';
    }
    else if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$_POST['e_mail']))
    {
        $email = mysql_real_escape_string($_POST['e_mail']);
    }
    else
    {
        $error[] = 'Niepoprawny format adresu e-mail!';
    }
    
    //Poprawnosc hasla
    if(strlen($_POST['haslo']) < 10)
    {
        $error[] = 'Hasło musi mieć co najmniej 10 znaków!';
    }
    else
    {
        $haslo = md5(mysql_real_escape_string($_POST['haslo']));
    }
    
    if(empty($error))
    {
        $polaczenie = Polaczenie();
        $sql = "select * from uzytkownicy where Email = '$email' or Login = '$login'";
        $wynik = $polaczenie -> query($sql);
        
        if(mysqli_num_rows($wynik) == 0)
        {
            $kod_aktywacyjny = md5(uniqid(rand(),true));
            //Baza danych
            $sql2 = "insert into uzytkownicy_tymczasowi (ID_Uzytkownika_tymczasowego,Login,Email,Haslo,Kod_aktywacyjny) values('','$login','$email','$haslo','$kod_aktywacyjny')";
            $wynik2 = $polaczenie -> query($sql2);
            
            //E-mail z kodem aktywacyjnym          
            $subject = 'Home Cinema: Potwierdzenie rejestracji';
            $headers = 'From: projekt.home.cinema@gmail.com' . "\r\n" .
            'Reply-To: projekt.home.cinema@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

            $tekst_wiadomosci = "Aby aktywować konto, kliknij w następujący link: \n\n";
            $tekst_wiadomosci .= "http://localhost/PROJEKT/aktywacja.php?email=$email&kod=$kod_aktywacyjny";
            
            mail($email, $subject, $tekst_wiadomosci, $headers);
            header('Location: index.php?wiadomosc=1');  
    }
    else
    {
        $error_message = '<span class="error">Użytkownik o podanym loginie lub adresie e-mail już istnieje! </span></br></br>';
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
        <title>Rejestracja</title>
        <link rel="stylesheet" href="css/glowny.css"/>
        <link rel="stylesheet" href="css/formy.css"/>
        <link rel="stylesheet" href="css/rejestracja.css"/>
    </head>
    <body>
        <?php Wiadomosc(); ?>
        <div id="wrapper">
        <?php
        Naglowek();
        ?>
            <aside id="left_side">
                <img src="obrazy/rejestracja_baner.jpg" width="420"/>
            </aside>
            <section id="right_side">
                <form id="generalform" class="container" method="post" action="">
                    <h3>Zarejestruj sie:</h3>
                    <?php echo $error_message;?>
                    <div class="field">
                        <label for="nazwa_uzytkownika">Login:</label>
                        <input type="text" class="input" id="login" name="login" maxlength="20" <?php echo 'value="' . $_POST['login'] . '"'; ?>/>
                        <p class="hint">Maksimum 20 znaków (litery i cyfry)</p>
                    </div>
                    <br />
                    <div class="field">
                        <label for="e_mail">Adres e-mail:</label>
                        <input type="text" class="input" id="e_mail" name="e_mail" maxlength="50" <?php echo 'value="' . $_POST['e_mail'] . '"'; ?>/>
                    </div>
                    <br />
                    <div class="field">
                        <label for="haslo">Hasło:</label>
                        <input type="password" class="input" id="haslo" name="haslo" maxlength="20"/>
                        <p class="hint">Minimum 10 znaków</p>
                    </div>
                    <input type="submit" class="button" value="Rejestruj!" name="rejestruj"/>
                </form>
            </section>
        </div>
    </body>
</html>
<?php
ob_end_flush();
?>