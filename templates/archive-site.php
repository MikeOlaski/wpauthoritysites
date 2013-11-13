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

//wp_die( '<pre>' . print_r( $wp_query, true ) . '</pre>' );

$columns = array();

// [SITE]
$columns['wpa-col-site'] = array(
	array(
		'name' => 'Thumbnail',
		'header' => 'wpa-th-thumbnail',
		'body' => 'wpa-td-thumbnail',
		'value' => 'thumbnail',
		'sortable' => true
	),
	array(
		'name' => 'Domain',
		'header' => 'wpa-th-domain',
		'body' => 'wpa-td-domain',
		'meta_key' => 'awp-domain',
		'sortable' => true
	),
	array(
		'name' => 'TLD <small>(Top Level Domain)</small>',
		'header' => 'wpa-th-tld',
		'body' => 'wpa-td-tld',
		'meta_key' => 'awp-tld',
		'sortable' => true
	),
	array(
		'name' => 'URL',
		'header' => 'wpa-th-link',
		'body' => 'wpa-td-link',
		'meta_key' => 'awp-url',
		'link' => 'meta',
		'sortable' => true
	),
	array(
		'name' => 'Date Founded',
		'header' => 'wpa-th-founded',
		'body' => 'wpa-td-founded',
		'meta_key' => 'awp-date',
		'format' => 'date',
		'sortable' => true
	),
	array(
		'name' => 'Location',
		'header' => 'wpa-th-location',
		'body' => 'wpa-td-location',
		'meta_key' => 'awp-location',
		'sortable' => true
	),
	array(
		'name' => 'Language',
		'header' => 'wpa-th-language',
		'body' => 'wpa-td-language',
		'meta_key' => 'awp-language',
		'sortable' => true
	)
);

// [PROJECT]
$columns['wpa-col-project'] = array(
	array(
		'name' => 'Founder',
		'header' => 'wpa-th-founder',
		'body' => 'wpa-td-founder',
		'meta_key' => 'awp-founder',
		'sortable' => true
	),
	array(
		'name' => 'Owner',
		'header' => 'wpa-th-owner',
		'body' => 'wpa-td-owner',
		'meta_key' => 'awp-owner',
		'sortable' => true
	),
	array(
		'name' => 'Publisher',
		'header' => 'wpa-th-publisher',
		'body' => 'wpa-td-publisher',
		'meta_key' => 'awp-publisher',
		'sortable' => true
	),
	array(
		'name' => 'Producer',
		'header' => 'wpa-th-producer',
		'body' => 'wpa-td-producer',
		'meta_key' => 'awp-producer',
		'sortable' => true
	),
	array(
		'name' => 'Manager',
		'header' => 'wpa-th-manager',
		'body' => 'wpa-td-manager',
		'meta_key' => 'awp-manager',
		'sortable' => true
	),
	array(
		'name' => 'Developer',
		'header' => 'wpa-th-developer',
		'body' => 'wpa-td-developer',
		'meta_key' => 'awp-developer',
		'sortable' => true
	),
	array(
		'name' => 'Editor',
		'header' => 'wpa-th-editor',
		'body' => 'wpa-td-editor',
		'meta_key' => 'awp-editor',
		'sortable' => true
	),
	array(
		'name' => 'CEO',
		'header' => 'wpa-th-ceo',
		'body' => 'wpa-td-ceo',
		'meta_key' => 'awp-ceo',
		'sortable' => true
	)
);

// [LINKS]
$columns['wpa-col-links'] = array(
	array(
		'name' => 'Goolge',
		'header' => 'wpa-th-goolge',
		'body' => 'wpa-td-goolge',
		'meta_key' => 'awp-goolge',
		'sortable' => true
	),
	array(
		'name' => 'Alexa',
		'header' => 'wpa-th-alexa',
		'body' => 'wpa-td-alexa',
		'meta_key' => 'awp-alexa',
		'sortable' => true
	),
	array(
		'name' => 'Yahoo',
		'header' => 'wpa-th-yahoo',
		'body' => 'wpa-td-yahoo',
		'meta_key' => 'awp-yahoo',
		'sortable' => true
	),
	array(
		'name' => 'Majestic',
		'header' => 'wpa-th-majestic',
		'body' => 'wpa-td-majestic',
		'meta_key' => 'awp-majestic',
		'sortable' => true
	)
);

