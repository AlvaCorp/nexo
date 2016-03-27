<?php
// Bon d'voir @since 2.1
$this->db->query( 'ALTER TABLE `'.$this->db->dbprefix.'nexo_bon_davoir` ADD `MONTANT` INT NOT NULL AFTER `REF_CLIENT`;' );