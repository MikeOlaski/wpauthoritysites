<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<section id="primary">
			<div id="content" role="main">

			<?php global $wp_query;
			wp_reset_query();
			/*?><pre><?php print_r( count( $wp_query->posts ) ); ?></pre><? wp_die();*/
			
			if ( $wp_query->have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php _e( 'Sites Archives', 'awp' ); ?>
					</h1>
				</header>

				<?php /* Start the Loop */ ?>
				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();
				
					?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php
						
						if(is_singular() && has_post_thumbnail()){
							?><div class="alignleft"><?php
								the_post_thumbnail();
							?></div><?php
						}
						
						?><header class="entry-header">
							<?php if ( is_sticky() ) : ?>
								<hgroup>
									<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'awp' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
									<h3 class="entry-format"><?php _e( 'Featured', 'awp' ); ?></h3>
								</hgroup>
							<?php else : ?>
							<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'awp' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
							<span><a href="http://<?php the_title(); ?>/" target="_blank"><?php the_title(); ?></a></span>
							<?php endif; ?>
						</header><!-- .entry-header -->
						
						<div class="clear"></div>
					
						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div><!-- .entry-summary -->
					
                    </article>

				<?php endwhile; ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'awp' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'awp' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			<div class="clear"></div>
			</div><!-- #content -->
		</section><!-- #primary -->
        
        <div class="clear"></div>

<?php get_footer(); ?>