<?php
ob_start();
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('dolaczenia/kod_html.php');
$sciezka;
    if(isset($_GET['pdf']))
    {
    require ('dolaczenia/fpdf/fpdf.php');
    
    $pdf = new FPDF();
    $pdf -> AddPage();
    
    $polaczenie = Polaczenie();
    $sql = "select * from szczegoly_rezerwacji join rezerwacje on szczegoly_rezerwacji.Rezerwacja = rezerwacje.ID_Rezerwacji join pokazy on rezerwacje.Pokaz = pokazy.ID_Pokazu join filmy on pokazy.Film = filmy.ID_Filmu join sale on pokazy.Sala = sale.ID_Sali join bilety on szczegoly_rezerwacji.Bilet = bilety.ID_Biletu where Sciezka = '" . $_GET['pdf'] . "' order by szczegoly_rezerwacji.Siedzenie";
    $wynik = $polaczenie -> query($sql);
    $numer_biletu = 0;
              $pdf -> SetAutoPageBreak(true,10);
    	while(($rekord = $wynik -> fetch_assoc()) != null)
    	{
          $sciezka = $rekord['Sciezka'];
 	      $poczatek_biletu = $numer_biletu * 65;
          $pdf -> Rect(10,$poczatek_biletu + 10,190,60,D);
          $pdf -> SetFont('Arial','',10);
          $pdf -> Text(15,$poczatek_biletu + 18,'Home Cinema');
          $pdf -> Text(15,$poczatek_biletu + 22,'Krasinskiego 25A');
          $pdf -> Text(15,$poczatek_biletu + 26,'40-019 Katowice');
          $pdf -> SetFont('Arial','',15);
          $pdf -> Text(85,$poczatek_biletu + 20,$rekord['Nazwa']);
          $pdf -> SetFont('Arial','',10);
          $pdf -> Text(155,$poczatek_biletu + 18,$rekord['Data_rezerwacji']);
          $pdf -> Text(155,$poczatek_biletu + 22,$rekord['Imie'] . ' ' . $rekord['Nazwisko']);
          $pdf -> Text(155,$poczatek_biletu + 26,$rekord['Email']);
          $pdf -> SetFont('Arial','',12);
          $pdf -> Text(15,$poczatek_biletu + 35,'Film');
          $pdf -> SetFont('Arial','',30);
          $pdf -> Text(15,$poczatek_biletu + 45,$rekord['Tytul']);
          $pdf -> SetFont('Arial','',12);
          $pdf -> Text(15,$poczatek_biletu + 55,'Data');
          $pdf -> Text(65,$poczatek_biletu + 55,'Godzina');
          $pdf -> Text(99,$poczatek_biletu + 55,'Sala');
          $pdf -> Text(120,$poczatek_biletu + 55,'Rzad');
          $pdf -> Text(142,$poczatek_biletu + 55,'Siedzenie');
          $pdf -> Text(170,$poczatek_biletu + 55,'Cena');
          $pdf -> SetFont('Arial','',24);
          $pdf -> Text(15,$poczatek_biletu + 65,date_format(date_create($rekord['Data']),'d.m.Y'));
          $pdf -> Text(65,$poczatek_biletu + 65,date_format(date_create($rekord['Data']),'H:i'));
          $pdf -> Text(99,$poczatek_biletu + 65,$rekord['Numer_sali']);
          $pdf -> Text(120,$poczatek_biletu + 65,substr($rekord['Siedzenie'],0,1));
          $pdf -> Text(142,$poczatek_biletu + 65,substr($rekord['Siedzenie'],1,strlen($rekord['Siedzenie'])-1));
          $pdf -> Text(170,$poczatek_biletu + 65,$rekord['Cena'] . 'zl');
          
          if($numer_biletu == 3 and mysqli_num_rows($wynik) != 4)
          {
            $numer_biletu = 0;
            $pdf -> AddPage();
          }
          else
          {
            $numer_biletu += 1;
          }
        }
    $pdf->Output('pdf/'. $sciezka .'.pdf','F');
    header('Location: pobierz_pdf.php?pdf=' . $sciezka);
    }
    else
    {
        header('Location: index.php');
    }
ob_end_flush();
?>