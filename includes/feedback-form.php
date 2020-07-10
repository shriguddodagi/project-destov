<?php 

require_once('./FormSanitizer.php');
if(isset($_POST['submit']) && empty($feedbackDone) && is_null($feedbackDone) && (isset($feedbackDone) == 0)) {
	echo "Record";
	$feedbackDone = true;
	unset($_POST);
	print_r($_POST);

   /*
    $name = FormSanitizer::sanitizeFormNameNumber($_POST['name']);
    $email = FormSanitizer::sanitizeFormEmail($_POST['email']);
    $phone = FormSanitizer::sanitizeFormNameNumber($_POST['phone']);
    $message = $_POST['message'];

    $query = "INSERT INTO `inquiries` (name, email, phone, message) VALUES('$name', '$email', '$phone', '$message')";
    if(mysqli_query($cn, $query)) {
    	$feedbackDone = true;
    	unset($_POST['submit']);
    	// // echo '<script type="text/javascript">location.reload(true);</script>';
    	// // header("Location: ". basename($_SERVER['REQUEST_URI']) . "#feedback");
    	// // $header = basename($_SERVER['REQUEST_URI']);
    	// // echo $header;
    	// // header("Location: $header");
    	// header_remove();
    	// header('Location: '.$_SERVER['REQUEST_URI']);
    }
    unset($_REQUEST);
    */
} else {
	echo "No Record";
}

?>


<div id="feedback" class="container content text-center margin-b-40">
  <div class="col-sm-12 sm-margin-b-30">

    <h4 
	    style = "background: black;
	    color: white;
	    border-radius: 8px;
	    font-weight: 100;
	    width: max-content;
	    display: inline-flex;
	    padding: 5px 30px;">Get In Touch</h4>
    <h5 class="text-center text-white bg-success rounded d-block" 
    	style="padding: 15px; display: <?php echo (isset($feedbackDone)) ? "block" : "none"; ?>; border-radius: 10px; "><?php if (isset($feedbackDone)) { echo "THANK YOU! OUR THEAM WILL CONTACT YOU SOON"; } ?></h5>
	<form method="POST" action="">
	    <input name="name" id="name" type="text" class="form-control footer-input margin-b-20" placeholder="Name" required pattern="^\w+(\s+\w+)*$">
	    <input name="email" id="email" type="email" class="form-control footer-input margin-b-20" placeholder="Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
	    <input name="phone" id="phone" type="text" class="form-control footer-input margin-b-20" placeholder="Phone" required pattern="[0-9]{6,}">
	    <textarea name="message" id="message" class="form-control footer-input margin-b-30" rows="6" placeholder="Message" required pattern="^\w+(\s+\w+)*$"></textarea>
    	<button name="submit" id="submit" type="submit" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Submit</button>
    </form>
  </div>
</div>