<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (isset($_POST['submit1'])) {
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobileno'];
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $sql = "INSERT INTO  tblenquiry(FullName,EmailId,MobileNumber,Subject,Description) VALUES(:fname,:email,:mobile,:subject,:description)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->bindParam(':subject', $subject, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();

    if ($lastInsertId) {
        // Generate reference number
        $reference_number = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);

        // Send confirmation email to user
        $to = $email;
        $subject = "Enquiry Submitted";
        $message = "Dear $fname,\n\nThank you for choosing BeingTraveler for your travel needs. We have received your enquiry [Reference Number : $reference_number ] and are excited to help you plan your next adventure. Our team of travel experts is currently reviewing your request and we will get back to you as soon as possible with a personalized travel itinerary that meets your needs.\n\nIn the meantime, feel free to browse our website for inspiration and travel ideas. Our comprehensive travel guides and insider tips will help you discover the best destinations and experiences around the world.\n\nAt BeingTraveler, we are committed to providing you with exceptional service and unforgettable travel experiences. We look forward to working with you and making your travel dreams a reality.\n\nBest regards,\nThe BeingTraveler Team";
        $headers = 'From: contact@beingtraveler.in' . "\r\n" .
                   'Reply-To: reply@beingtraveler.in' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $message, $headers);

        // Send email alert
        $to = "contact@beingtraveler.in"; // Your email address
        $subject = "New Enquiry Received !";
        $msg = "A New enquiry has been received Sir! , Details are: \n\n".
               "Name: $fname \n".
               "Email: $email \n".
               "Mobile: $mobile \n".
               "Subject: $subject \n".
               "Reference Number: $reference_number \n".
               "Description: $description";
        $from = "contact@beingtraveler.in"; // Your website email address
        $headers = "From: $from";
        mail($to, $subject, $msg, $headers);

        echo "success";
        exit; // Stop script execution after sending the success message
    } else {
        echo "error";
        exit; // Stop script execution after sending the error message
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- 
    - primary meta tags
  -->
  <title>BeingTraveler - Explore the world</title>
  <meta name="title" content="BeingTraveler - Explore the world">
  <meta name="description" content="BeingTraveler Tour & Travelling">

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
   <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Kumar+One&display=swap" rel="stylesheet">
  <!-- Add particles.js library -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

 <!--
 - my edit 
 -->
 <style>
@media only screen and (max-width: 767px) {
  .whatsapp-icon {
    bottom: 70px;
    right: 20px;
  }
  .whatsapp-icon img {
    width: 50px;
    height: 50px;
    padding: 8px;
  }
}
</style>
 
  <style>
@keyframes shimmer {
  0% {
    background-position: -100vw;
  }
  100% {
    background-position: 100vw;
  }
}

@keyframes glow {
  0%, 100% {
    text-shadow: 0 0 10px #FFD700, 0 0 20px #FFD700, 0 0 30px #FFD700, 0 0 40px #FFD700;
  }
  50% {
    text-shadow: 0 0 20px #FFD700, 0 0 30px #FFD700, 0 0 40px #FFD700, 0 0 50px #FFD700, 0 0 60px #FFD700;
  }
}

.ribbon-wrapper {
  position: relative;
  width: 100%;
  height: 200px;
  overflow: hidden;
}

#particles-js {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
}

.ribbon {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 2vw 4vw;
  z-index: 2;
  max-width: 90%;
  margin: 0 auto;
}

.ribbon-text {
  font-size: 4vw;
  font-weight: bold;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
  font-family: 'Kumar One', cursive;
  background-image: linear-gradient(
    to right, 
    #FFD700 40%, 
    #FFDF85 50%, 
    #FFD700 60%
  );
  background-size: 200% auto;
  color: white;
  overflow: hidden;
  box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.2);
  border-radius: 20px;
  animation: shimmer 2s linear infinite, glow 2s ease-in-out infinite;
  padding: 1vw 2vw;
}
@media (min-width: 768px) {
  .ribbon-text {
    font-size: 2vw;
  }
}
.popup-form {
  z-index: 9997;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.7);
  display: none;
}

.popup-form-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #fff;
  padding: 2rem;
  width: 24rem;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
}

.close-btn {
  float: right;
  cursor: pointer;
  font-size: 1.5rem;
  color: #ffd700; /* Golden text */
  background-color: #ffffff; /* White background */
  padding: 5px 10px;
  border-radius: 5px;
  border: 2px solid #ffd700; /* Golden border */
  transition: color 0.2s, background-color 0.2s, border-color 0.2s; 
}

.close-btn:hover {
  color: #ffffff; /* White text on hover */
  background-color: #ffd700; /* Golden background on hover */
  border-color: #d4af37; /* Darker golden border on hover */
}

.form-group {
  margin: 1rem 0;
}

label {
  display: block;
  font-weight: bold;
  margin-bottom: 0.5rem;
}

input {
  width: 100%;
  padding: 0.5rem;
  border-radius: 5px;
  border: 1px solid #ccc;
  font-size: 1rem;
}

.validation-message {
  color: red;
  font-size: 0.8rem;
  margin-top: 0.5rem;
}

/* ...other styles... */

