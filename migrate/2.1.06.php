<?php
// SKU @since 2.1.06
$this->db->query( 'ALTER TABLE `'.$this->db->dbprefix.'nexo_articles` CHANGE `SKU` `SKU` VARCHAR(200) NOT NULL;' );