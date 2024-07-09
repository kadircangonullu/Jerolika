-- --------------------------------------------------------

-- 
-- Table structure for table `avatarchat_profileviews`
-- 

CREATE TABLE `avatarchat_profileviews` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(250) NOT NULL,
  `viewed` varchar(250) NOT NULL,
  `visited` varchar(25) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; 

-- --------------------------------------------------------

-- 
-- Table structure for table `avatarchat_referrals`
-- 

CREATE TABLE `avatarchat_referrals` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(250) NOT NULL,
  `referred` varchar(250) NOT NULL,
  `joinIP` varchar(250) NOT NULL,
  `joindate` varchar(250) NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; 

-- --------------------------------------------------------

-- 
-- Alter table structure for table `avatarchat_user`
-- 

ALTER TABLE  `avatarchat_user` 
ADD  `vipStart` VARCHAR( 100 ) NOT NULL DEFAULT '0' AFTER  `vip` ,
ADD  `vipEnd` VARCHAR( 100 ) NOT NULL DEFAULT '0' AFTER  `vipStart` ,
ADD  `vipsubscrid` VARCHAR( 50 ) NOT NULL DEFAULT '0' AFTER  `vipEnd`,
ADD  `roomMaxStart` VARCHAR( 100 ) NOT NULL DEFAULT  '0' AFTER  `roommax` ,
ADD  `roomMaxEnd` VARCHAR( 100 ) NOT NULL DEFAULT  '0' AFTER  `roomMaxStart` ,
ADD  `roommaxsubscrid` VARCHAR( 50 ) NOT NULL DEFAULT  '0' AFTER  `roomMaxEnd`;

ALTER TABLE  `avatarchat_user` CHANGE  `avatar`  `avatar` VARCHAR( 1000 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

-- --------------------------------------------------------
