
<?php

 #############################################################################
 # IMDb Link transformer                                                     #
 # written by Prometheus group                                               #
 # http://www.ikiru.ch/blog                                                  #
 # ------------------------------------------------------------------------- #
 # This program is free software; you can redistribute and/or modify it      #
 # under the terms of the GNU General Public License (see LICENSE)           #
 # ------------------------------------------------------------------------- #
 #									     #
 #  Function : Cache management for IMDbLT		                     #
 #									     #
 #############################################################################


// included files
include_once ('functions.php');

// get files to be able to make a search movie
define('IMDBPHP_CONFIG',dirname(__FILE__).'/../config.php');
require_once (dirname(__FILE__)."/../class/imdb.class.php");

if ($engine) $engine = 'pilot'; // $engine variable comes from config.php
switch($engine) { 		
	case "pilot":
	  require_once(dirname(__FILE__)."/../class/pilot.class.php");
	  require_once(dirname(__FILE__)."/../class/pilot_person.class.php");
	  break;
	default:
	  require_once(dirname(__FILE__)."/../class/imdb.class.php");
	  require_once(dirname(__FILE__)."/../class/imdb_person.class.php");
	  break;
}

##################################### delete a specific file

if (($_GET['dothis'] == 'delete') && ($_GET['type'])) {

	// prevent drama
	if ( (is_null($imdbOptionsc['imdbcachedir'])) || (!is_numeric($_GET['where']))  )
		exit( __("Cannot work this way.", "imdb") );

		if (($_GET['type'])== 'movie') {
			// things to delete
			$filetodeletetitle=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Title";
			$filetodeletetaglines=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Taglines";
			$filetodeletesoundtrack=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Soundtrack";
			$filetodeletereleaseinfo=$imdbOptionsc['imdbcachedir'].$_GET['where'].".ReleaseInfo";
			$filetodeletetitlefoot=$imdbOptionsc['imdbcachedir'].$_GET['where'].".TitleFoot";
			$filetodeletegoofs=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Goofs";
			$filetodeletecredits=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Credits";
			$filetodeletemovieconnections=$imdbOptionsc['imdbcachedir'].$_GET['where'].".MovieConnections";
			$filetodeleteofficialsites=$imdbOptionsc['imdbcachedir'].$_GET['where'].".OfficialSites";
			$filetodeleteplot=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Plot";
			$filetodeletequotes=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Quotes";
			$filetodeletetrailers=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Trailers";
			$filetodeletepics=$imdbOptionsc['imdbphotodir'].$_GET['where']."_big.jpg";
			$filetodeletepics2=$imdbOptionsc['imdbphotodir'].$_GET['where'].".jpg";

			// delete things
			if( file_exists($filetodeletetitle ) && fopen($filetodeletetitle, 'w') or die( __("This file does not exist", "imdb") ) ) {
			 	if (file_exists($filetodeletetitle )) unlink ($filetodeletetitle);
			 	if (file_exists($filetodeletetaglines )) unlink ($filetodeletetaglines);
			 	if (file_exists($filetodeletesoundtrack )) unlink ($filetodeletesoundtrack);
			 	if (file_exists($filetodeletereleaseinfo )) unlink ($filetodeletereleaseinfo);
			 	if (file_exists($filetodeletetitlefoot )) unlink ($filetodeletetitlefoot);
			 	if (file_exists($filetodeletegoofs )) unlink ($filetodeletegoofs);
			 	if (file_exists($filetodeletecredits )) unlink ($filetodeletecredits);
			 	if (file_exists($filetodeletemovieconnections )) unlink ($filetodeletemovieconnections);
			 	if (file_exists($filetodeleteofficialsites )) unlink ($filetodeleteofficialsites);
			 	if (file_exists($filetodeleteplot )) unlink ($filetodeleteplot);
			 	if (file_exists($filetodeletequotes )) unlink ($filetodeletequotes);
			 	if (file_exists($filetodeletetrailers )) unlink ($filetodeletetrailers);
			 	if (file_exists($filetodeletepics )) unlink ($filetodeletepics);
			 	if (file_exists($filetodeletepics2 )) unlink ($filetodeletepics2);
			}
		}


		if (($_GET['type'])== 'people') {
			// things to delete
			$filetodeletebio=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Bio";
			$filetodeletename=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Name";
			$filetodeletepublicity=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Publicity";
			$filetodeletepics=$imdbOptionsc['imdbphotodir']."nm".$_GET['where'].".jpg";

			// delete things
			if( file_exists($filetodeletename ) && fopen($filetodeletename, 'w') or die( __("This file does not exist", "imdb") ) ) {
			 	if (file_exists($filetodeletebio )) unlink ($filetodeletebio);
			 	if (file_exists($filetodeletename )) unlink ($filetodeletename);
			 	if (file_exists($filetodeletepublicity )) unlink ($filetodeletepublicity);
			 	if (file_exists($filetodeletepics )) unlink ($filetodeletepics);
			}
		}

		?>
		<div style="padding:5px;background:lightYellow;border:1px solid #E6DB55;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;"><?php _e("Cache successfully deleted, back to the", "imdb"); ?> <a href="?page=imdblt_options&subsection=cache&cacheoption=manage"><?php _e("previous page", "imdb"); ?></a></div>
		<?php
			exit();
}

