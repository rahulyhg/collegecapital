<?php
	echo $html->script('jquery-1.4.4.min', false);
?>
<div class="galleries index">
	<h1><?php __('galleries');?></h1>
	<div id="wrap-tabs">
        <div class="menu-tab">
            <span class="tab"><?php echo $this->Html->link(__('add new', true), array('action' => 'add')); ?></span>			
        </div>
        <div class="menu-tab">
            <span class="tab-hi">display all </span>
        </div>
    </div>
	<div id="clear"></div>
    <div id="records">
        <div id="record_header_wrap">
            <div style="width:20px" id="record_header">
        	</div>
        </div>
		<?php foreach ($galleries as $gallery): 
                echo $html->div('image_frame',
                $html->link(
                    $html->image('/media/filter/medium/'.$gallery['Gallery']['dirname'].'/'.$gallery['Gallery']['basename']), 
                        '/media/transfer/img/'.$gallery['Gallery']['basename'],
                        array('rel' => 'prettyPhoto[gallery1]', 'escape' => false, 'title' => $gallery['Gallery']['basename']),
                    null, false
                ).
                $html->tag('div', 
                    $gallery['Gallery']['basename']. '<span class="deleteText">[Delete]</span>', 
                    array('class' => 'image_frame_info')
                ),
                array('title' => $gallery['Gallery']['id'])
            ); 
            endforeach; 
        ?>
        <div id="clear"></div><br />
        <div class="paging">
        <?php
         echo $this->Paginator->counter(array(
            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
         ));
        ?>
            <div id="clear"></div>	
            <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
            | <?php echo $this->Paginator->numbers();?> |
            <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
        </div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		/*$('.image_frame').deleteImage({
			deleteUrl: '<?php //echo $html->url(array('action' => 'delete')); ?>'
		});*/
		/*
		$("a[rel^='prettyPhoto']").prettyPhoto({
			theme: 'facebook'  light_rounded / dark_rounded / light_square / dark_square / facebook
		}); */	
	});
</script>