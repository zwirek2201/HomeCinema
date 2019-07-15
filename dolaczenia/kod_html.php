<?php
$tabela = array();
$post_bilety = $_POST['siedzenia'];
$post_seans = $_GET['id'];
Bilety();

function Polaczenie()
{
    $polaczenie = new mysqli('localhost','root','','projekt_kino');
    return $polaczenie;
}
function Naglowek()
{ 
echo '
    <header id="main_header">
        <div id="rightAlign">
     ';   
Linki();
echo '
    </div>
    <a href="index.php"><img src="obrazy/logo.png" width="200"></a>
    </header>
    ';   
Wyszukiwarka();
}

function Linki()
{
    if ( !isset($_SESSION['login']))
    {
        echo '
            <a href="rejestracja.php">Zarejestruj</a> | <a href="logowanie.php">Zaloguj</a>
        ';
    }
    else
    {
        $polaczenie = Polaczenie();
        $sql = 'select Login from uzytkownicy where ID_Uzytkownika = ' . $_SESSION['login'];
        $wynik = $polaczenie -> query($sql);
        
        while(($rekord = $wynik -> fetch_assoc()) != null)
        {
            $login = $rekord['Login'];
        }
    if(SprawdzRoleUzytkownika('Moderator') == true)
    {
        echo '
        <a href="moje_konto.php"><b><font color="red">'.$login.'</font></b></a> | <a href="moje_bilety.php">Moje bilety</a> | Moje filmy | <a href="wyloguj.php">Wyloguj</a>
             '; 
    }
    else
    {
        echo '
        <a href="moje_konto.php"><b>'.$login.'</b></a> | <a href="moje_bilety.php">Moje bilety</a> | Moje filmy | <a href="wyloguj.php">Wyloguj</a>
             ';
    }

    }
}


function Wyszukiwarka()
{
    $tekst_wejsciowy = htmlentities($_GET['slowa_kluczowe']);
    
    echo "
        <div id=\"top_search\">
            <form name=\"wyszukiwarka\" action=\"404.php\" method=\"GET\">
                <input type=\"text\" id=\"slowa_kluczowe\" name=\"slowa_kluczowe\" size=\"100\" class=\"searchBox\" value=\"$tekst_wejsciowy\">
        &nbsp
    ";
 
 // Wybor kategorii
    $polaczenie = Polaczenie();
    $sql = 'select ID_Kategorii,Nazwa from Kategorie order by ID_Kategorii asc';
    $wynik = $polaczenie -> query($sql);

    echo '
        <select id="kategoria" name="kategoria" class="searchBox">
        <option value="0">Wszystkie kategorie</option>
    ';
    while(($rekord = $wynik -> fetch_assoc()) != null)
    {
        if ($rekord['ID_Kategorii'] = $_GET['Kategoria'])
        {
        echo '<option value="' . $rekord['ID_Kategorii'] . '" selected> ' . $rekord['Nazwa'] . '</option>';    
        }
        else
        {
        echo '<option value="' . $rekord['ID_Kategorii'] . '"> ' . $rekord['Nazwa'] . '</option>';
        }
    }
    
    echo '
        <input type="submit" value="Szukaj" class="button">
        </select>
        </form>
        </div>
        ';
        
}

function Wiadomosc()
{
    if (isset($_GET['wiadomosc']))
    {
        $polaczenie = Polaczenie();
        $sql = "select Tresc,Typ from wiadomosci where ID_Wiadomosci ='" . $_GET['wiadomosc'] . "'";
        $wynik = $polaczenie -> query($sql);

        while(($rekord = $wynik -> fetch_assoc()) != null)
        {
            switch ($rekord['Typ']) 
            {
                case 'Wiadomosc':
                    echo '</br><span class="page_message">' . $rekord['Tresc'] . '</span></br>';
                    break;
                case 'Blad':
                    echo '</br><span class="page_error">' . $rekord['Tresc'] . '</span></br>';
                    break;
            }
        }
    }
}

function MenuBoczne()
{
    echo '
            <div id="aside_container" class="uzytkownik">
            <h2>Filmy:</h2>
            <center>
                <div id="aside_section">
                    Premiery
                </div>
                <div id="aside_section">
                    Repertuar
                </div>
                <div id="aside_section">
                    Moje filmy
                </div>
            </center>
            </div>
            
            <div id="aside_container" class="uzytkownik">
            <h2>Bilety:</h2>
            <center>
                <div id="aside_section">
                    Rezerwuj bilety
                </div>
                <div id="aside_section">
                    Promocje
                </div>
                <div id="aside_section">
                    Moje bilety
                </div>
            </center>
            </div>
        
            <div id="aside_container" class="uzytkownik">
            <h2>Konto:</h2>
            <center>
                <div id="aside_section">
                    Ustawienia
                </div>
            </center>
            </div>
        ';
}