// [SOCIAL]
$columns['wpa-col-social'] = array(
	array(
		'name' => 'Google+',
		'header' => 'wpa-th-googleplus',
		'body' => 'wpa-td-googleplus',
		'meta_key' => 'awp-shares-goolgeplus',
		'sortable' => true
	),
	array(
		'name' => 'Facebook Shares',
		'header' => 'wpa-th-fbshares',
		'body' => 'wpa-td-fbshares',
		'meta_key' => 'awp-shares-facebook',
		'sortable' => true
	),
	array(
		'name' => 'Facebook Likes',
		'header' => 'wpa-th-fblikes',
		'body' => 'wpa-td-fblikes',
		'meta_key' => 'awp-likes-facebook',
		'sortable' => true
	),
	array(
		'name' => 'Twitter',
		'header' => 'wpa-th-buzz-twitter',
		'body' => 'wpa-td-buzz-twitter',
		'meta_key' => 'awp-shares-twitter',
		'sortable' => true
	),
	array(
		'name' => 'Pinterest',
		'header' => 'wpa-th-pinterest',
		'body' => 'wpa-td-pinterest',
		'meta_key' => 'awp-shares-pinterest',
		'sortable' => true
	),
	array(
		'name' => 'LinkedIn',
		'header' => 'wpa-th-shares-linkedin',
		'body' => 'wpa-td-shares-linkedin',
		'meta_key' => 'awp-shares-linkedin',
		'sortable' => true
	)
);

// [BUZZ]
$columns['wpa-col-buzz'] = array(
	array(
		'name' => 'Recent Comments',
		'header' => 'wpa-th-recent-comments',
		'body' => 'wpa-td-recent-comments',
		'meta_key' => 'awp-recent-comments',
		'sortable' => true
	),
	array(
		'name' => 'Recent Post',
		'header' => 'wpa-th-recent-post',
		'body' => 'wpa-td-recent-post',
		'meta_key' => 'awp-recent-post',
		'sortable' => true
	),
	array(
		'name' => 'Recent Shares',
		'header' => 'wpa-th-recent-shares',
		'body' => 'wpa-td-recent-shares',
		'meta_key' => 'awp-recent-shares',
		'sortable' => true
	),
	array(
		'name' => 'Klout Score',
		'header' => 'wpa-th-klout-score',
		'body' => 'wpa-td-klout-score',
		'meta_key' => 'awp-klout-score',
		'sortable' => true
	)
);

// [FRAMEWORK]
$columns['wpa-col-framework'] = array(
	array(
		'name' => 'Plugins (Paid)',
		'header' => 'wpa-th-plugins-paid',
		'body' => 'wpa-td-plugins-paid',
		'meta_key' => 'awp-plugins-paid',
		'sortable' => true
	),
	array(
		'name' => 'Plugins (Free)',
		'header' => 'wpa-th-plugins-free',
		'body' => 'wpa-td-plugins-free',
		'meta_key' => 'awp-plugins-free',
		'sortable' => true
	),
	array(
		'name' => 'Plugins (Custom)',
		'header' => 'wpa-th-plugins-custom',
		'body' => 'wpa-td-plugins-custom',
		'meta_key' => 'awp-plugins-custom',
		'sortable' => true
	),
	array(
		'name' => 'Functions (Custom)',
		'header' => 'wpa-th-functions-custom',
		'body' => 'wpa-td-functions-custom',
		'meta_key' => 'awp-functions-custom',
		'sortable' => true
	),
	array(
		'name' => 'Theme (Paid)',
		'header' => 'wpa-th-theme-paid',
		'body' => 'wpa-td-theme-paid',
		'meta_key' => 'awp-theme-paid',
		'sortable' => true
	),
	array(
		'name' => 'Theme Framework',
		'header' => 'wpa-th-theme-framework',
		'body' => 'wpa-td-theme-framework',
		'meta_key' => 'awp-theme-framework',
		'sortable' => true
	),
	array(
		'name' => 'Theme Custom',
		'header' => 'wpa-th-theme-custom',
		'body' => 'wpa-td-theme-custom',
		'meta_key' => 'awp-theme-custom',
		'sortable' => true
	),
	array(
		'name' => 'Services (Facebook)',
		'header' => 'wpa-th-services-facebook',
		'body' => 'wpa-td-services-facebook',
		'meta_key' => 'awp-services-facebook',
		'sortable' => true
	),
	array(
		'name' => 'Services (Twitter)',
		'header' => 'wpa-th-services-twitter',
		'body' => 'wpa-td-services-twitter',
		'meta_key' => 'awp-services-twitter',
		'sortable' => true
	),
	array(
		'name' => 'Services (Google Plus)',
		'header' => 'wpa-th-services-google',
		'body' => 'wpa-td-services-google',
		'meta_key' => 'awp-services-google',
		'sortable' => true
	)
);