##################################### refresh a peliculiar file

if (($_GET['dothis'] == 'refresh') && ($_GET['type'])) {

	// prevent drama
	if ( (is_null($imdbOptionsc['imdbcachedir'])) || (!is_numeric($_GET['where']))  )
		exit( __("Cannot work this way.", "imdb") );

	if (($_GET['type'])== 'movie') {

		// things to delete
		$filetodeletetitle=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Title";
		$filetodeletetaglines=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Taglines";
		$filetodeletesoundtrack=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Soundtrack";
		$filetodeletereleaseinfo=$imdbOptionsc['imdbcachedir'].$_GET['where'].".ReleaseInfo";
		$filetodeletetitlefoot=$imdbOptionsc['imdbcachedir'].$_GET['where'].".TitleFoot";
		$filetodeletegoofs=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Goofs";
		$filetodeletecredits=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Credits";
		$filetodeletemovieconnections=$imdbOptionsc['imdbcachedir'].$_GET['where'].".MovieConnections";
		$filetodeleteofficialsites=$imdbOptionsc['imdbcachedir'].$_GET['where'].".OfficialSites";
		$filetodeleteplot=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Plot";
		$filetodeletequotes=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Quotes";
		$filetodeletetrailers=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Trailers";
		$filetodeletepics=$imdbOptionsc['imdbphotodir'].$_GET['where']."_big.jpg";
		$filetodeletepics2=$imdbOptionsc['imdbphotodir'].$_GET['where'].".jpg";

		// delete things
		if( file_exists($filetodeletetitle ) && fopen($filetodeletetitle, 'w') or die( __("This file does not exist", "imdb") ) ) {
		 	if (file_exists($filetodeletetitle )) unlink ($filetodeletetitle);
		 	if (file_exists($filetodeletetaglines )) unlink ($filetodeletetaglines);
		 	if (file_exists($filetodeletesoundtrack )) unlink ($filetodeletesoundtrack);
		 	if (file_exists($filetodeletereleaseinfo )) unlink ($filetodeletereleaseinfo);
		 	if (file_exists($filetodeletetitlefoot )) unlink ($filetodeletetitlefoot);
		 	if (file_exists($filetodeletegoofs )) unlink ($filetodeletegoofs);
		 	if (file_exists($filetodeletecredits )) unlink ($filetodeletecredits);
		 	if (file_exists($filetodeletemovieconnections )) unlink ($filetodeletemovieconnections);
		 	if (file_exists($filetodeleteofficialsites )) unlink ($filetodeleteofficialsites);
		 	if (file_exists($filetodeleteplot )) unlink ($filetodeleteplot);
		 	if (file_exists($filetodeletequotes )) unlink ($filetodeletequotes);
		 	if (file_exists($filetodeletetrailers )) unlink ($filetodeletetrailers);
		 	if (file_exists($filetodeletepics )) unlink ($filetodeletepics);
		 	if (file_exists($filetodeletepics2 )) unlink ($filetodeletepics2);
		}

		// get again the movie
		ob_start();
		$moviespecificid = $_GET['where'];
		$imdballmeta = "imdb-movie-widget-noname";
		include( 'imdb-movie.inc.php');
		$out = ob_get_contents();
		ob_end_clean();

	}

	if (($_GET['type'])== 'people') {
		// things to delete
		$filetodeletebio=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Bio";
		$filetodeletename=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Name";
		$filetodeletepublicity=$imdbOptionsc['imdbcachedir'].$_GET['where'].".Publicity";
		$filetodeletepics=$imdbOptionsc['imdbphotodir']."nm".$_GET['where'].".jpg";

		// delete things
		if( file_exists($filetodeletename ) && fopen($filetodeletename, 'w') or die( __("This file does not exist", "imdb") ) ) {
		 	if (file_exists($filetodeletebio )) unlink ($filetodeletebio);
		 	if (file_exists($filetodeletename )) unlink ($filetodeletename);
		 	if (file_exists($filetodeletepublicity )) unlink ($filetodeletepublicity);
		 	if (file_exists($filetodeletepics )) unlink ($filetodeletepics);
		}

		// get again the person
		if ($engine=="pilot") $person = new pilot_person ($objpiple);	// depending of the previous $engine variable
			      		else $person = new imdb_person ($objpiple);		 // choose between pilot & imdb class

		$person->setid ($_GET['where']); // set object search
		$name = $person->name(); // search title related to movie id
		$bio = $person->bio(); 
		$photo_url = $person->photo_localurl();
	}


	?>
	<div id="theend" name="theend" style="border:1px solid #E6DB55;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;background:lightYellow;padding:5px;"><?php _e("Cache succesfully refreshed, close the window.", "imdb"); ?></div>
	<?php
exit();
}

##################################### let's display real cache option page

?>
<script type="text/javascript" src="<?php echo IMDBLTURLPATH; ?>js/highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo IMDBLTURLPATH; ?>css/highslide.css" type="text/css" media="screen" />
<script type="text/javascript">
hs.graphicsDir = '<?php echo IMDBLTURLPATH; ?>js/highslide/graphics/';
hs.showCredits = false;
	hs.outlineType = 'custom';
	hs.easing = 'linearTween';
	hs.align = 'center';
	hs.useBox = true;
	hs.registerOverlay(
		{ html: '<div class=\"closebutton\" onclick=\"return hs.close(this)\" title=\"Close\"></div>',
		position: 'top right',
		useOnHtml: true, fade: 2 }
	);
