<?php
function trenutnaForma() {
  $trenutnaForma = $_POST["form_name"];

  if (!isset($trenutnaForma)) {
      return null;
  }

  return $trenutnaForma;
}

function validacija() {
    $greska = "";
    $forma = trenutnaForma();

    switch ($forma) {
        case "prijava":
            $kor_ime = $_POST["korisnicko_ime"];
            $lozinka = $_POST["lozinka"];
            $greska_div = '<div class="greska">';

            if ($kor_ime == "" || $lozinka == "") {
                $greska = "Molim unesite korisničko ime i lozinku<br/>";
                echo $greska_div . $greska . '</div>';
            }

            if (strlen($greska) != 0) {
                return false;
            }
            break;

        default:
            break;
    }
  }


?>