// [COMMUNITY]
$columns['wpa-col-community'] = array(
	array(
		'name' => 'Facebook',
		'header' => 'wpa-th-facebook-followers',
		'body' => 'wpa-td-facebook-followers',
		'meta_key' => 'awp-facebook-followers',
		'link' => 'awp-facebook',
		'sortable' => true
	),
	array(
		'name' => 'Twitter',
		'header' => 'wpa-th-twitter-followers',
		'body' => 'wpa-td-twitter-followers',
		'meta_key' => 'awp-twitter-followers',
		'link' => 'awp-twitter',
		'sortable' => true
	),
	array(
		'name' => 'Youtube',
		'header' => 'wpa-th-youtube-followers',
		'body' => 'wpa-td-youtube-followers',
		'meta_key' => 'awp-youtube-followers',
		'link' => 'awp-youtube',
		'sortable' => true
	),
	array(
		'name' => 'Google+',
		'header' => 'wpa-th-googleplus-followers',
		'body' => 'wpa-td-googleplus-followers',
		'meta_key' => 'awp-googleplus-followers',
		'link' => 'awp-googleplus',
		'sortable' => true
	),
	array(
		'name' => 'LinkedIn',
		'header' => 'wpa-th-linkedin-followers',
		'body' => 'wpa-td-linkedin-followers',
		'meta_key' => 'awp-linkedin-followers',
		'link' => 'awp-linkedin',
		'sortable' => true
	),
	array(
		'name' => 'Pinterest',
		'header' => 'wpa-th-pinterest-followers',
		'body' => 'wpa-td-pinterest-followers',
		'meta_key' => 'awp-pinterest-followers',
		'link' => 'awp-pinterest',
		'sortable' => true
	),
	array(
		'name' => 'RSS',
		'header' => 'wpa-th-rss',
		'body' => 'wpa-td-rss',
		'meta_key' => 'awp-rss',
		'link' => 'awp-rss',
		'sortable' => true
	),
	array(
		'name' => 'Email',
		'header' => 'wpa-th-email',
		'body' => 'wpa-td-email',
		'meta_key' => 'awp-email',
		'link' => 'awp-email',
		'sortable' => true
	)
);

// [AUTHOR]
$columns['wpa-col-authors'] = array(
	array(
		'name' => 'Number of Authors',
		'header' => 'wpa-th-authors-number',
		'body' => 'wpa-td-authors-number',
		'meta_key' => 'awp-authors-number',
		'sortable' => true
	),
	array(
		'name' => 'Bio Type',
		'header' => 'wpa-th-bio-type',
		'body' => 'wpa-td-bio-type',
		'meta_key' => 'awp-bio-type',
		'sortable' => true
	),
	array(
		'name' => 'Byline Type',
		'header' => 'wpa-th-byline-type',
		'body' => 'wpa-td-byline-type',
		'meta_key' => 'awp-byline-type',
		'sortable' => true
	),
	array(
		'name' => 'Author Page Type',
		'header' => 'wpa-th-author-page-type',
		'body' => 'wpa-td-author-page-type',
		'meta_key' => 'awp-author-page-type',
		'sortable' => true
	),
	array(
		'name' => 'Paid',
		'header' => 'wpa-th-author-paid',
		'body' => 'wpa-td-author-paid',
		'meta_key' => 'awp-author-paid',
		'sortable' => true
	),
	array(
		'name' => 'Free',
		'header' => 'wpa-th-author-free',
		'body' => 'wpa-td-author-free',
		'meta_key' => 'awp-author-free',
		'sortable' => true
	),
	array(
		'name' => 'Revenue Share',
		'header' => 'wpa-th-revenue-share',
		'body' => 'wpa-td-revenue-share',
		'meta_key' => 'awp-revenue-share',
		'sortable' => true
	),
	array(
		'name' => 'No. of Connected Profiles',
		'header' => 'wpa-th-profiles-number',
		'body' => 'wpa-td-profiles-number',
		'meta_key' => 'awp-profiles-number',
		'sortable' => true
	)
);

