<!DOCTYPE html>

<html>
<head>

  <title>Home Page</title>
  <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
 
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>    
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.7.2/combined/js/gijgo.min.js" type="text/javascript"></script>    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.7.2/combined/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery"></script>
    <script type="text/javascript">

  </script>

</head>

<body>



  <div id ="box1" class="row">
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
                      Sea Grass Beach Resort
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item" href="plaza.php">Plaza Azelea</a>
                      <a class="dropdown-item" href="campholiday.php">Camp Holiday</a>
                      <a class="dropdown-item" href="sunset.php">Sunset Beach Park</a>
                       <a class="dropdown-item" href="rmpc.php">RMPC Resort and Training center</a>
           
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

    <br><br>
</head>
  <body>
<div class="container-fluid">    
    <center><h1> Sensors' Reading for Sea Grass Beach Resort <i class="fa fa-line-chart" aria-hidden="true"></i></h1></center>

  </body>

<html lang="en">

<head>
<title>pH Level</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <table class="table table-bordered" style= "width:250px" align="right">
    <thread>
    <tr>
      <th>ph Level</th>
      <th>Date Retreived</th>

    </tr>
  </thread>
   
<!--------Database Connection and ID Selection of Data Display------->
    <?php

    $conn = mysqli_connect("localhost", "root", "", "arduino_thesis");
      if($conn-> connect_error){

        die("Connection failed:" . $conn-> connect_error);
      }

      $sql = "SELECT phLevel,dateRet FROM phsensor WHERE ID BETWEEN 34 AND 118";
      $result = $conn-> query($sql);

      if($result-> num_rows > 0){
        while($row = $result-> fetch_assoc()){


          echo"<tr><td>". $row["phLevel"]. "</td><td>". $row["dateRet"]. "</td></tr>";
        }

          echo "</table";
      }

        else {

          echo "0 result";
        }

        $conn -> close();

        ?>

        <div class="container">
  <table class="table table-bordered" style= "width:250px" align="left">
    <thread>
    <tr>
      <th>Temperature</th>
      <th>Date Retreived</th>

    </tr>
  </thread>
    <?php

    $conn = mysqli_connect("localhost", "root", "", "arduino_thesis");
      if($conn-> connect_error){

        die("Connection failed:" . $conn-> connect_error);
      }

      $sql = "SELECT tempLevel,dateRet FROM tempsensor WHERE ID BETWEEN 34 AND 118";
      $result = $conn-> query($sql);

      if($result-> num_rows > 0){
        while($row = $result-> fetch_assoc()){


          echo"<tr><td>". $row["tempLevel"]. "</td><td>". $row["dateRet"]. "</td></tr>";
        }

          echo "</table";
      }

        else {

          echo "0 result";
        }

        $conn -> close();

        ?>

        <div class="container">
  <table class="table table-bordered" style= "width:250px" align="center">
    <thread>
    <tr>
      <th>Turbidity</th>
      <th>Date Retreived</th>

    </tr>
  </thread>
    <?php

    $conn = mysqli_connect("localhost", "root", "", "arduino_thesis");
      if($conn-> connect_error){

        die("Connection failed:" . $conn-> connect_error);
      }

      $sql = "SELECT turbLevel,dateRet FROM turbidity WHERE ID BETWEEN 34 AND 118";
      $result = $conn-> query($sql);

      if($result-> num_rows > 0){
        while($row = $result-> fetch_assoc()){


          echo"<tr><td>". $row["turbLevel"]. "</td><td>". $row["dateRet"]. "</td></tr>";
        }

          echo "</table";
      }

        else {

          echo "0 result";
        }

        $conn -> close();

        ?>

      
  
</table>
</div>
</body>
</html>