function Premiery($ilosc_kolumn, $pelny)
{
    $polaczenie = Polaczenie();
    $date = date('Y-m-d');
    $sql = 'select * from filmy where Data_premiery >= \''.$date.'\' order by Data_premiery asc';
    if($pelny == false)
    {
        $sql .= ' limit ' . $ilosc_kolumn;
    }
    $wynik = $polaczenie -> query($sql);
    if(mysqli_num_rows($wynik) > 0)
    {         
    echo '    
        <div id="color_container">
        <h3 class="premieres">Premiery</h3>
        <table>';
    while(($rekord = $wynik -> fetch_assoc()) != null)
    {
        if($licznik == 0)
        {
         echo '<tr>';   
        }
        echo'  
            <td align="center">      
            <a href="film.php?id='.$rekord['ID_Filmu'].'">
            <div id="premiere_container">  
            ';
            if(date_format(date_create($rekord['Data_premiery']),'Y-m-d') == $date)
            {
                echo '<h4 class="today">DZIS!</h4>';
            }
            else
            {
                echo '<h4>'.date_format(date_create($rekord['Data_premiery']),'d.m.Y').'</h4>';   
            }
            echo '<img src="obrazy/okladki/'.$rekord['Okladka'].'" class="poster"/>
            <br/>
            <h5>'.$rekord['Tytul'].'</h5>
            </div>
            </a>
            </td>';
            $licznik += 1;
        if($licznik == $ilosc_kolumn)
        {
            echo '</tr>';
            $licznik = 0;
        }
    }
    if(mysqli_num_rows($wynik) < $ilosc_kolumn)
    {
        for($i = 0; $i < $ilosc_kolumn - mysqli_num_rows($wynik); $i++)
        {
            echo '
            <td>
            <div id="premiere_placeholder"> 
            </div>
            </td>
            ';
        }
    }
    echo '
        </table>
        </div>
        ';
    }   
}
function Filmy($ilosc_kolumn, $pelny)
{
    $polaczenie = Polaczenie();
    $date = date('Y-m-d');
    $sql = 'select * from filmy where Data_premiery < \''.$date.'\' order by Data_premiery asc';
    if($pelny == false)
    {
        $sql .= ' limit ' . $ilosc_kolumn;
    }
    $wynik = $polaczenie -> query($sql);
    if(mysqli_num_rows($wynik) > 0)
    {         
    echo '    
        <div id="white_container">
        <h3 class="movies">Repertuar</h3>
        <table>';
    while(($rekord = $wynik -> fetch_assoc()) != null)
    {
        if($licznik == 0)
        {
         echo '<tr>';   
        }
        echo'  
            <td align="center">      
            <a href="film.php?id='.$rekord['ID_Filmu'].'">
            <div id="movie_container">  
            <img src="obrazy/okladki/'.$rekord['Okladka'].'" class="poster"/>
            <br/>
            <h5>'.$rekord['Tytul'].'</h5>
            </div>
            </a>
            </td>';
            $licznik += 1;
        if($licznik == $ilosc_kolumn)
        {
            echo '</tr>';
            $licznik = 0;
        }
    }
    if(mysqli_num_rows($wynik) < $ilosc_kolumn)
    {
        for($i = 0; $i < $ilosc_kolumn - mysqli_num_rows($wynik); $i++)
        {
            echo '
            <td>
            <div id="movie_placeholder"> 
            </div>
            </td>
            ';
        }
    }
    echo '
        </table>
        </div>
        ';
    }   
}

function SzczegolyFilmu()
{
    $polaczenie = Polaczenie();
    $sql = 'select * from filmy where ID_Filmu = ' . $_GET['id'];
    $wynik = $polaczenie -> query($sql);
        while(($rekord = $wynik -> fetch_assoc()) != null)
    {
    echo '
    <aside id="main_aside">
        <div id="photo_container">
            <img src="obrazy/okladki/'.$rekord['Okladka'].'" class="photo"/>
        </div>
    </aside>
    <div id="details_container">
    <h2>' . $rekord['Tytul'] . '</h2> 
    <h3 class="date">('. date_format(date_create($rekord['Data_premiery']),'Y') .')</3>
    <h3>' . $rekord['Podtytul'] . '</h3>
    <h4>' . $rekord['Opis'] . '</h4>
    <table>
    <tr>
    <th>rezyseria:</th>
    <td>
    <p class="nazwisko">'. $rekord['Rezyseria'] .'</p>
    </td>
    </tr>
    <tr>
    <th>scenariusz:</th>
    <td>
    <p class="nazwisko">'. $rekord['Scenariusz'] .'</p>
    </td>
    </tr>
    <tr>
    <th>gatunek:</th>
    <td>
    <p class="nazwisko">'; 
    Gatunki(); 
    echo'</p>
    </td>
    </tr>
    <tr>
    <tr>
    <th>premiera:</th>
    <td>
    <p class="nazwisko">'.date_format(date_create($rekord['Data_premiery']),'d.m.Y').'</p>
    </td>
    </tr>
    <tr>
    <th>produkcja:</th>
    <td>
    <p class="nazwisko">'. $rekord['Produkcja'] .'</p>
    </td>
    </tr>
    </table>
    </div>
    ';
}
}

function OcenionoFilm()
{
    $polaczenie = Polaczenie();
    if (isset($_GET['ocena']) == true)
    {
        if(isset($_SESSION['login']) == true)
        {
            $sql = 'select * from oceny_filmow where Film = ' . $_GET['id'] . ' and Uzytkownik = ' . $_SESSION['login'];
            $wynik = $polaczenie -> query($sql);
            if (mysqli_num_rows($wynik) > 0)
            {
                while(($rekord2 = $wynik -> fetch_assoc()) != null)
                    {
                        $ocena_aktualna = $rekord['Ocena'];
                    }
                    $sql = 'update oceny_filmow set Ocena = ' . $_GET['ocena'] . ' where Film = ' . $_GET['id'] . ' and Uzytkownik = ' . $_SESSION['login'];
                    $wynik = $polaczenie -> query($sql);   
            }
            else
            {
            $sql = 'insert into oceny_filmow values(\'\',' . $_GET['id'] . ',' . $_SESSION['login'] . ',' . $_GET['ocena'] . ')';
            $wynik = $polaczenie -> query($sql);
            }
        }
        else
        {
            header('Location: film.php?id=' . $_GET['id'] . '&wiadomosc=6');
        }
 
    }
}
function OcenyFilmu()
{
    $polaczenie = Polaczenie();
    $sql = 'select avg(ocena) as srednia, count(ocena) as liczba from oceny_filmow where Film = ' . $_GET['id'];
    $wynik = $polaczenie -> query($sql);
    $srednia_glosow = 0;
    $liczba_glosow = 0;
    while(($rekord = $wynik -> fetch_assoc()) != null)
    {
        $srednia_glosow = round($rekord['srednia'],1);
        $liczba_glosow = $rekord['liczba'];
    }
    if(isset($_SESSION['login']) == true)
    {   
        $sql = 'select Ocena from oceny_filmow where Film = ' . $_GET['id'] . ' and Uzytkownik = ' . $_SESSION['login'];
        $wynik = $polaczenie -> query($sql);
        $ocena_uzytkownika = 0;
        while(($rekord = $wynik -> fetch_assoc()) != null)
        {
            $ocena_uzytkownika = $rekord['Ocena'];
        }
    }
    echo '
    <div id="ratings_container">
    <p class="gwiazda">&#9733;</p>
    <p class="srednia">'. $srednia_glosow .'</p>
    <p class="liczba_glosow">('. $liczba_glosow .' glosow)</p>
    <center>
    <p class="ocen">Ocen film:</p>
    <table class="table_ocena">
    <tr>
    ';
    for($i = 1; $i <= 5; $i++)
    {
        $tekst = '<td align="center"><a href="film.php?id='. $_GET['id'] .'&ocena='. $i .'">';
        if ($ocena_uzytkownika == $i)
        {
            $tekst .= '<div id="ocena_zaznaczona">';
        }
        else
        {    
            $tekst .= '<div id="ocena">'; 
        }
            $tekst .= $i. '</div></a></td>';
        echo $tekst;
    }
    echo '
    </tr>
    </table>
    </center>
    </div>
    ';
}

