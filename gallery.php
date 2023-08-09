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

 <style>
    .gallery {
      margin-top: 200px; /* adjust the value as needed */
    }
  </style>
 <!--
 - my edit 
 -->
  <style>

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
  color: #aaa;
  transition: color 0.2s;
}

.close-btn:hover {
  color: #000;
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

button {
  width: 100%;
  padding: 0.5rem 1rem;
  background: #22a6b3;
  border: none;
  color: #000;
  cursor: pointer;
  border-radius: 5px;
  transition: background 0.2s;
}

button:hover {
  background: #1e868c;
}

.success-message {
     z-index: 9998;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  font-size: 1.5rem;
  margin-top: 2rem;
  background: #22a6b3;
  padding: 1rem;
  border-radius: 5px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
  color: #fff;
}

.thanks-message {
     z-index: 9999;
  position: absolute;
  top: calc(50% + 50px); 
  left: 50%;
  transform: translateX(-50%);
  text-align: center;
  font-size: 1.5rem;
  background: #dff0d8;
  padding: 1rem;
  border-radius: 5px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
  color: #000;
}


}

 .gallery {
      margin-top: 100px; /* adjust the value as needed */
    }



 </style>
 <style>
     
.gold-heading {
    font-size: 14px; /* Adjust according to your preference */
    color: #FFD700; /* Gold color */
    margin-top: 100px; /* Space from the top, adjust as needed */
    position: center;
  padding: 1rem;
  border-radius: 5px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
  color: #000;
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
      <img src="./assets/images/logo.webp" width="50" height="50" alt="" class="img">
    </div>
  </div>

 
<h1 class="gold-heading">Explore Our Travel Gallery - BeingTraveler</h1>


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
            <a href="https://www.beingtraveler.in/about.html" class="navbar-link">About</a>
          </li>

          <li class="navbar-item">
            <a href="https://www.beingtraveler.in/package-list.php" class="navbar-link">Tour Packages</a>
          </li>

          <li class="navbar-item">
            <a href="https://www.beingtraveler.in/restaurant" class="navbar-link">Restaurants</a>
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
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<a href="https://api.whatsapp.com/send/?phone=917827573202&text=Hello,%20Get%20in%20touch%20with%20us&app_absent=0" class="whatsapp-icon" target="_blank" style="position: fixed; bottom: 10px; right: 10px; z-index: 9999;">
  <img src="./assets/images/WhatsApp.webp" alt="WhatsApp Chat" style="width: 40px; height: 40px; border-radius: 50%; box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); padding: 5px;" />
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
    <h2>Thank you!</h2>
    <p>Your message has been sent successfully.</p>
</div>

<div id="thanks-message" class="popup-form thanks-message" style="display:none;">
    <h2>Thank You for Your Submission!</h2>
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

document.addEventListener("DOMContentLoaded", function () {
  setTimeout(openForm, 15000);
});

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

    // AJAX request
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "index.php"); // POST request to the same index.php
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Handle server response
        if (xhr.responseText === "success") {
          document.querySelector(".popup-form-content").style.display = "none";
          document.getElementById("thanks-message").style.display = "block";
          setTimeout(closeThanksMessage, 3000); // Close the thanks message after 3 seconds
          setTimeout(closeForm, 5000); // Close the form after 5 seconds
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
</body>

</html>

