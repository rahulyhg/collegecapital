<?php
class FormatEpochToDateHelper extends FormHelper { 
	var $helpers = array('Html','Javascript');
	
	function formatEpochToDate($dt){
		return date("d/m/Y", $dt);
	}
}
?>