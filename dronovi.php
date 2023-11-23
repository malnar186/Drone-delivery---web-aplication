<?php
include("zaglavlje.php");
$bp=spojiSeNaBazu();
?>

<?php
$greska = "";
if(isset($_POST['submit'])){
  foreach ($_POST as $key => $value)if(strlen($value)==0)$greska="Sva polja za unos su obavezna";
  if(empty($greska)){
    $naziv_drona = $_POST['naziv_drona'];
    $naziv_vrste = $_POST['naziv_vrste'];
    $minKM = $_POST['minKM'];
    $maxKM = $_POST['maxKM'];
    $cijenaPoKM = $_POST['cijenaPoKM'];
    $poveznica_slika = $_POST['poveznica_slika'];
    $id = $_POST['dron_id'];
    
      if(isset($_GET['dronovi'])){
        $sql="UPDATE dron d 
        SET d.poveznica_slika = '{$poveznica_slika}', d.naziv = '{$naziv_drona}' 
        WHERE d.dron_id = '{$id}'";
        izvrsiUpit($bp, $sql);
      }      
    }
    header("Location:index.php");
  }

if(isset($_GET['dronovi'])){
  $id = $_GET['dronovi'];
  if($aktivni_korisnik_tip==2)$id_korisnika=$_SESSION["aktivni_korisnik_id"];
  $sql = "SELECT d.dron_id, d.vrsta_drona_id, d.poveznica_slika, d.naziv AS naziv_drona, v.naziv AS naziv_vrste, v.minKM, v.maxKM, v.cijenaPoKM
          FROM dron d
          INNER JOIN vrsta_drona v ON d.vrsta_drona_id = v.vrsta_drona_id
          WHERE d.dron_id = '{$id}'";
  $rs = izvrsiUpit($bp, $sql);
  $row = mysqli_fetch_array($rs);


  $id = $row['dron_id'];
  $vrsta_drona_id = $row['vrsta_drona_id'];
  $poveznica_slika = $row['poveznica_slika'];
  $naziv_drona = $row['naziv_drona'];
  $naziv_vrste = $row['naziv_vrste'];
  $minKM = $row['minKM'];
  $maxKM = $row['maxKM'];
  $cijenaPoKM = $row['cijenaPoKM'];
}
else{
  $id="";
  $vrsta_drona_id = "";
  $poveznica_slika = "";
  $naziv_drona = "";
  $naziv_vrste = "";
  $minKM = "";
  $maxKM = "";
  $cijenaPoKM = "";
}
  if(isset($_POST['reset']))header("Location:dronovi.php");
?>
<form method="POST" action="<?php if(isset($_GET['dronovi']))echo "dronovi.php?dronovi=$id";else echo "dronovi.php";?>">
<table class="tablicakorisnika">
  <caption>Uredi drona</caption>
  <tbody>
      <input type="text" name="dron_id" id="dron_id" size="120" maxlength="100"  hidden value="<?php echo $id;?>">
      <td colspan="2" style="text-align:center;">
        <label class="greska"><?php if($greska!="")echo $greska; ?></label>
      </td>
    <tr>
      <td>
        <label for="poveznica_slika"><strong>Poveznica slika:</strong></label>
      </td>
      <td>
      <input type="text" name="poveznica_slika" id="poveznica_slika" size="120" maxlength="100"  value="<?php if(!isset($_POST['poveznica_slika']))echo $poveznica_slika; else echo $_POST['poveznica_slika'];?>">
      </td>
    </tr>
      
    <tr>
      <td class="lijevi">
        <label for="naziv_drona"><strong>Naziv drona:</strong></label>
      </td>
      <td>
        <input type="text" name="naziv_drona" id="naziv_drona" size="120" maxlength="100"
          value="<?php if(!isset($_POST['naziv_drona']))echo $naziv_drona; else echo $_POST['naziv_drona'];?>"/>
      </td>
    </tr>    
				<td colspan="2" style="text-align:center;">
          <input class="gumb" type="submit" name="submit" value="Ažuriraj"/>
				</td>
			</tr>
      
		</tbody>
	</table>
</form>

<?php zatvoriVezuNaBazu($bp) ?>






      