button[type='submit'] {
  width: 100%;
  padding: 0.5rem 1rem;
  background: #ffffff; /* White background */
  border: 2px solid #ffd700; /* Golden border */
  color: #ffd700; /* Golden text */
  cursor: pointer;
  border-radius: 5px;
  outline: none; /* Remove default outline */
  transition: background 0.2s, color 0.2s, border-color 0.2s; 
}

button[type='submit']:hover {
  background: #ffd700; /* Golden background on hover */
  color: #ffffff; /* White text on hover */
  border-color: #d4af37; /* Darker golden border on hover */
}

/* ...other styles... */
.success-message {
  z-index: 9998;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  font-size: 1.5rem;
  background: rgba(255, 215, 0, 0.1); /* Slight golden background */
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0px 10px 30px -5px rgba(0, 0, 0, 0.3);
  color: #ffd700; /* Golden text */
  backdrop-filter: blur(10px); /* Add blur */
}

.success-message h2 {
  font-size: 2rem;
}

.success-message p {
  font-size: 1.2rem;
}

.close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  /* ...other styles... */
}

.checkmark {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  display: block;
  stroke-width: 2;
  stroke: #ffd700; /* Golden stroke */
  stroke-miterlimit: 10;
  box-shadow: inset 0px 0px 0px #ffd700; /* Golden shadow */
  animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
  position: relative;
  margin: 0 auto;
  top: -20px;
}

.checkmark__circle {
  stroke-dasharray: 166;
  stroke-dashoffset: 166;
  stroke-width: 2;
  stroke-miterlimit: 10;
  stroke: #ffd700; /* Golden stroke */
  fill: none;
  animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.checkmark__check {
  transform-origin: 50% 50%;
  stroke-dasharray: 48;
  stroke-dashoffset: 48;
  animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}

@keyframes stroke {
  100% {
    stroke-dashoffset: 0;
  }
}

@keyframes scale {
  0%, 100% {
    transform: none;
  }

  50% {
    transform: scale3d(1.1, 1.1, 1);
  }
}

@keyframes fill {
  100% {
    box-shadow: inset 0px 0px 0px 30px #ffd700; /* Golden fill */
  }
}

/* ...other styles... */

.thanks-message {
  z-index: 9999;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  font-size: 1.5rem;
  background: rgba(255, 215, 0, 0.1); /* Slight golden background */
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0px 10px 30px -5px rgba(0, 0, 0, 0.3);
  color: #ffd700; /* Golden text */
  backdrop-filter: blur(10px); /* Add blur */
}
.thanks-message h2 {
  font-size: 2rem;
}

.thanks-message p {
  font-size: 1.2rem;
}

/* Close button (cross) styling */
.close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  /* ...other styles... */
}

.checkmark {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  display: block;
  stroke-width: 2;
  stroke: #ffd700; /* Golden stroke */
  stroke-miterlimit: 10;
  box-shadow: inset 0px 0px 0px #ffd700; /* Golden shadow */
  animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
  position: relative;
  margin: 0 auto;
  top: -20px;
}

}



 </style>
 
  <!-- 
    - custom css link
  -->

   
  <link rel="stylesheet" href="./assets/css/style.css">
  
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap">
  <link rel="stylesheet" href="assets/css/sstyle.css">
  <link rel="stylesheet" href="assets/css/styleg.css">
  <link rel="stylesheet" href="assets/css/newer.css">
  
  <!-- 
    - preload images
  -->
<!--  <link rel="preload" as="image" href="./assets/images/hero-banner.webp">
  <link rel="preload" as="image" href="./assets/images/preloader.svg"> 
  -->
  <!-- Chatra {literal} -->
<script>
    (function(d, w, c) {
        w.ChatraID = 'ad8Mxj9DcY6bGYEF4';
        var s = d.createElement('script');
        w[c] = w[c] || function() {
            (w[c].q = w[c].q || []).push(arguments);
        };
        s.async = true;
        s.src = 'https://call.chatra.io/chatra.js';
        if (d.head) d.head.appendChild(s);
    })(document, window, 'Chatra');
</script>
<!-- /Chatra {/literal} -->



</head>

