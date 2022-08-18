<?php

if (!defined('DbConnect')) {
 

    function refValues($arr){
        if (strnatcmp(phpversion(),'5.3') >= 0) 
        {
            $refs = array();
            foreach($arr as $key => $value)
                $refs[$key] = &$arr[$key];
            return $refs;
        }
        return $arr;
    }

// Create connt
class DbConnect{
    protected $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "zeiterfassung";
    private $connt = null;
   

    public function __construct(){
        try{
	
            $this->connt = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
		
            if( mysqli_connect_errno() ){
                throw new Exception("Could not connect to database.");   
            }
		
        }catch(Exception $e){
            throw new Exception($e->getMessage());   
        }
    } 


    
    //creat table
    public function create_table($sql,$table_name){
        if ($this->connt->query($sql) === TRUE) {

           // echo "Table '".$table_name."' created successfully <br> ";
        } else {
            echo "Error creating table: <br> " . $this->conn->error;
        }
    }

    //Insert
    public function Insert( $query = "" , $params = [] ){
	
        try{
		
        $stmt = $this->executeStatement( $query , $params );
            $stmt->close();
            
            return $this->connt->insert_id;
		
        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }
	
        return false;
	
    }
    //Select 
    public function Select( $query = "" , $params = [] ){
	
        try{
		
            $stmt = $this->executeStatement( $query , $params );
		
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);				
            $stmt->close();
		
            return $result;
		
        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }
	
        return false;
    }

    // Update a row/s in a Database Table
    public function Update( $query = "" , $params = [] ){
        try{
        
            $this->executeStatement( $query , $params )->close();
        
        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }
    
        return false;
    }

    // Remove a row/s in a Database Table
    public function Remove( $query = "" , $params = [] ){
        try{
        
            $this->executeStatement( $query , $params )->close();
        
        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }

        return false;
    }


 

    // execute statement
    private function executeStatement( $query = "" , $params = [] ){
	
        try{
		
            $stmt = $this->connt->prepare( $query );
		
            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
		
            if( $params ){
                call_user_func_array(array($stmt, 'bind_param'), refValues( $params ));				
            }
		
            $stmt->execute();
		
            return $stmt;
		
        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }
	
    }

    public function get_connt(){
        return $this->connt;
    }


 

}


}
?>