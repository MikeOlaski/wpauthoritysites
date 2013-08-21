<?php
!defined( 'ABSPATH' ) ? exit : '';
/**
 * The default template for displaying content
 */

$fields = array();

$shortname = 'awp';

// General
$fields[] = array(
	'name' => 'General',
	'id' => $shortname.'-general',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Name',
	'id' => $shortname.'-name',
	'type' => 'text',
	'group' => $shortname.'-general'
);

$fields[] = array(
	'name' => 'Domain',
	'id' => $shortname.'-domain',
	'type' => 'text',
	'group' => $shortname.'-general'
);

$fields[] = array(
	'name' => 'TLD',
	'id' => $shortname.'-tld',
	'type' => 'text',
	'group' => $shortname.'-general'
);

$fields[] = array(
	'name' => 'URL – Link',
	'id' => $shortname.'-url',
	'type' => 'text',
	'group' => $shortname.'-general'
);

$fields[] = array(
	'name' => 'Date Founded',
	'id' => $shortname.'-date',
	'type' => 'text',
	'group' => $shortname.'-general'
);

$fields[] = array(
	'name' => 'Network IN?',
	'id' => $shortname.'-networked',
	'type' => 'text',
	'group' => $shortname.'-general'
);

$fields[] = array(
	'name' => 'Location',
	'id' => $shortname.'-location',
	'type' => 'text',
	'group' => $shortname.'-general'
);

$fields[] = array(
	'name' => 'Language',
	'id' => $shortname.'-language',
	'type' => 'text',
	'group' => $shortname.'-general'
);

$fields[] = array(
	'name' => 'Owners',
	'id' => $shortname.'-owners',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Founder',
	'id' => $shortname.'-founder',
	'type' => 'text',
	'group' => $shortname.'-owners'
);

$fields[] = array(
	'name' => 'Owner',
	'id' => $shortname.'-owner',
	'type' => 'text',
	'group' => $shortname.'-owners'
);

$fields[] = array(
	'name' => 'Publisher',
	'id' => $shortname.'-publisher',
	'type' => 'text',
	'group' => $shortname.'-owners'
);

$fields[] = array(
	'name' => 'Producer',
	'id' => $shortname.'-producer',
	'type' => 'text',
	'group' => $shortname.'-owners'
);

$fields[] = array(
	'name' => 'Links',
	'id' => $shortname.'-links',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Google',
	'id' => $shortname.'-google',
	'type' => 'text',
	'group' => $shortname.'-links'
);

$fields[] = array(
	'name' => 'Yahoo',
	'id' => $shortname.'-yahoo',
	'type' => 'text',
	'group' => $shortname.'-links'
);

$fields[] = array(
	'name' => 'Majestic',
	'id' => $shortname.'-majestic',
	'type' => 'text',
	'group' => $shortname.'-links'
);

$fields[] = array(
	'name' => 'Social Network',
	'id' => $shortname.'-social',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Google Plus',
	'id' => $shortname.'-googleplus',
	'type' => 'text',
	'group' => $shortname.'-social'
);

$fields[] = array(
	'name' => 'Facebook',
	'id' => $shortname.'-facebook',
	'type' => 'text',
	'group' => $shortname.'-social'
);

$fields[] = array(
	'name' => 'Twitter',
	'id' => $shortname.'-twitter',
	'type' => 'text',
	'group' => $shortname.'-social'
);

$fields[] = array(
	'name' => 'Pinterest',
	'id' => $shortname.'-pinterest',
	'type' => 'text',
	'group' => $shortname.'-social'
);

$fields[] = array(
	'name' => 'LinkedIn',
	'id' => $shortname.'-linkedin',
	'type' => 'text',
	'group' => $shortname.'-social'
);

$fields[] = array(
	'name' => 'Ranks',
	'id' => $shortname.'-ranks',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Alexa Rank',
	'id' => $shortname.'-alexa-rank',
	'type' => 'text',
	'group' => $shortname.'-ranks'
);

$fields[] = array(
	'name' => 'Compete Rank',
	'id' => $shortname.'-compete-rank',
	'type' => 'text',
	'group' => $shortname.'-ranks'
);

$fields[] = array(
	'name' => 'SEM Rush Rank',
	'id' => $shortname.'-semrush-rank',
	'type' => 'text',
	'group' => $shortname.'-ranks'
);

$fields[] = array(
	'name' => 'One Rank',
	'id' => $shortname.'-one-rank',
	'type' => 'text',
	'group' => $shortname.'-ranks'
);

