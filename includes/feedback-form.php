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
    	style="padding: 15px; display: <?php echo (isset($_SESSION['feedbackDone'])) ? "block" : "none"; ?>; border-radius: 10px; "><?php if (isset($feedbackDone)) { echo "THANK YOU! OUR THEAM WILL CONTACT YOU SOON"; } ?></h5>
		<form method="POST" action="">
			<div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" id="check" name="check" checked>
				<label class="form-check-label" for="check">Contacting For Inquiry</label>
			</div>
	    <input name="name" id="name" type="text" class="form-control footer-input margin-b-20" placeholder="Name" required pattern="^\w+(\s+\w+)*$">
	    <input name="email" id="email" type="email" class="form-control footer-input margin-b-20" placeholder="Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
	    <input name="phone" id="phone" type="text" class="form-control footer-input margin-b-20" placeholder="Phone" required pattern="[0-9]{6,}">
	    <textarea name="message" id="message" class="form-control footer-input margin-b-30" rows="6" placeholder="Message" required pattern="^\w+(\s+\w+)*$"></textarea>
    	<button name="submit" id="submit" type="submit" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Submit</button>
    </form>
  </div>
</div>