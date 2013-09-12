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

global $wpa_settings;
$wpa_settings = get_option('awp_settings');

global $wp_query;
wp_reset_query();

global $paged; $paged = 1; // Fix for the WordPress 3.0 "paged" bug.
if ( get_query_var( 'paged' ) && ( get_query_var( 'paged' ) != '' ) ) { $paged = get_query_var( 'paged' ); }
if ( get_query_var( 'page' ) && ( get_query_var( 'page' ) != '' ) ) { $paged = get_query_var( 'page' ); }

$wp_query->set("paged", $paged);
$wp_query->set("tax_query", array(
	array(
		'taxonomy' => 'site-type',
		'field' => 'slug',
		'terms' => 'wpa'
	)
));

$archivePage = get_post_type_archive_link('site') . '?';
$orderby = isset($wp_query->query['orderby']) ? $wp_query->query['orderby'] : 'id';
$order = (isset($wp_query->query['order']) && 'asc' == $wp_query->query['order']) ? 'desc' : 'asc';

$number = 10;
if(isset($_REQUEST['posts_per_page'])){
	$number = $_REQUEST['posts_per_page'];
	$archivePage = $archivePage . 'posts_per_page=' . $number . '&';
	$wp_query->set("posts_per_page", $number);
}

if(isset($_REQUEST['meta_key'])){
	$meta = $_REQUEST['meta_key'];
	$wp_query->set("meta_key", $meta);
}

$wp_query->get_posts();

/*?><pre><?php print_r( $wp_query ); ?></pre><?php wp_die();*/

$columns = array();
							
// Site
$columns['wpa-col-site'][] = array(
	'group' => 'Site',
	'name' => 'Domain',
	'header' => 'wpa-th-domain',
	'sortable' => true,
	'body' => 'wpa-td-domain',
	'meta_key' => 'awp-domain'
);

$columns['wpa-col-site'][] = array(
	'group' => 'Site',
	'name' => 'TLD',
	'header' => 'wpa-th-tld',
	'sortable' => true,
	'body' => 'wpa-td-tld',
	'meta_key' => 'awp-tld'
);

$columns['wpa-col-site'][] = array(
	'group' => 'Site',
	'name' => 'URL',
	'header' => 'wpa-th-link',
	'sortable' => true,
	'body' => 'wpa-td-link',
	'meta_key' => 'awp-url',
	'link' => 'meta'
);

$columns['wpa-col-site'][] = array(
	'group' => 'Site',
	'name' => 'Date Founded',
	'header' => 'wpa-th-founded',
	'sortable' => true,
	'body' => 'wpa-td-founded',
	'meta_key' => 'awp-date'
);

/*$columns['wpa-col-site'][] = array(
	'group' => 'Site',
	'name' => 'Network In',
	'header' => 'wpa-th-networked',
	'sortable' => true,
	'body' => 'wpa-td-networked',
	'meta_key' => 'awp-networked'
);*/

$columns['wpa-col-site'][] = array(
	'group' => 'Site',
	'name' => 'Location',
	'header' => 'wpa-th-location',
	'sortable' => true,
	'body' => 'wpa-td-location',
	'meta_key' => 'awp-location'
);

$columns['wpa-col-site'][] = array(
	'group' => 'Site',
	'name' => 'Language',
	'header' => 'wpa-th-language',
	'sortable' => true,
	'body' => 'wpa-td-language',
	'meta_key' => 'awp-language'
);

// Project
$columns['wpa-col-project'][] = array(
	'group' => 'Project',
	'name' => 'Founder',
	'header' => 'wpa-th-founder',
	'sortable' => true,
	'body' => 'wpa-td-founder',
	'meta_key' => 'awp-founder'
);

$columns['wpa-col-project'][] = array(
	'group' => 'Project',
	'name' => 'Owner',
	'header' => 'wpa-th-owner',
	'sortable' => true,
	'body' => 'wpa-td-owner',
	'meta_key' => 'awp-owner'
);

$columns['wpa-col-project'][] = array(
	'group' => 'Project',
	'name' => 'Publisher',
	'header' => 'wpa-th-publisher',
	'sortable' => true,
	'body' => 'wpa-td-publisher',
	'meta_key' => 'awp-publisher'
);

$columns['wpa-col-project'][] = array(
	'group' => 'Project',
	'name' => 'Producer',
	'header' => 'wpa-th-producer',
	'sortable' => true,
	'body' => 'wpa-td-producer',
	'meta_key' => 'awp-producer'
);

$columns['wpa-col-project'][] = array(
	'group' => 'Project',
	'name' => 'Manager',
	'header' => 'wpa-th-manager',
	'sortable' => true,
	'body' => 'wpa-td-manager',
	'meta_key' => 'awp-manager'
);

$columns['wpa-col-project'][] = array(
	'group' => 'Project',
	'name' => 'Developer',
	'header' => 'wpa-th-developer',
	'sortable' => true,
	'body' => 'wpa-td-developer',
	'meta_key' => 'awp-developer'
);

$columns['wpa-col-project'][] = array(
	'group' => 'Project',
	'name' => 'Network',
	'header' => 'wpa-th-member',
	'sortable' => true,
	'body' => 'wpa-td-member',
	'meta_key' => 'awp-member'
);

// Links
$columns['wpa-col-links'][] = array(
	'group' => 'Links',
	'name' => 'Goolge',
	'header' => 'wpa-th-goolge',
	'sortable' => true,
	'body' => 'wpa-td-goolge',
	'meta_key' => 'awp-goolge'
);

