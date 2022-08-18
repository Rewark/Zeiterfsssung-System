<?php
include("class\\DbController.php");


class ArbeitzeitRechnen{
    private $arbeitZeit;
    private $dbc;
    private $urlaub;
    private $fehlzeit;


    public function zeitRechnen($lastname, $datum){
        $dbc = new DbController();
        $data = $dbc->getArbeitzeit($lastname);

        $st = 0; $t = 0; $we = 0; $extra = 0; $url = 0;
        foreach($data as $value){
            $arbeitZeit = new ArbeitZeit($value["arbeit_tag"], $value["start_time"], $value["ende_time"], $value["mit_id_f"]);
            $da = substr($arbeitZeit->get_arbeitTag(),3, strlen($arbeitZeit->get_arbeitTag()));
            if($da == $datum){ 
                if($arbeitZeit->isWeekend($arbeitZeit->get_arbeitTag())){
                    $we += (int)$arbeitZeit->get_endeTime()-(int)$arbeitZeit->get_startTime();
                    
                }
                else{
                    
                    $wt = (float)$arbeitZeit->get_endeTime()-(float)$arbeitZeit->get_startTime();
                    if($wt > 8){
                        $b = (float)$wt - 8;
                        
                        $c = $wt - $b;
                        $t += $c ;
                        $extra += $b;
                    }
                    else{
                        $st += $wt;
                    }

                    $stunden = $st + $t;
                
                }
            }
        }
        

        $grund = $dbc->getGrund();
        $grund_id = $grund[0]['id']; 
         $fehlz = $dbc->getFehlzeit($lastname);
         $gru_id = 0;
         $gru_id = $fehlz[0]['gru_id_f'];
         $fehlzeit =$arbeitZeit->isUrlaub($fehlz);

         $g_krank = array();$a_grund = array(); $a_gru = 0; $g_kr = 0; 
        foreach($fehlzeit as $value){
            if(!$arbeitZeit->isWeekend($value)){
                $da = substr($value,3, strlen($value));
                if($da == $datum){
                   // var_dump($value);
                    if($gru_id == $grund_id){ 
                        array_push($g_krank, $value);
                        $length = count($g_krank);
                        $g_kr = $length * 8;
                    }else{
                        array_push($a_grund, $value);
                        $length = count($a_grund,);
                        
                        $a_gru = $length * 8;
                    }
                }
            }

        }
        $uz = $dbc->getUrlaub($lastname);
        $urlaub = $arbeitZeit->isUrlaub($uz);
        //var_dump($urlaub);
        $url = array(); $urlSt = 0;
        foreach($urlaub as $value){
            $da = substr($value,3, strlen($value));
            if($da == $datum){
                if(!$arbeitZeit->isWeekend($value)){
                    
                    array_push($url, $value);
            
                }
                $length = count($url);
                $urlSt = $length * 8;
            }
        }

    
        
        
        $arbeitStunde = array("we"=>$we, "tst"=> $stunden, "exst"=> $extra, "urlst"=>$urlSt, "fehlk"=>$g_kr, "fehla"=>$a_gru);
       // var_dump($arbeitStunde);
        return $arbeitStunde;
    }
    

}



?>