<body>

  <!-- 
    - #PRELOADER
  -->

  <div class="preloader" data-preloader>
    <div class="preloader-inner">
      <img src="./assets/images/preloader.svg" width="50" height="50" alt="" class="img">
    </div>
  </div>

 



  <!-- 
    - #HEADER
  -->

  <header class="header" data-header>
    <div class="container">

      <a href="https://www.beingtraveler.in/" class="logo">
        <img src="./assets/images/logo.webp" width="187" height="38" alt="logo">
      </a>

      <nav class="navbar" data-navbar>

        <div class="navbar-top">
          <a href="https://www.beingtraveler.in/enquiry.php" class="logo">
            <img src="./assets/images/logo.webp" width="187" height="38" alt="logo">
          </a>

          <button class="nav-toggle-btn" aria-label="close menu" data-nav-toggler>
            <ion-icon name="close-outline" aria-hidden="true"></ion-icon>
          </button>
        </div>

        <ul class="navbar-list">

          <li class="navbar-item">
            <a href="https://www.beingtraveler.in/" class="navbar-link active">Home</a>
          </li>

          <li class="navbar-item">
            <a href="https://www.beingtraveler.in/about.html" class="navbar-link">About Us</a>
          </li>

          <li class="navbar-item">
            <a href="https://www.beingtraveler.in/package-list.php" class="navbar-link">Tour Packages</a>
          </li>

          <li class="navbar-item">
            <a href="https://www.beingtraveler.in/restaurant" class="navbar-link">Restaurants</a>
          </li>
           <li class="navbar-item">
            <a href="https://www.beingtraveler.in/gallery.php" class="navbar-link">Gallery</a>
          </li>

          <li class="navbar-item">
            <a href="https://www.beingtraveler.in/founders.html" class="navbar-link">Founders</a>
          </li>
          

        </ul>

        <div class="header-action">
          <a href="https://www.beingtraveler.in/page.php#" class="login-btn">Login</a>

          <a href="https://www.beingtraveler.in/page.php#" class="btn btn-primary">Sign Up</a>
        </div>

      </nav>

      <button class="nav-toggle-btn" aria-label="open menu" data-nav-toggler>
        <ion-icon name="menu-outline" aria-hidden="true"></ion-icon>
      </button>

      <div class="overlay" data-overlay data-nav-toggler></div>

    </div>
  </header>





  <main>
    <article>

      <!-- 
        - #HERO
      -->
      <!-- 
        - #HERO
      -->

      <section class="section hero" aria-label="hero">
      <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop" poster="./assets/images/lake.jpg">
    <source src="./assets/images/background.mp4" type="video/mp4">
  </video>
        
        <div class="container">

          <div class="hero-content">
               <h1 class="h1 title hero-title">
        Welcome to Being Traveler !
      </h1>
      <p class="hero-subtitle">
        Explore the World
        <img src="./assets/images/title-icon.svg" width="20" height="20" alt="world icon" class="img">
      </p>
      <h1 class="h1 title hero-title">
        It’s a Big World Out There, Go Explore
      </h1>
      <p class="hero-text">
        We always make our customer happy by providing as many choices as possible
      </p>
      <div class="wrapper">
        <a href="https://www.beingtraveler.in/enquiry.php" class="btn btn-secondary">
          <span class="span">Plan a Trip</span>
          <ion-icon name="chevron-forward" aria-hidden="true"></ion-icon>
        </a>
        <button class="hero-btn">
          <div class="btn-img">
            <img src="./assets/images/hero-button-img.jpg" width="100" height="100" alt="our story" class="img-cover">
            <ion-icon name="play" aria-hidden="true"></ion-icon>
          </div>
          <p class="text">Watch our Story</p>
        </button>
      </div>
    </div>
    <figure class="hero-banner">
      <img src="./assets/images/hero-banner.webp" width="631" height="735" alt="hero banner" class="w-100">
    </figure>
  </div>
</section>



   <!--
  - BANNER
-->

<div class="bannerg">

  <div class="containerg">
<h2 class="banner-subtitlegg">Religious Locations Trending in India | Big Offers</h2>
    <div class="slider-containerg has-scrollbarg">

      <div class="slider-itemg">

        <img src="./assets/images/kedarnath.webp" alt="Visit Kedarnath , Book Now" class="banner-imgg">

        <div class="banner-contentg">

          <p class="banner-subtitleg">Visit Kedarnath !</p>

          <h2 class="banner-titleg">Most visited right now .</h2>

          <p class="banner-textg">
            starting at &dollar; <b>20%</b> Offer !
          </p>

          <a href="https://www.beingtraveler.in/booking.html" class="banner-btng">Book now</a>

        </div>

      </div>

      <div class="slider-itemg">

        <img src="./assets/images/rishikesh.webp" alt="Travel to Rishikesh" class="banner-imgg">

        <div class="banner-contentg">

          <p class="banner-subtitleg">Visit Rishikesh !</p>

          <h2 class="banner-titleg">The Origin of Lord Shiva.</h2>

          <p class="banner-textg">
            starting at &dollar; <b>20%</b> Offer !
          </p>

          <a href="https://www.beingtraveler.in/booking.html" class="banner-btng">Book now</a>

        </div>

      </div>

      <div class="slider-itemg">

        <img src="./assets/images/mathura.webp" alt="visit mathura" class="banner-imgg">

        <div class="banner-contentg">

          <p class="banner-subtitleg">Visit Mathura !</p>

          <h2 class="banner-titleg">Know Histroy of Lord Krishna.</h2>

          <p class="banner-textg">
            starting at &dollar; <b>25%</b> Offer !
          </p>

          <a href="https://www.beingtraveler.in/booking.html" class="banner-btng">Book now</a>

        </div>

      </div>

