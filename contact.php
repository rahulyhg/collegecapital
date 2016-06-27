<?php
	session_start();	
	$title = "Contact College Capital";
	$keywords = "contact details, financial professionals, broker network, College Capital";
	$description = "Contact College Capital";
	$page = "contact"; /* this name must match css to display active menu */
	require_once("inc/head.php"); 
	
	//contact form specific changes
	$str='';$success='';
	if($_SESSION['errStr'])
	{
		$str='<div class="error">'.$_SESSION['errStr'].'</div>';
		unset($_SESSION['errStr']);
	} elseif($_SESSION['sent']) {
		$success="<p style='color: #444; font-size: 16px;'>Thank you for your enquiry. We will be in touch with you shortly.</p>";
		
		$css='<style type="text/css">#RegisterUserForm{display:none;}</style>';
		
		unset($_SESSION['sent']);
	} else {
		//do nothing
	}
?>
<script type="text/javascript" src="<?php echo $site_path;?>captcha_ajax.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
    $("#RegisterUserForm label").inFieldLabels();
	//$('#RegisterUserForm').h5Validate();
	$('#RegisterUserForm').html5form({    
        messages : 'de', // Options 'en', 'es', 'it', 'de', 'fr', 'nl', 'be', 'br'
        responseDiv : '#response',
		//labels: 'hide',
		allBrowsers: true,
		method: 'POST'    
    })
});
</script>
<div id="page-banner"><h1>Contact Us</h1></div>
<div id="col-left">    
      
  <h3>College Capital Pty Ltd</h3>
   <p><strong>1300 535 935</strong></p>
  <p>Level 5,<br />
    15&#8211;19 Claremont Street, <br />
  South Yarra VIC 3141</p>
  <p>PO  Box 1508<br />
  Camberwell  East VIC 3126</p>
 
</div>
	<div id="col-right">
 

        <h2>Or complete our <strong>online enquiry form</strong> ...</h2>
        	<?php if(strlen($str)>0){ ?>
<p><?=$str;?></p>
            <?php } elseif (strlen($success)>0) {?>
                <p><?=$success.$css;?></p>
            <?php } else { //do nothing 
            } ?>
        		<div id="registration" >
            		<form id="RegisterUserForm" name="RegisterUserForm" action="<?php echo $site_path;?>contact-submit.php" method="post">
                	<fieldset>
                    
                    <p>
                    	<span class="field-label">Name*</span>
                        <span class="field">
                        	<label for="fname">Your name</label>
                        	<input id="fname" name="fname" type="text" required="required" class="text" value="" />
                        </span>
                    </p>
                    
                    <p>
                    <span class="field-label">Surname*</span>
                        <span class="field">
                        <label for="last">Your surname</label>
                        <input id="last" name="last" type="text" required="required" class="text" value="" /></span>
                    </p>
                    
                    <p><span class="field-label">Phone*</span>
                        <span class="field">
                        <label for="tel">Your contact phone</label>
                        <input id="tel" name="tel" type="tel" required="required" class="text" value="" /></span>
                    </p>
                    
                    <p><span class="field-label">Email*</span>
                        <span class="field">
                        <label for="email">Your email</label>
                        <input id="email" name="email" type="email" required="required" class="text" value="" /></span>
                    </p>
                    <p><span class="field-label">Address</span>
                        <span class="field">
                        <label for="addr">Your address</label>
                        <input id="addr" name="addr" type="text"  class="text" value="" /></span>
                    </p>
                    <p><span class="field-label">Suburb</span>
                        <span class="field">
                        <label for="suburb">Your suburb</label>
                        <input id="suburb" name="suburb" type="text"  class="text" value="" /></span>
                    </p>
                    <p><span class="field-label">State</span>
                        <span class="field">
                    	<!--<label for="state">Your state</label>-->
                        <select name="state" id="state" >
                        	<option value="">Select state</option>
                            <option value="VIC" selected="selected">VIC</option>
                            <option value="NSW">NSW</option>
                            <option value="QLD">QLD</option>
                            <option value="ACT">ACT</option>
                            <option value="NT">NT</option>
                            <option value="WA">WA</option>
                            <option value="SA">SA</option>
                            <option value="TAS">TAS</option>
                            <option value="OTHER">OTHER</option>
                      </select></span>
                    </p>
                    
                    <p><span class="field-label">Postcode</span>
                        <span class="field">
                        <label for="postcode">Your postcode</label>
                        <input id="postcode" name="postcode" type="text"  class="text" value="" style="width: 40%;"/></span>
                    </p>
                    
                    <p><span class="field-label">Preferred Contact*</span>
                        <span class="field">
                    	<!--<label for="contact">Preferred contact</label>-->
                        <select name="contact" id="contact" required="required">
                        	<option value="" selected="selected">Select preferred contact</option>
                            <option value="No preference">No preference</option>
                            <option value="Phone">Phone</option>
                            <option value="Email">Email</option>
                            <option value="Post">Post</option>
                        </select></span>
                    </p>
           
                    <p><span class="field-label">How did you find us?</span>
                        <span class="field">
                    	<!--<label for="find">How did you find us?</label>-->
                        <select name="how" id="how">
                        	<option value="" selected="selected">How did you find us?</option>
                            <option value="Friend">Friend</option>
                            <option value="Google">Google</option>
                            <option value="Twitter">Twitter</option>
                            <option value="LinkedIn">Linked In</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Newspaper">Newspaper</option>
                            <option value="Other">Other</option>
                        </select></span>
                    </p>
                    
                    <p><span class="field-label">Enquiry Details</span>
                        <span class="field">
                        <label for="message">Enquiry Details</label>
                        <textarea name="message" id="message"  class="textarea"></textarea></span>
                    </p>
                    
                    <p><span class="field-label">Security Code*</span>
                        <span class="field">
                        <img id="imgCaptcha" src="<?php echo $site_path;?>captcha_image.php"  style="width: 90px; float: left; height: 29px; padding-right: 6px;"/><input id="txtCaptcha" name="txtCaptcha" type="text" required="required" value="" class="secure" maxlength="5" /><br clear="all"/><a href="javascript:getParam(document.RegisterUserForm,1)" class="sml">Get another code</a>
                     </span></p> 
                     <span class="field-label"></span>
                        <span class="field">
                    <button id="btn-submit" type="submit" style="float: left; margin-right: 10px; padding: 5px 73px 5px 73px;">Submit</button></span>
				</fieldset>
			</form>
    </div>
</div>
</div>
<?php include("inc/foot.php"); ?>