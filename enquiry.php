<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['submit1']))
{
$fname=$_POST['fname'];
$email=$_POST['email'];	
$mobile=$_POST['mobileno'];
$subject=$_POST['subject'];	
$description=$_POST['description'];
$sql="INSERT INTO  tblenquiry(FullName,EmailId,MobileNumber,Subject,Description) VALUES(:fname,:email,:mobile,:subject,:description)";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':mobile',$mobile,PDO::PARAM_STR);
$query->bindParam(':subject',$subject,PDO::PARAM_STR);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
    // Generate reference number
        $reference_number = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);

$msg="We have received your query :) We will contact you soon. \n must check your spam/junk folder if confirmation mail not showing";
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
    mail($to,$subject,$msg,$headers);
}
else 
{
$error="Something went wrong. Please try again";
}

}

?>
<!DOCTYPE HTML>
<html>
<head>
<title>BeingTraveler | Tour & Travels</title>
<meta http-equiv='content-language' content='en-gb'>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="BeingTraveler | Tour & Travels" />
<meta name='description' content='Send inquiries or request specific information about BeingTraveler's travel packages and services.'>
<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<!-- Custom Theme files -->
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>
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
<!-- top-header -->
<div class="top-header">

<div class="banner-1 ">
	<div class="container">
		<h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">BeingTraveler | Tour & Travels</h1>
	</div>
</div>
<!--- /banner-1 ---->
<!--- privacy ---->
<div class="privacy">
	<div class="container">
		<h3 class="wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">Any Question ? Just fill this :)</h3>
		<form name="enquiry" method="post">
		 <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
	<p style="width: 350px;">
		
			<b>Your Full Name</b>  <input type="text" name="fname" class="form-control" id="fname" placeholder="Full Name" required="">
	</p> 
<p style="width: 350px;">
<b>Email</b>  <input type="email" name="email" class="form-control" id="email" placeholder="Valid Email id" required="">
	</p> 

	<p style="width: 350px;">
<b>Mobile No</b>  <input type="text" name="mobileno" class="form-control" id="mobileno" maxlength="10" placeholder="10 Digit mobile No" required="">
	</p> 

	<p style="width: 350px;">
<b>Subject ?</b>  <input type="text" name="subject" class="form-control" id="subject"  placeholder="Subject" required="">
	</p> 
	<p style="width: 350px;">
<b>Description</b>  <textarea name="description" class="form-control" rows="6" cols="50" id="description"  placeholder="Description" required=""></textarea> 
	</p> 

			<p style="width: 350px;">
<button type="submit" name="submit1" class="btn-primary btn">Submit</button>
			</p>
			</form>

		
	</div>
</div>
<!--- /privacy ---->
<!--- footer-top ---->
<!--- /footer-top ---->
<?php include('includes/footer.php');?>


</body>
</html>