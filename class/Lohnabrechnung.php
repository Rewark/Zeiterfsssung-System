<?php
include("class\\ArbeitzeitRechnen.php");
include("class\\Mitarbeiter.php");
class Lohnabrechnung{
    private $zeit;
    Private $dbc;

    public function brutto($lastname, $datum){
        $aZeit = new ArbeitzeitRechnen(); 
        $dbc = new DbController();
        $obj = $dbc->getMitarbeiter($lastname);

        $mitarbeiter = new Mitarbeiter($obj[0]['firstname'], $obj[0]['lastname'], $obj[0]['salary_pro_hour']);
        $zeit = $aZeit->zeitRechnen($lastname, $datum);

        ///var_dump($mitarbeiter);

        $arbeitSt = ($zeit['tst'] - $zeit['fehla']) * $mitarbeiter->get_salary_per_hor();
        $extraSt = $zeit['exst'] * $mitarbeiter->get_salary_per_hor();
        $urlaubSt = $zeit['urlst'] * $mitarbeiter->get_salary_per_hor();
        $krank = $zeit['fehlk'] * $mitarbeiter->get_salary_per_hor();
        $zuschlag = $zeit['we'] * $mitarbeiter->get_salary_per_hor() * $_POST['percent'] /100;
        $wochenEndeSt = $zeit['we'] * $mitarbeiter->get_salary_per_hor();

        $sume = $arbeitSt + $extraSt + $urlaubSt + $krank + $wochenEndeSt + $zuschlag;

        
        $brutto = array('arst'=> $arbeitSt, 'wen'=>$wochenEndeSt,
         'urls'=>$urlaubSt, 'ubers'=>$extraSt, 'krs'=>$krank, 'sume'=>$sume, 'zus'=>$zuschlag,
          'fname'=>$mitarbeiter->get_firstName(), 'lname'=>$mitarbeiter->get_lastName());

        return $brutto;
        
    }

}

?>