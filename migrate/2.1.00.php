<?php
// Bon d'voir @since 2.1
$this->db->query( 'CREATE TABLE IF NOT EXISTS `'.$this->db->dbprefix.'nexo_bon_davoir` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `RAISON` varchar(200) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `TYPE` varchar(200) NOT NULL,
  `COMMANDE_REF_ID` int(11) NOT NULL,
  `ARTICLE_CODEBAR` int(11) NOT NULL,
  `DATE_CREATION` datetime NOT NULL,
   `DATE_MOD` datetime NOT NULL,
  `AUTHOR` int(11) NOT NULL,  
  `REF_CLIENT` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;' );