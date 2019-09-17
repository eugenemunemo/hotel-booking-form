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
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li>
    </ul>
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
    <!-- End confirmation  Area -->


		<!-- Start History Area -->
	<!--	<section class="section-gap history-area">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-6 col-md-8">
						<div class="section-title text-center">
							<h2>Glorious History</h2>
							<p>It won’t be a bigger problem to find one video game lover in your neighbor. Since the introduction of Virtual Game,</p>
						</div>
					</div>
				</div>
				<div class="history-tab-wrapper">
					<div class="row justify-content-between">
						<div class="col-lg-4">
							<div class="tab-thumb text-center">
								<img src="img/tab-thumb.jpg" class="img-fluid" alt="">
							</div>
						</div>
						<div class="col-lg-6 ml-auto">
							<div class="tab-total-content">
								<div class="nav ilene-tabs" id="myTab" role="tablist">
									<a class="nav-item active" id="nav-home-tab" data-toggle="tab" href="#nav-history" role="tab" aria-controls="nav-history" aria-selected="true"><span class="lnr lnr-map"></span>History</a>
									<a class="nav-item" id="nav-profile-tab" data-toggle="tab" href="#nav-mission" role="tab" aria-controls="nav-mission" aria-selected="false"><span class="lnr lnr-bullhorn"></span>Mission</a>
									<a class="nav-item" id="nav-contact-tab" data-toggle="tab" href="#nav-vission" role="tab" aria-controls="nav-vission" aria-selected="false"><span class="lnr lnr-sun"></span>Vision</a>
								</div>
								<div class="tab-content mt-40" id="nav-tabContent">
									<div class="tab-pane fade show active" id="nav-history" role="tabpanel" aria-labelledby="nav-home-tab">
										<div class="single-content">
											<h3>History</h3>
											<p>Few would argue that, despite the advancements of feminism over the past three decades, women still face a double standard when it comes to their behavior. While men’s borderline-inappropriate behavior is often laughed off as “boys will be boys,” women face higher conduct standards – especially in the workplace. That’s why it’s crucial that, as women, our behavior on the job is beyond reproach.Small Towns and Big StatesFor evidence of the double standard, we need look no farther than Arlington.</p>
										</div>
									</div>
									<div class="tab-pane fade" id="nav-mission" role="tabpanel" aria-labelledby="nav-profile-tab">
										<div class="single-content">
											<h3>Mission</h3>
											<p>Few would argue that, despite the advancements of feminism over the past three decades, women still face a double standard when it comes to their behavior. While men’s borderline-inappropriate behavior is often laughed off as “boys will be boys,” women face higher conduct standards – especially in the workplace. That’s why it’s crucial that, as women, our behavior on the job is beyond reproach.Small Towns and Big StatesFor evidence of the double standard, we need look no farther than Arlington.</p>
										</div>
									</div>
									<div class="tab-pane fade" id="nav-vission" role="tabpanel" aria-labelledby="nav-contact-tab">
										<div class="single-content">
											<h3>Vision</h3>
											<p>Few would argue that, despite the advancements of feminism over the past three decades, women still face a double standard when it comes to their behavior. While men’s borderline-inappropriate behavior is often laughed off as “boys will be boys,” women face higher conduct standards – especially in the workplace. That’s why it’s crucial that, as women, our behavior on the job is beyond reproach.Small Towns and Big StatesFor evidence of the double standard, we need look no farther than Arlington.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-1"></div>
					</div>
				</div>
			</div>
		</section>
		<! End History Area -->
		<!-- Start Service Area -->
		<!--<section class="service-area">
			<div class="container">
				<div class="row no-gutters">
					<div class="col-md-3 col-sm-6">
						<div class="single-service">
							<div class="top">
								<div class="content text-center">
									<span class="lnr lnr-magic-wand"></span>
									<h3>Software</h3>
								</div>
							</div>
							<div class="bottom">
								<p>Few would argue that, despite the advancements of feminism over the past three decades.</p>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6">
						<div class="single-service d-flex flex-column">
							<div class="bottom order-2 order-sm-1">
								<p>Few would argue that, despite the advancements of feminism over the past three decades.</p>
							</div>
							<div class="top order-1 order-sm-2">
								<div class="content text-center">
									<span class="lnr lnr-book"></span>
									<h3>Wordpress</h3>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6">
						<div class="single-service">
							<div class="top">
								<div class="content text-center">
									<span class="lnr lnr-select"></span>
									<h3>Front End</h3>
								</div>
							</div>
							<div class="bottom">
								<p>Few would argue that, despite the advancements of feminism over the past three decades.</p>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6">
						<div class="single-service d-flex flex-column">
							<div class="bottom order-2 order-sm-1">
								<p>Few would argue that, despite the advancements of feminism over the past three decades.</p>
							</div>
							<div class="top order-1 order-sm-2">
								<div class="content text-center">
									<span class="lnr lnr-diamond"></span>
									<h3>UX Design</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		 End Service Area -->
		<!-- Start Exprience Area -->
		<section class="section-gap exprience-area">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-6 col-md-8">
						<div class="section-title text-center">
							<h2>Beautiful Experiences</h2>
							<p>Cape Town is the place to be , the view , beachs , atmosphere.</p>
						</div>
					</div>
				</div>
				<div class="row align-items-center">
					<div class="col-lg-3 col-md-6">
						<div class="vector-thumb">
							<img src="img/v1.jpg" class="img-fluid" alt="">
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="vector-thumb">
							<img src="img/v2.jpg" class="img-fluid" alt="">
						</div>
					</div>
					<div class="col-lg-6 col-md-12">
						<div class="vector-content mt-30">
							<h3 class="h2">Victoria falls</h3>
							<h4>The smoke that thunders or known as Mosi ya tunya .</h4>
							<p>Situated between Zimbabwe and Zambia .The city is among three boarders Namibia , Zimbabwe and Zambia .</p>
							<a href="#" class="primary-btn white-bg">View Details</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Start Exprience Area -->
		<!-- Start Projects Area -->
		<section class="section-gap projects-area">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-6 col-md-8">
						<div class="section-title text-center">
							<h2 class="text-white">Table Mountain</h2>
							<p class="text-white">Table Mountain is the most iconic landmark of South Africa. ... Besides the mountain, the national park contains another one of South Africa's attractions.</p>
						</div>
					</div>
				</div>
				<div class="active-project-carousel">
					<div class="item">
						<div class="row no-gutters">
							<div class="col-lg-8 col-md-6">
								<div class="carousel-thumb" style="background: url(img/c1.jpg);"></div>
							</div>
							<div class="col-lg-4 col-md-6">
								<div class="carousel-content">
									<h3>Garden Route</h3>
									<p>Along the South Coast of South Africa lies one of the most beautiful stretches of coastline in the world, home to the Garden Route National Park.

