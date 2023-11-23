<?php
include("zaglavlje.php");
$bp=spojiSeNaBazu();
?>

<?php
$greska = "";
if(isset($_POST['submit'])){
  foreach ($_POST as $key => $value)if(strlen($value)==0)$greska="Sva polja za unos su obavezna";
  if(empty($greska)){
    $naziv = $_POST['naziv'];   
    $minKM = $_POST['minKM'];
    $maxKM = $_POST['maxKM'];
    $cijenaPoKM = $_POST['cijenaPoKM'];   
    $id = $_POST['vrsta_drona_id'];    
      
    $sql="INSERT INTO vrsta_drona (naziv,minKM,maxKM,cijenaPoKM) VALUES ('{$naziv}','{$minKM}','{$maxKM}','{$cijenaPoKM}')";
    izvrsiUpit($bp, $sql);
   
    }
    header("Location:index.php");
  }
?>
<form method="POST" action="vrsta_dodaj.php">
<table class="tablicakorisnika">
  <caption>Dodaj vrstu drona</caption>
  <tbody>
      <td colspan="2" style="text-align:center;">
        <label class="greska"><?php if($greska!="")echo $greska; ?></label>
      </td>
    <tr>
      <td>
        <label for="naziv"><strong>Naziv:</strong></label>
      </td>
      <td>
      <input type="text" name="naziv" id="naziv" size="120" maxlength="100" >
      </td>
    </tr>
      
    <tr>
      <td class="lijevi">
        <label for="cijenaPoKM"><strong>Cijena po kilometru:</strong></label>
      </td>
      <td>
        <input type="text" name="cijenaPoKM" id="cijenaPoKM" size="120" maxlength="100"/>
      </td>
    </tr>    

    <tr>
      <td class="lijevi">
        <label for="maxKM"><strong>Maksimalna udaljenost (km):</strong></label>
      </td>
      <td>
        <input type="text" name="maxKM" id="maxKM" size="120" maxlength="100"/>
      </td>
    </tr> 

    <tr>
      <td class="lijevi">
        <label for="minKM"><strong>Minimalna udaljenost(km):</strong></label>
      </td>
      <td>
        <input type="text" name="minKM" id="minKM" size="120" maxlength="100"/>
      </td>
    </tr> 
				<td colspan="2" style="text-align:center;">
          <input class="gumb" type="submit" name="submit" value="Dodaj vrstu"/>
				</td>
			</tr>
      
		</tbody>
	</table>
</form>

<?php zatvoriVezuNaBazu($bp) ?>






      
