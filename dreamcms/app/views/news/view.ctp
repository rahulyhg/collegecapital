<?php
	if(isset($newsList) && !$newsList){ //display individual news
?>
        <div class="news view">
            <h2><?php echo $news['News']['title']; ?></h2>
            <em><?php echo $this->FormatEpochToDate->formatEpochToDate($news['News']['startDate']); ?></em>
            <?php echo $news['News']['body']; ?>
            <p class="more"><a href="javascript: history.go(-1);" title="Back"><i class="icon-circle-arrow-left"></i> BACK</a></p>
        </div>
<?php
	} else { //display all news
		if($news){
			echo $this->Html->css('paginateStyles.css');
			if (isset($javascript)) {
				echo $javascript->link('jquery.paginate.min.js');
				$this->set('page','news');
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
            <?php if($options) { ?>
            <div style="clear: both;display: block;height:30px; width: 150px;  padding: 0px 100px 10px 0px;">
				<?php
                    $jsString = "javascript:location.href='?group='+this.value;";
                    $categoryOptions[0] = 'Select News Category';
                    foreach ($options as $option){
                        $categoryOptions[$option['NewsCategory']['id']] = $option['NewsCategory']['category'];
                    }
                    if (!isset($_GET['group'])) {
                        echo $this->Form->input('select_news_category_id', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString));
                    } else {
                        $groupValue = $_GET['group'];
                        echo $this->Form->input('select_news_category_id', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString,'default' => $groupValue));
                    }
                ?>
            </div><hr />
<?php       
			}
			echo "<div id='paging_container'><div  class='content'>";
			foreach($news as $news_items):		
?>        		        
                <div class="news view">
                    <h4><?php echo $news_items['News']['title']; ?></h4>
                    <?php echo $news_items['News']['shortDescription']; ?>
                    <p class="more"><a href="/news/view/<?php echo $news_items['News']['id'];?>" title="Read More">READ MORE <i class="icon-circle-arrow-right"></i></a></p><hr />
                </div>
<?php
			endforeach;
			echo "	</div><br clear='all' />
                    <div class='info_text'></div>
                    <div class='page_navigation'></div>
                </div>
				<br clear='all' />
				<p class='more'><a href='/news/archive/' title='View Archived News'>VIEW ARCHIVED NEWS <i class='icon-circle-arrow-right'></i></a></p>";

		} else {
			echo "<p>There are currently no News items. Please check back later.</p>";
		}
	}
	
?>	