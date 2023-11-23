<?php
	include("baza.php");
	if(session_id()=="")session_start();

	$bp=spojiSeNaBazu();
	$trenutna=basename($_SERVER["PHP_SELF"]);
	$putanja=$_SERVER['REQUEST_URI'];
	$aktivni_korisnik=0;
	$aktivni_korisnik_tip=-1;
	$vrsta_drona = "";


	
	if(isset($_SESSION['aktivni_korisnik'])){
		$aktivni_korisnik=$_SESSION['aktivni_korisnik'];
		$aktivni_korisnik_ime=$_SESSION['aktivni_korisnik_ime'];
		$aktivni_korisnik_tip=$_SESSION['aktivni_korisnik_tip'];
		$aktivni_korisnik_id=$_SESSION["aktivni_korisnik_id"];
		$vrsta_drona=$_SESSION["vrsta_drona_id"];
		
	}
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
	<body onload="forma();">
  
  <header class="naslov">
  <div class="zaglavlje">
	<?php
					echo "<strong>Trenutna lokacija: </strong>".$trenutna."<br/>";
					if($aktivni_korisnik===0){
						echo "<span><strong>Status: </strong>Neprijavljeni korisnik</span><br/>";
						echo "<a class='link'  href='prijava.php'>prijava</a>";
					}
					elseif($aktivni_korisnik_tip===1){
						echo "<span><strong>Status: </strong>Dobrodošli, $aktivni_korisnik_ime</span><br/>";
						echo "<a class='link'  href='prijava.php?logout=1'>odjava</a>";
						
					}else{
						echo "<span><strong>Status: </strong>Dobrodošli, $aktivni_korisnik_ime</span><br/>";
						echo "<a class='link'  href='prijava.php?logout=1'>odjava</a>";
					}
				?>
	</div> 
  <h1>Dostava dronom</h1>
  				
			
		</header>
    <nav class="meni" id="navigacija">
		<?php
				if ($trenutna) {
					if ($aktivni_korisnik_tip == 0) {
						echo '<a class ="navbtn" href="index.php"';
						if ($trenutna == "index.php") echo ' class="aktivna" id="btnaktiv"';
						echo ">Početna</a>";
			
						echo '<a class ="navbtn" href="oautoru.html"';
						if ($trenutna == "oautoru.html") echo ' class="aktivna" id="btnaktiv" ';
						echo ">O autoru</a>";
			
						echo '<a class ="navbtn" href="korisnici.php"';
						if ($trenutna == "korisnici.php") echo ' class="aktivna" id="btnaktiv"';
						echo ">Korisnici</a>";
			
						echo '<a class ="navbtn" href="narudzba.php" id="btnaktiv"';
						if ($trenutna == "narudzba.php") echo ' class="aktivna"';
						echo ">Narudžba</a>";

						echo '<a class ="navbtn" href="dostave.php"';
						if ($trenutna == "dostave.php") echo ' class="aktivna" id="btnaktiv"';
						echo ">Popis zahtjeva</a>";

						echo '<a class ="navbtn" href="moderator.php"';
						if ($trenutna == "moderator.php") echo ' class="aktivna" id="btnaktiv"';
						echo ">Popis zahtjeva za potvrdu</a>";

						echo '<a class ="navbtn" href="vrste_dronova.php"';
						if ($trenutna == "vrste_dronova.php") echo ' class="aktivna" id="btnaktiv"';
						echo ">Vrste dronova</a>";

					} elseif($aktivni_korisnik_tip == 1){
						echo '<a class ="navbtn" href="index.php" id="btnaktiv"';
						if ($trenutna == "index.php") echo ' class="aktivna"';
						echo ">Početna</a>";
			
						echo '<a class ="navbtn" href="oautoru.html" id="btnaktiv"';
						if ($trenutna == "oautoru.html") echo ' class="aktivna"';
						echo ">O autoru</a>";

						echo '<a href="narudzba.php" id="btnaktiv"';
						if ($trenutna == "narudzba.php") echo ' class="aktivna" id="btnaktiv"';
						echo ">Narudžba</a>";

						echo '<a class ="navbtn" href="dostave.php"';
						if ($trenutna == "dostave.php") echo ' class="aktivna" id="btnaktiv"';
						echo ">Popis zahtjeva</a>";

						echo '<a class ="navbtn" href="moderator.php"';
						if ($trenutna == "moderator.php") echo ' class="aktivna" id="btnaktiv"';
						echo ">Popis zahtjeva za potvrdu</a>";

						echo '<a class ="navbtn" href="moderator_statistika.php"';
						if ($trenutna == "moderator_statistika.php") echo ' class="aktivna" id="btnaktiv"';
						echo ">Statistika</a>";

					}elseif($aktivni_korisnik_tip == 2){
						echo '<a href="index.php" id="btnaktiv"';
						if ($trenutna == "index.php") echo ' class="aktivna" id="btnaktiv"';
						echo ">Početna</a>";
			
						echo '<a href="oautoru.html" id="btnaktiv"';
						if ($trenutna == "oautoru.html") echo ' class="aktivna" id="btnaktiv"';
						echo ">O autoru</a>";
						echo '<a href="narudzba.php" id="btnaktiv"';
						if ($trenutna == "narudzba.php") echo ' class="aktivna" id="btnaktiv"';
						echo ">Narudžba</a>";
						echo '<a class ="navbtn" href="dostave.php"';
						if ($trenutna == "dostave.php") echo ' class="aktivna" id="btnaktiv"';
						echo ">Popis zahtjeva</a>";
					}else{
						echo '<a href="index.php" id="btnaktiv"';
						if ($trenutna == "index.php") echo ' class="aktivna" id="btnaktiv"';
						echo ">Početna</a>";
			
						echo '<a href="oautoru.html" id="btnaktiv"';
						if ($trenutna == "oautoru.html") echo ' class="aktivna" id="btnaktiv"';
						echo ">O autoru</a>";
					}
				}
						
			?>
  </nav>
    




	

		