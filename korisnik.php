<?php
	include("zaglavlje.php");
	$bp=spojiSeNaBazu();

?>

<?php
	$greska="";
	if(isset($_POST['submit'])){
		foreach ($_POST as $key => $value)
    if (strlen($value) == 0) {
      if ($key != 'vrsta_drona_id') {
          $greska = "Sva polja za unos su obavezna";
          break;
      }
  }

		if(empty($greska)){
      
      
			$id=$_POST['novi'];
			$tip=$_POST['tip'];
			$kor_ime=$_POST['korime'];
			$lozinka=$_POST['lozinka'];
			$ime=$_POST['ime'];
			$prezime=$_POST['prezime'];
			$email=$_POST['email'];
      $vrsta_drona_id=$_POST['vrsta_drona_id'];
    
      if ($_POST['vrsta_drona_id'] == "" or $_POST['vrsta_drona_id'] == NULL) {
				$vrsta_drona_id = "NULL"; 
			}

			if($id==0){
				if($tip == 2){
					$sql="INSERT INTO korisnik
					(tip_korisnika_id,korime,lozinka,ime,prezime,email,vrsta_drona_id)
					VALUES
					($tip,'$kor_ime','$lozinka','$ime','$prezime','$email',NULL);
					";
			} else {
				$sql="INSERT INTO korisnik
				(tip_korisnika_id,korime,lozinka,ime,prezime,email,vrsta_drona_id)
				VALUES
				($tip,'$kor_ime','$lozinka','$ime','$prezime','$email',$vrsta_drona_id);
				";
			}
				
			}
			else{
				$sql="UPDATE korisnik SET
					tip_korisnika_id='$tip',
          korime='$kor_ime',
					ime='$ime',
					prezime='$prezime',
					lozinka='$lozinka',
					email='$email',
          vrsta_drona_id=$vrsta_drona_id
					WHERE korisnik_id='$id'
				";
			}
			izvrsiUpit($bp,$sql);
			header("Location:korisnici.php");
		}
    
	}
  
 
	if(isset($_GET['korisnik'])){
		$id=$_GET['korisnik'];
		if($aktivni_korisnik_tip==2)$id=$_SESSION["aktivni_korisnik_id"]; 
		$sql="SELECT * FROM korisnik WHERE korisnik_id='$id'";
		$rs=izvrsiUpit($bp,$sql);
    $row = mysqli_fetch_array($rs);

    $id = $row['korisnik_id'];
    $tip = $row['tip_korisnika_id'];
    $kor_ime = $row['korime'];
    $email = $row['email'];
    $lozinka = $row['lozinka'];
    $ime = $row['ime'];
    $prezime = $row['prezime'];
    $vrsta_drona_id=$row['vrsta_drona_id'];
	}
	else{
		$tip=2;
		$kor_ime="";
		$lozinka="";
		$ime="";
		$prezime="";
		$email="";
    $vrsta_drona_id="";
	}
	if(isset($_POST['reset']))header("Location:korisnik.php");