</script>
<style>
.highslide-wrapper .highslide-footer .highslide-resize {
display: none; /* ------------disable resize------------ */
float: right;
height: 11px;
width: 11px;
background: url(highslide/graphics/resize.gif);
} 
</style>


<div id="tabswrap">
	<ul id="tabs">
		<li><img src="<?php echo IMDBLTURLPATH ?>pics/admin-cache-options.png" align="absmiddle" width="16px" />&nbsp;&nbsp;<a title="<?php _e("General options", 'imdb');?>" href="?page=imdblt_options&subsection=cache&cacheoption=option"><?php _e ('General options', 'imdb'); ?></a></li>
		<li>&nbsp;&nbsp;<img src="<?php echo IMDBLTURLPATH ?>pics/admin-cache-management.png" align="absmiddle" width="16px" />&nbsp;&nbsp;<a title="<?php _e("Manage Cache", 'imdb');?>" href="?page=imdblt_options&subsection=cache&cacheoption=manage"><?php _e ("Manage Cache", 'imdb'); ?></a></li>
	</ul>
</div>


<div id="poststuff" class="metabox-holder">

	<div style="padding:0 30px 30px 30px;"><?php _e("Cache is crucial to IMDb link transformer operation. As first imdb searchs are quite time consuming, if you do not want to kill your server but instead want quickest browsing experience, you will use cache. Pay a special attention to directories that need to be created.", 'imdb'); ?></div>

