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
<table class='tablicakorisnika'>
  <caption>Statistika prijeđenih kilometara</caption>
    <thead>
      <tr>
        <th>ID drona</th>
        <th>Naziv drona</th>
        <th>Slika</th>
        <th>Prijeđeni kilometri</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    $sql = "SELECT naziv, poveznica_slika, dostava.dron_id AS dostava_id, SUM(dostavaKM) AS kilometri, 
    dron.dron_id AS dronovi_id 
    FROM dostava 
    INNER JOIN dron ON dostava.dron_id = dron.dron_id
    GROUP BY dronovi_id";
    $rs = izvrsiUpit($bp, $sql);
    
    while($row = mysqli_fetch_array($rs)){
      $id_drona = $row['dronovi_id'];
      $naziv_drona = $row['naziv'];
      $poveznica = $row['poveznica_slika'];
      $prijedeno = $row['kilometri'];

    echo "
      <tr>
        <td>$id_drona</td>
        <td>$naziv_drona</td>
        <td><img src='{$poveznica}'></td>
        <td>$prijedeno</td>
      </tr>";
    }
    echo "
    </tbody>
	</table>";
  ?>
</html>
