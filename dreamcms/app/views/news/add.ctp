<?php echo $jQValidator->validator(); 
$this->set('page','news');?>
<?php
$page = "news";
if (isset($javascript)) {
	echo $javascript->link('jquery.friendurl.min.js');
}
?>
<script language="javascript" type="text/javascript">
$(function()
{
	//setting the date format for the datepicket
	Date.format = 'dd/mm/yyyy';
	var currentDate = new Date();
	var archiveDate = new Date();
	$('#NewsStartDate').datePicker({startDate:'01/01/1996'}).val(new Date().asString()).trigger('change');
	var nextYear = archiveDate.getDate()+365;
	archiveDate.setDate(nextYear);
	$('#NewsArchiveDate').datePicker({startDate:'01/01/1996'}).val(archiveDate.asString()).trigger('change');
	//$('#NewsUnpublishDate').datePicker();
	$('#NewsTitle').friendurl({id : 'NewsSeoPageName', transliterate: true});
});
</script>
<div class="news form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Add News Item</div>
        	</div>
    	</div>
		<?php 
		echo $this->Form->create('News', array('class'=>'editForm'));
		echo '<div style="position:relative; top: -25px;left:190px;width:350px;padding:0px; height: 0;">';
		echo $this->Form->button('Submit', array('type'=>'submit'));
		//echo $this->Form->button('Reset', array('type'=>'reset'));
		$url = array('action'=>'index');
		echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
        echo '</div>';
        echo $this->Form->input('title', array('class'=>'text'));
		echo $this->Form->input('seo_page_name', array('class'=>'text','readonly'=>'true', 'style' => 'background-color:transparent;border: 0px;'));
		//$options = array('1' => 'General', '2' => 'Latest Release');
		//echo $this->Form->input('category_id', array('type' => 'select', 'escape' => false));
		foreach ($options as $option){
			$categoryOptions[$option['NewsCategory']['id']] = $option['NewsCategory']['category'];
		}
		echo $this->Form->input('category_id', array('type' => 'select', 'escape' => false, 'options' => $categoryOptions));
		echo $this->Form->input('shortDescription', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass));
		?>
		<script type="text/javascript">
			var ck_newsShortDescription = CKEDITOR.replace( 'NewsShortDescription', { 
															toolbar: 'Basic',
															height: 150,
															resize_minHeight:150,
															resize_minWidth:800,
															resize_maxWidth:800
															} );
			CKFinder.setupCKEditor( ck_newsShortDescription, '<?php echo $ckfinderPath ?>') ;
        </script>
 		<?php
		echo $this->Form->input('body', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass));
 		?>
    	<script type="text/javascript">
			var ck_newsBody = CKEDITOR.replace( 'NewsBody', { 
												toolbar: 'Full',
												height: 325,
												resize_minHeight:325,
												resize_minWidth:800,
												resize_maxWidth:800
												} );
			CKFinder.setupCKEditor( ck_newsBody, '<?php echo $ckfinderPath ?>') ;
        </script>        
<!--        <div class="input select">
			<label for="NewsTeams">Teams</label>
   		<?php	
//		//echo $this->Form->input('documentFiles', array('type' => 'file', ));
//		//echo $this->Form->input('imageFiles', array('type' => 'file'));
//		foreach ($teams_list as $team_list){			
//			echo '<div class="multiCheckbox">';
//			echo '<input id="NewsTeams'.$team_list['Team']['id'].'" type="checkbox" value="'.$team_list['Team']['id'].'" name="data[News][teams][]" />';
//			echo '<label for="NewsTeams'.$team_list['Team']['id'].'">'.$team_list['Team']['name'].'</label>';
//			echo '</div>';
//		}?>
        </div>
        <div class="input select">
			<label for="NewsBranches">Branches</label>
   		<?php	
		//echo $this->Form->input('documentFiles', array('type' => 'file', ));
		//echo $this->Form->input('imageFiles', array('type' => 'file'));
//		foreach ($branches_list as $branch_list){			
//			echo '<div class="multiCheckbox">';
//			echo '<input id="NewsBranches'.$branch_list['Branch']['id'].'" type="checkbox" value="'.$branch_list['Branch']['id'].'" name="data[News][branches][]" />';
//			echo '<label for="NewsBranches'.$branch_list['Branch']['id'].'">'.$branch_list['Branch']['title'].'</label>';
//			echo '</div>';
//		}?>
        </div>-->
        <?php
		echo $this->Form->input('startDate', array('class'=>'dateField','id' => 'NewsStartDate', 'readonly' => 'true'));
		echo $this->Form->input('archiveDate', array('class'=>'dateField','id' => 'NewsArchiveDate', 'readonly' => 'true'));
		//echo $this->Form->input('unpublishDate', array('class'=>'dateField','id' => 'NewsUnpublishDate', 'readonly' => 'true'));
		echo $this->Form->input('live', array('type' => 'checkbox', 'label'=>'Push content Live?'));
		?>

      	<?php 
				echo $this->Form->button('Submit', array('type'=>'submit','style'=>'margin-left: 190px;'));
				//echo $this->Form->button('Reset', array('type'=>'reset'));
				$url = array('contoller'=>'news','action'=>'index');
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>

	</div>
</div>