<?php
	if(isset($linkList) && !$linkList){ //display individual links
?>
    <div class="links view">
        <h2><?php echo $link['Link']['name']; ?></h2>
        <a href="<?php echo $link['Link']['url'];?>" target="_blank"><?php echo $link['Link']['url']; ?></a>
        <p>
            <?php if(strlen($link['Link']['logo'])>0) { ?>
                <div style="float: right; width: auto; height: auto; margin: 10px; padding: 0px;"><img src="<?php echo '/app/webroot/uploads/links/'.$link['Link']['logo'];?>" width="150" /></div>
            <?php } ?>
            <?php echo $link['Link']['description']; ?>
        </p>
    </div>
<?php
	} else {
		if($link){
			echo $this->Html->css('paginateStyles.css');
			if (isset($javascript)) {
				echo $javascript->link('jquery.paginate.min.js');
				$this->set('page','links');
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
            <?php if ($options){ ?>
            <div style="clear: both;display: block;height:30px; width: 150px;  padding: 0px 100px 10px 0px;">
				<?php
                    $jsString = "javascript:location.href='?group='+this.value;";
                    $categoryOptions[0] = 'Select Link Category';
                    foreach ($options as $option){
                        $categoryOptions[$option['LinksCategory']['id']] = $option['LinksCategory']['category'];
                    }
                    if (!isset($_GET['group'])) {
                        echo $this->Form->input('select_links_category_id', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString));
                    } else {
                        $groupValue = $_GET['group'];
                        echo $this->Form->input('select_links_category_id', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString,'default' => $groupValue));
                    }
                ?>
            </div><hr>
<?php        
			}
			echo "<div id='paging_container'><div  class='content'>";
			foreach($link as $link_items):		
?>
				<div class="links view">
                    <h4><?php echo $link_items['Link']['name']; ?></h4>
                    <a href="<?php echo $link_items['Link']['url']; ?>" target="_blank"><?php echo $link_items['Link']['url']; ?></a>
                        <?php if(strlen($link_items['Link']['logo'])>0) { ?>
                            <div style="float: right; width: auto; height: auto; margin: 10px; padding: 0px;"><img src="<?php echo '/app/webroot/uploads/links/'.$link_items['Link']['logo'];?>" width="150" /></div>
                        <?php } ?>
                        <?php echo $link_items['Link']['description']; ?><br clear='all' /><hr />
                </div>
<?php
			endforeach;
			echo "	</div><br clear='all' />
                    <div class='info_text'></div>
                    <div class='page_navigation'></div>
                </div>";
		} else {
			echo "<p>There are currently no Link items. Please check back later.</p>";
		}
	}
?>
