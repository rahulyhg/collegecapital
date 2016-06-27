<?php echo $jQValidator->validator(); 
$this->set('page','pages');?>
<?php
if (isset($javascript)) {
	echo $javascript->link('jquery.friendurl.min.js');
	echo $javascript->link('jquery.textareaCounter.plugin.js');	
	echo $javascript->link('jquery.dimensions.js');
	echo $javascript->link('jquery.tooltip.js');
}
?>
<script type="text/javascript">
$(function(){
	$('#WebpageTitle').friendurl({id : 'WebpageSeoPageName', transliterate: true});
	$("#WebpageAddForm *").tooltip();
	var options2 = {
		'maxCharacterSize': 200,
		'originalStyle': 'originalTextareaInfo',
		'warningStyle' : 'warningTextareaInfo',
		'warningNumber': 40,
		'displayFormat' : '#input characters | #left characters left | #words words'
	};
	$('#WebpageMetaDescription').textareaCount(options2);
	$('#copy').click(function(){
		var con = true;
		if($('#WebpageMetaTitle').val()!=''){
			con = confirm('Are you sure you would like to over write current "Meta Title"?');
		}
		if (con){
			$('#WebpageMetaTitle').val($('#WebpageTitle').val());
		}
	});
	var options3 = {
		'maxCharacterSize': 100,
		'originalStyle': 'originalTextareaInfo',
		'warningStyle' : 'warningTextareaInfo',
		'warningNumber': 10,
		'displayFormat' : '#input characters | #left characters left'
	};
	$('#WebpageMetaTitle').textareaCount(options3);
	
	//parent and child pages option
	$('#WebpagePageTypeChild').click(function(){
		$('#showParentDropDown').css('display','block');
		$('#showPageCategory').css('display','none');
	});
	$('#WebpagePageTypeParent').click(function(){
		$('#showParentDropDown').css('display','none');
		$('#showPageCategory').css('display','block');
	});
	$('#WebpageEditForm').submit(function(){
		if($('#WebpagePageTypeChild').is(':checked')){
			if ($('#WepageParentPage').val() <= 0){
				alert('Please select parent page.'+$('#WepageParentPage').val());
				return false;	
			}
		}
	});
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
	var mywin = window.open("<?php echo Configure::read('Company.url');?>dreamcms/app/views/pages/upload.php?id=<?php echo $this->data['Webpage']['id']; ?>&opt="+opt+"&variable="+variable+"&fld="+fld,"uploadwindow","width=400,height=200");
	mywin.focus();
}
</script>
<style>
	.charleft{
		padding: 0px 0px 0px 190px;
		font-style:italic;
		font-size: 0.9em;	
	}
	.form .radio { float: left; }
	.form .radio input { width: 15px; float: left; margin: 5px; }
</style>
<div class="webpages form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Add Page</div>
        	</div>
    	</div>
		<?php 
		echo $this->Form->create('Webpage', array('class'=>'editForm','enctype'=>'multipart/form-data', 'type'=> 'file'));
		echo '<div style="position:relative; top: -25px;left:190px;width:350px;padding:0px;height: 0;">';
		echo $this->Form->button('Submit', array('type'=>'submit'));
		//echo $this->Form->button('Reset', array('type'=>'reset'));
		$url = array('action'=>'index');
		echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
        echo '</div>';
		echo $this->Form->input('title', array('class'=>'text', 'title'=>'Enter the Title for the Page.'));
		echo $this->Form->input('seo_page_name', array('class'=>'text','readonly'=>'true','style'=>'background-color: transparent;border: 0 none;', 'title'=>'This is a readonly field auto-populating with Search Engine friendly URLs.'));
		//parent or child
		echo "<div class='input radio'><label for='WebpagePageType'>Page Type</label>";
		$pageTypeOptions=array('Parent'=>'Parent Page','Child'=>'Child Page');
		$pageTypeAttributes=array('legend'=>false,'class'=>'radio','default'=>'Parent');
		echo $this->Form->radio('pageType',$pageTypeOptions,$pageTypeAttributes);
		echo "</div>";
		echo "<div id='showParentDropDown' style='display: none;'>";
		foreach ($parentPageOptions as $parentPageOption){
			$parentPages[$parentPageOption['Webpage']['id']] = $parentPageOption['PC']['category']." - ".$parentPageOption['Webpage']['title'];
		}
		echo $this->Form->input('parentPage',array('label'=>'Select Parent Page','type'=>'select','options'=>$parentPages));
		echo "</div>";
        foreach ($options as $option){
			$categoryOptions[$option['PagesCategory']['id']] = $option['PagesCategory']['category'];
		}
		echo $this->Form->input('category_id', array('div' => array('id' => 'showPageCategory', 'style' => 'display:block'),'type' => 'select', 'escape' => false, 'options' => $categoryOptions, 'title'=>'Select the Category for this Page.'));
		echo $this->Form->input('metaTitle', array('after'=>'<input id="copy" style="width: 100px;left: 75%;position: relative;top: -46px;" type="button" value="Copy from Title" />', 'class'=>'text', 'title'=>'Enter the Page Title for Search Engines. We recommend it to be 65 characters long for best results.'));
        echo $this->Form->input('metaKeywords', array('type'=>'textarea','rows'=>'3','cols'=>'61','class'=>'text', 'title'=>'Enter Page keywords for Search Engines.'));
		echo $this->Form->input('metaDescription',array('type'=>'textarea','rows'=>'3','cols'=>'61', 'class'=>'nrmlTextArea','title'=>'Enter Page description for Search Engines.'));
		echo $this->Form->input('shortDescription', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass));
		?>
		<script type="text/javascript">
			var ck_webpagesShortDescription = CKEDITOR.replace( 'WebpageShortDescription', { 
															toolbar: 'Basic',
															enterMode : CKEDITOR.ENTER_BR,
															shiftEnterMode: CKEDITOR.ENTER_P,
															height: 150,
															resize_minHeight:150,
															resize_minWidth:800,
															resize_maxWidth:800
															} );
			CKFinder.setupCKEditor( ck_webpagesShortDescription, '<?php echo $ckfinderPath ?>') ;
        </script>
 		<?php
		echo $this->Form->input('body', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass));
		?>
        <script type="text/javascript">
			var ck_webpagesBody = CKEDITOR.replace( 'WebpageBody', { 
												toolbar: 'Full',
												height: 325,
												resize_minHeight:325,
												resize_minWidth:800,
												resize_maxWidth:800
												} );
			CKFinder.setupCKEditor( ck_webpagesBody, '<?php echo $ckfinderPath ?>') ;
        </script>
   		
        <?php
		echo $this->Form->input('leftColContent', array('label'=>'Left Column Content','between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass));
		?>
        <script type="text/javascript">
			var ck_webpageLeftColContent = CKEDITOR.replace( 'WebpageLeftColContent', { 
												toolbar: 'Column',
												enterMode : CKEDITOR.ENTER_BR,
												shiftEnterMode: CKEDITOR.ENTER_P,
												height: 150,
												resize_minHeight:150,
												resize_minWidth:800,
												resize_maxWidth:800
												} );
			CKFinder.setupCKEditor( ck_webpageLeftColContent, '<?php echo $ckfinderPath ?>') ;
        </script>
        <?php
		echo $this->Form->input('position', array('type'=>'hidden', 'value'=>$maxPosition));
		echo $this->Form->input('live', array('type' => 'checkbox', 'label'=>'Push content Live?', 'class'=>'checkbox'));
		?>

      	<?php 
				echo $this->Form->button('Submit', array('type'=>'submit','style'=>'margin-left: 190px;'));
				//echo $this->Form->button('Reset', array('type'=>'reset'));
				$url = array('action'=>'index');
				//$url = $_SERVER['HTTP_REFERER'];
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>

	</div>  
</div>

<script type="text/javascript">
$(function(){
	var isChildChecked = $('#WebpagePageTypeChild').is(':checked');
	var isParentChecked = $('#WebpagePageTypeParent').is(':checked');
	if(isChildChecked){
		$('#showParentDropDown').css('display','block');
		$('#showPageCategory').css('display','none');
	}
	if(isParentChecked){
		$('#showParentDropDown').css('display','none');
		$('#showPageCategory').css('display','block');
	}
});
</script>