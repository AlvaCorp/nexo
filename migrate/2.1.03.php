<?php
// Bon d'voir @since 2.1.03
$this->db->query( 'CREATE TABLE IF NOT EXISTS `'.$this->db->dbprefix.'nexo_newsletter` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITRE` varchar(200) NOT NULL,
  `CONTENT` text NOT NULL,
  `DATE_CREATION` datetime NOT NULL,
   `DATE_MOD` datetime NOT NULL,
  `AUTHOR` int(11) NOT NULL,  
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;' );