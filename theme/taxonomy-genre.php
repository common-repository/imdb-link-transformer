<?php 
/*
Template Name: Taxonomy for IMDb Link Transformer (-> genre)
*
* ( This file should be copied in your theme folder (root) )
*
*/ 

get_header(); 

get_sidebar(); ?>

<br />
<br />

	<div id="content" class="narrowcolumn">


		<h1 class="pagetitle"><?php _e('Taxonomy'); ?></h1>

<?php	if ( have_posts() ) { // there is post
		while ( have_posts() ) { 
			the_post(); ?>
			
			<div class="postList">
				<h3 id="post-<?php the_ID(); ?>">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to ', 'LH2')?><?php the_title(); ?>">
						<?php the_title(); ?>
					</a>
				</h3>
				<small><?php the_date("l j F Y"); ?></small> 
				
				<div class="entry">
					<?php the_excerpt() ?>
				</div>
		
				<p class="postmetadata">
					<span class="category"><?php _e("Filed under: "); ?> <?php the_category(', ') ?></span> 

					<?php if (has_tag()){ ?>
					<strong>|</strong>
					<span class="tags"><?php the_tags(__('Tags: '), ' &bull; ', ' '); ?></span><?php } ?>

					<?php if (get_terms('genre')){ ?>
					<strong>|</strong> 
					<span class="taxonomy"><?php echo get_the_term_list($wp_query->post->ID, 'genre', __('Taxonomy: '), ', ', '' ); ?></span><?php } ?>
					<strong>|</strong> <?php edit_post_link('Edit','','<strong>|</strong>'); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
				</p>
			</div><?php

		}

	} else { // there is no post
			_e('No post found.'); 
			echo "<br /><br /><br />";
	} ?>

		
	</div>


<?php get_footer(); ?>

