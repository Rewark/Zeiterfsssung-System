<?php

class Mitarbeiter {
    private $firstName;
    private $lastName;
    private $salary_per_hour;
    private $arbeitZeit;


    function __construct($firstName, $lastName, $salary_per_hour){
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->salary_per_hour = $salary_per_hour;
     
    }

    function set_arbeitszeit( $arbeitZeit ){
        $this->arbeitZeit = $arbeitZeit;
    }

    function get_firstName(){
        return $this->firstName;
    }

    function get_lastName(){
        return $this->lastName;
    }

    function get_salary_per_hor(){
        return $this->salary_per_hour;
    }
}





?>