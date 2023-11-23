<?php include("zaglavlje.php"); 
$bp=spojiSeNaBazu();

$id_korisnika = $_SESSION["aktivni_korisnik_id"];

$sql1 = "SELECT * FROM vrsta_drona 
INNER JOIN korisnik ON vrsta_drona.vrsta_drona_id = korisnik.vrsta_drona_id
WHERE korisnik.korisnik_id = '{$id_korisnika}'";

$rs1 = izvrsiUpit($bp, $sql1);

$red = mysqli_fetch_array($rs1);

if(isset($red)){
  $minKM = $red['minKM'];
  $maxKM = $red['maxKM'];
  $cijena = $red['cijenaPoKM'];

  $sql="SELECT * FROM dostava
  WHERE dostava.dostavaKM BETWEEN '{$minKM}' AND '{$maxKM}' 
  ORDER BY hitnost DESC"; 
  
  $rs=izvrsiUpit($bp,$sql);



echo "<table class='tablicakorisnika'>";
echo "<caption>Zahtjevi za dostavom</caption>";
echo "<thead><tr>
  <th>ID dostave</th>
  <th>Datum i vrijeme dostave</th>
  <th>Datum i vrijeme zahtjeva</th>
  <th>Opis pošiljke</th>
  <th>Napomene</th>
  <th>Adresa polazišta</th>
  <th>Adresa dostave</th>
  <th>Dostava u KM</th>
  <th>Dostava u KG</th>
  <th>Hitnost</th>
  <th>Ukupna cijena</th>
  <th>Status</th>
  <th class='izbrisi'></th>";
echo "</tr></thead>";

while ($row = mysqli_fetch_array($rs)) {
    $dostava_id=$row['dostava_id'];
    $korisnik_id=$row['korisnik_id'];
    $dron_id=$row['dron_id'];
    $datum_vrijeme_dostave= $row['datum_vrijeme_dostave'];
    $datum_vrijeme_zahtjeva = $row['datum_vrijeme_zahtjeva'];
    $opis_posiljke = $row['opis_posiljke'];
    $napomene = $row['napomene'];
    $adresa_polazista = $row['adresa_polazista'];
    $adresa_dostave = $row['adresa_dostave'];
    $dostavaKM= $row['dostavaKM'];
    $dostavaKG = $row['dostavaKG'];
    $hitnost = $row['hitnost'];
    $ukupna_cijena = $row['ukupna_cijena'];
    $status = $row['status'];
  
    echo "<tbody>";

    echo "
    <tr><td>$dostava_id</td>
     <td>$datum_vrijeme_dostave</td>
     <td>$datum_vrijeme_zahtjeva</td>
     <td>$opis_posiljke</td>
     <td>$napomene</td>
     <td>$adresa_polazista</td>
     <td>$adresa_dostave</td>
     <td>$dostavaKM</td>
     <td>$dostavaKG</td>
     <td>"; 
     if($hitnost == 0){
      echo "Nije hitno</td>";
     }else{
      echo "Hitno</td>";
     }
     echo "
     <td>$ukupna_cijena</td>
     <td>";
     if($status == 0){
      echo "Nije potvrđeno</td>";
     }elseif($status == 1) {
      echo "Potvrđeno i čeka na dostavu</td>";
     }else{
      echo "Dostavljeno</td>";
    }
     
     echo "
     <td>";
     if($status == 0){
        echo "<a href='moderator_potvrda.php?dostava_id={$dostava_id}'><input class='gumb' type='submit' name='submit' value='Potvrdi narudžbu'/></a>";
     }
     echo "</td></tr>";
    
  }
  if(isset($_POST['submit']));

echo "</tbody>";
echo "</table>";
}else{
echo "<table class='tablicakorisnika'>";
echo "<caption>Zahtjevi za dostavom</caption>";
echo "<thead><tr>
  <th>ID dostave</th>
  <th>Datum i vrijeme dostave</th>
  <th>Datum i vrijeme zahtjeva</th>
  <th>Opis pošiljke</th>
  <th>Napomene</th>
  <th>Adresa polazišta</th>
  <th>Adresa dostave</th>
  <th>Dostava u KM</th>
  <th>Dostava u KG</th>
  <th>Hitnost</th>
  <th>Ukupna cijena</th>
  <th>Status</th>
  <th class='izbrisi'></th>";
echo "</tr></thead></table>";
}

zatvoriVezuNaBazu($bp) ?>