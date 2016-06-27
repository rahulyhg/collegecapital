<?php
$this->set('page','documents');
echo $this->Html->css('paginateStyles.css');
if (isset($javascript)) {
	echo $javascript->link('jquery.paginate.min.js');
}
?>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		$('#paging_container').pajinate({
			num_page_links_to_display : 4,
			items_per_page : <?php echo $pageLimit;?>	
		});
	});
</script>
<div class="documents view">
	<?php if($options){ ?>
	<div style="clear: both;display: block;height:30px; width: 150px;  padding: 0px 100px 10px 0px;">
		<?php
            $jsString = "javascript:location.href='?group='+this.value;";
            $groupOptions[0] = 'Select Category';
            foreach ($options as $option){
                $groupOptions[$option['DocumentsCategory']['id']] = $option['DocumentsCategory']['category'];
            }
            if (!isset($_GET['group'])) {
                echo $this->Form->input('select_document_category', array('label'=> '','type' => 'select','options' => $groupOptions,'onchange'=> $jsString));
            } else {
                $groupValue = $_GET['group'];
                echo $this->Form->input('select_document_category', array('label'=> '','type' => 'select','options' => $groupOptions,'onchange'=> $jsString,'default' => $groupValue));
            }
        ?>
    </div><hr>
    <?php } ?>
    <?php
if($documents){
?>
	<div id="paging_container" class="container">
        <div id="documents_list" class="content">       
		<?php
            foreach($documents as $document_items):
        ?>
            
            	<h4><a href='<?php echo Configure::read('Company.menuUrl');?>app/webroot/uploads/documents/<?php echo $document_items['Document']['documentFile'];?>' target='_blank'><?php echo $document_items['Document']['title'];?></a></h4>
                <?php if(strlen($document_items['Document']['description'])>0){ echo $document_items['Document']['description']; } ?><hr style="margin-top: 10px;">
           
        <?php
            endforeach;
        ?>
        </div>
        <br clear="all" />
        <div class="info_text"></div>
        <div class="page_navigation"></div>
	</div>
</div>
<?php
} else {
	echo "<p>Select select a category.</p>";
}
?>