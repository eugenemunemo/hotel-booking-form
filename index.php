<?php
// Start the session
session_start();
?>


<!DOCTYPE html>
<html>
<body>

<head>
<link rel="stylesheet" href="css/style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <!-- jQuery first, then Popper.js, then Bootstrap JS -->
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Hotels</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Rooms</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Restaurant</a>
          <a class="dropdown-item" href="#">Food</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Wine</a>
        </div>
      </li>

      <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

<h1>Reservation for your  dream Hotel</h1>
<div class="price">
<p id="inn">Holiday Inn: R 200</p>
<p id="rad">Radison: R 100</p>
<p id="city">City Lodge: R 400</p>
<p id="town">Town Lodge: R 150</p>
</div>



<div class="container">
   <div class="row">
      <div class="col-md-6">
      <div id='form'>
<form role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

<label>First Name<input type="text" name="firstname" placeholder='First Name' required></label><br>
<label>Surname<input type="text" name="surname"placeholder='surname' required></label><br>
<label>Hotel Name
<select name="hotelname" required>
  <option value="Holiday Inn">Holiday Inn</option>
  <option value="Radison">Radison</option>
  <option value="City Lodge">City Lodge</option>
  <option value="Town Lodge">Town Lodge</option>
</select>
</label><br>

<label>In Date<input type="date" name="indate" placeholder='indate' required></label><br>
<label>Out Date<input type="date" name="outdate" placeholder='outdate' required></label><br>
<button class="submit" name="submit" type="submit">Submit</button>



</form>
</div>

      </div>
      <div class="col-md-6">
      <?php
require_once "connect.php";
echo $conn->error;

$sql = "CREATE TABLE IF NOT EXISTS bookings (
   id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   firstname VARCHAR(50),
   surname VARCHAR(50),
   hotelname VARCHAR(50),
   indate VARCHAR(30),
   outdate VARCHAR(30),
   booked INT(4))";


$conn ->query($sql);

if (isset($_GET['error']) && $_GET['error'] == 'timestamp') {

   ?>

<div class='panel panel-default'>
   <h1>
      You must select at least  1 day 
   </h1>
      </div>

      <?php
   }


//echo '<br>'. $_POST['firstname'] .'<br>'. $_POST['lastname'].'<br>'.$_POST['hotelname'].'<br>'.$_POST['indate'].'<br>'. $_POST['outdate'];




if (isset($_POST['submit'])) {
   $_SESSION['firstname']= $_POST['firstname'];
   $_SESSION['surname']= $_POST['surname'];
   $_SESSION['hotelname']= $_POST['hotelname'];
   $_SESSION['indate']= $_POST['indate'];
   $_SESSION['outdate']= $_POST['outdate'];



//echo $_SESSION['firstname'] //."<br>".  $_SESSION['lastname'] ."<br>".  $_SESSION['hotelname'] ."<br>". $_SESSION['indate'] ."<br>". $_SESSION['outdate']."<br>";


//display booking info to user

// echo "<br> Firstname:".  $_SESSION['firstname']."<br>".
// "surname:".  $_SESSION['surname']."<br>".
// "Start Date:". $_SESSION['indate']."<br>".
// "End Date:". $_SESSION['outdate']."<br>".
// "Hotel Name:". $_SESSION['hotelname']."<br>";


//calculate duration of user's stay at hotel
$datetime1 = new DateTime($_SESSION['indate']);
$datetime2 = new DateTime($_SESSION['outdate']);
$interval = $datetime1->diff($datetime2);

$interval->format('%d');

$checkInStamp = strtotime($_SESSION['indate']);
        $checkOutStamp = strtotime($_SESSION['outdate']);
        // echo $checkInStamp . '<br>';
        // echo $checkOutStamp;
        if ($checkInStamp - $checkOutStamp > 86400 || $checkInStamp == $checkOutStamp) {
            header("Location: ?error=timestamp");
            exit;
        }

$daysbooked = $interval->format('%d');
$value;

switch(isset($_SESSION['hotelname'])){
   case 'Holiday Inn':
   $value = $daysbooked * 200;
   break;

   case 'Radison':
   $value = $daysbooked * 100;
   break;

   case 'City Lodge':
   $value = $daysbooked * 400;
   break;

   case 'Town Lodge':
   $value = $daysbooked * 150;
   break;

   default:
   return "ERROR!";
}

$firstname = $_POST['firstname'];
$surname = $_POST['surname'];

$result = mysqli_query($conn,"SELECT hotelname, indate, outdate, firstname, surname FROM bookings WHERE firstname='$firstname' && surname='$surname'"); 
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {    
 echo "<div class='duplicate'> You already have a booking. <br> Firstname: ". $row['firstname'] . "<br>
Lastname: " . $row['surname'].
"<br> Start Date: " . $row['indate'].
"<br> End Date: " . $row['outdate'].
"<br> Hotel Name: " . $row['hotelname'].
"<br>" . $interval->format('%r%a days') . "<br> Total: R " . $value ."</div>";
    } 
}


echo '<div class="return">'. "<br> Firstname:".  $_SESSION['firstname']."<br>".
"surname:".  $_SESSION['surname']."<br>".
"Start Date:". $_SESSION['indate']."<br>".
"End Date:". $_SESSION['outdate']."<br>".
"Hotel Name:". $_SESSION['hotelname']."<br>".
"Total R" . $value ;

echo "<form role='form' action=" . htmlspecialchars($_SERVER['PHP_SELF']) . " method='post'>
<button name='confirm' type='submit'> Confirm </button> </form>".'</div>';

//echo "<form role='form' action=" . htmlspecialchars($_SERVER['PHP_SELF']) . " method='post'><input type='submit' name='confirm'>.'Confirm'.</form>";

}

if(isset($_POST['confirm'])){
//Preparing and binding a statement
//prepare is method, this way we only pass the query once and then the values
$stmt=$conn->prepare("INSERT INTO bookings(firstname,surname,hotelname,indate,outdate) VALUES (?,?,?,?,?)");
//also part of preparing & binding these values to the questions marks.
$stmt->bind_param('sssss', $firstname,$surname,$hotelname,$indate,$outdate);
$firstname=$_SESSION['firstname'];
$surname=$_SESSION['surname'];
$hotelname=$_SESSION['hotelname'];
$indate=$_SESSION['indate'];
$outdate=$_SESSION['outdate'];
$stmt->execute();
echo '<div id="confirmed">'."Booking confirmed".'</div>';

}

// if($_POST['confirm']){
//    $firstname =$_SESSION['firstname'];
//    $surname =$_SESSION['surname'];
//    $hotelname =$_SESSION['hotelname'];
//    $indate=$_SESSION['indate'];
//    $outdate=$_SESSION['outdate'];
//      mysqli_query($conn, "INSERT INTO bookings (firstname, surname, hotelname,indate,outdate)
//      VALUES ('$firstname ', '$surname','$hotelname','$indate','$outdate')");
// }




?>
      </div>
     
   </div>
</div>
</div>
