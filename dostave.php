<?php include("zaglavlje.php"); 
$bp=spojiSeNaBazu();
?>

<?php 

if(isset($_GET['izvrsena'])){
  $dostava_id = $_GET['izvrsena'];
  $sql = "UPDATE dostava SET status = 2 WHERE dostava_id = $dostava_id ";
  izvrsiUpit($bp, $sql);
  header("Location:dostave.php");
}

$korisnik_id = $_SESSION["aktivni_korisnik_id"];

if(isset($_POST['submit'])){
  if(!empty($_POST['datum_od'])){
    $datum_od = date("Y-m-d H:i:s", strtotime($_POST['datum_od']));
  } else {
    $datum_od = "1991-11-11 11:11:11";
  }

  if(!empty($_POST['datum_do'])){
    $datum_do = date("Y-m-d H:i:s", strtotime($_POST['datum_do']));
  } else {
    $datum_do = "2111-11-11 11:11:11";
  }

  $sql="SELECT dostava_id,korisnik_id,dron_id,datum_vrijeme_dostave, datum_vrijeme_zahtjeva, opis_posiljke, adresa_dostave,
  adresa_polazista, dostavaKM, dostavaKG, hitnost, ukupna_cijena, napomene, status	
  FROM dostava WHERE datum_vrijeme_zahtjeva BETWEEN '{$datum_od}' AND '{$datum_do}'
  AND dostava.korisnik_id = '{$korisnik_id}' ORDER BY hitnost DESC"; 

} else {
  $sql="SELECT dostava_id,korisnik_id,dron_id,datum_vrijeme_dostave, datum_vrijeme_zahtjeva, opis_posiljke, adresa_dostave,
  adresa_polazista, dostavaKM, dostavaKG, hitnost, ukupna_cijena, napomene, status	
  FROM dostava WHERE dostava.korisnik_id = '{$korisnik_id}'
  ORDER BY hitnost DESC"; 
}

$rs=izvrsiUpit($bp,$sql);

echo"<form method='post' action='dostave.php'>
        <label for='datum_od'>Datum od</label>
        <input type='text' id='datum_od' name='datum_od' placeholder='d.m.Y H:i:s'/>
        <br>       
        <label for='datum_do'>Datum do</label>
        <input type='text' id='datum_do' name='datum_do' placeholder='d.m.Y H:i:s'/>
        <br>
        <input type='submit' id='submit' name='submit' value='Filtriraj' /> 
    </form>";

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
  $datum_vrijeme_dostave= date("d.m.Y. H:i:s", strtotime($row['datum_vrijeme_dostave']));
  $datum_vrijeme_zahtjeva = date("d.m.Y. H:i:s", strtotime($row['datum_vrijeme_zahtjeva']));
  $opis_posiljke = $row['opis_posiljke'];
  $napomene = $row['napomene'];
  $adresa_polazista = $row['adresa_polazista'];
  $adresa_dostave = $row['adresa_dostave'];
  $dostavaKM= $row['dostavaKM'];
  $dostavaKG = $row['dostavaKG'];
  $hitnost = $row['hitnost'];
  $ukupna_cijena = $row['ukupna_cijena'];
  $status = $row['status'];

  echo "<tbody>
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
    $trenutni_datum = date("d.m.Y. H:i:s");
    if(strtotime($datum_vrijeme_dostave) <= strtotime($trenutni_datum) && $status == 1){
      echo "
      <td>
      <a href='dostave.php?izvrsena=$dostava_id'><input class='gumb' name='submit' type='submit' name='submit' value='Dostava izvršena'/></a>
      </td>";
    }       
     echo"</tr>";
     
    
  }
echo "</tbody>";
echo "</table>";
?>

<?php zatvoriVezuNaBazu($bp) ?>