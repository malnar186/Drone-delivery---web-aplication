<?php
include("zaglavlje.php");
$bp=spojiSeNaBazu();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>IWA iwa_2022_vz_projekt</title>
		<meta name="autor" content="Jan Malnar"/>
		<meta name="datum" content="20.06.2023."/>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css"
			   href="css\style.css"/>
	</head>
</html>
<?php
$greska = "";
if(isset($_POST['submit'])){
  foreach ($_POST as $key => $value)if(strlen($value)==0)$greska="Sva polja za unos su obavezna";
  if(empty($greska)){
    $adresa_polazista = $_POST['adresa_polazista'];
    $adresa_dostave = $_POST['adresa_dostave'];
    $opis_posiljke = $_POST['opis_posiljke'];
    $dostavakg = $_POST['dostavaKG'];
    $dostavakm= $_POST['dostavaKM'];
    $hitnost = $_POST['hitnost'];
		$napomene = $_POST['napomene'];
		$id = $_POST['dostava_id'];
    
		if($id == 0){
      $sql = "INSERT INTO dostava (korisnik_id, datum_vrijeme_zahtjeva, adresa_polazista, adresa_dostave, opis_posiljke, dostavaKG, dostavaKM, hitnost, napomene, status)
                    VALUES ($_SESSION[aktivni_korisnik_id], \"".date("Y-m-d H:i:s")."\", '$adresa_polazista', '$adresa_dostave', '$opis_posiljke', '$dostavakg','$dostavakm','$hitnost','$napomene', 0)";
}else {
	$sql="UPDATE dostava
	SET adresa_polazista = '$adresa_polazista',
			adresa_dostave = '$adresa_dostave',
			opis_posiljke= '$opis_posiljke',
			dostavaKG = '$dostavakg',
			dostavaKM = '$dostavakm',
			hitnost = '$hitnost',
			napomene = '$napomene'
	WHERE dostava_id = $id;";
}

izvrsiUpit($bp, $sql);
header("Location:index.php");

	}}

	if(isset($_GET['narudzba'])){
		$id = $_GET['narudzba'];
		if($aktivni_korisnik_tip==2)$id=$_SESSION["aktivni_korisnik_id"];
		$sql = "SELECT * 
						FROM dostava
						WHERE dron_id = $id";
		$rs = izvrsiUpit($bp, $sql);
		$row = mysqli_fetch_array($rs);
	
		$adresa_polazista = $row['adresa_polazista'];
		$adresa_dostave = $row['adresa_dostave'];
		$opis_posiljke = $row['opis_posiljke'];
		$dostavakg = $row['dostavaKG'];
		$dostavakm = $row['dostavaKM'];
		$hitnost = $row['hitnost'];
		$napomene = $row['napomene'];

	}
	else{
		$id="";
		$adresa_polazista = "";
		$adresa_dostave = "";
		$opis_posiljke = "";
		$dostavakg  = "";
		$dostavakm = "";
		$hitnost = "";
		$napomene = "";
	}
		if(isset($_POST['reset']))header("Location:narudzba.php");
	?>
	<form method="POST" action="<?php if(isset($_GET['narudzba']))echo "narudzba.php?narudzba=$id";else echo "narudzba.php";?>">
<table class="tablicakorisnika">
  <caption>
   Zatraži dostavu
  </caption>
	<tbody>
		<tr>
			<td>
				<input type="hidden" name="dostava_id" id="dostava_id" value="<?php if(!empty($id)) echo $id; else echo 0; ?>">
			</td>
		</tr>
    <tr>
      <td>
        <label for="adresa_polazista"><strong>Adresa polazišta:</strong></label>
      </td>
      <td>
      <input type="text" name="adresa_polazista" id="adresa_polazista" size="120" maxlength="100"  value=" <?php $adresa_polazista ?>"/>
      </td>
    </tr>
		<tr>
      <td>
        <label for="adresa_dostave"><strong>Adresa dostave:</strong></label>
      </td>
      <td>
      <input type="text" name="adresa_dostave" id="adresa_dostave" size="120" maxlength="100"  value=" <?php $adresa_dostave ?>"/>
      </td>
    </tr>
		<tr>
      <td>
        <label for="opis_posiljke"><strong>Opis pošiljke:</strong></label>
      </td>
      <td>
      <input type="textarea" name="opis_posiljke" id="opis_posiljke" size="120" maxlength="100"  value=" <?php $opis_posiljke; ?>"/>
      </td>
    </tr>
		<tr>
      <td>
        <label for="dostavaKG"><strong>Težina dostave:</strong></label>
      </td>
      <td>
      <input type="text" name="dostavaKG" id="dostavaKG" size="120" maxlength="100"  value=" <?php $dostavakg ?>"/>
      </td>
    </tr>
		<tr>
      <td>
        <label for="dostavaKM"><strong>Duljina dostave:</strong></label>
      </td>
      <td>
      <input type="text" name="dostavaKM" id="dostavaKM" size="120" maxlength="100"  value=" <?php $dostavakm ?>"/>
      </td>
    </tr>
		<tr>
      <td>
        <label for="hitnost"><strong>hitnost dostave:</strong></label>
      </td>
      <td>
      <select  name="hitnost" id="hitnost" >
				<option value="0">Nije hitno</option>
				<option value="1">Hitno</option>
			</select>
			
      </td>
    </tr>
		<tr>
      <td>
        <label for="napomene"><strong>Napomene:</strong></label>
      </td>
      <td>
      <input type="textarea" name="napomene" id="napomene" size="120" maxlength="100"  value=" <?php $napomene ?>"/>
      </td>
    </tr>
    
				<td colspan="2" style="text-align:center;">
					<?php
						if(isset($id)&&$aktivni_korisnik_id==$id||!empty($id))echo '<input class="gumb" type="submit" name="submit" value="Pošalji"/>';
						else echo '<input type="submit" class ="gumb" name="submit" value="Pošalji"/><input class="gumb" type="submit" name="reset" value="Izbriši"/>';
					?>
				</td>
			</tr>
      
		</tbody>
	</table>
</form>

<?php zatvoriVezuNaBazu($bp); ?>