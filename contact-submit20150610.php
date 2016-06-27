<?php

/* config start */

//$emailAddress = 'glynnis@echo3.com.au'; TEST
$emailAddress = 'admin@collegecapital.com.au';

/* config end */

require $_SERVER['DOCUMENT_ROOT']."/phpmailer/class.phpmailer.php5.php";
session_start();

foreach($_POST as $k=>$v)
{
	if(ini_get('magic_quotes_gpc'))
	$_POST[$k]=stripslashes($_POST[$k]);
	
	$_POST[$k]=htmlspecialchars(strip_tags($_POST[$k]));
}


$err = array();

if(!checkLen('fname'))
	$err[]='The name field is too short or empty!';

if(!checkLen('last'))
	$err[]='The surname field is too short or empty!';	

if(!checkLen('tel'))
	$err[]='The phone field is too short or empty!';
		
if(!checkLen('email'))
	$err[]='The email field is too short or empty!';
else if(!checkEmail($_POST['email']))
	$err[]='Your email is not valid!';

/*if(!checkLen('addr'))
	$err[]='The address field is too short or empty!';
	
if(!checkLen('suburb'))
	$err[]='The suburb field is too short or empty!';

if(!checkLen('state'))
	$err[]='You have not selected "State"!';
	
if(!checkLen('country'))
	$err[]='You have not selected "Country"!';		
	
if(!checkLen('postcode'))
	$err[]='The postcode field is too short or empty!';	*/
	
if(!checkLen('contact'))
	$err[]='You have not selected "Preferred contact"!';		
		
/*if(!checkLen('enquiryType'))
	$err[]='You have not selected an "Enquiry type"!';
	
if(!checkLen('how'))
	$err[]='You have not selected an "How did you find us?"!';	

if(!checkLen('message'))
	$err[]='The message field is too short or empty!';*/

if ((md5($_POST["txtCaptcha"]."echo3") != $_SESSION["security_code"]) && (isset($_SESSION["security_code"])))
	$err[]='The security code was wrong. Please try again!';

/*if((int)$_POST['captcha'] != $_SESSION['expect'])
	$err[]='The captcha code is wrong!';*/


if(count($err))
{
	if($_SERVER['HTTP_REFERER'])
	{
		$_SESSION['errStr'] = implode('<br />',$err);
		$_SESSION['post']=$_POST;
		
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}

	exit;
}

/**************************************************************
Send Email to the Administrator
**************************************************************/
$msg=
'Name:	'.$_POST['fname'].'<br />
Surname:	'.$_POST['last'].'<br />
Phone:	'.$_POST['tel'].'<br />
Email:	'.$_POST['email'].'<br />
Address:	'.$_POST['addr'].'<br />
Suburb:	'.$_POST['suburb'].'<br />
State:	'.$_POST['state'].'<br />
Postcode:	'.$_POST['postcode'].'<br />
Preferred Contact:	'.$_POST['contact'].'<br />
How did you find us?:	'.$_POST['how'].'<br />

Message:<br /><br />

'.nl2br($_POST['message']).'

';


$mail = new PHPMailer();
$mail->IsMail();

$mail->AddReplyTo('admin@collegecapital.com.au', 'College Capital'); //LIVE
$mail->AddAddress($emailAddress); //change the config variable at Go Live
$mail->AddBCC('glynnis@echo3.com.au', 'First Person');
$mail->SetFrom('admin@collegecapital.com.au','College Capital');
$mail->Subject = "College Capital  | Contact Form";

$mail->MsgHTML($msg);

$mail->Send();

/**************************************************************
Send Email to the User
**************************************************************/
$msgUser=
'Hi '.$_POST['fname'].' '.$_POST['last'].',<br /><br />
Thank you for submitting your enquiry.<br />
A College Capital representative will contact you shortly.<br /><br />
Regards,<br />
College Capital ';


$mailUser = new PHPMailer();
$mailUser->IsMail();

$mailUser->AddReplyTo('admin@collegecapital.com.au', 'College Capital'); //LIVE
$mailUser->AddAddress($_POST['email']); //change the config variable at Go Live
$mailUser->SetFrom('admin@collegecapital.com.au','College Capital');
$mailUser->Subject = "College Capital  | Enquiry Form";

$mailUser->MsgHTML($msgUser);

$mailUser->Send();


unset($_SESSION['post']);

$_SESSION['sent']=1;
	
if($_SERVER['HTTP_REFERER'])
	header('Location: '.$_SERVER['HTTP_REFERER']);	
exit;


function checkLen($str,$len=2)
{
	return isset($_POST[$str]) && mb_strlen(strip_tags($_POST[$str]),"utf-8") > $len;
}
function checkEmail($str)
{
	return preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $str);
}

?>