<div class="slider-itemg">

        <img src="./assets/images/badrinath.webp" alt="Visit Kedarnath , Book Now" class="banner-imgg">

        <div class="banner-contentg">

          <p class="banner-subtitleg">Visit Badrinath !</p>

          <h2 class="banner-titleg">Most visited right now .</h2>

          <p class="banner-textg">
            starting at &dollar; <b>10%</b> Offer !
          </p>

          <a href="https://www.beingtraveler.in/booking.html" class="banner-btng">Book now</a>

        </div>

      </div>

      <div class="slider-itemg">

        <img src="./assets/images/varanasi.webp" alt="Travel to Rishikesh" class="banner-imgg">

        <div class="banner-contentg">

          <p class="banner-subtitleg">Visit Varanasi !</p>

          <h2 class="banner-titleg">Visit India's Biggest holy River , The Ganga.</h2>

          <p class="banner-textg">
            starting at &dollar; <b>20%</b> Offer !
          </p>

          <a href="https://www.beingtraveler.in/booking.html" class="banner-btng">Book now</a>

        </div>

      </div>

      <div class="slider-itemg">

        <img src="./assets/images/vrindawan.webp" alt="visit mathura" class="banner-imgg">

        <div class="banner-contentg">

          <p class="banner-subtitleg">Visit Vrindawan !</p>

          <h2 class="banner-titleg">The Place of lord krishna.</h2>

          <p class="banner-textg">
            starting at &dollar; <b>35%</b> Offer !
          </p>

          <a href="https://www.beingtraveler.in/booking.html" class="banner-btng">Book now</a>

        </div>

      </div>
    </div>

  </div>

</div>

<div class="ribbon-wrapper">
  <div id="particles-js"></div>
  <div class="ribbon">
    <span class="ribbon-text">जय श्री खाटू श्याम</span>
  </div>
</div>

      <!-- 
        - #SERVICE
      -->

      <section class="section service" aria-label="service">
        <div class="container">

          <div class="title-wrapper">

            <p class="section-subtitle">
              What We Serve
            </p>

            <h2 class="h2 title section-title">Top Values For You</h2>

            <p class="section-text">
              Try a variety of benefits when
              using our services.
            </p>

          </div>

          <div class="service-card">

            <div class="card-icon">
              <img src="./assets/images/service-icon-1.svg" width="60" height="60" loading="lazy" alt="icon">
            </div>

            <h3 class="h3 title card-title">Lot Of Choices</h3>

            <p class="card-text">
              Total 460+ destinations that we work with.
            </p>

          </div>

          <div class="service-card">

            <div class="card-icon">
              <img src="./assets/images/service-icon-2.svg" width="60" height="60" loading="lazy" alt="icon">
            </div>

            <h3 class="h3 title card-title">Best Tour Guide</h3>

            <p class="card-text">
              Our tour guide with 15+ years of experience.
            </p>

          </div>

          <div class="service-card">

            <div class="card-icon">
              <img src="./assets/images/service-icon-3.svg" width="60" height="60" loading="lazy" alt="icon">
            </div>

            <h3 class="h3 title card-title">Easy Booking</h3>

            <p class="card-text">
              With an easy and fast ticket purchase process.
            </p>

          </div>

        </div>
      </section>



<section class="intro-section">
  <div class="overlaygagan"></div>
  <h1>Welcome To BeingTraveler</h1>
  <p class="slogan">Travel around the World with us...</p>
