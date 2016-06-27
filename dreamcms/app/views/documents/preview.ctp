<div class="documents view">
	<ul id="documents_list" class="content"> 
    	<a href='<?php echo Configure::read('Company.menuUrl');?>app/webroot/uploads/documents/<?php echo $document['Document']['documentFile'];?>' target='_blank'><?php echo $document['Document']['title'];?></a><br />
		<?php if(strlen($document['Document']['description'])>0){ echo "<p>".$document['Document']['description']."</p>"; } ?>
    </ul>
</div>
<div id="top-cms-text">
    <?php echo $this->Html->link(__('EDIT DOCUMENT', true), array('action' => 'edit', $document['Document']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('DELETE DOCUMENT', true), array('action' => 'delete', $document['Document']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $document['Document']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('RETURN TO DOCUMENTS', true), array('action' => 'index')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('ADD NEW DOCUMENT', true), array('action' => 'add')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('PUBLISH THIS DOCUMENT?', true), array('action' => 'publish', $document['Document']['id']), null, sprintf(__('Are you sure you want to publish DOCUMENT # %s?', true), $document['Document']['id'])); ?>
</div>