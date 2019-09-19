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

 <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>


<!-- Navigation Bar -->
<div class="pos-f-t">
  <div class="collapse" id="navbarToggleExternalContent">
    <div class="bg-dark p-4">
      <h5 class="text-white h4">EM HOTEL BOOKINGS</h5>
      <span class="text-muted">You can enjoy your holidays.</span>
    </div>
  </div>
  <nav class="navbar navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>
</div>
<!--search bar-->
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>


<div class="container padding padding">
   <div class="row">
      <div class="col-md-6">
	 
<h1>Reservation for your  dream Hotel</h1>
<div class="price">
<p id="inn">Holiday Inn: R 200</p>
<p id="rad">Radison: R 100</p>
<p id="city">City Lodge: R 400</p>
<p id="town">Town Lodge: R 150</p>
</div>
</div>
</div>

</div>
<div class="container padding padding">
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
</div>




<br>
<br>
<br>



<div class="c">
<div class="section">
<div class="row-padding" id="about">
    <div class="col l4 12">
	<div class="c">	
      <h3>About</h3>
      <h6>Our hotel is one of a kind. It is truely amazing. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</h6>
    <p>We accept: <i class="fa fa-credit-card large"></i> <i class="fa fa-cc-mastercard large"></i> <i class="fa fa-cc-amex large"></i> <i class="fa fa-cc-cc-visa large"></i><i class="fa fa-cc-paypal large"></i></p>
    </div>
    <div class="col l8 12">
      <!-- Image of location/map -->
      <img src="images/hotel2.jpg" class="image greyscale" style="width:;">
    </div>
  </div>
  
  <div class="row-padding large center" style="margin:32px 0">
    <div class="third"><i class="fa fa-map-marker text-red"></i> 6 Biccardi Street, Durbanville, Cape Town, RSA</div>
    <div class="third"><i class="fa fa-phone text-red"></i> Phone: +00 27 619125338</div>
    <div class="third"><i class="fa fa-envelope text-red"></i> Email: emunemo@gmail.com</div>
  </div>

  <div class="panel red leftbar padding-32">
    <h6><i class="fa fa-info deep-orange padding margin-right"></i> On demand, we can offer playstation, babycall, children care, dog equipment, etc.</h6>
  </div>

  <div class="container">
    <h3>Our Hotels</h3>
    <h6>You can find our hotels anywhere in the world:</h6>
  </div>
  </div>
  </div>	<!-- Start Projects Area -->
		<!-- Start Exprience Area -->


		<!-- Start Exprience Area -->
		<!-- Start Subscription Area -->
		<div class="container padding-32 black opacity card hover-opacity-off" style="margin:32px 0;">
    <h2>Get the best offers first!</h2>
    <p>Join our newsletter.</p>
    <label>E-mail</label>
    <input class="input border" type="text" placeholder="Your Email address">
    <button type="button" class="button red margin-top">Subscribe</button>
  </div>

  <div class="container" id="contact">
    <h2>Contact</h2>
    <p>If you have any questions, do not hesitate to ask them.</p>
    <i class="fa fa-map-marker text-red" style="width:30px"></i> Chicago, US<br>
    <i class="fa fa-phone text-red" style="width:30px"></i> Phone: +00 151515<br>
    <i class="fa fa-envelope text-red" style="width:30px"> </i> Email: mail@mail.com<br>
    <form action="/action_page.php" target="_blank">
      <p><input class="input padding-16 border" type="text" placeholder="Name" required name="Name"></p>
      <p><input class="input padding-16 border" type="text" placeholder="Email" required name="Email"></p>
      <p><input class="input padding-16 border" type="text" placeholder="Message" required name="Message"></p>
      <p><button class="button black padding-large" type="submit">SEND MESSAGE</button></p>
    </form>
  </div>

		<!-- End Subscription Area -->

		<!-- Strat Footer Area -->
		<footer class="section-gap">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-sm-6">
						<div class="single-footer-widget">
							<h6 class="text-white text-uppercase mb-20">About Agency</h6>
							<ul class="footer-nav">
								<li><a href="#">Managed Booking </a></li>
								<li><a href="#">Manage Reputation</a></li>
								<li><a href="#">Power Tools</a></li>
								<li><a href="#">Marketing Service</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="single-footer-widget">
							<h6 class="text-white text-uppercase mb-20">Navigation Links</h6>
							<ul class="footer-nav">
								<li><a href="#">Home</a></li>
								<li><a href="#">Main Features</a></li>
								<li><a href="#">Offered Services</a></li>
								<li><a href="#">Latest Portfolio</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="single-footer-widget">
							<h6 class="text-white text-uppercase mb-20">Navigation Links</h6>
							<ul class="footer-nav">
								<li><a href="#">Works & Builders</a></li>
								<li><a href="#">Works & Wordpress</a></li>
								<li><a href="#">Works & Templates</a></li>
							</ul>
						</div>
					</div>

					<div class="col-lg-3 col-sm-6">
						<div class="single-footer-widget">
							<h6 class="text-white text-uppercase mb-20">Destination</h6>
							<ul class="instafeed d-flex flex-wrap">
								<li><img src="images/hotel1.jpg" alt=""></li>
								<li><img src="images/hotel2.jpg" alt=""></li>
								<li><img src="images/hotel3.jpg" alt=""></li>
								<li><img src="images/hotel4.jpg" alt=""></li>
								<li><img src="images/hotel5.jpg" alt=""></li>
								<li><img src="images/hotel6.jpg" alt=""></li>
								<li><img src="images/hotel7.jpg" alt=""></li>
								<li><img src="images/hotel8.jpg" alt=""></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="footer-bottom d-flex justify-content-between align-items-center flex-wrap">
					<p class="footer-text m-0">Copyright &copy; 2019 All rights reserved   |   This is made by us for us <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://codespace.com">Codespace</a></p>
					<div class="footer-social d-flex align-items-center">
						<a href="#"><i class="fa fa-facebook"></i></a>
						<a href="#"><i class="fa fa-twitter"></i></a>
						<a href="#"><i class="fa fa-dribbble"></i></a>
						<a href="#"><i class="fa fa-behance"></i></a>
					</div>
				</div>
			</div>
		</footer>
		<!-- End Footer Area -->
    </div>
	<!--	<script src="js/vendor/jquery-2.2.4.min.js"></script>-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<!--<script src="js/vendor/bootstrap.min.js"></script>
		<script src="js/jquery.ajaxchimp.min.js"></script>
		<script src="js/owl.carousel.min.js"></script>
		<script src="js/jquery.nice-select.min.js"></script>
		<script src="js/jquery.magnific-popup.min.js"></script>
		<script src="js/main.js"></script>-->
	</body>
</html>




</body>
</html>