$columns['wpa-col-links'][] = array(
	'group' => 'Links',
	'name' => 'Alexa',
	'header' => 'wpa-th-alexa',
	'sortable' => true,
	'body' => 'wpa-td-alexa',
	'meta_key' => 'awp-alexa'
);

$columns['wpa-col-links'][] = array(
	'group' => 'Links',
	'name' => 'Yahoo',
	'header' => 'wpa-th-yahoo',
	'sortable' => true,
	'body' => 'wpa-td-yahoo',
	'meta_key' => 'awp-yahoo'
);

$columns['wpa-col-links'][] = array(
	'group' => 'Links',
	'name' => 'Majestic',
	'header' => 'wpa-th-majestic',
	'sortable' => true,
	'body' => 'wpa-td-majestic',
	'meta_key' => 'awp-majestic'
);

$columns['wpa-col-links'][] = array(
	'group' => 'Scores',
	'name' => 'Links Scores',
	'header' => 'wpa-th-links-scores',
	'sortable' => true,
	'body' => 'wpa-td-links-scores',
	'meta_key' => 'awp-links-scores'
);

// Social
$columns['wpa-col-social'][] = array(
	'group' => 'Social',
	'name' => 'Google+',
	'header' => 'wpa-th-googleplus',
	'sortable' => true,
	'body' => 'wpa-td-googleplus',
	'meta_key' => 'awp-shares-goolgeplus'
);

$columns['wpa-col-social'][] = array(
	'group' => 'Social',
	'name' => 'Facebook Shares',
	'header' => 'wpa-th-fbshares',
	'sortable' => true,
	'body' => 'wpa-td-fbshares',
	'meta_key' => 'awp-shares-facebook'
);

$columns['wpa-col-social'][] = array(
	'group' => 'Social',
	'name' => 'Facebook Likes',
	'header' => 'wpa-th-fblikes',
	'sortable' => true,
	'body' => 'wpa-td-fblikes',
	'meta_key' => 'awp-likes-facebook'
);

$columns['wpa-col-social'][] = array(
	'group' => 'Social',
	'name' => 'Twitter',
	'header' => 'wpa-th-buzz-twitter',
	'sortable' => true,
	'body' => 'wpa-td-buzz-twitter',
	'meta_key' => 'awp-shares-twitter'
);

$columns['wpa-col-social'][] = array(
	'group' => 'Social',
	'name' => 'Pinterest',
	'header' => 'wpa-th-pinterest',
	'sortable' => true,
	'body' => 'wpa-td-pinterest',
	'meta_key' => 'awp-shares-pinterest'
);

$columns['wpa-col-social'][] = array(
	'group' => 'Social',
	'name' => 'LinkedIn',
	'header' => 'wpa-th-shares-linkedin',
	'sortable' => true,
	'body' => 'wpa-td-shares-linkedin',
	'meta_key' => 'awp-shares-linkedin'
);

$columns['wpa-col-social'][] = array(
	'group' => 'Scores',
	'name' => 'Social Scores',
	'header' => 'wpa-th-social-scores',
	'sortable' => true,
	'body' => 'wpa-td-social-scores',
	'meta_key' => 'awp-social-scores'
);

// Community
$columns['wpa-col-network'][] = array(
	'group' => 'Community',
	'name' => 'Google+',
	'header' => 'wpa-th-plus-google',
	'sortable' => true,
	'body' => 'wpa-td-plus-google',
	'meta_key' => 'awp-googleplus-followers',
	'link' => 'meta'
);

$columns['wpa-col-network'][] = array(
	'group' => 'Community',
	'name' => 'Facebook',
	'header' => 'wpa-th-facebook',
	'sortable' => true,
	'body' => 'wpa-td-facebook',
	'meta_key' => 'awp-facebook-followers',
	'link' => 'meta'
);

$columns['wpa-col-network'][] = array(
	'group' => 'Community',
	'name' => 'Twitter',
	'header' => 'wpa-th-twitter',
	'sortable' => true,
	'body' => 'wpa-td-twitter',
	'meta_key' => 'awp-twitter-followers',
	'link' => 'meta'
);

$columns['wpa-col-network'][] = array(
	'group' => 'Community',
	'name' => 'Pinterest',
	'header' => 'wpa-th-pinterest',
	'sortable' => true,
	'body' => 'wpa-td-pinterest',
	'meta_key' => 'awp-pinterest-followers',
	'link' => 'meta'
);

$columns['wpa-col-network'][] = array(
	'group' => 'Community',
	'name' => 'LinkedIn',
	'header' => 'wpa-th-linkedin',
	'sortable' => true,
	'body' => 'wpa-td-linkedin',
	'meta_key' => 'awp-linkedin-followers',
	'link' => 'meta'
);

$columns['wpa-col-network'][] = array(
	'group' => 'Community',
	'name' => 'Klout',
	'header' => 'wpa-th-klout',
	'sortable' => true,
	'body' => 'wpa-td-klout',
	'meta_key' => 'awp-klout-followers',
	'link' => 'meta'
);

$columns['wpa-col-network'][] = array(
	'group' => 'Community',
	'name' => 'RSS',
	'header' => 'wpa-th-rss',
	'sortable' => true,
	'body' => 'wpa-td-rss',
	'meta_key' => 'awp-rss',
	'link' => 'meta'
);