// [CONTENT]
$columns['wpa-col-content'] = array(
	array(
		'name' => 'Pillars - Silos',
		'header' => 'wpa-th-silos-number',
		'body' => 'wpa-td-silos-number',
		'meta_key' => 'awp-silos-number',
		'sortable' => true
	),
	array(
		'name' => 'Number of Rich Snippet Types',
		'header' => 'wpa-th-rich-snippet-types',
		'body' => 'wpa-td-rich-snippet-types',
		'meta_key' => 'awp-rich-snippet-types',
		'sortable' => true
	),
	array(
		'name' => 'Number of Rich Snippet Posts',
		'header' => 'wpa-th-rich-snippets',
		'body' => 'wpa-td-rich-snippets',
		'meta_key' => 'awp-rich-snippets',
		'sortable' => true
	)
);

// [PRODUCTS]
$columns['wpa-col-products'] = array(
	array(
		'name' => 'Number',
		'header' => 'wpa-th-brand-number',
		'body' => 'wpa-td-brand-number',
		'meta_key' => 'awp-brand-number',
		'sortable' => true
	)
);

// [SYSTEMS]
$columns['wpa-col-systems'] = array(
	array(
		'name' => 'Content',
		'header' => 'wpa-th-system-content',
		'body' => 'wpa-td-system-content',
		'meta_key' => 'awp-system-content',
		'sortable' => true
	),
	array(
		'name' => 'Marketing',
		'header' => 'wpa-th-system-marketing',
		'body' => 'wpa-td-system-marketing',
		'meta_key' => 'awp-system-marketing',
		'sortable' => true
	),
	array(
		'name' => 'Sales',
		'header' => 'wpa-th-system-sales',
		'body' => 'wpa-td-system-sales',
		'meta_key' => 'awp-system-sales',
		'sortable' => true
	),
	array(
		'name' => 'Fulfillment',
		'header' => 'wpa-th-system-fulfilment',
		'body' => 'wpa-td-system-fulfilment',
		'meta_key' => 'awp-system-fulfilment',
		'sortable' => true
	),
	array(
		'name' => 'Management (Staff)',
		'header' => 'wpa-th-system-management',
		'body' => 'wpa-td-system-management',
		'meta_key' => 'awp-system-management',
		'sortable' => true
	)
);

// [RANKS]
$columns['wpa-col-ranks'] = array(
	array(
		'name' => 'Alexa Rank',
		'header' => 'wpa-th-alexa-rank',
		'body' => 'wpa-td-alexa-rank',
		'meta_key' => 'awp-alexa-rank',
		'sortable' => true
	),
	array(
		'name' => 'Google Rank',
		'header' => 'wpa-th-google-rank',
		'body' => 'wpa-td-google-rank',
		'meta_key' => 'awp-google-rank',
		'sortable' => true
	),
	array(
		'name' => 'Compete Rank',
		'header' => 'wpa-th-compete-rank',
		'body' => 'wpa-td-compete-rank',
		'meta_key' => 'awp-compete-rank',
		'sortable' => true
	),
	array(
		'name' => 'SEMRUSH Rank',
		'header' => 'wpa-th-semrush-rank',
		'body' => 'wpa-td-semrush-rank',
		'meta_key' => 'awp-semrush-rank',
		'sortable' => true
	),
	array(
		'name' => 'ONE Rank',
		'header' => 'wpa-th-one-rank',
		'body' => 'wpa-td-one-rank',
		'meta_key' => 'awp-one-rank',
		'sortable' => true
	)
);

