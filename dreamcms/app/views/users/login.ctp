<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
	$(document).ready(function(){
	  $("#UserUsername").focus();
	});
</script>
<?php 
$this->set('page','login');
echo $this->Html->css('dreamcms-general.css'); 
echo $this->Html->css('font-awesome.css');
?>
<body id='<?php echo $page ?>' >
<!-- header -->
<div id="header-wrap">
	<div id="header-client-logo"></div>
</div>
<div id="panel" style="min-height: 100px!important;">
	<div id="band">
		<div id="band-left"><h1>Welcome to cCap</h1><p>Please enter a valid username and password<br /> to enter the website. <br /><strong>Any questions?</strong> <a href="http://www.collegecapital.com.au/contact">Please do not hesitate to contact College Capital.</a></p>
        </div>
		<div id="band-right" class="login">
			<h1>Login to cCAP</h1>
			<?php
				echo $this->Session->flash();    
				echo $this->Session->flash('auth');
				if  ($session->check('Message.auth')) $session->flash('auth');
				echo $form->create('User', array('action' => 'login'));
				echo $form->input('username', array('between'=>''));
				echo $form->input('password', array('between'=>' '));
				echo $form->end('Login');
			?>

		</div>
   </div>
</div>   
<!-- footer -->
<div id="footer"><a href="http://www.collegecapital.com.au" target="_blank">&copy; <?php echo date('Y'); ?> College Capital</a> | <a href="http://www.echo3.com.au" target="_blank">web</a></div>
</body>
<?php echo $this->element('sql_dump'); ?>