$columns['wpa-col-network'][] = array(
	'group' => 'Community',
	'name' => 'Email',
	'header' => 'wpa-th-email',
	'sortable' => true,
	'body' => 'wpa-td-email',
	'meta_key' => 'awp-email'
);

$columns['wpa-col-network'][] = array(
	'group' => 'Scores',
	'name' => 'Community Scores',
	'header' => 'wpa-th-community-scores',
	'sortable' => true,
	'body' => 'wpa-td-community-scores',
	'meta_key' => 'awp-community-scores'
);

// Buzz
$columns['wpa-col-buzz'][] = array(
	'group' => 'Buzz',
	'name' => 'Community Metric',
	'header' => 'wpa-th-community-metric',
	'sortable' => true,
	'body' => 'wpa-td-community-metric',
	'meta_key' => 'awp-community-metric'
);

$columns['wpa-col-buzz'][] = array(
	'group' => 'Buzz',
	'name' => 'Recent Post',
	'header' => 'wpa-th-recent-post',
	'sortable' => true,
	'body' => 'wpa-td-recent-post',
	'meta_key' => 'awp-recent-post'
);

$columns['wpa-col-buzz'][] = array(
	'group' => 'Buzz',
	'name' => 'Recent Comments',
	'header' => 'wpa-th-recent-comments',
	'sortable' => true,
	'body' => 'wpa-td-recent-comments',
	'meta_key' => 'awp-recent-comments'
);

$columns['wpa-col-buzz'][] = array(
	'group' => 'Buzz',
	'name' => 'Recent Shares',
	'header' => 'wpa-th-recent-shares',
	'sortable' => true,
	'body' => 'wpa-td-recent-shares',
	'meta_key' => 'awp-recent-shares'
);

/*Systems
$columns['wpa-col-systems'][] = array(
	'group' => 'Systems',
	'name' => 'Automated Processes',
	'header' => 'wpa-th-automated-processes',
	'sortable' => true,
	'body' => 'wpa-td-automated-processes',
	'meta_key' => 'awp-automated-processes'
);*/

// Ranks
$columns['wpa-col-ranks'][] = array(
	'group' => 'Ranks',
	'name' => 'Alexa',
	'header' => 'wpa-th-alexa-rank',
	'sortable' => true,
	'body' => 'wpa-td-alexa-rank',
	'meta_key' => 'awp-alexa-rank'
);

$columns['wpa-col-ranks'][] = array(
	'group' => 'Ranks',
	'name' => 'Google',
	'header' => 'wpa-th-google-rank',
	'sortable' => true,
	'body' => 'wpa-td-google-rank',
	'meta_key' => 'awp-google-rank'
);

$columns['wpa-col-ranks'][] = array(
	'group' => 'Ranks',
	'name' => 'Compete',
	'header' => 'wpa-th-compete-rank',
	'sortable' => true,
	'body' => 'wpa-td-compete-rank',
	'meta_key' => 'awp-compete-rank'
);

$columns['wpa-col-ranks'][] = array(
	'group' => 'Ranks',
	'name' => 'SEM Rush',
	'header' => 'wpa-th-semrush-rank',
	'sortable' => true,
	'body' => 'wpa-td-semrush-rank',
	'meta_key' => 'awp-semrush-rank'
);

$columns['wpa-col-ranks'][] = array(
	'group' => 'Ranks',
	'name' => '1Rank',
	'header' => 'wpa-th-one-rank',
	'sortable' => true,
	'body' => 'wpa-td-one-rank',
	'meta_key' => 'awp-one-rank'
);

$columns['wpa-col-ranks'][] = array(
	'group' => 'Scores',
	'name' => 'Ranks Scores',
	'header' => 'wpa-th-ranks-scores',
	'sortable' => true,
	'body' => 'wpa-td-ranks-scores',
	'meta_key' => 'awp-ranks-scores'
);

// Traffic
$columns['wpa-col-traffic'][] = array(
	'group' => 'Traffic',
	'name' => 'Monthly Unique Visitors',
	'header' => 'wpa-th-visitors',
	'sortable' => true,
	'body' => 'wpa-td-visitors',
	'meta_key' => 'awp-unique-visitors'
);

$columns['wpa-col-traffic'][] = array(
	'group' => 'Traffic',
	'name' => 'Monthly Page Views',
	'header' => 'wpa-th-page-views',
	'sortable' => true,
	'body' => 'wpa-td-page-views',
	'meta_key' => 'awp-page-views'
);

$columns['wpa-col-traffic'][] = array(
	'group' => 'Traffic',
	'name' => 'Monthly Page Speed',
	'header' => 'wpa-th-page-speed',
	'sortable' => true,
	'body' => 'wpa-td-page-speed',
	'meta_key' => 'awp-page-speed'
);

$columns['wpa-col-traffic'][] = array(
	'group' => 'Scores',
	'name' => 'Traffic Scores',
	'header' => 'wpa-th-traffic-scores',
	'sortable' => true,
	'body' => 'wpa-td-traffic-scores',
	'meta_key' => 'awp-traffic-scores'
);

// Engagement
$columns['wpa-col-engagement'][] = array(
	'group' => 'Engagement',
	'name' => 'Pages per Visit',
	'header' => 'wpa-th-pages-per-visit',
	'sortable' => true,
	'body' => 'wpa-td-pages-per-visit',
	'meta_key' => 'awp-pages-per-visit'
);