// [VALUATION]
$columns['wpa-col-valuation'] = array(
	array(
		'name' => 'Replacement - Content',
		'header' => 'wpa-th-replacement-content',
		'body' => 'wpa-td-replacement-content',
		'meta_key' => 'awp-replacement-content',
		'sortable' => true
	),
	array(
		'name' => 'Replacement - Technology',
		'header' => 'wpa-th-replacement-technology',
		'body' => 'wpa-td-replacement-technology',
		'meta_key' => 'awp-replacement-technology',
		'sortable' => true
	),
	array(
		'name' => 'Replacement - Community',
		'header' => 'wpa-th-replacement-community',
		'body' => 'wpa-td-replacement-community',
		'meta_key' => 'awp-replacement-community',
		'sortable' => true
	),
	array(
		'name' => 'TTM - Trailing Twelve Months',
		'header' => 'wpa-th-trailing-12-months',
		'body' => 'wpa-td-trailing-12-months',
		'meta_key' => 'awp-trailing-12-months',
		'sortable' => true
	),
	array(
		'name' => 'Income',
		'header' => 'wpa-th-net-income',
		'body' => 'wpa-td-net-income',
		'meta_key' => 'awp-net-income',
		'sortable' => true
	),
	array(
		'name' => 'Expenses',
		'header' => 'wpa-th-cost-expense',
		'body' => 'wpa-td-cost-expense',
		'meta_key' => 'awp-cost-expense',
		'sortable' => true
	),
	array(
		'name' => 'Last Value',
		'header' => 'wpa-th-last-valuation',
		'body' => 'wpa-td-last-valuation',
		'meta_key' => 'awp-last-valuation',
		'sortable' => true
	),
	array(
		'name' => 'Multiplier - Revenue',
		'header' => 'wpa-th-revenue-multiplier',
		'body' => 'wpa-td-revenue-multiplier',
		'meta_key' => 'awp-revenue-multiplier',
		'sortable' => true
	),
	array(
		'name' => 'Multiplier - Income',
		'header' => 'wpa-th-income-multiplier',
		'body' => 'wpa-td-income-multiplier',
		'meta_key' => 'awp-income-multiplier',
		'sortable' => true
	)
);

// [SCORES]
$columns['wpa-col-scores'] = array(
	array(
		'name' => 'Site',
		'header' => 'wpa-th-site-score',
		'body' => 'wpa-td-site-score',
		'meta_key' => 'awp-site-score',
		'sortable' => true
	),
	array(
		'name' => 'Project',
		'header' => 'wpa-th-project-score',
		'body' => 'wpa-td-project-score',
		'meta_key' => 'awp-project-score',
		'sortable' => true
	),
	array(
		'name' => 'Social',
		'header' => 'wpa-th-social-scores',
		'body' => 'wpa-td-social-scores',
		'meta_key' => 'awp-social-scores',
		'sortable' => true
	),
	array(
		'name' => 'Buzz',
		'header' => 'wpa-th-buzz-score',
		'body' => 'wpa-td-buzz-score',
		'meta_key' => 'awp-buzz-score',
		'sortable' => true
	),
	array(
		'name' => 'Framework',
		'header' => 'wpa-th-framework-score',
		'body' => 'wpa-td-framework-score',
		'meta_key' => 'awp-framework-score',
		'sortable' => true
	),
	array(
		'name' => 'Community',
		'header' => 'wpa-th-community-scores',
		'body' => 'wpa-td-community-scores',
		'meta_key' => 'awp-community-scores',
		'sortable' => true
	),
	array(
		'name' => 'Authors',
		'header' => 'wpa-th-authors-scores',
		'body' => 'wpa-td-authors-scores',
		'meta_key' => 'awp-authors-scores',
		'sortable' => true
	),
	array(
		'name' => 'Content',
		'header' => 'wpa-th-content-scores',
		'body' => 'wpa-td-content-scores',
		'meta_key' => 'awp-content-scores',
		'sortable' => true
	),
	array(
		'name' => 'Systems',
		'header' => 'wpa-th-systems-score',
		'body' => 'wpa-td-systems-score',
		'meta_key' => 'awp-systems-score',
		'sortable' => true
	),
	array(
		'name' => 'Ranks',
		'header' => 'wpa-th-ranks-scores',
		'body' => 'wpa-td-ranks-scores',
		'meta_key' => 'awp-ranks-scores',
		'sortable' => true
	),
	array(
		'name' => 'Scores',
		'header' => 'wpa-th-scores-score',
		'body' => 'wpa-td-scores-score',
		'meta_key' => 'awp-scores-score',
		'sortable' => true
	),
	array(
		'name' => 'Valuation',
		'header' => 'wpa-th-valuation-score',
		'body' => 'wpa-td-valuation-score',
		'meta_key' => 'awp-valuation-score',
		'sortable' => true
	)
);

