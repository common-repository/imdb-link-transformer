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
 #  Function : Show a popup including movie information related to movies    #
 #									     #
 #############################################################################

//---------------------------------------=[Vars]=----------------

require_once (dirname(__FILE__).'/../../../../wp-blog-header.php');
require_once ("functions.php"); 

global $imdb_admin_values, $imdb_widget_values;

if ($imdb_admin_values['imdbsourceout']) $engine = 'pilot';

## toute la partie, avec le choix de imdb ou de pilot :
switch($engine) {
	case "pilot":
	  require_once(dirname(__FILE__)."/../class/pilotsearch.class.php");
	  require_once(dirname(__FILE__)."/../class/pilot.class.php");
	  $search = new pilotsearch();
	  break;
	default:
	  require_once(dirname(__FILE__)."/../class/imdbsearch.class.php");
	  require_once(dirname(__FILE__)."/../class/imdb.class.php");
	  $search = new imdbsearch();
	  break;
}

if ($_GET["searchtype"]=="episode") $search->search_episodes(TRUE);
else $search->search_episodes(FALSE);

$search->setsearchname ($_GET["film"]);
$results = $search->results ();

//--------------------------------------=[Layout]=---------------

if (($imdb_admin_values[imdbdirectsearch] == false ) OR ($_GET["norecursive"] == 'yes')) { //------------------------- 1. recherche, comportement classique
	require_once ('popup-header.php'); ?>


<h1><?php _e('Results related to this film', 'imdb'); ?></h1>

<table class='TableListeResultats'>
	<tr>
		<th class='TableListeResultatsTitre'><?php _e('Titles matching', 'imdb'); ?></th>
		<th class='TableListeResultatsTitre' style='width: 40%'><?php _e('Director', 'imdb'); ?></th>
	</tr>

	<?php
	foreach ($results as $res) {
		echo "	<tr>\n";
		
		// ---- movie part
		echo "		<td class='TableListeResultatsColGauche'><a href=\"popup-imdb_movie.php?mid=".$res->imdbid()."\" title=\"".__('more on', 'imdb')." ".$res->title()."\" >".$res->title()."(".$res->year().")"."</a> \n";
		echo "&nbsp;&nbsp;<a class=\"imdblink\" href=\"http://us.imdb.com/title/tt".$res->imdbid()."\" target=\"_blank\" title='".__('link to imdb for', 'imdb')." ".$res->title()."'>";

			if ($imdb_admin_values[imdbdisplaylinktoimdb] == true) { # if the user has selected so
		echo "<img  class='img-imdb' src='".$imdb_admin_values[imdbplugindirectory].$imdb_admin_values[imdbpicurl]."' width='".$imdb_admin_values[imdbpicsize]."' alt='".__('link to imdb for', 'imdb')." ".$res->title()."'/></a>";	
			}
		echo "</td>\n";
		flush ();
	
		// ---- director part
		$realisateur = $res->director();
		if (! is_null ($realisateur['0']['name'])){
		echo "		<td class='TableListeResultatsColDroite'><a href=\"popup-imdb_person.php?mid=".$realisateur['0']['imdb']."&film=".$_GET['film']."\" title=\"".__('more on', 'imdb')." ".$realisateur['0']['name']."\" >".$realisateur['0']['name']."</a>";

			if ($imdb_admin_values[imdbdisplaylinktoimdb] == true) { # if the user has selected so
		echo "&nbsp;&nbsp;<a class=\"imdblink\" href=\"http://imdb.com/name/nm".$realisateur['0']['imdb']."\" target=\"_blank\" title='".__('link to imdb for', 'imdb')." ".$realisateur['0']['name']."'>";
		echo "<img class='img-imdb' src='".$imdb_admin_values[imdbplugindirectory].$imdb_admin_values[imdbpicurl]."' width='".$imdb_admin_values[imdbpicsize]."' alt='".__('link to imdb for', 'imdb')." ".$realisateur['0']['name']."'/>";
		echo "</a>";
			}
			
		echo "</td>\n";
		}
		echo "	</tr>\n";
		flush ();
	} // end foreach  ?> 

</table>
</body>
</html> 



<?php
} else {  //-------------------------------------------------------------------------- 2. acc�s direct, option sp�ciale

	if ($results[0]) {	// test pour afficher le film m�me lorsque celui-ci est un r�sultat unique (sinon, msg erreur php)
		$nbarrayresult = "0"; // lorsque r�sultat unique, tout s'affiche dans l'array "0"
	} else {
		$nbarrayresult = "1"; // lorsque r�sultats multiples, le premier film s'affiche dans l'array "1"
	}	
	$midPremierResultat = $results[$nbarrayresult]->imdbid();
	$_GET['mid'] = $midPremierResultat; //"mid" will be transmitted to next include
	require_once ("popup-imdb_movie.php");
}

?>
