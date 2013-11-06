<?php

function wpa_default_metrics(){
	global $fields;
	$fields = array();

	$shortname = 'awp';
	
	// Departments
	$fields[$shortname.'-departments'] = array(
		'name' => 'Departments',
		'id' => $shortname.'-departments',
		'type' => 'separator'
	);
	
		// General
		$fields[$shortname.'-general'] = array(
			'name' => 'Site',
			'id' => $shortname.'-general',
			'type' => 'heading',
			'category' => 'departments',
			'readonly' => true
		);
		
		$fields[$shortname.'-thumbnail'] = array(
			'name' => 'Image URL',
			'id' => $shortname.'-thumbnail',
			'type' => 'upload',
			'group' => $shortname.'-general',
			'readonly' => true
		);
		
		$fields[$shortname.'-name'] = array(
			'name' => 'Name',
			'id' => $shortname.'-name',
			'type' => 'text',
			'group' => $shortname.'-general',
			'readonly' => true
		);
		
		$fields[$shortname.'-domain'] = array(
			'name' => 'Domain',
			'id' => $shortname.'-domain',
			'type' => 'text',
			'group' => $shortname.'-general',
			'readonly' => true
		);
		
		$fields[$shortname.'-tld'] = array(
			'name' => 'TLD',
			'id' => $shortname.'-tld',
			'type' => 'text',
			'group' => $shortname.'-general',
			'readonly' => true
		);
		
		$fields[$shortname.'-url'] = array(
			'name' => 'URL – Link',
			'id' => $shortname.'-url',
			'type' => 'text',
			'group' => $shortname.'-general',
			'readonly' => true
		);
		
		$fields[$shortname.'-date'] = array(
			'name' => 'Date Founded',
			'id' => $shortname.'-date',
			'type' => 'text',
			'group' => $shortname.'-general',
			'readonly' => true
		);
		
		$fields[$shortname.'-networked'] = array(
			'name' => 'Network IN?',
			'id' => $shortname.'-networked',
			'type' => 'text',
			'group' => $shortname.'-general',
			'readonly' => true
		);
		
		$fields[$shortname.'-location'] = array(
			'name' => 'Location',
			'id' => $shortname.'-location',
			'type' => 'text',
			'group' => $shortname.'-general',
			'readonly' => true
		);
		
		$fields[$shortname.'-language'] = array(
			'name' => 'Language',
			'id' => $shortname.'-language',
			'type' => 'text',
			'group' => $shortname.'-general',
			'readonly' => true
		);
		
		// Owners
		$fields[$shortname.'-owners'] = array(
			'name' => 'Project',
			'id' => $shortname.'-owners',
			'type' => 'heading',
			'category' => 'departments',
			'readonly' => true
		);
		
		$fields[$shortname.'-founder'] = array(
			'name' => 'Founder',
			'id' => $shortname.'-founder',
			'type' => 'text',
			'group' => $shortname.'-owners',
			'readonly' => true
		);
		
		$fields[$shortname.'-owner'] = array(
			'name' => 'Owner',
			'id' => $shortname.'-owner',
			'type' => 'text',
			'group' => $shortname.'-owners',
			'readonly' => true
		);
		
		$fields[$shortname.'-publisher'] = array(
			'name' => 'Publisher',
			'id' => $shortname.'-publisher',
			'type' => 'text',
			'group' => $shortname.'-owners',
			'readonly' => true
		);
		
		$fields[$shortname.'-producer'] = array(
			'name' => 'Producer',
			'id' => $shortname.'-producer',
			'type' => 'text',
			'group' => $shortname.'-owners',
			'readonly' => true
		);
		
		$fields[$shortname.'-manager'] = array(
			'name' => 'Manager',
			'id' => $shortname.'-manager',
			'type' => 'text',
			'group' => $shortname.'-owners',
			'readonly' => true
		);
		
		$fields[$shortname.'-developer'] = array(
			'name' => 'Developer',
			'id' => $shortname.'-developer',
			'type' => 'text',
			'group' => $shortname.'-owners',
			'readonly' => true
		);
		
		$fields[$shortname.'-editor'] = array(
			'name' => 'Editor',
			'id' => $shortname.'-editor',
			'type' => 'text',
			'group' => $shortname.'-owners',
			'readonly' => true
		);
		
		$fields[$shortname.'-ceo'] = array(
			'name' => 'CEO',
			'id' => $shortname.'-ceo',
			'type' => 'text',
			'group' => $shortname.'-owners',
			'readonly' => true
		);
		
		$fields[$shortname.'-member'] = array(
			'name' => 'Network Member',
			'id' => $shortname.'-member',
			'type' => 'text',
			'group' => $shortname.'-owners',
			'readonly' => true
		);
	
	// Signals
	$fields[$shortname.'-signals'] = array(
		'name' => 'Signals',
		'id' => $shortname.'-signals',
		'type' => 'separator'
	);
	
		// Links
		$fields[$shortname.'-links'] = array(
			'name' => 'Links',
			'id' => $shortname.'-links',
			'type' => 'heading',
			'category' => 'signals',
			'readonly' => true
		);
		
		$fields[$shortname.'-google'] = array(
			'name' => 'Google',
			'id' => $shortname.'-google',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-alexa'] = array(
			'name' => 'Alexa',
			'id' => $shortname.'-alexa',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-yahoo'] = array(
			'name' => 'Yahoo',
			'id' => $shortname.'-yahoo',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-majestic'] = array(
			'name' => 'Majestic',
			'id' => $shortname.'-majestic',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-subscriber'] = array(
			'name' => 'Social',
			'id' => $shortname.'-subscriber',
			'type' => 'heading',
			'category' => 'signals',
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-goolgeplus'] = array(
			'name' => 'Google Plus',
			'id' => $shortname.'-shares-goolgeplus',
			'type' => 'text',
			'group' => $shortname.'-subscriber',
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-facebook'] = array(
			'name' => 'Facebook Shares',
			'id' => $shortname.'-shares-facebook',
			'type' => 'text',
			'group' => $shortname.'-subscriber',
			'readonly' => true
		);
		
		$fields[$shortname.'-likes-facebook'] = array(
			'name' => 'Facebook Likes',
			'id' => $shortname.'-likes-facebook',
			'type' => 'text',
			'group' => $shortname.'-subscriber',
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-twitter'] = array(
			'name' => 'Twitter',
			'id' => $shortname.'-shares-twitter',
			'type' => 'text',
			'group' => $shortname.'-subscriber',
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-pinterest'] = array(
			'name' => 'Pinterest',
			'id' => $shortname.'-shares-pinterest',
			'type' => 'text',
			'group' => $shortname.'-subscriber',
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-linkedin'] = array(
			'name' => 'LinkedIn',
			'id' => $shortname.'-shares-linkedin',
			'type' => 'text',
			'group' => $shortname.'-subscriber',
			'readonly' => true
		);
		
		$fields[$shortname.'-score-klout'] = array(
			'name' => 'Klout',
			'id' => $shortname.'-score-klout',
			'type' => 'text',
			'group' => $shortname.'-subscriber',
			'readonly' => true
		);
		
		// Community
		$fields[$shortname.'-social'] = array(
			'name' => 'Community',
			'id' => $shortname.'-social',
			'type' => 'heading',
			'category' => 'signals',
			'readonly' => true
		);
		
		$fields[$shortname.'-googleplus-followers'] = array(
			'name' => 'Google Plus Followers',
			'id' => $shortname.'-googleplus-followers',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-googleplus'] = array(
			'name' => 'Google Plus URL',
			'id' => $shortname.'-googleplus',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-facebook-followers'] = array(
			'name' => 'Facebook Followers',
			'id' => $shortname.'-facebook-followers',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-facebook'] = array(
			'name' => 'Facebook URL',
			'id' => $shortname.'-facebook',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-twitter-followers'] = array(
			'name' => 'Twitter Followers',
			'id' => $shortname.'-twitter-followers',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-twitter'] = array(
			'name' => 'Twitter URL',
			'id' => $shortname.'-twitter',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-youtube-followers'] = array(
			'name' => 'Youtube Followers',
			'id' => $shortname.'-youtube-followers',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-youtube'] = array(
			'name' => 'Youtube URL',
			'id' => $shortname.'-youtube',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-pinterest-followers'] = array(
			'name' => 'Pinterest Followers',
			'id' => $shortname.'-pinterest-followers',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-pinterest'] = array(
			'name' => 'Pinterest URL',
			'id' => $shortname.'-pinterest',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-linkedin-followers'] = array(
			'name' => 'LinkedIn Followers',
			'id' => $shortname.'-linkedin-followers',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-linkedin'] = array(
			'name' => 'LinkedIn URL',
			'id' => $shortname.'-linkedin',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-klout-followers'] = array(
			'name' => 'Klout Followers',
			'id' => $shortname.'-klout-followers',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-klout'] = array(
			'name' => 'Klout',
			'id' => $shortname.'-klout',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-rss'] = array(
			'name' => 'RSS',
			'id' => $shortname.'-rss',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-email'] = array(
			'name' => 'Email',
			'id' => $shortname.'-email',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		// Buzz
		$fields[$shortname.'-buzz'] = array(
			'name' => 'Buzz',
			'id' => $shortname.'-buzz',
			'type' => 'heading',
			'category' => 'signals',
			'readonly' => true
		);
		
		$fields[$shortname.'-community-metric'] = array(
			'name' => 'Community Metrics',
			'id' => $shortname.'-community-metric',
			'type' => 'text',
			'group' => $shortname.'-buzz',
			'readonly' => true
		);
		
		$fields[$shortname.'-recent-post'] = array(
			'name' => 'Recent Post',
			'id' => $shortname.'-recent-post',
			'type' => 'text',
			'group' => $shortname.'-buzz',
			'readonly' => true
		);
		
		$fields[$shortname.'-recent-comments'] = array(
			'name' => 'Recent Comments',
			'id' => $shortname.'-recent-comments',
			'type' => 'text',
			'group' => $shortname.'-buzz',
			'readonly' => true
		);
		
		$fields[$shortname.'-recent-shares'] = array(
			'name' => 'Recent Shares',
			'id' => $shortname.'-recent-shares',
			'type' => 'text',
			'group' => $shortname.'-buzz',
			'readonly' => true
		);
	
		$fields[$shortname.'-klout-score'] = array(
			'name' => 'Klout Score',
			'id' => $shortname.'-klout-score',
			'type' => 'text',
			'group' => $shortname.'-buzz',
			'readonly' => true
		);
		
		// Framework
		$fields[$shortname.'-framework'] = array(
			'name' => 'Framework',
			'id' => $shortname.'-framework',
			'type' => 'heading',
			'category' => 'signals',
			'readonly' => true
		);
		
		$fields[$shortname.'-plugins-paid'] = array(
			'name' => 'Plugins (Paid)',
			'id' => $shortname.'-plugins-paid',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-plugins-free'] = array(
			'name' => 'Plugins (free)',
			'id' => $shortname.'-plugins-free',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-plugins-custom'] = array(
			'name' => 'Plugins (Custom)',
			'id' => $shortname.'-plugins-custom',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-functions-custom'] = array(
			'name' => 'Functions (Custom)',
			'id' => $shortname.'-functions-custom',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-theme-paid'] = array(
			'name' => 'Theme (Paid)',
			'id' => $shortname.'-theme-paid',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-theme-framework'] = array(
			'name' => 'Theme Framework',
			'id' => $shortname.'-theme-framework',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-theme-custom'] = array(
			'name' => 'Theme (Custom)',
			'id' => $shortname.'-theme-custom',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-services-facebook'] = array(
			'name' => 'Services (Facebook)',
			'id' => $shortname.'-services-facebook',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-services-twitter'] = array(
			'name' => 'Services (Twitter)',
			'id' => $shortname.'-services-twitter',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-services-google'] = array(
			'name' => 'Services (Google+)',
			'id' => $shortname.'-services-google',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
	// Valuation
	$fields[$shortname.'-valuation'] = array(
		'name' => 'Valuation',
		'id' => $shortname.'-valuation',
		'type' => 'separator'
	);
	
		// Ranks
		$fields[$shortname.'-ranks'] = array(
			'name' => 'Ranks',
			'id' => $shortname.'-ranks',
			'type' => 'heading',
			'category' => 'valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-alexa-rank'] = array(
			'name' => 'Alexa Rank',
			'id' => $shortname.'-alexa-rank',
			'type' => 'text',
			'group' => $shortname.'-ranks',
			'readonly' => true
		);
		
		$fields[$shortname.'-moz-rank'] = array(
			'name' => 'MOZ Rank',
			'id' => $shortname.'-moz-rank',
			'type' => 'text',
			'group' => $shortname.'-ranks',
			'readonly' => true
		);
		
		$fields[$shortname.'-compete-rank'] = array(
			'name' => 'Compete Rank',
			'id' => $shortname.'-compete-rank',
			'type' => 'text',
			'group' => $shortname.'-ranks',
			'readonly' => true
		);
		
		$fields[$shortname.'-semrush-rank'] = array(
			'name' => 'SEM Rush Rank',
			'id' => $shortname.'-semrush-rank',
			'type' => 'text',
			'group' => $shortname.'-ranks',
			'readonly' => true
		);
		
		$fields[$shortname.'-one-rank'] = array(
			'name' => '1Rank',
			'id' => $shortname.'-one-rank',
			'type' => 'text',
			'group' => $shortname.'-ranks',
			'readonly' => true
		);
		
		$fields[$shortname.'-one-score'] = array(
			'name' => 'One Score',
			'id' => $shortname.'-one-score',
			'type' => 'text',
			'group' => $shortname.'-ranks',
			'readonly' => true
		);
		
		// Scores
		$fields[$shortname.'-score'] = array(
			'name' => 'Scores',
			'id' => $shortname.'-score',
			'type' => 'heading',
			'category' => 'valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-site-score'] = array(
			'name' => 'Site',
			'id' => $shortname.'-site-score',
			'type' => 'text',
			'group' => $shortname.'-score',
			'readonly' => true
		);
		
		$fields[$shortname.'-project-score'] = array(
			'name' => 'Project',
			'id' => $shortname.'-project-score',
			'type' => 'text',
			'group' => $shortname.'-score',
			'readonly' => true
		);
		
		$fields[$shortname.'-google-rank'] = array(
			'name' => 'Google Score',
			'id' => $shortname.'-google-rank',
			'type' => 'text',
			'group' => $shortname.'-score',
			'readonly' => true
		);
		
		$fields[$shortname.'-links-scores'] = array(
			'name' => 'Link Score',
			'id' => $shortname.'-links-scores',
			'type' => 'text',
			'group' => $shortname.'-score',
			'readonly' => true
		);
		
		$fields[$shortname.'-community-scores'] = array(
			'name' => 'Community Score',
			'id' => $shortname.'-community-scores',
			'type' => 'text',
			'group' => $shortname.'-score',
			'readonly' => true
		);
		
		$fields[$shortname.'-social-scores'] = array(
			'name' => 'Social Score',
			'id' => $shortname.'-social-scores',
			'type' => 'text',
			'group' => $shortname.'-score',
			'readonly' => true
		);
		
		$fields[$shortname.'-buzz-score'] = array(
			'name' => 'Buzz',
			'id' => $shortname.'-buzz-score',
			'type' => 'text',
			'group' => $shortname.'-score',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-score'] = array(
			'name' => 'Framework',
			'id' => $shortname.'-framework-score',
			'type' => 'text',
			'group' => $shortname.'-score',
			'readonly' => true
		);
		
		$fields[$shortname.'-ranks-scores'] = array(
			'name' => 'Ranks Score',
			'id' => $shortname.'-ranks-scores',
			'type' => 'text',
			'group' => $shortname.'-score',
			'readonly' => true
		);
		
		$fields[$shortname.'-traffic-scores'] = array(
			'name' => 'Traffic Score',
			'id' => $shortname.'-traffic-scores',
			'type' => 'text',
			'group' => $shortname.'-score',
			'readonly' => true
		);
		
		$fields[$shortname.'-engagement-scores'] = array(
			'name' => 'Engagement Score',
			'id' => $shortname.'-engagement-scores',
			'type' => 'text',
			'group' => $shortname.'-score',
			'readonly' => true
		);
		
		$fields[$shortname.'-content-scores'] = array(
			'name' => 'Content Score',
			'id' => $shortname.'-content-scores',
			'type' => 'text',
			'group' => $shortname.'-score',
			'readonly' => true
		);
		
		$fields[$shortname.'-systems-score'] = array(
			'name' => 'Systems',
			'id' => $shortname.'-systems-score',
			'type' => 'text',
			'group' => $shortname.'-score',
			'readonly' => true
		);
		
		$fields[$shortname.'-authors-scores'] = array(
			'name' => 'Authors Score',
			'id' => $shortname.'-authors-scores',
			'type' => 'text',
			'group' => $shortname.'-score',
			'readonly' => true
		);
		
		$fields[$shortname.'-scores-score'] = array(
			'name' => 'Scores',
			'id' => $shortname.'-scores-score',
			'type' => 'text',
			'group' => $shortname.'-score',
			'readonly' => true
		);
		
		$fields[$shortname.'-valuation-score'] = array(
			'name' => 'Valuation',
			'id' => $shortname.'-valuation-score',
			'type' => 'text',
			'group' => $shortname.'-score',
			'readonly' => true
		);
	
		// Traffic
		$fields[$shortname.'-traffic'] = array(
			'name' => 'Traffic',
			'id' => $shortname.'-traffic',
			'type' => 'heading',
			'category' => 'valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-unique-visitors'] = array(
			'name' => 'Monthly Unique Visitors',
			'id' => $shortname.'-unique-visitors',
			'type' => 'text',
			'group' => $shortname.'-traffic',
			'readonly' => true
		);
		
		$fields[$shortname.'-page-views'] = array(
			'name' => 'Monthly Page Views',
			'id' => $shortname.'-page-views',
			'type' => 'text',
			'group' => $shortname.'-traffic',
			'readonly' => true
		);
		
		$fields[$shortname.'-page-speed'] = array(
			'name' => 'Page Speed',
			'id' => $shortname.'-page-speed',
			'type' => 'text',
			'group' => $shortname.'-traffic',
			'readonly' => true
		);
	
		// Engagement
		$fields[$shortname.'-engagement'] = array(
			'name' => 'Engagement',
			'id' => $shortname.'-engagement',
			'type' => 'heading',
			'category' => 'valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-pages-per-visit'] = array(
			'name' => 'Pages Per Visit',
			'id' => $shortname.'-pages-per-visit',
			'type' => 'text',
			'group' => $shortname.'-engagement',
			'readonly' => true
		);
		
		$fields[$shortname.'-time-per-visit'] = array(
			'name' => 'Time Per Visit',
			'id' => $shortname.'-time-per-visit',
			'type' => 'text',
			'group' => $shortname.'-engagement',
			'readonly' => true
		);
		
		$fields[$shortname.'-comments-active'] = array(
			'name' => 'Comments Active',
			'id' => $shortname.'-comments-active',
			'type' => 'text',
			'group' => $shortname.'-engagement',
			'readonly' => true
		);
		
		$fields[$shortname.'-comment-system'] = array(
			'name' => 'Comment System',
			'id' => $shortname.'-comment-system',
			'type' => 'text',
			'group' => $shortname.'-engagement',
			'readonly' => true
		);
		
		$fields[$shortname.'-comments-per-post'] = array(
			'name' => 'Comments Per Post',
			'id' => $shortname.'-comments-per-post',
			'type' => 'text',
			'group' => $shortname.'-engagement',
			'readonly' => true
		);
		
		$fields[$shortname.'-percent-longer-15'] = array(
			'name' => 'Percent Longer than 15 Seconds',
			'id' => $shortname.'-percent-longer-15',
			'type' => 'text',
			'group' => $shortname.'-engagement',
			'readonly' => true
		);
		
		$fields[$shortname.'-10-seconds-under-55'] = array(
			'name' => '0-10 Seconds under 55%',
			'id' => $shortname.'-10-seconds-under-55',
			'type' => 'text',
			'group' => $shortname.'-engagement',
			'readonly' => true
		);
		
		// valuation
		$fields[$shortname.'-valuation'] = array(
			'name' => 'Valuation',
			'id' => $shortname.'-valuation',
			'type' => 'heading',
			'category' => 'valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-replacement-content'] = array(
			'name' => 'Replacement - Content',
			'id' => $shortname.'-replacement-content',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-replacement-technology'] = array(
			'name' => 'Replacement - Technology',
			'id' => $shortname.'-replacement-technology',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-replacement-community'] = array(
			'name' => 'Replacement - Community',
			'id' => $shortname.'-replacement-community',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-last-valuation'] = array(
			'name' => 'Last Valuation',
			'id' => $shortname.'-last-valuation',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-revenue-multiplier'] = array(
			'name' => 'Revenue Value Multiplier',
			'id' => $shortname.'-revenue-multiplier',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-income-multiplier'] = array(
			'name' => 'Income value Multiplier',
			'id' => $shortname.'-income-multiplier',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-daily-worth'] = array(
			'name' => 'Daily Worth (From Income Diary)',
			'id' => $shortname.'-daily-worth',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-staff'] = array(
			'name' => 'Staff',
			'id' => $shortname.'-staff',
			'type' => 'text',
			//'group' => $shortname.'-management'
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-net-income'] = array(
			'name' => 'Net Income',
			'id' => $shortname.'-net-income',
			'type' => 'text',
			//'group' => $shortname.'-financials'
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-gross-revenue'] = array(
			'name' => 'Gross Revenue',
			'id' => $shortname.'-gross-revenue',
			'type' => 'text',
			//'group' => $shortname.'-financials'
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-trailing-12-months'] = array(
			'name' => 'Trailing 12 Months',
			'id' => $shortname.'-trailing-12-months',
			'type' => 'text',
			//'group' => $shortname.'-financials'
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-cost-to-build'] = array(
			'name' => 'Cost to Build',
			'id' => $shortname.'-cost-to-build',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-cost-expense'] = array(
			'name' => 'Expenses',
			'id' => $shortname.'-cost-expense',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
	
		// Content
		$fields[$shortname.'-content'] = array(
			'name' => 'Content',
			'id' => $shortname.'-content',
			'type' => 'heading',
			'category' => 'valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-silos-number'] = array(
			'name' => 'Number of Defined Silos',
			'id' => $shortname.'-silos-number',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-silos-tag'] = array(
			'name' => 'Silos',
			'id' => $shortname.'-silos-tag',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-rich-snippet-types'] = array(
			'name' => 'Number of Rich Snippet Types',
			'id' => $shortname.'-rich-snippet-types',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-rich-snippets'] = array(
			'name' => 'Number of Rich Snippets',
			'id' => $shortname.'-rich-snippets',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
	
		/*Developments
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
		);*/
	
		// Authors
		$fields[$shortname.'-authors'] = array(
			'name' => 'Authors',
			'id' => $shortname.'-authors',
			'type' => 'heading',
			'category' => 'valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-authors-number'] = array(
			'name' => 'Number of Authors',
			'id' => $shortname.'-authors-number',
			'type' => 'text',
			'group' => $shortname.'-authors',
			'readonly' => true
		);
		
		$fields[$shortname.'-bio-type'] = array(
			'name' => 'Bio Type',
			'id' => $shortname.'-bio-type',
			'type' => 'text',
			'group' => $shortname.'-authors',
			'readonly' => true
		);
		
		$fields[$shortname.'-byline-type'] = array(
			'name' => 'Byline Type',
			'id' => $shortname.'-byline-type',
			'type' => 'text',
			'group' => $shortname.'-authors',
			'readonly' => true
		);
		
		$fields[$shortname.'-author-page-type'] = array(
			'name' => 'Author Page Type',
			'id' => $shortname.'-author-page-type',
			'type' => 'text',
			'group' => $shortname.'-authors',
			'readonly' => true
		);
		
		$fields[$shortname.'-author-paid'] = array(
			'name' => 'Paid',
			'id' => $shortname.'-author-paid',
			'type' => 'text',
			'group' => $shortname.'-authors',
			'readonly' => true
		);
		
		$fields[$shortname.'-author-free'] = array(
			'name' => 'Free',
			'id' => $shortname.'-author-free',
			'type' => 'text',
			'group' => $shortname.'-authors',
			'readonly' => true
		);
		
		$fields[$shortname.'-revenue-share'] = array(
			'name' => 'Revenue Share',
			'id' => $shortname.'-revenue-share',
			'type' => 'text',
			'group' => $shortname.'-authors',
			'readonly' => true
		);
		
		$fields[$shortname.'-profiles-number'] = array(
			'name' => 'Number of Connected Profiles',
			'id' => $shortname.'-profiles-number',
			'type' => 'text',
			'group' => $shortname.'-authors',
			'readonly' => true
		);
		
		// Products (Old = Brand)
		$fields[$shortname.'-products'] = array(
			'name' => 'Products',
			'id' => $shortname.'-products',
			'type' => 'heading',
			'category' => 'valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-brand-number'] = array(
			'name' => 'Number',
			'id' => $shortname.'-brand-number',
			'type' => 'text',
			'group' => $shortname.'-products',
			'readonly' => true
		);
		
		// Systems
		$fields[$shortname.'-systems'] = array(
			'name' => 'Systems',
			'id' => $shortname.'-systems',
			'type' => 'heading',
			'category' => 'valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-system-content'] = array(
			'name' => 'Content',
			'id' => $shortname.'-system-content',
			'type' => 'text',
			'group' => $shortname.'-systems',
			'readonly' => true
		);
		
		$fields[$shortname.'-system-marketing'] = array(
			'name' => 'Marketing',
			'id' => $shortname.'-system-marketing',
			'type' => 'text',
			'group' => $shortname.'-systems',
			'readonly' => true
		);
		
		$fields[$shortname.'-system-sales'] = array(
			'name' => 'Sales',
			'id' => $shortname.'-system-sales',
			'type' => 'text',
			'group' => $shortname.'-systems',
			'readonly' => true
		);
		
		$fields[$shortname.'-system-fulfilment'] = array(
			'name' => 'Fulfillment',
			'id' => $shortname.'-system-fulfilment',
			'type' => 'text',
			'group' => $shortname.'-systems',
			'readonly' => true
		);
		
		$fields[$shortname.'-system-management'] = array(
			'name' => 'Management (Staff)',
			'id' => $shortname.'-system-management',
			'type' => 'text',
			'group' => $shortname.'-systems',
			'readonly' => true
		);
	
	$cfields = get_option('wpa_metrics');
	
	$fields = wp_parse_args( $cfields, $fields);
	
	return $fields;
}

function wpa_get_metrics_groups(){
	$metrics = wpa_default_metrics();
	
	$groups = array();
	foreach($metrics as $fields){
		if('heading' == $fields['type']){
			$groups[] = $fields;
		} else {
			continue;
		}
	}
	
	return $groups;
}

function wpa_get_metrics_group_by_id($group_id){
	$metrics = wpa_default_metrics();
	
	$group = array();
	foreach($metrics as $field){
		if('heading' == $field['type']){
			if($group_id === $field['id']){
				$group = $field;
			}
		} else {
			continue;
		}
	}
	
	return $group;
}

function wpa_get_metrics_group_by_category($category){
	$metrics = wpa_default_metrics();
	
	$groups = array();
	foreach($metrics as $field){
		if('heading' == $field['type']){
			if($category === $field['category']){
				$groups[] = $field;
			}
		} else {
			continue;
		}
	}
	
	return $groups;
}

function wpa_get_metrics_by_group($group_id){
	$metrics = wpa_default_metrics();
	
	$groups = array();
	foreach($metrics as $field){
		if('heading' == $field['type']){
			if($group_id === $field['id']){
				$groups[] = $field;
			}
		} else {
			continue;
		}
	}
	
	return $groups;
}

function wpa_get_editable_metrics(){
}

function wpa_get_metrics_by_id($id){
	$metrics = wpa_default_metrics();
	
	foreach($metrics as $field){
		if('seperator' == $field['type'] || 'heading' == $field['type']){
			continue;
		} else {
			if($id === $field['id']){
				$metric = $field;
			}
		}
	}
	
	return $metric;
}