$fields[] = array(
	'name' => 'Traffic',
	'id' => $shortname.'-traffic',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Monthly Unique Visitors',
	'id' => $shortname.'-unique-visitors',
	'type' => 'text',
	'group' => $shortname.'-traffic'
);

$fields[] = array(
	'name' => 'Monthly Page Views',
	'id' => $shortname.'-page-views',
	'type' => 'text',
	'group' => $shortname.'-traffic'
);

$fields[] = array(
	'name' => 'Engagement',
	'id' => $shortname.'-engagement',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Pages Per Visit',
	'id' => $shortname.'-pages-per-visit',
	'type' => 'text',
	'group' => $shortname.'-engagement'
);

$fields[] = array(
	'name' => 'Time Per Visit',
	'id' => $shortname.'-time-per-visit',
	'type' => 'text',
	'group' => $shortname.'-engagement'
);

$fields[] = array(
	'name' => 'Comments Active',
	'id' => $shortname.'-comments-active',
	'type' => 'text',
	'group' => $shortname.'-engagement'
);

$fields[] = array(
	'name' => 'Comment System',
	'id' => $shortname.'-comment-system',
	'type' => 'text',
	'group' => $shortname.'-engagement'
);

$fields[] = array(
	'name' => 'Comments Per Post',
	'id' => $shortname.'-comments-per-post',
	'type' => 'text',
	'group' => $shortname.'-engagement'
);

$fields[] = array(
	'name' => 'Percent Longer than 15 Seconds',
	'id' => $shortname.'-percent-longer-15',
	'type' => 'text',
	'group' => $shortname.'-engagement'
);

$fields[] = array(
	'name' => '0-10 Seconds under 55%',
	'id' => $shortname.'-10-seconds-under-55',
	'type' => 'text',
	'group' => $shortname.'-engagement'
);

$fields[] = array(
	'name' => 'Financials',
	'id' => $shortname.'-financials',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Net Income',
	'id' => $shortname.'-net-income',
	'type' => 'text',
	'group' => $shortname.'-financials'
);

$fields[] = array(
	'name' => 'Gross Revenue',
	'id' => $shortname.'-gross-revenue',
	'type' => 'text',
	'group' => $shortname.'-financials'
);

$fields[] = array(
	'name' => 'Trailing 12 Months',
	'id' => $shortname.'-trailing-12-months',
	'type' => 'text',
	'group' => $shortname.'-financials'
);

$fields[] = array(
	'name' => 'Valuation',
	'id' => $shortname.'-valuation',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Last Sale Value',
	'id' => $shortname.'-sale-value',
	'type' => 'text',
	'group' => $shortname.'-valuation'
);

$fields[] = array(
	'name' => 'Last Sale Price',
	'id' => $shortname.'-sale-price',
	'type' => 'text',
	'group' => $shortname.'-valuation'
);

$fields[] = array(
	'name' => 'Revenue Value Multiplier',
	'id' => $shortname.'-revenue-multiplier',
	'type' => 'text',
	'group' => $shortname.'-valuation'
);

$fields[] = array(
	'name' => 'Income value Multiplier',
	'id' => $shortname.'-income-multiplier',
	'type' => 'text',
	'group' => $shortname.'-valuation'
);

$fields[] = array(
	'name' => 'Daily Worth (From Income Diary)',
	'id' => $shortname.'-daily-worth',
	'type' => 'text',
	'group' => $shortname.'-valuation'
);

$fields[] = array(
	'name' => 'Sale URL',
	'id' => $shortname.'-sale-url',
	'type' => 'text',
	'group' => $shortname.'-valuation'
);

$fields[] = array(
	'name' => 'Sale Date',
	'id' => $shortname.'-sale-date',
	'type' => 'text',
	'group' => $shortname.'-valuation'
);

$fields[] = array(
	'name' => 'Sale Type',
	'id' => $shortname.'-sale-type',
	'type' => 'text',
	'group' => $shortname.'-valuation'
);

$fields[] = array(
	'name' => 'Content',
	'id' => $shortname.'-content',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Number of Defined Silos',
	'id' => $shortname.'-silos-number',
	'type' => 'text',
	'group' => $shortname.'-content'
);

$fields[] = array(
	'name' => 'Silos',
	'id' => $shortname.'-silos-tag',
	'type' => 'text',
	'group' => $shortname.'-content'
);

$fields[] = array(
	'name' => 'Number of Rich Snippet Types',
	'id' => $shortname.'-rich-snippet-types',
	'type' => 'text',
	'group' => $shortname.'-content'
);

