<?php
  include 'FootballData.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    
        <title>Liga Santader</title>
        <link rel="shortcut icon" href="laliga.png" />
        <link href="./css/bootstrap.min.css" type="text/css" rel="stylesheet" />
     <style>
        body {
             background-image: url("campofutbol.jpg");
            
  background-repeat: no-repeat;
  background-attachment: fixed; 
  background-size: 170% 170%;
               
        }
        .tabletable-striped {
            background-color:white;
          border: 1px solid black;
    width:1000px;
          
        }
        table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
    text-align: center;
}
th, td {
  padding: 5px;
 
}
h4 {
margin-left:30%;
color:black;
}
input {
margin-left:40%;

}
img {
    position:absolute;
    margin-left:65%;
    width:9%;
    margin-top:1%;
}
        h3 {
        color:black;
        text-align:center;
        }
      
         tr:nth-child(2n+1){
  
    background-color: #F4F5F7;
  }
tr:hover {background-color:#f5f5f5;}
}
        
     </style>
    </head>
    <body>
        <div class="container">
             
                <?php
                
                $api = new FootballData();
                
            ?>
               <img src="laliga.png">
              <br><br><br>   <br><br><br>  <br><br><br>  
                <h3>Partidos en tiempo real</h3>
               <table class="tabletable-striped">
                    <tr>
                    <th>Equipo local</th>
                <th></th>
                    <th>Equipo visitante</th>
                    <th colspan="3">Resultados</th>
                    </tr>
                    <?php foreach ($api->tiemporeal('PD', 2)->matches as $match) { ?>
                    <tr>
                        <td><?php echo $match->homeTeam->name; ?></td>
                        <td>-</td>
                        <td><?php echo $match->awayTeam->name; ?></td>
                        <td><?php echo $match->score->fullTime->homeTeam;  ?></td>
                        <td>:</td>
                        <td><?php echo $match->score->fullTime->awayTeam;  ?></td>
                    </tr>
                    <?php } ?>
                </table>
                <br><br><br>
                <h3>Clasificación</h3>
                <table class="tabletable-striped">
                    <tr>
                    <th>Posición</th>
                    <th>Nombre del equipo</th>
                    <th>Goles de diferencia</th>
                    <th>Puntos</th>
                    </tr>
                    <?php foreach ($api->clasificacion('PD')->standings as $standing) { 
                          if ($standing->type == 'TOTAL') { 
                              foreach ($standing->table as $standingRow) {
                    ?>
                    <tr>
                      <td><?php echo $standingRow->position; ?></td>
                      <td><?php echo $standingRow->team->name; ?></td>
                      <td><?php echo $standingRow->goalDifference; ?></td>
                      <td><?php echo $standingRow->points; ?></td>
                    </tr>
                    <?php }}} ?>
                    <tr>
                    </tr>
                </table>
 
<?php               
              if(!empty($_POST)) {
  $numero=$_POST['numero'];
} else {
$numero=1;
}

?>   
 <br> 
                <h3>Partidos de la jornada <?php echo $numero; ?> </h3>
                <table class="tabletable-striped">
                    <tr>
                    <th>Equipo local</th>
                    <th></th>
                    <th>Equipo visitante</th>
                    <th colspan="3">Resultado</th>
                    </tr>
                    <?php foreach ($api->buscarpartidosdejornada('PD', $numero)->matches as $match) { ?>
                    <tr>
                        <td><?php echo $match->homeTeam->name; ?></td>
                        <td>-</td>
                        <td><?php echo $match->awayTeam->name; ?></td>
                        <td><?php echo $match->score->fullTime->homeTeam;  ?></td>
                        <td>:</td>
                        <td><?php echo $match->score->fullTime->awayTeam;  ?></td>
                    </tr>
                    <?php } ?>
                </table>
                <h4> Introduce la jornada de los partidos que quieres ver</h4>
                <form action="" method="post">
                    
               <input   type="number"  required min=1 max=20 name="numero">
               <br>
               <input style="margin-left:47%" type="submit" value="Introducir">
                </form>
              
            <?php
              
               
                $now = new DateTime();
                $end = new DateTime(); $end->add(new DateInterval('P7D'));
                $response = $api->partidosproximosrango($now->format('Y-m-d'), $end->format('Y-m-d'));
            ?>
             <br>
            <h3>Partidos en los proximos 7 dias</h3>
                <table class="tabletable-striped">
                    <tr>
                        <th>Equipo local</th>
                        <th></th>
                        <th>Equipo visitante</th>
                        <th colspan="3">Resultado</th>
                    </tr>
                    <?php foreach ($response->matches as $match) { ?>
                    <tr>
                        <td><?php echo $match->homeTeam->name; ?></td>
                        <td>-</td>
                        <td><?php echo $match->awayTeam->name; ?></td>
                        <td><?php echo $match->score->fullTime->homeTeam; ?></td>
                        <td>:</td>
                        <td><?php echo $match->score->fullTime->awayTeam; ?></td>
                    </tr>
                    <?php } ?>
                </table>
                <br> <br> <br>
         
              
  <!--

            <?php
               
                $matches = $api->findHomeMatchesByTeam(145);
            ?>
          
                <h3>All home matches of Everton FC:</h3>
                <table class="table table-striped">
                    <tr>
                        <th>HomeTeam</th>
                        <th></th>
                        <th>AwayTeam</th>
                        <th colspan="3">Result</th>
                    </tr>
                    <?php foreach ($matches as $match) { ?>
                    <tr>                        
                        <td><?php echo $match->homeTeam->name; ?></td>
                        <td>-</td>
                        <td><?php echo $match->awayTeam->name; ?></td>
                        <td><?php echo $match->score->fullTime->homeTeam;  ?></td>
                        <td>:</td>
                        <td><?php echo $match->score->fullTime->awayTeam;  ?></td>
                    </tr>
                    <?php } ?>
                </table>

            <?php
              
                // show players of a specific team
                $team = $api->findTeamById(254);
            ?>
            <h3>Players of <?php echo $team->name; ?></h3>
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Position</th>                    
	            <th>Shirtnumber</th>
                    <th>Date of birth</th>
                </tr>
                <?php foreach ($team->squad as $player) { ?>
                <tr>
                    <td><?php echo $player->name; ?></td>
                    <td><?php echo $player->position; ?></td>                    
                    <td><?php echo $player->shirtNumber; ?></td>
                    <td><?php echo $player->dateOfBirth; ?></td>
                </tr>
                <?php } ?>
            </table>
           -->
          
        </div>
    </body>
</html>