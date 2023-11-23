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

	$sql="SELECT COUNT(*) FROM vrsta_drona";
	$rs=izvrsiUpit($bp,$sql);
	$red=mysqli_fetch_array($rs);
	$vel_str=10;
	$broj_redaka=$red[0];
	$broj_stranica=ceil($broj_redaka/$vel_str);


	$sql="SELECT * FROM vrsta_drona LIMIT ".$vel_str;
	if(isset($_GET['stranica'])){
		$sql=$sql." OFFSET ".(($_GET['stranica']-1)*$vel_str);
		$aktivna=$_GET['stranica'];
	}
	else $aktivna = 1;

	$rs=izvrsiUpit($bp,$sql);
	echo "<table class='tablicakorisnika'>";
	echo "<caption>Popis vrsta dronova</caption>";
	echo "<thead><tr>
		<th>Vrsta drona</th>
		<th>Cijena po kilometru</th>
		<th>Minimalna udaljenost (km)</th>
		<th>Maksimalna udaljenost (km)</th>		
		<th class='izbrisi'></th>";
	echo "</tr></thead>";

	echo "<tbody>";
	while(list($vrsta_drona_id,$naziv,$minKM,$maxKM,$cijenaPoKM)=mysqli_fetch_array($rs)){											
		echo "<tr>
			<td>$naziv</td>
            <td>$cijenaPoKM</td>
			<td>$minKM</td>
            <td>$maxKM</td>";
			if($aktivni_korisnik_tip==0) echo "<td class='izbrisi'><a id='uredi' href='vrsta.php?vrsta=$vrsta_drona_id'>UREDI</a></td>";
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
	if($aktivni_korisnik_tip==0)echo '<a class="link" href="vrsta_dodaj.php">DODAJ VRSTU DRONA</a>';
	echo '</div>';

?>

<?php
	zatvoriVezuNaBazu($bp);
?>

