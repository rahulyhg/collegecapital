
-- --------------------------------------------------------
USE `collegecapital`
--
-- Table structure for table `claims`
--

CREATE TABLE IF NOT EXISTS `claims` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientName` varchar(255) NOT NULL,
  `claims_user_broker` int(10) NOT NULL,
  `industryprofile_id` int(10) NOT NULL,
  `lender_id` int(10) NOT NULL,
  `goodsdesc_id` int(10) NOT NULL,
  `producttype_id` int(10) NOT NULL,
  `netRate` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `amount` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `terms` int(10) NOT NULL DEFAULT '0',
  `settlementDate` int(32) NOT NULL,
  `actioned` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `claims`
--

INSERT INTO `claims` (`id`, `clientName`, `claims_user_broker`, `industryprofile_id`, `lender_id`, `goodsdesc_id`, `producttype_id`, `netRate`, `amount`, `terms`, `settlementDate`, `actioned`, `created`, `modified`) VALUES
(1, 'Test Claim', 2, 1, 1, 1, 1, '10.3500', '100.0000', 2, 1358168400, 1, '2013-01-16 12:15:47', '2013-01-17 15:02:36'),
(2, 'Claim 2', 5, 1, 1, 1, 1, '5.2500', '500.0000', 5, 1358946000, 0, '2013-01-17 15:27:35', '2013-01-17 15:27:35'),
(3, 'Fred Flinstone', 2, 1, 1, 2, 1, '4.5000', '20000.0000', 60, 1364130000, 0, '2013-03-18 12:04:03', '2013-03-18 15:01:17'),
(4, 'Santa Claus', 2, 3, 3, 6, 2, '5.0000', '150000.0000', 120, 1364130000, 0, '2013-03-18 12:06:43', '2013-03-18 12:06:43'),
(5, 'Electrolux', 5, 5, 2, 3, 2, '10.0000', '100000.0000', 12, 1363611600, 0, '2013-03-18 15:13:31', '2013-03-18 15:14:00'),
(6, 'Basil Brush', 2, 2, 2, 3, 2, '4.5000', '100000.0000', 60, 1362488400, 1, '2013-03-19 09:41:40', '2013-03-19 16:46:19'),
(7, 'College capital test', 67, 6, 2, 1, 2, '5.2300', '50000.0000', 60, 1362661200, 1, '2013-03-20 16:56:58', '2013-03-21 10:56:17'),
(8, 'College capital test', 67, 6, 2, 1, 2, '5.2300', '50000.0000', 60, 1364302800, 0, '2013-03-20 16:57:18', '2013-03-20 16:57:18'),
(9, 'AAA', 2, 1, 1, 1, 1, '5.0000', '100000.0000', 60, 1364302800, 0, '2013-03-20 16:59:29', '2013-03-20 16:59:29'),
(10, 'AAA', 2, 1, 1, 1, 1, '5.0000', '100000.0000', 60, 1364302800, 0, '2013-03-20 17:01:36', '2013-03-20 17:01:36'),
(11, 'Pepsi Walsh', 100, 1, 1, 1, 1, '5.9000', '200000.0000', 60, 1364302800, 0, '2013-03-20 20:01:55', '2013-03-20 20:01:55');

-- --------------------------------------------------------

--
-- Table structure for table `claims_goodsdescs`
--

CREATE TABLE IF NOT EXISTS `claims_goodsdescs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsDescription` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `claims_goodsdescs`
--

INSERT INTO `claims_goodsdescs` (`id`, `goodsDescription`) VALUES
(1, 'Agricultural'),
(2, 'Aircraft'),
(3, 'Boat'),
(4, 'Buses'),
(5, 'Earth Moving Equipment'),
(6, 'Low Value Goods'),
(7, 'Manufacturing'),
(8, 'Medical'),
(9, 'Motor Vehicle'),
(10, 'Other'),
(11, 'Trailer'),
(12, 'Truck');

-- --------------------------------------------------------

--
-- Table structure for table `claims_industryprofiles`
--

CREATE TABLE IF NOT EXISTS `claims_industryprofiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `industryProfile` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `claims_industryprofiles`
--

INSERT INTO `claims_industryprofiles` (`id`, `industryProfile`) VALUES
(1, 'Agricultural'),
(2, 'Construction'),
(3, 'Education & Training'),
(4, 'Finance & Insurance'),
(5, 'Healthcare'),
(6, 'Manufacturing'),
(7, 'Mining'),
(8, 'Other'),
(9, 'Professional'),
(10, 'Retail'),
(11, 'Telecommunication'),
(12, 'Transport & Warehousing'),
(13, 'Wholesale');

-- --------------------------------------------------------

--
-- Table structure for table `claims_lenders`
--

CREATE TABLE IF NOT EXISTS `claims_lenders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lender` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `claims_lenders`
--

INSERT INTO `claims_lenders` (`id`, `lender`) VALUES
(1, 'Commonwealth Bank Australia (CBA)'),
(2, 'ANZ'),
(3, 'Macquarie');

-- --------------------------------------------------------

--
-- Table structure for table `claims_producttypes`
--

CREATE TABLE IF NOT EXISTS `claims_producttypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productType` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `claims_producttypes`
--

INSERT INTO `claims_producttypes` (`id`, `productType`) VALUES
(1, 'Chattel Mortgage'),
(2, 'Hire Purchase'),
(3, 'Lease'),
(4, 'Novated Lease');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `description` text,
  `documentDate` int(11) DEFAULT NULL,
  `documentFile` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `live` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `title`, `description`, `documentDate`, `documentFile`, `category_id`, `live`) VALUES
(1, 'Test Doc 1', '<p>\r\n	This is a test document</p>\r\n', 1362574800, 'pdf-test.pdf', 1, 1),
(2, 'Test Broker list', '<p>\r\n	Test broker list</p>\r\n', 1363611600, 'broker_export_template.xlsx', 3, 1),
(3, 'College Capital Presentation', '<p>\r\n	Presentation slides from College Capital Launch 21/3/13</p>\r\n', 1363698000, 'CC Presentation - Internal - Not for financier distribution.pptx', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `documents_categories`
--

CREATE TABLE IF NOT EXISTS `documents_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) DEFAULT NULL,
  `seo_cat_name` varchar(150) DEFAULT NULL,
  `description` text,
  `leftColContent` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `documents_categories`
--

INSERT INTO `documents_categories` (`id`, `category`, `seo_cat_name`, `description`, `leftColContent`) VALUES
(1, 'Statutory Documents', 'statutory-documents', 'Upload all documents of type Statutory<br />\r\nNote: Everyone can view this document type<br />', NULL),
(2, 'Other Documents', 'other-documents', 'Upload all documents of type Other<br />\r\nNote: Everyone can view this document type<br />\r\n', NULL),
(3, 'Contact Documents', 'contact-documents', 'Upload all documents of type Contact<br />\r\nNote: Everyone can view this document type<br />\r\n', NULL),
(4, 'Banking Products', 'banking-products', 'Upload all documents of type Banking Product<br />\r\nNote: Everyone can view this document type<br />\r\n', NULL),
(5, 'Volume Bonus Report', 'volumne-bonus-report', 'Upload all documents of type Volume Bonus Report<br />\r\nNote: Everyone can view this document type<br />\r\n', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE IF NOT EXISTS `faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `position` int(11) DEFAULT NULL,
  `live` tinyint(4) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `faqs_category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `faqs_categories`
--

CREATE TABLE IF NOT EXISTS `faqs_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) NOT NULL,
  `seo_cat_name` varchar(150) DEFAULT NULL,
  `left_col_content` text,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group`) VALUES
(1, 'SuperUsers'),
(2, 'Principals'),
(3, 'Brokers'),
(4, 'Banks');

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `description` text,
  `logo` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `live` tinyint(1) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `links_category_id` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `name`, `url`, `description`, `logo`, `category_id`, `live`, `position`) VALUES
(1, 'Google', 'http://www.google.com', '<p>\r\n	Google Inc. is an American multinational corporation that provides Internet-related products and services, including internet search, cloud computing, software and advertising technologies.</p>\r\n', 'google.jpg', 1, 1, 0),
(2, 'Commonwealth Bank of Australia', 'http://www.commbank.com.au', '<p>\r\n	The Commonwealth Bank of Australia is an Australian multinational bank with businesses across New Zealand, Fiji, Asia, USA and the United Kingdom. Commonly referred to as the Commonwealth Bank (or Commbank), it provides a variety of financial services including retail, business and institutional banking, funds management, superannuation, insurance, investment and broking services</p>\r\n', 'cba1.jpg', 1, 1, 1),
(3, 'Facebook', 'http://www.facebook.com', '<p>\r\n	Facebook is a social networking service launched in February 2004, owned and operated by Facebook, Inc. As of September 2012, Facebook has over one billion active users,[6] more than half of whom use Facebook on a mobile device.[7] Users must register before using the site, after which they may create a personal profile, add other users as friends, and exchange messages, including automatic notifications when they update their profile. Additionally, users may join common-interest user groups, organized by workplace, school or college, or other characteristics, and categorize their friends into lists such as &quot;People From Work&quot; or &quot;Close Friends&quot;.</p>\r\n', 'Facebook-logo.jpg', 2, 1, 2),
(4, 'LinkedIn', 'http://www.linkedin.com', '<p>\r\n	LinkedIn&nbsp;is a social networking website for people in professional occupations. Founded in December 2002 and launched on May 5, 2003, it is mainly used for professional networking. As of January 2013, LinkedIn reports more than 200 million acquired users in more than 200 countries and territories</p>\r\n', '225px-LinkedIn_Logo.jpg', 2, 1, 3),
(5, 'Twitter', 'http://www.twitter.com', '<p>\r\n	&nbsp;</p>\r\n<div>\r\n	Twitter is an online social networking service and microblogging service that enables its users to send and read text-based messages of up to 140 characters, known as &quot;tweets&quot;.</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Twitter was created in March 2006 by Jack Dorsey and by July, the social networking site was launched. The service rapidly gained worldwide popularity, with over 500 million registered users as of 2012, generating over 340 million tweets daily and handling over 1.6 billion search queries per day. Since its launch, Twitter has become one of the ten most visited websites on the Internet, and has been described as &quot;the SMS of the Internet.&quot; Unregistered users can read tweets, while registered users can post tweets through the website interface, SMS, or a range of apps for mobile devices.</div>\r\n', 'twitter.jpg', 2, 1, 4),
(6, 'Microsoft', 'http://www.microsoft.com', '<p>\r\n	Microsoft Corporation is an American multinational software corporation headquartered in Redmond, Washington that develops, manufactures, licenses, and supports a wide range of products and services related to computing. The company was founded by Bill Gates and Paul Allen on April 4, 1975. Microsoft is the world&#39;s largest software maker measured by revenues. It is also one of the world&#39;s most valuable companies.</p>\r\n', 'microsoft.jpg', 1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `links_categories`
--

CREATE TABLE IF NOT EXISTS `links_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `links_categories`
--

