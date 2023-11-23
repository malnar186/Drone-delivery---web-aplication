
<?php
	include("zaglavlje.php");
	$bp=spojiSeNaBazu();
	
?>
<?php
	if(isset($_GET['logout'])){
		unset($_SESSION["aktivni_korisnik"]);
		unset($_SESSION['aktivni_korisnik_ime']);
		unset($_SESSION["aktivni_korisnik_tip"]);
		unset($_SESSION["aktivni_korisnik_id"]);
		unset($_SESSION["vrsta_drona_id"]);
		session_destroy();
		header("Location:index.php");
		
	}

	$greska= "";
	if(isset($_POST['submit'])){
		$kor_ime=mysqli_real_escape_string($bp,$_POST['korime']);
		$lozinka=mysqli_real_escape_string($bp,$_POST['lozinka']);

		if(!empty($kor_ime)&&!empty($lozinka)){
			$sql="SELECT korisnik_id,tip_korisnika_id,ime,prezime,vrsta_drona_id FROM korisnik WHERE korime='$kor_ime' AND lozinka='$lozinka'";
			$rs=izvrsiUpit($bp,$sql);
			if(mysqli_num_rows($rs)==0)$greska="Ne postoji korisnik s navedenim korisničkim imenom i lozinkom";
			else{
				list($id,$tip,$ime,$prezime,$vrsta_drona)=mysqli_fetch_array($rs);
				$_SESSION['aktivni_korisnik']=$kor_ime;
				$_SESSION['aktivni_korisnik_ime']=$ime." ".$prezime;
				$_SESSION["aktivni_korisnik_id"]=$id;
				$_SESSION['aktivni_korisnik_tip']=$tip;
				$_SESSION["vrsta_drona_id"]=$vrsta_drona;
				header("Location:index.php");
			}
		}
		else $greska = "Molim unesite korisničko ime i lozinku";
	}
?>

  <div class="prijava" id="login">
  <h2 class="naslovprijava">Prijava</h2>
  <?php if($greska!="")echo $greska; ?>
  <form action="prijava.php" method="POST" id="pforma" onsubmit="return validacija();">
  <label for="korime">Korisničko ime:</label> <br>
  <input id="korime" name="korime" required=""><br>
  <label for="lozinka">Lozinka:</label> <br>
  <input type="password" name="lozinka" id="lozinka"> <br>
  <input type="submit" name="submit" value="Prijavi se" class="gumb"> 
  </form>
  </div>
<?php
zatvoriVezuNaBazu($bp)
?>
  