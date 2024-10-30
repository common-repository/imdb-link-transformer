<?php

 #############################################################################
 # IMDb Link transformer                                                     #
 # written by Prometheus group                                               #
 # http://www.ikiru.ch/blog                                                  #
 # ------------------------------------------------------------------------- #
 # This program is free software; you can redistribute and/or modify it      #
 # under the terms of the GNU General Public License (see LICENSE)           #
 # ------------------------------------------------------------------------- #
 #       			                                             #
 #  Function : Configuration file             				     #
 #       	  			                                     #
 #############################################################################

#--------------------------------------------------=[ define constants ]=--

define('IMDBLTURLPATH', plugins_url() . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('IMDBLTFILE', plugin_basename( dirname(__FILE__)) );
define('IMDBLTABSPATH', str_replace("\\","/", WP_PLUGIN_DIR . '/' . plugin_basename( dirname(__FILE__) ) . '/' ));
define('IMDBBLOG', 'http://www.ikiru.ch/blog');
define('IMDBHOMEPAGE', 'http://www.ikiru.ch/blog/imdb-link-transformer-wordpress-plugin');
define('IMDBPHP_CONFIG',dirname(__FILE__).'/config.php');
define('PILOT_IMDBFALLBACK', TRUE);

#--------------------------------------------------=[ configuration class ]=--

class imdb_settings_conf extends mdb_config {

	var $imdbAdminOptionsName = "imdbAdminOptions";
	var $imdbWidgetOptionsName = "imdbWidgetOptions";
	var $imdbCacheOptionsName = "imdbCacheOptions";

	function imdb_settings_conf() { //constructor
	}
	
	function notice($code, $msg) { // from more smilies plugin
		switch ($code) {
			default:
			case 1: // simple notice
				echo '<div id="message" class="updated fade"><p>'. $msg .'</p></div>';
				break;
			case 3: // simple error
				echo '<div id="error" class="updated fade-ff0000"><p>'. $msg .'</p></div>';
				break;
			case 2: // advanced notice
			case 4: // advanced error
				echo '<div class="wrap">'. $msg .'</div>';
				break;
			case 5: // super duper wicked crazy critical error!
				die($msg);
				break;
		}
	}

	function init() {
			$this->get_imdb_admin_option();
			$this->get_imdb_widget_option();
			$this->get_imdb_cache_option();
	}

	//Returns an array of admin options
	function get_imdb_admin_option() {		

	$imdbAdminOptions = array(
	#--------------------------------------------------=[ Basic ]=--
	'blog_adress' => get_bloginfo('url'),
	'imdbplugindirectory' => get_bloginfo('url').'/wp-content/plugins/imdb-link-transformer/',
	'imdbwebsite' => "akas.imdb.com",
	'pilotsite' => "uk.moviepilot.com",
	'imdbcoversize' => false,
	'imdbcoversizewidth' => '100',
	#--------------------------------------------------=[ Technical ]=--

	'pilot_imdbfill'=> '1',
	'pilot_apikey'=> "",
	'imdb_utf8recode'=> true,
	'imdbmaxresults' => 10,
	'popupLarg' => '540',
	'popupLong' => '350',
	'imdbpicsize' => '25',
	'imdbpicurl' => 'pics/imdb-link.png',
	'imdbimgdir' => 'pics/',
	'imdbsearchvariant' => "",
	'imdbdirectsearch' => true,
	'imdbsourceout' => false,
	'imdbdisplaylinktoimdb' => true,
	'imdbdebug' => 0,
	'PEAR' => false,
	'imdbwordpress_bigmenu'=>false,
	'imdbwordpress_tooladminmenu'=>true,
	'imdbpopup_highslide'=>false,
	'imdbtaxonomy'=> false,
	);
	$imdbOptions = get_option($this->imdbAdminOptionsName);
		if (!empty($imdbOptions)) {
			foreach ($imdbOptions as $key => $option)
				$imdbAdminOptions[$key] = $option;
		}
		update_option($this->imdbAdminOptionsName, $imdbAdminOptions);
		return $imdbAdminOptions;
	} // end function get_imdb_admin_option ()


	//Returns an array of cache options
	function get_imdb_cache_option() {		

	$imdbCacheOptions = array(
	#--------------------------------------------------=[ Cache ]=--
	'imdbcachedir' => ABSPATH . 'wp-content/cache/imdb/',
	'imdbphotoroot' => get_bloginfo('siteurl').'/wp-content/cache/imdb/images/',
	'imdbphotodir' => ABSPATH . 'wp-content/cache/imdb/images/',
	'imdbstorecache' => true,
	'imdbusecache' => true,
	'imdbconverttozip' => true,
	'imdbusezip' => true,
	'imdbcacheexpire' => "2592000", // one month
	'imdbcachedetails'=> false,
	'imdbcachedetailsshort'=> false,
	);
	$imdbOptionsc = get_option($this->imdbCacheOptionsName);
		if (!empty($imdbOptionsc)) {
			foreach ($imdbOptionsc as $key => $option)
				$imdbCacheOptions[$key] = $option;
		}
		update_option($this->imdbCacheOptionsName, $imdbCacheOptions);
		return $imdbCacheOptions;
	} // end function get_imdb_cache_option ()

	//Returns an array of widget options
	function get_imdb_widget_option() {
	#--------------------------------------------------=[ Widget ]=--
	$imdbWidgetOptions = array(
	'imdbautopostwidget' => false,
	'imdblinkingkill' => false,
	'imdbwidgettitle' => true,
	'imdbwidgetpic' => true,
	'imdbwidgetruntime' => false,
	'imdbwidgetdirector' => true,
	'imdbwidgetcountry' => false,
	'imdbwidgetactor' => true,
	'imdbwidgetactornumber' => '10',
	'imdbwidgetcreator' => false,
	'imdbwidgetrating' => false,
	'imdbwidgetlanguage' => false,
	'imdbwidgetgenre' => false,
	'imdbwidgetwriter' => true,
	'imdbwidgetproducer' => false,
	'imdbwidgetkeywords' => false,
	'imdbwidgetprodCompany' => false,
	'imdbwidgetplot' => false,
	'imdbwidgetplotnumber' => false,
	'imdbwidgetgoofs' => false,
	'imdbwidgetgoofsnumber' => false, 
	'imdbwidgetcomments' => false,
	'imdbwidgetcommentsnumber' => false, 
	'imdbwidgetquotes' => false,
	'imdbwidgetquotesnumber' => false,
	'imdbwidgettaglines' => false,
	'imdbwidgettaglinesnumber' => false,
	'imdbwidgetcolors' => false,
	'imdbwidgetalsoknow' => false,
	'imdbwidgetcomposer' => false,
	'imdbwidgetsoundtrack' => false,
	'imdbwidgetsoundtracknumber' => false,
	'imdbwidgetofficialSites' => false,
	'imdbwidgetsource' => true,
	'imdbwidgetonpost' => true,
	'imdbwidgetonpage' => true,
	'imdbwidgetyear' => false,
	'imdbwidgettrailer' => false,

	'imdbwidgetorder'=>array("title" => "1", "pic" => "2","runtime" => "3", "director" => "4", "country" => "5", "actor" => "6", "creator" => "7", "rating" => "8", "language" => "9","genre" => "10","writer" => "11","producer" => "12", "keywords" => "13", "prodCompany" => "14", "plot" => "15", "goofs" => "16", "comments" => "17", "quotes" => "18", "taglines" => "19", "colors" => "20", "alsoknow" => "21", "composer" => "22", "soundtrack" => "23", "trailer" => "24", "officialSites" => "25", "source" => "26" ),

	'imdbtaxonomycolor' => false,
	'imdbtaxonomycomposer' => false,
	'imdbtaxonomycountry' => false,
	'imdbtaxonomycreator' => false,
	'imdbtaxonomydirector' => false,
	'imdbtaxonomygenre' => true,
	'imdbtaxonomykeywords' => false,
	'imdbtaxonomylanguage' => false,
	'imdbtaxonomyproducer' => false,
	'imdbtaxonomyactor' => false,
	'imdbtaxonomywriter' => false,
	'imdbtaxonomytitle' => false,
	);

	$imdbOptionsw = get_option($this->imdbWidgetOptionsName);
		if (!empty($imdbOptionsw)) {
			foreach ($imdbOptionsw as $key => $option)
				$imdbWidgetOptions[$key] = $option;
		}
		update_option($this->imdbWidgetOptionsName, $imdbWidgetOptions);
		return $imdbWidgetOptions;
	} // end function get_imdb_widget_option ()

	//Prints out the admin page
	function printAdminPage() {
		$imdbOptions = $this->get_imdb_admin_option();
		$imdbOptionsc = $this->get_imdb_cache_option();
		$imdbOptionsw = $this->get_imdb_widget_option();

		if (isset($_POST['update_imdbSettings'])) { //--------------------save data selected (general options)

			foreach ($_POST as $key=>$postvalue) {		
				$keynoimdb = str_replace ( "imdb_", "", $key);
				if (isset($_POST["$key"])) {
						$imdbOptions["$keynoimdb"] = $_POST["$key"];
				}
			}

			check_admin_referer('update_imdbSettings_check', 'update_imdbSettings_check'); // check if the refer is ok before saving data
			
			// display message on top
			$this->notice(1, '<strong>'. __('Options saved.', 'imdb') .'</strong>');
	
			update_option($this->imdbAdminOptionsName, $imdbOptions); 
		
		} 
		if (isset($_POST['reset_imdbSettings'])) { //---------------------reset options selected (general options)

			check_admin_referer('reset_imdbSettings_check', 'reset_imdbSettings_check'); // check if the refer is ok before saving data 

			update_option($this->imdbAdminOptionsName, $imdbAdminOptions);
			
			// display message on top
			$this->notice(1, '<strong>'. __('Options reset.', 'imdb') .'</strong>'); 

			// refresh the page to reset display for values; &reset=true is the only way to reset all values and truly see them reset
			// also check plugin collision -> follow a link instead of automatic refresh
			if (!headers_sent()) {
				header("Refresh: 0;url=".$_SERVER[ "REQUEST_URI"]."&reset=true", false);
			} else {
			$this->notice(1, '<strong>'. __('Plugin collision. Please follow ').'<a href="'.$_SERVER[ "REQUEST_URI"].'&reset=true">'.__('this link.', 'imdb').'</a>'.'</strong>'); 
			}
			//header("Location: ".$_SERVER[ "REQUEST_URI"]."&reset=true"); --- less sexy way

		} 
		if  (isset($_POST['update_imdbwidgetSettings']) ) { //--------------save data selected (widget options)

			foreach ($_POST as $key=>$postvalue) {
				$keynoimdb = str_replace ( "imdb_", "", $key);
					if (isset($_POST["$key"])) {
						$imdbOptionsw["$keynoimdb"] = $_POST["$key"];
					}
			}

			// Special part related to details order
			if (isset($_POST[imdb_imdbwidgetorder]) ){ 
					$data = array_flip(explode(" ", $_POST[imdb_imdbwidgetorder]));
					$imdbOptionsw[imdbwidgetorder] = $data;
			}

			// check if the refer is ok before saving data
			check_admin_referer('update_imdbwidgetSettings_check', 'update_imdbwidgetSettings_check'); 

			// be sure that data posted in imdb_imdbwidgetorder (options-widget.php) are not empty; otherwise, it would
			// replace $imdbOptions[imdbwidgetorder] values by an empty one.
			if ( $_POST[imdb_imdbwidgetorder] == "empty") {
				if (!headers_sent()) {
					header("Location: ".$_SERVER[ "REQUEST_URI"], false);
					die();
				} else {
				$this->notice(1, '<strong>'. __('Error. You have to select a value.', 'imdb'). '</strong>' ); 
					die();
				}
			}
			update_option($this->imdbWidgetOptionsName, $imdbOptionsw);
			
			// display message on top
			$this->notice(1, '<strong>'. __('Options saved.', 'imdb') .'</strong>'); 
				
		 } 
		if (isset($_POST['reset_imdbwidgetSettings'])) { //--------------reset options selected  (widget options)

			check_admin_referer('reset_imdbwidgetSettings_check', 'reset_imdbwidgetSettings_check'); // check if the refer is ok before saving data
			update_option($this->imdbWidgetOptionsName, $imdbWidgetOptionsw);

			// display message on top
			$this->notice(1, '<strong>'. __('Options reset.', 'imdb') .'</strong>'); 
	
			// refresh the page to reset display for values; &reset=true is the only way to reset all values and truly see them reset
			// also check plugin collision -> follow a link instead of automatic refresh
			if (!headers_sent()) {
				header("Refresh: 0;url=".$_SERVER[ "REQUEST_URI"]."&reset=true", false);
			} else {
			$this->notice(1, '<strong>'. __('Plugin collision. Please follow ').'<a href="'.$_SERVER[ "REQUEST_URI"].'&reset=true">'.__('this link.', 'imdb').'</a>'.'</strong>'); 
			}
			//header("Location: ".$_SERVER[ "REQUEST_URI"]."&reset=true"); --- less sexy way

		} 
		if (isset($_POST['update_cache_options'])) { //--------------------save data selected (cache options)

			foreach ($_POST as $key=>$postvalue) {		
				$keynoimdb = str_replace ( "imdb_", "", $key);
				if (isset($_POST["$key"])) {
						$imdbOptionsc["$keynoimdb"] = $_POST["$key"];
				}
			}

			check_admin_referer('update_cache_options_check', 'update_cache_options_check'); // check if the refer is ok before saving data
			
			// display message on top
			$this->notice(1, '<strong>'. __('Options saved.', 'imdb') .'</strong>');
	
			update_option($this->imdbCacheOptionsName, $imdbOptionsc); 
		
		} 
		if (isset($_POST['reset_cache_options'])) { //---------------------reset options selected (cache options)

			check_admin_referer('reset_cache_options_check', 'reset_cache_options_check'); // check if the refer is ok before saving data 

			update_option($this->imdbCacheOptionsName, $imdbCacheOptions);
			
			// display message on top
			$this->notice(1, '<strong>'. __('Options reset.', 'imdb') .'</strong>'); 

			// refresh the page to reset display for values; &reset=true is the only way to reset all values and truly see them reset
			// also check plugin collision -> follow a link instead of automatic refresh
			if (!headers_sent()) {
				header("Refresh: 0;url=".$_SERVER[ "REQUEST_URI"]."&reset=true", false);
			} else {
			$this->notice(1, '<strong>'. __('Plugin collision. Please follow ').'<a href="'.$_SERVER[ "REQUEST_URI"].'&reset=true">'.__('this link.', 'imdb').'</a>'.'</strong>'); 
			}
			//header("Location: ".$_SERVER[ "REQUEST_URI"]."&reset=true"); --- less sexy way

		} 
		if (isset($_POST['reset_imdbltcache'])) {  //---------------------reset detected, delete all cache files (cache options)

			check_admin_referer('reset_imdbltcache_check', 'reset_imdbltcache_check'); // check if the refer is ok before saving data 

			$this->notice(1, '<strong>'. __('All cache deleted.', 'imdb') .'</strong>'); 

			// refresh the page to reset display for values; &reset=true is the only way to reset all values and truly see them reset
			// also check plugin collision -> follow a link instead of automatic refresh
			if (!headers_sent()) {
				header("Refresh: 0;url=".$_SERVER[ "REQUEST_URI"]."&reset=true", false);
			} else {
			$this->notice(1, '<strong>'. __('Plugin collision. Please follow ').'<a href="'.$_SERVER[ "REQUEST_URI"].'&reset=true">'.__('this link.', 'imdb').'</a>'.'</strong>'); 
			}

			unlinkRecursive ( $imdbOptionsc['imdbcachedir'] );


		}
		if (isset($_POST['update_imdbltcache'])) { //---------------------update detected, delete some cache files (cache options)

			check_admin_referer('update_imdbltcache_check', 'update_imdbltcache_check'); // check if the refer is ok before saving data 

			$this->notice(1, '<strong>'. __('Part cache deleted.', 'imdb') .'</strong>'); 

			// for movies
			for ($i = 0; $i < count ($_POST ['imdb_cachedeletefor']); $i++) {
				foreach ( glob($imdbOptionsc['imdbcachedir'].$_POST ['imdb_cachedeletefor'][$i].".*") as $cacheTOdelete) {
					if($cacheTOdelete == $imdbOptionsc['imdbcachedir'].'.' || $cacheTOdelete == $imdbOptionsc['imdbcachedir'].'..') {
						continue;
					} 
					unlink ("$cacheTOdelete");
				}
			}

			// for people
			for ($i = 0; $i < count ($_POST ['imdb_cachedeletefor_people']); $i++) {
				foreach ( glob($imdbOptionsc['imdbcachedir'].$_POST ['imdb_cachedeletefor_people'][$i].".*") as $cacheTOdelete) {
					if($cacheTOdelete == $imdbOptionsc['imdbcachedir'].'.' || $cacheTOdelete == $imdbOptionsc['imdbcachedir'].'..') {
						continue;
					} 
					unlink ("$cacheTOdelete");
				}
			}


		}
		//----------------------------------------------------------display the admin settings options ?>

<div class=wrap>
	<?php screen_icon('options-general'); ?>
	<h2>IMDb link transformer options</h2>
	<br />
	
	<div class="subpage">
	
	<div align="left" style="float:left" >
			<img src="<?php echo IMDBLTURLPATH ?>pics/admin-general.png" align="absmiddle" width="16px" />&nbsp;
		<a title="<?php _e('General Options', 'imdb'); ?>" href="?page=imdblt_options"> <?php _e('General Options', 'imdb'); ?></a> 
			
		<?php 	### sub-page is relative to what is activated
			### check if widget is active, and/or direct search option ?>
		<?php if ( ($imdbOptions['imdbdirectsearch'] == "1") && (is_active_widget(widget_imdbwidget)) ){ ?>

			&nbsp;&nbsp;<img src="<?php echo IMDBLTURLPATH ?>pics/admin-widget-inside.png" align="absmiddle" width="16px" />&nbsp;
		<a title="<?php _e('Widget/Inside post Options', 'imdb'); ?>" href="?page=imdblt_options&subsection=widgetoption"><?php _e('Widget/Inside post Options', 'imdb'); ?></a>
		<?php } elseif ( ($imdbOptions['imdbdirectsearch'] == "1") && (! is_active_widget(widget_imdbwidget)) ) { ?>

			&nbsp;&nbsp;<img src="<?php echo IMDBLTURLPATH ?>pics/admin-widget-inside.png" align="absmiddle" width="16px" />&nbsp;
		<a title="<?php _e('Widget/Inside post Options', 'imdb'); ?>" href="?page=imdblt_options&subsection=widgetoption"><?php _e('Widget/Inside post Options', 'imdb'); ?></a> (<em><a href="widgets.php"><?php _e('Widget unactivated', 'imdb'); ?>)</a></em>)

		<?php } elseif ( (!$imdbOptions['imdbdirectsearch'] == "1") && (is_active_widget(widget_imdbwidget)) )  { ?>
			&nbsp;&nbsp;<img src="<?php echo IMDBLTURLPATH ?>pics/admin-widget-inside.png" align="absmiddle" width="16px" />&nbsp;
		<a title="<?php _e('Widget/Inside post Options', 'imdb'); ?>" href="?page=imdblt_options&subsection=widgetoption"><?php _e('Widget/Inside post Options', 'imdb'); ?></a> (<em><a href="?page=imdblt_options&generaloption=advanced#imdb_imdbdirectsearch_yes"><?php _e('Direct search', 'imdb'); ?></a> <?php _e('unactivated', 'imdb'); ?></em>)		

		<?php } else { ?>
			&nbsp;&nbsp;<img src="<?php echo IMDBLTURLPATH ?>pics/admin-widget-inside.png" align="absmiddle" width="16px" />&nbsp;
		<a title="<?php _e('Widget/Inside post Options', 'imdb'); ?>" href="?page=imdblt_options&subsection=widgetoption"><?php _e('Widget/Inside post Options', 'imdb'); ?></a> (<em><a href="?page=imdblt_options&generaloption=advanced#imdb_imdbdirectsearch_yes"><?php _e('Direct search', 'imdb'); ?></a></em> & <em><a href="widgets.php"><?php _e('Widget unactivated', 'imdb'); ?></a></em>)

		<?php } ?>
			&nbsp;&nbsp;<img src="<?php echo IMDBLTURLPATH ?>pics/admin-cache.png" align="absmiddle" width="16px" />&nbsp;
		<a title="<?php _e('Cache management', 'imdb'); ?>" href="?page=imdblt_options&subsection=cache"><?php _e('Cache management', 'imdb'); ?></a>
	</div>
	<div align="right" >
			&nbsp;&nbsp;<img src="<?php echo IMDBLTURLPATH ?>pics/admin-help.png" align="absmiddle" width="16px" />&nbsp;
		<a title="<?php _e('How to use IMDb link transformer, check FAQs & changelog', 'imdb');?>" href="?page=imdblt_options&subsection=help">
			<?php _e('IMDb link transformer help', 'imdb'); ?>
		</a> 
	</div>
	</div>
	
	<?php ### select the sub-page
	
	if (empty($_GET['subsection'])) { ?>
		<form method="post" name="imdbconfig_save" action="<?php echo $_SERVER[ "REQUEST_URI"]; ?>" >
			<?php include (dirname (__FILE__) . '/inc/options-general.php'); ?>
		</form>
	<?php } 
	// if (($_GET['subsection'] == "widgetoption") && ($imdbOptions['imdbdirectsearch'] == "1")) {		--- old way
	if ($_GET['subsection'] == "widgetoption")  {	?>
		<form method="post" name="imdbconfig_save" action="<?php echo $_SERVER[ "REQUEST_URI"]; ?>" >
			<?php include (dirname (__FILE__) . '/inc/options-widget.php'); ?>
		</form>
	<?php }
	elseif ($_GET['subsection'] == "cache")  {
		$test = $this->get_imdb_admin_option(); //this variable has to be sent to new page
		$engine = $test['imdbsourceout'];
		include (dirname (__FILE__) . '/inc/options-cache.php');} 
	elseif ($_GET['subsection'] == "help")  {	
		include (dirname (__FILE__) . '/inc/help.php');} 
	// end subselection ?>

	<?php imdblt_admin_signature (); ?>

<?php	

		} //End function printAdminPage() 

} //End class
				

