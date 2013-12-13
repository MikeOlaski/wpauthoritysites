<?php
!defined( 'ABSPATH' ) ? exit : '';

$virtual_template = new SiteTemplate( 'site' );

class SiteTemplate
{   
    private $pt;
    private $url;
    private $path;
	private $settings;

    /**
     * Construct 
     *
     * @return void
     **/
    public function __construct( $pt )
    {       
        $this->pt = $pt;
        $this->url = PLUGINURL;
        $this->path = PLUGINPATH;
		$this->settings = get_option('awp_settings');
        add_action( 'init', array( $this, 'init_all' ) );
    }

    /**
     * Dispatch general hooks
     *
     * @return void
     **/
    public function init_all(){
		add_action( 'wp_enqueue_scripts',   array( $this, 'frontend_scripts' ) );
        add_filter( 'body_class',           array( $this, 'filter_body_class' ) );
        add_filter( 'template_include',     array( $this, 'site_template' ) );
		
		// Allow users to override the default archive template contents through Content and SEO settings.
		add_filter( 'wpa_archive_page_title', array( $this, 'archive_page_title' ) );
		add_filter( 'wpa_archive_content_before', array( $this, 'archive_content_before' ) );
		add_filter( 'wpa_archive_content_after', array( $this, 'archive_content_after' ) );
		
		add_filter( 'wp_title', array( $this, 'filter_archive_title'), 10, 2 );
		add_action( 'wp_head', array( $this, 'wpa_add_meta_tags' ) );
    }

    /**
     * Use for custom frontend enqueues of scripts and styles
     * http://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts
     *
     * @return void
     **/
    public function frontend_scripts(){
		$settings = get_option('awp_settings');
        global $post;
		
        if( !in_array( get_post_type( $post->ID ), array($this->pt, 'page' ) ) )
            return;
		
		if( is_page() && $post->ID == $settings['bb_builder_page'] ){
			
			$departments = array();
			$AutoCompletes = $depts = get_terms( 'site-department', array(
				'orderby'       => 'count', 
				'order'         => 'ASC',
				'hide_empty'    => true,
				'number'		=> 10 
			));
			
			foreach( $AutoCompletes as $ac){
				$departments[$ac->slug] = $ac->name;
			}
			
			wp_register_script('jquery-ui-custom', 'http://code.jquery.com/ui/1.10.3/jquery-ui.js', array('jquery'));
			wp_register_script('bb_builder', PLUGINURL . 'js/bb_builder.js', array('jquery', 'jquery-ui-custom', 'jquery-ui-widget'));
			wp_enqueue_style('jquery-ui-theme', PLUGINURL . 'css/jquery-ui.css');
			wp_enqueue_style('bb_builder', PLUGINURL . 'css/bb_builder.css');
			wp_enqueue_script('bb_builder');
			wp_localize_script('bb_builder', 'bbObj', $departments);
		}
		
		if( is_singular($this->pt) ){
			wp_register_script( 'flexslider', PLUGINURL . 'js/jquery.flexslider.js', array('jquery') );
			
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-tabs');
			
			wp_enqueue_style( 'ui-css', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css' );
			wp_enqueue_style( 'cBoxStyle', PLUGINURL . 'css/flexslider.css' );
			wp_enqueue_style( 'cBoxStyle', PLUGINURL . 'css/colorbox.css' );
		}
		
		wp_enqueue_script( 'cBoxScript', PLUGINURL . 'js/jquery.colorbox.js', array('jquery') );
		wp_enqueue_script( 'awpmain', PLUGINURL . 'js/main.js', array('jquery') );
		wp_localize_script( 'awpmain', 'wpaObj', array('ajaxurl' => admin_url( 'admin-ajax.php' )));
		
		wp_enqueue_style( 'awpmain', PLUGINURL . 'css/main.css' );
    }

    /**
     * Add custom class to body tag
     * http://codex.wordpress.org/Function_Reference/body_class
     *
     * @param array $classes
     * @return array
     **/
    public function filter_body_class( $classes ) {
        global $post;
        if( $this->pt != get_post_type( $post->ID ) )
            return $classes;
		
		if( is_archive() ){
			$classes[] = 'wpa-archive-' . $this->pt;
		}
		
        $classes[] = $this->pt . '-body-class';
        return $classes;
    }

    /**
     * Use the plugin template file to display the CPT
     * http://codex.wordpress.org/Conditional_Tags
     *
     * @param string $template
     * @return string
     **/
    public function site_template( $template ) {
		$settings = get_option('awp_settings');
        $post_types = array( $this->pt );
        $theme = wp_get_theme();
		global $post;

        if ( is_post_type_archive( $post_types ) )
            $template = $this->path . 'templates/archive.php';

        if ( is_singular( $post_types ) )
            $template = $this->path . 'templates/single.php';
		
		if( is_page() && $post->ID == $settings['bb_builder_page'] )
			$template = $this->path . 'templates/template-survey.php';

        return $template;
    }
	
	/**
	 * Allow users to override the default archive template contents
	 * through Content and SEO settings.
	 **/
	public function archive_page_title() {
		return $this->settings['archive_page_title'];
	}
	
	public function archive_content_before(){
		return apply_filters('the_content', $this->settings['archive_content_before']);
	}
	
	public function archive_content_after(){
		return apply_filters('the_content', $this->settings['archive_content_after']);
	}
	
	public function filter_archive_title($title, $sep){
		$post_types = array( $this->pt );
		global $paged, $page;
		
		if ( is_post_type_archive( $post_types ) ){
			
			$title = $this->settings['archive_meta_title'];
			
			if ( $paged >= 2 || $page >= 2 ){
				$title = "$title $sep " . sprintf( __( 'Page %s', 'wpa' ), max( $paged, $page ) );
			}
			
			echo $title;
		}
		return;
	}
	
	public function wpa_add_meta_tags(){
		$post_types = array( $this->pt );
		
		if ( is_post_type_archive( $post_types ) ){
			?>
            <meta name="description" content="<?php echo $this->settings['archive_meta_desc']; ?>" />
			<meta name="keywords" content="<?php echo $this->settings['archive_meta_keywords']; ?>" />
			<?php
		}
	}
}