<?php
	include("zaglavlje.php");
	$bp=spojiSeNaBazu();

    $id_dostave = $_GET['dostava_id'];
    $id_korisnika = $_SESSION["aktivni_korisnik_id"];

    $sql = "SELECT dostava.dostavaKM, dostava.dron_id FROM 
    dostava WHERE dostava.dostava_id = '{$id_dostave}'";
    $rs = izvrsiUpit($bp, $sql);
    $red = mysqli_fetch_array($rs);  
    $dostavaKM = $red["dostavaKM"];
   
    if (isset($_POST['submit'])){  

        $datum_vrijeme = date("Y-m-d H:i:s", strtotime($_POST['datum_vrijeme']));
        $dron = $_POST['dron'];
        $sql2 = "SELECT cijenaPoKM FROM vrsta_drona INNER JOIN 
        korisnik ON vrsta_drona.vrsta_drona_id = korisnik.vrsta_drona_id 
        WHERE korisnik.korisnik_id = '{$id_korisnika}'";
        $rs2 = izvrsiUpit($bp, $sql2);
        $red2 = mysqli_fetch_array($rs2);         
        $cijena = $dostavaKM * $red2["cijenaPoKM"];      

        $sql_update = "UPDATE dostava SET status = 1, datum_vrijeme_dostave = '{$datum_vrijeme}', dron_id = '{$dron}', ukupna_cijena = '{$cijena}' WHERE dostava_id = '{$id_dostave}'";
        izvrsiUpit($bp,$sql_update);
           
        header("Location:moderator.php");
    }

?>
<form method="POST" action="<?php echo "{$_SERVER['PHP_SELF']}?dostava_id={$id_dostave}";?>">

<table class="tablicakorisnika">
  <caption>
   Potvrdi narudžbu
  </caption>
	<tbody>  
    <tr>
      <td>
        <label for="datum_vrijeme"><strong>Datum i vrijeme dostave:</strong></label>
      </td>
      <td>
        <input type="text" name="datum_vrijeme" id="datum_vrijeme" size="120" maxlength="100" placeholder="dd.mm.gggg h:m:s"/>
      </td>     
    </tr>
    <tr>
        <td>
            <label for="dron"><strong>Dron:</strong></label>
        </td>
        <td>
        <select id="select" name="dron" required>            
            <?php          
                $sql_select = "SELECT dron.vrsta_drona_id, dron.dron_id as id, dron.naziv as naziv, korisnik.vrsta_drona_id FROM dron
                INNER JOIN korisnik ON dron.vrsta_drona_id = korisnik.vrsta_drona_id
                WHERE korisnik_id = '{$id_korisnika}'";
                $rs_select = izvrsiUpit($bp, $sql_select);
                
                while($row_select = mysqli_fetch_array($rs_select)){
                ?>
        <option value="<?php echo $row_select['id'];?>">
            <?php echo $row_select['naziv'] ?></option>
            <?php
                }            
            ?>
        </select>	
        </td>
    </tr>
    <tr>    
		<td colspan="2" style="text-align:center;">
		    <input type="submit" class ="gumb" name="submit" value="Pošalji"/>
		</td>
	</tr>
      
		</tbody>
	</table>
</form>

<?php
zatvoriVezuNaBazu($bp)
?>