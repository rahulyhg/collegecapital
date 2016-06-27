<?php echo $jQValidator->validator(); 
$this->set('page','links');
?>
<script type="text/javascript" language="javascript">
function uploadFile(opt, variable, fld){
	// opt    :: option
	// fld    :: folder
	// values :: 
	//           0 = image (general)
	//           1 = image
	//           2 = image
	//           3 = audio file
	//           4 = media file
	var mywin = window.open("<?php echo Configure::read('Company.url');?>app/webroot/uploads/upload.php?id=<?php echo $this->data['Link']['id']; ?>&opt="+opt+"&variable="+variable+"&fld="+fld,"uploadwindow","width=400,height=200");
	mywin.focus();
}
</script>
<div class="links form">
<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Edit Item: <?php echo $this->data['Link']['id']; ?></div>
        	</div>
    	</div>
		<?php 
		echo $this->Form->create('Link', array('class'=>'editForm'));
		?>
        <div style="position:relative; top: -25px;left:190px;width:350px;padding:0px; height: 0;">
		<?php
            echo $this->Form->button('Submit', array('type'=>'submit'));
            $url = array('action'=>'index');
            echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
        ?>	
        </div>	
        <?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		foreach ($options as $option){
			$categoryOptions[$option['LinksCategory']['id']] = $option['LinksCategory']['category'];
		}
		echo $this->Form->input('category_id', array('type' => 'select', 'escape' => false, 'options' => $categoryOptions));
		echo $this->Form->input('url', array('after' => 'e.g. www.google.com'));
		echo $this->Form->input('description', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass));
		?>
		<script type="text/javascript">
			var ck_linksDescription = CKEDITOR.replace( 'LinkDescription', { 
															toolbar: 'Basic',
															height: 150,
															resize_minHeight:150,
															resize_minWidth:800,
															resize_maxWidth:800
															} );
			CKFinder.setupCKEditor( ck_linksDescription, '<?php echo $ckfinderPath ?>') ;
        </script>
   		<?php
        if(strlen($this->data['Link']['logo'])<=0){
			 //echo $this->Form->input('logo', array('type'=>'file', 'label'=>'Member Photo'));
			 $jsString1 = "javascript:uploadFile('1', 'LinkLogo', 'links');document.getElementById('LinkLogo_img').src='".Configure::read('Company.url')."app/webroot/uploads/links/'+document.getElementById('LinkLogo').value";
			 echo '<div class="input file">';
			 echo '<label for="LinkLogo">Logo</label>';
			 echo '<input readonly="true" name="data[Link][logo]" id="LinkLogo" class="pdf" value="'.$this->data['Link']['logo'].'">';
			 echo '<input name="uploadLinkLogo" type="button" class="uploadButton" id="uploadLinkLogo" onMouseUp="'.$jsString1.'" value="Upload File">';
			 $jsString2 = "javascript:document.getElementById('LinkLogo').value=''; document.getElementById('LinkLogo_img').src='".Configure::read('Company.url')."app/webroot/uploads/links/blank.gif'";
			 echo '<input name="removeLinkLogo" type="button" class="uploadButton" id="removeLinkLogo" onMouseUp="'.$jsString2.'" value="Remove File" />';
			 echo '<div style="width:120px; height: 100px;padding:0px 50px 0px 0px;float: right;">';
			 echo '<img src=""  id="LinkLogo_img" name="LinkLogo_img" height="100">';
			 echo '</div>';
			 echo '</div>';
		} else { ?>
			<div class="input">
            	<label for="LinkLogo">Logo</label>
            	<img src="<?php echo Configure::read('Company.url');?>app/webroot/uploads/links/<?php echo $this->data['Link']['logo'];?>" height="100"/>
                <!--<a href="<?php echo Configure::read('Company.url');?>index.php/links/deletefile/<?php //echo $this->data['Link']['id'];?>/<?php //echo $this->data['Link']['logo'];?>" >Delete File</a>-->
				<?php echo $this->Html->link($html->image("delete.gif",array('id'=>'deletefile','alt'=>'delete file', 'border' => 0)), array('action' => 'deletefile', $this->data['Link']['id']), array('escape' => false,'id'=>'record','title'=>'delete file'), sprintf(__('Are you sure you want to delete this file?', true)));?>
             </div>
		<?php
        }
		
		echo $this->Form->input('live', array('type' => 'checkbox', 'label'=>'Push content Live?', 'class'=>'checkbox'));
		echo $this->Form->input('position',array('type'=>'hidden'));
		?>

		<?php 
				echo $this->Form->button('Submit', array('type'=>'submit','style'=>'margin-left: 190px;'));
				//echo $this->Form->button('Reset', array('type'=>'reset'));
				$url = array('contoller'=>'links','action'=>'index');
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>

	</div>
</div>