$columns['wpa-col-engagement'][] = array(
	'group' => 'Engagement',
	'name' => 'Time per Visit',
	'header' => 'wpa-th-time-per-visit',
	'sortable' => true,
	'body' => 'wpa-td-time-per-visit',
	'meta_key' => 'awp-time-per-visit'
);

$columns['wpa-col-engagement'][] = array(
	'group' => 'Engagement',
	'name' => 'Comments Active',
	'header' => 'wpa-th-comments-active',
	'sortable' => true,
	'body' => 'wpa-td-comments-active',
	'meta_key' => 'awp-comments-active'
);

$columns['wpa-col-engagement'][] = array(
	'group' => 'Engagement',
	'name' => 'Comments System',
	'header' => 'wpa-th-comment-system',
	'sortable' => true,
	'body' => 'wpa-td-comment-system',
	'meta_key' => 'awp-comment-system'
);

$columns['wpa-col-engagement'][] = array(
	'group' => 'Engagement',
	'name' => 'Comments Per Post',
	'header' => 'wpa-th-comments-per-post',
	'sortable' => true,
	'body' => 'wpa-td-comments-per-post',
	'meta_key' => 'awp-comments-per-post'
);

$columns['wpa-col-engagement'][] = array(
	'group' => 'Engagement',
	'name' => 'Percent Longer than 15s',
	'header' => 'wpa-th-percent-longer',
	'sortable' => true,
	'body' => 'wpa-td-percent-longer',
	'meta_key' => 'awp-percent-longer-15'
);

$columns['wpa-col-engagement'][] = array(
	'group' => 'Engagement',
	'name' => '0-10 Seconds under 55%',
	'header' => 'wpa-th-seconds-under',
	'sortable' => true,
	'body' => 'wpa-td-seconds-under',
	'meta_key' => 'awp-10-seconds-under-55'
);

$columns['wpa-col-engagement'][] = array(
	'group' => 'Scores',
	'name' => 'Engagement Scores',
	'header' => 'wpa-th-engagement-scores',
	'sortable' => true,
	'body' => 'wpa-td-engagement-scores',
	'meta_key' => 'awp-engagement-scores'
);

// Content
$columns['wpa-col-content'][] = array(
	'group' => 'Content',
	'name' => 'Number of Defined Silos',
	'header' => 'wpa-th-silos-number',
	'sortable' => true,
	'body' => 'wpa-td-silos-number',
	'meta_key' => 'awp-silos-number'
);

$columns['wpa-col-content'][] = array(
	'group' => 'Content',
	'name' => 'Silos',
	'header' => 'wpa-th-silos-tag',
	'sortable' => true,
	'body' => 'wpa-td-silos-tag',
	'meta_key' => 'awp-silos-tag'
);

$columns['wpa-col-content'][] = array(
	'group' => 'Content',
	'name' => 'Number of Rich Snippet Types',
	'header' => 'wpa-th-snippet-types',
	'sortable' => true,
	'body' => 'wpa-td-snippet-types',
	'meta_key' => 'awp-rich-snippet-types'
);

$columns['wpa-col-content'][] = array(
	'group' => 'Content',
	'name' => 'Number of Rich Snippets',
	'header' => 'wpa-th-rich-snippets',
	'sortable' => true,
	'body' => 'wpa-td-rich-snippets',
	'meta_key' => 'awp-rich-snippets'
);

$columns['wpa-col-content'][] = array(
	'group' => 'Scores',
	'name' => 'Content Scores',
	'header' => 'wpa-th-content-scores',
	'sortable' => true,
	'body' => 'wpa-td-content-scores',
	'meta_key' => 'awp-content-scores'
);

// Authors
$columns['wpa-col-authors'][] = array(
	'group' => 'Authors',
	'name' => 'Number of Authors',
	'header' => 'wpa-th-authors-number',
	'sortable' => true,
	'body' => 'wpa-td-authors-number',
	'meta_key' => 'awp-authors-number'
);

$columns['wpa-col-authors'][] = array(
	'group' => 'Authors',
	'name' => 'Bio Type',
	'header' => 'wpa-th-bio-type',
	'sortable' => true,
	'body' => 'wpa-td-bio-type',
	'meta_key' => 'awp-bio-type'
);

$columns['wpa-col-authors'][] = array(
	'group' => 'Authors',
	'name' => 'Byline Type',
	'header' => 'wpa-th-byline-type',
	'sortable' => true,
	'body' => 'wpa-td-byline-type',
	'meta_key' => 'awp-byline-type'
);

$columns['wpa-col-authors'][] = array(
	'group' => 'Authors',
	'name' => 'Authors Page Type',
	'header' => 'wpa-th-author-page',
	'sortable' => true,
	'body' => 'wpa-td-author-page',
	'meta_key' => 'awp-author-page-type'
);

$columns['wpa-col-authors'][] = array(
	'group' => 'Authors',
	'name' => 'Number of Connected Profiles',
	'header' => 'wpa-th-profiles-number',
	'sortable' => true,
	'body' => 'wpa-td-profiles-number',
	'meta_key' => 'awp-profiles-number'
);

$columns['wpa-col-authors'][] = array(
	'group' => 'Scores',
	'name' => 'Authors Scores',
	'header' => 'wpa-th-authors-scores',
	'sortable' => true,
	'body' => 'wpa-td-authors-scores',
	'meta_key' => 'awp-authors-scores'
);

