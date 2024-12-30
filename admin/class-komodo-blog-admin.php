<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rankyoursites.net/wp/wp-admin/
 * @since      1.0.1
 *
 * @package    RankYourSites
 * @subpackage RankYourSites/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    RankYourSites
 * @subpackage RankYourSites/admin
 * @author     #
 */
class Komodo_Blog_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		
		/* global varible declear */
        global $wpdb;

		// if (isset($_POST['action'])) {				
		// 	add_action('wp_ajax_'.$_POST['action'], array( $this, $_POST['action'] ) );
		// }
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		// Authentication User 
		add_action( 'wp_ajax_kb_auth_user', array( $this, 'kb_auth_user' ) );		
		add_action('wp_ajax_apiSettings', array( $this, 'apiSettings' ) );
		add_action('wp_ajax_seed_keywords_serach', array( $this, 'seed_keywords_serach' ) );
		add_action('wp_ajax_GoogleAdsPlanner', array( $this, 'GoogleAdsPlanner' ) );
		add_action('wp_ajax_OepenAiGeneratePost', array( $this, 'OepenAiGeneratePost' ) );
		add_action('wp_ajax_GoogleAnalytics', array( $this, 'GoogleAnalytics' ) );
		add_action('wp_ajax_SiteMapsSetting', array( $this, 'SiteMapsSetting' ) );
		add_action('wp_ajax_GoogleTrands', array( $this, 'GoogleTrands' ) );
		add_action('wp_ajax_TrendsPostCreate', array( $this, 'TrendsPostCreate' ) );
		add_action('wp_ajax_SaveDataActivity', array( $this, 'SaveDataActivity' ) );
		add_action('wp_ajax_usersAnalyticsData', array( $this, 'usersAnalyticsData' ) );
		add_action('wp_ajax_compititionDataDelet', array( $this, 'compititionDataDelet' ) );
		add_action('wp_ajax_seedKeywordDelete', array( $this, 'seedKeywordDelete' ) );
		add_action('wp_ajax_exactResultShow', array( $this, 'exactResultShow' ) );
		add_action('wp_ajax_favoriteDataUpdate', array( $this, 'favoriteDataUpdate' ) );
		add_action('wp_ajax_favDataAdd', array( $this, 'favDataAdd' ) );


		// role restriction 
		add_action('init',array($this,'komodo_blogs_simple_role'));

        add_action('admin_footer', array($this,'rys_admin_footer'));
        add_action('admin_head', array($this,'rys_admin_head'));
		// Common Helper Call 
		require_once KOMODO_BLOGS_PATH . '/admin/helper/common.php';
		// common DB 
		require_once KOMODO_BLOGS_PATH . '/admin/model/Db_access.php';
		

		// Hook the function to the init action
		add_action('publish_post', array($this,'generate_sitemap'));
		add_action('publish_page', array($this,'generate_sitemap'));
	
		//  API Call 
		require_once KOMODO_BLOGS_PATH . '/admin/api/api.php';

        //	Timezone Set 
		$tz = 'Asia/Kolkata';   
		date_default_timezone_set($tz);

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in RankYourSites_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The RankYourSites_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/komodo-blog-admin.css', array(), $this->version, 'all' );
		// custome css call 
		wp_enqueue_style( 'dp', plugin_dir_url( __FILE__ ) . 'css/daterangepicker.css', array(), $this->version, '' );
		wp_enqueue_style( 'dpm', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, '' );
		wp_enqueue_style( 's-two', plugin_dir_url( __FILE__ ) . 'css/datepicker.min.css', array(), $this->version, '' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in RankYourSites_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The RankYourSites_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_script( 'jquery', plugin_dir_url( __FILE__ ) . 'js/jquery.js', array(), $this->version, false );	
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/komodo-blog-admin.js', array( 'jquery' ), $this->version, false );
	
		if (in_array($hook, array('post.php', 'post-new.php'))) {
			wp_enqueue_script( 'komodo-blog-custom', plugin_dir_url( __FILE__ ) . 'js/komodo-blog-custom.js', array('wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data', 'jquery'), $this->version, true );	
			
			wp_localize_script( 'komodo-blog-custom', 'frontendajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'success'=>plugin_dir_url( __FILE__ ).'images/success.svg', 'error'=>plugin_dir_url( __FILE__ ).'images/error.svg','postid'=>get_the_ID() ) );

		}
		
		// custom js call 
		wp_enqueue_script( 'platform', plugin_dir_url( __FILE__ ) . 'js/platform.js', array( 'jquery' ), $this->version, false );	
		wp_enqueue_script( 'moment.min', plugin_dir_url( __FILE__ ) . 'js/moment.min.js', array( 'jquery' ), $this->version, false );	
		wp_enqueue_script( 'loader', plugin_dir_url( __FILE__ ) . 'js/loader.js', array( 'jquery' ), $this->version, false );	
		wp_enqueue_script( 'daterangepicker', plugin_dir_url( __FILE__ ) . 'js/daterangepicker.min.js', array( 'jquery' ), $this->version, false );	
		wp_enqueue_script( 'my_chart', plugin_dir_url( __FILE__ ) . 'js/my_chart.js', array( 'jquery' ), $this->version, false );	
		wp_enqueue_script( 'apexcharts', plugin_dir_url( __FILE__ ) . 'js/apexchart/apexcharts.min.js', array( 'jquery' ), $this->version, false );	
		wp_enqueue_script( 'BarChart', plugin_dir_url( __FILE__ ) . 'js/BarChart.min.js', array( 'jquery' ), $this->version, false );	
		// wp_enqueue_script( 'control', plugin_dir_url( __FILE__ ) . 'js/apexchart/control-chart-apexcharts.js', array( 'jquery' ), $this->version, false );	
		wp_enqueue_script( 'custom', plugin_dir_url( __FILE__ ) . 'js/dev.js', 'custom', $this->version, false );	
		wp_enqueue_script( 'bootstrap', plugin_dir_url( __FILE__ ) . 'js/dataTable/bootstrap.min.js', 'bootstrap', $this->version, false );	
		wp_enqueue_script( 'dataTables', plugin_dir_url( __FILE__ ) . 'js/dataTable/jquery.dataTables.min.js', 'dataTables', $this->version, false );	
		
	}

	/**
	 * Author Role Check 
	*/
	function komodo_blogs_simple_role() {
		$editor = get_role( 'author' );
		$editor->add_cap( 'manage_feup', true );

		$admin = get_role( 'administrator' );
		$admin->add_cap( 'manage_feup', true );
	}
    public function rys_admin_footer(){
        echo "<input hidden type='text' id='hmurl' value='".site_url()."'>";
    }
    public function rys_admin_head(){
         echo '<!-- Google tag (gtag.js) -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=G-76274GGFDM"></script>
            <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              ';
            echo " gtag('js', new Date());
            
              gtag('config', 'G-76274GGFDM');
            </script>";
    }
	/**
	 * Register a custom menu page.
	*/	
	
	public function komodo_blogs_custom_menu_page() {

		add_submenu_page(
			'options-general.php',
			esc_html__('Rank Your Site Auth','rank-your-site'),
			esc_html__('Rank Your Site Auth','rank-your-site'),
			'administrator',
			'kb-auth',
			array($this, 'kb_auth_settings')
		);	
		$keyCheck = get_option('rys-auth-key');
		if(!empty($keyCheck)){
			add_menu_page(
				esc_html__( 'Rank Your Sites', 'rank-your-site'),
				esc_html__('Rank Your Sites', 'rank-your-site'),
				'manage_feup',
				'kb-rank-your-site',
				array($this, 'kb_dashboard'),
				KOMODO_BLOGS_URL.'/admin/images/wp-icon.png',
				2
			);			
			remove_submenu_page( 'kb-rank-your-site', 'rank-your-site' );
			add_submenu_page(
				'kb-rank-your-site',
				esc_html__('Seed Keywords','rank-your-site'),
				esc_html__('Seed Keywords','rank-your-site'),
				'manage_feup',
				'seed-keywords',
				array($this, 'kb_seed_kleywords')
			);		
			add_submenu_page(
				'kb-rank-your-site',
				esc_html__('Google Trends','rank-your-site'),
				esc_html__('Google Trends','rank-your-site'),
				'manage_feup',
				'google-trends',
				array($this, 'google_trends')
			);		
			add_submenu_page(
				'kb-rank-your-site',
				esc_html__('Google Analytics','rank-your-site'),
				esc_html__('Google Analytics','rank-your-site'),
				'manage_feup',
				'google-analytics',
				array($this, 'kb_GoogleAnalytics')
			);		
			add_submenu_page(
				'kb-rank-your-site',
				esc_html__('Saved Keywords','rank-your-site'),
				esc_html__('Saved Keywords','rank-your-site'),
				'manage_feup',
				'saved-compitition-data',
				array($this, 'savedcompititiondata')
			);		
			add_submenu_page(
				'kb-rank-your-site',
				esc_html__('Sitemap Settings','rank-your-site'),
				esc_html__('Sitemap Settings','rank-your-site'),
				'manage_feup',
				'sitemap-settings',
				array($this, 'kb_sitemap_settings')
			);	
			add_submenu_page(
				'kb-rank-your-site',
				esc_html__('Page & Screens','rank-your-site'),
				esc_html__('Page & Screens','rank-your-site'),
				'manage_feup',
				'page-screens',
				array($this, 'PageScreens')
			);		
			add_submenu_page(
				'kb-rank-your-site',
				esc_html__('View traffic acquisition','rank-your-site'),
				esc_html__('View traffic acquisition','rank-your-site'),
				'manage_feup',
				'top-campaign-traffic',
				array($this, 'TopCampaignTraffic')
			);		
			add_submenu_page(
				'kb-rank-your-site',
				esc_html__('Events Show ','rank-your-site'),
				esc_html__('Events Show','rank-your-site'),
				'manage_feup',
				'event-show',
				array($this, 'EventShow')
			);	
			add_submenu_page(
				'kb-rank-your-site',
				esc_html__('404 Monitor','rank-your-site'),
				esc_html__('404 Monitor','rank-your-site'),
				'manage_feup',
				'404moniter',
				array($this, 'komodo_404_monitor')
			);	
			add_submenu_page(
				'kb-rank-your-site',
				esc_html__('Image ALT Tags','rank-your-site'),
				esc_html__('Image ALT Tags','rank-your-site'),
				'manage_feup',
				'komodo-image-alt-tags',
				array($this, 'komodo_image_alt_tags_page')
			);		
			add_submenu_page(
				'kb-rank-your-site',
				esc_html__('Authentication','rank-your-site'),
				esc_html__('Authentication','rank-your-site'),
				'manage_feup',
				'authentication',
				array($this, 'kb_auth_settings')
			);		
		}	
	}
	
	/** * Komodo Blogs Admin Planel Add Option */ 

	/**
	 * 404 Monitor Screen
	 */
	public function komodo_404_monitor(){

			global $wpdb;
			$table_name = $wpdb->prefix . 'redirects'; // Replace with your table name

			// Pagination variables
			$items_per_page = 20; // Number of items per page
			$current_page = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
			$offset = ($current_page - 1) * $items_per_page;
			
			// Fetch total number of items
			$total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
			$total_pages = ceil($total_items / $items_per_page);
			// Fetch data for current page
			$results = $wpdb->get_results($wpdb->prepare(
				"SELECT * FROM $table_name LIMIT %d OFFSET %d",
				$items_per_page,
				$offset
			), ARRAY_A);

			

			echo '<div class="komodo-main-wrapper komodo-fullwidth komodo-alt-wrapper">
					<div class="komodo-page-title">
						<div class="komodo-title">
							<h2>404 Redirections</h2>
							<p>Redirect URL</p>
						</div>
						<div class="komodo-alt-btn-wrap">
							<a href="javascript:void(0);" class="komodo-btn" komodo-open-modal="deleteallredirection" >Clear All Data</a>
						</div>
					</div>
					<div class="komodo-container">
						<input type="hidden" name="action" value="clear_data">
					
					
					
			';
			
			echo '';
			echo '<div class="komodo-fixed-height-table">';
			echo '<table class="komodo-custom-table">';
			echo '<thead>';
			echo '<tr>';
			// Adjust column headers according to your table
			echo '<tr>
						<th>ID</th>
						<th>Requested URL</th>
						<th>Redirect URL</th>
						<th>Created Date</th>
					</tr>';
			echo '</thead>';
			if ($results) {				
				echo '<tbody>';
				
				foreach ($results as $row) {
					echo '<tr>';
					echo '<td>' . esc_html($row['id']) . '</td>';
					echo '<td><span class="komodo-url" title="' . esc_html($row['requested_url']) . '">' . esc_html($row['requested_url']) . '</span></td>';
					echo '<td><span class="komodo-url"  title="' . esc_html($row['redirect_url']) . '">' . esc_html($row['redirect_url']) . '</span></td>';
					echo '<td>' . esc_html($row['created_at']) . '</td>';
					echo '</tr>';
				}
				
				echo '</tbody>';
			} else {
				echo '<tbody>';
				echo '<tr><td colspan="4" >No data found.</td></tr>';
				echo '</tbody>';
			}
			
			echo '</table>';
			echo '</div>';
			
			// Pagination controls
			echo '<div class="tablenav bottom komodo-pagination">';
			echo '<div class="tablenav-pages">';
			
			$pagination_args = array(
				'total' => $total_pages,
				'current' => $current_page,
				'format' => '?paged=%#%',
				'prev_text' => __('&laquo; Previous'),
				'next_text' => __('Next &raquo;'),
			);
			echo paginate_links($pagination_args);
			
			echo '</div>';
			echo '</div>';
			echo '</div></div>';

			//Model code
			echo '<!--  popup -->
			<div id="deleteallredirection" class="komodo-delete-modal komodo-custom-modal">
				<div class="komodo-custom-modal-dialog">
					<div class="komodo-custom-modal-content">
						<div class="komodo-custom-modal-inner">
							<span class="komodo-close-modal" komodo-close-modal>X</span>
						</div>
						<div class="komodo-custom-modal-body">
							<div class="komodo-delete-modal-body ">
								<img src="'.KOMODO_BLOGS_URL.'/admin/images/delete.png">
								<h3 class="komodo-modal-title">Are you sure you want to delete all the 404 Redirection?</h3>
								<p>This action cannot be undone</p>    

								<div class="komodo-btn-wrap">
									<button type="button" class="komodo-btn komodo-btn-dark"  komodo-close-modal>Cancel</button>
									<button type="button" class="komodo-btn 404-redirection-delete">Confirm</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>';
	}

	/**
	 *
	 */
	public function komodo_image_alt_tags_page(){
		// Handle form submission
		if (isset($_POST['update_alt'])) {
			$attachment_id = intval($_POST['attachment_id']);
			$alt_text = sanitize_text_field($_POST['alt_text']);
			update_post_meta($attachment_id, '_wp_attachment_image_alt', $alt_text);
			echo '<div class="updated"><p>ALT text updated successfully.</p></div>';
		}
		// Fetch images
		$args = array(
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'posts_per_page' => -1,
		);
		$images = get_posts($args);
		?>
		<div class="komodo-main-wrapper komodo-fullwidth komodo-alt-wrapper">
			<div class="komodo-page-title">
				<div class="komodo-title">
					<h2>Manage Image ALT Tags</h2>
					<p>Seamlessly Manage ALT Tags for Better SEO</p>
				</div>
				<div class="komodo-alt-btn-wrap">
					<a href="javascript:void(0);" class="komodo-btn" komodo-open-modal="updatealttag">+ Set alt in all Images</a>
				</div>
			</div>
			<div class="komodo-container">
				<div class="komodo-fixed-height-table">
					<table class="komodo-custom-table">
						<thead>
							<tr>
								<th>Image</th>
								<th>Uploaded to</th>
								<th>ALT Text</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($images as $image): ?>
								<tr>
									<td>
										<div class="komodo-alt-img">
											<img src="<?php echo wp_get_attachment_url($image->ID); ?>" width="100" />
										</div>
									</td>
									<td>
										<div class="komodo-alt-img">
											<?php
												$imgurl = '%'.get_the_title($image->ID).'%';
												global $wpdb;
												$pmt_tbl = $wpdb->prefix . 'posts'; 
												$post_tbl = $wpdb->prefix . 'postmeta'; 
												$query = $wpdb->get_row("SELECT * FROM `$pmt_tbl` WHERE post_content LIKE '$imgurl'");
												
												$featurequery =  $wpdb->get_row("SELECT * FROM `$post_tbl` WHERE meta_value = $image->ID");
												if(!empty($query)){
													$titlename = get_the_title($query->ID);
													echo '<a href="'.get_the_permalink($query->ID).'">'.$titlename.'</a>';
												}elseif(!empty($featurequery)){
													if($featurequery->meta_key == '_thumbnail_id'){
														$titlename = get_the_title($featurequery->post_id);
														echo '<a href="'.get_the_permalink($featurequery->post_id).'">'.$titlename.'</a>';
													}
												}else{
													echo 'This image is not connected to any post.';
												}
											?>
										</div>
									</td>
									<td>
										<form method="post" action="">
											<input type="hidden" name="attachment_id" value="<?php echo $image->ID; ?>" />
											<div class="komodo-alt-budget">
												<input type="text" name="alt_text" value="<?php echo esc_attr(get_post_meta($image->ID, '_wp_attachment_image_alt', true)); ?>" />
												<!-- <span>click on text to update</span> -->
											</div>
									</td>
									<td>	
											<input type="submit" name="update_alt" class="komodo-btn komodo-btn-sm" value="Update ALT" />
										</form>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<?php

		//Model code
		echo '<!-- popup -->
		<div id="updatealttag" class="komodo-custom-modal komodo-delete-modal komodo-alt-modal">
			<div class="komodo-custom-modal-dialog">
				<div class="komodo-custom-modal-content">
					<div class="komodo-custom-modal-inner">
						<span class="komodo-close-modal" komodo-close-modal>X</span>
					</div>
					<div class="komodo-custom-modal-body">
						<div class="komodo-delete-modal-body ">
							<h3 class="komodo-modal-title">By default, the alt tag will be set to <code>Site Title + Image Name</code> Are you sure you want to apply this tag to the images?</h3>
							<p>This action cannot be undone</p>    

							<div class="komodo-btn-wrap">
								<button type="button" class="komodo-btn komodo-btn-dark"  komodo-close-modal>Cancel</button>
								<button type="button" class="komodo-btn updatealttag_images">Confirm</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>';
	}

	/** 
	 * Display Authentication Page
	*/
	public function kb_auth_settings(){
		$auth_key = '';
	    $auth_key = get_option('rys-auth-key');
		require_once KOMODO_BLOGS_PATH . '/admin/partials/auth/authentication.php';
	}

	/**
	 * Display Dashboard Page
	*/
	public function kb_dashboard(){		
		$auth_key = '';
	    $auth_key = get_option('rys-auth-key');
		require_once KOMODO_BLOGS_PATH . '/admin/partials/backend/dashboard.php';
	}
	public function EventShow(){			
		// M END POINT 
		$MEPoint = !empty(get_option('m_area_end_point'))?get_option('m_area_end_point'):'https://rankyoursites.net/';
		$accessToken = get_option('rys_ga4access_token');
		if(isset($accessToken)){
			$token = json_decode($accessToken,true);
		}else{
			$token = "";
		}
		
		$data['functionName'] 	= isset($_POST['function'])?$_POST['function']:'TopEventsAllDataShow';
		$data['startDate'] 	= isset($_GET['startDate']) ? date('Y-m-d',strtotime($_GET['startDate'])) : date('Y-m-d', strtotime('-7 days'));
		$data['endDate'] 	= isset($_GET['endDate']) 	? date('Y-m-d',strtotime($_GET['endDate'])) : date('Y-m-d');
		$data['subDomain'] 	= isset($_GET['appName']) 	? $_GET['appName'] : '';
		$data['loCation'] 	= isset($_GET['loCation']) ? $_GET['loCation'] : 'worldwide';
		$data['type'] 		= isset($_POST['type']) ? $_POST['type'] : 'Visits'; //installs
		$data['token'] 		= $accessToken;

		$data['propertyID'] = isset($_GET['pro-id']) ? $_GET['pro-id'] : ''; 

		$data['dimensions'] =  isset($_GET['dimensions']) ? $_GET['dimensions'] : ''; //installs
	
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $MEPoint.'multi-request',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $data,	
				CURLOPT_HTTPHEADER => array(
					'Bearer: '.$token['access_token'],
					'Cookie: ci_session=d3250tjk1j66ch8rurvqlvkfke02lifd'
				),	
			));

			$response = curl_exec($curl);	
		
			$result = json_decode($response,true);
			
			curl_close($curl);				
		require_once KOMODO_BLOGS_PATH . '/admin/partials/pages/EventShow.php';
	}
	public function TopCampaignTraffic(){	
		// M END POINT 
		// echo "<pre>";print_r($_GET);
		// die;
		$MEPoint = !empty(get_option('m_area_end_point'))?get_option('m_area_end_point'):'https://rankyoursites.net/';

		$accessToken = get_option('rys_ga4access_token');
		if(isset($accessToken)){
			$token = json_decode($accessToken,true);
		}else{
			$token = "";
		}
		$data['functionName'] 	= isset($_POST['function'])?$_POST['function']:'TrafficAcquisitionSessionCampaign';
		$data['startDate'] 	= isset($_GET['startDate']) ? date('Y-m-d',strtotime($_GET['startDate'])) : date('Y-m-d', strtotime('-7 days'));
		$data['endDate'] 	= isset($_GET['endDate']) 	? date('Y-m-d',strtotime($_GET['endDate'])) : date('Y-m-d');
		$data['subDomain'] 	= isset($_GET['appname']) 	? $_GET['appname'] : '';
		$data['loCation'] 	= isset($_GET['loCation']) ? $_GET['loCation'] : 'worldwide';
		$data['type'] 		= isset($_POST['type']) ? $_POST['type'] : 'Visits'; //installs

		$data['propertyId'] = isset($_GET['pro-id']) ? $_GET['pro-id'] : ''; 

		$data['dimensions'] =  isset($_GET['dimensions']) ? $_GET['dimensions'] : 'sessionDefaultChannelGroup'; //installs

		$data['token'] 		= $accessToken;
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $MEPoint.'multi-request',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $data,	
			CURLOPT_HTTPHEADER => array(
					'Bearer: '.$token['access_token'],
					'Cookie: ci_session=d3250tjk1j66ch8rurvqlvkfke02lifd'
				),		
		));

		$response = curl_exec($curl);	
	// 	echo "<pre>";print_r($response);
	// die;	
		$result = json_decode($response,true);
		
		curl_close($curl);			
		require_once KOMODO_BLOGS_PATH . '/admin/partials/pages/TopCampaignTraffic.php';
	}
	public function PageScreens(){	
		// M END POINT 
		
		$MEPoint = !empty(get_option('m_area_end_point'))?get_option('m_area_end_point'):'https://rankyoursites.net/';

		$accessToken = get_option('rys_ga4access_token');
		if(isset($accessToken)){
			$token = json_decode($accessToken,true);
		}else{
			$token = "";
		}
		$data['functionName'] 	= isset($_POST['function'])?$_POST['function']:'PagesAndScreens';
		
		$data['startDate'] 	= isset($_GET['startDate']) ? date('Y-m-d',strtotime($_GET['startDate'])) : date('Y-m-d', strtotime('-7 days'));
		
		$data['endDate'] 	= isset($_GET['endDate']) 	? date('Y-m-d',strtotime($_GET['endDate'])) : date('Y-m-d');
		
		$data['subDomain'] 	= isset($_GET['appName']) 	? $_GET['appName'] : '';
		
		$data['loCation'] 	= isset($_GET['loCation']) ? $_GET['loCation'] : 'worldwide';

		$data['type'] 		= isset($_POST['type']) ? $_POST['type'] : 'Visits'; //installs

		$data['propertyID'] = isset($_POST['propertyId']) ? $_POST['propertyId'] :$_GET['pro-id']; 

		$data['dimensions'] =  isset($_GET['dimensions']) ? $_GET['dimensions'] : 'sessionDefaultChannelGroup'; //installs
		
		
		$data['token'] 		= $accessToken;
	
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $MEPoint.'multi-request',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $data,	
			CURLOPT_HTTPHEADER => array(
				'Bearer: '.$token['access_token'],
				'Cookie: ci_session=d3250tjk1j66ch8rurvqlvkfke02lifd'
			),		
		));

		$response = curl_exec($curl);	
	
		$result = json_decode($response,true);
		
		curl_close($curl);			
		require_once KOMODO_BLOGS_PATH . '/admin/partials/pages/PageScreens.php';
	}
	public function savedcompititiondata(){		
		global $wpdb;
		// $sql_query = "SELECT * FROM `rys_check_competition_data` ";
		// $competitionData = $wpdb->get_results($sql_query, ARRAY_A);


		// Construct the SQL query with dynamic sorting
		$sql_query = "SELECT * FROM `rys_check_competition_data` ORDER BY cc_id DESC";

		$competitionData = $wpdb->get_results($sql_query, ARRAY_A);
		require_once KOMODO_BLOGS_PATH . '/admin/partials/backend/savedcompititiondata.php';
	}
	/**
	 * Display kb_GoogleAnalytics Page
	*/
	public function kb_GoogleAnalytics(){		
		// Token Get 	
		$accessToken = get_option('rys_ga4access_token');
		$mapsApi = get_option('rys_mapsApi');
		// M END POINT 
		$MEPoint = !empty(get_option('m_area_end_point'))?get_option('m_area_end_point'):'https://rankyoursites.net/';
		
		if(isset($accessToken)){
			$token = json_decode($accessToken,true);
		}else{
			$token = "";
		}
		$data['token'] = $accessToken; 
	    if(!empty($token)){
    	    $curl = curl_init();
    
    		curl_setopt_array($curl, array(
    		CURLOPT_URL => $MEPoint.'get-websites',
    		CURLOPT_RETURNTRANSFER => true,
    		CURLOPT_ENCODING => '',
    		CURLOPT_MAXREDIRS => 10,
    		CURLOPT_TIMEOUT => 0,
    		CURLOPT_FOLLOWLOCATION => true,
    		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    		CURLOPT_CUSTOMREQUEST => 'POST',
    		CURLOPT_POSTFIELDS => $data,
    		CURLOPT_HTTPHEADER => array(
    			'Bearer: '.$token['access_token'],
    			'Cookie: ci_session=d3250tjk1j66ch8rurvqlvkfke02lifd'
    		),
    		));
    
    		$res = curl_exec($curl);
    		curl_close($curl);
    		$websites = json_decode($res,true);
			
    		$propertyID = isset($websites['accountSummaries'][0]['propertySummaries'][0]['property'])?$websites['accountSummaries'][0]['propertySummaries'][0]['property']:'';
    			
			if(!empty($propertyID)){
				$property = [];
				$i = 0;
			 
				if(isset($websites)){
					foreach($websites as $website){
						foreach($website as $web){
							foreach($website[$i]['propertySummaries'] as $prop){
								array_push($property,$prop);
							}
						$i++;
					}}        
				}
				
				foreach($property as $key=>$webProperty){
					
					$data['property-id'] = $webProperty['property']; 
					
					$curl_dn = curl_init();

					curl_setopt_array($curl_dn, array(
					CURLOPT_URL => $MEPoint.'get-domain-names',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => $data,
					CURLOPT_HTTPHEADER => array(
						'Bearer: '.$token['access_token']
					),
					));

					$ress = curl_exec($curl_dn);
					$gdnD = json_decode($ress,true);
					
					curl_close($curl_dn);

					if(!empty($gdnD)){
						$gdn = $gdnD;	
						$wbsel = $webProperty['property'];
						break;									
					}
				}		
			}else{
				$gdn = [];
				$wbsel="";
			}		
	    }else{
			$gdn = [];
			$websites = [];
		}
		
		require_once KOMODO_BLOGS_PATH . '/admin/partials/backend/google-analytics.php';
	}
	/**
	 * Display kb_sitemap_settings Page
	*/
	public function kb_sitemap_settings(){
		$siteMapData = get_option('siteMapData');
		if(!empty($siteMapData)){
			$sikteMaps = json_decode($siteMapData,true);
		}else{
			$sikteMaps = array();
		}
		require_once KOMODO_BLOGS_PATH . '/admin/partials/backend/sitemap.php';
	}
	
	/**
	 * Display kb_sitemap_settings Page
	*/
	public function google_trends(){	
		$_POST['country'] = "IN";
		
		// M END POINT 
		$MEPoint = !empty(get_option('m_area_end_point'))?get_option('m_area_end_point'):'https://rankyoursites.net/';
		$data['ctry'] 	= $_POST['country'];
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => $MEPoint.'google-trands',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => $data,		
		));

		$response = curl_exec($curl);		
		$Gtrends = json_decode($response,true);
		curl_close($curl);	

		require_once KOMODO_BLOGS_PATH . '/admin/partials/backend/googletrends.php';
	}
	/**
	 * Display Seed Keyword Page
	*/
	public function kb_seed_kleywords(){
		global $wpdb;
		$sql_query = "SELECT * FROM `rys_check_competition_data` ";
		$sql_query2 = "SELECT * FROM `rys_trends_save_keuword` ";
		// Retrieve the results from the database
		$competitionData = $wpdb->get_results($sql_query, ARRAY_A);
		$savekeyword = $wpdb->get_results($sql_query2, ARRAY_A);
		$site_url = site_url();
		require_once KOMODO_BLOGS_PATH . '/admin/partials/backend/seedkeywords.php';
	}

	/**
	 * User Authentication 
	*/
	public function kb_auth_user(){
		
		$siteURL = get_bloginfo('url');
		
		if($_POST['action']=='kb_auth_user'){
			if(isset($_POST['kb_auth_key']) && $_POST['type']=="Connect"){
				$data = array('auth-key'=>$_POST['kb_auth_key'],'end-point'=>$siteURL."/wp-json/rank-your-sites/v1/getToken");
				$MEPoint = !empty(get_option('m_area_end_point'))?get_option('m_area_end_point'):'https://rankyoursites.net/';
				$curl = curl_init();

				curl_setopt_array($curl, array(
				CURLOPT_URL => $MEPoint.'api/auth_user',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $data,				
				));

				$res = curl_exec($curl);
			
				curl_close($curl);

				$data_arr = json_decode($res,true);
								
				if(isset($data_arr['status']) && $data_arr['status']=='success'){
					$res = update_option('rys-auth-key',$_POST['kb_auth_key']);
					update_option('rys_access_oto',$data_arr['access']);					
					update_option('m_area_end_point',$data_arr['endpointmember']);					
					update_option('rys_mapsApi',$data_arr['mapsapi']);					
					$resp = array('status'=>1,'msg' => 'Successfully authenticated','url'=>admin_url( 'admin.php?page=kb-rank-your-site'));
				}else{
					$resp = array('status'=>0,'msg' => 'Authentication key is incorrect. ','url'=>admin_url( 'options-general.php?page=kb-auth'));
				} 				
				echo json_encode($resp,JSON_UNESCAPED_SLASHES);
				die();				
						
			}else{
				/**
				* wpemails authentication disconnect
				*/
				if(isset($_POST['type']) && $_POST['type']=="Disconnect"){
					$authkey = delete_option('rys-auth-key');
					$kb_auth_OTO = delete_option('rys_access_oto');
					
					if(!empty($authkey) && !empty($kb_auth_OTO)){
						$resp = array('status'=>1,'msg' => 'User successfully disconnected.','url'=>admin_url( 'options-general.php?page=kb-auth'));			
						echo json_encode($resp,JSON_UNESCAPED_SLASHES);
						die();	
					}	
				}
			}
		}else{	
			$resp = array('status'=>0,'msg' => 'Direct access not allowed ','url'=>admin_url( 'options-general.php?page=kb-auth'));			
			echo json_encode($resp,JSON_UNESCAPED_SLASHES);
			die();	
		}		
	}	
	public function auth_admindata__fail(){
		echo '<div class="notice notice notice-error is-dismissible">
				<p>'.esc_html__( 'Sorry, we did not find match for this key.', 'wpemails' ).'</p>
			</div>';
	}
	public function auth_admindata__success(){
		echo '<div class="notice notice-success is-dismissible">
				<p>'.esc_html__( 'Your key has been Successfully authenticated.', 'wpemails' ).'</p>
			</div>';
	}
	/*
	* apiSettings add 
	*/

	public function apiSettings(){
		if(isset($_POST['action']) && $_POST['action']=="apiSettings"){
			$db = new Db_access();
			
			if (!method_exists($db, 'wpTableOperations')) {
				$resp = array('status'=>0,'msg' => ' Error: Method wpTableOperations does not exist in Db_access class.');
				echo json_encode($resp,JSON_UNESCAPED_SLASHES);
				die();					
			}else{
				$tbl = "option";
				$data = $_POST;
				$authurl = "";
				if(isset($_POST['key-type']) && !empty($_POST['key-type']) && $_POST['key-type']=="ga4"){
					$add_key = "rys_ga4Key";
					
				}else if(isset($_POST['key-type']) && !empty($_POST['key-type']) && $_POST['key-type']=="openai"){
					$add_key = "rys_openaiKey";
				}else if(isset($_POST['key-type']) && !empty($_POST['key-type']) && $_POST['key-type']=="rapid"){
					$add_key = "rys_rapidKey";
				}else{
					$add_key = "rys_ga4Key";
				}

				
				if(isset($_POST['operation-type']) && !empty($_POST['operation-type']) && $_POST['operation-type']=="add"){
					$opr = "add";
					$res = add_option($add_key,json_encode($data));
					$resp = array('status'=>1,'msg' => 'Successfully Added ','url'=>$authurl);		
				}else if(isset($_POST['operation-type']) && !empty($_POST['operation-type']) && $_POST['operation-type']=="update"){
					$opr = "Update";
					$res = update_option($add_key,json_encode($data));
					$resp = array('status'=>1,'msg' => 'Successfully Updated ','url'=>$authurl);		
				}else if(isset($_POST['operation-type']) && !empty($_POST['operation-type']) && $_POST['operation-type']=="delete"){
					$opr = "Delete";
					$res = delete_option($add_key);
					$resp = array('status'=>1,'msg' => 'Successfully deleted ','url'=>$authurl);		
				}else{
					$res = delete_option($add_key);
					$resp = array('status'=>1,'msg' => 'Successfully Disconnet ','url'=>$authurl);		
				}						
					
				echo json_encode($resp,JSON_UNESCAPED_SLASHES);
				die();	
			}			
		}else{
			$resp = array('status'=>0,'msg' => 'Direct access not allowed ');			
			echo json_encode($resp,JSON_UNESCAPED_SLASHES);
			die();	
		}	
	}
	
	/*
	* Seed Keywords Search
	*/

	public function seed_keywords_serach(){							
		// seed-keywords-searching
		if(isset($_POST['action']) && $_POST['action']=="seed_keywords_serach"){
			if(isset($_POST['seed-keywords']) && !empty($_POST['seed-keywords'])){
				$text = $_POST['seed-keywords'];
                $MEPoint = !empty(get_option('m_area_end_point'))?get_option('m_area_end_point'):'https://rankyoursites.net/';
				$curl = curl_init();

				curl_setopt_array($curl, array(
				CURLOPT_URL => $MEPoint.'/seed-keywords-searching',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => array('keywords' => $text),
				CURLOPT_HTTPHEADER => array(
					'Bearer: ya29.a0AXooCgtP4zKdR-goOlmOJvM5omZdLVhRn5fkuP67EykzBtDVqnL6R5tQpFQ6-8_qJU1CgHMoCgXIoqkNmS7pcikcI4xmvXo39T4V4JimXo1BeFQKC-N31904NxrdJw2TrMq0sKevVTS-kAbfuYYmll4ARTifaiGAhM8raCgYKAW0SARISFQHGX2MivPNDP_bmhJVaO5i--2SqLQ0171',
					'Cookie: ci_session=n5qhmhbklrei7hc77mjf1ihjm4qh5rbc'
				),
				));

				$response = curl_exec($curl);
			
				curl_close($curl);
				if(!empty($response)){
					$resp = array('status'=>1,'data' => json_decode($response,true));	
				}else{
					$resp = array('status'=>0,'data' => '','msg'=>'Record not found');	
				}

				echo json_encode($resp,JSON_UNESCAPED_SLASHES);
				die();		
			}else{
				$resp = array('status'=>0,'data' => '','msg'=>'Please Enter Your Find Keyword');
				echo json_encode($resp,JSON_UNESCAPED_SLASHES);
				die();		
			}

		}else{
			$resp = array('status'=>0,'msg' => 'Direct access not allowed');			
			echo json_encode($resp,JSON_UNESCAPED_SLASHES);
			die();			
		}
	}
	
    public function getRandomStringe($n){
        $seed = str_split('abcdefghijklmnopqrstuvwxyz');
        shuffle($seed); // probably optional since array_is randomized; this may be redundant
      
        $rand = '';       
        return $rand .= $seed[array_rand($seed, $n)];
    }

	/**
	 * Google Planner Activity 
	*/
	public function GoogleAdsPlanner(){
		if(isset($_POST['action']) && $_POST['action']=="GoogleAdsPlanner"){

			// Token Get 	
			$accessToken = get_option('rys_plannerToken');
			// M END POINT 
			$MEPoint = !empty(get_option('m_area_end_point'))?get_option('m_area_end_point'):'https://rankyoursites.net/';
			
			if(isset($accessToken)){
				$token = json_decode($accessToken,true);
			}else{
				$token = "";
			}
		
			$curl = curl_init();

			curl_setopt_array($curl, array(
			CURLOPT_URL => $MEPoint.'planneer-activity',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array('seedkeywords' => $_POST['seedkeywords'],'tnk'=>$accessToken,'country'=>$_POST['country']),
			CURLOPT_HTTPHEADER => array(
				'Bearer: '.$token['access_token'],
				'Cookie: ci_session=9logcuuj2kkipi8nrnvmm19oceonc3pr'
			),
			));

			$response = curl_exec($curl);
		
			curl_close($curl);
							
			echo json_encode(json_decode($response,true),JSON_UNESCAPED_SLASHES);
			die();	
		}else{
			$resp = array('status'=>0,'msg' => 'Direct access not allowed');		
			echo json_encode($resp,JSON_UNESCAPED_SLASHES);
			die();			
		}
	}

	public function SaveDataActivity(){
		if(isset($_POST['action']) && $_POST['action']=="SaveDataActivity"){
			global $wpdb;
		
			$finalPostArray = [];
			foreach ($_POST['CheckCompetion'] as $key => $value) {
				array_push($finalPostArray,json_decode(base64_decode($value),true));
			}
			$post_status = "publish";
			
			$current_user_id = get_current_user_id();
			if(isset($_POST['ac-type']) && $_POST['ac-type']=="saveData"){
				$rescheck = 0;
				
				foreach ($finalPostArray as $key => $comData) {
					$data_to_insert = array(
						'cc_data' =>json_encode($comData),					
					);
					$data_format = array('%s');	
					
					$res = $wpdb->insert('rys_check_competition_data', $data_to_insert, $data_format);
					$rescheck++;
				}	
				
				if($rescheck!=0){
					$resp = array('status'=>1,'msg' => 'Successfully added data.');			
					echo json_encode($resp,JSON_UNESCAPED_SLASHES);
					die();
				}else{
					$resp = array('status'=>0,'msg' => 'Something went wrong. ');			
					echo json_encode($resp,JSON_UNESCAPED_SLASHES);
					die();
				}
			}			
		}else{
			$resp = array('status'=>0,'msg' => 'Direct access not allowed');			
			echo json_encode($resp,JSON_UNESCAPED_SLASHES);
			die();			
		}
	}
	public function favoriteDataUpdate(){
		global $wpdb;

		if($_POST['Ftype']=="Notadd"){
			$FavSt = 0;
			$msg = 'Favorite was successfully removed';
		}else{
			$FavSt = 1;
			$msg = 'Favorite was successfully added';
		}	

		$res = $wpdb->update(
			'rys_check_competition_data',
			array( 
				'Favorite' => $FavSt
			),
			array(
				'cc_id' => $_POST['id']
			)
		);
		echo json_encode(array('status'=>1,'msg'=>$msg));		
		die;
	}
	public function favDataAdd(){

		global $wpdb;

		$finalPostArray = json_decode(base64_decode($_POST['d']),true);
	
		$current_user_id = get_current_user_id();
		if(isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] !='undefined'){

			$condition = array('cc_id' =>$_POST['id']);
		
			$res = $wpdb->delete('rys_check_competition_data', $condition);

			$msg ="Successfully Remove";
			if($res){
				echo json_encode(array('status'=>2,'msg'=>$msg));
			}else{
				echo json_encode(array('status'=>0,'msg'=>'Something went wrong; please try again later'));
			}
			die();
		}else{

			$data_to_insert = array(
				'cc_data' =>json_encode($finalPostArray),					
				'Favorite' =>1,					
			);
			$data_format = array('%s');	
			
			$res = $wpdb->insert('rys_check_competition_data', $data_to_insert, $data_format);
			$lastid = $wpdb->insert_id;
			if($res !=0){
				$resp = array('status'=>1,'msg' => 'Successfully added save keyword','insId'=>$lastid);			
				echo json_encode($resp,JSON_UNESCAPED_SLASHES);
				die();
			}else{
				$resp = array('status'=>0,'msg' => 'Something went wrong. ');			
				echo json_encode($resp,JSON_UNESCAPED_SLASHES);
				die();
			}
		}	
	}
	/**
	 * Open AI Generate Post Content 
	*/
	public function OepenAiGeneratePost(){
		if(isset($_POST['action']) && $_POST['action']=="OepenAiGeneratePost"){
			
			$accessToken = get_option('rys_ga4access_token');
			// M END POINT 
			$MEPoint = !empty(get_option('m_area_end_point'))?get_option('m_area_end_point'):'https://rankyoursites.net/';
			$checkCreatePost = [];
			
			if(isset($_POST['postName']) && isset($_POST['customPrompt'])){

				if($_POST['customPrompt']==1){
					$promptNew = $_POST['query'];
				}else{

					// Get the post name (query) from the form or API call
					$query = $_POST['postName'];
					
					// Define the website URL (plugin URL)
					$pluginUrl = site_url();  // Ensure this variable is set correctly in your WordPress environment
	
					// Create the prompt string with dynamic content, preserving the line breaks and formatting
					$promptNew = "Create a comprehensive blog post of 2500 words titled “" . $query . ": The Ultimate Guide with 10 Delicious Options”. The article should be well structured with clear headings and subheadings, effectively organizing the content for readability. And add the website URL to the focus keyword.\n\n";
					$promptNew .= "Website URL: " . $pluginUrl . "\n\n";
					$promptNew .= "**SEO Elements:**\n\n";
					$promptNew .= "1. **SEO Title:**\n";
					$promptNew .= "- Start with the focus keyword “" . $query . "”\n";
					$promptNew .= "- Reflect positive sentiment.\n";
					$promptNew .= "- Include the power word “Ultimate”.\n";
					$promptNew .= "- Feature the numerical value “10”.\n\n";
					$promptNew .= "2. **SEO Meta Description:**\n";
					$promptNew .= "- Include “" . $query . "”\n";
					$promptNew .= "- Provide a concise summary that attracts clicks.\n\n";
					$promptNew .= "3. **URL Structure:**\n";
					$promptNew .= "- Create a URL that includes “" . $query . ".\n\n";
					$promptNew .= "**Content Guidelines:**\n\n";
					$promptNew .= "- Make sure the focus keyword “" . $query . " is mentioned in the first paragraph.\n";
					$promptNew .= "- Integrate the focus keyword naturally throughout the article to achieve a density of approximately 2.5%, between 63 and 100 mentions in total.\n";
					$promptNew .= "- Use subheadings (H2, H3, H4) to structure the content, incorporating the focus keyword where relevant.\n";
					$promptNew .= "- Write short, concise paragraphs to enhance readability.\n";
					// $promptNew .= "- Include engaging images and/or videos to support the content, specifying the focus keyword as alt text for at least one image.\n\n";
					$promptNew .= "- Include engaging images and/or videos to support the content, specifying the focus keyword as the alt text for at least one image. The image or video must be a live preview URL.\n\n";
					$promptNew .= "**External Linking:**\n\n";
					$promptNew .= "- Include DoFollow links to reputable, relevant external resources that increase the authority of the article.\n\n";
					$promptNew .= "**Additional Notes:**\n\n";
					$promptNew .= "- Make sure the content flows smoothly with varied language to avoid repetition.\n";
					$promptNew .= "- Maintain an overall structure with clear headings and subheadings for easy navigation.\n";
					$promptNew .= "- The content should be engaging, informative, and optimized for search engines, as well as follow the specified guidelines.\n\n";
					$promptNew .= "**Final Requirement:**\n\n";
					$promptNew .= "- Prepare the content with the above specifications, ensuring it is both user-friendly and optimized for search engines.\n\n";
					$promptNew .= "Generate HTML";
				}
				
				$postName = $_POST['postName'];
				
				// Initialize cURL session
				$curl = curl_init();
	
				curl_setopt_array($curl, array(
				CURLOPT_URL => $MEPoint.'oepen-ai-generate-post',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => array('content-query' =>$promptNew),
				CURLOPT_HTTPHEADER => array(
					'Bearer: '.$token['access_token'],
					'Cookie: ci_session=9logcuuj2kkipi8nrnvmm19oceonc3pr'
				),
				));
	
				$response = curl_exec($curl);
			
				curl_close($curl);
				
				// Decode the JSON response
				$result = json_decode($response, true);
				$data = json_decode($result['data'], true);
				
				if (isset($result['status']) && $result['status']==0) {
					$resp = array('status'=>2,'msg' =>$result['msg']);			
					echo json_encode($resp,JSON_UNESCAPED_SLASHES);
					die();	
				} else {
					// Extract and print the generated content
					$generated_content = $data['choices'][0]['message']['content'];
					
					$post_status = "draft";
	
					$current_user_id = get_current_user_id();
					// Create a new post
					$post_data = array(
						'post_title'    => $postName,
						'post_content'  => $generated_content,
						'post_status'   => $post_status, // Set post status to 'publish' to make it visible immediately
						'post_author'   => $current_user_id, // ID of the post author. You can change this to match the desired author.
						'post_type'     => 'post' // Post type (e.g., 'post', 'page', 'custom_post_type')
					);
					
					//Insert the post into the database
					$post_id = wp_insert_post($post_data);
	
					// Check if the post was inserted successfully
					if (!is_wp_error($post_id)) {
						// Post was inserted successfully
						$URLEDIT = admin_url( 'post.php?post='.$post_id.'&action=edit');
						array_push($checkCreatePost,array('postId'=>$post_id,'status'=>'Post Creted Success','url'=>admin_url( 'wp-admin/post.php?post='.$post_id.'&action=edit')));						
					} else {
						// There was an error inserting the post
						array_push($checkCreatePost,array('postId'=>$key,'status'=>$post_id->get_error_message()));		
						$URLEDIT = "";				
					}
				}
				$resp = array('status'=>1,'msg' => ' Successfully created post ','EDITURL'=>$URLEDIT,'postAdded'=>$checkCreatePost);			
				echo json_encode($resp,JSON_UNESCAPED_SLASHES);
				die();	
			}else{
				$finalPostArray = [];
				foreach ($_POST['CheckCompetion'] as $key => $value) {
					array_push($finalPostArray,json_decode(base64_decode($value),true));
				}
				
				foreach ($finalPostArray as $key => $value) {	
	
					$query = $value['keyword'];
					$postName = $value['keyword'];
						
					// Initialize cURL session
					$curl = curl_init();
		
					curl_setopt_array($curl, array(
					CURLOPT_URL => $MEPoint.'oepen-ai-generate-post',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => array('content-query' =>'Prepare a 2500-word blog post on the topic '.$query.' The article should be well structured with headings and subheadings, effectively organizing the content. The keyword '.$query.' should be mentioned between 63 and 100 times throughout the article, achieving a keyword density of around 2.5%. Ensure the keyword is naturally integrated into various places in the content, including the title, introductory paragraph, and throughout the body of the text to avoid repetition and maintain a smooth flow'),
					// CURLOPT_POSTFIELDS => array('content-query' =>'write a blog post on '.$query.' with 2500 words having kwyword density of  2.5'),
					CURLOPT_HTTPHEADER => array(
						'Bearer: '.$token['access_token'],
						'Cookie: ci_session=9logcuuj2kkipi8nrnvmm19oceonc3pr'
					),
					));
		
					$response = curl_exec($curl);
					curl_close($curl);
					
					// Decode the JSON response
					$result = json_decode($response, true);
					$data = json_decode($result['data'], true);
					
					if (isset($result['status']) && $result['status']==0) {
				    	$resp = array('status'=>2,'msg' =>$result['msg']);			
    					echo json_encode($resp,JSON_UNESCAPED_SLASHES);
    					die();
					} else {
						// Extract and print the generated content
						$generated_content = $data['choices'][0]['message']['content'];
		
						$post_status = "draft";
		
						$current_user_id = get_current_user_id();
						// Create a new post
						$post_data = array(
							'post_title'    => $postName,
							'post_content'  => $generated_content,
							'post_status'   => $post_status, // Set post status to 'publish' to make it visible immediately
							'post_author'   => $current_user_id, // ID of the post author. You can change this to match the desired author.
							'post_type'     => 'post' // Post type (e.g., 'post', 'page', 'custom_post_type')
						);
						//Insert the post into the database
						$post_id = wp_insert_post($post_data);
		
						// Check if the post was inserted successfully
						if (!is_wp_error($post_id)) {
							// Post was inserted successfully
							array_push($checkCreatePost,array('postId'=>$post_id,'status'=>'Post Creted Success','url'=>admin_url( 'edit.php')));						
						} else {
							// There was an error inserting the post
							array_push($checkCreatePost,array('postId'=>$key,'status'=>$post_id->get_error_message()));						
						}
					}
				}
				$resp = array('status'=>1,'msg' => 'Successfully Created post ','EDITURL'=>admin_url( 'edit.php'),'postAdded'=>$checkCreatePost);			
				echo json_encode($resp,JSON_UNESCAPED_SLASHES);
				die();	
			}
		
				
		}else{
			$resp = array('status'=>0,'msg' => 'Direct access not allowed');			
			echo json_encode($resp,JSON_UNESCAPED_SLASHES);
			die();			
		}
	}

	public function GoogleAnalytics(){
		// Token Get 	
		$accessToken = get_option('rys_ga4access_token');
		// M END POINT 
		$MEPoint = !empty(get_option('m_area_end_point'))?get_option('m_area_end_point'):'https://rankyoursites.net/';

		if(isset($accessToken)){
			$token = json_decode($accessToken,true);
		}else{
			$token = "";
		}
		
		$current_user = wp_get_current_user();
		$data['startDate'] 	= isset($_POST['startDate']) ? date('Y-m-d',strtotime($_POST['startDate'])) : date('Y-m-d', strtotime('-7 days'));
		$data['endDate'] 	= isset($_POST['endDate']) 	? date('Y-m-d',strtotime($_POST['endDate'])) : date('Y-m-d');
		$data['subDomain'] 	= isset($_POST['appName']) 	? $_POST['appName'] : '';
		$data['loCation'] 	= isset($_POST['loCation']) ? $_POST['loCation'] : 'worldwide';
		$data['type'] 		= isset($_POST['type']) ? $_POST['type'] : 'Visits'; //installs
		$data['property-id'] = isset($_POST['propertyId']) ? $_POST['propertyId'] : ''; 			
		$data['token'] = $accessToken; 			
		$data['user-id'] = $current_user->ID; 			
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => $MEPoint.'analytics-data',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS => $data,
		CURLOPT_HTTPHEADER => array(
			'Bearer: '.$token['access_token'],
			'Cookie: ci_session=d3250tjk1j66ch8rurvqlvkfke02lifd'
		),
		));

		$response = curl_exec($curl);
		// print_r($response);
		// die;
		$result = json_decode($response,true);
		curl_close($curl);
		echo  $response;
		die;
	}

	// Add this to your theme's functions.php file
	public function generate_sitemap() {
		$siteMapData = get_option('siteMapData');
		if(!empty($siteMapData)){
			$sikteMaps = json_decode($siteMapData,true);
			if($sikteMaps['site_map_status']=="on"){

				// Query for all posts and pages
				$postsForSitemap = get_posts(array(
					'numberposts' => -1,
					'orderby' => 'modified',
					'post_type'  => array('post', $sikteMaps['post_type']),
					'order'    => 'DESC'
				));
			
				// Start the sitemap XML structure
				$sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
				$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
				
				// Loop through each post and page
				foreach ($postsForSitemap as $post) {
					setup_postdata($post);
					$postdate = explode(" ", $post->post_modified);
					
					// Add each post/page to the sitemap
					$sitemap .= '<url>'.
					'<loc>' . get_permalink($post->ID) . '</loc>'.
					'<lastmod>' . $postdate[0] . '</lastmod>'.
					'<changefreq>monthly</changefreq>'.
					'</url>';
				}
				
				$sitemap .= '</urlset>';
				
				// Save the XML to a file in the root directory
				$fp = fopen(ABSPATH . "sitemap.xml", 'w');
				fwrite($fp, $sitemap);
				fclose($fp);
			}
		}
	}

	public function SiteMapsSetting(){
		if(isset($_POST['action']) && $_POST['action']=="SiteMapsSetting"){
			$check = get_option('siteMapData');
			$_POST['site_map_status'] = isset($_POST['site_map_status'])?$_POST['site_map_status']:'';
			if(empty($check)){
				$res = add_option('siteMapData',json_encode($_POST));	
				$resp = array('status'=>1,'msg' => 'Successfully added site map settings ','url'=>$authurl);					
			}else{
				$res = update_option('siteMapData',json_encode($_POST));	
				$resp = array('status'=>1,'msg' => 'Successfully Update site map settings ','url'=>$authurl);	
			}			
			echo json_encode($resp,JSON_UNESCAPED_SLASHES);
			die();	
		}else{
			$resp = array('status'=>0,'msg' => 'Direct access not allowed');			
			echo json_encode($resp,JSON_UNESCAPED_SLASHES);
			die();			
		}
	}

	public function GoogleTrands(){
		if(isset($_POST['action']) && $_POST['action']=="GoogleTrands"){
			// M END POINT 
			$MEPoint = !empty(get_option('m_area_end_point'))?get_option('m_area_end_point'):'https://rankyoursites.net/';
			$data['ctry'] 	= $_POST['country'];
			$curl = curl_init();

			curl_setopt_array($curl, array(
			CURLOPT_URL => $MEPoint.'google-trands',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $data,		
			));

			$response = curl_exec($curl);		
		
			$result = json_decode($response,true);
			curl_close($curl);
			echo json_encode($result,JSON_UNESCAPED_SLASHES);
			die;		
		}else{
			$resp = array('status'=>0,'msg' => 'Direct access not allowed');			
			echo json_encode($resp,JSON_UNESCAPED_SLASHES);
			die();			
		}
	}

	public function TrendsPostCreate(){
		if(isset($_POST['action']) && $_POST['action']=="TrendsPostCreate"){
		 
			global $wpdb;
			$finalPostArray = [];
			foreach ($_POST['trendsPosst'] as $key => $value) {
				array_push($finalPostArray,json_decode(base64_decode($value),true));
			}
			$rescheck = 0;
				
			foreach ($finalPostArray as $key => $comData) {
				
				$data_to_insert = array(
					'tk_name' =>$comData['Title'],					
				);
				$data_format = array('%s');	
				
				$res = $wpdb->insert('rys_trends_save_keuword', $data_to_insert, $data_format);
				$rescheck++;
			}	
		
			if($rescheck!=0){
				$resp = array('status'=>1,'msg' => 'Successfully added data');			
				echo json_encode($resp,JSON_UNESCAPED_SLASHES);
				die();
			}else{
				$resp = array('status'=>0,'msg' => 'Something went wrong. ');			
				echo json_encode($resp,JSON_UNESCAPED_SLASHES);
				die();
			}			
			/*
			$post_status = "publish";

			$current_user_id = get_current_user_id();
			$res = 0;
			if(count($finalPostArray)!=1){
				
				$i= 1;
				$pTitle = '';				
				$postHTML = '<div class="komodo-accordion">';
				foreach ($finalPostArray as $key => $value) {
					$pTitle .= ", ".$value['Title'];
					$subChildData = '';
					foreach ($value['RelatedNews']  as $key => $subChild) {  
						$subChildData .='<a href="'.$subChild["News Item URL"].'" target="_blank" class="komodo-google-trend-content">
							<img src="'.$value["Picture"].' alt="'.$value["Picture Source"].' ?>" />
							<div class="komodo-post-content">
								<span class="komodo-post-date">'.$subChild["News Item Source"]. '<span><b>.</b></span> '.$value['Hours Ago'].'</span>
								<h4>'.$subChild['News Item Title'].'</h4>
								<p>'.$subChild['News Item Snippet'].'</p>
							</div>
						</a>';
						}
					$data = array(
						'Title'=>$value["Item Title"],
						'Traffic'=>$value["Approx Traffic"],
						'Link'=>$value["Link"],
						'Date'=>$value["Publication Date"],
						'Picture'=>$value["Picture"],
						'PictureSource'=>$value["Picture Source"],
						'Description'=>$value["Description"],
						'RelatedNews'=>$value['RelatedNews']
					);                          
					$postHTML .= '<div class="komodo-accordian-item">  
						<div class="ee-checkbox">
							<input class="checkItem" type="checkbox" name="trendsPosst[]" value="'.base64_encode(json_encode($data)).'">
							<span><!-- span has design  --></span>
						</div> 
						<div class="komodo-accordian-title">
							<span class="post-counting">'.$i++.' </span>
							<div class="komodo-trend-info">
								<div class="komodo-treand-title-info">
									<a class="komodo-trend-title" href="'.$value["Link"].'" target="_blank">'.$value["Item Title"].'</a>
								<p> '.$value["Description"].'</p>
								<span class="komodo-publish-date">'.$value["Publication Date"].'</span>
								<span class="komodo-post-date">                                               
										<a href="'.$value["Link"].'" target="_blank">'.$value['RelatedNews'][0]['News Item Title'].'</a>
										<span>'.$value['RelatedNews'][0]['News Item Source'].' </span>
										<span class="bold-text">'.$value['Hours Ago'].' </span>
									</span>
								</div>
							</div>
							<div class="komodo-search-count">
								<div class="">
									'.$value["Approx Traffic"].'
									<span>searches</span>
								</div>
							</div>
							<div class="komodo-trend-thumb">                                        
								<img src="'.$value["Picture"].' alt="'.$value["Picture Source"].' ?>" />
								<h5>'.$value["Picture Source"].' ?></h5>
							</div>
						</div>
						<div class="komodo-accordian-tab">
							<div class="komodo-google-trend-posts">
								<h6>Related News</h6>
								'.$subChildData.'
							</div>
						</div>                                
					</div>';                        
					$i++;
				}						
				
				if(count($finalPostArray)==$i){
					$postHTML .= '</div>';
				}

				print_r($postHTML);
				die;
				$parts = explode(',', $pTitle);

				// Remove the first element if it is empty
				if (empty(trim($parts[0]))) {
					array_shift($parts);
				}

				// Join the array back into a string with commas
				$output = implode(',', $parts);

				// Create a new post
				$post_data = array(
					'post_title'    => $output,
					'post_content'  => $postHTML,
					'post_status'   => $post_status, // Set post status to 'publish' to make it visible immediately
					'post_author'   => $current_user_id, // ID of the post author. You can change this to match the desired author.
					'post_type'     => 'post' // Post type (e.g., 'post', 'page', 'custom_post_type')
				);
				//Insert the post into the database
				$post_id = wp_insert_post($post_data);
				if (!is_wp_error($post_id)) {
					$res++;
				}
			}else{
				foreach ($finalPostArray as $key => $value) {
					$postHTML = '<div class="google-trennds">							
									<div>'.$value['Title'].'</div>
									<div>'.$value['Traffic'].'</div>
									<div><a href="'.$value['Link'].'" target="_blank">Click Here</a></div>
									<div>'.$value['Date'].'</div>
									<div><img src="'.$value['Picture'].'"/></div>
									<div>'.$value['PictureSource'].'</div>
									<div>'.$value['Description'].'</div>
								</div>';	
								// Create a new post
					$post_data = array(
						'post_title'    => $value['Title'],
						'post_content'  => $postHTML,
						'post_status'   => $post_status, // Set post status to 'publish' to make it visible immediately
						'post_author'   => $current_user_id, // ID of the post author. You can change this to match the desired author.
						'post_type'     => 'post' // Post type (e.g., 'post', 'page', 'custom_post_type')
					);
					//Insert the post into the database
					$post_id = wp_insert_post($post_data);
					if (!is_wp_error($post_id)) {
						$res++;
					}	
				}	

			}		
			// Check if the post was inserted successfully
			if ($res) {
				// Post was inserted successfully
				$resp = array('status'=>1,'msg' => 'Successfully Create Post ');			
				echo json_encode($resp,JSON_UNESCAPED_SLASHES);
				die();	
			}*/
		}else{
			$resp = array('status'=>0,'msg' => 'Direct access not allowed');			
			echo json_encode($resp,JSON_UNESCAPED_SLASHES);
			die();			
		}
	}

	public function usersAnalyticsData(){
		
		// M END POINT 
		$MEPoint = !empty(get_option('m_area_end_point'))?get_option('m_area_end_point'):'https://rankyoursites.net/';
		$accessToken = get_option('rys_ga4access_token');
		if(isset($accessToken)){
			$token = json_decode($accessToken,true);
		}else{
			$token = "";
		}
		
		$data['functionName'] 	= $_POST['function'];
		$data['startDate'] 	= isset($_POST['startDate']) ? date('Y-m-d',strtotime($_POST['startDate'])) : date('Y-m-d', strtotime('-7 days'));
		$data['endDate'] 	= isset($_POST['endDate']) 	? date('Y-m-d',strtotime($_POST['endDate'])) : date('Y-m-d');
		$data['subDomain'] 	= isset($_POST['appName']) 	? $_POST['appName'] : '';
		$data['loCation'] 	= isset($_POST['loCation']) ? $_POST['loCation'] : 'worldwide';
		$data['type'] 		= isset($_POST['type']) ? $_POST['type'] : 'Visits'; //installs
		$data['propertyID'] = isset($_POST['propertyId']) ? $_POST['propertyId'] : ''; 
		$data['token'] =$accessToken; 

		if($_POST['chartName']=="countryWise"){				

			$curl = curl_init();
	
			curl_setopt_array($curl, array(
				CURLOPT_URL => $MEPoint.'multi-request',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $data,	
				CURLOPT_HTTPHEADER => array(
					'Bearer: '.$token['access_token'],
					'Cookie: ci_session=d3250tjk1j66ch8rurvqlvkfke02lifd'
				),	
			));
	
			$response = curl_exec($curl);			
			$result = json_decode($response,true);
			curl_close($curl);
			echo json_encode($result,JSON_UNESCAPED_SLASHES);
			die;		
			
		}else if($_POST['chartName']=="UsersActivity"){

			$data['condition'] 		= 'all'; //installs
			
			$curl = curl_init();
	
			curl_setopt_array($curl, array(
				CURLOPT_URL => $MEPoint.'multi-request',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $data,	
				CURLOPT_HTTPHEADER => array(
					'Bearer: '.$token['access_token'],
					'Cookie: ci_session=d3250tjk1j66ch8rurvqlvkfke02lifd'
				),	
			));
	
			$response = curl_exec($curl);	
				
			$result = json_decode($response,true);
			curl_close($curl);
			echo json_encode($result,JSON_UNESCAPED_SLASHES);
			die;		
		}else if($_POST['chartName']=="TopCampaigns"){
			$data['dimensions'] =  isset($_POST['dimensions']) ? $_POST['dimensions'] : 'sessionDefaultChannelGroup'; //installs
			$curl = curl_init();
	
			curl_setopt_array($curl, array(
				CURLOPT_URL => $MEPoint.'multi-request',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $data,	
				CURLOPT_HTTPHEADER => array(
					'Bearer: '.$token['access_token'],
					'Cookie: ci_session=d3250tjk1j66ch8rurvqlvkfke02lifd'
				),	
			));
	
			$response = curl_exec($curl);	
			
			$result = json_decode($response,true);
			
			curl_close($curl);

			echo $response;
			die;		
		
		}else if($_POST['chartName']=="TrafficAcquisitionSessionCampaign"){
			$data['dimensions'] =  isset($_POST['dimensions']) ? $_POST['dimensions'] : 'sessionDefaultChannelGroup'; //installs
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $MEPoint.'multi-request',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $data,	
				CURLOPT_HTTPHEADER => array(
					'Bearer: '.$token['access_token'],
					'Cookie: ci_session=d3250tjk1j66ch8rurvqlvkfke02lifd'
				),	
			));

			$response = curl_exec($curl);	
			
			$result = json_decode($response,true);
			
			curl_close($curl);

			echo $response;
			die;			
		}else if($_POST['chartName']=="PagesAndScreens"){
			
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => $MEPoint.'multi-request',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $data,	
				CURLOPT_HTTPHEADER => array(
					'Bearer: '.$token['access_token'],
					'Cookie: ci_session=d3250tjk1j66ch8rurvqlvkfke02lifd'
				),	
			));

			$response = curl_exec($curl);	
			
			$result = json_decode($response,true);
			
			curl_close($curl);
			
			echo $response;
			die;	
		}else if($_POST['chartName']=="TopEvents"){
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => $MEPoint.'multi-request',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $data,
				CURLOPT_HTTPHEADER => array(
					'Bearer: '.$token['access_token'],
					'Cookie: ci_session=d3250tjk1j66ch8rurvqlvkfke02lifd'
				),		
			));

			$response = curl_exec($curl);	
			
			$result = json_decode($response,true);
			
			curl_close($curl);
			
			echo $response;
			die;	
		}
	}

	public function compititionDataDelet(){
		if(isset($_POST['action']) && $_POST['action']=="compititionDataDelet"){
			global $wpdb;
		    
			$table_name = 'rys_check_competition_data';

			$condition = array('cc_id' =>$_POST['ID']);
		
			$res = $wpdb->delete($table_name, $condition);
			$msg ="Successfully deleted";
			if($res){
				echo json_encode(array('status'=>1,'msg'=>$msg));
			}else{
				echo json_encode(array('status'=>0,'msg'=>'Something went wrong; please try again later'));
			}
			die();
		}else{
			$resp = array('status'=>0,'msg' => 'Direct access not allowed');			
			echo json_encode($resp,JSON_UNESCAPED_SLASHES);
			die();			
		}
	}

	public function seedKeywordDelete(){
		if(isset($_POST['action']) && $_POST['action']=="seedKeywordDelete"){
			global $wpdb;
		   
			$table_name = 'rys_trends_save_keuword';
            $delIds = [];
            if($_POST['DelType']=="single"){
			    $condition = array('tk_id' =>$_POST['ID']);
			         
			    $res = $wpdb->delete($table_name, $condition);
		        array_push($delIds,$_POST['ID']);
            }else{
                $IDS = explode(',',$_POST['IDs']);
               
                foreach($IDS as $id){
    			    $condition = array('tk_id' =>$id);
    			 
    			    $res = $wpdb->delete($table_name, $condition);
    			    array_push($delIds,$id);
                }
            }
	
			$msg ="Successfully deleted";
			if($res){
				echo json_encode(array('status'=>1,'msg'=>$msg,'delID'=>$delIds));
			}else{
				echo json_encode(array('status'=>0,'msg'=>'Something went wrong; please try again later'));
			}
			die();
		}else{
			$resp = array('status'=>0,'msg' => 'Direct access not allowed');			
			echo json_encode($resp,JSON_UNESCAPED_SLASHES);
			die();			
		}
	}

    public function exactResultShow(){
      
        $string = "".$_POST['exw']."";
        // Replace spaces with the + symbol
        $modified_string = str_replace(' ', '+', $string);
        $url = 'https://www.google.com/search?q=%22'.$modified_string.'%22&gl=us&hl=en&pws=0';

        // Initialize cURL session
        $curl = curl_init();
        
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36',
            CURLOPT_FOLLOWLOCATION => true,
        ));
        
        // Execute the request
        $response = curl_exec($curl);
        
        // Check for errors
        if (curl_errno($curl)) {
            echo 'cURL error: ' . curl_error($curl);
            curl_close($curl);
            exit();
        }
        
        // Close cURL session
        curl_close($curl);
        
        // Use regular expression to extract the "About x results" part of the HTML
        preg_match('/About ([\d,]+) results/', $response, $matches);
        
        if (isset($matches[1])) {
            echo "Total Results: " . $matches[1];
        } else {
            echo "Could not find any accurate results for this";
        }
        die;
    }

	
}
