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

<?php
	include("zaglavlje.php");
	$bp=spojiSeNaBazu();
?>

<?php



	$sql="SELECT COUNT(*) FROM korisnik";
	$rs=izvrsiUpit($bp,$sql);
	$red=mysqli_fetch_array($rs);
	$vel_str=10;
	$broj_redaka=$red[0];
	$broj_stranica=ceil($broj_redaka/$vel_str);


	$sql="SELECT * FROM korisnik ORDER BY korisnik_id LIMIT ".$vel_str;
	if(isset($_GET['stranica'])){
		$sql=$sql." OFFSET ".(($_GET['stranica']-1)*$vel_str);
		$aktivna=$_GET['stranica'];
	}
	else $aktivna = 1;

	$rs=izvrsiUpit($bp,$sql);
	echo "<table class='tablicakorisnika'>";
	echo "<caption>Popis korisnika sustava</caption>";
	echo "<thead><tr>
		<th>Korisničko ime</th>
		<th>Ime</th>
		<th>Prezime</th>
		<th>E-mail</th>
		<th>Lozinka</th>
		<th class='izbrisi'></th>";
	echo "</tr></thead>";

	echo "<tbody>";
	while(list($id,$tip,$vrsta,$kor_ime,$email,$lozinka,$ime,$prezime)=mysqli_fetch_array($rs)){											
		echo "<tr>
			<td>$kor_ime</td>
			<td>$ime</td>";
		echo "<td>".(empty($prezime)?"&nbsp;":"$prezime")."</td>
			<td>".(empty($email)?"&nbsp;":"$email")."</td>
			<td>$lozinka</td>";
			if($aktivni_korisnik_tip==0||$aktivni_korisnik_tip==1)echo "<td class='izbrisi'><a id='uredi' href='korisnik.php?korisnik=$id'>UREDI</a></td>";
			else if(isset($_SESSION["aktivni_korisnik_id"])&&$_SESSION["aktivni_korisnik_id"]==$id) echo '<td class="izbrisi"><a id="uredi" href="korisnik.php?korisnik='.$_SESSION["aktivni_korisnik_id"].'">UREDI</a></td>';
			else echo "<td></td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";


	echo '<div id="paginacija">';

	if($aktivna!=1){
		$prethodna=$aktivna-1;
		echo "<a class='link' href=\"korisnici.php?stranica=".$prethodna."\">&lt;</a>";
	}
	for($i=1;$i<=$broj_stranica;$i++){
		echo "<a class='link";
		if($aktivna==$i)echo " aktivna"; 
		echo "' href=\"korisnici.php?stranica=".$i."\">$i</a>";
	}

	if($aktivna<$broj_stranica){
		$sljedeca=$aktivna+1;
		echo "<a class='link' href=\"korisnici.php?stranica=".$sljedeca."\">&gt;</a>";
	}
	echo "<br/>";
	if($aktivni_korisnik_tip==0||$aktivni_korisnik_tip==1)echo '<a class="link" href="korisnik.php">DODAJ KORISNIKA</a>';
	if(isset($_SESSION["aktivni_korisnik_id"]))echo '<a class="link" href="korisnik.php?korisnik='.$_SESSION["aktivni_korisnik_id"].'">UREDI MOJE PODATKE</a>';
	echo '</div>';

?>

<?php
	zatvoriVezuNaBazu($bp);
?>