</section>



      <!-- 
        - #DESTINATION
      -->

      <section class="section desti" aria-label="destination">
        <div class="container">

          <p class="section-subtitle">Top destination</p>

          <h2 class="h2 title section-title">Explore Top Destination</h2>

          <ul class="desti-list">

            <li>
              <div class="desti-card">

                <div class="card-banner img-holder" style="--width: 600; --height: 650;">
                  <img src="./assets/images/jaipurgate.webp" width="600" height="650" loading="lazy"
                    alt="Enjoy the Beauty of Jaipur with new Energy" class="img-cover">

                  <span class="card-price">20% Off</span>
                </div>

                <div class="card-content">

                  <h3 class="h3 title">
                    <a href="booking.html" class="card-title">
                      Enjoy the Beauty of Jaipur
                    </a>
                  </h3>

                  <address class="card-text">
                    Rajasthan, India
                  </address>

                  <div class="card-rating">
                    <span class="span">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>

                      4.7
                    </span>

                    <p class="rating-text">(11.1k Review)</p>
                  </div>

                </div>

              </div>
            </li>

            <li>
              <div class="desti-card">

                <div class="card-banner img-holder" style="--width: 600; --height: 650;">
                  <img src="./assets/images/jammu.webp" width="600" height="650" loading="lazy"
                    alt="Enjoy the Beauty of Jammu-Kashmir" class="img-cover">

                  <span class="card-price">20% Off</span>
                </div>

                <div class="card-content">

                  <h3 class="h3 title">
                    <a href="booking.html" class="card-title">
                      Enjoy the Beauty of the Jammu - Kashmir
                    </a>
                  </h3>

                  <address class="card-text">
                    Jammu & Kashmir, India
                  </address>

                  <div class="card-rating">
                    <span class="span">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>

                      4.6
                    </span>

                    <p class="rating-text">(10.9k Review)</p>
                  </div>

                </div>

              </div>
            </li>

            <li>
              <div class="desti-card">

                <div class="card-banner img-holder" style="--width: 600; --height: 650;">
                  <img src="./assets/images/mathura.webp" width="600" height="650" loading="lazy"
                    alt="Enjoy the Beauty of Mathura Temples" class="img-cover">

                  <span class="card-price">20% Off</span>
                </div>

                <div class="card-content">

                  <h3 class="h3 title">
                    <a href="booking.html" class="card-title">
                      Enjoy the Beauty of Mathura Temples
                    </a>
                  </h3>

                  <address class="card-text">
                    Uttar Pradesh, India
                  </address>

                  <div class="card-rating">
                    <span class="span">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>

                      4.7
                    </span>

                    <p class="rating-text">(8k Review)</p>
                  </div>

                </div>

              </div>
            </li>

            <li>
              <div class="desti-card">

                <div class="card-banner img-holder" style="--width: 600; --height: 650;">
                  <img src="./assets/images/tajmahal.webp" width="600" height="650" loading="lazy"
                    alt="Enjoy the Beauty of the Taj-Mahal" class="img-cover">

                  <span class="card-price">20% Off</span>
                </div>

                <div class="card-content">

                  <h3 class="h3 title">
                    <a href="booking.html" class="card-title">
                      Enjoy the Beauty of the Taj-Mahal
                    </a>
                  </h3>

                  <address class="card-text">
                    Agra, U.P , India
                  </address>

                  <div class="card-rating">
                    <span class="span">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>

                      4.7
                    </span>

                    <p class="rating-text">(17.9k Review)</p>
                  </div>

                </div>

              </div>
            </li>

            <li>
              <div class="desti-card">

                <div class="card-banner img-holder" style="--width: 600; --height: 650;">
                  <img src="./assets/images/kedarnath.webp" width="600" height="650" loading="lazy"
                    alt="Enjoy the Beauty of the Kedarnath" class="img-cover">

                  <span class="card-price">20% Off</span>
                </div>

                <div class="card-content">

                  <h3 class="h3 title">
                    <a href="booking.html" class="card-title">
                      Enjoy the Beauty of the Kedarnath
                    </a>
                  </h3>

                  <address class="card-text">
                    Uttrakhand, India
                  </address>

                  <div class="card-rating">
                    <span class="span">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>

                      4.5
                    </span>

                    <p class="rating-text">(5k Review)</p>
                  </div>

                </div>

              </div>
            </li>

            <li>
              <div class="desti-card">

                <div class="card-banner img-holder" style="--width: 600; --height: 650;">
                  <img src="./assets/images/goa.webp" width="600" height="650" loading="lazy"
                    alt="Enjoy the Beauty of the Goa and it's Beach" class="img-cover">

                  <span class="card-price">20% Off</span>
                </div>

                <div class="card-content">

                  <h3 class="h3 title">
                    <a href="booking.html" class="card-title">
                      Enjoy the Beauty of the Goa
                    </a>
                  </h3>

                  <address class="card-text">
                    Goa, India
                  </address>

                  <div class="card-rating">
                    <span class="span">
                      <ion-icon name="star" aria-hidden="true"></ion-icon>

                      4.8
                    </span>

                    <p class="rating-text">(29.6k Review)</p>
                  </div>

                </div>

              </div>
            </li>

          </ul>

          <a href="https://www.beingtraveler.in/package-list.php" class="btn btn-primary">View All Destination</a>

        </div>
      </section>





      <!-- 
        - #EXPERIENCE
      -->

      <section class="section exp" aria-label="experience">
        <div class="container">

          <div class="exp-content">

            <p class="section-subtitle">
              Our Experience
            </p>

            <h2 class="h2 title section-title">With Our Experience We Will Serve You</h2>

            <p class="section-text">
              Since we first opened we have always prioritized the convenience of our users by providing low prices and
              with a easy process.
            </p>

            <ul class="exp-list">

              <li class="exp-item">
                <h3 class="h3 title item-title">20</h3>

                <p class="item-text">
                  Years <br>
                  Experience
                </p>
              </li>

              <li class="exp-item">
                <h3 class="h3 title item-title">460+</h3>

                <p class="item-text">
                  Destination <br>
                  Collaboration
                </p>
              </li>

              <li class="exp-item">
                <h3 class="h3 title item-title">50K+</h3>

                <p class="item-text">
                  Happy <br>
                  Customer
                </p>
              </li>

            </ul>

          </div>

          <figure class="exp-banner">

            <img src="./assets/images/experience-banner.webp" width="550" height="660" loading="lazy"
              alt="experience banner" class="w-100">

            <img src="./assets/images/exp-shape.svg" width="75" height="109" loading="lazy" alt="24/7 Guide Support"
              class="exp-shape">

          </figure>

        </div>
      </section>





      <!-- 
        - #GALLERY
      -->

      <section class="section gallery" aria-label="gallery">
        <div class="container">

          <p class="section-subtitle">Photo Gallery</p>

          <h2 class="h2 title section-title">
            Photo’s From Travelers
          </h2>

          <ul class="gallery-list">

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 378;">
                <img src="./assets/images/gallery-1.webp" width="700" height="378" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 925;">
                <img src="./assets/images/gallery-2.webp" width="700" height="925" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 840;">
                <img src="./assets/images/gallery-3.webp" width="700" height="840" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 378;">
                <img src="./assets/images/gallery-4.webp" width="700" height="378" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 378;">
                <img src="./assets/images/gallery-5.webp" width="700" height="378" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 378;">
                <img src="./assets/images/gallery-6.webp" width="700" height="378" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

           <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 925;">
                <img src="./assets/images/gallery-7.webp" width="700" height="925" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 925;">
                <img src="./assets/images/gallery-8.webp" width="700" height="925" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 840;">
                <img src="./assets/images/gallery-9.webp" width="700" height="840" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 378;">
                <img src="./assets/images/gallery-10.webp" width="700" height="378" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 378;">
                <img src="./assets/images/gallery-11.webp" width="700" height="378" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 378;">
                <img src="./assets/images/gallery-12.webp" width="700" height="378" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>


           <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 925;">
                <img src="./assets/images/gallery-13.webp" width="700" height="925" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 925;">
                <img src="./assets/images/gallery-14.webp" width="700" height="925" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 840;">
                <img src="./assets/images/gallery-15.webp" width="700" height="840" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 378;">
                <img src="./assets/images/gallery-16.webp" width="700" height="378" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 378;">
                <img src="./assets/images/gallery-17.webp" width="700" height="378" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 378;">
                <img src="./assets/images/gallery-18.webp" width="700" height="378" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>
  <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 378;">
                <img src="./assets/images/gallery-19.webp" width="700" height="378" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 925;">
                <img src="./assets/images/gallery-20.webp" width="700" height="925" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 840;">
                <img src="./assets/images/gallery-21.webp" width="700" height="840" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>

            <li class="gallery-item">

              <figure class="item-banner img-holder" style="--width: 700; --height: 378;">
                <img src="./assets/images/gallery-22.webp" width="700" height="378" loading="lazy" alt="gallery"
                  class="img-cover">
              </figure>

            </li>


          </ul>

        </div>
      </section>



          <!--
            - SERVICE
          -->

          <div class="serviceg">

            

            <div class="service-containerg">

              <a href="#" class="service-itemg">

                <div class="service-icong">
                  <ion-icon name="boat-outline"></ion-icon>
                </div>

                <div class="service-contentg">

                  <h3 class="service-titleg">Worldwide Traveling</h3>
                  <p class="service-descg">We are here for you</p>

                </div>

              </a>

              <a href="#" class="service-itemg">
              
                <div class="service-icong">
                  <ion-icon name="rocket-outline"></ion-icon>
                </div>
              
                <div class="service-contentg">
              
                  <h3 class="service-titleg">Quick Booking</h3>
                  <p class="service-descg">We are very Fast</p>
              
                </div>
              
              </a>

              <a href="#" class="service-itemg">
              
                <div class="service-icong">
                  <ion-icon name="call-outline"></ion-icon>
                </div>
              
                <div class="service-contentg">
              
                  <h3 class="service-titleg">Best Online Support</h3>
                  <p class="service-descg">Hours: 8AM - 11PM</p>
              
                </div>
              
              </a>

              <a href="#" class="service-itemg">
              
                <div class="service-icong">
                  <ion-icon name="arrow-undo-outline"></ion-icon>
                </div>
              
                <div class="service-contentg">
              
                  <h3 class="service-titleg">Refund Policy</h3>
                  <p class="service-descg">Easy Refunds </p>
              
                </div>
              
              </a>

              <a href="#" class="service-itemg">
              
                <div class="service-icong">
                  <ion-icon name="ticket-outline"></ion-icon>
                </div>
              
                <div class="service-contentg">
              
                  <h3 class="service-titleg">20% money back</h3>
                  <p class="service-descg">For Booking over Call</p>
              
                </div>
              
              </a>

            </div>

          </div>



   <!--
  - BANNER
