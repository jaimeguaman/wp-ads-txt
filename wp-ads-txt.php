<?php
/*
Plugin Name: WP ADS.txt
Plugin URI: https://github.com/jaimeguaman/wp-ads-txt
Description: manage ADS.txt content from Admin
Version: 0.1
Author: Jaime Guaman
Author URI: http://guaman.cl
*/

add_action( 'admin_menu', 'add_admin_menu' );
add_action( 'admin_init', 'settings_init' );

function add_admin_menu() {
	add_menu_page( 'ADS.txt', 'ADS.txt', 'manage_options', 'adstxt', 'adstxt_options_page' );
}

function settings_init() {

	register_setting( 'pluginPage', 'adstxt_settings' );

	add_settings_section(
		'adstxt-general',
		__( 'Administrar contenido', 'ads-txt' ),
		'adstxt_settings_section_callback',
		'pluginPage'
	);

	add_settings_field(
		'adstxt_ads_txt',
		__( 'ADS.txt', 'ads-txt' ),
		'adstxt_ads_txt_render',
		'pluginPage',
		'adstxt-general'
	);
}

function adstxt_ads_txt_render() {
	$options = get_option( 'adstxt_settings' );
	?>
	<textarea cols='40' rows='10' name='adstxt_settings[adstxt_ads_txt]'><?php echo $options['adstxt_ads_txt']; ?></textarea>
	<?php
}


function adstxt_settings_section_callback(  ) {
	echo __( 'Aquí puedes administrar el contenido de tu ads.txt', 'ads-txt' );
}

function adstxt_options_page() {
	?>
  <p> Para más información sobre ads.txt <a href="https://iabtechlab.com/ads-txt/">consulta la documentación oficial</a>
	<form action='options.php' method='post'>
		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>
	</form>
	<?php
}

add_action( 'template_redirect', 'check_for_ads_txt' );

function check_for_ads_txt(){
  if ($_SERVER['REQUEST_URI'] == '/ads.txt') {
    global $wp_query;
    $wp_query->is_404 = false;
    status_header(200);
    $options = get_option( 'adstxt_settings' );
    echo $options['adstxt_ads_txt'];
    exit();
  }
}

?>
