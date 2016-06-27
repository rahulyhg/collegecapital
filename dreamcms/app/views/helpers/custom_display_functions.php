<?php
class CustomDisplayFunctionsHelper extends FormHelper { 
	var $helpers = array('Html','Javascript');
	
	function displayHeader($var) {
		if($var){
			$htmlOutput = "<div id='header-wrap'>
								<div id='header-client-logo'></div>
						   </div>";
			return $htmlOutput;	
		}
	}
	
	function displayMenuModules($var,$userType) {
		if($var){
			$htmlOutput = "";	
			$siteMenu = 	"<div class='horizontalcssmenu'>
							<ul id='cssmenu1'>

									<li class='home'><a href='".Configure::read('Company.menuUrl')."' title='home'>Home</a></li>
									<li class='about'><a href='".Configure::read('Company.menuUrl')."webpages/view/1' title='about'>About</a></li>
									
									".($_SESSION['Auth']['User']['group_id']<4?"<li class='claims'><a href='".Configure::read('Company.menuUrl')."claims/' title='transactions'>Transactions</a></li>
									<li class='links'><a href='".Configure::read('Company.menuUrl')."links/view/' title='links'>Links</a></li>
									<li class='contacts'><a href='".Configure::read('Company.menuUrl')."clients/view/' title='contacts'>Contacts</a></li>":"")."
									<li class='network'><a href='".Configure::read('Company.menuUrl')."users/view/' title='network'>Network</a></li>
									".($_SESSION['Auth']['User']['group_id']<4?"<li class='news'><a href='".Configure::read('Company.menuUrl')."news/view/' title='news'>News</a></li>
									<li class='documents'><a href='".Configure::read('Company.menuUrl')."documents/view' title='documents'>Documents</a></li>":"")."
									<li class='rates'><a href='".Configure::read('Company.menuUrl')."rates/view' title='rates'>Rates</a></li>".
									($_SESSION['Auth']['User']['group_id']==1?"
									
									<li class='pages'><a href='".Configure::read('Company.menuUrl')."webpages/' title='pages'>Pages</a></li>":"")."
									".($_SESSION['Auth']['User']['group_id']==1?"<li class='vbis'><a href='".Configure::read('Company.menuUrl')."vbis/' title='VBI'>VBI</a></li>":"")."	
							</ul></div>";
			
			
			if ((int)$userType==1){ //admin
				$htmlOutput = $siteMenu;
			} else {	//content-users		
				$htmlOutput = $siteMenu;
			}
			return $htmlOutput;	
		}
	}
	
	
function displayWebsiteModules($var,$userType) {
		if($var){
			$htmlOutput = "";	
			$adminMenuStart = "<div class='menu-module'><div class='squarebox'><div class='squareboxgradientcaption' onclick='togglePannelAnimatedStatus(this.nextSibling,50,50)'><div class='squareboxHead'>ADMIN MODULES</div><div style='float: right; vertical-align: middle'><img src='".Configure::read('Company.url')."app/webroot/img/expand.gif' width='13' height='14' border='0' alt='Show/Hide' title='Show/Hide' /></div></div><div class='squareboxcontent' style='display: none;'><ul>";
								
			if ((int)$userType==1){ 
				$adminCategoryMenu = "<li><a class='menu_item' href='".Configure::read('Company.menuUrl')."claims_goodsdescs/' title='transaction goods descriptions'>Transaction Goods Descriptions</a></li>
				                  <li><a class='menu_item' href='".Configure::read('Company.menuUrl')."claims_industryprofiles/' title='transaction industry profiles'>Transaction Industry Profiles</a></li>
								  <li><a class='menu_item' href='".Configure::read('Company.menuUrl')."claims_lenders/' title='transaction lenders'>Transaction Lenders</a></li>
								  <li><a class='menu_item' href='".Configure::read('Company.menuUrl')."claims_producttypes/' title='transaction product types'>Transaction Product Types</a></li>
								  <li><a class='menu_item' href='".Configure::read('Company.menuUrl')."clients_categories/' title='contacts categories'>Contacts Categories</a></li>
								  <li><a class='menu_item' href='".Configure::read('Company.menuUrl')."documents_categories/' title='documents categories'>Documents Categories</a></li>
								  <li><a class='menu_item' href='".Configure::read('Company.menuUrl')."links_categories/' title='links categories'>Links Categories</a></li>
								  <li><a class='menu_item' href='".Configure::read('Company.menuUrl')."news_categories/' title='news categories'>News Categories</a></li>
								  <li><a class='menu_item' href='".Configure::read('Company.menuUrl')."pages_categories/' title='pages categories'>Pages Categories</a></li>
								  <li><a class='menu_item' href='".Configure::read('Company.menuUrl')."rates_categories/' title='rates categories'>Rates Categories</a></li>";
			}
			$userAccessMenu =	"<li><a class='menu_item' href='".Configure::read('Company.menuUrl')."groups/' title='user groups'>User Groups</a></li>";					  
			$adminMenuEnd = "</ul></div></div></div>";
			
			
			if ((int)$userType==1){ //admin
				$htmlOutput = $adminMenuStart.$adminCategoryMenu.$userAccessMenu.$adminMenuEnd;
			} else {	//content-users		
				$htmlOutput = "";
			}
			return $htmlOutput;	
		}
	}	
	
	
	function displayQuickLinks($var) {
		if($var){
			$htmlOutput = "";
			return $htmlOutput;	
		}
	}
	
	function displayQuickSearch($var, $url){
		if ($var){
			$htmlOutput = "<div id='quick-search'><strong>Quick search:</strong>&nbsp;
							<a href='".$url."?sel=A'>A</a> 
							<a href='".$url."?sel=B'>B</a> 
							<a href='".$url."?sel=C'>C</a> 
							<a href='".$url."?sel=D'>D</a> 
							<a href='".$url."?sel=E'>E</a> 
							<a href='".$url."?sel=F'>F</a> 
							<a href='".$url."?sel=G'>G</a> 
							<a href='".$url."?sel=H'>H</a> 
							<a href='".$url."?sel=I'>I</a> 
							<a href='".$url."?sel=J'>J</a> 
							<a href='".$url."?sel=K'>K</a> 
							<a href='".$url."?sel=L'>L</a> 
							<a href='".$url."?sel=M'>M</a> 
							<a href='".$url."?sel=N'>N</a> 
							<a href='".$url."?sel=O'>O</a> 
							<a href='".$url."?sel=P'>P</a> 
							<a href='".$url."?sel=Q'>Q</a> 
							<a href='".$url."?sel=R'>R</a> 
							<a href='".$url."?sel=S'>S</a> 
							<a href='".$url."?sel=T'>T</a> 
							<a href='".$url."?sel=U'>U</a> 
							<a href='".$url."?sel=V'>V</a> 
							<a href='".$url."?sel=W'>W</a> 
							<a href='".$url."?sel=X'>X</a> 
							<a href='".$url."?sel=Y'>Y</a> 
							<a href='".$url."?sel=Z'>Z</a> | 
							<a href='".$url."?sel=all'>all</a> |
							<a href='".$url."?sel=other'>other</a>&nbsp;
						   </div>";
			return $htmlOutput;	
		}
	}
		
	function displaySearchBox($var){
		if($var){
			$jsString = "javascript:location.href='?search='+document.getElementById('search').value;";
			$htmlOutput = "<div class='menu-tab'>
							<input type='text' id='search'>&nbsp;
							<a onclick=".$jsString." href='javascript:void(0)'>search</a>
						   </div>";
			return $htmlOutput;	
		}
	}
	
	function displaySearchBoxView($var){
		if($var){
			$jsString = "javascript:location.href='?search='+document.getElementById('search').value;";
			$htmlOutput = "<div class='input text'>
							<input type='text' id='search' style='height: 16px;'>&nbsp;
							<a onclick=".$jsString." href='javascript:void(0)'>search</a>
						   </div>";
			return $htmlOutput;	
		}
	}
	
	function displayNoRecordDetails($var){
		if($var){
			$htmlOutput = 	"<div id='record_wrap'>
								<div style='width:100%' id='record_row'>
									<div id='record_detail'>There are no records in your current selection or current search criteria or filtering options.</div>
								</div>
							</div>";
			return $htmlOutput;	
		}
	}
	
	function displayNoClaimsDetails($var){
		if($var){
			$htmlOutput = 	"<div id='record_wrap'>
								<div style='width:100%' id='record_row'>
									<div id='record_detail'>Phew! No more pending claims to be actioned.</div>
								</div>
							</div>";
			return $htmlOutput;	
		}
	}
}
?>