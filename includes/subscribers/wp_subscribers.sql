--
-- Table structure for table `wp_subscribers`
--
CREATE TABLE IF NOT EXISTS `wp_subscribers` (
  `subscriber_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`subscribe_id`),
  KEY `email` (`email`(10))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

INSERT INTO `wp_subscribers` (`email`, `date`, `active`) VALUES 
								('email1@whale.com', '2016-09-01 00:00:00', '1'),
								('email2@whale.com', '2016-09-01 00:00:00', '1'),
								('email3@whale.com', '2016-09-01 00:00:00', '1'),
								('email4@whale.com', '2016-09-01 00:00:00', '1'),
								('email5@whale.com', '2016-09-01 00:00:00', '1')
								;