// [ACTION]
$columns['wpa-col-action'] = array(
	array(
		'name' => 'Action',
		'header' => 'wpa-th-site-action',
		'body' => 'wpa-td-site-action',
		'taxonomy' => 'site-action'
	),
	array(
		'name' => 'Status',
		'header' => 'wpa-th-site-status',
		'body' => 'wpa-td-site-status',
		'taxonomy' => 'site-status'
	),
	array(
		'name' => 'Include',
		'header' => 'wpa-th-site-include',
		'body' => 'wpa-td-site-include',
		'taxonomy' => 'site-include'
	),
	array(
		'name' => 'Topic',
		'header' => 'wpa-th-site-topic',
		'body' => 'wpa-td-site-topic',
		'taxonomy' => 'site-topic'
	),
	array(
		'name' => 'Type',
		'header' => 'wpa-th-site-type',
		'body' => 'wpa-td-site-type',
		'taxonomy' => 'site-type'
	),
	array(
		'name' => 'Location',
		'header' => 'wpa-th-site-location',
		'body' => 'wpa-td-site-location',
		'taxonomy' => 'site-location'
	),
	array(
		'name' => 'Assignment',
		'header' => 'wpa-th-site-assignment',
		'body' => 'wpa-td-site-assignment',
		'taxonomy' => 'site-assignment'
	),
	array(
		'name' => 'Date',
		'header' => 'wpa-th-date',
		'body' => 'wpa-td-date',
		'post' => 'post_date',
		'format' => 'date',
		'sortable' => true
	)
);

get_header();

