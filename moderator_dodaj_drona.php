<?php
include("zaglavlje.php");
$bp=spojiSeNaBazu();

$greska = "";

$sql = "SELECT korisnik_id, vrsta_drona_id FROM korisnik WHERE korisnik_id = '{$_SESSION["aktivni_korisnik_id"]}'";
$rs = izvrsiUpit($bp, $sql);
$row = mysqli_fetch_array($rs);

$id_vrste = $row['vrsta_drona_id'];

if(isset($_POST['submit'])){   
    $vrsta_drona_id = $_POST['vrsta_drona_id'];
    $poveznica = $_POST['poveznica_slika'];
    $naziv = $_POST['naziv_drona'];
    $sql1 = "INSERT INTO dron (vrsta_drona_id, poveznica_slika, naziv) VALUES ('{$vrsta_drona_id}', '{$poveznica}', '{$naziv}')";
    izvrsiUpit($bp, $sql1);
    header("Location:index.php");
}


?>

<form method="POST" action="<?php echo "{$_SERVER['PHP_SELF']}";?>">
<table class="tablicakorisnika">
  <caption>Dodaj drona</caption>
  <tbody>
      <td colspan="2" style="text-align:center;">
        <label class="greska"><?php if($greska!="")echo $greska; ?></label>
      </td>
      <input type="text" name="vrsta_drona_id" id="vrsta_drona_id" hidden value="<?php echo $id_vrste?>">
    <tr>
      <td>
        <label for="poveznica_slika"><strong>Poveznica slika:</strong></label>
      </td>
      <td>
      <input type="text" name="poveznica_slika" id="poveznica_slika" size="120" maxlength="100">
      </td>
    </tr>
      
    <tr>
      <td class="lijevi">
        <label for="naziv_drona"><strong>Naziv drona:</strong></label>
      </td>
      <td>
        <input type="text" name="naziv_drona" id="naziv_drona" size="120" maxlength="100"/>
      </td>
    </tr>    
				<td colspan="2" style="text-align:center;">
          <input class="gumb" type="submit" name="submit" value="Dodaj"/>
				</td>
			</tr>
      
		</tbody>
	</table>
</form>

<?php zatvoriVezuNaBazu($bp) ?>