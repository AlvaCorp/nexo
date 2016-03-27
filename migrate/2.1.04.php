<?php
// SKU @since 2.1.04
$this->db->query( 'ALTER TABLE `'.$this->db->dbprefix.'nexo_articles` ADD `SKU` INT NOT NULL AFTER `REF_CATEGORIE`;' );