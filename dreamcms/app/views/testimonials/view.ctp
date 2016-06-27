<div class="testimonials view">
	<blockquote><span class="bqstart">"</span><?php echo $testimonial['Testimonial']['description']; ?><span class="bqend">"</span></blockquote>
    <?php
		if (strlen($testimonial['Testimonial']['person_company'])>0){ ?>
        	<p align="right" style="float:right;">- <?php echo $testimonial['Testimonial']['person_company']; ?></p>
	<?php		
		}
    ?>
</div>
<div id="top-cms-text">
    <?php echo $this->Html->link(__('EDIT THIS ITEM', true), array('action' => 'edit', $testimonial['Testimonial']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('DELETE THIS ITEM', true), array('action' => 'delete', $testimonial['Testimonial']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $testimonial['Testimonial']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('RETURN TO TESTIMONIALS', true), array('action' => 'index')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('ADD NEW TESTIMONIAL', true), array('action' => 'add')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('PUBLISH THIS ITEM?', true), array('action' => 'publish', $testimonial['Testimonial']['id']), null, sprintf(__('Are you sure you want to publish TESTIMONIAL # %s?', true), $testimonial['Testimonial']['id'])); ?>
</div>
