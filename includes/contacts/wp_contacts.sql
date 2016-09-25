--
-- Table structure for table `wp_contacts`
--
CREATE TABLE IF NOT EXISTS `wp_contacts` (
  `contact_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `message` text COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

INSERT INTO `wp_contacts` 
		(`name`, `email`, `phone`, `message`, `date`) VALUES 
		('sh1', 'sh1@yahoo.com', '878', 'msg...', '2016-09-21 11:00:00'),
		('sh2', 'sh2@yahoo.com', '878', 'msg...', '2016-09-22 12:00:00'),
		('sh3', 'sh3@yahoo.com', '878', 'msg...', '2016-09-23 13:00:00')
		;