?>
<form method="POST" action="<?php if(isset($_GET['korisnik']))echo "korisnik.php?korisnik=$id";else echo "korisnik.php";?>">
	<table class="tablicakorisnika">
		<caption>
			<?php
				if(isset($id)&&$aktivni_korisnik_id==$id)echo "Uredi moje podatke";
				else if(!empty($id))echo "Uredi korisnika";
				else echo "Dodaj korisnika";
			?>
		</caption>
		<tbody>
			<tr>
				<td colspan="2">
					<input type="hidden" name="novi" value="<?php if(!empty($id))echo $id;else echo 0;?>"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;">
					<label class="greska"><?php if($greska!="")echo $greska; ?></label>
				</td>
			</tr>
			<tr>
				<td class="lijevi">
					<label for="korime"><strong>Korisničko ime:</strong></label>
				</td>
				<td>
					<input type="text" name="korime" id="korime"
						<?php
							if(isset($id))echo "readonly='readonly'";
						?>
						value="<?php if(!isset($_POST['korime']))echo $kor_ime; else echo $_POST['korime'];?>" size="120" minlength="4" maxlength="50"
						placeholder="Korisničko ime ne smije sadržavati praznine, treba uključiti minimalno 4 znakova i započeti malim početnim slovom"
						required="required"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="ime"><strong>Ime:</strong></label>
				</td>
				<td>
					<input type="text" name="ime" id="ime" value="<?php if(!isset($_POST['ime']))echo $ime; else echo $_POST['ime'];?>"
						size="120" minlength="1" maxlength="50" placeholder="Ime treba započeti velikim početnim slovom" required="required"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="prezime"><strong>Prezime:</strong></label>
				</td>
				<td>
					<input type="text" name="prezime" id="prezime" value="<?php if(!isset($_POST['prezime']))echo $prezime; else echo $_POST['prezime'];?>"
						size="120" minlength="1" maxlength="50" placeholder="Prezime treba započeti velikim početnim slovom" required="required"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="lozinka"><strong>Lozinka:</strong></label>
				</td>
				<td>
					<input <?php if(!empty($lozinka))echo "type='text'"; else echo "type='password'";?>
						name="lozinka" id="lozinka" value="<?php if(!isset($_POST['lozinka']))echo $lozinka; else echo $_POST['lozinka'];?>"
						size="120" minlength="6" maxlength="50"
						placeholder="Lozinka treba sadržati minimalno 6 znakova uključujući jedno veliko i jedno malo slovo, jedan broj i jedan posebni znak"
						required="required"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="email"><strong>E-mail:</strong></label>
				</td>
				<td>
					<input type="email" name="email" id="email" value="<?php if(!isset($_POST['email']))echo $email; else echo $_POST['email'];?>"
						size="120" minlength="5" maxlength="50" placeholder="Ispravan oblik elektroničke pošte je nesto@nesto.nesto" required="required"/>
				</td>
			</tr>
			<?php
				if($_SESSION['aktivni_korisnik_tip']==0){
			?>
			<tr>
				<td><label for="tip"><strong>Tip korisnika:</strong></label></td>
				<td>
					<select id="tip" name="tip">
						<?php
							$sql_tipovi = "SELECT * FROM tip_korisnika";
							$rezultat_tipovi = izvrsiUpit($bp,  $sql_tipovi);
							while($red_tipovi = mysqli_fetch_array($rezultat_tipovi)){
								$vrijednost = $red_tipovi['tip_korisnika_id'];
								$naziv = $red_tipovi['naziv'];
								echo "<option value='{$vrijednost}' ";
								if(isset($_POST['tip'])){									
									if($_POST['tip'] == $vrijednost){
										echo "selected";
									}									
								}else{
									if($tip == $vrijednost){
										echo "selected";
									}
								}
								echo ">$naziv</option>";
							}				
						?>
					</select>
				</td>
			</tr>
      <tr>
				<?php if($aktivni_korisnik_tip==0 || $aktivni_korisnik_tip ==1){  ?>
				<td><label for="vrsta_drona_id"><strong>Vrsta drona:</strong></label></td>
				<td>
					<select id="vrsta_drona_id" name="vrsta_drona_id" <?php if(isset($_GET['korisnik']) && $tip == 2){ echo "disabled='disabled'"; } ?> >
						<?php $sql_izbornik = "SELECT * FROM vrsta_drona";
						$rezultat_izbornik = izvrsiUpit($bp, $sql_izbornik);
						while($red_izbornik = mysqli_fetch_array($rezultat_izbornik)){
							$vrijednost = $red_izbornik['vrsta_drona_id'];
							$naziv = $red_izbornik['naziv'];
							echo "<option value='{$vrijednost}' ";
							if($vrijednost == $vrsta_drona_id){
								echo "selected";
							}
							echo ">$naziv</option>";
						}}
						?>
					</select>
				</td>
				
			</tr>
		
			<?php
				}
			?>
			<tr>
				<td colspan="2" style="text-align:center;">
					<?php
						if(isset($id)&&$aktivni_korisnik_id==$id||!empty($id))echo '<input class="gumb" type="submit" name="submit" value="Pošalji"/>';
						else echo '<input class="gumb" type="submit" name="reset" value="Izbriši"/><input class="gumb" type="submit" name="submit" value="Pošalji"/>';
					?>
				</td>
			</tr>
		</tbody>
	</table>
</form>

<?php
	zatvoriVezuNaBazu($bp);
?>