INSERT INTO `links_categories` (`id`, `category`) VALUES
(1, 'Corporate'),
(2, 'Social Media');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `shortDescription` text,
  `body` mediumtext,
  `documentFiles` varchar(256) DEFAULT NULL,
  `imageFiles` varchar(256) DEFAULT NULL,
  `startDate` int(11) DEFAULT NULL,
  `archiveDate` int(11) DEFAULT NULL,
  `unpublishDate` int(11) DEFAULT NULL,
  `live` tinyint(1) DEFAULT '0',
  `category_id` int(11) DEFAULT NULL,
  `teams` varchar(200) DEFAULT NULL,
  `branches` varchar(200) DEFAULT NULL,
  `seo_page_name` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `shortDescription`, `body`, `documentFiles`, `imageFiles`, `startDate`, `archiveDate`, `unpublishDate`, `live`, `category_id`, `teams`, `branches`, `seo_page_name`) VALUES
(1, 'Test News 1', '<p>\r\n	This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news. This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;</p>\r\n', '<h2>\r\n	This is a test blurb for the test news.&nbsp;This is a test</h2>\r\n<p>\r\n	<img alt="" src="/app/webroot/files/images/College-Capital-word.jpg" style="width: 100px; height: 63px; border-width: 0px; border-style: solid; margin: 10px; float: left;" />blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;</p>\r\n<p>\r\n	This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;</p>\r\n<p>\r\n	This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.</p>\r\n', NULL, NULL, 1361365200, 1392901200, NULL, 1, 1, NULL, NULL, 'test-news-1'),
(2, 'Test News 2', '<p>\r\n	This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;</p>\r\n', '<p>\r\n	This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;</p>\r\n<p>\r\n	This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;</p>\r\n<p>\r\n	This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;This is a test blurb for the test news.&nbsp;</p>\r\n', NULL, NULL, 1361278800, 1392814800, NULL, 0, 1, NULL, NULL, 'test-news-2');

-- --------------------------------------------------------

--
-- Table structure for table `news_categories`
--

CREATE TABLE IF NOT EXISTS `news_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `news_categories`
--

INSERT INTO `news_categories` (`id`, `category`) VALUES
(1, 'Latest News'),
(2, 'Blog');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `metaTitle` varchar(255) DEFAULT NULL,
  `metaKeywords` text,
  `metaDescription` text,
  `shortDescription` text,
  `body` mediumtext,
  `position` int(11) DEFAULT NULL,
  `live` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `seo_page_name` varchar(256) DEFAULT NULL,
  `parent_page_id` int(11) DEFAULT '0',
  `leftColContent` text,
  `cms_user_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `pages_category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `metaTitle`, `metaKeywords`, `metaDescription`, `shortDescription`, `body`, `position`, `live`, `created`, `modified`, `category_id`, `seo_page_name`, `parent_page_id`, `leftColContent`, `cms_user_id`) VALUES
(1, 'Overview', 'Overview', 'about us, college capital', 'college capital about us information', '<span style="color: rgb(51, 51, 51); font-family: Arial, Helvetica, sans-serif; font-size: 13px; line-height: 18px;">College Capital is a financial services aggregator specialising in asset finance, established to promote and add value to asset finance brokers</span>', '<p style="margin: 0px; font-size: 13px; line-height: 18px; padding: 10px 0px 0px; color: rgb(51, 51, 51); font-family: Arial,Helvetica,sans-serif;">\r\n	<strong>Being one of the largest asset finance aggregation groups and boasting an impressive list of broker members, we pride ourselves on our relationships that we hold with a wide range of financiers.</strong></p>\r\n<p style="margin: 0px; font-size: 13px; line-height: 18px; padding: 10px 0px 0px; color: rgb(51, 51, 51); font-family: Arial, Helvetica, sans-serif;">\r\n	By staying close to our financiers, we are able to provide up to date market intelligence to assist our broker members to deliver the best possible financing solutions to clients.</p>\r\n<p style="margin: 0px; font-size: 13px; line-height: 18px; padding: 10px 0px 0px; color: rgb(51, 51, 51); font-family: Arial, Helvetica, sans-serif;">\r\n	We encourage collaboration between our broker members to support and promote each other across the group. This provides another avenue to leverage local market knowledge and industry specialisations, very valuable information to be equipped with in order to fully understand a client&#39;s needs and to provide them with the best possible experience.</p>\r\n<p style="margin: 0px; font-size: 13px; line-height: 18px; padding: 10px 0px 0px; color: rgb(51, 51, 51); font-family: Arial, Helvetica, sans-serif;">\r\n	At College Capital, we understand the compliance and regulatory requirements that financial institutions are administered by, and part of our charter is to provide a link between our broker members and financiers. By accepting this responsibility we communicate with our broker members to ensure they are operating diligently within the industry. For our broker members, it means they can let us take the worry out of keeping abreast of the ever changing landscape of corporate governance.</p>\r\n<p style="margin: 0px; font-size: 13px; line-height: 18px; padding: 10px 0px 0px; color: rgb(51, 51, 51); font-family: Arial, Helvetica, sans-serif;">\r\n	We value your independence within the finance industry and encourage you to go about your business equipped with the knowledge that at College Capital you have access to a network of experienced colleagues to call on should you desire.</p>\r\n', 0, 1, '2013-02-22 16:12:02', '2013-03-19 14:48:42', 1, 'overview', 0, '', 3),
(2, 'Our People', 'Another', 'College Capital People', 'College Capital People', '<span style="color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: 15px; line-height: 18px;">College Capital was founded by a shared desire to build an effective aggregation platform for brokers to operate within.</span>', '<p>\r\n	&nbsp;</p>\r\n<p style="margin: 0px; color: rgb(0, 0, 0); font-size: 15px; line-height: 18px; padding: 15px 0px 0px; font-family: Arial, Helvetica, sans-serif;">\r\n	<strong>College Capital was founded by a shared desire to build an effective aggregation platform for brokers to operate within.</strong></p>\r\n<p style="margin: 0px; font-size: 13px; line-height: 18px; padding: 10px 0px 0px; color: rgb(51, 51, 51); font-family: Arial, Helvetica, sans-serif;">\r\n	This entailed the combination of four successful asset finance broker groups coming together to form College Capital.</p>\r\n<p style="margin: 0px; font-size: 13px; line-height: 18px; padding: 10px 0px 0px; color: rgb(51, 51, 51); font-family: Arial, Helvetica, sans-serif;">\r\n	The founding parties &ndash;&nbsp;<a href="http://www.allfreightfinance.com.au/" style="margin: 0px; color: rgb(102, 102, 102); text-decoration: none;" target="_blank">Allfreight Finance</a>, Leasing Consultants Group,&nbsp;<a href="http://www.mainlandfinance.com.au/" style="margin: 0px; color: rgb(102, 102, 102); text-decoration: none;" target="_blank">Mainland Finance</a>&nbsp;and&nbsp;<a href="http://www.moneyresources.com.au/" style="margin: 0px; color: rgb(102, 102, 102); text-decoration: none;" target="_blank">Money Resources Group</a>&nbsp;are all successful and well established businesses in their own right.</p>\r\n<p style="margin: 0px; font-size: 13px; line-height: 18px; padding: 10px 0px 0px; color: rgb(51, 51, 51); font-family: Arial, Helvetica, sans-serif;">\r\n	They identified an opportunity to create a unique tripartite aggregation model designed to benefit:</p>\r\n<ul style="margin: 10px 0px 0px 10px; font-size: 13px; line-height: 16px; list-style-type: none; padding-left: 0px; color: rgb(51, 51, 51); font-family: Arial, Helvetica, sans-serif;">\r\n	<li style="margin: 0px 0px 3px; background-image: url(http://www.collegecapital.com.au/images/bullet.gif); padding-left: 16px; background-position: 0px 7px; background-repeat: no-repeat no-repeat;">\r\n		Broker</li>\r\n	<li style="margin: 0px 0px 3px; background-image: url(http://www.collegecapital.com.au/images/bullet.gif); padding-left: 16px; background-position: 0px 7px; background-repeat: no-repeat no-repeat;">\r\n		Financier</li>\r\n	<li style="margin: 0px 0px 3px; background-image: url(http://www.collegecapital.com.au/images/bullet.gif); padding-left: 16px; background-position: 0px 7px; background-repeat: no-repeat no-repeat;">\r\n		Client</li>\r\n</ul>\r\n<p style="margin: 0px; font-size: 13px; line-height: 18px; padding: 10px 0px 0px; color: rgb(51, 51, 51); font-family: Arial, Helvetica, sans-serif;">\r\n	College Capital is supported by a hands-on General Manager, Leanne Walsh, who with her extensive financial background can provide the endorsement you need to operate in today&#39;s dynamic financial services environment.</p>\r\n', 1, 1, '2013-03-18 10:17:47', '2013-03-19 13:47:39', 1, 'our-people', 0, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages_categories`
--