// Valuation
$columns['wpa-col-valuation'][] = array(
	'group' => 'Valuation',
	'name' => 'Last Valuation',
	'header' => 'wpa-th-last-valuation',
	'sortable' => true,
	'body' => 'wpa-td-last-valuation',
	'meta_key' => 'awp-last-valuation'
);

$columns['wpa-col-valuation'][] = array(
	'group' => 'Valuation',
	'name' => 'Revenue Value Multiplier',
	'header' => 'wpa-th-revenue-multiplier',
	'sortable' => true,
	'body' => 'wpa-td-revenue-multiplier',
	'meta_key' => 'awp-revenue-multiplier'
);

$columns['wpa-col-valuation'][] = array(
	'group' => 'Valuation',
	'name' => 'Income Value Multiplier',
	'header' => 'wpa-th-income-multiplier',
	'sortable' => true,
	'body' => 'wpa-td-income-multiplier',
	'meta_key' => 'awp-income-multiplier'
);

$columns['wpa-col-valuation'][] = array(
	'group' => 'Valuation',
	'name' => 'Daily Worth <small>(From Income Diary)</small>',
	'header' => 'wpa-th-daily-worth',
	'sortable' => true,
	'body' => 'wpa-td-daily-worth',
	'meta_key' => 'awp-daily-worth'
);

$columns['wpa-col-valuation'][] = array(
	'group' => 'Valuation',
	'name' => 'Staff',
	'header' => 'wpa-th-staff',
	'sortable' => true,
	'body' => 'wpa-td-staff',
	'meta_key' => 'awp-staff'
);

$columns['wpa-col-valuation'][] = array(
	'group' => 'Valuation',
	'name' => 'Net Income',
	'header' => 'wpa-th-net-income',
	'sortable' => true,
	'body' => 'wpa-td-net-income',
	'meta_key' => 'awp-net-income'
);

$columns['wpa-col-valuation'][] = array(
	'group' => 'Valuation',
	'name' => 'Gross Revenue',
	'header' => 'wpa-th-gross-revenue',
	'sortable' => true,
	'body' => 'wpa-td-gross-revenue',
	'meta_key' => 'awp-gross-revenue'
);

$columns['wpa-col-valuation'][] = array(
	'group' => 'Valuation',
	'name' => 'Trailing 12 Months',
	'header' => 'wpa-th-trailing-months',
	'sortable' => true,
	'body' => 'wpa-td-trailing-months',
	'meta_key' => 'awp-trailing-12-months'
);

$columns['wpa-col-valuation'][] = array(
	'group' => 'Valuation',
	'name' => 'Cost to Build',
	'header' => 'wpa-th-cost-build',
	'sortable' => true,
	'body' => 'wpa-td-cost-build',
	'meta_key' => 'awp-cost-to-build'
);

$columns['wpa-col-valuation'][] = array(
	'group' => 'Valuation',
	'name' => 'Expenses',
	'header' => 'wpa-th-cost-expense',
	'sortable' => true,
	'body' => 'wpa-td-cost-expense',
	'meta_key' => 'awp-cost-expense'
);

get_header();

