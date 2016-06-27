<div class="faqs view">
    <h2><?php echo $faq['Faq']['title']; ?></h2>
    <p>&nbsp;</p>
    <p><?php echo $faq['Faq']['description']; ?></p>
</div>
<div id="top-cms-text">
    <?php echo $this->Html->link(__('EDIT FAQ', true), array('action' => 'edit', $faq['Faq']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('DELETE FAQ', true), array('action' => 'delete', $faq['Faq']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $faq['Faq']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('RETURN TO FAQS', true), array('action' => 'index')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('ADD NEW FAQ', true), array('action' => 'add')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('PUBLISH THIS FAQ?', true), array('action' => 'publish', $faq['Faq']['id']), null, sprintf(__('Are you sure you want to publish FAQ # %s?', true), $faq['Faq']['id'])); ?>
</div>