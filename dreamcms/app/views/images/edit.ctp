<?php echo $jQValidator->validator(); ?>
<div class="images form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Add Item</div>
        	</div>
    	</div>
		<?php 
			if(strlen($this->data['Image']['location'])<=0){
				echo $this->Form->create('Image',array('type' => 'file', 'class' => 'editForm'));
			} else {
				echo $this->Form->create('Image',array('class' => 'editForm'));	
			}
			echo $this->Form->input('id');
			echo $this->Form->input('name');
			/*echo $this->Form->input('location');*/
			if(strlen($this->data['Image']['location'])<=0){
				echo $form->input('location', array('type' => 'file','label'=>'Image'));
			} else {
		?>		
				<div class="input file required">
            	<label for="ImageLocation">Image</label>
            	<img src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/thumbnails/<?php echo $this->data['Image']['location'];?>" />
				<?php echo $this->Html->link($html->image("delete.gif",array('id'=>'deletefile','alt'=>'delete file','border' => 0)), array('action' => 'deletefile', $this->data['Image']['id'].'/location'), array('escape' => false,'id'=>'record','title'=>'delete file'), sprintf(__('Are you sure you want to delete the image?', true)));?>
                <input type="hidden" id="ImageLocation" name="data[Image][location]" value="<?php echo $this->data['Image']['location'];?>">
             </div>	
		<?php
			}
			/*echo $form->input('Image.location.remove',  array('type' => 'checkbox', 'label' => 'Delete Image'));*/
			echo $this->Form->input('categorie_id', array('label'=>'Category'));
			echo $this->Form->input('upload',array('type'=>'hidden','value'=>date("Y-m-d G:i:s")));
			echo $this->Form->input('description',array('type'=>'textarea','rows'=>'10','cols'=>'44'));
			//echo $this->Form->input('Tag');	
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
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$_SERVER['HTTP_REFERER']."'"));
		?>
        		</div>
            </div>
        </div>
	</div>
</div>