function Gatunki()
{
$polaczenie = Polaczenie();
    $sql = 'select Kategorie.Nazwa from filmy_gatunki join Kategorie on filmy_gatunki.Kategoria = Kategorie.ID_Kategorii where Film = ' . $_GET['id'];
    $wynik = $polaczenie -> query($sql);
    $temp = 0;
    $gatunki = '';
    while(($rekord = $wynik -> fetch_assoc()) != null)
    {
        if($temp == 0)
        {
            $gatunki .= $rekord['Nazwa'];
            $temp = 1;
        }
        else
        {
            $gatunki .= ', ' . $rekord['Nazwa'];
        }
    }
    echo $gatunki;
}

function Tytul()
{
    $polaczenie = Polaczenie();
    $sql = 'select Tytul, Data_premiery from filmy where ID_Filmu = ' . $_GET['id'];
    $wynik = $polaczenie -> query($sql);
    while(($rekord = $wynik -> fetch_assoc()) != null)
    {
        echo $rekord['Tytul'] . ' (' . date_format(date_create($rekord['Data_premiery']),'Y') . ')';
    }
}

function Powrot($url)
{   echo '
    <div style="width: 1000px; height: 30px; float: left; margin-left: -10px;">
    <a href=" '. $url .'"><div class="button">Powrot</div></a>
    </div>
    ';
}

function Rezerwacje()
{
    $data = date('Y-m-d H:i'); 
    $polaczenie = Polaczenie();
    $sql = 'select * from pokazy join sale on pokazy.Sala = sale.ID_Sali where Film = ' . $_GET['id'] . ' and Data > \'' . $data . '\' order by Data';
    $wynik = $polaczenie -> query($sql);
    $pokazy = array();
    $daty = array();
    $daty_u = array();
    while(($rekord = $wynik -> fetch_assoc()) != null)
    {
        $data = date_format(date_create($rekord['Data']),'Y-m-d');
        $daty[] = (string)$data;
        $pokaz = new Pokaz($rekord['ID_Pokazu'],date_create($rekord['Data']),$rekord['Film'],$rekord['Numer_sali'],$rekord['Rodzaj_obrazu'],$rekord['Rodzaj_dzwieku']);
        $pokazy[] = $pokaz;
    }
    $daty_u = array_unique($daty);
    echo '<div id="reservation_container"><p class="tytul">Pokazy filmu:</p>';
    foreach ($daty_u as $data)
    { 
        $data = date_create($data);
        echo '<div id="day_container">
        <div id="date_container">'. date_format($data,'d.m.Y') .'</div>';
        foreach ($pokazy as $pokaz)
        {
            $data_baza = date_format($pokaz -> varData,'Y-m-d');
            $data_d = date_format($data,'Y-m-d');
            if($data_baza == $data_d)
            {
            echo '<div id="show_container" onmouseover="ScrollDown()">'. 
            date_format($pokaz -> varData,'H:i').'
            <div id="show_details">
                <p class="details_info">Sala '. $pokaz -> varSala .'</p>
                <p class="details_info">'. $pokaz -> varObraz .'</p>
                <p class="details_info">'. $pokaz -> varDzwiek .'</p>
            </div>
            <a href="seans.php?id='. $pokaz -> varID .'"><div id="reservation_button">Rezerwuj</div></a>
            </div>';
            }
        } 
        echo '</div>';
    }
    echo '</div>';
}

function Bilety()
{
global $tabela;
    $polaczenie = Polaczenie();
    $sql = 'select * from bilety';
    $wynik = $polaczenie -> query($sql);
    while(($rekord = $wynik -> fetch_assoc()) != null)
    {
        $tabela[] = array($rekord['ID_Biletu'],$rekord['Nazwa'],$rekord['Cena']);
    }
}
?>
<script type="text/javascript">
 var zarezerwowane = 0;
 var bilety = <?php echo json_encode($tabela); ?>;
function Siedzenie(sender)
{
    if(sender.className == "pelne")
    {
        if(zarezerwowane < 10)
        {
            sender.className = "zajete";
            zarezerwowane += 1;
            DodajDoListy(sender.getAttribute('rzad'),sender.getAttribute('siedzenie'),sender.getAttribute('vip'))
        }
        else
        {
            alert("Nie mozna zarezerwowac wiecej miejsc!");
        }
    }
    else
    {
        sender.className = "pelne";
        zarezerwowane -= 1;
        UsunZListy(String.fromCharCode(64 + parseInt(sender.getAttribute('rzad'))) + sender.getAttribute('siedzenie'))
    }
}

function UsunZListy(id)
{
    var element = document.getElementById(id)
    element.remove(element)
}

function DodajDoListy(rzad, siedzenie)
{
    var table = document.getElementById('tabela_biletow')
    table.setAttribute('class','tabela_biletow')
    table.setAttribute('id','tabela_biletow')
    var row = table.insertRow(table.rows.counter)
    row.setAttribute("id",String.fromCharCode(64 + parseInt(rzad)) + siedzenie)
    var cell = row.insertCell(0)
    cell.setAttribute('align','left')
    cell.innerHTML = '<p class="id_biletu">Miejsce ' + String.fromCharCode(64 + parseInt(rzad)) + siedzenie + '</p>'
    cell = row.insertCell(1)
    cell.setAttribute('align','right')
    var select = document.createElement('select')
    select.setAttribute('class','bilety_combo')
     for (var i = 0; i < bilety.length; i++)
    {
        var bilet = bilety[i]
        var option = document.createElement('option')
        option.id = bilet[0]
        option.value = bilet[2]
        option.innerHTML = bilet[1]
        select.appendChild(option)
            cell.appendChild(select)
    }
         select.setAttribute('onchange','ZmienCene(this)')   
    cell = row.insertCell(2)
    cell.setAttribute('align','left')
    cell.setAttribute('id','cena')
            cell.innerHTML = '<p class="cena_biletu">' + select.options[select.selectedIndex].value + ' zl</p>' 
}

