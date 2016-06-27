<?php echo $jQValidator->validator();
$this->set('page','news'); ?>
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
	$('#NewsStartDate').datePicker({startDate:'01/01/1996'});
	$('#NewsArchiveDate').datePicker({startDate:'01/01/1996'});
	$('#NewsTitle').friendurl({id : 'NewsSeoPageName', transliterate: true});
	//$('#NewsUnpublishDate').datePicker();
});
</script>
<div class="news form">	
    <div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Edit Item: <?php echo $this->data['News']['id']; ?></div>
        	</div>
    	</div>
        <?php		
		echo $this->Form->create('News', array('class'=>'editForm')); ?>
     	<div style="position:relative; top: -25px;left:190px;width:350px;padding:0px; height: 0px;">
		<?php
            echo $this->Form->button('Submit', array('type'=>'submit'));
            //echo $this->Form->button('Reset', array('type'=>'reset'));
            $url = array('action'=>'index');
            echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
        ?>	
        </div>	
		<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title', array('class'=>'text'));
		echo $this->Form->input('seo_page_name', array('class'=>'text','readonly'=>'true', 'style' => 'background-color:transparent;border: 0px;'));
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
//		$explodedTeamsID = explode(',',$this->data['News']['teams']);	
//		foreach ($teams_list as $team_list){
//			$checked = '';	
//			$teamOptions[$team_list['Team']['id']] = $team_list['Team']['name'];
//			for($i=0;$i<count($explodedTeamsID);$i++){
//				if($team_list['Team']['id']==(int)$explodedTeamsID[$i]){
//					//echo "TeamID:".(int)$explodedTeamsID[$i]." is Checked\n";
//					$checked = 'checked';
//					break;
//				}				
//			}
//			echo '<div class="multiCheckbox">';
//			echo '<input id="NewsTeams'.$team_list['Team']['id'].'" type="checkbox" value="'.$team_list['Team']['id'].'" name="data[News][teams][]" '.$checked.'>';
//			echo '<label for="NewsTeams'.$team_list['Team']['id'].'">'.$team_list['Team']['name'].'</label>';
//			echo '</div>';
//		}
		//echo $this->Form->input('teams', array('type'=>'select', 'multiple' => 'checkbox', 'escape' => false, 'options' => $teamOptions));
		?>
        </div>
        <div class="input select">
			<label for="NewsBranches">Branches</label>
        <?php
//		$explodedBranchesID = explode(',',$this->data['News']['branches']);	
//		foreach ($branches_list as $branch_list){
//			$checked = '';	
//			$branchOptions[$branch_list['Branch']['id']] = $branch_list['Branch']['title'];
//			for($i=0;$i<count($explodedBranchesID);$i++){
//				if($branch_list['Branch']['id']==(int)$explodedBranchesID[$i]){
//					//echo "TeamID:".(int)$explodedTeamsID[$i]." is Checked\n";
//					$checked = 'checked';
//					break;
//				}				
//			}
//			echo '<div class="multiCheckbox">';
//			echo '<input id="NewsBranches'.$branch_list['Branch']['id'].'" type="checkbox" value="'.$branch_list['Branch']['id'].'" name="data[News][branches][]" '.$checked.'>';
//			echo '<label for="NewsBranches'.$branch_list['Branch']['id'].'">'.$branch_list['Branch']['title'].'</label>';
//			echo '</div>';
//		}
		//echo $this->Form->input('teams', array('type'=>'select', 'multiple' => 'checkbox', 'escape' => false, 'options' => $teamOptions));
		?>
        </div>-->
        <?php
		echo $this->Form->input('startDate', array('class'=>'dateField','id' => 'NewsStartDate', 'readonly' => 'true', 'value' => $this->FormatEpochToDate->formatEpochToDate($this->data['News']['startDate'])));
		echo $this->Form->input('archiveDate', array('class'=>'dateField','id' => 'NewsArchiveDate', 'readonly' => 'true', 'value' => $this->FormatEpochToDate->formatEpochToDate($this->data['News']['archiveDate'])));
		//echo $this->Form->input('unpublishDate', array('class'=>'dateField','id' => 'NewsUnpublishDate', 'readonly' => 'true', 'value' => $this->FormatEpochToDate->formatEpochToDate($this->data['News']['unpublishDate'])));
		echo $this->Form->input('live', array('type' => 'checkbox', 'label'=>'Push content Live?'));
		?>

		<?php 
				echo $this->Form->button('Submit', array('type'=>'submit','style'=>'margin-left: 190px;'));
				//echo $this->Form->button('Reset', array('type'=>'reset'));
				$url = array('action'=>'index');
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>

	</div>
</div>