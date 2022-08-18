<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS only -->
    <link rel="stylesheet" href="css//style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Zeiterfassung</title>
</head>
<body>
  
    <div class="option">
      <form action="index1.php" method="post">
      <label for="cars">Import CSV file:</label>

      <select id="import" name="import">
        <option name="mitarbeiter" value="mitarbeiter">Mitarbeiter</option>
        <option name="arbeitzeit" value="arbeitzeit">Arbeitzeit</option>
        <option name="urlaub" value="urlaub">Urlaub</option>
        <option name="grund_fehlzeit" value="grund_fehlzeit">Grund Fehlzeit</option>
        <option name="fehlzeit" value="fehlzeit">Fehlzeit</option>
      </select>
        <input type="submit" name="button" Value= "Import">
      </form>
  </div><br>
  <div class = "invoice">
      <form action="" method ="post">
        <h6>Arbeitzeit für Mitarbeiter</h6>
        <label for="lname">Lastname</label><br>
        <input type="text" name = "lastname" placeholder="Last Name"><br>
        <label for="monat">Monat</label><br>
        <input type="date_default_timezone_get" name="date" placeholder="mm.jjjj"><br>
        <label for="percent">Prozent</label><br>
        <input type="number" name="percent" placeholder="50%"><br><br>
        <input type = "submit" name = "button" value = "Rechne">
  </div><br>
      <div class="table"> 
      <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Mitarbeiter</th>
          <th scope="col">Arbeitstunden </th>
          <th scope="col">Extra Stunden  </th>
          <th scope="col">Wochenende Arbeitstunden</th>
          <th scope="col">Urlaub Stunden </th>
          <th scope="col">fehl-St-andergrund </th>
          <th scope="col">fehl-St-Krank </th>
          
        </tr>
      </thead>




<?php 


  include("class\\Lohnabrechnung.php");
  $dbc = new DbController();
  $dbc->create_table();

  $az = new ArbeitzeitRechnen();
  $la = new Lohnabrechnung();


  if(isset($_POST['button'])){
    
    $stunden = $az->zeitRechnen($_POST['lastname'], $_POST['date']);
    //var_dump($stunden);
    if($stunden != 0){
        echo "<tbody>
          <tr>
            <th scope= row >".$_POST['lastname']."</th>
            <td>".$stunden['tst']."</td>
            <td>".$stunden['exst']."</td>
            <td>".$stunden['we']."</td>
            <td>".$stunden['urlst']."</td>
            <td>".$stunden['fehla']."</td>
            <td>".$stunden['fehlk']."</td>
          </tr>
          <tbody> ";

    }

 
    $brutto = $la->brutto($_POST['lastname'], $_POST['date']);
    //var_dump($brutto);
    if($brutto != 0){
      echo '<table class="table table-hover">
      <thead>
        <tr>';
        echo  "<br><th class='table-success'> <h5>Brutto Gehalt für ".$_POST['date']."</h6></th>
          </tr>
          </thead>
          ";
          echo "<tbody>
          <tr>
            <th class='table-success' > <div>
            <h4>".$brutto['lname'].' '.$brutto['fname']."<h4></div>
            <div> <p> Arbeit: &nbsp &nbsp ".$brutto['arst']."€</p>
            <p> Urlaub: &nbsp &nbsp ".$brutto['urls']."€ </p>
            <p> Uberstunden: &nbsp".$brutto['ubers']."€</p>
            <p> Wohchenende: &nbsp ".$brutto['wen']."€</p>
            <p> Zuschlag: &nbsp &nbsp".$brutto['zus']."€</p>
            <p> Krank: &nbsp &nbsp".$brutto['krs']."€</p>
            <p> Gesamt: &nbsp &nbsp".$brutto['sume']."€</p>
            
            </div></th>
          </tbody> 
      ";

    }

  }


  
  
  
    


   
  
  

?>

</body>
</html>