<?php echo $jQValidator->validator();
$this->set('page','documents'); ?>
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
	$('#DocumentDocumentDate').datePicker({startDate:'01/01/1996'});
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
	var mywin = window.open("<?php echo Configure::read('Company.url');?>app/webroot/uploads/upload.php?id=<?php echo $this->data['Document']['id']; ?>&opt="+opt+"&variable="+variable+"&fld="+fld,"uploadwindow","width=400,height=200");
	mywin.focus();
}
</script>
<div class="document form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Edit Item: <?php echo $this->data['Document']['id']; ?></div>
        	</div>
    	</div>
        <?php 
		echo $this->Form->create('Document', array('class'=>'editForm', 'enctype'=>'multipart/form-data', 'type'=> 'file'));
		echo '<div style="position:relative; top: -25px;left:190px;width:350px;padding:0px; height: 0;">';
		echo $this->Form->button('Submit', array('type'=>'submit'));
		//echo $this->Form->button('Reset', array('type'=>'reset'));
		$url = array('action'=>'index');
		echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
        echo '</div>';
		echo $this->Form->input('id');
		echo $this->Form->input('title', array('class'=>'text', 'title'=>'Enter the Title for the Document.'));
		foreach ($options as $option){
			$categoryOptions[$option['DocumentsCategory']['id']] = $option['DocumentsCategory']['category'];
		}
		echo $this->Form->input('category_id', array('type' => 'select', 'escape' => false, 'options' => $categoryOptions, 'title'=>'Select the Category for this Document.'));
		echo $this->Form->input('description', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass));
		?>
        <script type="text/javascript">
			var ck_documentDescription = CKEDITOR.replace( 'DocumentDescription', { 
												toolbar: 'Full',
												height: 325,
												resize_minHeight:325,
												resize_minWidth:800,
												resize_maxWidth:800
												} );
			CKFinder.setupCKEditor( ck_documentDescription, '<?php echo $ckfinderPath ?>') ;
        </script>
   		
        <?php
        if(strlen($this->data['Document']['documentFile'])<=0){
		//file uploader utility	
			$jsString1 = "javascript:uploadFile('5', 'DocumentDocumentFile', 'documents');document.getElementById('DocumentDocumentFile_file').src='".Configure::read('Company.url')."app/webroot/uploads/documents/'+document.getElementById('DocumentDocumentFile').value";
			echo '<div class="input file">';
			echo '<label for="DocumentDocumentFile">Document</label>';
			echo '<input readonly="true" name="data[Document][documentFile]" id="DocumentDocumentFile" class="pdf" value="'.$this->data['Document']['documentFile'].'">';
			echo '<input name="uploadDocumentDocumentFile" type="button" class="uploadButton" id="uploadDocumentDocumentFile" onMouseUp="'.$jsString1.'" value="Upload File">';
			$jsString2 = "javascript:document.getElementById('DocumentDocumentFile').value=''; document.getElementById('DocumentDocumentFile_file').src='".Configure::read('Company.url')."app/webroot/uploads/documents/blank.gif'";
			echo '<input name="removeDocumentDocumentFile" type="button" class="uploadButton" id="removeDocumentDocumentFile" onMouseUp="'.$jsString2.'" value="Remove File" />';
			echo '<div style="width:120px; height: 100px;padding:0px 50px 0px 0px;float: right;">';
			echo '<img src="'.Configure::read('Company.url').'app/webroot/uploads/documents/blank.gif"  id="DocumentDocumentFile_file" name="DocumentDocumentFile_file" height="100">';
			echo '</div>';
			echo '</div>';
		//file uploader utility code ends here
		} else { ?>
			<div class="input">
            	<label for="DocumentDocumentFile">Document</label>
            	<a href="<?php echo Configure::read('Company.url');?>app/webroot/uploads/documents/<?php echo $this->data['Document']['documentFile'];?>" target="_blank"><?php echo trim($this->data['Document']['documentFile']);?></a>
				<?php echo $this->Html->link($html->image("delete.gif",array('id'=>'deletefile','alt'=>'delete file', 'border' => 0)), array('action' => 'deletefile', $this->data['Document']['id']), array('escape' => false,'id'=>'record','title'=>'delete file'), sprintf(__('Are you sure you want to delete this file?', true)));?><br clear='all'><span style='margin: 0px 0px 0px 187px;'></span>
             </div>
        <?php	
		}
		echo $this->Form->input('documentDate', array('class'=>'dateField','id' => 'DocumentDocumentDate','readonly' => 'true', 'value' => $this->FormatEpochToDate->formatEpochToDate($this->data['Document']['documentDate'])));
		echo $this->Form->input('live', array('type' => 'checkbox', 'label'=>'Push content Live?', 'class'=>'checkbox'));
		?>
        <div id="record_wrap">
            <div class="record_row_desc" id="record_row">
                <div id="record_detail">&nbsp;</div>
            </div>
            <div class="record_row_data" id="record_row">
                <div id="record_data">
      	<?php 
				echo $this->Form->button('Submit', array('type'=>'submit'));
				//echo $this->Form->button('Reset', array('type'=>'reset'));
				//$url = array('action'=>'index');
				$url = $_SERVER['HTTP_REFERER'];
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>
        		</div>
            </div>
        </div>
	</div>  
</div>