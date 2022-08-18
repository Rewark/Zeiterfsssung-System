<?php



class ArbeitZeit{
    
    private $arbeitTag;
    private $startTime;
    private $endeTime;
    private $m_id;
 

    function __construct($arbeitTag, $startTime, $endeTime, $m_id){
        $this->arbeitTag = $arbeitTag;
        $this->startTime = $startTime;
        $this->endeTime = $endeTime;
        $this->m_id = $m_id;
    }



    function get_startTime(){
        return $this->startTime;
    }

    function set_arbeitTag($start){
        $this->arbeitTag = $start;
    }

    function get_arbeitTag(){
        return $this->arbeitTag;
    }

    function get_endeTime(){
        return $this->endeTime;
    }

    function get_m_id(){
        return $this->m_id;
    }

   /* function arbeitZeitRechnen($id){
        $dbc = new DbController();


    }*/

    public function isWeekend($zeit){
        $this->weekDay = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
       
        $day = $this->weekDay[date("w", strtotime($zeit))];
        if($day == "Sonntag" || $day == "Samstag"){
            //echo $day;
            return true;
        }
        else{
           // echo $day;
            return false;
        }
        
    }

    public function isUrlaub($data){
        
        $uTage = array(); 

        foreach($data as $value){
            $tage = (int)$value["ende_date"] - (int)$value["start_date"];
            $last = substr($value["start_date"], 2, strlen($value["start_date"]));
            $tag = substr($value["start_date"],0,2);
   
            for($i = 0; $i <= $tage; $i++){
                
                $first = (int)$tag++;
                
                $ut =  array((string)$first . $last);
   
                   array_push($uTage, $ut[0]);
                 
            }
            
        }
        return $uTage;
    }
        
    


        
    
}




?>