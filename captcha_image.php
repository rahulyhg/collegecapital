<?php
/*
	This is PHP file that generates CAPTCHA image for the How to Create CAPTCHA Protection using PHP and AJAX Tutorial

	You may use this code in your own projects as long as this 
	copyright is left in place.  All code is provided AS-IS.
	This code is distributed in the hope that it will be useful,
 	but WITHOUT ANY WARRANTY; without even the implied warranty of
 	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
	
	For the rest of the code visit http://www.WebCheatSheet.com
	
	Copyright 2006 WebCheatSheet.com	

*/

//Start the session so we can store what the security code actually is
session_start();

//Send a generated image to the browser 
create_image(); 
exit(); 

function create_image() 
{ 
    //Let's generate a totally random string using md5 
//    $md5_hash = md5(rand(0,999)); 
    //We don't need a 32 character long string so we trim it down to 5 
//    $security_code = str_replace("0","8",substr($md5_hash, 15, 5)); 
	$security_code = (string) rand(12321,98789); 

    //Set the session to store the security code
    $_SESSION["security_code"] = md5($security_code."echo3");

    //Set the image width and height 
    $width = 100; 
    $height = 30;  

    //Create the image resource 
    $image = ImageCreate($width, $height);  

    //We are making three image colors 005085
    $text_color       = ImageColorAllocate($image,  11,  13,  11); 
    $background_color = ImageColorAllocate($image, 244,  242,  232); 
    $obscure_color    = ImageColorAllocate($image,  204,  204,  204); 

    //Make the background black 
    ImageFill($image, 0, 0, $background_color); 

    //Add randomly generated string in white to the image
	for($i=0;$i<strlen($security_code);$i++) {
		//$font = rand(4,5);
		$x = 30+($i*7);
		$y = rand(3,10);
		//ImageString($image, $font, $x-1, $y-1, substr($security_code,$i,1), $obscure_color); 
		//ImageString($image, $font, $x, $y, substr($security_code,$i,1), $text_color); 
		ImageString($image, 5, $x, $y, substr($security_code,$i,1), $text_color); 
	}
	
    //Throw in some lines to make it a little bit harder for any bots to break 
    ImageRectangle($image,0,0,$width-1,$height-1,$obscure_color); 

 	//Add in speckled background to obscure image
	$specks = (integer) ($width*$height)/20; 
	for($s=0;$s<$specks;$s++) {
		$posX = rand(1,$width-1);
		$posY = rand(1,$height-1);
		imageline($image, $posX, $posY, $posX, $posY, $obscure_color); 
	}

    //Tell the browser what kind of file is come in 
    header("Content-Type: image/jpeg"); 

    //Output the newly created image in jpeg format 
    ImageJpeg($image); 
    
    //Free up resources
    ImageDestroy($image); 
} 
?>