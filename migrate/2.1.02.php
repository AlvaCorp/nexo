<?php
// Bon d'voir @since 2.1
$this->db->query( 'ALTER TABLE `'.$this->db->dbprefix.'nexo_bon_davoir` ADD `REF_PRODUCT_CODEBAR` INT NOT NULL AFTER `MONTANT`;' );