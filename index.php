<?php
  include("zaglavlje.php");
	$bp=spojiSeNaBazu();
  
  if($aktivni_korisnik_tip == 0 or $aktivni_korisnik_tip == 1 or $aktivni_korisnik_tip == 2){
  $sql="SELECT d.dron_id, d.vrsta_drona_id, d.poveznica_slika, d.naziv AS naziv_drona, v.naziv AS naziv_vrste, v.minKM, v.maxKM, v.cijenaPoKM
  FROM dron d
  INNER JOIN vrsta_drona v ON d.vrsta_drona_id = v.vrsta_drona_id;";
	$rs=izvrsiUpit($bp,$sql);
  }else{
    $sql = "SELECT d.dron_id, d.vrsta_drona_id, d.poveznica_slika, d.naziv AS naziv_drona, v.naziv AS naziv_vrste, v.minKM, v.maxKM, v.cijenaPoKM, COUNT(ds.dron_id) AS ukupno_dostavaKM
        FROM dron d
        INNER JOIN vrsta_drona v ON d.vrsta_drona_id = v.vrsta_drona_id
        INNER JOIN dostava ds ON d.dron_id = ds.dron_id
        GROUP BY d.dron_id
        ORDER BY ukupno_dostavaKM DESC
        LIMIT 5";
    $rs=izvrsiUpit($bp,$sql);
  }
 
  
      

  if(isset($_GET['sortiraj'])){
    if($_GET['sortiraj']=="a-z"){
      $sql="SELECT d.dron_id, d.vrsta_drona_id, d.poveznica_slika, d.naziv AS naziv_drona, v.naziv AS naziv_vrste, v.minKM, v.maxKM, v.cijenaPoKM
      FROM dron d
      INNER JOIN vrsta_drona v ON d.vrsta_drona_id = v.vrsta_drona_id
      ORDER BY naziv_drona ASC;";
      $rs=izvrsiUpit($bp,$sql);
    }elseif($_GET['sortiraj']=="z-a"){
      $sql="SELECT d.dron_id, d.vrsta_drona_id, d.poveznica_slika, d.naziv AS naziv_drona, v.naziv AS naziv_vrste, v.minKM, v.maxKM, v.cijenaPoKM
      FROM dron d
      INNER JOIN vrsta_drona v ON d.vrsta_drona_id = v.vrsta_drona_id
      ORDER BY naziv_drona DESC;";
      $rs=izvrsiUpit($bp,$sql);
    }elseif($_GET['sortiraj']=="csilazno"){
      $sql="SELECT d.dron_id, d.vrsta_drona_id, d.poveznica_slika, d.naziv AS naziv_drona, v.naziv AS naziv_vrste, v.minKM, v.maxKM, v.cijenaPoKM
      FROM dron d
      INNER JOIN vrsta_drona v ON d.vrsta_drona_id = v.vrsta_drona_id
      ORDER BY cijenaPoKM DESC;";
      $rs=izvrsiUpit($bp,$sql);
    }elseif($_GET['sortiraj']=="cuzlazno"){
      $sql="SELECT d.dron_id, d.vrsta_drona_id, d.poveznica_slika, d.naziv AS naziv_drona, v.naziv AS naziv_vrste, v.minKM, v.maxKM, v.cijenaPoKM
      FROM dron d
      INNER JOIN vrsta_drona v ON d.vrsta_drona_id = v.vrsta_drona_id
      ORDER BY cijenaPoKM ASC;";
      $rs=izvrsiUpit($bp,$sql);
    }
    
  }
  
?>

  <h2>Dronovi</h2>
<?php if($aktivni_korisnik_tip == 0 or $aktivni_korisnik_tip == 1 or $aktivni_korisnik_tip == 2){  ?>
  <form action="" method="get" id="sortform">
    <select name="sortiraj" id="sortiraj">
      <option value="">Izaberi sortiranje</option>
      <option value="a-z" <?php if(isset($_GET['sortiraj']) && $_GET['sortiraj']=="a-z"){echo "selected";} ?>>A-Z prema nazivu</option>
      <option value="z-a" <?php if(isset($_GET['sortiraj']) && $_GET['sortiraj']=="z-a"){echo "selected";} ?>>Z-A prema nazivu</option>
      <option value="csilazno" <?php if(isset($_GET['sortiraj']) && $_GET['sortiraj']=="csilazno"){echo "selected";} ?>>silazno prema cijeni</option>
      <option value="cuzlazno" <?php if(isset($_GET['sortiraj']) && $_GET['sortiraj']=="cuzlazno"){echo "selected";} ?>>uzlazno prema cijeni</option>
    </select>
    <button type="submit" class="gumb">Sortiraj</button>
  </form>
   <?php } ?> 
	<?php
   if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==0)echo '<div class="drondod"><a class="link" href="moderator_dodaj_drona.php">Dodaj drona</a></div>';

  echo '<div class="dronovi">';
 
  
  while ($row = mysqli_fetch_array($rs)) {
    $dron_id = $row['dron_id'];
    $vrsta_drona_id = $row['vrsta_drona_id'];
    $poveznica_slika = $row['poveznica_slika'];
    $naziv_drona = $row['naziv_drona'];
    $naziv_vrste = $row['naziv_vrste'];
    $minKM = $row['minKM'];
    $maxKM = $row['maxKM'];
    $cijenaPoKM = $row['cijenaPoKM'];

      echo '<div class="dron">';
      echo '<img src="' . $poveznica_slika . '" alt="' . $naziv_drona . '">';
      echo '<h4>' . $naziv_drona . '</h4>';
      echo '<p> Vrsta: '.$naziv_vrste.'<br></p>';
      echo '<p> MinKM: '.$minKM.'<br></p>';
      echo '<p> MaxKM: '.$maxKM.'<br></p>';
      echo '<p> Cijena po kilometru: '.$cijenaPoKM.'<br></p>';
 
      if(($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==0) && $vrsta_drona==$vrsta_drona_id) echo "<a href='dronovi.php?dronovi=$dron_id' class='link'>Uredi</a>";

      echo '</div>';
  }
  echo '</div>';  
?>
</body>
</html>

<?php
zatvoriVezuNaBazu($bp);
?>