function ZmienCene(sender)
{
    var tabela = document.getElementById('tabela_biletow')
    var wiersz = sender.parentNode.parentNode
    var komorka = wiersz.cells[2]
         komorka.innerHTML = '<p class="cena_biletu">' + sender.value + ' zl</p>'   
}

function ScrollDown()
{
    window.scroll(window.scrollX,window.scrollY + 100)
}

function Rezerwuj()
{
    var tab = document.getElementById('tabela_biletow')
    if ( tab.rows.length > 0)
    {
        var seans = <?php echo json_encode($post_seans); ?>;
        var string = ''
        for (var i = 0; i < tab.rows.length; i++)
        {
            var select = tab.rows[i].cells[1].getElementsByTagName('select')[0]
            string += tab.rows[i].id + '_' + select.options[select.selectedIndex].id + ';'
        }
        var form = document.createElement('form')
        form.setAttribute('id','temp')
        form.setAttribute('action','dane_klienta.php')
        form.setAttribute('style','display:none;')
        form.setAttribute('method','POST')
        var text = document.createElement('input')
        text.setAttribute('name','siedzenia')
        text.setAttribute('value',string)
        form.appendChild(text)
        var text1 = document.createElement('input')
        text1.setAttribute('name','seans')
        text1.setAttribute('value',seans)
        form.appendChild(text1)
        var text2 = document.createElement('input')
        text2.setAttribute('name','operacja')
        text2.setAttribute('value','0')
        form.appendChild(text2)
        var submit = document.createElement('input')
        submit.setAttribute('type','submit')
        form.appendChild(submit)
        document.getElementById("bilety").appendChild(form)
        form.submit()
    }
    else
    {
        alert('Nie wybrano zadnego biletu!')
    }
}

function Kup()
{
    var seans = <?php echo json_encode($post_seans); ?>;
    var string = ''
    var tab = document.getElementById('tabela_biletow')
    for (var i = 0; i < tab.rows.length; i++)
    {
        var select = tab.rows[i].cells[1].getElementsByTagName('select')[0]
        string += tab.rows[i].id + '_' + select.options[select.selectedIndex].id + ';'
    }
    var form = document.createElement('form')
    form.setAttribute('id','temp')
    form.setAttribute('action','dane_klienta.php')
    form.setAttribute('style','display:none;')
    form.setAttribute('method','POST')
    var text = document.createElement('input')
    text.setAttribute('name','siedzenia')
    text.setAttribute('value',string)
    form.appendChild(text)
    var text1 = document.createElement('input')
    text1.setAttribute('name','seans')
    text1.setAttribute('value',seans)
    form.appendChild(text1)
    var text2 = document.createElement('input')
    text2.setAttribute('name','operacja')
    text2.setAttribute('value','1')
    form.appendChild(text2)
    var submit = document.createElement('input')
    submit.setAttribute('type','submit')
    form.appendChild(submit)
    document.getElementById("bilety").appendChild(form)
    form.submit()
}

function SprawdzDane(seans,operacja)
{
    var blad = 0
    var imie = document.getElementById('form_imie')
    var nazwisko = document.getElementById('form_nazwisko')
    var email = document.getElementById('form_email')
    
    if (imie.value == '')
    {
        imie.setAttribute('class','dane_blad')
        blad = 1
    }
    if (nazwisko.value == '')
    {
        nazwisko.setAttribute('class','dane_blad')
        blad = 1
    }
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var test = re.test(email.value);
    if(test)
    {
        
    }
    else
    {
        email.setAttribute('class','dane_blad')
        blad = 1
    }
    if(blad == 0)
    {
    var wybrane_bilety = <?php echo json_encode($post_bilety); ?>;
    var form = document.createElement('form')
    form.setAttribute('id','temp')
    switch (operacja)
    {
        case 0:
        form.setAttribute('action','potwierdzenie_rezerwacji.php')
        break;
        case 1:
        form.setAttribute('action','potwierdzenie_kupna.php')
        break;
    }
    form.setAttribute('style','display:none;')
    form.setAttribute('method','POST')
    var text = document.createElement('input')
    text.setAttribute('name','siedzenia')
    text.setAttribute('value',wybrane_bilety)
    form.appendChild(text)
    var text1 = document.createElement('input')
    text1.setAttribute('name','seans')
    text1.setAttribute('value',seans)
    form.appendChild(text1)
    var text2 = document.createElement('input')
    text2.setAttribute('name','imie')
    text2.setAttribute('value',imie.value)
    form.appendChild(text2)
    var text3 = document.createElement('input')
    text3.setAttribute('name','nazwisko')
    text3.setAttribute('value',nazwisko.value)
    form.appendChild(text3)
    var text4 = document.createElement('input')
    text4.setAttribute('name','email')
    text4.setAttribute('value',email.value)
    form.appendChild(text4)
    var submit = document.createElement('input')
    submit.setAttribute('type','submit')
    form.appendChild(submit)
    document.getElementById("container_800_30").appendChild(form)
    form.submit()
    }
}

function SprawdzDaneNowySeans(operacja,pokaz)
{
    var blad = 0
    var data = document.getElementById('form_data')
    var film = document.getElementById('form_film')
    var sala = document.getElementById('form_sala')
    var obraz = document.getElementById('form_obraz')    
    var dzwiek = document.getElementById('form_dzwiek')
    
    if (data.value == '')
    {
        data.setAttribute('class','input_blad')
        blad = 1
    }
    if (obraz.value == '')
    {
        obraz.setAttribute('class','input_blad')
        blad = 1
    }
    if (dzwiek.value == '')
    {
        dzwiek.setAttribute('class','input_blad')
        blad = 1
    }
    if(blad == 0)
    {
    var form = document.createElement('form')
    form.setAttribute('id','temp')
    form.setAttribute('action','dodaj_seans.php')
    form.setAttribute('style','display:none;')
    form.setAttribute('method','POST')
    var text = document.createElement('input')
    text.setAttribute('name','data')
    text.setAttribute('value',data.value)
    form.appendChild(text)
    var text1 = document.createElement('input')
    text1.setAttribute('name','film')
    text1.setAttribute('value',film.options[film.selectedIndex].value)
    form.appendChild(text1)
    var text2 = document.createElement('input')
    text2.setAttribute('name','sala')
    text2.setAttribute('value',sala.options[sala.selectedIndex].value)
    form.appendChild(text2)
    var text3 = document.createElement('input')
    text3.setAttribute('name','obraz')
    text3.setAttribute('value',obraz.value)
    form.appendChild(text3)
    var text4 = document.createElement('input')
    text4.setAttribute('name','dzwiek')
    text4.setAttribute('value',dzwiek.value)
    form.appendChild(text4)
    var text5 = document.createElement('input')
    text5.setAttribute('name','operacja')
    text5.setAttribute('value',operacja)
    form.appendChild(text5)
    if(pokaz != '')
    {
    var text6 = document.createElement('input')
    text6.setAttribute('name','pokaz')
    text6.setAttribute('value',pokaz)
    form.appendChild(text6)
    }
    var submit = document.createElement('input')
    submit.setAttribute('type','submit')
    form.appendChild(submit)
    document.getElementsByTagName('body')[0].appendChild(form)
    form.submit()
    }
}