Featured Activity</p>
								</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="row no-gutters">
							<div class="col-lg-8 col-md-6">
								<div class="carousel-thumb" style="background: url(img/c1.jpg);"></div>
							</div>
							<div class="col-lg-4 col-md-6">
								<div class="carousel-content">
									<h3>Durban Botanic Gardens</h3>
									<p>The Durban Botanic Gardens is situated in the city of Durban, KwaZulu-Natal, South Africa. It is Durban’s oldest public institution and Africa's oldest surviving botanical gardens</p>
								</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="row no-gutters">
							<div class="col-lg-8 col-md-6">
								<div class="carousel-thumb" style="background: url(img/c1.jpg);"></div>
							</div>
							<div class="col-lg-4 col-md-6">
								<div class="carousel-content">
									<h3>Sun City resort </h3>
									<p>Sun City resort in South Africa is a premium destination with a host of hotels, attractions & kids' activities - ideal for golfing, game viewing & water sports.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Start Projects Area -->
		<!-- Start Exprience Area -->
		<section class="section-gap">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-6 col-md-8">
						<div class="section-title text-center">
							<h2>Keep in Touch</h2>
							<p>For all reservations, please contact the appropiate hotel</p>
						</div>
					</div>ase
				</div>
				<form id="myForm" action="mail.php" method="post" class="contact-form">
					<div class="row justify-content-center">
						<div class="col-lg-5">
							<input type="text" name="fname" placeholder="Enter your name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" class="common-input mt-20" required>
						</div>
						<div class="col-lg-5">
							<input type="email" name="email" placeholder="Enter email address" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" class="common-input mt-20" required>
						</div>
						<div class="col-lg-10">
							<textarea class="common-textarea mt-20" name="message" placeholder="Messege" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Messege'" required></textarea>
						</div>
						<div class="col-lg-10 d-flex justify-content-end">
							<button class="primary-btn white-bg d-inline-flex align-items-center mt-20"><span class="mr-10">Send Message</span><span class="lnr lnr-arrow-right"></span></button> <br>
							<div class="alert-msg"></div>
						</div>
					</div>
				</form>
			</div>
		</section>
		<!-- Start Exprience Area -->
		<!-- Start Subscription Area -->
		<section class="subscription-area">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-6">
						<div class="section-title text-center">
							<h2 class="text-white">Together, <br>Let’s Make this happen</h2>
						</div>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-6">
						<div id="mc_embed_signup">
							<form target="_blank" novalidate action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&id=92a4423d01" method="get" class="subscription relative">
								<input type="email" name="EMAIL" placeholder="Email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email address'" required>
								<div style="position: absolute; left: -5000px;">
									<input type="text" name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="">
								</div>
								<button class="primary-btn white-bg d-inline-flex align-items-center"><span class="mr-10">Get Started</span><span class="lnr lnr-arrow-right"></span></button>
								<div class="info"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
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
		<script src="js/vendor/jquery-2.2.4.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="js/vendor/bootstrap.min.js"></script>
		<script src="js/jquery.ajaxchimp.min.js"></script>
		<script src="js/owl.carousel.min.js"></script>
		<script src="js/jquery.nice-select.min.js"></script>
		<script src="js/jquery.magnific-popup.min.js"></script>
		<script src="js/main.js"></script>
	</body>
</html>




</body>
</html>