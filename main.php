<?php
// Auto Load
require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );

if( get_instance()->setup->is_installed() ) {
	require dirname( __FILE__ ) . '/inc/helpers.php';
	require dirname( __FILE__ ) . '/inc/controller.php';
	require dirname( __FILE__ ) . '/inc/tours.php';
	require dirname( __FILE__ ) . '/inc/cron.php';
}

require dirname( __FILE__ ) . '/inc/install.php';

class Nexo extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		
		$this->events->add_action( 'load_dashboard_home', array( $this, 'init' ) );
		$this->events->add_action( 'dashboard_header', array( $this, 'header' ) );
		
		$this->events->add_filter( 'default_js_libraries', function( $libraries ){
			foreach( $libraries as $key => $lib ){
				if( in_array( $lib, array( '../plugins/jQueryUI/jquery-ui-1.10.3.min' ) ) ){ // '../plugins/jQuery/jQuery-2.1.4.min', 
					unset( $libraries[ $key ] );
				}
			}
			$libraries	=	array_values( $libraries );
			return $libraries;
		});
		
		$this->events->add_action( 'load_dashboard', array( $this, 'dashboard' ) );
		$this->events->add_action( 'dashboard_footer', array( $this, 'footer' ) );
		$this->events->add_action( 'after_app_init', array( $this, 'after_app_init' ) );
		$this->events->add_filter( 'nexo_daily_details_link', array( $this, 'remove_link' ), 10, 2 );
		$this->events->add_action( 'load_frontend', array( $this, 'load_frontend' ) );
		
		// For codebar
		if( ! is_dir( 'public/upload/codebar' ) ) {
			mkdir( 'public/upload/codebar' );
		}
		
		define( 'NEXO_CODEBAR_PATH', 'public/upload/codebar/' );
	}
	
	/**
	 * Front End
	 *
	 * @return void
	**/
	
	public function load_frontend()
	{
		// Prevent Frontend display
		redirect( array( 'dashboard' ) );
	}
		
	/**
	 * After APP init
	 *
	 * @return void
	**/
	
	public function after_app_init()
	{
		global $Options;

		$this->lang->load( '../../modules/nexo/language/nexo_lang' );
	}
	
	/**
	 * Display text on footer
	 * 
	 * @return void
	**/
	
	public function footer()
	{
		?>
        <style type="text/css">
		.flexigrid div.form-div input[type=text], .flexigrid div.form-div select, .flexigrid div.form-div textarea,
		.datatables div.form-div input[type=text], .datatables div.form-div select, .datatables div.form-div textarea {
			font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
			font-weight: normal;
			line-height: 35px;
			height: 40px;
			font-size: 28px;
			vertical-align: middle;
			width:100%;
		}
		#AUTHOR_field_box { display:none; }
		#TYPE_field_box { display:none; }
		</style>
        <?php
	}
	
	/**
	 * Check Whether Grocery Module is active
	 *
	 * @return void
	**/
	
	public function dashboard()
	{
		$escapeAds 	=	$this->events->apply_filters( 'nexo_escape_nexoadds', Modules::is_active( 'nexoads' ) );
		if( ! Modules::is_active( 'grocerycrud' ) || $escapeAds == false ) {
			Modules::disable( 'nexo' );
			redirect( array( 'dashboard', 'modules?highlight=Nexo&notice=error-occured' ) );
		}
	}
	
	/**
	 * Add custom styles and scripts
	 *
	 * @return void
	**/
	
	public function header()
	{
		/** 
		 * <script type="text/javascript" src="<?php echo js_url( 'nexo' ) . 'jsapi.js';?>"></script>
		**/
		?>
        <link rel="stylesheet" href="<?php echo css_url( 'nexo' ) . 'jquery-ui.css';?>">
		<script src="<?php echo js_url( 'nexo' ) . 'jquery-ui.min.js';?>"></script>
        <script src="<?php echo module_url( 'nexo' ) . '/bower_components/Chart.js/Chart.min.js';?>"></script>
        <script src="<?php echo module_url( 'nexo' ) . '/js/html5-audio-library.js';?>"></script>
        <script type="text/javascript">
		Number.prototype.format = function(n, x, s, c) {
			var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
				num = this.toFixed(Math.max(0, ~~n));
		
			return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
		};
		var NexoAPI			=	new Object();
			NexoAPI.Format	=	function( int ){
				return int.format( 2, 3, '.', ',' )
			}
		var NexoSound		=	'<?php echo asset_url( '/modules/nexo/sound/sound-' );?>';
		</script>
        <?php
	}
	
	/**
	 * Register Widgets
	 *
	 * @return void
	**/
	
	public function init()
	{
		$this->dashboard_widgets->add( 'ventes_annuelles', array(
			'title'	=> __( 'Nombres de commandes journalières', 'nexo' ),
			'type'	=> 'box-primary',
			// 'background-color'	=>	'',
			'position'	=> 1,
			'content'	=>	$this->load->view( '../modules/nexo/inc/widgets/sales.php', array(), true )
		) );
		
		$this->dashboard_widgets->add( 'chiffre_daffaire_net', array(
			'title'	=> __( 'Chiffre d\'affaire journalier', 'nexo' ),
			'type'	=> 'box-primary',
			// 'background-color'	=>	'',
			'position'	=> 1,
			'content'	=>	$this->load->view( '../modules/nexo/inc/widgets/chiffre-daffaire-net.php', array(), true )
		) );
	}
	
	/**
	 * Add link to premium version
	**/
	
	function remove_link( $link )
	{
		return 'http://nexo.tendoo.org/get-premium';
	}
}
new Nexo;