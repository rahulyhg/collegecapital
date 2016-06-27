<?php 
	if (!isset($content_for_layout)){ 	
		header('Location: /');
	} else {
		echo $content_for_layout;
	}
?>