$fields[] = array(
	'name' => 'Number of Rich Snippets',
	'id' => $shortname.'-rich-snippets',
	'type' => 'text',
	'group' => $shortname.'-content'
);

$fields[] = array(
	'name' => 'Development',
	'id' => $shortname.'-development',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Percent Customized',
	'id' => $shortname.'-percent-customized',
	'type' => 'text',
	'group' => $shortname.'-development'
);

$fields[] = array(
	'name' => 'Cost to Build',
	'id' => $shortname.'-cost-to-build',
	'type' => 'text',
	'group' => $shortname.'-development'
);

$fields[] = array(
	'name' => 'Cost to Maintain',
	'id' => $shortname.'-cost-to-maintain',
	'type' => 'text',
	'group' => $shortname.'-development'
);

$fields[] = array(
	'name' => 'Authors',
	'id' => $shortname.'-authors',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Number of Authors',
	'id' => $shortname.'-authors-number',
	'type' => 'text',
	'group' => $shortname.'-authors'
);

$fields[] = array(
	'name' => 'Bio Type',
	'id' => $shortname.'-bio-type',
	'type' => 'text',
	'group' => $shortname.'-authors'
);

$fields[] = array(
	'name' => 'Byline Type',
	'id' => $shortname.'-byline-type',
	'type' => 'text',
	'group' => $shortname.'-authors'
);

$fields[] = array(
	'name' => 'Author Page Type',
	'id' => $shortname.'-author-page-type',
	'type' => 'text',
	'group' => $shortname.'-authors'
);

$fields[] = array(
	'name' => 'Number of Connected Profiles',
	'id' => $shortname.'-profiles-number',
	'type' => 'text',
	'group' => $shortname.'-authors'
);

$fields[] = array(
	'name' => 'Management',
	'id' => $shortname.'-management',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Staff',
	'id' => $shortname.'-staff',
	'type' => 'text',
	'group' => $shortname.'-management'
);

$fields[] = array(
	'name' => 'Automated Processes',
	'id' => $shortname.'-automated-processes',
	'type' => 'text',
	'group' => $shortname.'-management'
);

$fields[] = array(
	'name' => 'Brand',
	'id' => $shortname.'-brand',
	'type' => 'heading'
);

$fields[] = array(
	'name' => 'Brand Keywords',
	'id' => $shortname.'-brand-keywords',
	'type' => 'text',
	'group' => $shortname.'-brand'
);

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
	
	<div class="clear"></div><?php

	if(is_singular()){
		?><div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'awp' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		
        <table class="custom-info"><?php
			
			global $post;
			
			foreach ($fields as $fl){
				if($fl['type'] != 'heading'){
					$metavalue = get_post_meta( $post->ID, $fl['id'], true );
					if( $metavalue ){
						?><tr>
							<th scope="row" align="left"><i class="icon" title="<?php echo $fl['name']; ?>"></i><?php echo $fl['name']; ?></th>
							<td><?php echo $metavalue; ?></td>
							<td><?php _e('Massa magnis nisi augue. Pellentesque sit magna pid! Proin ridiculus, odio placerat! Dolor lundium ac.'); ?></td>
						</tr><?php
					}
				}
			}
			
		?></table><?php
	} else {
		?><div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary --><?php
	}

	?><footer class="entry-meta"><?php
    	$show_sep = false;
		
		if ( is_object_in_taxonomy( get_post_type(), 'site-category' ) ) :
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_term_list( get_the_ID(), 'site-category', '', __( ', ', 'awp' ) );
			if ( $categories_list ):
				?><span class="cat-links">
					<?php printf( __( '<span class="%1$s">Posted in</span> %2$s', 'awp' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list ); $show_sep = true; ?>
                </span><?php
			endif;
		endif; // End if is_object_in_taxonomy( get_post_type(), 'category' )
		
		if ( is_object_in_taxonomy( get_post_type(), 'site-tag' ) ) : // Hide tag text when not supported 
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_term_list( get_the_ID(), 'site-tag', '', __( ', ', 'awp' ) );
			if ( $tags_list ):
				if ( $show_sep ) :
					?><span class="sep"> | </span><?php
                endif; // End if $show_sep
				?><span class="tag-links">
                    <?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'twentyeleven' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); $show_sep = true; ?>
                </span><?php
			endif; // End if $tags_list
		endif; // End if is_object_in_taxonomy( get_post_type(), 'post_tag' )
		
		edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' );
	
	?></footer><!-- .entry-meta --><?php
	
?></article>