CREATE TABLE IF NOT EXISTS `pages_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(200) DEFAULT NULL,
  `seo_cat_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pages_categories`
--

INSERT INTO `pages_categories` (`id`, `category`, `seo_cat_name`) VALUES
(1, 'About Us', 'about-us');

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

CREATE TABLE IF NOT EXISTS `rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `description` text,
  `documentDate` int(11) DEFAULT NULL,
  `documentFile` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `live` tinyint(1) NOT NULL DEFAULT '0',
  `cms_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `rates`
--

INSERT INTO `rates` (`id`, `title`, `description`, `documentDate`, `documentFile`, `category_id`, `live`, `cms_user_id`) VALUES
(1, 'CBA - Home Loan Interest Rates - Feb 2013', '<p>\r\n	<span style="color: rgb(102, 102, 102); font-family: Verdana, Arial, ''Arial Unicode MS'', Helvetica, sans-serif; font-size: 11px; line-height: 15px; -webkit-text-size-adjust: none;">With a Commonwealth Bank home loan, you can get 6 months&#39; pre-approval and take your time to shop. If saving a large enough deposit seems to take forever, we offer a Property Share option so you can split the cost of purchase with a friend or relative, and Guarantor Support to assist with securing your loan. Our home loans are also portable, so if you sell your property down the track, you can take your loan with you. You can also top-up your home loan and have access to more funds, as your needs change over time. Finally, with all our home loans, interest is calculated daily in arrears and charged monthly. And you have a choice of weekly, fortnightly or monthly repayments. Use the comparison table to find out which loan type suits you best.</span></p>\r\n', 1362574800, 'home-loan-update-002842.pdf', 1, 1, 6),
(2, 'CBA - Test Document', '<p>\r\n	This is a test PDF uploaded</p>\r\n', 1362488400, 'pdf-test.pdf', 1, 1, 6),
(3, 'Test Bank - Test PDF', '<p>\r\n	This is a test Interest Rate document</p>\r\n', 1362488400, 'pdf-test.pdf', 1, 1, 3),
(4, 'Test Bank - Interest Rate PDF', '<p>\r\n	This is a test Interest Rate PDF document</p>\r\n', 1362574800, 'pdf-test.pdf', 1, 1, 3),
(5, 'Test Bank March Interest Rates', '', 1363266000, 'CC-Leanne-press.pdf', 1, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `rates_categories`
--

CREATE TABLE IF NOT EXISTS `rates_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `seo_cat_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rates_categories`
--

