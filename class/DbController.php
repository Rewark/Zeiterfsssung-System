<?php

include("class\\dbconnect.php");
include("class\\ArbeitZeit.php");

class DbController {

    private $db = null;
    
    public function __construct(){
        $this->db = new DbConnect();
    }

    function get_db(){
        return $this->db;
    }


    public function create_table(){
    
        

        $mitarbeiter = "CREATE TABLE IF NOT EXISTS  mitarbeiter(
            id INT(10) NOT NULL AUTO_INCREMENT,
             firstname VARCHAR(50),
              lastname VARCHAR(50),
              salary_pro_hour INT(10),
               PRIMARY KEY(id))";

       $this->db->create_table($mitarbeiter, "Mitarbeiter");

        $anwesenheit = "CREATE TABLE IF NOT EXISTS anwesenheit(
            id INT(10) NOT NULL AUTO_INCREMENT,
            arbeit_tag VARCHAR(50),
            start_time VARCHAR(50), 
            ende_time VARCHAR(50),
            mit_id_f INT(10),
            PRIMARY KEY(id),
            FOREIGN KEY(mit_id_f) REFERENCES mitarbeiter(id) ON UPDATE CASCADE ON DELETE SET NULL )";
            $this->db->create_table($anwesenheit, "Anwesenheit");

        $urlaub = "CREATE TABLE IF NOT EXISTS urlaub(
            id INT(10) NOT NULL AUTO_INCREMENT,
            start_date VARCHAR(50) ,
            ende_date VARCHAR(50),
            mit_id_f INT(10),
            PRIMARY KEY(id),
            FOREIGN KEY(mit_id_f) REFERENCES mitarbeiter(id) ON UPDATE CASCADE ON DELETE SET NULL)";
            $this->db->create_table($urlaub, "Urlaub");

        $grund_fhelziet = "CREATE TABLE IF NOT EXISTS grund_fhelzeit(
            id INT(10) NOT NULL AUTO_INCREMENT,
            grund VARCHAR(50),
            PRIMARY KEY(id))";
            $this->db->create_table($grund_fhelziet, "Grund_fhelzeit");

            
        $fehlzeit = "CREATE TABLE IF NOT EXISTS fehlzeit(
            ID INT(10) NOT NULL AUTO_INCREMENT,
            start_date VARCHAR(50) ,
            ende_date VARCHAR(50),
            gru_id_f INT(10),
            mit_id_f INT(10),
            PRIMARY KEY(ID),
            FOREIGN KEY(mit_id_f) REFERENCES mitarbeiter(id) ON UPDATE CASCADE ON DELETE SET NULL,
            FOREIGN KEY(gru_id_f) REFERENCES grund_fhelzeit(id) ON UPDATE CASCADE ON DELETE SET NULL)";
            $this->db->create_table($fehlzeit, "Fehlzeit");

            
    }

    
    public function  getArbeitZeit($lastname){
        $data = $this->db->select(
        "SELECT * FROM anwesenheit WHERE mit_id_f =(
        SELECT id FROM mitarbeiter WHERE lastname = '".$lastname."'LIMIT 1)");
   

        return $data;
    }

    public function  getUrlaub($lastname){
        $urlaub = $this->db->Select(
        "SELECT * FROM urlaub WHERE mit_id_f = (
        SELECT  id FROM mitarbeiter WHERE lastname = '".$lastname."'LIMIT 1)");
   

        return $urlaub;
    }

    public function  getFehlzeit($lastname){
       $fehlzeit = $this->db->Select(
        "SELECT * FROM fehlzeit WHERE mit_id_f = (
        SELECT id FROM mitarbeiter WHERE lastname = '".$lastname."'LIMIT 1)");
   

        return $fehlzeit;
    }

    public function getGrund(){
        $grund = $this->db->Select(
            "SELECT id FROM grund_fhelzeit WHERE grund = 'krank'");
        return $grund;
    }

    public function getMitarbeiter($lastname){
        $mitarbeiter = $this->db->select("SELECT * FROM mitarbeiter WHERE lastname = '".$lastname."'");

        return $mitarbeiter;
    }

}

?>