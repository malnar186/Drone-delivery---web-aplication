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
    
      if(isset($_GET['vrsta'])){
        $sql="UPDATE vrsta_drona
        SET naziv = '{$naziv}', cijenaPoKM = '{$cijenaPoKM}', 
        minKM = '{$minKM}',  maxKM = '{$maxKM}' WHERE vrsta_drona_id = '{$id}'";
        izvrsiUpit($bp, $sql);
      }      
    }
    header("Location:index.php");
  }

if(isset($_GET['vrsta'])){
  $id = $_GET['vrsta'];  
  $sql = "SELECT *
          FROM vrsta_drona          
          WHERE vrsta_drona_id = '{$id}'";
  $rs = izvrsiUpit($bp, $sql);
  $row = mysqli_fetch_array($rs);


  $id = $row['vrsta_drona_id'];  
  $naziv = $row['naziv'];
  $cijenaPoKM = $row['cijenaPoKM'];
  $minKM = $row['minKM'];
  $maxKM = $row['maxKM'];
}
else{
  $id="";
  $naziv = "";
  $cijenaPoKM = ""; 
  $minKM = "";
  $maxKM = ""; 
}
  if(isset($_POST['reset']))header("Location:vrsta.php");
?>
<form method="POST" action="<?php if(isset($_GET['vrsta']))echo "vrsta.php?vrsta=$id";else echo "vrsta.php";?>">
<table class="tablicakorisnika">
  <caption>Uredi vrstu drona</caption>
  <tbody>
      <input type="text" name="vrsta_drona_id" id="vrsta_drona_id" size="120" maxlength="100"  hidden value="<?php echo $id;?>">
      <td colspan="2" style="text-align:center;">
        <label class="greska"><?php if($greska!="")echo $greska; ?></label>
      </td>
    <tr>
      <td>
        <label for="naziv"><strong>Naziv:</strong></label>
      </td>
      <td>
      <input type="text" name="naziv" id="naziv" size="120" maxlength="100"  value="<?php if(!isset($_POST['naziv']))echo $naziv; else echo $_POST['naziv'];?>">
      </td>
    </tr>
      
    <tr>
      <td class="lijevi">
        <label for="cijenaPoKM"><strong>Cijena po kilometru:</strong></label>
      </td>
      <td>
        <input type="text" name="cijenaPoKM" id="cijenaPoKM" size="120" maxlength="100"
          value="<?php if(!isset($_POST['cijenaPoKM']))echo $cijenaPoKM; else echo $_POST['cijenaPoKM'];?>"/>
      </td>
    </tr>    

    <tr>
      <td class="lijevi">
        <label for="maxKM"><strong>Maksimalna udaljenost (km):</strong></label>
      </td>
      <td>
        <input type="text" name="maxKM" id="maxKM" size="120" maxlength="100"
          value="<?php if(!isset($_POST['maxKM']))echo $maxKM; else echo $_POST['maxKM'];?>"/>
      </td>
    </tr> 

    <tr>
      <td class="lijevi">
        <label for="minKM"><strong>Minimalna udaljenost(km):</strong></label>
      </td>
      <td>
        <input type="text" name="minKM" id="minKM" size="120" maxlength="100"
          value="<?php if(!isset($_POST['minKM']))echo $minKM; else echo $_POST['minKM'];?>"/>
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






      