?><section id="primary"><?php

	/*<div id="secondary" class="widget-area" role="complementary">
    </div>*/
    
    ?><div id="content" role="main">
    	<div class="wpaSearchForm">
            <form name="s" action="<?php echo home_url(); ?>" method="get">
                <p>
                <select name="taxonomy" id="wpa-taxonomy">
                    <option value="0">Search Fields</option><?php
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
            
            <ul class="filterButtons">
            	<li><a id="addFilterButton" href="javascript:void(0);" title="Add new conditional filter row">Add new Conditional Filter</a></li>
                <li>
                	<a id="filterGroups" class="wpa-filterg-btn" href="javascript:void(0);" title="Extra Buttons">Extra Buttons</a>
                    <div class="wpa-filter-groups hide">
                    	<span class="displayOptionshead"><?php _e('DISPLAY OPTIONS'); ?></span>
                        <p>
                        	Show 
                        	<label class="star-1 wpa-rating"><input type="checkbox" name="" id="" value="1" />1</label>
                            <label class="star-2 wpa-rating"><input type="checkbox" name="" id="" value="2" />2</label>
                            <label class="star-3 wpa-rating"><input type="checkbox" name="" id="" value="3" />3</label>
                            <label class="star-4 wpa-rating"><input type="checkbox" name="" id="" value="4" />4</label>
                            <label class="star-5 wpa-rating"><input type="checkbox" name="" id="" value="5" />5</label>
                        	rated sites
                        </p>
                        <ul class="filterGroup">
                        	<li><label> <input type="checkbox" name="" id="" value="" /> Categories</label></li>
                            <li><label> <input type="checkbox" name="" id="" value="" /> Tags</label></li>
                            <li><label> <input type="checkbox" name="" id="" value="" /> Actions</label></li>
                            <li><label> <input type="checkbox" name="" id="" value="" /> Status</label></li>
                            <li><label> <input type="checkbox" name="" id="" value="" /> Include</label></li>
                            <li><label> <input type="checkbox" name="" id="" value="" /> Topic</label></li>
                            <li><label> <input type="checkbox" name="" id="" value="" /> Type</label></li>
                            <li><label> <input type="checkbox" name="" id="" value="" /> Location</label></li>
                            <li><label> <input type="checkbox" name="" id="" value="" /> Assignment</label></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
		
		<ul class="wpa-display-controls">
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
            <li><a href="#grid" class="wpa-control grid current" title="Grid View">Grid</a></li>
            <li><a href="#detail" class="wpa-control detail" title="Detail View">Detail</a></li>
            <li><a href="#list" class="wpa-control list" title="Detailed List View">Detail list</a></li>
            <li><a href="#line" class="wpa-control line" title="Line List View">Line List</a></li>
            <li>&nbsp;</li>
            <li class="openSearch"><a href="#openSearch" class="wpa-control search" title="Screen Options">Open Search</a>
            	<div class="wpa-screen-options hide">
					<span class="displayOptionshead"><?php _e('DISPLAY OPTIONS'); ?></span><?php
					foreach($columns as $name=>$group){
						?><h4> <strong><?php echo ucwords(str_replace('wpa-col-', '', $name)); ?></strong> <p><?php
						
						foreach($group as $col){
							
							if( isset($col['meta_key']) ) { 
								$inputID = $col['meta_key'].'-option';
								$inputVal = '.metrics-' . $col['meta_key'];
							} elseif( isset($col['value']) ) {
								$inputID = $col['value'].'-option';
								$inputVal = '.metrics-' . $col['value'];
							} elseif( isset($col['taxonomy']) ) {
								$inputID = $col['taxonomy'].'-option';
								$inputVal = '.metrics-' . $col['taxonomy'];
							} elseif( isset($col['post']) ) {
								$inputID = $col['post'].'-option';
								$inputVal = '.metrics-' . $col['post'];
							}
							
							?><label for="<?php echo $inputID; ?>"><input type="checkbox" class="ch-box checkbox-<?php echo $name; ?>" id="<?php echo $inputID; ?>" value="<?php echo $inputVal; ?>" <?php echo ($name == 'wpa-col-site') ? 'checked="checked"' : ''; ?> /><?php echo $col['name']; ?></label><?php
						}
						?></p>
                        <span class="clear"></span>
						</h4><?php
					}
					?><div class="clear"></div>
				</div>
            </li>
            <li class="openExport">
            	<a href="#export" class="wpa-control export" title="Export Options">Export</a>
                <div class="wpa-export-options hide">
                	<span class="displayOptionshead"><?php _e('DISPLAY OPTIONS'); ?></span>
                	<ul class="export">
                    	<li><a href="#">Save to CSV</a></li>
                        <li><a href="#">Save to PDF</a></li><?php
							$max_num_pages = $wp_query->max_num_pages;
							if($max_num_pages > 10){
								?><li>Pagination: <?php
									$pagination = 10;
									while($pagination < $max_num_pages){
										$pagination += 25;
										?><a href="<?php echo get_pagenum_link($pagination); ?>"><?php echo $pagination; ?></a><?php
									}
								?></li><?php
							}
                    ?></ul>
                </div>
            </li>
        </ul>
		
		<div class="clear"></div>
		
		<div class="wpa-group-column alignleft">
            <ul>
                <li class="first current"><a href=".wpa-col">All</a></li>
                <li class="first"><a href=".wpa-default">Summary</a></li><?php
                foreach($columns as $name=>$group){
                    $classes = array();
                    if($name == 'wpa-col-action'){
                        $classes[] = 'last';
                    }
                    ?><li class="<?php echo implode(' ', $classes); ?>"><a data-inputs=".checkbox-<?php echo $name; ?>" href=".<?php echo $name; ?>"><?php echo ucwords( str_replace('wpa-col-', '', $name) ); ?></a></li><?php
                }
            ?></ul>
        </div><?php
		
		$sortbytitle = $archivePage . 'orderby=title&order='. $order;
		$sortbyPR = $archivePage . 'meta_key=awp-google-rank&orderby=meta_value_num&order=' . $order;
		$sortbyalexa = $archivePage . 'meta_key=awp-alexa-rank&orderby=meta_value_num&order=' . $order;
		
		/* Sort Header */
		?><div class="wpa-sort-wrapper alignright">
			<p>Sort by:
			<a href="<?php echo $sortbytitle; ?>" class="wpa-sortable <?php echo $order; echo ($orderby == 'title') ? ' current' : ''; ?>" >Title</a> |
			<a href="<?php echo $sortbyPR; ?>" class="wpa-sortable <?php echo $order; echo ($meta == 'awp-google-rank') ? ' current' : ''; ?>">Google Rank</a> |
			<a href="<?php echo $sortbyalexa; ?>" class="wpa-sortable <?php echo $order; echo ($meta == 'awp-alexa-rank') ? ' current' : ''; ?>">Alexa Rank</a>
			</p>
		</div>
		
		<div class="clear"></div>
		
		<form class="wpa-filter-form hide" name="filter" action="<?php echo site_url('sites'); ?>" method="post">
			<span class="displayOptionshead"><?php _e('New Filter'); ?></span>
            <fieldset>
            	<select name="filter[action][]" id="wpa-action">
                    <option value="include">Include</option>
                    <option value="exclude">Exclude</option>
				</select>
                
                <select name="filter[term][]" id="wpa-filter-term">
                    <option value="0">Keyword</option>
                </select>
                
                <input type="text" name="filter[s][]" id="wpa-filter-search" value="" />
            </fieldset>
            
            <input type="submit" class="wpa-submit-button" id="wpa-filter-button" name="search" value="Search" />
            
            <div class="clear"></div>
		</form><?php
		
		/* Collapsable area
		?><div class="wpa-collapse-wrapper">
			<a href="javascript:void(0);" class="wpa-collapse-btn">
				<span>Open Search</span>
				<span style="display:none;">Close Search</span>
			</a>
			<div class="wpa-collapse">
                
			</div>
		</div><?php
		End of Collapsable area */
		
		if ( $wp_query->have_posts() ) :
		
			?><header class="page-header">
                <h1 class="page-title"><?php
					$title = apply_filters('wpa_archive_page_title', 'WordPress Authority Site Directory');
					echo $title;
				?></h1>
            </header><?php
            
            $content_before = apply_filters('wpa_archive_content_before', '');
			echo $content_before;
			
            ?><div class="wpa-display-archives grid">
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
							
							if( isset($col['meta_key']) ){
								$sort = $archivePage.'meta_key='.$col['meta_key'].'&orderby='.$oby.'&order='.$order;
							} elseif( isset($col['post']) ) {
								$sort = $archivePage.'&orderby='.$col['post'].'&order='.$order;
							}
							
							$class = array('wpa-sortable', $order);
							$class[] = ($meta == $col['meta_key']) ? 'current' : null;
							
							$classes = array('wpa-th', 'wpa-col', 'hide');
							
							if( isset($col['meta_key']) ) { 
								$classes[] = 'metrics-' . $col['meta_key'];
							} elseif( isset($col['value']) ) {
								$classes[] = 'metrics-' . $col['value'];
							} elseif( isset($col['taxonomy']) ) {
								$classes[] = 'metrics-' . $col['taxonomy'];
							} elseif( isset($col['post']) ) {
								$classes[] = 'metrics-' . $col['post'];
							}
							
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
					$class .= (current_user_can('edit_post')) ? ' edit-enabled' : '';
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
                            	<?php edit_post_link('Edit'); ?>
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
                                <?php edit_post_link('Edit'); ?>
                            </div><?php
							
							foreach($columns as $class=>$group){
								foreach($group as $col){
									
									$classes = array('wpa-td', 'wpa-col', 'hide');
									$classes[] = $col['body'];
									$classes[] = $class;
									
									if( isset($col['meta_key']) ) { 
										$classes[] = 'metrics-' . $col['meta_key'];
									} elseif( isset($col['value']) ) {
										$classes[] = 'metrics-' . $col['value'];
									} elseif( isset($col['taxonomy']) ) {
										$classes[] = 'metrics-' . $col['taxonomy'];
									} elseif( isset($col['post']) ) {
										$classes[] = 'metrics-' . $col['post'];
									}
									
									if($class == 'wpa-col-site'){
										$classes[] = 'wpa-default';
									}
									
									if($class == 'wpa-col-scores'){
										$classes[] = 'wpa-scores';
									}
									
									?><div class="<?php echo implode(' ', $classes); ?> "><?php
										
										$data = '';
										if( isset($col['meta_key']) ){
											$data .= $metrics[$col['meta_key']][0];
										} elseif( isset($col['taxonomy']) ) {
											$term_list = wp_get_post_terms($post_id, $col['taxonomy']);
											foreach($term_list as $term){
												$data .= '<a href="' . get_term_link( $term, $term->taxonomy ) . '">' . $term->name . '</a>';
											}
										} elseif( isset($col['post']) ) {
											$data .= $post->$col['post'];
										} elseif( isset($col['value']) ) {
											switch($col['value']){
												case 'thumbnail':
													$data .= '<img src="' . $thumbnailURL . '" alt="' . get_the_title() . '" />';
													break;
											}
										}
										
										if( isset($col['format']) ){
											switch( $col['format'] ){
												case 'date':
													$data = ($data) ? date('F j, Y', strtotime($data)) : ''; break;
											}
										}
										
										if( isset($col['link']) ){
											switch($col['link']){
												case 'meta':
													$link = $col['meta_key']; break;
												default:
													$link = $metrics[$col['link']][0];
											}
											$data = '<a href="'. $link .'" target="_blank">'. $data .'</a>';
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
                                <?php edit_post_link('Edit'); ?>
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
                                	<?php edit_post_link('Edit'); ?>
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