?><section id="primary"><?php

	/*<div id="secondary" class="widget-area" role="complementary">
    </div>*/
    
    ?><div id="content" role="main"><?php
		
		// Collapsable area
		?><div class="wpa-collapse-wrapper">
			<a href="javascript:void(0);" class="wpa-collapse-btn">
				<span>Open Search</span>
				<span style="display:none;">Close Search</span>
			</a>
			<div class="wpa-collapse">
				<form name="s" action="<?php echo home_url(); ?>" method="get">
					<p>
					<select name="taxonomy" id="wpa-taxonomy">
						<option value="0">Select Filter</option><?php
						$taxes = get_taxonomies( array('object_type' => array('site')), 'objects' );
						foreach($taxes as $tax){
							?><option value="<?php echo $tax->name; ?>"><?php echo $tax->label; ?></option><?php
						}
					?></select>
					
					<select name="term" id="wpa-term" disabled="disabled">
						<option value="0">Select Type</option><?php
						$terms = get_terms('site-type', array('hide_empty' => 0));
						foreach($terms as $tm){
							?><option value="<?php echo $tm->slug; ?>"><?php echo $tm->name; ?></option><?php
						}
					?></select>
					
					<input type="text" name="s" id="search_field" value="<?php echo get_search_query(); ?>" />
					<input type="hidden" name="post_type" value="site" />
					<input type="submit" name="search" value="Search" /></p>
				</form>
				
                <div class="wpa-screen-options hide"><?php
				
					foreach($columns as $name=>$group){
						?><h4><?php echo $group[0]['group']; ?></h4><?php
						
						if($group[0]['group'] == 'Site'){ ?><p><input type="checkbox" id="wpa-thumbnail-option" value=".metrics-thumbnail" checked="checked" /><label for="wpa-thumbnail-option">Thumbnail</label><?php } else { echo '<p>'; }
						
						foreach($group as $col){
							$inputID = $col['meta_key'].'-option';
							$inputVal = '.metrics-' . $col['meta_key'];
							?><input type="checkbox" class="ch-box checkbox-<?php echo $name; ?>" id="<?php echo $inputID; ?>" value="<?php echo $inputVal; ?>" <?php echo ($name == 'wpa-col-site') ? 'checked="checked"' : ''; ?> /><label for="<?php echo $inputID; ?>"><?php echo $col['name']; ?></label><?php
						}
						?></p><?php
					}
					
					?><div class="clear"></div>
				</div>
                
				<div class="wpa-group-column hide">
					<ul>
						<li class="first"><a href=".wpa-col">All</a></li>
						<li class="first"><a href=".wpa-default">Summary</a></li>
						<li class="first"><a href=".wpa-scores">Scores</a></li><?php
						foreach($columns as $name=>$group){
							$classes = array();
							if($name == 'wpa-col-site'){
								$classes[] = 'current';
							}
							
							if($name == 'wpa-col-valuation'){
								$classes[] = 'last';
							}
							?><li class="<?php echo implode(' ', $classes); ?>"><a data-inputs=".checkbox-<?php echo $name; ?>" href=".<?php echo $name; ?>"><?php echo $group[0]['group']; ?></a></li><?php
						}
					?></ul>
				</div>
			</div>
		</div><?php
		/* End of Collapsable area */
		
		if ( $wp_query->have_posts() ) :
		
			?><ul class="wpa-display-controls">
            	<li class="wpa-number-control"><span>Show <select name="posts_per_page" id="posts_per_page"><?php
					for($i=1; $i<=10; $i++){
						$count = $i * 10;
						$thisPage = $archivePage;
						if(isset($_REQUEST['posts_per_page']))
							$thisPage = get_post_type_archive_link('site') . '?';
						
						$URLquery = $thisPage . 'posts_per_page=' .$count . '&';
						?><option value="<?php echo $URLquery; ?>" <?php selected($number, $count); ?>><?php echo $count; ?></option><?
					}
				?></select> Per page</span></li>
                <li><a href="#grid" class="wpa-control grid current">Grid</a></li>
                <li><a href="#detail" class="wpa-control detail">Detail</a></li>
                <li><a href="#list" class="wpa-control list">Detail list</a></li>
                <li><a href="#line" class="wpa-control line">Line Line</a></li>
            </ul>
            
            <header class="page-header">
                <h1 class="page-title"><?php
					
					$title = apply_filters('wpa_archive_page_title', 'WordPress Authority Site Directory');
					echo $title;
					
				?></h1>
            </header><?php
            
            $content_before = apply_filters('wpa_archive_content_before', '');
			echo $content_before;
			
            ?><div class="wpa-display-archives grid"><?php
				
				$sortbytitle = $archivePage . 'orderby=title&order='. $order;
				$sortbyPR = $archivePage . 'meta_key=awp-google-rank&orderby=meta_value_num&order=' . $order;
				$sortbyalexa = $archivePage . 'meta_key=awp-alexa-rank&orderby=meta_value_num&order=' . $order;
				
				/* Grid and Detail Header */
				?><div class="wpa-sort-wrapper">
					<p>Sort by:
                    <a href="<?php echo $sortbytitle; ?>" class="wpa-sortable <?php echo $order; echo ($orderby == 'title') ? ' current' : ''; ?>" >Title</a> |
                    <a href="<?php echo $sortbyPR; ?>" class="wpa-sortable <?php echo $order; echo ($meta == 'awp-google-rank') ? ' current' : ''; ?>">Google Rank</a> |
                    <a href="<?php echo $sortbyalexa; ?>" class="wpa-sortable <?php echo $order; echo ($meta == 'awp-alexa-rank') ? ' current' : ''; ?>">Alexa Rank</a>
                    </p>
				</div>
                
                <!-- Line List View -->
                <div class="wpa-line-header">
                    <div class="wpa-th wpa-th-thumbnail">Thumbnail</div>
                    <div class="wpa-th wpa-th-description">Description</div>
                    
                    <div class="clear"></div>
                </div>
                
                <!-- Start of list HR wrapper -->
                <div class="wpa-site-wrapper">
				
                <div class="wpa-list-header">
                	<div class="wpa-th wpa-th-change">&nbsp;</div>
					<div class="wpa-th wpa-th-count">1Rank</div>
                    <div class="wpa-th wpa-th-title">
                    	<a href="<?php echo $sortbytitle; ?>" class="wpa-sortable <?php echo $order; echo ($orderby == 'title') ? ' current' : ''; ?>">Blog</a>
                    </div><?php
                    
					foreach($columns as $name=>$group){
						foreach($group as $col){
							$oby = 'meta_value';
							
							if($name == 'wpa-col-ranks'){
								$oby = 'meta_value_num';
							}
							
							$sort = $archivePage . 'meta_key='. $col['meta_key'] . '&orderby=' . $oby . '&order=' . $order;
							
							$class = array('wpa-sortable', $order);
							$class[] = ($meta == $col['meta_key']) ? 'current' : null;
							
							$classes = array('wpa-th', 'wpa-col', 'hide');
							$classes[] = 'metrics-' . $col['meta_key'];
							$classes[] = $col['header'];
							$classes[] = $name;
							
							if($name == 'wpa-col-site'){
								$classes[] = 'wpa-default';
							}
							
							if($col['group'] == 'Scores'){
								$classes[] = 'wpa-scores';
							}
							
							?><div class="<?php echo implode(' ', $classes); ?>"><?php
								$column = $col['name'];
								
								if($col['sortable'])
									$column = sprintf('<a href="%s" class="%s">%s</a>', $sort, implode(' ', $class), $column);
								
								echo $column;
							?></div><?php
						}
					}
					
                    ?><div class="clear"></div>
				</div>
				
				<?php /* Start the Loop */
				
				$i = 1;
				while ( $wp_query->have_posts() ) : $wp_query->the_post();
				
					$metrics = get_post_meta( get_the_ID() );
					
					$post_id = get_the_ID();
					$class = (is_sticky()) ? 'sticky-site' : '';
					$attachment = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ) );
					$attachmentURL = ($attachment) ? PLUGINURL . '/timthumb.php?src=' . $attachment[0] . '&w=150&h=150' : null;
					$thumbnailURL = ($attachment) ? PLUGINURL . '/timthumb.php?src=' . $attachment[0] . '&w=180&h=100' : null;
					
					$pageRank = get_post_meta($post_id, 'awp-google-rank', true);
					$alexaRank = get_post_meta($post_id, 'awp-alexa-rank', true);
					$date = get_post_meta($post_id, 'awp-date', true);
					$location = get_post_meta($post_id, 'awp-location', true);
					$language = get_post_meta($post_id, 'awp-language', true);
					
					$gplus = get_post_meta($post_id, 'awp-googleplus', true);
					$fb = get_post_meta($post_id, 'awp-facebook', true);
					$twitter = get_post_meta($post_id, 'awp-twitter', true);
					$pinteret = get_post_meta($post_id, 'awp-pinterest', true);
					$linkedin = get_post_meta($post_id, 'awp-linkedin', true);
					
					$gPlusCount = get_post_meta($post_id, 'awp-shares-goolgeplus', true);
					$fbShares = get_post_meta($post_id, 'awp-shares-facebook', true);
					$fbLikes = get_post_meta($post_id, 'awp-likes-facebook', true);
					$tweets = get_post_meta($post_id, 'awp-shares-twitter', true);
					$pinCount = get_post_meta($post_id, 'awp-shares-pinterest', true);
					$linkedCount = get_post_meta($post_id, 'awp-shares-linkedin', true);
					
					?><article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
						
                        <!-- Line List View -->
                        <div class="wpa-line-item">
                            <div class="wpa-td wpa-td-thumbnail"><div class="thumbnail alignleft">
                                <a href="<?php the_permalink(); ?>"><?php
                                    if($attachmentURL){
                                        ?><img src="<?php echo $thumbnailURL ?>" align="<?php the_title(); ?>" /><?php
                                    } else {
                                        ?><span><?php echo 'NO IMAGE'; ?></span><?php
                                    }
                                ?></a>
                            </div></div>
                            <div class="wpa-td wpa-td-description">
                            	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </div>
                            
                            <div class="clear"></div>
                        </div>
                        
                        <!-- List View -->
						<div class="wp-list-item">
                        	<div class="wpa-td wpa-td-change">&nbsp;</div>
                        	<div class="wpa-td wpa-td-count"><?php echo $metrics['awp-one-rank'][0]; ?></div>
                            <div class="wpa-td wpa-td-title">
                            	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </div><?php
							
							foreach($columns as $class=>$group){
								foreach($group as $col){
									
									$classes = array('wpa-td', 'wpa-col', 'hide');
									$classes[] = 'metrics-' . $col['meta_key'];
									$classes[] = $col['body'];
									$classes[] = $class;
									
									if($class == 'wpa-col-site'){
										$classes[] = 'wpa-default';
									}
									
									if($col['group'] == 'Scores'){
										$classes[] = 'wpa-scores';
									}
									
									?><div class="<?php echo implode(' ', $classes); ?> "><?php
										if($class == 'wpa-col-network'){
											if($metrics[$col['meta_key']][0] > 0){
												$img = PLUGINURL . '/images/link-icon.png';
												$profile = str_replace('-followers', '', $col['meta_key']);
												$link = $metrics[$profile][0];
												$data = sprintf('<a target="_blank" href="%s">%s <img src="%s" alt="%s" /></a>', $link, $metrics[$col['meta_key']][0], $img, $col['name']);
											} else {
												$data = 0;
											}
										} else {
											if($col['link']){
												$link = ($col['link'] == 'meta') ? $metrics[$col['meta_key']][0] : $col['link'];
												$data = sprintf('<a href="%s" target="_blank">%s</a>', $link, $metrics[$col['meta_key']][0]);
											} else {
												$data = $metrics[$col['meta_key']][0];
											}
										}
										echo $data;
									?></div><?php
								}
							}
                            
                            ?><div class="clear"></div>
						</div>
						
                        <!-- Grid View -->
						<div class="wpa-grid-item"><?php
							
							?><header class="entry-header">
								<div class="thumbnail alignleft">
									<a href="<?php the_permalink(); ?>"><?php
										if($attachmentURL){
											?><img src="<?php echo $thumbnailURL ?>" align="<?php the_title(); ?>" /><?php
										} else {
											?><span><?php echo 'NO IMAGE'; ?></span><?php
										}
									?></a>
                                </div>
                                
                                <h4 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'awp' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                                
                                <a href="<?php echo $metrics['awp-url'][0]; ?>" title="<?php the_title(); ?>" target="_blank"><img src="<?php echo PLUGINURL; ?>/images/link-icon.png" alt="<?php the_title(); ?>" /></a></h4>
                            </header><!-- .entry-header -->
							
							<div class="entry-summary"><?php
								?><h2><?php echo number_format( (float)$alexaRank ); ?></h2>
                                
                                <p class="clear"><strong>Page Ranks</strong></p>
                                <span class="meta"><span class="wpa-icons wpa-icon-alexa">Alexa</span><?php
									echo number_format( (float)$alexaRank );
								?></span> 
                                <span class="meta"><span class="wpa-icons wpa-icon-moz">MOZ Authority</span><?php
                                	echo '';
								?></span>
                                
                                <p class="clear"><strong>Social</strong></p>
                                <!-- Social -->
                                <span class="meta"><span class="wpa-icons wpa-icon-googleplus">Google+</span><?php
									echo $metrics['awp-shares-goolgeplus'][0];
								?></span>
                                <span class="meta"><span class="wpa-icons wpa-icon-facebook">Facebook Shares</span><?php
                                	echo $metrics['awp-shares-facebook'][0];
								?></span>
                                <span class="meta"><span class="wpa-icons wpa-icon-fblikes">Facebook Likes</span><?php
                                	echo $metrics['awp-likes-facebook'][0];
								?></span>
                                <span class="meta"><span class="wpa-icons wpa-icon-twitter">Twitter Feed</span><?php
									echo $metrics['awp-shares-twitter'][0];
								?></span>
                                <span class="meta"><span class="wpa-icons wpa-icon-pinterest">Pinterest</span><?php
									echo $metrics['awp-shares-pinterest'][0];
								?></span>
                                <span class="meta"><span class="wpa-icons wpa-icon-linkedin">LinkedIn</span><?php
                                	echo $metrics['awp-score-klout'][0];
								?></span>
                                
                                <p class="clear"><strong>Network</strong></p>
                                <!-- Community --><?php
								
								if($metrics['awp-googleplus'][0]){ ?><a href="<?php echo $metrics['awp-googleplus'][0]; ?>" class="wpa-icons wpa-icon-googleplus" target="_blank">Google+</a><?php }
								
								if($metrics['awp-facebook'][0]){ ?><a href="<?php echo $metrics['awp-facebook'][0]; ?>" class="wpa-icons wpa-icon-facebook" target="_blank">Facebook</a><?php }
								
								if($metrics['awp-twitter'][0]){ ?><a href="<?php echo $metrics['awp-twitter'][0]; ?>" class="wpa-icons wpa-icon-twitter" target="_blank">Twitter</a><?php }
                                
                                if($metrics['awp-pinterest'][0]){ ?><a href="<?php echo $metrics['awp-pinterest'][0]; ?>" class="wpa-icons wpa-icon-pinterest" target="_blank">Pinterest</a><?php }
								
								if($metrics['awp-linkedin'][0]){ ?><a href="<?php echo $metrics['awp-linkedin'][0]; ?>" class="wpa-icons wpa-icon-linkedin" target="_blank">LinkedIn</a><?php }
								
								if($metrics['awp-klout'][0]){ ?><a href="<?php echo $metrics['awp-klout'][0]; ?>" class="wpa-icons wpa-icon-klout" target="_blank">Klout</a><?php }
                                
                                ?><p class="clear"><strong>One Score</strong></p>
                                <span class="meta">One Score: <?php echo $metrics['awp-one-score'][0]; ?></span>
                                <span class="meta">One Rank: <?php echo $metrics['awp-one-rank'][0]; ?></span>
                            </div><!-- .entry-summary -->
                            
                            <div class="clear"></div>
						</div>
						
                        <!-- Detail View -->
						<div class="wpa-detail-item">
                            <div class="thumbnail alignleft metrics-thumbnail">
								<a href="<?php the_permalink(); ?>"><?php
									if($attachmentURL){
										?><img src="<?php echo $attachmentURL ?>" align="<?php the_title(); ?>" /><?php
									} else {
										?><span><?php echo 'NO IMAGE'; ?></span><?php
									}
								?></a>
                            </div>
							
							<div class="entry-summary">
                                <header class="entry-header">
                                    <h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'awp' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                                </header><!-- .entry-header --><?php
								
								the_excerpt();
								
								foreach($columns as $name=>$group){
									?><p><?php
									foreach($group as $col){
										?><span class="meta metrics-<?php echo $col['meta_key']; ?>"> <?php echo $col['name']; ?>: <span class="metaval"><?php echo $metrics[$col['meta_key']][0]; ?></span></span><?php
									}
									?></p><?php
								}
                            
							?></div><!-- .entry-summary -->
                            
                            <div class="clear"></div>
						</div><?php
						$i++;
					?></article><?php
				endwhile;
				
				?><div class="clear"></div>
                </div><!-- wpa-site-wrapper -->
                
			</div><?php
			
			$content_after = apply_filters('wpa_archive_content_after', '');
			echo $content_after;
			
			if(function_exists('wp_pagenavi')) {
				wp_pagenavi();
			} else {
				echo wpa_paginate();
			}
			
		else :
			?><article id="post-0" class="post no-results not-found">
                <header class="entry-header">
                    <h1 class="entry-title"><?php _e( 'Nothing Found', 'awp' ); ?></h1>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'awp' ); ?></p>
                    <?php get_search_form(); ?>
                </div><!-- .entry-content -->
            </article><!-- #post-0 --><?php
        
		endif;
		
	?></div><!-- #content -->
    
    <div class="clear"></div>
</section><!-- #primary -->
    
<div class="clear"></div>

<?php get_footer(); ?>