function ZmienKlase(sender,klasa)
{
    sender.setAttribute('class',klasa)
}
</script>
<?php

function Siedzenia()
{
    $zarezerwowane = array();
    $seans = $_GET['id'];
    $polaczenie = Polaczenie();
    $sql = 'select * from pokazy join sale on pokazy.Sala = sale.ID_Sali where ID_Pokazu = ' . $seans;
    $wynik = $polaczenie -> query($sql);
    
    while(($rekord = $wynik -> fetch_assoc()) != null)
    {
        $uklad_sali = $rekord['Uklad_siedzen'];
        $sala = $rekord['Numer_sali'];
    }
    $sql = 'select szczegoly_rezerwacji.Siedzenie from szczegoly_rezerwacji join rezerwacje on szczegoly_rezerwacji.Rezerwacja = rezerwacje.ID_Rezerwacji where rezerwacje.Pokaz = ' . $seans;
    $wynik = $polaczenie -> query($sql);
    while(($rekord = $wynik -> fetch_assoc()) != null)
    {
        $zarezerwowane[] = $rekord['Siedzenie'];
    }
    $uklad_split = split('/',$uklad_sali);
    echo '<center>';
    echo '<p class="numer_sali">Sala '.$sala.'</p>';
    echo '<div id="ekran">EKRAN</div>';
    echo '<table class="uklad_sali">';
    $numer_rzedu = 1;
    $numer_siedzenia = 1;
    foreach ($uklad_split as $rzad)
    {
        $numer_siedzenia = 1;
        echo '<tr>';
        $uklad_split2 = split(',',$rzad);
        foreach($uklad_split2 as $siedzenie)
        {
            echo '<td>';
            switch ($siedzenie) {
                case 0:
                echo '<div id="siedzenie" class="puste"></div>';
            break;
                case 1:
                $numer = chr(64 + $numer_rzedu) . $numer_siedzenia;
                    if(in_array($numer,$zarezerwowane) == true)
                    {
                        echo '<div id="siedzenie" class="zarezerwowane" rzad="'.$numer_rzedu.'" siedzenie="'.$numer_siedzenia.'"></div>';
                    }
                    else
                    {
                        echo '<div id="siedzenie" class="pelne" vip="0"  rzad="'.$numer_rzedu.'" siedzenie="'.$numer_siedzenia.'" onclick="Siedzenie(this)"></div>';   
                    }
                $numer_siedzenia += 1;
            break;
            }
            echo '</td>';
        }
        echo '</tr>';
        $numer_rzedu += 1;
    }
    echo '</table>';
    echo '<div id="bilety"><table id="tabela_biletow"></table></div>';
    echo '<div id="przyciski">';
    echo '<a href="javascript:Rezerwuj()"><div id="przycisk" class="rezerwuj">Rezerwuj</div></a>';
    echo '<a href="javascript:Kup()"><div id="przycisk" class="kup">Kup</div></a>';
    echo '</div>';
    echo '</center>';
}

function Dane_Seansu()
{
    $seans = $_GET['id'];
    $post_seans = $seans;
    $polaczenie = Polaczenie();
    $sql = 'select * from pokazy join sale on pokazy.Sala = sale.ID_Sali join Filmy on pokazy.Film = filmy.ID_Filmu where ID_Pokazu = ' . $seans;
    $wynik = $polaczenie -> query($sql);
    while(($rekord = $wynik -> fetch_assoc()) != null)
    {
    $Tytul = $rekord['Tytul'];
    $Podtytul = $rekord['Podtytul'];
    $Data = date_create($rekord['Data']);
    }
    echo '<h2>'.$Tytul.'</h2>';
    echo '<h3>'.$Podtytul.'</h3>';
    echo '<h4>'. date_format($Data,'d.m.Y') . ' ' . date_format($Data,'H:i') . '</h4>';
}

function Tabela_biletow()
{
    $suma = 0;
    global $tabela;
    
$bilety = array();
global $post_bilety;
$bilety_split = split(';',$_POST['siedzenia']);
foreach ($bilety_split as $bilet)
{
    $bilety[] = array(substr($bilet,0,strrpos($bilet,'_')), substr($bilet,strrpos($bilet,'_')+1,strlen($bilet)-strrpos($bilet,'_')-1));
}
echo '<div id="container_800_30" class="white">
      <p class="tytul_niebieski">Bilety:</p>
      <center>
      <table class="tabela_biletow">
      ';
for($i = 0;$i < count($bilety) - 1;$i++)
{
    echo '
    <tr>
    <td align="left">
    <p class="id_biletu">Miejsce ' . $bilety[$i][0] . '</p>
    </td>
    <td align="right">
    <p class="id_biletu">' . $tabela[$bilety[$i][1]-1][1] . '</p>
    </td>
    <td align="right">
    <p class="cena_biletu">' . $tabela[$bilety[$i][1]-1][2] . ' zl</p>
    </td>
    </tr>
    ';
    $suma = $suma + intval($tabela[$bilety[$i][1]-1][2]);
}
echo '
    </table>
    <div style="background-color: #006699; height: 1px; width: 750px;"></div>
    <table class="tabela_biletow2">
    <tr>
    <td></td>
    <td align="right"><p class="id_biletu">Suma:</p></td>
    <td align="right"><p class="id_biletu">'. $suma .' zl</p></td>
    </tr>
    </table>
    </center>
    </div>
    ';
}

