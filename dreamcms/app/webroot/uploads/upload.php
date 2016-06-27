<?php
	if ($_SERVER["SERVER_NAME"]=="echo00"){
		$site_path	 = "http://echo00/ccap.collegecapital/";
	} 
        else if (strpos($_SERVER['SERVER_NAME'], 'localhost') !== false){
            $site_path	 = "http://localhost/dreamcms/";
        }
        else {
		$site_path	 = "http://ccap.collegecapital.com.au/";
	}
	// resize an image
	function resize_image($file_org, $file_new, $max_width, $max_height, $quality = 100, $size_down= true, $size_up = false, $aspect_ratio = true) {
		// The file
		list($width, $height) = getimagesize($file_org);

		if($aspect_ratio) 
			$ratio = $height/$width;

		// only resize image if required
		if(($size_down && ($width > $max_width || $height > $max_height)) || ($size_up && ($width < $max_width || $height < $max_height))) {
			// set new size based on WIDTH
			$new_width = $max_width;
			if($aspect_ratio) {
				$new_height = ceil($new_width * $ratio);
			} else {
				$new_height = $max_height;
			}
			
			// when resizing both parameters must fit within the boundaries.
			while($new_height > $max_height) {
				$new_width -= 1;
				$new_height = ceil($new_width * $ratio);
			}
			
			// resize image and replace original file
			$resampled_image = imagecreatetruecolor($new_width, $new_height);
			$existing_image  = imagecreatefromjpeg($file_org);
			imagecopyresampled($resampled_image, $existing_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		
			// Output
			ImageJPEG($resampled_image, ((is_null($file_new)) ? $file_org : $file_new), $quality);
		
			// Clean up
			imagedestroy($resampled_image);
		}
	}
?>
<html>
<head>
<title>File Upload</title>
<style type="text/css">
<!--
.style1 {
	font-size: 9px;
	font-family: Arial, Helvetica, sans-serif;
}
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 10px;
}
.style5 {
	font-size: 10px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #82960E;
	font-weight: bold;
}
.style6 {
	color: #82960E;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style7 {color: #FFFFFF}
.style8 {font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif; }

.text8 {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 0.7em;	
}
-->
</style>
<script language="javascript" type="text/javascript">
	function submitForm(f) {
		document.getElementById('img'+f).src = "<?php echo $site_path;?>app/webroot/img/loading.gif";
		document.getElementById('form'+f).submit();
	}
</script>
</head>
<body>
<?php

$id       = $_REQUEST["id"];                 // single id
$aid      = NULL;//explode("_" ,$_REQUEST["aid"]);  // array of id's
@$status   = $_REQUEST["status"];
$opt      = $_REQUEST["opt"];
$variable = $_REQUEST["variable"];
$fld      = $_REQUEST["fld"];                // folder to upload to
$mf       = NULL;//$_REQUEST["mf"];               // maximum files allowed

//var_dump($_REQUEST);

if (!isset($status)) {
	switch($opt) {
		case 0:
		case 1:
		case 2:
	 		$upload_header = "Image Upload";
			$upload_header_sub = "Image";
			$upload_format = "images must be jpg format";
			$upload_message = "image size must be less than 2Mb (maximum)";
			break;
		/*case 1:
	 		$upload_header = "Image Upload";
			$upload_header_sub = "Image";
			$upload_format = "images must be jpg or gif format";
			$upload_message = "image size must be 400 x 100 (100 Kb maximum)";
			break;
		case 2:
	 		$upload_header = "Image Upload";
			$upload_header_sub = "Image";
			$upload_format = "images must be jpg or gif format";
			$upload_message = "image size must be 805 x 150 (100 Kb maximum)";
			break;*/
		case 3:
	 		$upload_header = "Audio Upload";
			$upload_header_sub = "Audio";
			$upload_format = "audio must be mp3 format";
			$upload_message = "(5 Mb maximum)";
			break;
		case 4:
	 		$upload_header = "Media Upload";
			$upload_header_sub = "Media";
			$upload_format = "media must be mpg or mpeg format";
			$upload_message = "(5 Mb maximum)";
			break;
		case 5:
	 		$upload_header = "Document Upload";
			$upload_header_sub = "Document";
			$upload_format = "files must be PDF format";
			$upload_message = "(2 Mb maximum)";
			break;
	} ?>

  <p class="style1 style2"><?php echo $upload_header;?></p>

<?php	if(!isset($id)) {
		for($i=0; $i<count($aid); $i++) { ?>
	<form name="form<?php echo $i;?>" id="form<?php echo $i;?>" enctype="multipart/form-data" method="post" action="upload.php?id=<?php echo $i;?>&opt=<?php echo $opt;?>&variable=<?php echo $variable;?><?php echo $aid[$i];?>&fld=<?php echo $fld;?>" style="padding:2px;margin:2px;" target="upload_target<?php echo $i;?>">
		<table width="350px" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="75px" class="style1">File <?php echo $aid[$i];?> (<?php echo $mf;?>):</td>
				<td><input name="uploadedfile" id="uploadedfile" type="file" class="style1" size="40" onChange="submitForm(<?php echo $i;?>)"></td>
				<td width="40px"><img src="<?php echo $site_path;?>app/webroot/img/blank.gif" id="img<?php echo $i;?>" name="img<?php echo $i;?>" height="24px"></td>
			</tr>
		</table>
		<input type="hidden" name="status" id="status" value="m">
	</form>
	<iframe id="upload_target<?php echo $i;?>" name="upload_target<?php echo $i;?>" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
<?php		}
	} else { ?>
	<form name="form0" id="form0" method="post" enctype='multipart/form-data' action="upload.php?id=0&opt=<?php echo $opt;?>&variable=<?php echo $variable;?>&fld=<?php echo $fld;?>" target="upload_target0">
		<table width="350" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="75" class="style8"><?php echo $upload_header_sub;?>:</td>
				<td><input name="uploadedfile" id="uploadedfile" type="file" class="style1" size="40" onChange="submitForm(0)"></td>
				<td width="40px"><img src="<?php echo $site_path;?>app/webroot/img/blank.gif" id="img0" name="img0" height="24px"></td>
			</tr>
		</table>
		<input type="hidden" name="status" id="status" value="s">
		<iframe id="upload_target0" name="upload_target0" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
	</form>
<?php	} ?>
	<p><span class="style5">* <?php echo $upload_format;?><br /><span class="style5">* </span><?php echo $upload_message;?></span></p>
	<p><a href="javascript:window.close();" class="text8">Close window</a><p>
<?php
} else {

	$dir="../../webroot/uploads/".$fld."/";
/*	switch($opt) {
		case 5:
			$dir="../../images/".$fld."/";
			break;
	}
*/	
	$uploadfile = $dir.basename($_FILES['uploadedfile']['name']);
	$uploadedfile_type = $_FILES['uploadedfile']['type'];
	echo "<p class='style1'>".$uploadfile."<br />".$uploadedfile_type."</p>";
	
	if($uploadedfile_type!="none") {
		$pass = true;
		switch($opt) {
			case 0:
				//echo $uploadedfile_type;
				if ($uploadedfile_type!="image/pjpeg"&&$uploadedfile_type!="image/jpeg") {
					$message = "The image that you are trying to upload is not a valid jpg file.";
					$pass = false;
				}
				break;
			case 1:
			case 2:
				//echo $uploadedfile_type;
				if ($uploadedfile_type!="image/gif"&&$uploadedfile_type!="image/pjpeg"&&$uploadedfile_type!="image/x-png"&&$uploadedfile_type!="image/jpeg") {
					$message = "The image that you are trying to upload is not a valid jpg, gif or png file.";
					$pass = false;
				}
				break;
			case 3:
				//echo $uploadedfile_type;
				if ($uploadedfile_type!="application/octet-stream"&&$uploadedfile_type!="audio/mp3"&&$uploadedfile_type!="audio/mpeg3"&&$uploadedfile_type!="audio/x-mp3") {
					$message = "The audio that you are trying to upload is not a valid mp3 format.";
					$pass = false;
				}
				break;
			case 4:
				//echo $uploadedfile_type;
				if ($uploadedfile_type!="video/mpeg"&&$uploadedfile_type!="video/avi"&&$uploadedfile_type!="audio/mpeg"&&$uploadedfile_type!="video/mp4"&&$uploadedfile_type!="audio/mp4"&&$uploadedfile_type!="video/x-mpeg") {
					$message = "The media that you are trying to upload is not a valid mpg or mpeg format.";
					$pass = false;
				}
				break;
			case 5:
				//echo $uploadedfile_type;
				break;
		}
		
		if($pass) {
			//collect the name from POST VARS
			
			//$MyImageName="{$HTTP_POST_VARS['name']}";
			$MyImageName = $_FILES['uploadedfile']['name'];
			//get type of file
			$MyImageType=$uploadedfile_type;
						
			//get length of image type
			$MyImageLength=strlen($MyImageType);
			//get part of file image to build image extension
			$pos=strpos($MyImageType,"/")+1;
			//build extension of image
			$MyImageExtension=substr($MyImageType,$pos,$MyImageLength);
			 
			//correct errors with some file formats
			//jpg
			if($MyImageExtension=="pjpeg"||$MyImageExtension=="jpeg") {
				$MyImageExtension="jpg";
			}
			//png
			if($MyImageExtension=="x-png") {
				$MyImageExtension="png";
			}
			//added in version 0.2
			//if the name is empty copy name of image from your HDD
			//that correct error if you do not enter new name of image
			if (!$MyImageName) {
				$MyImageName=$uploadedfile_name;
			} else { //build new name of name that you specified, . and extension of image
			   // $MyImageName.=".".$MyImageExtension;
			}
			//Upload image to the correct dir
			if(!move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $uploadfile)) { ?>
			<script language="javascript1.2" type="text/javascript">
				window.parent.document.getElementById("img<?php echo $id;?>").src = "<?php echo Confgiure::read('Company.url');?>/img/cross.gif";
				alert("File Upload Error!");
			</script>
<?php			} else { //or finish (and resize if required)
				$file_name_OLD = "../../webroot/uploads/".$fld."/".$MyImageName;
				$file_name_NEW = "../../webroot/uploads/".$fld."/".$MyImageName;
				if(file_exists($file_name_OLD)) {
					resize_image($file_name_OLD, $file_name_NEW, 1000, 800);  // actual image resize
					$file_name_NEW = "../../webroot/uploads/".$fld."/".$MyImageName;
					//resize_image($file_name_OLD, $file_name_NEW, 170, 170);   // thumbnail resize
				}
?>
			<script type="text/javascript" language="javascript">
				if(window.parent.opener.document.getElementById('<?php echo $variable;?>_img')) window.parent.opener.document.getElementById('<?php echo $variable;?>_img').src = '<?php echo $site_path;?>app/webroot/uploads/<?php echo $fld;?>/<?php echo $MyImageName;?>';
				window.parent.opener.document.getElementById('<?php echo $variable;?>').value = '<?php echo $MyImageName;?>';
				if(window.parent.opener.document.getElementById('<?php echo $variable;?>_display')) window.parent.opener.document.getElementById('<?php echo $variable;?>_display').style.display = '';
				window.parent.document.getElementById("img<?php echo $id;?>").src = "<?php echo $site_path;?>app/webroot/img/tick.gif";
<?php				if($status=="s") { ?>
				window.parent.close();
<?php				} ?>
			</script>
<?php			}  
		} else { ?>
			<script type="text/javascript" language="javascript">
				window.parent.document.getElementById("img<?php echo $id;?>").src = "<?php echo $site_path;?>app/webroot/img/cross.gif";
				alert("<?php echo $message;?>");
			</script>
<?php		}
	} else { ?>
			<script type="text/javascript" language="javascript">
				window.parent.document.getElementById("img<?php echo $id;?>").src = "<?php echo $site_path;?>app/webroot/img/cross.gif";
				alert("File Upload Error!");
			</script>
<?php	}
} ?>
</body>
</html>