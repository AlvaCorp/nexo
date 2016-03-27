<?php
class Nexo_Categories extends CI_Model
{
	function __construct( $args )
	{
		parent::__construct();
		if( is_array( $args ) && count( $args ) > 1 ) {
			if( method_exists( $this, $args[1] ) ){
				return $this->$args[1]( array_slice( $args, 2 ) );
			} else {
				return $this->defaults();
			}			
		}
		return $this->defaults();
	}
	
	function crud_header()
	{
		// Protecting
		if( ! User::can( 'manage_categories' ) ) : redirect( array( 'dashboard', 'access-denied?from=nexo_categories_controller' ) ); endif;
		
		$crud = new grocery_CRUD();

		$crud->set_theme('bootstrap');
		$crud->set_subject( 'Catégories' );	

		$crud->set_table( $this->db->dbprefix( 'nexo_categories' )  );
		$crud->columns( 'NOM',  'PARENT_REF_ID', 'DESCRIPTION' );
		$crud->fields( 'NOM', 'PARENT_REF_ID', 'DESCRIPTION' );
		$crud->set_relation( 'PARENT_REF_ID', 'nexo_categories','NOM');
		
		$crud->display_as('NOM','Nom de la catégorie');
		$crud->display_as('DESCRIPTION','Description');
		$crud->display_as('PARENT_REF_ID','Catégorie parente');
		
		$crud->required_fields( 'NOM' );
		
		$crud->unset_jquery();
		$output = $crud->render();
		
		foreach( $output->js_files as $files ) {
			$this->enqueue->js( substr( $files, 0, -3 ), '' );
		}
		foreach( $output->css_files as $files ) {
			$this->enqueue->css( substr( $files, 0, -4 ), '' );
		}
		
		return $output;
	}
	
	function lists()
	{
		$data[ 'crud_content' ]	=	$this->crud_header();
		$_var1					=	'categories';		
				$this->Gui->set_title( __( 'Liste des catégories &mdash; Nexo', 'nexo' ) );
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}
	
	function add()
	{		
		$data[ 'crud_content' ]	=	$this->crud_header();
		$_var1					=	'categories';
				$this->Gui->set_title( __( 'Créer une nouvelle catégorie &mdash; Nexo', 'nexo' ) );
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}	
	
	function defaults()
	{
		$this->lists();
	}
}
new Nexo_Categories( $this->args );