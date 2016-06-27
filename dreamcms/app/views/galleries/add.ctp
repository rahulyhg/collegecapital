<?php
	if($javascript){
		echo $javascript->link('jquery-1.6.2.min');
		echo $javascript->link('jquery-ui-1.8.14.custom.min');
		echo $javascript->link('jquery.fileUploader');
	}
	echo $html->css('ui-lightness/jquery-ui-1.8.14.custom', null, array(), false);
	echo $html->css('fileUploader', null, array(), false);
?>

<div class="galleries form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Add Gallery Item</div>
        	</div>
    	</div>
		<?php
		echo $this->Form->create('Gallery', array('type' => 'file','class'=>'editForm'));
		echo $this->Form->input('file', array(
			'type' => 'file', 
			'label' => false, 'div' => false,
			'class' => 'fileUpload', 
			'multiple' => 'multiple'
		));
		echo $this->Form->button('Upload', array('type' => 'submit', 'id' => 'px-submit'));
		echo $this->Form->button('Clear', array('type' => 'reset', 'id' => 'px-clear'));
		?>
        <div id="record_wrap">
            <div class="record_row_desc" id="record_row">
                <div id="record_detail">&nbsp;</div>
            </div>
            <div class="record_row_data" id="record_row">
                <div id="record_data">
      	<?php 
				
				//echo $this->Form->button('Submit', array('type'=>'submit'));
				//echo $this->Form->button('Reset', array('type'=>'reset'));
				$url = array('contoller'=>'galleries','action'=>'index');
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>
        		</div>
            </div>
        </div>
	</div>  
</div>
<script>
	$(function(){
		$('.fileUpload').fileUploader();
	});
</script>