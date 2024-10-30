
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
 #  Function : general configuration admin page                              #
 #									     #
 #############################################################################

// included files
include_once ('functions.php');

?>

<div id="tabswrap">
	<ul id="tabs">
		<li><img src="<?php echo IMDBLTURLPATH ?>pics/admin-general-path.png" align="absmiddle" width="16px" />&nbsp;&nbsp;<a title="<?php _e("Paths & Layout", 'imdb');?>" href="?page=imdblt_options&generaloption=base"><?php _e ('Paths & Layout', 'imdb'); ?></a></li>

		<li>&nbsp;&nbsp;<img src="<?php echo IMDBLTURLPATH ?>pics/admin-general-advanced.png" align="absmiddle" width="16px" />&nbsp;&nbsp;<a title="<?php _e("Advanced", 'imdb');?>" href="?page=imdblt_options&generaloption=advanced"><?php _e ("Advanced", 'imdb'); ?></a></li>
	</ul>
</div>


<div id="poststuff" class="metabox-holder">

<?php if ( ($_GET['generaloption'] == "base") || (!isset($_GET['generaloption'] )) ) { 	////////// Paths & Layout section  ?>

	<div style="padding:0 30px 30px 30px;"><?php _e ("Options below don't need usually any complementary setup. However, you can widely customize IMDb link transformer according your needs.", 'imdb'); ?></div>

	<div class="postbox">
		<h3 class="hndle" id="directories" name="directories"><?php _e('Paths: url & folders', 'imdb'); ?></h3>
	</div>

	<div class="inside">
	<table class="option widefat">

		<?php //------------------------------------------------------------------=[ web adresses ]=- ?>

		<tr>
			<td class="td-aligntop"><label for="imdb_blog_adress"><?php _e('Blog adress', 'imdb'); ?></label>
			</td>
			<td width="80%"><input type="text" name="imdb_blog_adress" size="70" value="<?php _e(apply_filters('format_to_edit',$imdbOptions['blog_adress']), 'imdb') ?>" >
				<div class="explain"><?php _e('Where the blog is installed.', 'imdb'); ?> <br /><?php _e('Default:','imdb');?> "<?php echo $imdbOptions['blog_adress']; ?>"</div>
			</td>
			
		</tr>
		<tr>
			<td class="td-aligntop"><label for="imdb_imdbplugindirectory"><?php _e('Plugin directory', 'imdb'); ?></label>
			</td>
			<td><input type="text" name="imdb_imdbplugindirectory" size="70" value="<?php _e(apply_filters('format_to_edit',$imdbOptions['imdbplugindirectory']), 'imdb') ?>">
				<div class="explain"><?php _e('Where <strong>imdb link transformer</strong> is installed.', 'imdb'); ?> <br /><?php _e('Default:','imdb');?> "<?php echo $imdbOptions['imdbplugindirectory']; ?>"</div>
			</td>
		</tr>
		
	</table>
	</div>

	
	<br />
	<br />

	<div class="postbox">
		<h3 class="hndle" id="layout" name="layout"><?php _e('Layout', 'imdb'); ?></h3>
	</div>

	<div class="inside">
	<table class="option widefat">
		<?php //------------------------------------------------------------------ =[Popup]=- ?>
		<tr>
			<td colspan="3" class="titresection">
				<img src="<?php echo $imdbOptions['imdbplugindirectory']; ?>pics/popup.png" width="60" align="absmiddle" />&nbsp;&nbsp;&nbsp;
				<?php _e('Popup', 'imdb'); ?></td>
		</tr>
		
		<tr>
			<td width="33%">
				<label for="imdb_popupLarg"><?php _e('Width', 'imdb'); ?></label>
				<input type="text" name="imdb_popupLarg" size="5" value="<?php _e(apply_filters('format_to_edit',$imdbOptions['popupLarg']), 'imdb') ?>" >
			</td>
			<td width="33%">
				<label for="imdb_popupLong"><?php _e('Height', 'imdb'); ?></label>
				<input type="text" name="imdb_popupLong" size="5" value="<?php _e(apply_filters('format_to_edit',$imdbOptions['popupLong']), 'imdb') ?>" >
			</td>
			<td width="33%">
				<?php // Warning message displayed when highslide option was set but no folder "highslide" exists
				if (($imdbOptions['imdbpopup_highslide'] == "1") && (!is_dir(IMDBLTABSPATH.'js/highslide'))) {
				#notice displayed on top page
				$this->notice(1, '<span style="color:red;"><strong>'.__ ('Warning! Highslide is activated but no Highslide folder is found. Either download Highslide (see below) or click on "reset setting" at the bottom', 'imdb') .'</strong></span>');
				#notice display in highslide option field
				echo '<span style="color:red;">'.__('Warning! Highslide is activated but no Highslide folder is found. Either download Highslide (see below) or click on "reset setting" at the bottom.', 'imdb').'</span><br />'; 
				} ?>

				<?php if(is_dir(IMDBLTABSPATH.'js/highslide')) { // If the folder "highslide" exists (manually added)
					_e('Display highslide popup', 'imdb'); 
					echo '&nbsp;&nbsp;&nbsp;&nbsp; 
					<input type="radio" id="imdb_imdbpopup_highslide_yes" name="imdb_imdbpopup_highslide" value="1" ';
					if ($imdbOptions['imdbpopup_highslide'] == "1") { echo 'checked="checked"'; }
					echo ' /><label for="imdb_imdbpopup_highslide_yes">';
					_e('Yes', 'imdb');
					echo '</label><input type="radio" id="imdb_imdbpopup_highslide_no" name="imdb_imdbpopup_highslide" value="" ';
					 if ($imdbOptions['imdbpopup_highslide'] == 0) { echo 'checked="checked"'; } 
					echo '/><label for="imdb_imdbpopup_highslide_no">';
					 _e('No', 'imdb'); 
					echo '</label>';
				 } else {					// If no folder "highslide" exists, explanations
					echo __('<b>Option highslide unavailable.</b>', 'imdb').'<br /><a href="'.IMDBBLOG.'/wp-content/files/wordpress-imdb-link-transformer-highslide.zip">'. __('In order to activate it, click here and move the folder "highslide" into the "js" one!', 'imdb').'</a>&nbsp;';
				_e('Once you are done, this message will disapear.', 'imdb');
				}; ?>
				
			</td>
		</tr>
		<tr>
			<td class="td-aligntop">
				<div class="explain"><?php _e('Popup width, in pixels', 'imdb'); ?> <br /><?php _e('Default:','imdb');?> "540"</div>
			</td>
			<td class="td-aligntop">
				<div class="explain"><?php _e('Popup height, in pixels', 'imdb'); ?> <br /><?php _e('Default:','imdb');?> "350"</div>
			</td>
			<td class="td-aligntop">
				<?php if(is_dir(IMDBLTABSPATH.'js/highslide')) { // If the folder "highslide" exists (manually added) ?>
				<div class="explain"><?php _e('Highslide popup is a more stylished popup, and allows to open movie details straightly in page instead of a new popup window.', 'imdb'); ?> <br /><?php _e('Default:','imdb');?> <?php _e('Yes', 'imdb'); ?></div>
				<?php } else { // If no folder "highslide" exists, explanations
				echo '<div class="explain">';
				_e('Please note Highslide JS is licensed under a Creative Commons Attribution-NonCommercial 2.5 License, which means you need the author\'s permission to use Highslide JS on commercial websites.','imdb');
				echo '<br />';
				echo __('Website:','imdb').'&nbsp;<a href="http://highslide.com/">Highslide</a>';
				echo '</div>';
				}; ?>
			</td>
		</tr>
		
		<?php //------------------------------------------------------------------ =[Imdb link picture]=- ?>
			
		<tr>
			<td colspan="3" class="titresection">
				<img src="<?php echo $imdbOptions['imdbplugindirectory'].$imdbOptions['imdbpicurl']; ?>" width="40" align="absmiddle" />&nbsp;&nbsp;&nbsp;
				<?php _e('Imdb link picture', 'imdb'); ?>
			</td>
		</tr>
		
		<tr>
			<td class="td-aligntop">
				<?php _e('Display imdb pic?', 'imdb'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" id="imdb_imdbdisplaylinktoimdb_yes" name="imdb_imdbdisplaylinktoimdb" value="1" <?php if ($imdbOptions['imdbdisplaylinktoimdb'] == "1") { echo 'checked="checked"'; }?> onClick="GereControle('imdb_imdbdisplaylinktoimdb_yes', 'imdb_imdbpicsize', '0');GereControle('imdb_imdbdisplaylinktoimdb_yes', 'imdb_imdbpicurl', '0');" /><label for="imdb_imdbdisplaylinktoimdb_yes"><?php _e('Yes', 'imdb'); ?></label><input type="radio" id="imdb_imdbdisplaylinktoimdb_no" name="imdb_imdbdisplaylinktoimdb" value="" <?php if ($imdbOptions['imdbdisplaylinktoimdb'] == 0) { echo 'checked="checked"'; } ?>  onClick="GereControle('imdb_imdbdisplaylinktoimdb_yes', 'imdb_imdbpicsize', '0');GereControle('imdb_imdbdisplaylinktoimdb_yes', 'imdb_imdbpicurl', '0');"/><label for="imdb_imdbdisplaylinktoimdb_no"><?php _e('No', 'imdb'); ?></label>
			</td>
			<td class="td-aligntop">
				<label for="imdb_imdbpicsize"><?php _e('Size', 'imdb'); ?></label>
				<input type="text" name="imdb_imdbpicsize" id="imdb_imdbpicsize" size="5" value="<?php _e(apply_filters('format_to_edit',$imdbOptions['imdbpicsize']), 'imdb') ?>" <?php if ($imdbOptions['imdbdisplaylinktoimdb'] == 0) { echo 'disabled="disabled"'; }; ?> />
			</td>
			<td class="td-aligntop">
				<label for="imdb_imdbpicurl"><?php _e('Url', 'imdb'); ?></label>
				<input type="text" name="imdb_imdbpicurl" id="imdb_imdbpicurl" value="<?php _e(apply_filters('format_to_edit',$imdbOptions['imdbpicurl']), 'imdb') ?>" <?php if ($imdbOptions['imdbdisplaylinktoimdb'] == 0) { echo 'disabled="disabled"'; }; ?> />
			</td>
		</tr>
		<tr>
			<td class="td-aligntop">
				<div class="explain"><?php _e("Whether display imdb link (the yellow icon) or not. This picture can be found into the popup when looking for akas movies. If the option is unselected, visitors will no more have opportunity to follow links to IMDb (even if they could still follow internal links).", 'imdb'); ?> <br /><?php _e('Default:','imdb');?> <?php _e('Yes', 'imdb'); ?></div>
			</td>
			<td class="td-aligntop">
				<div class="explain"><?php _e('Size of the imdb picture. The value will correspond to the width in pixels.', 'imdb'); ?> <br /><?php _e('Default:','imdb');?> "25"</div>
			</td>
			<td>
				<div class="explain"><?php _e('Url for the imdb picture', 'imdb'); ?> <br /><?php _e('Default:','imdb');?> "pics/imdb-link.png"</div>
			</td>
		</tr>
		
		<?php //------------------------------------------------------------------ =[Imdb cover picture]=- ?>
		<tr>
			<td colspan="3" class="titresection">
				<img src="<?php echo $imdbOptions['imdbplugindirectory']; ?>pics/cover.jpg" width="60" align="absmiddle" />&nbsp;&nbsp;&nbsp;
				<?php _e('Imdb cover picture', 'imdb'); ?>
			</td>
		</tr>
		
		<tr>
			<td width="33%">
				<label for="imdb_popupLarg"><?php _e('Display only thumbnail', 'imdb'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" id="imdb_imdbcoversize_yes" name="imdb_imdbcoversize" value="1" <?php if ($imdbOptions['imdbcoversize'] == "1") { echo 'checked="checked"'; }?> /><label for="imdb_imdbcoversize_yes"><?php _e('Yes', 'imdb'); ?></label><input type="radio" id="imdb_imdbcoversize_no" name="imdb_imdbcoversize" value="" <?php if ($imdbOptions['imdbcoversize'] == 0) { echo 'checked="checked"'; } ?> /><label for="imdb_imdbcoversize_no"><?php _e('No', 'imdb'); ?></label>
			</td>
			<td width="33%">
				<label for="imdb_imdbcoversizewidth"><?php _e('Size', 'imdb'); ?></label>
				<input type="text" name="imdb_imdbcoversizewidth" id="imdb_imdbcoversizewidth" size="5" value="<?php _e(apply_filters('format_to_edit',$imdbOptions['imdbcoversizewidth']), 'imdb'); ?>" />
			</td>
			<td width="33%">
			</td>
		</tr>
		<tr>
			<td class="td-aligntop">
				<div class="explain"><?php _e('Whether to display a thumbnail or a large image cover for movies inside a post or a widget. Select "No" to choose cover picture width (a new option on the right will be available).', 'imdb'); ?> <br /><?php _e('Default:','imdb');?> <?php _e('No', 'imdb'); ?></div>
			</td>
			<td class="td-aligntop">
				<div class="explain"><?php _e('Size of the imdb cover picture. The value will correspond to the width in pixels. Delete any value to get maximum width.', 'imdb'); ?> <br /><?php _e('Default:','imdb');?> "100"</div>
			</td>
			<td class="td-aligntop">
			</td>
		</tr>
		
	</table>
	</div>
	
	<br />
	<br />


<?php	} 
	if ($_GET['generaloption'] == "advanced") { 				//////////////// Advanced section  ?>

	<div style="padding:0 30px 30px 30px;"><?php _e ("Options below can break a lot of things. Change them only if you know what you're doing.", 'imdb'); ?></div>


	<div class="inside">
	<table class="option widefat">
		<?php //------------------------------------------------------------------ =[Search]=- ?>
		<tr>
			<td colspan="3" class="titresection"><?php _e('Search, imdb part', 'imdb'); ?></td>
		</tr>

		<tr>
			<td width="33%" class="td-aligntop">
				<label for="imdb_imdbwebsite"><?php _e('Imdb address', 'imdb'); ?></label>
				<select name="imdb_imdbwebsite">
					<option <?php if($imdbOptions['imdbwebsite'] == "akas.imdb.com") echo 'selected="selected"'; ?> value="akas.imdb.com">akas.imdb.com (default)</option>
					<option <?php if($imdbOptions['imdbwebsite'] == "www.imdb.fr") echo 'selected="selected"'; ?> value="www.imdb.fr">french imdb</option>
					<option <?php if($imdbOptions['imdbwebsite'] == "uk.imdb.com") echo 'selected="selected"'; ?> value="uk.imdb.com">uk imdb</option>
					<option <?php if($imdbOptions['imdbwebsite'] == "www.imdb.de") echo 'selected="selected"'; ?> value="www.imdb.de">german imdb</option>			
					<option <?php if($imdbOptions['imdbwebsite'] == "www.imdb.it") echo 'selected="selected"'; ?> value="www.imdb.it">italian imdb</option>
				</select>
			</td>
			<td width="33%">
				<label for="imdb_imdbsearchvariant"><?php _e('Search variant', 'imdb'); ?></label>
				<select name="imdb_imdbsearchvariant">
					<option <?php if(($imdbOptions['imdbsearchvariant'] == "izzy") OR ($imdbOptions['imdbsearchvariant'] == "")) echo 'selected="selected"'; ?> value="izzy">izzy (default)</option>
					<option <?php if($imdbOptions['imdbsearchvariant'] == "sevec") echo 'selected="selected"'; ?> value="sevec">sevec</option>
					<option <?php if($imdbOptions['imdbsearchvariant'] == "moonface") echo 'selected="selected"'; ?> value="moonface">moonface</option>
				</select>
			</td>
			<td width="33%">
			</td>
		</tr>
		<tr>
			<td class="td-aligntop">
				<div class="explain"><?php _e("This is the imdb server to use. The localized ones (i.e. italian and german) are only qualified to find the movies ID - but parsing for the details will fail at the moment.", 'imdb'); ?></div>
			</td>
			<td class="td-aligntop">
				<div class="explain"><?php _e('Moviename search variant. There are different ways of searching a movie name, with slightly differing result sets. Set the variant you prefer.', 'imdb'); ?></div>
			</td>
			<td class="td-aligntop">
			</td>
		</tr>		
		
		<?php //------------------------------------------------------------------ =[misc]=- ?>
		<tr>
			<td colspan="3" class="titresection"><?php _e('Misc', 'imdb'); ?></td>
		</tr>

		<tr>
			<td>
				<?php _e('Debug mode', 'imdb'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" id="imdb_imdbdebug_yes" name="imdb_imdbdebug" value="1" <?php if ($imdbOptions['imdbdebug'] == "1") { echo 'checked="checked"'; }?> /><label for="imdb_imdbdebug_yes"><?php _e('Yes', 'imdb'); ?></label><input type="radio" id="imdb_imdbdebug_no" name="imdb_imdbdebug" value="" <?php if ($imdbOptions['imdbdebug'] == 0) { echo 'checked="checked"'; } ?>/><label for="imdb_imdbdebug_no"><?php _e('No', 'imdb'); ?></label>				
			</td>
			<td>
				<?php _e('Direct search', 'imdb'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" id="imdb_imdbdirectsearch_yes" name="imdb_imdbdirectsearch" value="1" <?php if ($imdbOptions['imdbdirectsearch'] == "1") { echo 'checked="checked"'; }?> onClick="GereControle('imdb_imdbdirectsearch_no', 'imdb_imdbmaxresults', '0');" /><label for="imdb_imdbdirectsearch_yes"><?php _e('Yes', 'imdb'); ?></label><input type="radio" id="imdb_imdbdirectsearch_no" name="imdb_imdbdirectsearch" value="" <?php if ($imdbOptions['imdbdirectsearch'] == 0) { echo 'checked="checked"'; } ?> onClick="GereControle('imdb_imdbdirectsearch_no', 'imdb_imdbmaxresults', '0');" /><label for="imdb_imdbdirectsearch_no"><?php _e('No', 'imdb'); ?></label>
			</td>
			<td>
				<?php _e('Menu for IMDB LT options', 'imdb'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" id="imdb_imdbwordpress_bigmenu_yes" name="imdb_imdbwordpress_bigmenu" value="1" <?php if ($imdbOptions['imdbwordpress_bigmenu'] == "1") { echo 'checked="checked"'; }?> /><label for="imdb_imdbwordpress_bigmenu_yes"><?php _e('Yes', 'imdb'); ?></label><input type="radio" id="imdb_imdbwordpress_bigmenu_no" name="imdb_imdbwordpress_bigmenu" value="" <?php if ($imdbOptions['imdbwordpress_bigmenu'] == 0) { echo 'checked="checked"'; } ?>  /><label for="imdb_imdbwordpress_bigmenu_no"><?php _e('No', 'imdb'); ?></label>
			</td>
		</tr>
		<tr>
			<td class="td-aligntop">
				<div class="explain"><?php _e('Enable debug mode?', 'imdb'); ?> <br /><?php _e('Default:','imdb');?> <?php _e('No', 'imdb'); ?></div>
			</td>
			<td class="td-aligntop">
				<div class="explain">
				<?php _e("When enabled, instead of displaying several results related to a name searched, only the first result is returned and directly displayed. That means no more window results is displayed, but straightforwardly related data. <br />This option allows to use the 'IMDb widget' and 'inside the post' options; if deactivated, these options will not work anymore. <br />Some options will be hidden and other will be shown depending if it is turned on yes or no.", 'imdb'); ?> <br /><?php _e('Default:','imdb');?> <?php _e('Yes', 'imdb'); ?></div>
			</td>
			<td class="td-aligntop">
				<div class="explain">
				<?php _e("When enabled, IMDb Link Transformer options are displayed separately from the settings menu. It will create a dedicated menu to the IMDB Link Transformer options.", 'imdb'); ?> <br /><?php _e('Default:','imdb');?> <?php _e('No', 'imdb'); ?></div>
			</td>
		</tr>


		<tr>
			<td>
				<label for="imdb_imdbmaxresults"><?php _e('Limit results', 'imdb'); ?></label>
				<input type="text" name="imdb_imdbmaxresults" id="imdb_imdbmaxresults" size="5" value="<?php _e(apply_filters('format_to_edit',$imdbOptions['imdbmaxresults']), 'imdb') ?>" <?php if ($imdbOptions['imdbdirectsearch'] == 1) { echo 'disabled="disabled"'; }; ?> />
			</td>
			<td>	
				<label for="imdb_imdbtaxonomy"><?php _e('Use automatical genre taxonomy?', 'imdb'); ?></label>
				<input type="radio" id="imdb_imdbtaxonomy_yes" name="imdb_imdbtaxonomy" value="1" <?php if ($imdbOptions['imdbtaxonomy'] == "1") { echo 'checked="checked"'; }?> /><label for="imdb_imdbtaxonomy_yes"><?php _e('Yes', 'imdb'); ?></label><input type="radio" id="imdb_imdbtaxonomy_no" name="imdb_imdbtaxonomy" value="" <?php if ($imdbOptions['imdbtaxonomy'] == 0) { echo 'checked="checked"'; } ?>  /><label for="imdb_imdbtaxonomy_no"><?php _e('No', 'imdb'); ?></label>
			</td>
			<td>
				<?php _e('Toolbar IMDB LT admin menu', 'imdb'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" id="imdb_imdbwordpress_tooladminmenu_yes" name="imdb_imdbwordpress_tooladminmenu" value="1" <?php if ($imdbOptions['imdbwordpress_tooladminmenu'] == "1") { echo 'checked="checked"'; }?> /><label for="imdb_imdbwordpress_tooladminmenu_yes"><?php _e('Yes', 'imdb'); ?></label><input type="radio" id="imdb_imdbwordpress_tooladminmenu_no" name="imdb_imdbwordpress_tooladminmenu" value="" <?php if ($imdbOptions['imdbwordpress_tooladminmenu'] == 0) { echo 'checked="checked"'; } ?>  /><label for="imdb_imdbwordpress_tooladminmenu_no"><?php _e('No', 'imdb'); ?></label>
			</td>
		</tr>
		<tr>
			<td class="td-aligntop">
				<div class="explain"><?php _e('This the limit for the result set of researches. Use 0 for no limit, or the number of maximum entries you wish. When "direct search" option is turned to yes, this option is hidden.', 'imdb'); ?> <br /><?php _e('Default:','imdb'); ?> "10"</div>
			</td>
			<td class="td-aligntop">
				<div class="explain"><?php _e('This will automatically add "genre" terms found for the movie into wordpress database, as <a href="http://codex.wordpress.org/WordPress_Taxonomy">taxonomy</a>. Activating this option open <a href="?page=imdblt_options&subsection=widgetoption&widgetoption=taxo">others taxonomy options</a>. Taxonomy terms are uninstalled when removing the plugin.', 'imdb'); ?> <br /><?php _e('Default:','imdb'); ?> <?php _e('No', 'imdb'); ?></div>
			</td>
			<td class="td-aligntop">
				<div class="explain">
				<?php _e("When activated, IMDb Link Transformer options are displayed in the toolbar admin menu of Wordpress.", 'imdb'); ?> <br /><?php _e('Default:','imdb');?> <?php _e('Yes', 'imdb'); ?></div>
			</td>

		</tr>
<?php	} // end of advanced section ?>

				
		
	</table>
	</div>

	<?php //------------------------------------------------------------------ =[Submit selection]=- ?>
	<div class="submit submit-imdb" align="center">
		<?php wp_nonce_field('reset_imdbSettings_check', 'reset_imdbSettings_check'); //check that data has been sent only once ?>
		<input type="submit" class="button-primary" name="reset_imdbSettings" value="<?php _e('Reset settings', 'imdb') ?>" />
		<?php wp_nonce_field('update_imdbSettings_check', 'update_imdbSettings_check', false);  //check that data has been sent only once -- don't send _wp_http_referer twice, already sent with first wp_nonce_field -> 3rd option to "false" ?>
		<input type="submit" class="button-primary" name="update_imdbSettings" value="<?php _e('Update settings', 'imdb') ?>" />
	</div>
	<br />
</div>