-->

<div class="bannerg">

  <div class="containerg">

    <div class="slider-containerg has-scrollbarg">

      <div class="slider-itemg">

        <img src="./assets/images/agra.webp" alt="Agra Top service , Book Now" class="banner-imgg">

        <div class="banner-contentg">

          <p class="banner-subtitleg">Trending Location</p>

          <h2 class="banner-titleg">Top trending Locations</h2>

          <p class="banner-textg">
            starting at &dollar; <b>20</b>.00
          </p>

          <a href="https://www.beingtraveler.in/booking.html" class="banner-btng">Book now</a>

        </div>

      </div>

      <div class="slider-itemg">

        <img src="./assets/images/lake.jpg" alt="modern sunglasses" class="banner-imgg">

        <div class="banner-contentg">

          <p class="banner-subtitleg">Trending Lakes</p>

          <h2 class="banner-titleg">Travel to Top Indian lakes</h2>

          <p class="banner-textg">
            starting at &dollar; <b>15</b>.00
          </p>

          <a href="https://www.beingtraveler.in/booking.html" class="banner-btng">Book now</a>

        </div>

      </div>

      <div class="slider-itemg">

        <img src="./assets/images/tajmahal.webp" alt="Tajmahal is waiting For you" class="banner-imgg">

        <div class="banner-contentg">

          <p class="banner-subtitleg">Travel Offer</p>

          <h2 class="banner-titleg">Being Traveler sale</h2>

          <p class="banner-textg">
            starting at &dollar; <b>29</b>.99
          </p>

          <a href="https://www.beingtraveler.in/booking.html" class="banner-btng">Book now</a>

        </div>

      </div>

    </div>

  </div>