<?php if ( ($_GET['cacheoption'] == "option") || (!isset($_GET['cacheoption'] )) ) { 	/////////////////////////////////// Cache options  ?>


	<div class="postbox-container">
		<div id="left-sortables" class="meta-box-sortables" >

		<form method="post" name="imdbconfig_save" action="<?php echo $_SERVER[ "REQUEST_URI"]; ?>" >
			<div class="inside">
			<table class="option widefat">

		<?php //------------------------------------------------------------------ =[cache directories]=- ?>
		<tr>
			<td colspan="3" class="titresection"><?php _e('Cache directories (folders have to be created and writable)', 'imdb'); ?></td>
		</tr>
		<tr>
			<td class="td-aligntop" width="33%">
				<label for="imdb_imdbcachedir">
					<?php _e('Cache directory (absolute path)', 'imdb'); ?>
					<br />
					<span style="font-size:smaller">
					<?php 						// display cache folder size
					if (!isEmptyDir($imdbOptionsc['imdbcachedir'])) {
						foreach (glob($imdbOptionsc['imdbcachedir']."*") as $filename) {
							$filenamesize1 += filesize($filename);
						}
						echo _e('Cache size is currently', 'imdb') . ' ' . round($filenamesize1/1048576, 2) . " Mb \n";
					} else {  echo _e('Cache size is currently', 'imdb') . " 0 Mb \n"; }
					?>
					</span>
					</label>
			</td>
			<td colspan="2"><input type="text" name="imdb_imdbcachedir" size="70" value="<?php _e(apply_filters('format_to_edit',$imdbOptionsc['imdbcachedir']), 'imdb') ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php if (file_exists($imdbOptionsc['imdbcachedir'])) { // check if folder exists
				echo '<span style="color:green;">';
				_e("Folder exists.", 'imdb');
				echo '</span>';
				} else {
				echo '<span style="color:red">';
				_e("Folder doesn't exist!", 'imdb');
				echo '</span>'; }
				if (file_exists($imdbOptionsc['imdbcachedir'])) { // check if permissions are ok
					if ( substr(sprintf('%o', fileperms($imdbOptionsc['imdbcachedir'])), -3) == "777") { 
					echo ' <span style="color:green;">';
					_e("Permissions OK.", 'imdb');
					echo '</span>';
					} else { 
					echo ' <span style="color:red">';
					_e("Check folder permissions!", 'imdb');
					echo '</span>'; 
					}
				} ?>
				<div class="explain"><?php _e('Absolute path to store data retrieved from the IMDb website. Has to be <a href="http://codex.wordpress.org/Changing_File_Permissions" title="permissions how-to on wordpress website">writable</a> by the webserver.','imdb');?> <br /><?php _e('Default:','imdb');?> "<?php echo ABSPATH; ?>wp-content/cache/imdb/'<br />
			</div>
			</td>
		</tr>
		<tr>
			<td class="td-aligntop">
				<label for="imdb_imdbphotodir">
				<?php _e('Photo directory (absolute path)', 'imdb'); ?>
					<br />
					<span style="font-size:smaller">
					<?php						// display cache folder size
					if (!isEmptyDir($imdbOptionsc['imdbphotodir'], "2")) { // isEmptyDir with "2"
						foreach (glob($imdbOptionsc['imdbphotodir']."*") as $filename) {
							$filenamesize2 += filesize($filename);
						}
						echo _e('Cache size is currently', 'imdb') . ' ' . round($filenamesize2/1048576, 2) . " Mb \n";
					} else {  echo _e('Cache size is currently', 'imdb') . " 0 Mb \n"; }
					?>
					</span>
				</label>
			</td>
			<td colspan="2"><input type="text" name="imdb_imdbphotodir" size="70" value="<?php _e(apply_filters('format_to_edit',$imdbOptionsc['imdbphotodir']), 'imdb') ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php if (file_exists($imdbOptionsc['imdbphotodir'])) { // check if folder exists
				echo '<span style="color:green">';
				_e("Folder exists.", 'imdb');
				echo '</span>';
				} else {
				echo '<span style="color:red">';
				_e("Folder doesn't exist!", 'imdb');
				echo '</span>'; } 
				if (file_exists($imdbOptionsc['imdbcachedir'])) { // check if permissions are ok
					if ( substr(sprintf('%o', fileperms($imdbOptionsc['imdbphotodir'])), -3) == "777") { 
						echo ' <span style="color:green;">';
						_e("Permissions OK.", 'imdb');
						echo '</span>';
					} else { 
						echo ' <span style="color:red">';
						_e("Check folder permissions!", 'imdb');
						echo '</span>'; 
					}
				} ?>
		<div class="explain"><?php _e('Absolute path to store images retrieved from the IMDb website. Has to be <a href="http://codex.wordpress.org/Changing_File_Permissions" title="permissions how-to on wordpress website">writable</a> by the webserver.', 'imdb');?> <br /><?php _e('Default:','imdb');?> "<?php echo ABSPATH; ?>wp-content/cache/imdb/images/"</div>
			</td>
		</tr>

		<tr>
			<td class="td-aligntop"><label for="imdb_imdbphotoroot"><?php _e('Photo directory (url)', 'imdb'); ?></label>
			</td>
			<td colspan="2"><input type="text" name="imdb_imdbphotoroot" size="70" value="<?php _e(apply_filters('format_to_edit',$imdbOptionsc['imdbphotoroot']), 'imdb') ?>">
				<div class="explain"><?php _e('URL corresponding to photo directory.','imdb');?> <br /><?php _e('Default:','imdb');?> "<?php echo $imdbOptions['blog_adress']; ?>/wp-content/cache/imdb/images/"</div>
			</td>
		</tr>

			
		<?php //------------------------------------------------------------------ =[cache options]=- ?>
		<tr>
			<td colspan="3" class="titresection"><?php _e('Cache general options', 'imdb'); ?></td>
		</tr>

		<tr>
			<td>
				<?php _e('Store cache?', 'imdb'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" id="imdb_imdbstorecache_yes" name="imdb_imdbstorecache" value="1" <?php if ($imdbOptionsc['imdbstorecache'] == "1") { echo 'checked="checked"'; }?> onClick="GereControle('imdb_imdbstorecache_yes', 'imdb_imdbusecache_yes', '0');GereControle('imdb_imdbstorecache_yes', 'imdb_imdbcacheexpire', '0');GereControle('imdb_imdbstorecache_yes', 'imdb_imdbconverttozip_yes', '0');GereControle('imdb_imdbstorecache_yes', 'imdb_imdbusezip_yes', '0');" /><label for="imdb_imdbstorecache_yes"><?php _e('Yes', 'imdb'); ?></label><input type="radio" id="imdb_imdbstorecache_no" name="imdb_imdbstorecache" value="" <?php if ($imdbOptionsc['imdbstorecache'] == 0) { echo 'checked="checked"'; } ?> onClick="GereControle('imdb_imdbstorecache_yes', 'imdb_imdbusecache_yes', '0');GereControle('imdb_imdbstorecache_yes', 'imdb_imdbcacheexpire', '0');GereControle('imdb_imdbstorecache_yes', 'imdb_imdbconverttozip_yes', '0');GereControle('imdb_imdbstorecache_yes', 'imdb_imdbusezip_yes', '0');"/><label for="imdb_imdbstorecache_no"><?php _e('No', 'imdb'); ?></label>
			</td>
			<td>
				<?php _e('Use cache?', 'imdb'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" id="imdb_imdbusecache_yes" name="imdb_imdbusecache" value="1" <?php if ($imdbOptionsc['imdbusecache'] == "1") { echo 'checked="checked"'; }?> onClick="GereControle('imdb_imdbusecache_yes', 'imdb_imdbcacheexpire', '0');" /><label for="imdb_imdbusecache_yes"><?php _e('Yes', 'imdb'); ?></label><input type="radio" id="imdb_imdbconverttozip_no" name="imdb_imdbusecache" value="" <?php if ($imdbOptionsc['imdbusecache'] == 0) { echo 'checked="checked"'; } ?> onClick="GereControle('imdb_imdbusecache_yes', 'imdb_imdbcacheexpire', '0');" /><label for="imdb_imdbusecache_no"><?php _e('No', 'imdb'); ?></label>
			</td>
			<td>
				<label for="imdb_imdbcacheexpire"><?php _e('Cache expire', 'imdb'); ?></label>
				<input type="text" id="imdb_imdbcacheexpire" name="imdb_imdbcacheexpire" size="7" value="<?php _e(apply_filters('format_to_edit',$imdbOptionsc['imdbcacheexpire']), 'imdb') ?>" <?php if ( ($imdbOptionsc['imdbusecache'] == 0) || ($imdbOptionsc['imdbstorecache'] == 0) ) { echo 'disabled="disabled"'; }; ?> />
				 
				<input type="checkbox"  value="0" id="imdb_imdbcacheexpire_definitive" onclick="javascript:document.getElementById ('imdb_imdbcacheexpire').value = document.getElementById ('imdb_imdbcacheexpire_definitive').value;" <?php if ($imdbOptionsc['imdbcacheexpire'] == 0) { echo 'checked="checked"'; }; ?> /><label for="imdb_imdbcacheexpire"><?php _e('(never)','imdb');?></label>

			</td>
		</tr>
		<tr>
			<td class="td-aligntop">
				<div class="explain"><?php _e('Whether to store the pages retrieved for later use. When activated, you have to check you created the folders', 'imdb'); ?> <?php _e('Cache directory', 'imdb'); ?> <?php _e('and', 'imdb'); ?> <?php _e('Photo directory (folder)', 'imdb'); ?>. <br /><?php _e('Default:','imdb');?> <?php _e('Yes', 'imdb'); ?></div>
			</td>
			<td class="td-aligntop">
				<div class="explain"><?php _e('Whether to use a cached page to retrieve the information (if available).', 'imdb'); ?> <br /><?php _e('Default:','imdb');?> <?php _e('Yes', 'imdb'); ?></div>
			</td>
			<td class="td-aligntop">
				<div class="explain"><?php _e('Cache files older than this value (in seconds) will be automatically deleted. Insert "0" or click "never" to keep cache files forever.', 'imdb'); ?> <br /><?php _e('Default:','imdb');?> "2592000" <?php _e('(one month)', 'imdb'); ?></div>
			</td>
		</tr>

		<?php //------------------------------------------------------------------ =[zip]=- ?>
		<tr>
			<td colspan="3" class="titresection"><?php _e('Cache zip options', 'imdb'); ?></td>
		</tr>
		<tr>
			<td>
				<?php _e('Convert to zip?', 'imdb'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" id="imdb_imdbconverttozip_yes" name="imdb_imdbconverttozip" value="1" <?php if ($imdbOptionsc['imdbconverttozip'] == "1") { echo 'checked="checked"'; }?> /><label for="imdb_imdbconverttozip_yes"><?php _e('Yes', 'imdb'); ?></label><input type="radio" id="imdb_imdbconverttozip_no" name="imdb_imdbconverttozip" value="" <?php if ($imdbOptionsc['imdbconverttozip'] == 0) { echo 'checked="checked"'; } ?> /><label for="imdb_imdbconverttozip_no"><?php _e('No', 'imdb'); ?></label>
			</td>
		
			<td>
				<?php _e('Use zip?', 'imdb'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" id="imdb_imdbusezip_yes" name="imdb_imdbusezip" value="1" <?php if ($imdbOptionsc['imdbusezip'] == "1") { echo 'checked="checked"'; }?> /><label for="imdb_imdbusezip_yes"><?php _e('Yes', 'imdb'); ?></label><input type="radio" id="imdb_imdbusezip_no" name="imdb_imdbusezip" value="" <?php if ($imdbOptionsc['imdbusezip'] == 0) { echo 'checked="checked"'; } ?>/><label for="imdb_imdbusezip_no"><?php _e('No', 'imdb'); ?></label>
			</td>
			<td></td>
		</tr>
		<tr>
			<td class="td-aligntop">
				<div class="explain"><?php _e('Convert non-zip cache-files to zip (check file permissions!)', 'imdb'); ?> <br /><?php _e('Default:','imdb');?> <?php _e('Yes', 'imdb'); ?></div>
			</td>
			<td class="td-aligntop">
				<div class="explain"><?php _e('Use zip compression for caching the retrieved html-files.', 'imdb'); ?> <br /><?php _e('Default:','imdb');?> <?php _e('Yes', 'imdb'); ?></div>
			</td>
			<td></td>
		</tr>


		<?php //------------------------------------------------------------------ =[cache details]=- ?>
		<tr>
			<td colspan="3" class="titresection"><?php _e('Cache details', 'imdb'); ?></td>
		</tr>
		<tr>
			<td>
				<?php _e('Show advanced cache details', 'imdb'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" id="imdb_imdbcachedetails_yes" name="imdb_imdbcachedetails" value="1" <?php if ($imdbOptionsc['imdbcachedetails'] == "1") { echo 'checked="checked"'; }?> onClick="GereControle('imdb_imdbcachedetails_yes', 'imdb_imdbcachedetailsshort_yes', '0');GereControle('imdb_imdbcachedetails_yes', 'imdb_imdbcachedetailsshort_no', '0');" />
				<label for="imdb_imdbcachedetails_yes"><?php _e('Yes', 'imdb'); ?></label>
				<input type="radio" id="imdb_imdbcachedetails_no" name="imdb_imdbcachedetails" value="" <?php if ($imdbOptionsc['imdbcachedetails'] == 0) { echo 'checked="checked"'; } ?> onClick="GereControle('imdb_imdbcachedetails_yes', 'imdb_imdbcachedetailsshort_yes', '0');GereControle('imdb_imdbcachedetails_yes', 'imdb_imdbcachedetailsshort_no', '0');" />
				<label for="imdb_imdbcachedetails_no"><?php _e('No', 'imdb'); ?></label>

			</td>
		
			<td>
				<?php _e('Quick advanced cache details', 'imdb'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" id="imdb_imdbcachedetailsshort_yes" name="imdb_imdbcachedetailsshort" value="1" <?php if ($imdbOptionsc['imdbcachedetailsshort'] == "1") { echo 'checked="checked"'; }?> <?php if ($imdbOptionsc['imdbcachedetails'] == 0) { echo 'disabled="disabled"'; }; ?> />
				<label for="imdb_imdbcachedetailsshort_yes"><?php _e('Yes', 'imdb'); ?></label>
				<input type="radio" id="imdb_imdbcachedetailsshort_no" name="imdb_imdbcachedetailsshort" value="" <?php if ($imdbOptionsc['imdbcachedetailsshort'] == 0) { echo 'checked="checked"'; } ?> <?php if ($imdbOptionsc['imdbcachedetails'] == 0) { echo 'disabled="disabled"'; }; ?> />
				<label for="imdb_imdbcachedetailsshort_no"><?php _e('No', 'imdb'); ?></label>
			</td>
			<td></td>
		</tr>
		<tr>
			<td class="td-aligntop">
				<div class="explain"><?php _e('To show or not advanced cache details, which allows to specifically delete a movie cache. Be carefull with this option, if you have a lot of cached movies, it could crash this page. When yes is selected, an additional menu "manage cache" will appear next to the cache "General Options" menu.', 'imdb'); ?> <br /><?php _e('Default:','imdb');?> <?php _e('No', 'imdb'); ?></div>
			</td>
			<td class="td-aligntop">
				<div class="explain"><?php _e('Allow a quicker load time for the "manage cache" page, by displaying shorter movies and people presentation. Usefull when you have several of those. This option is available when "Show advanced cache details" is activated.', 'imdb'); ?> <br /><?php _e('Default:','imdb');?> <?php _e('No', 'imdb'); ?></div>
			</td>
			<td></td>
		</tr>



		</table>
		</div>
		
		<?php //------------------------------------------------------------------ =[Submit selection]=- ?>
			<div class="submit submit-imdb" align="center">
				<?php wp_nonce_field('reset_cache_options_check', 'reset_cache_options_check'); //check that data has been sent only once ?>
				<input type="submit" class="button-primary" name="reset_cache_options" value="<?php _e('Reset settings', 'imdb') ?>" />
				<?php wp_nonce_field('update_cache_options_check', 'update_cache_options_check', false);  //check that data has been sent only once -- don't send _wp_http_referer twice, already sent with first wp_nonce_field -> 3rd option to "false" ?>
				<input type="submit" class="button-primary" name="update_cache_options" value="<?php _e('Update settings', 'imdb') ?>" />
			</div>
		</form>











<?php	}  // end cache options
		if ($_GET['cacheoption'] == "manage")  { 	////////////////////////////////////////////// Cache management ?>


	<div class="postbox-container">
		<div id="left-sortables" class="meta-box-sortables" >


		<?php //------------------------------------------------------------------ =[cache delete]=- ?>
		<form method="post" name="manage_imdbltcache" id="manage_imdbltcache" action="<?php echo $_SERVER[ "REQUEST_URI"]; ?>">			
			<div class="inside">
				<table class="option widefat">
					<tr>
						<td colspan="3" class="titresection"><?php _e('Cache management', 'imdb'); ?></td>
					</tr>
		<?php	if (file_exists($imdbOptionsc['imdbcachedir']) && ($imdbOptionsc['imdbstorecache'])) { // check if folder exists & store cache option is selected
				if ($imdbOptionsc['imdbcachedetails'] == "1") { // imdbcachedetails options is selected ?>


		<?php //------------------------------------------------------------------ =[movies management]=- ?>
		<tr>
			<td>	
				<div>::<?php _e('Movie\'s detailed cache', 'imdb'); ?>::</div>
				<div style="padding-left:20%;padding-right:20%;"><?php _e('If you want to refresh movie\'s cache regardless the cache expiration time, you may either tick movie\'s checkbox(es) related to the movie you want to delete and click on "delete cache", or you may click on individual movies "refresh". The first way will require an additional movie refresh - from you post, for instance.', 'imdb'); ?>
				<br />
				<br />
				<?php _e('You may also either delete individually the cache or by group.', 'imdb'); ?>
				<br />
				<br />
				</div>
				<table style="margin-left:auto;margin-right:auto;" width="90%"><tr>
				<?php
				if(!$dh = @opendir($imdbOptionsc['imdbcachedir'])){return;}

				while (false !== ($obj = readdir($dh))) {
					if($obj == '.' || $obj == '..' || $obj == 'images') {continue;} //exclude these files
					if ( (substr( $obj, -5 ) != "Title" ) && (substr( $obj, -11 ) != "Title.pilot" ) ) {continue;} // keep only Title files
				$filepath = $imdbOptionsc['imdbcachedir'].$obj;
				$obj = substr($obj, 0, 7); // get correct id

				if ($engine=="pilot") $movie = new pilot ($obj); // depending of the previous $engine variable
			      		else $movie = new imdb ($obj);		 // choose between pilot & imdb class

				$movie->setid ($obj); // set object search
				$title = $movie->title(); // search title related to movie id

				if ($imdbOptionsc['imdbcachedetailsshort'] == 1)  { // display only cache movies' names, quicker loading

					$data[] = '<input type="checkbox" id="imdb_cachedeletefor_'.$title.'" name="imdb_cachedeletefor[]" value="'.$obj.'" /><label for="imdb_cachedeletefor[]">'.$title.'</label>'; // send input and results into array
					flush();

					} else { // display every cache movie details, longer loading

				$moviepicturelink = (($photo_url = $movie->photo_localurl() ) != FALSE) ? 'src="'.$imdbOptionsc['imdbphotoroot'].$obj.'.jpg" alt="'.$title.'"' : 'src="'.IMDBLTURLPATH.'pics/no_pics.gif" alt="'.__('no picture', 'imdb').'"'; // get either local picture or if no local picture exists, display the default one
				$data[] = '	<td>
							<img id="pic_'.$title.'" style="float:left;padding-right:5px;" '.$moviepicturelink.' width="40px">

							<input type="checkbox" id="imdb_cachedeletefor_'.$title.'" name="imdb_cachedeletefor[]" value="'.$obj.'" /><label for="imdb_cachedeletefor[]" style="font-weight:bold">'.$title.'</label> <br />'. __('last updated on ', 'imdb').date ("j M Y H:i:s", filemtime($filepath)).' 

							<div id="refresh_edit_'.$title.'" class="row-actions" style="float:right;">
								<span class="edit"><a href="?page=imdblt_options&subsection=cache&dothis=refresh&where='.$obj.'&type=movie" onclick="return hs.htmlExpand(this, { wrapperClassName: \'no-footer no-move\', objectType: \'iframe\', width: 30, objectWidth: 20, objectHeight: 1, headingEval: \'this.a.innerHTML\', headingText: \'Cache for this movie successfully refreshed! Please close.\', wrapperClassName: \'titlebar\' } )" title="Refresh cache for *'.$title.'*">'.__("refresh", "imdb").'</a></span>

								<span class="delete"><a href="?page=imdblt_options&subsection=cache&dothis=delete&where='.$obj.'&type=movie" 
	onclick=\'if ( confirm( "You are about to delete *'.$title.'* from cache. Click Cancel to stop or OK to continue." ) ) { return true;}return false;\' title="Delete cache for *'.$title.'*">'.__("delete", "imdb").'</a></span>
							</div>
						</td>'; // send input and results into array

					flush();

					} //end quick/long loading $imdbOptionsc['imdbcachedetailsshort']
				} // end while

				closedir($dh);

				if (empty($data)){
					echo '<div style="font-weight:bold;color:red;text-align:center;">'.__('No file found in cache folder.','imdb').'</div>';
				} else {
				asort ($data);
				$nbfilm="1";
					foreach ($data as $inputline) {
						echo $inputline;
						if ( ($nbfilm % 5) == "0" ) { // split into 5 movies by line
							echo '</tr><tr>';
						}
						$nbfilm++;
					}
				}

				
				?>
				</tr></table>
				<br />
					<div align="center">
						<input type="button" name="CheckAll" value="Check All" onClick="checkAll(document.getElementsByName('imdb_cachedeletefor[]'));">
						<input type="button" name="UnCheckAll" value="Uncheck All" onClick="uncheckAll(document.getElementsByName('imdb_cachedeletefor[]'));">
					</div>
						<br />
						<br />
					<div align="center">
						<?php wp_nonce_field('update_imdbltcache_check', 'update_imdbltcache_check'); //check that data has been sent only once  ?>
						<input type="submit" class="button-primary" name="update_imdbltcache" value="<?php _e('Delete cache', 'imdb') ?>" />
						<br/>
						<?php echo _e('Warning!', 'imdb'); ?>
						<?php echo _e('This button will to delete specific cache files selected from cache folder.', 'imdb'); ?>
					</div>

			</td>
		</tr>


		<?php //------------------------------------------------------------------ =[people delete]=- ?>
		<tr>
			<td>	
				<div>::<?php _e('People\'s detailed cache', 'imdb'); ?>::</div>
				<div style="padding-left:20%;padding-right:20%;"><?php _e('If you want to refresh people\'s cache regardless the cache expiration time, you may either tick people checkbox(es) related to the person you want to delete and click on "delete cache", or you may click on individual people\'s "refresh". The first way will require an additional people refresh - from you post, for instance.', 'imdb'); ?>
				<br /><br />
				<?php _e('You may also either delete individually the cache or by group.', 'imdb'); ?>
				</div>
				<br /><br />
				<table style="margin-left:auto;margin-right:auto;" width="90%"><tr>
				<?php
				if(!$di = @opendir($imdbOptionsc['imdbcachedir'])){return;}
				$datapeople="";

				while (false !== ($objpiple = readdir($di))) {
					if($objpiple == '.' || $objpiple == '..' || $objpiple == 'images') {continue;} //exclude these files
					if ( (substr( $objpiple, -4 ) != "Name" ) && (substr( $objpiple, -10 ) != "Name.pilot" ) ) {continue;} // keep only Name files
				$filepath = $imdbOptionsc['imdbcachedir'].$objpiple;
				$objpiple = substr($objpiple, 0, 7); // get correct id

				if ($engine=="pilot") $person = new pilot_person ($objpiple);	// depending of the previous $engine variable
			      		else $person = new imdb_person ($objpiple);		 // choose between pilot & imdb class

				$person->setid ($objpiple); // set object search
				$name = $person->name(); // search title related to movie id

					if ($imdbOptionsc['imdbcachedetailsshort'] == 1)  { // display only cache peoples' names, quicker loading

						$datapeople[] = '<input type="checkbox" id="imdb_cachedeletefor_people_'.$name.'" name="imdb_cachedeletefor_people[]" value="'.$objpiple.'" /><label for="imdb_cachedeletefor_people[]">'.$name.'</label>'; // send input and results into array

					flush();
					} else { // display every cache people details, longer loading


				$picturelink = (($photo_url = $person->photo_localurl() ) != FALSE) ? 'src="'.$imdbOptionsc['imdbphotoroot']."nm".$objpiple.'.jpg" alt="'.$name.'"' : 'src="'.IMDBLTURLPATH.'pics/no_pics.gif" alt="'.__('no picture', 'imdb').'"'; // get either local picture or if no local picture exists, display the default one
				$datapeople[] = '	
						<td>
							<img id="pic_'.$name.'" style="float:left;padding-right:5px;" '.$picturelink.' width="40px" alt="no pic">
							<input type="checkbox" id="imdb_cachedeletefor_people_'.$name.'" name="imdb_cachedeletefor_people[]" value="'.$objpiple.'" /><label for="imdb_cachedeletefor_people_[]" style="font-weight:bold">'.$name.'</label><br />'. __('last updated on ', 'imdb').date ("j M Y H:i:s", filemtime($filepath)).'
							
							<div class="row-actions" style="float:right;">
								<span class="view"><a href="?page=imdblt_options&subsection=cache&dothis=refresh&where='.$objpiple.'&type=people" onclick="return hs.htmlExpand(this, { wrapperClassName: \'no-footer no-move\', objectType: \'iframe\', width: 30, objectWidth: 20, objectHeight: 1, headingEval: \'this.a.innerHTML\', headingText: \'Cache for this person successfully refreshed! Please close.\', wrapperClassName: \'titlebar\' } )" title="Refresh cache for *'.$name.'*">'.__("refresh", "imdb").'</a></span> 

								<span class="delete"><a href="?page=imdblt_options&subsection=cache&dothis=delete&where='.$objpiple.'&type=people" onclick=\'if ( confirm( "You are about to delete *'.$name.'* from cache. Click Cancel to stop or OK to continue." ) ) { return true;}return false;\' title="Delete cache for *'.$name.'*">'.__("delete", "imdb").'</a></span>
							</div>
						</td>'; // send input and results into array

				flush();
					} //end quick/long loading $imdbOptionsc['imdbcachedetailsshort']

				} // end while
				closedir($di);

				if (empty($datapeople)){
					echo '<div style="font-weight:bold;color:red;text-align:center;">'.__('No file found in cache folder.','imdb').'</div>';
				} else {
				asort ($datapeople);
				$nbperso="1";
					foreach ($datapeople as $inputline) {
						echo $inputline;
						if ( ($nbperso % 5) == "0" ) { // split into 5 movies by line
							echo '</tr><tr>';
						}
						$nbperso++;
					}
				} ?>
				</tr></table>
				<br />
					<div align="center">
						<input type="button" name="CheckAll" value="Check All" onClick="checkAll(document.getElementsByName('imdb_cachedeletefor_people[]'));">
						<input type="button" name="UnCheckAll" value="Uncheck All" onClick="uncheckAll(document.getElementsByName('imdb_cachedeletefor_people[]'));">
					</div>
						<br />
						<br />
					<div align="center">
						<?php wp_nonce_field('update_imdbltcache_check', 'update_imdbltcache_check'); //check that data has been sent only once  ?>
						<input type="submit" class="button-primary" name="update_imdbltcache" value="<?php _e('Delete cache', 'imdb') ?>" />
						<br/>
						<?php echo _e('Warning!', 'imdb'); ?>
						<?php echo _e('This button will to delete specific cache files selected from cache folder.', 'imdb'); ?>
					</div>

			</td>
		</tr>
		<?php		} // end $imdbOptionsc['imdbcachedetails'] check ?>

		<tr>
			<td>
				<div>::<?php _e('Global cache', 'imdb'); ?>::</div>
				<div><?php _e('If you want to reset the entire cache (including names & pictures cache) click on "reset cache". Beware, there is no undo.', 'imdb'); ?></div>
				<div class="submit submit-imdb" align="center">
					<strong><?php echo __('Warning!', 'imdb'); ?></strong>


					<br/>
<?php				 	//check that data has been sent only once -- don't send _wp_http_referer twice, 
					//already sent with first wp_nonce_field -> 3rd option to "false" 
					wp_nonce_field('reset_imdbltcache_check', 'reset_imdbltcache_check', false); ?>
					<input type="submit" class="button-primary" name="reset_imdbltcache" value="<?php _e('Delete all cache', 'imdb') ?>" /> 
					<br/>
					<?php echo _e('This button will <strong>delete all cache</strong> stored in cache folder.', 'imdb'); ?>

				</div>
			</td>
		</tr>


		<?php } else {  // else (if folder exists) -> if folder does not exist  ?>
		<tr>
			<td>
		<?php 
				echo _e('A cache folder has to be created and the cache storage option has to be activated before having the opportunity to manage cache!', 'imdb');
		?>
			</td>
		</tr>
		<?php } // end "check if folder exists & store cache option is selected" ?>




				</table>
			</div>
		</form>

<?php } //end cache management ?>

		</div>
	</div>
</div>
<br clear="all">

