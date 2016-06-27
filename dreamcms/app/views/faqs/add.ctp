<?php echo $jQValidator->validator(); ?>
<?php
if (isset($javascript)) {
	echo $javascript->link('jquery.friendurl.min.js');
}
?>
<script type="text/javascript">
$(function(){
	$('#FaqTitle').friendurl({id : 'FaqSeoPageName', transliterate: true});
});
</script>
<div class="news form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Add Faq</div>
        	</div>
    	</div>
		<?php 
		echo $this->Form->create('Faq', array('class'=>'editForm'));
		echo '<div style="position:relative; top: -13px;left:160px;width:300px;margin:-11px;padding:0px">';
		echo $this->Form->button('Submit', array('type'=>'submit'));
		//echo $this->Form->button('Reset', array('type'=>'reset'));
		$url = array('action'=>'index');
		echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
        echo '</div>';
		echo $this->Form->input('title', array('class'=>'text'));
		echo $this->Form->input('seo_page_name', array('class'=>'text','readonly'=>'true','type'=>'hidden'));		
		foreach ($options as $option){
			$categoryOptions[$option['FaqsCategory']['id']] = $option['FaqsCategory']['category'];
		}
		echo $this->Form->input('category_id', array('type' => 'select', 'escape' => false, 'options' => $categoryOptions));
		echo $this->Form->input('description', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass));
 		?>
    	<script type="text/javascript">
			var ck_faqsDesc = CKEDITOR.replace( 'FaqDescription', { 
												toolbar: 'Full',
												height: 325,
												resize_minHeight:325,
												resize_minWidth:800,
												resize_maxWidth:800
												} );
			CKFinder.setupCKEditor( ck_faqsDesc, '<?php echo $ckfinderPath ?>') ;
        </script>
   		<?php	
		echo $this->Form->input('position', array('type'=>'hidden', 'value'=>$maxPosition));
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
				$url = array('contoller'=>'faqs','action'=>'index');
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>
        		</div>
            </div>
        </div>
	</div>  
</div>