function DaneUzytkownika()
{
    echo '
    <div id="container_800_30" class="blue">
    <p class="tytul_bialy">Dane osobowe: </p>
    <form action="">
    <table class="formularz">
    <tr>
        <td align="right"><p class="label">Imie:</p></td>
        <td align="left"><input class="dane" id="form_imie" name="imie" type="text" onchange="ZmienKlase(this,' . "'dane'" . ')"/></input></td>
    </tr>
    <tr>
        <td align="right"><p class="label">Nazwisko:</p></td>
        <td align="left"><input class="dane" id="form_nazwisko" name="nazwisko" type="text" onchange="ZmienKlase(this,' . "'dane'" . ')"/></input></td>
    </tr>
    <tr>
        <td align="right"><p class="label">Adres e-mail:</p></td>
        <td align="left"><input class="dane" id="form_email" name="email" type="text" onchange="ZmienKlase(this,' . "'dane'" . ')"/></input></td>
    </tr>
    </table>
    </form>
    <center>
    ';
    switch ($_POST['operacja'])
    {
    case 0:
    echo '<a href="javascript:SprawdzDane('.$_POST['seans'].','. 0 .')"><div id="przycisk_nofloat" class="kup">Rezerwuj</div></a>';
    break;
    case 1:
    echo '<a href="javascript:SprawdzDane('.$_POST['seans'].','. 1 .')"><div id="przycisk_nofloat" class="kup">Kup</div></a>';
    break;
    }
    echo '
    </center>
    </div>
         ';
}

