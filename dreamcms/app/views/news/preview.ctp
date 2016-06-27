<div class="news view">
    <h2><?php echo $news['News']['title']; ?></h2>
    <em><?php echo $this->FormatEpochToDate->formatEpochToDate($news['News']['startDate']); ?></em>
    <p><?php echo $news['News']['body']; ?></p>
    <p><a href="javascript: history.go(-1);" title="Go Back"><< Go Back</a></p>
</div>
<div id="top-cms-text">
	<?php echo $this->Html->link(__('EDIT NEWS', true), array('action' => 'edit', $news['News']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('DELETE NEWS', true), array('action' => 'delete', $news['News']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $news['News']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('RETURN TO NEWS', true), array('action' => 'index')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('ADD NEWS', true), array('action' => 'add')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('PUBLISH THIS NEWS?', true), array('action' => 'publish', $news['News']['id']), null, sprintf(__('Are you sure you want to publish NEWS # %s?', true), $news['News']['id'])); ?>
</div>