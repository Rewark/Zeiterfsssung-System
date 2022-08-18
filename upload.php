<?php
include("class\\dbconnect.php");
include("class\\Mitarbeiter.php");
include("class\\ArbeitZeit.php");
session_start();
 
    
   
    if (isset($_POST['submit']))
    {

        // Allowed mime types
    $file = array(
            'text/x-comma-separated-values',
            'text/comma-separated-values',
            'application/octet-stream',
            'application/vnd.ms-excel',
            'application/x-csv',
            'text/x-csv',
            'text/csv',
            'application/csv',
            'application/excel',
            'application/vnd.msexcel',
            'text/plain'
        );

        // Validate whether selected file is a CSV file
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file))
    {

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            // Parse data from CSV file line by line
           
           // $db = new DbConnect();
            //$db->get_conn();
            
            while (($getData = fgetcsv($csvFile, 10000, ";")) !== FALSE)
            {
                
                $db = new DbConnect();
                
             
                switch($_SESSION['import']){
                    case "mitarbeiter":
                        $firstname = $getData[0];
                        $lastname = $getData[1];
                        $salary_pro_hor = $getData[2];
                        $m = new Mitarbeiter($firstname, $lastname, $salary_pro_hor);
                        $query = "INSERT INTO mitarbeiter(firstname, lastname, salary_pro_hour)VALUES(?, ?, ?)";
                        $stmt = $db->Insert($query, ["ssi", $m->get_firstName(), $m->get_lastName(), $m->get_salary_per_hor()]);
                        break;

                    case "arbeitzeit":
                        $arbeit_tag = $getData[0];
                        $start_time = $getData[1];
                        $ende_time = $getData[2];
                        $mit_id_f = $getData[3];
                        $a = new ArbeitZeit($arbeit_tag, $start_time, $ende_time, $mit_id_f);
                        $query = "INSERT INTO anwesenheit(arbeit_tag, start_time, ende_time, mit_id_f)VALUES(?, ?, ?, (SELECT id FROM mitarbeiter WHERE lastname= '".$mit_id_f."'))";
                        $stmt = $db->Insert($query, ["sss", $a->get_arbeitTag(), $a->get_startTime(), $a->get_endeTime()]);
                        break;
                    case "urlaub":
                        $urlaub_start = $getData[0];
                        $urlaub_ende = $getData[1];
                        $mit_id_f = $getData[2];

                        $query = "INSERT INTO urlaub(start_date, ende_date, mit_id_f)VALUES(?, ?, (SELECT id FROM mitarbeiter WHERE lastname= '".$mit_id_f."'))";
                        $stmt = $db->Insert($query, ["ss", $urlaub_start, $urlaub_ende]);
                        break;

                    case "grund_fehlzeit":
                        $grund = $getData[0];
                        $query = "INSERT INTO grund_fhelzeit(grund)VALUES(?)";
                        $stmt = $db->Insert($query, ["s", $grund]);
                        break;

                    case "fehlzeit":
                        $fehl_von = $getData[0];
                        $fhle_bis = $getData[1];
                        $gru_id_f = $getData[2];
                        $mit_id_f = $getData[3];

                        $query = "INSERT INTO fehlzeit(start_date, ende_date, gru_id_f, mit_id_f)VALUES(?, ?, ?, (SELECT id FROM mitarbeiter WHERE lastname= '".$mit_id_f."'))";
                        $stmt = $db->Insert($query, ["ssi", $fehl_von, $fhle_bis, $gru_id_f]);
                        break;
                    

                }
   
                
            }
        
           // $banana = array(array( $arbeitzeit));
            // Close opened CSV file
            
            fclose($csvFile);
            
        
        header("location: index2.php");
        
    }
        else
        {
            echo "Please select valid file";
        }

        

    }
   // return $banana;



?>