INSERT INTO `rates_categories` (`id`, `category`, `seo_cat_name`, `description`) VALUES
(1, 'Interest Rates', 'interest-rates', 'Upload documents of type Interest Rates.<br />\r\nNotes: Only banks and super admins can upload such documents<br />\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `tblcountry`
--

CREATE TABLE IF NOT EXISTS `tblcountry` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Country` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=250 ;

--
-- Dumping data for table `tblcountry`
--

INSERT INTO `tblcountry` (`ID`, `Country`) VALUES
(1, 'Afghanistan'),
(2, 'Albania'),
(3, 'Algeria'),
(4, 'American Samoa'),
(5, 'Andorra'),
(6, 'Angola'),
(7, 'Anguilla'),
(8, 'Antarctica'),
(9, 'Antigua and Barbuda'),
(10, 'Argentina'),
(11, 'Armenia'),
(12, 'Aruba'),
(13, 'Ascension'),
(14, 'Australia'),
(15, 'Austria'),
(16, 'Azerbaijan'),
(17, 'Bahamas'),
(18, 'Bahrain'),
(19, 'Bangladesh'),
(20, 'Barbados'),
(21, 'Belarus'),
(22, 'Belgium'),
(23, 'Belize'),
(24, 'Benin, Republic of'),
(25, 'Bermuda'),
(26, 'Bhutan'),
(27, 'Bolivia'),
(28, 'Bosnia and Herzegovina'),
(29, 'Botswana'),
(30, 'Brazil'),
(31, 'British Virgin Islands'),
(32, 'Brunei'),
(33, 'Bulgaria'),
(34, 'Burkina Faso'),
(35, 'Burundi'),
(36, 'Cambodia'),
(37, 'Cameroon'),
(38, 'Canada'),
(39, 'Cape Verde Islands'),
(40, 'Cayman Islands'),
(41, 'Central African Rep'),
(42, 'Chad Republic'),
(43, 'Chatham Island, NZ'),
(44, 'Chile'),
(45, 'China'),
(46, 'Christmas Island'),
(47, 'Cocos Islands'),
(48, 'Colombia'),
(49, 'Comoros'),
(50, 'Congo'),
(51, 'Cook Islands'),
(52, 'Costa Rica'),
(53, 'Croatia'),
(54, 'Cuba'),
(55, 'Curacao'),
(56, 'Cyprus'),
(57, 'Czech Republic'),
(58, 'Denmark'),
(59, 'Diego Garcia'),
(60, 'Djibouti'),
(61, 'Dominica'),
(62, 'Dominican Republic'),
(63, 'Easter Island'),
(64, 'Ecuador'),
(65, 'Egypt'),
(66, 'El Salvador'),
(67, 'Equitorial Guinea'),
(68, 'Eritrea'),
(69, 'Estonia'),
(70, 'Ethiopia'),
(71, 'Falkland Islands'),
(72, 'Faroe Islands'),
(73, 'Fiji Islands'),
(74, 'Finland'),
(75, 'France'),
(76, 'French Antilles'),
(77, 'French Guiana'),
(78, 'French Polynesia'),
(79, 'Gabon Republic'),
(80, 'Gambia'),
(81, 'Georgia'),
(82, 'Germany'),
(83, 'Ghana'),
(84, 'Gibraltar'),
(85, 'Greece'),
(86, 'Greenland'),
(87, 'Grenada and Carriacuou'),
(88, 'Grenadin Islands'),
(89, 'Guadeloupe'),
(90, 'Guam'),
(91, 'Guantanamo Bay'),
(92, 'Guatemala'),
(93, 'Guiana'),
(94, 'Guinea, Bissau'),
(95, 'Guinea, Rep'),
(96, 'Guyana'),
(97, 'Haiti'),
(98, 'Honduras'),
(99, 'Hong Kong'),
(100, 'Hungary'),
(101, 'Iceland'),
(102, 'India'),
(103, 'Indonesia'),
(104, 'Inmarsat'),
(105, 'Iran'),
(106, 'Iraq'),
(107, 'Ireland'),
(108, 'Isle of Man'),
(109, 'Israel'),
(110, 'Italy'),
(111, 'Ivory Coast'),
(112, 'Jamaica'),
(113, 'Japan'),
(114, 'Jordan'),
(115, 'Kazakhstan'),
(116, 'Kenya'),
(117, 'Kiribati'),
(118, 'Korea, North'),
(119, 'Korea, South'),
(120, 'Kosovo'),
(121, 'Kuwait'),
(122, 'Kyrgyzstan'),
(123, 'Laos'),
(124, 'Latvia'),
(125, 'Lebanon'),
(126, 'Lesotho'),
(127, 'Liberia'),
(128, 'Libya'),
(129, 'Liechtenstein'),
(130, 'Lithuania'),
(131, 'Luxembourg'),
(132, 'Macau'),
(133, 'Macedonia, FYROM'),
(134, 'Madagascar'),
(135, 'Malawi'),
(136, 'Malaysia'),
(137, 'Maldives'),
(138, 'Mali Republic'),
(139, 'Malta'),
(140, 'Mariana Islands'),
(141, 'Marshall Islands'),
(142, 'Martinique'),
(143, 'Mauritania'),
(144, 'Mauritius'),
(145, 'Mayotte Island'),
(146, 'Mexico'),
(147, 'Micronesia, Fed States'),
(148, 'Midway Islands'),
(149, 'Miquelon'),
(150, 'Moldova'),
(151, 'Monaco'),
(152, 'Mongolia'),
(153, 'Montserrat'),
(154, 'Morocco'),
(155, 'Mozambique'),
(156, 'Myanmar'),
(157, 'Namibia'),
(158, 'Nauru'),
(159, 'Nepal'),
(160, 'Neth. Antilles'),
(161, 'Netherlands'),
(162, 'Nevis'),
(163, 'New Caledonia'),
(164, 'New Zealand'),
(165, 'Nicaragua'),
(166, 'Niger Republic'),
(167, 'Nigeria'),
(168, 'Niue'),
(169, 'Norfolk Island'),
(170, 'Norway'),
(171, 'Oman'),
(172, 'Pakistan'),
(173, 'Palau'),
(174, 'Panama'),
(175, 'Papua New Guinea'),
(176, 'Paraguay'),
(177, 'Peru'),
(178, 'Philippines'),
(179, 'Poland'),
(180, 'Portugal'),
(181, 'Principe'),
(182, 'Puerto Rico'),
(183, 'Qatar'),
(184, 'Reunion Island'),
(185, 'Romania'),
(186, 'Russia'),
(187, 'Rwanda'),
(188, 'Saipan'),
(189, 'San Marino'),
(190, 'Sao Tome'),
(191, 'Saudi Arabia'),
(192, 'Senegal Republic'),
(193, 'Serbia, Republic of'),
(194, 'Seychelles'),
(195, 'Sierra Leone'),
(196, 'Singapore'),
(197, 'Slovakia'),
(198, 'Slovenia'),
(199, 'Solomon Islands'),
(200, 'Somalia Republic'),
(201, 'South Africa'),
(202, 'Spain'),
(203, 'Sri Lanka'),
(204, 'St. Helena'),
(205, 'St. Kitts'),
(206, 'St. Lucia'),
(207, 'St. Pierre et Miquelon'),
(208, 'St. Vincent'),
(209, 'Sudan'),
(210, 'Suriname'),
(211, 'Swaziland'),
(212, 'Sweden'),
(213, 'Switzerland'),
(214, 'Syria'),
(215, 'Taiwan'),
(216, 'Tajikistan'),
(217, 'Tanzania'),
(218, 'Thailand'),
(219, 'Togo'),
(220, 'Tokelau'),
(221, 'Tonga'),
(222, 'Trinidad and Tobago'),
(223, 'Tunisia'),
(224, 'Turkey'),
(225, 'Turkmenistan'),
(226, 'Turks and Caicos Islands'),
(227, 'Tuvalu'),
(228, 'US Virgin Islands'),
(229, 'Uganda'),
(230, 'Ukraine'),
(231, 'United Arab Emirates'),
(232, 'United Kingdom'),
(233, 'United States'),
(234, 'Uruguay'),
(235, 'Uzbekistan'),
(236, 'Vanuatu'),
(237, 'Vatican city'),
(238, 'Venezuela'),
(239, 'Vietnam, Soc Republic of'),
(240, 'Wake Island'),
(241, 'Wallis and Futuna Islands'),
(242, 'Western Samoa'),
(243, 'Yemen'),
(244, 'Yugoslavia'),
(245, 'Zaire'),
(246, 'Zambia'),
(247, 'Zanzibar'),
(248, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `tblstate`
--

CREATE TABLE IF NOT EXISTS `tblstate` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `State` varchar(100) NOT NULL,
  `ShortName` varchar(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tblstate`
--

INSERT INTO `tblstate` (`ID`, `State`, `ShortName`) VALUES
(1, 'Australian Capital Territory', 'ACT'),
(2, 'New South Wales', 'NSW'),
(3, 'Northern Territory', 'NT'),
(4, 'Queensland', 'QLD'),
(5, 'South Australia', 'SA'),
(6, 'Tasmania', 'TAS'),
(7, 'Victoria', 'VIC'),
(8, 'Western Australia', 'WA'),
(9, 'International', 'INT'),
(11, 'Please Select', 'NA');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `shortDescription` text,
  `body` text,
  `phone` int(10) DEFAULT NULL,
  `mobile` int(10) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `qualifications` text,
  `memberships` text,
  `publications` text,
  `photo` varchar(256) DEFAULT NULL,
  `live` tinyint(1) DEFAULT '0',
  `position` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `seo_page_name` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teams_category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `teams_categories`
--

CREATE TABLE IF NOT EXISTS `teams_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) DEFAULT NULL,
  `seo_cat_name` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_company` varchar(100) DEFAULT NULL,
  `description` text,
  `position` int(11) DEFAULT NULL,
  `live` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(45) NOT NULL,
  `position` varchar(200) DEFAULT NULL,
  `companyName` varchar(200) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `mobile` char(12) NOT NULL,
  `phone` char(12) NOT NULL,
  `fax` char(12) NOT NULL,
  `streetAddress` varchar(255) NOT NULL,
  `streetSuburb` char(200) DEFAULT NULL,
  `street_state_id` smallint(4) NOT NULL,
  `streetPostcode` smallint(4) DEFAULT NULL,
  `postalAddress` varchar(255) NOT NULL,
  `postalSuburb` char(200) DEFAULT NULL,
  `postal_state_id` smallint(4) NOT NULL,
  `postalPostcode` smallint(4) DEFAULT NULL,
  `googleMap` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `websiteLogin` varchar(255) NOT NULL,
  `linkedIn` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `parent_user_id` int(10) NOT NULL DEFAULT '0',
  `status_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=131 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `username`, `password`, `position`, `companyName`, `email`, `mobile`, `phone`, `fax`, `streetAddress`, `streetSuburb`, `street_state_id`, `streetPostcode`, `postalAddress`, `postalSuburb`, `postal_state_id`, `postalPostcode`, `googleMap`, `website`, `websiteLogin`, `linkedIn`, `logo`, `group_id`, `parent_user_id`, `status_id`) VALUES
(1, 'Mayur', 'Meshram', 'mayur@echo3.com.au', '58d45d0365a2b2cfa74ad140277f6abe86ba7feb', 'Senior Web Developer', 'Echo3 Pty. Ltd.', 'mayur@echo3.com.au', '042 127 5123', '039 428 3322', '039 428 3333', '20 Normanby Pl', 'Richmond', 7, 3121, '20 Normanby Pl', 'Richmond', 7, 3121, 'http://goo.gl/maps/CRC84', 'http://www.echo3.com.au/', 'http://www.echo3.com.au/login.php', 'http://www.linkedin.com/in/mayurmeshram', 'blank_b.jpg', 1, 0, 1),
(2, 'Yorick', 'Hopmans', 'yorick', 'e6ab6778f96ad3a6a99c2385b189d32eeccda665', 'Investment Manager and Stockbroker', 'Echo3', 'yorick@echo3.com.au', '0', '039 428 3322', '0', '20 Normanby Pl, Richmond, VIC, 3121', NULL, 7, NULL, '20 Normanby Pl, Richmond, VIC, 3121', NULL, 7, NULL, '', '', '', '', 'blank_b.jpg', 3, 4, 1),
(3, 'Glynnis', 'Owen', 'glynnis', '335d7e743348869894d1016ddf40fc8033a36013', '', '', 'glynnis@echo3.com.au', '0', '0', '0', '', NULL, 1, NULL, '', NULL, 1, NULL, '', '', '', '', '', 1, 0, 1),
(4, 'Susan', 'Elwood', 'susan@echo3.com.au', '1cccad312a93e7bcb844e1c16663eaedd161f739', '', 'Echo3 Pty. Ltd.', 'see@echo3.com.au', '0', '0', '0', '', NULL, 11, NULL, '', NULL, 11, NULL, '', '', '', '', '', 2, 0, 1),
(5, 'Broker 2', '', 'broker', 'c2f5b1b31eef631abcd6a5eb3d0767eb2097b2d1', NULL, NULL, 'mayur@echo3.com.au', '0', '0', '0', '', NULL, 11, NULL, '', NULL, 11, NULL, '', '', '', '', '', 3, 0, 1),
(6, 'Commonwealth Bank Australia', '(CBA)', 'cba_rep', 'b26e944c1a977fc9504dac963ce6a074110bb6c5', '', '', 'abc@test.com', '', '13 2221', '', '385 Bourke St  Melbourne, VIC 3000 ', NULL, 7, NULL, '385 Bourke St  Melbourne, VIC 3000 ', NULL, 7, NULL, 'https://maps.google.com.au/maps?q=385+Bourke+St+Melbourne,+VIC+3000&hnear=385+Bourke+St,+Melbourne+Victoria+3000&gl=au&t=m&z=16', 'http://www.commbank.com.au', '', 'http://www.linkedin.com/company/commonwealthbank', 'thumbs_cba.jpg', 4, 0, 1),
(7, 'Ainsley', 'Cutts', 'admin@allfreightfinance.com.au', '2114f663a608b2c05d6e071dbccf110882d953ed', 'General Manager', 'Allfreight Finance', 'ainsley@allfreightfinance.com.au', '0413111511', '0393059400', '0393053699', 'Ground Floor, 17 Stanley Drive', NULL, 7, NULL, '', NULL, 11, NULL, '', 'www.allfreightfinance.com.au', '', '', '', 2, 0, 1),
(8, 'Harold', 'Clapham', 'admin@mainlandfinance.com.au', 'c8a734f7963f3a93dd582d3704876c96c842ce7c', 'Managing Director', 'Mainland Finance', 'haroldc@mainlandfinance.com.au', '', '03 5881 7700', '03 5881 7677', '379 George St', NULL, 2, NULL, '', NULL, 11, NULL, '', 'www.mainlandfinance.com.au', '', '', '', 2, 0, 1),
(9, 'Michael', 'Pratt', 'admin@smecommercialfinance.com.au', 'bf39c5dc3c0809f59ff5265d9e79ee646531efe6', 'Managing Director', 'SME Commercial Finance', 'michael.pratt@smecommercialfinance.com.au', '', '03 9832 4477', '03 9832 7288', 'Level 5, 15-19 Claremont Street', NULL, 7, NULL, '', NULL, 11, NULL, '', 'www.smecommercialfinance.com.au', '', '', '', 2, 0, 1),
(10, 'Dennis', 'Horne', 'admin@moneyresources.com.au', 'fa899bbad4120bfbd7b9ba458bb2f0a42e8f4c56', 'Managing Director', 'Money Resources Group', 'dhorne@moneyresources.com.au', '0408 310 374', '03 8699 5008', '03 9690 9484', '2nd Floor, 18-22 Thomson St', 'South Melbourne', 7, 3205, '', '', 11, NULL, '', 'www.moneyresources.com.au', '', '', '', 2, 0, 1),
(11, 'Stephen', 'Bickford', 'admin@leasingconsultants.com.au', '107a31f7ce4234af37861a070905d7080ecb4ab4', 'Managing Director', 'Leasing Consultants', 'sbickford@leasingconsultants.com.au', '0438 393 066', '03 9521 1188', '03 9521 1166', 'Level 4, 606 St Kilda Rd', NULL, 7, NULL, '', NULL, 11, NULL, '', 'www.leasingconsultants.com.au', '', '', '', 2, 0, 1),
(12, 'Geoff', 'Schintler', 'admin@mainlandbendigo.com.au', 'edaca59c54d0c7ceda7324358924f5907eb5c71c', 'Administration Manager', 'Mainland Bendigo', 'geoffs@mainlandfinance.com.au', '', '03 5444 1995', '03 5881 1959', '114 Queen St', NULL, 7, NULL, 'P.O Box 2170', NULL, 7, NULL, '', 'www.mainlandfinance.com.au', '', '', '', 2, 0, 1),
(65, 'Ainsley', 'Cutts', 'ainsley@allfreightfinance.com.au', 'bbe1922c576e4cba2dddf24e4b3e7efd6628fc96', '', 'Allfreight Finance Brokers P/L', 'ainsley@allfreightfinance.com.au', '0413 111 511', '9305 9400', '9305 3699', 'Ground Floor, 17 Stanley Drive', 'Somerton', 7, 3062, '', '', 11, 0, '', 'www.allfreightfinance.com.au', '', '', '', 3, 7, 1),
(66, 'Andrew', 'Hadley', 'andrew@allfreightfinance.com.au', 'b5f293d46af44ddb5663c79b4baf7a0c2ddf903e', '', 'Outdoor Space Finance', 'andrew@allfreightfinance.com.au', '0437 258 832', '9305 9400', '9305 3699', '144 Bogong Ave', 'Invermay Park', 7, 3350, 'P.O Box 83BK', 'Black Hill', 7, 3350, '', '', '', '', '', 3, 7, 1),
(67, 'Donella', 'Cutts', 'donella@allfreightfinance.com.au', 'ddf159ed79432bfc2fa22ec058d817c40bb149f0', '', 'Allfreight Finance Brokers P/L', 'donella@allfreightfinance.com.au', '0433 002 211', '9305 9400', '9305 3699', 'Ground Floor, 17 Stanley Drive', 'Somerton', 7, 3062, '', '', 11, 0, '', 'www.allfreightfinance.com.au', '', '', '', 3, 7, 1),
(68, 'Jim', 'Chiodo   ', 'info@allfreightfinance.com.au', '1482f7adc7a0fd557fd8f7e7e70ee2862da88b43', '', 'Pheasant Investments P/L', 'info@allfreightfinance.com.au', '0412 327 407', '9305 9400', '9305 3699', 'Ground Floor, 17 Stanley Drive', 'Somerton', 7, 3062, '', '', 11, 0, '', '', '', '', '', 3, 7, 1),
(69, 'Patrick', 'O’Keefe', 'patrick@allfreightfinance.com.au', '0b5ad5e5561aa5c5a847fed0ade0412c065834cb', '', 'Mornington Peninsula Finance (Vic) P/L', 'patrick@allfreightfinance.com.au', '0433 002 204', '9791 9893', '9791 9392', 'Office 7, 11 Bryants Rd', 'Dandenong', 7, 3175, '', '', 11, 0, '', '', '', '', '', 3, 7, 1),
(70, 'Richard', 'O’Keeffe', 'richard@allfreightfinance.com.au', '29ceb55a2d0de81f778c7754b690fa400495ff42', '', 'Staaar Finance P/L', 'richard@allfreightfinance.com.au', '0410 667 523', '9791 9893', '9791 9392', 'Office 7, 11 Bryants Rd', 'Dandenong', 7, 3175, '', '', 11, 0, '', '', '', '', '', 3, 7, 1),
(71, 'Glenda', 'Boschert', 'glendab@capexfinance.com.au', '2cc322a8417ab22f3b24d00c6d8895889a389e92', '', 'Capex Finance P/L', 'glendab@capexfinance.com.au', '0412 958 833', '', '', 'Level 4, 606 St Kilda Rd', 'Melbourne', 7, 3004, 'P.O Box 6165 St Kilda Rd', 'Central Melbourne', 7, 3004, '', 'www.capexfinance.com.au', '', '', '', 3, 11, 1),
(72, 'John', 'Hatherley', 'johnh@equityfinanceaust.com.au', 'd529068dbada354f24d7a733227d00db73deca0f', '', 'Equity Finance Australia P/L', 'johnh@equityfinanceaust.com.au', '0417 317 276', '9521 2266', '9521 3322', 'Level 4, 606 St Kilda Rd', 'Melbourne', 7, 3004, 'P.O Box 6165 St Kilda Rd', 'Central Melbourne', 7, 3004, '', 'www.equityfinanceaust.com.au', '', '', '', 3, 11, 1),
(73, 'Jonathan', 'Walmsley', 'jwalmsley@leasingconsultants.com.au', 'c9cff0522dadf5c9543f43422ca082be0f9461cf', '', 'Pearl Leasing & Finance P/L', 'jwalmsley@leasingconsultants.com.au', '0418 514 804', '9521 1188', '9521 1166', 'Level 4, 606 St Kilda Rd', 'Melbourne', 7, 3004, 'P.O Box 6165 St Kilda Rd', 'Central Melbourne', 7, 3004, '', 'www.leasingconsultants.com.au', '', '', '', 3, 11, 1),
(74, 'Kym', 'Stoekel', 'kym@leasingconsultants.com.au', '86bd2bb1af32cc183430c353ab41b254812e7720', '', 'Leasing Consultants Australia P/L', 'kym@leasingconsultants.com.au', '0438 838 848', '9521 1188', '9521 1166', 'Level 4, 606 St Kilda Rd', 'Melbourne', 7, 3004, 'P.O Box 6165 St Kilda Rd', 'Central Melbourne', 7, 3004, '', 'www.leasingconsultants.com.au', '', '', '', 3, 11, 1),
(75, 'Robert', 'Williams', 'rob@leasingconsultants.com.au', '5e56e22e8bfc21f7c19dd3e35cdcee0590a4985d', '', 'Maitland Financial Services Group P/L', 'rob@leasingconsultants.com.au', '0412 304 005', '9521 1188', '9521 1166', 'Level 4, 606 St Kilda Rd', 'Melbourne', 7, 3004, 'P.O Box 6165 St Kilda Rd', 'Central Melbourne', 7, 3004, '', 'www.leasingconsultants.com.au', '', '', '', 3, 11, 1),
(76, 'Stephen', 'Bickford', 'sbickford@leasingconsultants.com.au', 'f235f492605db6cd2643c4148f32048a70bdae04', '', 'Leasing Consultants Australia P/L', 'sbickford@leasingconsultants.com.au', '0438 393 066', '9521 1188', '9521 1166', 'Level 4, 606 St Kilda Rd', 'Melbourne', 7, 3004, 'P.O Box 6165 St Kilda Rd', 'Central Melbourne', 7, 3004, '', 'www.leasingconsultants.com.au', '', '', '', 3, 11, 1),
(77, 'Trevor', 'Phillips', 'trevor@sourcefs.com.au', '7f42199db65ebe761f355c5bac054852aa96033c', '', 'Trevor R Phillips', 'trevor@sourcefs.com.au', '0418 502 541', '9008 0525', '9596 2219', '2 Hurlington St', 'Brighton East', 7, 3187, '', '', 11, 0, '', 'www.sourcefs.com.au', '', '', '', 3, 11, 1),
(79, 'Geoff', 'Ireland', 'geoffi@mainlandfinance.com.au', '4d633648165d42a951d34762538ae4018b4f16be', '', 'Aqua Nominees P/L', 'geoffi@mainlandfinance.com.au', '0414 492 706', '03 5444 1995', '035881 1959', '114 Queen St', 'Bendigo', 7, 3550, 'P.O Box 2170', 'Bendigo Mail Centre', 7, 3554, '', 'www.mainlandbendigo.com.au', '', '', '', 3, 12, 1),
(80, 'Joanne', 'De Bono', 'joanne@mainlandfinance.com.au', '14bceb4809c5c75dbbaee40567ccbf9a4e0bf8f7', '', 'Aqua Nominees P/L', 'joanne@mainlandfinance.com.au', '0422 816 845', '03 5444 1995', '035881 1959', '114 Queen St', 'Bendigo', 7, 3550, 'P.O Box 2170', 'Bendigo Mail Centre', 7, 3554, '', 'www.mainlandbendigo.com.au', '', '', '', 3, 12, 1),
(81, 'Pauline', 'Schintler', 'paulines@mainlandfinance.com.au', 'd65cec6f2de40a27ce8952954466f8099090670c', '', 'Aqua Nominees P/L  T/As Mainland Bendigo', 'paulines@mainlandfinance.com.au', '0438 510 430', '03 5444 1995', '035881 1959', '114 Queen St', 'Bendigo', 7, 3550, 'P.O Box 2170', 'Bendigo Mail Centre', 7, 3554, '', 'www.mainlandbendigo.com.au', '', '', '', 3, 12, 1),
(82, 'David', 'Cannon', 'davidc@mainlandfinance.com.au', '3afa50291f8fdade1a8e0753c59607652f4c62d7', '', 'DR & JC Cannon P/L', 'davidc@mainlandfinance.com.au', '0419 216 955', '02 6921 2344', '02 6921 2355', 'Suite 4, 2/185 Morgan St', 'Wagga Wagga', 2, 2650, 'P.O Box 5254', 'Wagga Wagga', 2, 2650, '', 'www.mainlandfinance.com.au', '', '', '', 3, 8, 1),
(83, 'Harold', 'Clapham', 'haroldc@mainlandfinance.com.au', '247e122ea3745c07a3be4843e28f5b64c938542d', '', 'Nargundi P/L   T/As Mainland Finance', 'haroldc@mainlandfinance.com.au', '0408 668 943', '03 5881 7700', '035881 7677', '379 George St', 'Deniliquin', 2, 2710, 'P.O Box 516', 'Deniliquin', 2, 2710, '', 'www.mainlandfinance.com.au', '', '', '', 3, 8, 1),
(84, 'Howard', 'Brown', 'howard@mainlandfinance.com.au', 'a8f2239350d32c93314461754e8b990893d8fd4b', '', 'Hem Finance P/L', 'howard@mainlandfinance.com.au', '0438 366 327', '02 6921 2344', '026921 2355', 'Suite 4, 2/185 Morgan St', 'Wagga Wagga', 2, 2650, 'P.O Box 5254', 'Wagga Wagga', 2, 2650, '', 'www.mainlandfinance.com.au', '', '', '', 3, 8, 1),
(85, 'Malcolm', 'Leggat', 'malcolml@mainlandfinance.com.au', 'dc28dd68e9ce3ae1e2591e5b70ec359322eb4be1', '', 'Mainland Finance Gunnedah', 'malcolml@mainlandfinance.com.au', '0427 445 262', '02 6742 6106', '02 6742 6108', '240a Conadilly St', 'Gunnedah', 2, 2380, 'P.O Box 614', 'Gunnedah', 2, 2380, '', 'www.mainlandfinance.com.au', '', '', '', 3, 8, 1),
(86, 'Stephen', 'Cook', 'stephen.cook@elders.com.au', '7f90b9a855546ee84bfeea6014e2fd35bdabcec8', '', 'Hem Finance P/L', 'stephen.cook@elders.com.au', '0412 694 360', '02 6921 6090', '026921 7318', '20 Tompson St', 'Wagga Wagga', 2, 2650, '', '', 11, 0, '', '', '', '', '', 3, 8, 1),
(87, 'Stephen', 'Wade', 'wadeincpl@bigpond.com', '4f8a1141e1bc3b83e32881bed8214577d2c7064c', '', 'Wadeinc P/L', 'wadeincpl@bigpond.com', '0410 645 325', '02 6582 5772', '02 6582 5772', '', '', 11, 0, 'P.O Box 9237', 'Port Macquarie', 2, 2444, '', '', '', '', '', 3, 8, 1),
(88, 'Wendy', 'Bolton', 'wendym@mainlandfinance.com.au', '3fc45c30bc041a65f448ac61caa0e874a5379b2f', '', 'Employee - Nargundi P/L', 'wendym@mainlandfinance.com.au', '0427 815 047', '03 5881 7700', '03 5881 7677', '379 George St', 'Deniliquin', 2, 2710, 'P.O Box 516', 'Deniliquin', 2, 2710, '', 'www.mainlandfinance.com.au', '', '', '', 3, 8, 1),
(89, 'Andrew', 'Reilly', 'andrew@krw.com.au', 'b5fc0e4347051e16220a8b27af41cf3e58fc22ac', '', 'KRW Partners P/L', 'andrew@krw.com.au', '0414 380 678', '1300 557 750', '1300 557 758', 'Suite 24/574 Plummer St', 'Port Melbourne', 7, 3207, '', '', 11, 0, '', 'www.krw.com.au', '', '', '', 3, 10, 1),
(90, 'Ashley', 'McLean', 'ashleymclean@sefinance.com.au', 'ac51c401817c56b9a90f983fa2289aaa3f4c86fd', '', 'Ashley McLean T/As AKM Financial Services P/L', 'ashleymclean@sefinance.com.au', '0407 503 275', '9584 0388', '9584 0399', '2/1253 Nepean Hwy', 'Cheltenham', 7, 3192, '', '', 11, 0, '', 'www.sefinance.com.au', '', '', '', 3, 10, 1),
(91, 'Barry', 'Lyncoln', 'lyngcolnlf@bigpond.com', '0c639e9abe29e5363721ca8e35bb912fa9fd4950', '', 'Lyngcoln Leasing & Finance P/L', 'lyngcolnlf@bigpond.com', '0418 374 747', '9717 1122', '9717 1123', '43 Orchard Rd', 'Doreen', 7, 3091, '', '', 11, 0, '', '', '', '', '', 3, 10, 1),
(92, 'Bob', 'Sheffield', 'bob@stiles-sheffield.com.au', 'dad21b073c8eb12eac153fd5f4a04743bb478d2c', '', 'Stifield Aust P/L', 'bob@stiles-sheffield.com.au', '0418 337 979', '9803 6622', '9803 6644', '5 Ruby St', 'Burwood East', 7, 3151, '', '', 11, 0, '', 'www.stiles-sheffield.com.au', '', '', '', 3, 10, 1),
(93, 'Carlo', 'Scarfi', 'mmf@aapt.com.au', '9fe6ac9aec9366c818c7e1ca3591ad7fc512ef77', '', 'Melbourne Medical Finance Ltd', 'mmf@aapt.com.au', '0408 121 679', '9349 5733', '9349 3622', 'Level 2, 766 Elizabeth St', 'Melbourne', 7, 3000, '', '', 11, 0, '', '', '', '', '', 3, 10, 1),
(94, 'Colin', 'Cooper', 'colin@austwidefinance.com.au ', 'bffe02614b2da2e9c73dd4d83e6eee3d3dac54f2', '', 'Australia Wide Finance & Leasing P/L', 'colin@austwidefinance.com.au ', '0428 367 327', '8699 5010', '9690 9484', '2nd Floor, 18-22 Thomson St', 'South Melbourne', 7, 3205, '', '', 11, 0, '', 'www.austwidefinance.com.au ', '', '', '', 3, 10, 1),
(95, 'Colin', 'McNamara', 'Colmac@moneyresources.com.au', '6bfbd5516513ed8c7f7f844171dfbecdd1eb5e3d', '', 'Hanleigh Lodge P/L', 'Colmac@moneyresources.com.au', '0418 179 870', '1300 935 674', '1300 935 634', '30 Seddon Drive', 'Narre Warren', 7, 3805, '', '', 11, 0, '', 'www.moneyresources.com.au', '', '', '', 3, 10, 1),
(96, 'Daniel', 'Di Conza', 'ddiconza@acceptancefinance.com.au', '2ae5fb180e397cc22814353b6b80e03e82aa38a3', '', 'Acceptance Finance P/L', 'ddiconza@acceptancefinance.com.au', '', '9854 3550', '9852 7333', 'Level 1, 35 Whitehorse Rd', 'Balwyn', 7, 3103, '', '', 11, 0, '', 'www.acceptancefinance.com.au', '', '', '', 3, 10, 1),
(97, 'David', 'Clark', 'david_ a_ clark@belgraviafinance.com', 'c8aeb5e0956f4566344cf22f3c59369895568f09', '', 'Belgravia Finance P/L', 'david_ a_ clark@belgraviafinance.com', '0417 289 656', '9941 3138', '9941 3133', 'Level 2, 70 Park St', 'South Melbourne', 7, 3205, '', '', 11, 0, '', 'www.belgraviafinance.com', '', '', '', 3, 10, 1),
(98, 'David', 'Jakimiuk', 'mail@creditlinkaustralia.com.au', '40d2eae329935faf25b12eb78106ddb16fec0035', '', 'Creditlink P/L', 'mail@creditlinkaustralia.com.au', '0417 363 720', '', '9678 3922', '1355 High St', 'Malbern', 7, 3144, '', '', 11, 0, '', 'www.creditlinkaustralia.com.au', '', '', '', 3, 10, 1),
(99, 'Dennis', 'Horne', 'dhorne@moneyresources.com.au', 'ed5f658bc2d5c8052bf643f54736417f8a59005d', '', 'Money Resources Finance P/L', 'dhorne@moneyresources.com.au', '0408 310 374', '8699 5008', '9690 9484', '2nd Floor, 18-22 Thomson St', 'South Melbourne', 7, 3205, '', '', 11, 0, '', 'www.moneyresources.com.au', '', '', '', 3, 10, 1),
(100, 'Don', 'Ross', 'moneylenders@telstra.com', 'c26a923400f5be2ae1e2ba7c7bcbbdd5e41e68b4', '', 'D&H Ross P/L T/A The Money Lenders', 'moneylenders@telstra.com', '0418 361 333', '9852 1833', '9852 2033', 'Level 4, 8 Greenaway St', 'Bulleen', 7, 3105, '', '', 11, 0, '', '', '', '', '', 3, 10, 1),
(101, 'Graeme', 'McDonald', 'graeme@moneyresources.com.au', '89aeed21b9c74241bed0fb6806a7adf8250191f6', '', 'G MC Financial Services P/L', 'graeme@moneyresources.com.au', '0401 189 160', '8699 5011', '9690 9484', '2nd Floor, 18-22 Thomson St', 'South Melbourne', 7, 3205, '', '', 11, 0, '', 'www.moneyresources.com.au', '', '', '', 3, 10, 1),
(102, 'Graham', 'Liddy', 'graham@capitalaccess.net.au', '13aa7bab068669db8f7ff63480b4e1d957963f48', '', 'Austwide Leasing P/L', 'graham@capitalaccess.net.au', '0418 310 109', '9888 6411', '9888 5633', '16/333 Canterbury Rd', 'Canterbury', 7, 3126, '', '', 11, 0, '', 'www.capitalaccess.net.au', '', '', '', 3, 10, 1),
(103, 'Harry', 'Anderson', 'anderson@leaseline.com.au', '9fc61b52f30d580ba02a3fa81d5b11288b88f438', '', 'Leaseline Financial Services P/L', 'anderson@leaseline.com.au', '0418 329 103', '9867 3955', '9866 3147', 'Suite 10, 456 St Kilda Rd ', 'Melbourne', 7, 3004, '', '', 11, 0, '', 'www.leaseline.com.au', '', '', '', 3, 10, 1),
(104, 'Howard', 'Paraman', 'paraman13@optusnet.com.au', 'e83b3e75884672e225115576d8b0489bbf614b8e', '', 'Common Sense Solutions P/L', 'paraman13@optusnet.com.au', '0428 825 069', '9726 2050', '9720 1594', '12/603 Boronia Rd', 'Wantirna', 7, 3152, '', '', 11, 0, '', '', '', '', '', 3, 10, 1),
(105, 'Jamie', 'Hannah', 'jamiehannah@bigpond.com', '31fa2b37def9a7de142ea830fc67b416060c1741', '', 'Plant & Equipment Finance P/L', 'jamiehannah@bigpond.com', '0419 317 480', '9726 2050', '9720 1594', '5 Ruby St', 'Burwood East', 7, 3151, '', '', 11, 0, '', '', '', '', '', 3, 10, 1),
(106, 'Joe', 'Terlato', 'jterlato@acceptancefinance.com.au', '225e3146bbd54d11cf630e1ca67e3feb9f76cfda', '', 'Acceptance Finance P/L', 'jterlato@acceptancefinance.com.au', '0412 317 250', '9854 3550', '9852 7333', 'Level 1, 35 Whitehorse Rd', 'Balwyn', 7, 3103, '', '', 11, 0, '', 'www.acceptancefinance.com.au', '', '', '', 3, 10, 1),
(107, 'John', 'Murphy', 'johnmurphy@moneyresources.com.au', '2547fddc88ab9db15a74698a4780f0c3466994c9', '', 'Ireaus Finance P/L', 'johnmurphy@moneyresources.com.au', '0418 373 490', '9854 3586', '9852 7333', 'Level 1, 35 Whitehorse Rd', 'Balwyn', 7, 3103, '', '', 11, 0, '', 'www.moneyresources.com.au', '', '', '', 3, 10, 1),
(108, 'Ken', 'Pattison', 'kenpattison@sefinance.com.au', '6697ff2ac7aeda771311cd111978d4eb5ce69760', '', 'SE Finance P/L ', 'kenpattison@sefinance.com.au', '0414 679 627', '9584 0388', '9584 0399', '2/1253 Nepean Hwy', 'Cheltenham', 7, 3192, '', '', 11, 0, '', 'www.sefinance.com.au', '', '', '', 3, 10, 1),
(109, 'Linden', 'Hope', 'lhope@money resources.com.au', 'e706ea4eb8360a8682dad6b0a4cc1af9ba57f979', '', 'Linden Hope P/L', 'lhope@money resources.com.au', '0409 700 160', '8699 5005', '9690 9484', '2nd Floor, 18-22 Thomson St', 'South Melbourne', 7, 3205, '', '', 11, 0, '', 'www.moneyresources.com.au', '', '', '', 3, 10, 1),
(110, 'Malcolm', 'Hall', 'amhfinance@optusnet.com.au', '92f688c73b1407792460b919010f53151e0da35e', '', 'AMH Vehicle & Equipment Finance P/L', 'amhfinance@optusnet.com.au', '0432 276 506', '9440 8222', '9440 6622', '66 Porter Rd', 'Heidelberg Heights', 7, 3081, '', '', 11, 0, '', '', '', '', '', 3, 10, 1),
(111, 'Mark', 'Walsh', 'mark@belgraviafinance.com', '06379ccb8af1efb3b4b6dc6554b94be4776234bb', '', 'Belgravia Finance P/L', 'mark@belgraviafinance.com', '0457 264 627', '9941 3111', '9941 3133', 'Level 2, 70 Park St', 'South Melbourne', 7, 3205, '', '', 11, 0, '', 'www.belgraviafinance.com', '', '', '', 3, 10, 1),
(112, 'Martin', 'Stenhouse', 'martin@moneyresources.com.au', '3f783c89b879ed24035c554b065337c29902e60f', '', 'Deemar Financial ServiceP/L', 'martin@moneyresources.com.au', '0412 318 034', '8699 5003', '9690 9484', '2nd Floor, 18-22 Thomson St', 'South Melbourne', 7, 3205, '', '', 11, 0, '', 'www.moneyresources.com.au', '', '', '', 3, 10, 1),
(113, 'Michael', 'Lowden', 'michael@moneyresources.com.au', '8f699bd216b82ce059f215882ba19564eafa672e', '', 'Bellchoice P/L', 'michael@moneyresources.com.au', '0418 101 291', '8699 5006', '9690 9484', '2nd Floor, 18-22 Thomson St', 'South Melbourne', 7, 3205, '', '', 11, 0, '', 'www.moneyresources.com.au', '', '', '', 3, 10, 1),
(114, 'Mike', 'Stiles', 'mike@stiles-sheffield.com.au', '80959d0c5caaae04f52a9f293a034239b7270474', '', 'Stifield Aust P/L', 'mike@stiles-sheffield.com.au', '0418 337 979', '9803 6622', '9803 6644', '5 Ruby St', 'Burwood East', 7, 3151, '', '', 11, 0, '', 'www.stiles-sheffield.com.au', '', '', '', 3, 10, 1),
(115, 'Ray', 'McNamara', 'raymac@moneyresources.com.au', '236ec6ce7807a5706ecc5a17e3a3d813961da88d', '', 'Hanleigh Lodge P/L', 'raymac@moneyresources.com.au', '0408 331 375', '1300 935 674', '1300935634', '30 Seddon Drive', 'Narre Warren', 7, 3805, '', '', 11, 0, '', 'www.moneyresources.com.au', '', '', '', 3, 10, 1),
(116, 'Reg', 'Seit', 'reg.seit@regentfinance.com.au', '1bbd17982128d7ba2da3884a9bf7061ce70ace1b', '', 'Regent Finance (Aust) P/L', 'reg.seit@regentfinance.com.au', '0418 315 915', '9480 2000', '9484 4474', '157 Plenty Road', 'Preston', 7, 3072, '', '', 11, 0, '', 'www.regentfinance.com.au', '', '', '', 3, 10, 1),
(117, 'Rick', 'Kowalski', 'rick@krw.com.au', '3ea631b94b69cee590f8b21136070b6e0a0e0b92', '', 'KRW Partners P/L', 'rick@krw.com.au', '0425 853 213', '1300 557 750', '1300 557 758', 'Suite 24/574 Plummer St', 'Port Melbourne', 7, 3207, '', '', 11, 0, '', 'www.moneyresources.com.au', '', '', '', 3, 10, 1),
(118, 'Ron', 'Chowanetz ', 'ronc@moneyresources.com.au', 'f194a150b066c41415b4e88dd7f882d8351ecee1', '', 'Anroka P/L', 'ronc@moneyresources.com.au', '0412 534 503', '1300 935 674', '1300 935 634', '30 Seddon Drive ', 'Narre Warren', 7, 3805, '', '', 11, 0, '', 'www.moneyresources.com.au', '', '', '', 3, 10, 1),
(119, 'Ron', 'Wiber', 'ron@belgraviafinance.com', 'bad0820bdca9f85e706eee95b826a6c3c02dae48', '', 'Belgravia Finance P/L', 'ron@belgraviafinance.com', '', '9941 3111', '9941 3133', 'Level 2, 70 Park St', 'South Melbourne', 7, 3205, '', '', 11, 0, '', 'www.belgraviafinance.com', '', '', '', 3, 10, 1),
(120, 'Stephen', 'Hall', 'stevehall@moneyresources.com.au', '833df9b42a6e879d7c2b2bf7fd81e9268f381f93', '', 'Money Resources Credit P/L', 'stevehall@moneyresources.com.au', '0418 536 873', '8699 5007', '9690 9484', '2nd Floor, 18-22 Thomson St', 'South Melbourne', 7, 3205, '', '', 11, 0, '', 'www.moneyresources.com.au', '', '', '', 3, 10, 1),
(121, 'Stephen', 'Ryan', 'steveryan@sefinance.com.au', 'fc27c58c6a6b2a772d0873f8e9bbc14131bc0757', '', 'SE Finance P/L ', 'steveryan@sefinance.com.au', '0412 990 788', '9584 0388', '9584 0399', '2/1253 Nepean Hwy', 'Cheltenham', 7, 3192, '', '', 11, 0, '', 'www.sefinance.com.au', '', '', '', 3, 10, 1),
(122, 'Tony', 'Bryant', 'bryant@leaseline.com.au', '12af3f2ec266beed21063effb7e97c692e905208', '', 'Leaseline Financial Services P/L', 'bryant@leaseline.com.au', '0418 993 475', '9867 3955', '9866 3147', 'Suite 10, 456 St Kilda Rd ', 'Melbourne', 7, 3004, '', '', 11, 0, '', 'www.leaseline.com.au', '', '', '', 3, 10, 1),
(123, 'Michael', 'Pratt', 'michael.pratt@smecommercialfinance.com.au', 'ae858dcf02c4a265d86c90b74016af578236d452', '', 'SME Commercial', 'michael.pratt@smecommercialfinance.com.au', '0417 335 488', '9827 4477', '9827 7288', 'Level 5, 15-19 Claremont Street', 'South Yarra', 7, 3142, '', '', 11, 0, '', 'www.smecommercialfinance.com.au', '', '', '', 3, 9, 1),
(124, 'Ken', 'McLean', 'kmclean@smecommercialfinance.com.au', 'ad0c028b36ce88bcb3c5055b3627b2987b73ad16', '', 'SME Commercial', 'kmclean@smecommercialfinance.com.au', '0417 537 891', '9827 4477', '9827 7288', 'Level 5, 15-19 Claremont Street', 'South Yarra', 7, 3143, '', '', 11, 0, '', 'www.smecommercialfinance.com.au', '', '', '', 3, 9, 1),
(125, 'David', 'Williams', 'dwilliams@smecommercialfinance.com.au', '000a8c8a0425ecbfa24054dfa82de2a375b97071', '', 'SME Commercial', 'dwilliams@smecommercialfinance.com.au', '0414 919 192', '9827 4477', '9827 7288', 'Level 5, 15-19 Claremont Street', 'South Yarra', 7, 3144, '', '', 11, 0, '', 'www.smecommercialfinance.com.au', '', '', '', 3, 9, 1),
(126, 'Derham', 'Stewart', 'dstewart@smecommercialfinance.com.au', '83dc51294ae562dd9ce8e2f40790eb1f48dbd342', '', 'SME Commercial', 'dstewart@smecommercialfinance.com.au', '0412 888 288', '9827 4477', '9827 7288', 'Level 5, 15-19 Claremont Street', 'South Yarra', 7, 3145, '', '', 11, 0, '', 'www.smecommercialfinance.com.au', '', '', '', 3, 9, 1),
(127, 'Len', 'Fuller', 'lfuller@smecommercialfinance.com.au', '6ee1e9091c84356715e451924715d6a230cfb36a', '', 'SME Commercial', 'lfuller@smecommercialfinance.com.au', '0419 592 004', '9827 4477', '9827 7288', 'Level 5, 15-19 Claremont Street', 'South Yarra', 7, 3146, '', '', 11, 0, '', 'www.smecommercialfinance.com.au', '', '', '', 3, 9, 1),
(128, 'Mario', 'Stepancic', 'mstepancic@smecommercialfinance.com.au', '017177de1811c5d98240e6121290ed946691cfa5', '', 'SME Commercial', 'mstepancic@smecommercialfinance.com.au', '', '9827 4477', '9827 7288', 'Level 5, 15-19 Claremont Street', 'South Yarra', 7, 3147, '', '', 11, 0, '', 'www.smecommercialfinance.com.au', '', '', '', 3, 9, 1),
(129, 'Michael', 'Johns', 'mjohns@aquilacorporate.com.au', '67718ec3460182cccfd45413844c915999b85445', '', 'SME Commercial', 'mjohns@aquilacorporate.com.au', '0402 990 775', '9827 4477', '9827 7288', 'Level 5, 15-19 Claremont Street', 'South Yarra', 7, 3148, '', '', 11, 0, '', 'www.aquilacorporate.com.au', '', '', '', 3, 9, 1),
(130, 'Leanne', 'Walsh', 'leanne@collegecapital.com.au', '57ec6bc66b684693d2de7463792b39c665233acd', '', 'College Capital', 'leanne@collegecapital.com.au', '', '', '', '', '', 11, NULL, '', '', 11, NULL, '', '', '', '', '', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_statuses`
--

CREATE TABLE IF NOT EXISTS `user_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_statuses`
--

INSERT INTO `user_statuses` (`id`, `status`) VALUES
(1, 'Active'),
(2, 'Inactive');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_category_id` FOREIGN KEY (`category_id`) REFERENCES `documents_categories` (`id`);

--
-- Constraints for table `faqs`
--
ALTER TABLE `faqs`
  ADD CONSTRAINT `faqs_category_id` FOREIGN KEY (`category_id`) REFERENCES `faqs_categories` (`id`);

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_category_id` FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`);

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_category_id` FOREIGN KEY (`category_id`) REFERENCES `pages_categories` (`id`);

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_category_id` FOREIGN KEY (`category_id`) REFERENCES `teams_categories` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `user_group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `user_status_id` FOREIGN KEY (`status_id`) REFERENCES `user_statuses` (`id`);