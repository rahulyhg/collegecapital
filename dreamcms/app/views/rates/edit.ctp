<?php echo $jQValidator->validator();
$this->set('page','rates'); ?>
<?php
if (isset($javascript)) {
	echo $javascript->link('jquery.tooltip.js');
}
?>
<script type="text/javascript">
$(function(){
	$("#DocumentAddForm *").tooltip();
	
	//setting the date format for the datepicket
	Date.format = 'dd/mm/yyyy';
	var currentDate = new Date();
	$('#RateDocumentDate').datePicker({startDate:'01/01/1996'});
});
function uploadFile(opt, variable, fld){
	// opt    :: option
	// fld    :: folder
	// values :: 
	//           0 = image (general)
	//           1 = image
	//           2 = image
	//           3 = audio file
	//           4 = media file
	var mywin = window.open("<?php echo Configure::read('Company.url');?>app/webroot/uploads/upload.php?id=<?php echo $this->data['Rate']['id']; ?>&opt="+opt+"&variable="+variable+"&fld="+fld,"uploadwindow","width=400,height=200");
	mywin.focus();
}
function updateCategory() {
	$('#RateCategory').val($('#RateCategoryId option:selected').text());
	//alert($('#RateCategory').text());
}
function updateUserName() {
	$('#RateUserName').val($('#RateCmsUserId option:selected').text());
	//alert($('#RateUserName').text());
}
</script>
<div class="rate form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Edit Item: <?php echo $this->data['Rate']['id']; ?></div>
        	</div>
    	</div>
        <?php 
		echo $this->Form->create('Rate', array('class'=>'editForm', 'enctype'=>'multipart/form-data', 'type'=> 'file'));
		echo '<div style="position:relative; top: -25px;left:190px;width:350px;padding:0px; height: 0;">';
		echo $this->Form->button('Submit', array('type'=>'submit'));
		//echo $this->Form->button('Reset', array('type'=>'reset'));
		$url = array('action'=>'index');
		echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
        echo '</div>';
		echo $this->Form->input('id');
		echo $this->Form->input('title', array('class'=>'text', 'title'=>'Enter the Title for the Rate.'));
		$category = "";
		foreach ($options as $option){
			$categoryOptions[$option['RatesCategory']['id']] = $option['RatesCategory']['category'];
			$category = ($option['RatesCategory']['id']==$this->data['Rate']['category_id']) ? $option['RatesCategory']['category'] : $category;
		}
		echo $this->Form->input('category_id', array('type' => 'select', 'escape' => false, 'options' => $categoryOptions, 'title'=>'Select the Category for this Rate.', 'onchange' => 'updateCategory()'));
		echo $this->Form->input('category', array('type' => 'hidden', 'value'=>$category));		
		$user_name = "";
		if($_SESSION['Auth']['User']['group_id']==1){
			foreach ($banks as $bank){
				$bankOptions[$bank['Users']['id']] = $bank['Users']['name'];
				$user_name = ($bank['Users']['id']==$this->data['Rate']['cms_user_id']) ? $bank['Users']['name'] : $user_name;
			}
			echo $this->Form->input('cms_user_id', array('label' => 'On behalf of', 'type' => 'select', 'escape' => false, 'options' => $bankOptions, 'onchange' => 'updateUserName()'));
			
		} else {
			echo $this->Form->input('cms_user_id', array('type' => 'hidden', 'value' => (int)$_SESSION['Auth']['User']['id']));
		}
		echo $this->Form->input('user_name', array('type' => 'hidden', 'value'=>$user_name));		
		
		echo $this->Form->input('description', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass));
		?>
        <script type="text/javascript">
			var ck_rateDescription = CKEDITOR.replace( 'RateDescription', { 
												toolbar: 'Full',
												height: 325,
												resize_minHeight:325,
												resize_minWidth:800,
												resize_maxWidth:800
												} );
			CKFinder.setupCKEditor( ck_rateDescription, '<?php echo $ckfinderPath ?>') ;
        </script>
   		
        <?php
        if(strlen($this->data['Rate']['documentFile'])<=0){
		//file uploader utility	
			$jsString1 = "javascript:uploadFile('5', 'RateDocumentFile', 'rates');rate.getElementById('RateDocumentFile_file').src='".Configure::read('Company.url')."app/webroot/uploads/rates/'+rate.getElementById('RateDocumentFile').value";
			echo '<div class="input file">';
			echo '<label for="RateDocumentFile">Interest Rate Document</label>';
			echo '<input readonly="true" name="data[Rate][documentFile]" id="RateDocumentFile" class="pdf" value="'.$this->data['Rate']['documentFile'].'">';
			echo '<input name="uploadRateDocumentFile" type="button" class="uploadButton" id="uploadRateDocumentFile" onMouseUp="'.$jsString1.'" value="Upload File">';
			$jsString2 = "javascript:rate.getElementById('RateDocumentFile').value=''; rate.getElementById('RateDocumentFile_file').src='".Configure::read('Company.url')."app/webroot/uploads/rates/blank.gif'";
			echo '<input name="removeRateDocumentFile" type="button" class="uploadButton" id="removeRateDocumentFile" onMouseUp="'.$jsString2.'" value="Remove File" />';
			echo '<div style="width:120px; height: 100px;padding:0px 50px 0px 0px;float: right;">';
			echo '<img src="'.Configure::read('Company.url').'app/webroot/uploads/rates/blank.gif"  id="RateDocumentFile_file" name="RateDocumentFile_file" height="100">';
			echo '</div>';
			echo '</div>';
		//file uploader utility code ends here
		} else { ?>
			<div class="input">
            	<label for="RateDocumentFile">Rate</label>
            	<a href="<?php echo Configure::read('Company.url');?>app/webroot/uploads/rates/<?php echo $this->data['Rate']['documentFile'];?>" target="_blank"><?php echo trim($this->data['Rate']['documentFile']);?></a>
				<?php echo $this->Html->link($html->image("delete.gif",array('id'=>'deletefile','alt'=>'delete file', 'border' => 0)), array('action' => 'deletefile', $this->data['Rate']['id']), array('escape' => false,'id'=>'record','title'=>'delete file'), sprintf(__('Are you sure you want to delete this file?', true)));?><br clear='all'><span style='margin: 0px 0px 0px 187px;'></span>
             </div>
        <?php	
		}
		echo $this->Form->input('documentDate', array('class'=>'dateField','id' => 'RateDocumentDate','readonly' => 'true', 'value' => $this->FormatEpochToDate->formatEpochToDate($this->data['Rate']['documentDate'])));
		echo $this->Form->input('notify', array('type' => 'checkbox', 'label'=>'Notify all brokers of update?', 'class'=>'checkbox', 'value'=>1));
		echo $this->Form->input('live', array('type' => 'checkbox', 'label'=>'Push content Live?', 'class'=>'checkbox'));
		?>

      	<?php 
				echo $this->Form->button('Submit', array('type'=>'submit','style'=>'margin-left: 190px;'));
				//echo $this->Form->button('Reset', array('type'=>'reset'));
				//$url = array('action'=>'index');
				$url = $_SERVER['HTTP_REFERER'];
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>

	</div>  
</div>