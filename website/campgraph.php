<?php
  
  require_once 'conf.php';
  session_start();

?>

<!DOCTYPE html>

<head>
  <title>Home Page</title>
  <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>    
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

   <script src="${pageContext.request.contextPath}/static/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript">

     <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato" />
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">

  </script>

</head>
<body>

  <div class="row">
        <div class="container-fluid">
              <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                  </li>              

  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Camp Holiday
                    </a>

                     <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item" href="seagrassgraph.php">Sea Grass Beach Resort </a>
                      <a class="dropdown-item" href="plazagraph.php">Plaza Azelea</a>
                       <a class="dropdown-item" href="sunsetgraph.php">Sunset Beach Park</a>
                        <a class="dropdown-item" href="rmpcgraph.php">RMPC Resort and Training Center</a>
                  </div>
                </li>

                  </div>
                </li>
              </ul>
              
              <?php

              date_default_timezone_set('Asia/Manila');
              $date = date("M d, Y");          
              echo "<span class='navbar-text'>". $date ."&nbsp;&nbsp;</span>";
              echo "<span class='navbar-text' id='time'></span>";
              ?>
            </div>                       
        </nav>
      </div>
    </div>



<?php

//index.php
$connect = mysqli_connect("localhost", "root", "", "arduino_thesis");

$query = 'SELECT phLevel,
UNIX_TIMESTAMP(dateRet) AS datetime 
FROM phsensor WHERE id between 152 AND 184
ORDER BY dateRet DESC';
$result = mysqli_query($connect, $query);
$rows = array();
$table = array();

$table['cols'] = array(
 array(
  'label' => 'Date Time', 
  'type' => 'datetime'
 ),
 array(
  'label' => 'ph Level', 
  'type' => 'number'
 )
);

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $datetime = explode(".", $row["datetime"]);
 $sub_array[] =  array(
      "v" => 'Date(' . $datetime[0] . '000)'
     );
 $sub_array[] =  array(
      "v" => $row["phLevel"]
     );
 $rows[] =  array(
     "c" => $sub_array
    );
}
$table['rows'] = $rows;
$jsonTable1 = json_encode($table);

?>

<html>
 <head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script type="text/javascript">
   
   //    setTimeout(function(){window.location=window.location;},5000);
   google.charts.load('current', {'packages':['corechart']});
   google.charts.setOnLoadCallback(drawChart);
   function drawChart()
   {
    var data = new google.visualization.DataTable(<?php echo $jsonTable1; ?>);
    var options = {
     title:'Sensors Data',
     legend:{position:'bottom'},
     chartArea:{width:'95%', height:'65%'}
    };

    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));

    chart.draw(data, options);
   }
  </script>
  <style>
  .page-wrapper
  {
   width:1000px;
   margin:0 auto;
  }
  </style>
 </head>  
 <body>
  <div class="page-wrapper">
   <br />
   <h2 align="center">ph Level Graph </h2>
   <div id="line_chart" style="width: 100%; height: 500px"></div>
  </div>
 </body>
</html>


<?php

//index.php
$connect = mysqli_connect("localhost", "root", "", "arduino_thesis");

$query = 'SELECT tempLevel,
UNIX_TIMESTAMP(dateRet) AS datetime 
FROM tempsensor WHERE id between 152 AND 184
ORDER BY dateRet DESC';
$result = mysqli_query($connect, $query);
$rows = array();
$table = array();

$table['cols'] = array(
 array(
  'label' => 'Date Time', 
  'type' => 'datetime'
 ),
 array(
  'label' => 'Temperature', 
  'type' => 'number'
 )
);

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $datetime = explode(".", $row["datetime"]);
 $sub_array[] =  array(
      "v" => 'Date(' . $datetime[0] . '000)'
     );
 $sub_array[] =  array(
      "v" => $row["tempLevel"]
     );
 $rows[] =  array(
     "c" => $sub_array
    );
}
$table['rows'] = $rows;
$jsonTable2 = json_encode($table);

?>

<html>
 <head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script type="text/javascript">
   
   //    setTimeout(function(){window.location=window.location;},5000);
   google.charts.load('current', {'packages':['corechart']});
   google.charts.setOnLoadCallback(drawChart);
   function drawChart()
   {
    var data = new google.visualization.DataTable(<?php echo $jsonTable2; ?>);
    var options = {
     title:'Sensors Data',
     legend:{position:'bottom'},
     chartArea:{width:'95%', height:'65%'}
    };

    var chart = new google.visualization.LineChart(document.getElementById('line_chart_chart'));

    chart.draw(data, options);
   }
  </script>
  <style>
  .page-wrapper
  {
   width:1000px;
   margin:0 auto;
  }
  </style>
 </head>  
 <body>
  <div class="page-wrapper">
   <br />
   <h2 align="center">Temperature Level Graph </h2>
   <div id="line_chart_chart" style="width: 100%; height: 500px"></div>
  </div>
 </body>
</html>


<?php

//index.php
$connect = mysqli_connect("localhost", "root", "", "arduino_thesis");

$query = 'SELECT turbLevel,
UNIX_TIMESTAMP(dateRet) AS datetime 
FROM turbidity WHERE id between 152 AND 184
ORDER BY dateRet DESC';
$result = mysqli_query($connect, $query);
$rows = array();
$table = array();

$table['cols'] = array(
 array(
  'label' => 'Date Time', 
  'type' => 'datetime'
 ),
 array(
  'label' => 'turbLevel', 
  'type' => 'number'
 )
);

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $datetime = explode(".", $row["datetime"]);
 $sub_array[] =  array(
      "v" => 'Date(' . $datetime[0] . '000)'
     );
 $sub_array[] =  array(
      "v" => $row["turbLevel"]
     );
 $rows[] =  array(
     "c" => $sub_array
    );
}
$table['rows'] = $rows;
$jsonTable3 = json_encode($table);

?>

<html>
 <head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script type="text/javascript">
   
   //    setTimeout(function(){window.location=window.location;},5000);
   google.charts.load('current', {'packages':['corechart']});
   google.charts.setOnLoadCallback(drawChart);
   function drawChart()
   {
    var data = new google.visualization.DataTable(<?php echo $jsonTable3; ?>);
    var options = {
     title:'Sensors Data',
     legend:{position:'bottom'},
     chartArea:{width:'95%', height:'65%'}
    };

    var chart = new google.visualization.LineChart(document.getElementById('line_chart_chart_chart'));

    chart.draw(data, options);
   }
  </script>
  <style>
  .page-wrapper
  {
   width:1000px;
   margin:0 auto;
  }
  </style>
 </head>  
 <body>
  <div class="page-wrapper">
   <br />
   <h2 align="center">Turbidity Level Graph </h2>
   <div id="line_chart_chart_chart" style="width: 100%; height: 500px"></div>
  </div>
 </body>
</html> 