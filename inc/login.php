<script type="text/javascript" language="javascript">
$(document).ready(function() {
    $("#LoginForm label").inFieldLabels();
	//$('#RegisterUserForm').h5Validate();
	$('#LoginForm').html5form({    
        messages : 'de', // Options 'en', 'es', 'it', 'de', 'fr', 'nl', 'be', 'br'
        responseDiv : '#response',
		//labels: 'hide',
		allBrowsers: true,
		method: 'POST'    
    })
});
</script>

<h1 style="padding: 0!important;">Login to cCAP</h1>
<form id="LoginForm" name="LoginForm" action="" method="post">
<fieldset>
 <p>
                    	<span class="login-label">Username</span>
                        <span class="login">
                        	<label for="fname">Your username</label>
                        	<input id="fname" name="fname" type="text" required="required" class="text" value="" />
                        </span>
                    </p>
                    
                    <p>
                    <span class="login-label">Password</span>
                        <span class="login">
                        <label for="last">Your password</label>
                        <input id="last" name="last" type="text" required="required" class="text" value="" /></span>
                    </p>
                      <span class="login-label">&nbsp;</span><button id="btn-submit" type="submit" style="float: left; ">LOGIN <i class="icon-circle-arrow-right"></i></button></span>
				</fieldset>
</form>