function PotwierdzenieRezerwacji()
{
    $siedzenia = $_POST['siedzenia'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $seans = $_POST['seans'];
    $date = date('Y-m-d H:i:s');
    $sql;
    $uzytkownik;
    $id_rezerwacji;
    $polaczenie = Polaczenie();
    if (isset($_SESSION['login']) == true)
    {
        $uzytkownik = $_SESSION['login'];
        $sql = "insert into rezerwacje values ('',$seans,$uzytkownik,'$imie','$nazwisko','$email','$date',NULL)";
    }
    else
    {
        $sql = "insert into rezerwacje values ('',$seans,null,'$imie','$nazwisko','$email','$date',NULL)";
    }
    $wynik = $polaczenie -> query($sql);
    
    $sql = "select ID_Rezerwacji from rezerwacje where Pokaz = $seans and Data_rezerwacji = '$date'";
    $wynik = $polaczenie -> query($sql);
    if(mysqli_num_rows($wynik) > 0)
    {
    while(($rekord = $wynik -> fetch_assoc()) != null)
    {
        $id_rezerwacji = $rekord['ID_Rezerwacji'];
    }
    $bilety = array();
    $bilety_split = split(';',$_POST['siedzenia']);
    foreach ($bilety_split as $bilet)
    {
        $id_biletu = substr($bilet,0,strrpos($bilet,'_')); 
        $rodzaj_biletu = substr($bilet,strrpos($bilet,'_')+1,strlen($bilet)-strrpos($bilet,'_')-1);
        $sql = "insert into szczegoly_rezerwacji values($id_rezerwacji,'$id_biletu',$rodzaj_biletu)";
        $wynik = $polaczenie -> query($sql);
    }
    
    echo '
    <div id="container_800_30" class="white">
    <center>
    <p class="potwierdzenie">Bilety zostaly zarezerwowane.<br>Podczas odbioru biletow, prosimy o podanie nastepujacego kodu:</p>
    <p class="potwierdzenie_kod">'.
    $id_rezerwacji
    .'
    </p>
    </center>
    </div>
    ';
    $_SESSION['rezerwacja_w_toku'] = 0;
    }
    else
    {
        echo 'Wystapil blad, prosze sprobowac ponownie';
    }
}

function PotwierdzenieKupna()
{
    $siedzenia = $_POST['siedzenia'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $seans = $_POST['seans'];
    $date = date('Y-m-d H:i:s');
    $sql;
    $uzytkownik;
    $id_rezerwacji;
    $polaczenie = Polaczenie();
    $sciezka = md5(uniqid(rand(),true));
    if (isset($_SESSION['login']) == true)
    {
        $uzytkownik = $_SESSION['login'];
        $sql = "insert into rezerwacje values ('',$seans,$uzytkownik,'$imie','$nazwisko','$email','$date','$sciezka')";
    }
    else
    {
        $sql = "insert into rezerwacje values ('',$seans,null,'$imie','$nazwisko','$email','$date','$sciezka')";
    }
    $wynik = $polaczenie -> query($sql);
    
    $sql = "select ID_Rezerwacji from rezerwacje where Pokaz = $seans and Data_rezerwacji = '$date'";
    $wynik = $polaczenie -> query($sql);
    if(mysqli_num_rows($wynik) > 0)
    {
    while(($rekord = $wynik -> fetch_assoc()) != null)
    {
        $id_rezerwacji = $rekord['ID_Rezerwacji'];
    }
    $bilety = array();
    $bilety_split = split(';',$_POST['siedzenia']);
    foreach ($bilety_split as $bilet)
    {
        $id_biletu = substr($bilet,0,strrpos($bilet,'_')); 
        $rodzaj_biletu = substr($bilet,strrpos($bilet,'_')+1,strlen($bilet)-strrpos($bilet,'_')-1);
        $sql = "insert into szczegoly_rezerwacji values($id_rezerwacji,'$id_biletu',$rodzaj_biletu)";
        $wynik = $polaczenie -> query($sql);
    }
    header('Location: pdf_bilety.php?pdf='.$sciezka);
    $_SESSION['rezerwacja_w_toku'] = 0;
    }
    else
    {
        echo 'Wystapil blad, prosze sprobowac ponownie';
    } 
}

function SprawdzRoleUzytkownika($rola)
{
    $polaczenie = Polaczenie();
    $sql = 'select Rola from uzytkownicy where ID_Uzytkownika = ' . $_SESSION['login'];
    $wynik = $polaczenie -> query($sql);
    $return;
    while(($rekord = $wynik -> fetch_assoc()) != null)
    { 
        if($rola == $rekord['Rola'])
        {
            $return = true;
        }
        else
        {
            $return = false;
        }
    }
    return $return;
}

function MenuModeratora()
{
    echo '
            <div id="aside_container_mod">
            <h2>Moderator:</h2>
            <center>
                <div id="aside_section">
                    Filmy
                </div>
                <a href="mod_seanse.php"><div id="aside_section">
                    Seanse
                </div></a>
                <div id="aside_section">
                    Sale
                </div>
            </center>
            </div>
        ';
}

function Seanse()
{
    $polaczenie = Polaczenie();
    $sql = 'select Data, ID_Pokazu, Tytul, Okladka, Numer_sali, Rodzaj_obrazu, Rodzaj_dzwieku from pokazy join filmy on pokazy.Film = filmy.ID_Filmu join sale on pokazy.Sala = sale.ID_Sali order by Data, Tytul, Numer_sali';
    $wynik = $polaczenie -> query($sql);
    echo '
    <div id="pokazy_container">
    <h3 class="movies">Seanse</h3>
    <div class="dodaj_seans"><a href="mod_nowy_seans.php"><div class="dodaj_seans_przycisk">Nowy seans</div></a></div>
    <div id="seans_naglowek">
            <table id="tabela_seansow">
        <th width="120">Data</th>
        <th width="120">Film</th>
        <th width="100">Sala</th>
        <th width="100">Obraz</th>
        <th width="120">Dzwiek</th>
        <th>Opcje</th>
        </table>     
    </div>
         ';
    while(($rekord = $wynik -> fetch_assoc()) != null)
    {   
        $date = date('Y-m-d H:i');
        if(date_format(date_create($rekord['Data']),'Y-m-d H:i') >= $date)
        {
            echo '<div id="seans_container">';
        }
        else
        {
            echo '<div id="seans_container_przeszly">';
        }
        echo '
        <table id="tabela_seansow">
        <tr>
        <td width="120">
        <p class="data_seansu">
        '.
        date_format(date_create($rekord['Data']),'d.m.Y') 
        . '<br>' .
        date_format(date_create($rekord['Data']),'H:i')        
        .'
        </p>
        </td>
        <td width="120">
        <img class="okladka" src="obrazy/okladki/' . $rekord['Okladka'] . '">
        <p class="tytul">'.$rekord['Tytul'].'</p>
        </td>
        <td width="100">
        <p class="data_seansu">'. $rekord['Numer_sali'] .'</p>
        </td>
        <td width="100">
        <p class="data_seansu">'. $rekord['Rodzaj_obrazu'] .'</p>
        </td>
        <td width="120">
        <p class="data_seansu">'. $rekord['Rodzaj_dzwieku'] .'</p>
        </td>
        <td>
        <center>
        <div>
        <a href="mod_nowy_seans.php?id='.$rekord['ID_Pokazu'].'"><img src="obrazy/edytuj.png" width="20"></a>
        &nbsp;
        <a href="mod_usun_seans.php?id='.$rekord['ID_Pokazu'].'"><img src="obrazy/usun.png" width="20"></a>
        </div>
        </center>
        </td>
        </tr>
        </table>
        </div>';
    }
    echo '</div>';
}

function UsunSeans($seans)
{
    $polaczenie = Polaczenie();
    $sql = 'delete from szczegoly_rezerwacji where Rezerwacja in (select ID_Rezerwacji from rezerwacje where rezerwacje.Pokaz = '. $seans .')';
    $wynik = $polaczenie -> query($sql);
    $sql = 'delete from rezerwacje where rezerwacje.Pokaz = '. $seans;
    $wynik = $polaczenie -> query($sql);
    $sql = 'delete from pokazy where ID_Pokazu = '. $seans;
    $wynik = $polaczenie -> query($sql);
}

function NowySeans()
{
    $filmy = array();
    $sale = array();
    $options;
    $polaczenie = Polaczenie();
    $sql = 'select ID_Filmu, Tytul, Podtytul from filmy order by ID_Filmu';
    $wynik = $polaczenie -> query($sql);
    while(($rekord = $wynik -> fetch_assoc()) != null)
    {  
        $filmy[] = array($rekord['ID_Filmu'],$rekord['Tytul'] . ' ' . $rekord['Podtytul']);
    }
    $sql = 'select ID_Sali, Numer_sali, Rodzaj from sale order by ID_Sali';
    $wynik = $polaczenie -> query($sql);
    while(($rekord = $wynik -> fetch_assoc()) != null)
    {  
        $sale[] = array($rekord['ID_Sali'],$rekord['Numer_sali'] . ' (' . $rekord['Rodzaj'] .')');
    }
    
    if(isset($_GET['id']))
    { 
        $sql = 'select * from pokazy where ID_Pokazu =' . $_GET['id'];
        $wynik = $polaczenie -> query($sql);
        while(($rekord = $wynik -> fetch_assoc()) != null)
        {
            $data_data = date_format(date_create($rekord['Data']),'Y-m-d');
            $data_czas = date_format(date_create($rekord['Data']),'H:i');
            $data_form = $data_data . 'T' . $data_czas;
            echo ' 
            <div id="pokazy_container">
            <h3 class="movies">Nowy seans</h3>
            <form action="javascript:SprawdzDaneNowySeans()" method="POST">
            <center>
            <table>
            <tr>
            <td width="100" align="right"><p class="label">Data: </p></td><td width="270" align="left"><input class="input" type="datetime-local" id="form_data" value="' . $data_form .'" onchange="ZmienKlase(this,' . "'input'" . ')"/></td><td align="left"><p class="opis">MM/DD/RRRR GG:MM Pora dnia</p></td>
            </tr>
            <tr>
            <td width="100" align="right"><p class="label">Film: </p></td><td width="270" align="left"><select class="input" id="form_film">';
            $licznik = 1;
            foreach ($filmy as $film)
            {   
                if($licznik == $rekord['Film'])
                {
                echo '<option selected = "selected" value=' . $film[0] . '>' . $film[1] . '</option>';   
                }
                else
                {
                echo '<option value=' . $film[0] . '>' . $film[1] . '</option>';
                }
                $licznik += 1;
            }
            echo '</select></td>
            </tr>
            <tr>
            <td width="100" align="right"><p class="label">Sala: </p></td><td width="270" align="left"><select class="input" id="form_sala">';
            $licznik = 1;
            foreach ($sale as $sala)
            {
                if($licznik == $rekord['Sala'])
                {
                    echo '<option selected="selected" value=' . $sala[0] . '>' . $sala[1] . '</option>';   
                }
                else
                {
                    echo '<option value=' . $sala[0] . '>' . $sala[1] . '</option>';
                }
                $licznik += 1;
            }
            echo '</select></td>
            </tr>
            <tr>
            <td width="100" align="right"><p class="label">Obraz: </p></td><td width="270" align="left"><input class="input" type="text" id="form_obraz" value="'. $rekord['Rodzaj_obrazu'] .'" onchange="ZmienKlase(this,' . "'input'" . ')"/></td><td align="left"><p class="opis">Np. 2D/3D/IMAX 3D</p></td>
            </tr>
            <tr>
            <td width="100" align="right"><p class="label">Dzwiek: </p></td><td width="270" align="left"><input class="input" type="text" id="form_dzwiek" value="'. $rekord['Rodzaj_dzwieku'] .'" onchange="ZmienKlase(this,' . "'input'" . ')"/></td><td align="left"><p class="opis">Np. Napisy/Lektor/Dubbing</p></td>
            </tr>
            </table>
            <a href="javascript:SprawdzDaneNowySeans(0,'. $_GET['id'] .')"><div id="dodaj" class="dodaj_seans_przycisk">Aktualizuj</div></a>
            </center>
            </form>
            <div>
            ';
        }
    }
    else
    {
        $data = date('Y-m-d') . 'T' . date('H:i');
            echo ' 
            <div id="pokazy_container">
            <h3 class="movies">Nowy seans</h3>
            <form action="javascript:SprawdzDaneNowySeans()" method="POST">
            <center>
            <table>
            <tr>
            <td width="100" align="right"><p class="label">Data: </p></td><td width="270" align="left"><input class="input" type="datetime-local" id="form_data" value = "'. $data .'" onchange="ZmienKlase(this,' . "'input'" . ')"/></td><td align="left"><p class="opis">MM/DD/RRRR GG:MM Pora dnia</p></td>
            </tr>
            <tr>
            <td width="100" align="right"><p class="label">Film: </p></td><td width="270" align="left"><select class="input" id="form_film">';
            foreach ($filmy as $film)
            {   
                echo '<option value=' . $film[0] . '>' . $film[1] . '</option>';
            }
            echo '</select></td>
            </tr>
            <tr>
            <td width="100" align="right"><p class="label">Sala: </p></td><td width="270" align="left"><select class="input" id="form_sala">';
            foreach ($sale as $sala)
            {
                    echo '<option value=' . $sala[0] . '>' . $sala[1] . '</option>';
            }
            echo '</select></td>
            </tr>
            <tr>
            <td width="100" align="right"><p class="label">Obraz: </p></td><td width="270" align="left"><input class="input" type="text" id="form_obraz" onchange="ZmienKlase(this,' . "'input'" . ')"/></td><td align="left"><p class="opis">Np. 2D/3D/IMAX 3D</p></td>
            </tr>
            <tr>
            <td width="100" align="right"><p class="label">Dzwiek: </p></td><td width="270" align="left"><input class="input" type="text" id="form_dzwiek" onchange="ZmienKlase(this,' . "'input'" . ')"/></td><td align="left"><p class="opis">Np. Napisy/Lektor/Dubbing</p></td>
            </tr>
            </table>
            <a href="javascript:SprawdzDaneNowySeans(1,'. "''" . ')"><div id="dodaj" class="dodaj_seans_przycisk">Dodaj</div></a>
            </center>
            </form>
            <div>
            ';
    }
}

function BiletyUzytkownika()
{
    $polaczenie = Polaczenie();
    $sql = 'select ID_Rezerwacji, count(Siedzenie) as Siedzenia, Data, ID_Pokazu, Tytul, Okladka, Numer_sali, Rodzaj_obrazu, Rodzaj_dzwieku, Sciezka from rezerwacje join szczegoly_rezerwacji on rezerwacje.ID_Rezerwacji = szczegoly_rezerwacji.Rezerwacja join pokazy on rezerwacje.Pokaz = pokazy.ID_Pokazu join filmy on pokazy.Film = filmy.ID_Filmu join sale on pokazy.Sala = sale.ID_Sali where Uzytkownik = '. $_SESSION['login'] .' group by ID_Rezerwacji, Data, ID_Pokazu, Tytul, Okladka, Numer_sali, Rodzaj_obrazu, Rodzaj_dzwieku, Sciezka order by Data';
    $wynik = $polaczenie -> query($sql);
    echo '
    <div id="pokazy_container">
    <h3 class="movies">Bilety</h3>
    <div id="seans_naglowek">
            <table id="tabela_seansow">
        <th width="120">Data</th>
        <th width="120">Film</th>
        <th width="100">Sala</th>
        <th width="100">Miejsca</th>
        <th>Opcje</th>
        </table>     
    </div>
         ';
    while(($rekord = $wynik -> fetch_assoc()) != null)
    {   
        $date = date('Y-m-d H:i');
        if(date_format(date_create($rekord['Data']),'Y-m-d H:i') >= $date)
        {
            echo '<div id="seans_container">';
        }
        else
        {
            echo '<div id="seans_container_przeszly">';
        }
        echo '
        <table id="tabela_seansow">
        <tr>
        <td width="120">
        <p class="data_seansu">
        '.
        date_format(date_create($rekord['Data']),'d.m.Y') 
        . '<br>' .
        date_format(date_create($rekord['Data']),'H:i')        
        .'
        </p>
        </td>
        <td width="120">
        <img class="okladka" src="obrazy/okladki/' . $rekord['Okladka'] . '">
        <p class="tytul">'.$rekord['Tytul'].'</p>
        </td>
        <td width="100">
        <p class="data_seansu">'. $rekord['Numer_sali'] .'</p>
        </td>
        <td width="100">
        <p class="data_seansu">'. $rekord['Siedzenia'] .'</p>
        </td>
        <td>
        <center>
        ';
        if($rekord['Sciezka'] != '')
        {
        echo '
        <div>
        <a href="pdf/index.php?pdf='.$rekord['Sciezka'].'"><img src="obrazy/drukuj.png" width="20"></a>
        </div>';
        }
        echo '
        </center>
        </td>
        </tr>
        </table>
        </div>';
    }
    echo '</div>';
}

class Pokaz {

public $varID ;
public $varData;
public $varFilm;
public $varSala;
public $varObraz;
public $varDzwiek;

function __construct($ID, $Data, $Film, $Sala, $Obraz, $Dzwiek)
{
    $this ->varID = $ID;
    $this ->varData = $Data;
    $this ->varFilm = $Film;
    $this ->varSala = $Sala;
    $this ->varObraz = $Obraz;
    $this ->varDzwiek = $Dzwiek;   
}
}
?>