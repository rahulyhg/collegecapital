<?php
 
class RSSComponent extends Object {
	var $name = 'RSS';
	function RSS()
	{
		//require_once ('pathto.../mysql_connect.php');
	}

	function GetFeed()
	{
		return $this->getDetails() . $this->getItems();
	}

	function dbConnect()
	{
		//DEFINE ('LINK', mysql_connect (DB_HOST, DB_USER, DB_PASSWORD));
	}

	function getDetails()
	{
		$details = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>
						<rss version=\"2.0\">
							<channel>
								<title>".Configure::read('Company.name')."</title>
								<link>".Configure::read('Company.url')."</link>
								<description>College Capital Finance Solutions</description>
								<language>en-au</language>
								<image>
									<title>".Configure::read('Company.name')."</title>
									<url>".Configure::read('Company.url')."images/logo.jpg</url>
									<link>".Configure::read('Company.url')."</link>
									<width>100</width>
								</image>";
		return $details;
	}

	function getItems()
	{
		$query = "SELECT * FROM `news` WHERE `news`.`live` = 1 AND `news`.`category_id` = 1 AND FROM_UNIXTIME(`news`.`archiveDate`) > CURDATE() ORDER by `news`.`startDate` DESC;";
		$result = mysql_query($query);
		$items = '';
		while($row = mysql_fetch_array($result))
		{
			$items .= "<item>
				<title>".str_replace("&","and",$row["title"])."</title>
				<link>".Configure::read('Company.url')."latest-news/". $row["seo_page_name"] ."</link>
				<description><![CDATA[".str_replace("&","and",$row["shortDescription"])."]]></description>
				<pubDate>".date("Y-m-d",$row["startDate"])."</pubDate>
			</item>";
		}
		$items .= "</channel>
				</rss>";
		return $items;
	}
	
	function writeFeed() {
		$data = $this->getFeed();
		$file = "../rss.xml";
		$handle = fopen($file, 'w');
		fwrite($handle, $data);
		fclose($handle); 
	}
}
?>