<?php
class Nexo_Clients extends CI_Model
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
		if( ! User::can( 'manage_shop' ) ) : redirect( array( 'dashboard', 'access-denied?from=Nexo_client_controller' ) ); endif;
		
		$crud = new grocery_CRUD();
		$crud->set_subject( 'Clients' );
		$crud->set_table( $this->db->dbprefix( 'nexo_clients' )  );
		$crud->set_theme('bootstrap');
		$crud->columns( 'NOM', 'PRENOM', 'OVERALL_COMMANDES', 'TEL', 'EMAIL' );
		$crud->fields( 'NOM', 'PRENOM', 'EMAIL', 'TAILLE', 'PREFERENCE', 'TEL', 'DATE_NAISSANCE', 'ADRESSE', 'DESCRIPTION' );
		
		$crud->display_as('NOM', __( 'Nom du client', 'nexo' ) );
		$crud->display_as('EMAIL', __( 'Email du client', 'nexo' ) );
		$crud->display_as('OVERALL_COMMANDES', __( 'Nombre de commandes' , 'nexo' ) );
		$crud->display_as('NBR_COMMANDES', __( 'Nbr Commandes (sess courante)', 'nexo' ) );
		$crud->display_as('TEL', __( 'Téléphone du client', 'nexo' ) );
		$crud->display_as('PRENOM', __( 'Prénom du client', 'nexo' ) );
		$crud->display_as('PREFERENCE', __( 'Préférence du client', 'nexo' ) );
		$crud->display_as('DATE_NAISSANCE', __( 'Date de naissance', 'nexo' ) );
		$crud->display_as('ADRESSE', __( 'Adresse', 'nexo' ) );
		$crud->display_as('TAILLE', __( 'Taille', 'nexo' ) );
		
		$crud->required_fields( 'NOM' );
		
		$crud->set_rules('EMAIL',__( 'Email', 'nexo' ),'valid_email');
	 
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
		$_var1					=	'clients';		
				$this->Gui->set_title( __( 'Liste des clients &mdash; Nexo', 'nexo' ) );
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}
	
	function add()
	{		
		$data[ 'crud_content' ]	=	$this->crud_header();
		$_var1					=	'clients';
				$this->Gui->set_title( __( 'Ajouter un nouveau client &mdash; Nexo', 'nexo' ) );
		$this->load->view( '../modules/nexo/views/' . $_var1 . '-list.php', $data );
	}
	
	function defaults()
	{
		$this->lists();
	}
}
new Nexo_Clients( $this->args );