</div>

      <!-- 
        - #CTA
      -->

      <section class="section cta" aria-label="call to action">
        <div class="container">

          <div class="cta-card has-bg-image" style="background-image: url('./assets/images/cta-bg.jpg')">

            <h2 class="h2 title section-title">
              Prepare Yourself & Let’s Explore The Beauty Of The World

              <img src="./assets/images/title-icon.svg" width="36" height="36" loading="lazy" alt="icon" class="img">
            </h2>

            <p class="section-text">
              We have many special offers especially for you.
            </p>

            <a href="https://www.beingtraveler.in/package-list.php" class="btn btn-primary">Get Started</a>

          </div>

        </div>
      </section>

    </article>
  </main>





  <!-- 
    - #FOOTER
  -->

  <footer class="footer">
    <div class="container">

      <div class="footer-top">

        <div class="footer-brand">

          <a href="https://www.beingtraveler.in/" class="logo">
            <img src="./assets/images/logo.webp" width="187" height="38" alt="logo">
          </a>

          <p class="footer-text">
            We always make our customer
            happy by providing as many
            choices as possible
          </p>

          <ul class="social-list">

            <li>
              <a href="https://www.instagram.com/beingtraveler_in" class="social-link">
                <ion-icon name="logo-instagram"></ion-icon>
              </a>
            </li>

            <li>
              <a href="https://www.facebook.com/beingtraveler_in" class="social-link">
                <ion-icon name="logo-facebook"></ion-icon>
              </a>
            </li>

            <li>
              <a href="https://www.twitter.com/beingtraveler_in" class="social-link">
                <ion-icon name="logo-twitter"></ion-icon>
              </a>
            </li>

          </ul>

        </div>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">About</p>
          </li>

          <li>
            <a href="https://www.beingtraveler.in/about.html" class="footer-link">About Us</a>
          </li>

          <li>
            <a href="https://www.beingtraveler.in/terms.html" class="footer-link">Terms Of Use</a>
          </li>

          <li>
            <a href="https://www.beingtraveler.in/privacy.html" class="footer-link">Privacy Policy</a>
          </li>

          <li>
            <a href="https://www.beingtraveler.in/blog.html" class="footer-link">Blog</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Company</p>
          </li>

          <li>
            <a href="https://www.beingtraveler.in/about.html" class="footer-link">Why Being Traveler</a>
          </li>

          <li>
            <a href="https://www.beingtraveler.in/enquiry.php" class="footer-link">Partner With Us</a>
          </li>

      
          <li>
            <a href="https://www.beingtraveler.in/founders.html" class="footer-link">Founders</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Support</p>
          </li>

          <li>
            <a href="https://www.beingtraveler.in/admin/index.php" class="footer-link">Admin Login</a>
          </li>

          <li>
            <a href="https://www.beingtraveler.in/enquiry.php" class="footer-link">Support Center</a>
          </li>

          <li>
            <a href="https://www.beingtraveler.in/package-list.php" class="footer-link">Packages</a>
          </li>

          <li>
            <a href="https://www.beingtraveler.in/contact.html" class="footer-link">Contact Us</a>
          </li>

         

        </ul>

        <div class="footer-list">

          <p class="footer-list-title">Get in Touch</p>

          <p class="footer-text">
            Question or feedback? We’d love to hear from you.
          </p>

<form action="newsletter_signup.php" method="post" class="input-wrapper">
  <input type="email" name="email_address" placeholder="Email Address" autocomplete="off" required
    class="input-field">

  <button type="submit" class="input-btn" aria-label="send a message">
    <ion-icon name="paper-plane-outline" aria-hidden="true"></ion-icon>
  </button>
</form>
  
        </div>

      </div>

      <div class="footer-bottom">
 <p class="copyright">
         We Accept
        </p>
         <img src="./assets/images/payment.png" alt="payment method" class="payment-img">

        <p class="copyright">
          Copyright &copy; <a href="https://www.beingtraveler.in/">BeingTraveler</a> all rights reserved. Made by <a href="#"> GA </a>
        </p>

        <ul class="footer-bottom-list">

          <li>
            <a href="https://www.beingtraveler.in/terms.html" class="footer-bottom-link">Terms and Condition</a>
          </li>

          <li>
            <a href="https://www.beingtraveler.in/privacy.html" class="footer-bottom-link">Privacy and Policy</a>
          </li>

        </ul>

      </div>

    </div>
  </footer>



<a href="//www.dmca.com/Protection/Status.aspx?ID=207433fd-928d-421d-b731-9c5dd46fafda" title="DMCA.com Protection Status" class="dmca-badge"> <img src ="https://images.dmca.com/Badges/dmca-badge-w150-5x1-03.png?ID=207433fd-928d-421d-b731-9c5dd46fafda"  alt="DMCA.com Protection Status" /></a>  <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>

  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>
  

  <!-- 
    - ionicon link
  -->
  
  <script>  function closeThanksMessage() {
  document.getElementById('thanks-message').style.display = 'none';
}</script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<a href="https://api.whatsapp.com/send/?phone=917827573202&text=Hello,%20Get%20in%20touch%20with%20us&app_absent=0" class="whatsapp-icon" target="_blank" style="position: fixed; bottom: 10px; right: 10px; z-index: 9999;">
  <img src="./assets/images/WhatsApp.webp" alt="WhatsApp Chat" style="width: 60px; height: 60px; border-radius: 50%; box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); padding: 10px;" />