#--------------------------------------------------=[ Language ]=--

// Where the language files resides
// Edit only if you know what you are doing

load_plugin_textdomain('imdb', 'wp-content/plugins/imdb-link-transformer/lang');

#--------------------------------------------------=[ Class to be called from original imdb classes ]=--

class mdb_config {
	var $imdb_admin_values;
	var $imdb_cache_values;
	protected $pilot_imdbfill;

	function __construct() {
	global $imdb_admin_values, $imdb_cache_values;

	$this->pilotsite = $imdb_admin_values['pilotsite'];
	$this->pilot_imdbfill = $imdb_admin_values['pilot_imdbfill'];
	$this->pilot_apikey = $imdb_admin_values['pilot_apikey'];
	$this->imdb_utf8recode = $imdb_admin_values['imdb_utf8recode'];
	$this->imdbsite = $imdb_admin_values['imdbwebsite'];
	$this->imdbplugindirectory = $imdb_admin_values['imdbplugindirectory'];
	$this->searchvariant = $imdb_admin_values['imdbsearchvariant'];
	$this->debug = $imdb_admin_values['imdbdebug'];
	$this->maxresults = $imdb_admin_values['imdbmaxresults'];
	$this->cachedir = $imdb_cache_values['imdbcachedir'];
	$this->photodir = $imdb_cache_values['imdbphotodir'];
	$this->imdb_img_url = $imdb_cache_values['imdbimgdir'];
	$this->cache_expire = $imdb_cache_values['imdbcacheexpire'];
	$this->photoroot = $imdb_cache_values['imdbphotoroot'];
	$this->storecache = $imdb_cache_values['imdbstorecache'];
	$this->usecache = $imdb_cache_values['imdbusecache'];
	$this->converttozip = $imdb_cache_values['imdbconverttozip'];
	$this->usezip = $imdb_cache_values['imdbusezip'];

	/** Where the local IMDB images reside (look for the "showtimes/" directory)
	*  This should be either a relative, an absolute, or an URL including the
	*  protocol (e.g. when a different server shall deliver them)
	* @class imdb_config
	* @attribute string imdb_img_url
	* Cannot be changed in wordpress plugin 
	*/
	$this->imdb_img_url = $imdb_admin_values['imdbplugindirectory'].'/pics/showtimes';

	################################################# Browser agent used to get data; usually, doesn't need any change
	/** Set the default user agent (if none is detected)
	* @attribute string user_agent
	*/
	$this->default_agent = 'Mozilla/5.0 (X11; U; Linux i686; en; rv:1.9.2.3) Gecko/20100101 Firefox/6.0';
	/** Enforce the use of a special user agent
	* @attribute string force_agent
	*/
	$this->force_agent = '';
	/** Trigger the HTTP referer
	*  This is required in some places. However, if you think you need to disable
	*  this behaviour, do it here.
	*/
	$this->trigger_referer = TRUE;	
	
	
	}

}

?>