</a>

<div class="popup-form">
    <div class="popup-form-content">
        <span class="close-btn" onclick="closeForm()">&times;</span>
        <h2>Contact Us</h2>
        <form id="contact-form" onsubmit="return submitForm()">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" placeholder="Enter your name" required>
                <div id="name-validation" class="validation-message"></div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Enter your email" required>
                <div id="email-validation" class="validation-message"></div>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" placeholder="Enter your phone number" required>
                <div id="phone-validation" class="validation-message"></div>
            </div>
            <button type="submit" class="loading">Submit</button>
        </form>
    </div>
</div>

<div id="success-message" class="popup-form success-message" style="display:none;">
    <span class="close-btn" onclick="closeSuccessMessage()">&times;</span>
    <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
      <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
      <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
    </svg>
    <h2>Thank you!</h2>
    <p>Your message has been sent successfully.</p>
</div>

<div id="thanks-message" class="popup-form thanks-message" style="display:none;">
    <span class="close-btn" onclick="closeThanksMessage()">&times;</span>
    <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
      <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
      <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
    </svg>
    <h2>Thank You <span id="user-name"></span> for Your Submission!</h2>
    <p>Your request is important to us and we're on it! Expect a response from our team shortly.</p>
    <hr>
    <h3>Contact Details</h3>
    <p>Need to reach us sooner? Feel free to use the following details:</p>
    <ul>
        <li><strong>Phone:</strong> <a href="tel:+917827573202">+91 78275 73202</a></li>
        <li><strong>Email:</strong> <a href="mailto:contact@beingtraveler.in">contact@beingtraveler.in</a></li>
        <li><strong>Address:</strong> 2 Main Crossing, Runkata, Agra, Uttar Pradesh, India, 282007</li>
    </ul>
    <hr>
    <h3>Travel Quote</h3>
    <p>"Travel is the only thing you buy that makes you richer."</p>
</div>


<script>


function openForm() {
  document.querySelector(".popup-form").style.display = "block";
}

function closeForm() {
  document.querySelector(".popup-form").style.display = "none";
  document.getElementById("success-message").style.display = "none";
  document.getElementById("thanks-message").style.display = "none";
  document.getElementById("name-validation").textContent = "";
  document.getElementById("email-validation").textContent = "";
  document.getElementById("phone-validation").textContent = "";
}



function submitForm() {
  // Validate form fields
  let name = document.getElementById("name").value.trim();
  let email = document.getElementById("email").value.trim();
  let phone = document.getElementById("phone").value.trim();
  let nameValidation = document.getElementById("name-validation");
  let emailValidation = document.getElementById("email-validation");
  let phoneValidation = document.getElementById("phone-validation");
  let isValid = true;
  if (!name) {
    nameValidation.textContent = "Please enter your name";
    isValid = false;
  }
  if (!email) {
    emailValidation.textContent = "Please enter your email";
    isValid = false;
  } else if (!isValidEmail(email)) {
    emailValidation.textContent = "Please enter a valid email address";
    isValid = false;
  }
  if (!phone) {
    phoneValidation.textContent = "Please enter your phone number";
    isValid = false;
  } else if (!isValidPhone(phone)) {
    phoneValidation.textContent = "Please enter a valid phone number";
    isValid = false;
  }

  if (isValid) {
    // Prepare form data
    const formData = new FormData();
    formData.append("fname", name);
    formData.append("email", email);
    formData.append("mobileno", phone);
    formData.append("subject", "Enquiry from Popup Form"); // Add a default subject value
    formData.append("description", ""); // Add an empty description value
    formData.append("submit1", "true"); // Add a submit flag
var userName = document.getElementById('name').value;
document.getElementById('user-name').textContent = userName;
    // AJAX request
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php"); // POST request to the same index.php
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Handle server response
        if (xhr.responseText === "success") {
          document.querySelector(".popup-form-content").style.display = "none";
          document.getElementById("thanks-message").style.display = "block";
          function closeThanksMessage() {
  document.getElementById('thanks-message').style.display = 'none';
}
          setTimeout(closeThanksMessage, 10000); // Close the thanks message after 3 seconds
          setTimeout(closeForm, 11000); // Close the form after 5 seconds
        } else {
          alert("Error: " + xhr.responseText);
        }
      }
    };
    xhr.send(formData);
    return false;
  } else {
    return false;
  }
}

function isValidEmail(email) {
  // Validate email using regular expression
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return regex.test(email);
}

function isValidPhone(phone) {
  // Validate phone using regular expression
  const regex = /^\d{10}$/;
  return regex.test(phone);
}

openForm();
</script>

<script>
particlesJS('particles-js', {
  "particles": {
    "number": {
      "value": 80,
      "density": {
        "enable": true,
        "value_area": 800
      }
    },
    "color": {
      "value": "#FFD700" // Set to golden color
    },
    "shape": {
      "type": "edge", // Set to lines instead of circles
    },
    "line_linked": {
      "enable": true,
      "distance": 150,
      "color": "#FFD700",
      "opacity": 0.4,
      "width": 1
    },
    /* More configuration as needed... */
  }
});
</script>
</body>

</html>