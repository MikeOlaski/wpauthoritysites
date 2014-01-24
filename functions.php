<?php

function wpa_default_metrics(){
	global $fields;
	$fields = array();

	$shortname = 'awp';
	
	$fields[$shortname.'-departments'] = array(
		'name' => 'Departments',
		'id' => $shortname.'-departments',
		'type' => 'separator'
	);
	
		/********** 	SITE	 ***********/
		$fields[$shortname.'-site'] = array(
			'name' => 'Site',
			'id' => $shortname.'-site',
			'type' => 'heading',
			'category' => 'departments',
			'readonly' => true
		);
		
		$fields[$shortname.'-thumbnail'] = array(
			'name' => 'Thumbnail',
			'id' => $shortname.'-thumbnail',
			'type' => 'upload',
			'group' => $shortname.'-site',
			'readonly' => true,
			'format' => 'image'
		);
		
		$fields[$shortname.'-domain'] = array(
			'name' => 'Domain',
			'id' => $shortname.'-domain',
			'type' => 'text',
			'group' => $shortname.'-site',
			'desc' => 'by Site Auditor',
			'readonly' => true
		);
		
		$fields[$shortname.'-tld'] = array(
			'name' => 'TLD',
			'id' => $shortname.'-tld',
			'type' => 'text',
			'group' => $shortname.'-site',
			'desc' => 'by Site Auditor',
			'readonly' => true
		);
		
		$fields[$shortname.'-url'] = array(
			'name' => 'URL',
			'id' => $shortname.'-url',
			'type' => 'text',
			'group' => $shortname.'-site',
			'desc' => 'by Site Auditor',
			'readonly' => true,
			'format' => 'link'
		);
		
		$fields[$shortname.'-date'] = array(
			'name' => 'Date Founded',
			'id' => $shortname.'-date',
			'type' => 'text',
			'group' => $shortname.'-site',
			'desc' => 'by Site Auditor',
			'programmatic' => true,
			'readonly' => true,
			'format' => 'date'
		);
		
		$fields[$shortname.'-date-launched'] = array(
			'name' => 'Date Launched',
			'id' => $shortname.'-date-launched',
			'type' => 'text',
			'group' => $shortname.'-site',
			'desc' => 'by Site Auditor',
			'readonly' => true,
			'format' => 'date'
		);
		
		$fields[$shortname.'-location'] = array(
			'name' => 'Server Location',
			'id' => $shortname.'-location',
			'type' => 'text',
			'group' => $shortname.'-site',
			'desc' => 'by Site Auditor',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-language'] = array(
			'name' => 'Language',
			'id' => $shortname.'-language',
			'type' => 'text',
			'group' => $shortname.'-site',
			'desc' => 'by Site Auditor',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-name'] = array(
			'name' => 'Name',
			'id' => $shortname.'-name',
			'type' => 'text',
			'group' => $shortname.'-site',
			'readonly' => true
		);
		
		$fields[$shortname.'-domain-age'] = array(
			'name' => 'Domain Age',
			'id' => $shortname.'-domain-age',
			'type' => 'text',
			'group' => $shortname.'-site',
			'readonly' => true
		);
		
		$fields[$shortname.'-domain-expiry'] = array(
			'name' => 'Domain Expiry',
			'id' => $shortname.'-domain-expiry',
			'type' => 'text',
			'group' => $shortname.'-site',
			'readonly' => true
		);
		
		$fields[$shortname.'-server-location'] = array(
			'name' => 'Server Location',
			'id' => $shortname.'-server-location',
			'type' => 'text',
			'group' => $shortname.'-site',
			'desc' => '',
			'readonly' => true
		);
		
		$fields[$shortname.'-business-location'] = array(
			'name' => 'Business Location',
			'id' => $shortname.'-business-location',
			'type' => 'text',
			'group' => $shortname.'-site',
			'desc' => '',
			'readonly' => true
		);
		
		$fields[$shortname.'-site-cache'] = array(
			'name' => 'Site Cache',
			'id' => $shortname.'-site-cache',
			'type' => 'text',
			'group' => $shortname.'-site',
			'desc' => '',
			'readonly' => true
		);
		
		$fields[$shortname.'-site-summary'] = array(
			'name' => 'Summary / Description',
			'id' => $shortname.'-site-summary',
			'type' => 'text',
			'group' => $shortname.'-site',
			'desc' => '',
			'readonly' => true
		);
		
		$fields[$shortname.'-site-excerpt'] = array(
			'name' => 'Excerpt',
			'id' => $shortname.'-site-excerpt',
			'type' => 'text',
			'group' => $shortname.'-site',
			'desc' => '',
			'readonly' => true
		);
		/**********		END OF SITE 	***********/
		
		/********** 	TEAM	 ***********/
		$fields[$shortname.'-team'] = array(
			'name' => 'Team',
			'id' => $shortname.'-team',
			'type' => 'heading',
			'category' => 'departments',
			'readonly' => true
		);
		
		$fields[$shortname.'-founder'] = array(
			'name' => 'Founders',
			'id' => $shortname.'-founder',
			'type' => 'text',
			'group' => $shortname.'-team',
			'readonly' => true
		);
		
		$fields[$shortname.'-owner'] = array(
			'name' => 'Owners',
			'id' => $shortname.'-owner',
			'type' => 'text',
			'group' => $shortname.'-team',
			'readonly' => true
		);
		
		$fields[$shortname.'-publisher'] = array(
			'name' => 'Publisher',
			'id' => $shortname.'-publisher',
			'type' => 'text',
			'group' => $shortname.'-team',
			'readonly' => true
		);
		
		$fields[$shortname.'-producer'] = array(
			'name' => 'Producer',
			'id' => $shortname.'-producer',
			'type' => 'text',
			'group' => $shortname.'-team',
			'readonly' => true
		);
		
		$fields[$shortname.'-manager'] = array(
			'name' => 'Managers',
			'id' => $shortname.'-manager',
			'type' => 'text',
			'group' => $shortname.'-team',
			'readonly' => true
		);
		
		$fields[$shortname.'-site-runner'] = array(
			'name' => 'Site Runner',
			'id' => $shortname.'-site-runner',
			'type' => 'text',
			'group' => $shortname.'-team',
			'readonly' => true
		);
		
		$fields[$shortname.'-developer'] = array(
			'name' => 'Developers',
			'id' => $shortname.'-developer',
			'type' => 'text',
			'group' => $shortname.'-team',
			'readonly' => true
		);
		
		$fields[$shortname.'-contributors'] = array(
			'name' => 'Contributors',
			'id' => $shortname.'-contributors',
			'type' => 'text',
			'group' => $shortname.'-team',
			'readonly' => true
		);
		
		$fields[$shortname.'-authors'] = array(
			'name' => 'Authors',
			'id' => $shortname.'-authors',
			'type' => 'text',
			'group' => $shortname.'-team',
			'readonly' => true
		);
		
		$fields[$shortname.'-editor'] = array(
			'name' => 'Editors',
			'id' => $shortname.'-editor',
			'type' => 'text',
			'group' => $shortname.'-team',
			'readonly' => true
		);
		
		$fields[$shortname.'-executives'] = array(
			'name' => 'Executives',
			'id' => $shortname.'-executives',
			'type' => 'text',
			'group' => $shortname.'-team',
			'readonly' => true
		);
		/**********		END OF TEAM 	***********/
		
		/********** 	FRAMEWORK	 ***********/
		$fields[$shortname.'-framework'] = array(
			'name' => 'Framework',
			'id' => $shortname.'-framework',
			'type' => 'heading',
			'category' => 'departments',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-system'] = array(
			'name' => 'System',
			'id' => $shortname.'-framework-system',
			'type' => 'subheading',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-system-host'] = array(
			'name' => 'Host',
			'id' => $shortname.'-framework-system-host',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-system-caching'] = array(
			'name' => 'Caching',
			'id' => $shortname.'-framework-system-caching',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-system-cdn'] = array(
			'name' => 'CDN',
			'id' => $shortname.'-framework-system-cdn',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-plugins'] = array(
			'name' => 'Plugins',
			'id' => $shortname.'-framework-plugins',
			'type' => 'subheading',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-plugins-paid'] = array(
			'name' => 'Paid',
			'id' => $shortname.'-framework-plugins-paid',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-plugins-free'] = array(
			'name' => 'Free',
			'id' => $shortname.'-framework-plugins-free',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-plugins-custom'] = array(
			'name' => 'Custom',
			'id' => $shortname.'-framework-plugins-custom',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-functions-custom'] = array(
			'name' => 'Functions (Custom)',
			'id' => $shortname.'-framework-functions-custom',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-themes'] = array(
			'name' => 'Theme',
			'id' => $shortname.'-framework-themes',
			'type' => 'subheading',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-themes-paid'] = array(
			'name' => 'Paid',
			'id' => $shortname.'-framework-themes-paid',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-themes-free'] = array(
			'name' => 'Free',
			'id' => $shortname.'-framework-themes-free',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-themes-custom'] = array(
			'name' => 'Custom',
			'id' => $shortname.'-framework-themes-custom',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-services'] = array(
			'name' => 'Services ',
			'id' => $shortname.'-framework-services',
			'type' => 'subheading',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-services-facebook'] = array(
			'name' => 'Services (Facebook)',
			'id' => $shortname.'-framework-services-facebook',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-services-twitter'] = array(
			'name' => 'Services (Twitter)',
			'id' => $shortname.'-framework-services-twitter',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-services-google'] = array(
			'name' => 'Services (Google Plus)',
			'id' => $shortname.'-framework-services-google',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		/**********		END OF FRAMEWORK 	***********/
		
		/********	AUTHORS	 **********/
		$fields[$shortname.'-authors'] = array(
			'name' => 'Authors',
			'id' => $shortname.'-authors',
			'type' => 'heading',
			'category' => 'departments',
			'readonly' => true
		);
		
		$fields[$shortname.'-authors-number'] = array(
			'name' => 'No. of Authors',
			'id' => $shortname.'-authors-number',
			'type' => 'text',
			'group' => $shortname.'-authors',
			'readonly' => true
		);
		
		$fields[$shortname.'-authors-bio-type'] = array(
			'name' => 'Bio Type',
			'id' => $shortname.'-authors-bio-type',
			'type' => 'text',
			'group' => $shortname.'-authors',
			'readonly' => true
		);
		
		$fields[$shortname.'-authors-byline-type'] = array(
			'name' => 'Byline Type',
			'id' => $shortname.'-authors-byline-type',
			'type' => 'text',
			'group' => $shortname.'-authors',
			'readonly' => true
		);
		
		$fields[$shortname.'-authors-page-type'] = array(
			'name' => 'Author Page Type',
			'id' => $shortname.'-authors-page-type',
			'type' => 'text',
			'group' => $shortname.'-authors',
			'readonly' => true
		);
		
		$fields[$shortname.'-authors-paid'] = array(
			'name' => 'Paid',
			'id' => $shortname.'-authors-paid',
			'type' => 'text',
			'group' => $shortname.'-authors',
			'readonly' => true
		);
		
		$fields[$shortname.'-authors-free'] = array(
			'name' => 'Free',
			'id' => $shortname.'-authors-free',
			'type' => 'text',
			'group' => $shortname.'-authors',
			'readonly' => true
		);
		
		$fields[$shortname.'-authors-revenue-share'] = array(
			'name' => 'Revenue Share',
			'id' => $shortname.'-authors-revenue-share',
			'type' => 'text',
			'group' => $shortname.'-authors',
			'readonly' => true
		);
		
		$fields[$shortname.'-authors-profiles-count'] = array(
			'name' => 'No. of Connected Profiles',
			'id' => $shortname.'-authors-profiles-count',
			'type' => 'text',
			'group' => $shortname.'-authors',
			'readonly' => true
		);
		
		$fields[$shortname.'-authors-score'] = array(
			'name' => 'Authors Score',
			'id' => $shortname.'-authors-score',
			'type' => 'text',
			'group' => $shortname.'-authors',
			'readonly' => true
		);
		/********	END OF AUTHORS	 **********/
		
		/**********		CONTENT 	***********/
		$fields[$shortname.'-content'] = array(
			'name' => 'Content',
			'id' => $shortname.'-content',
			'type' => 'heading',
			'category' => 'departments',
			'readonly' => true
		);
		
		$fields[$shortname.'-content-pillars'] = array(
			'name' => 'Pillars - Silos',
			'id' => $shortname.'-content-pillars',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-content-type-snippet-count'] = array(
			'name' => 'No. of Rich Snippet Types',
			'id' => $shortname.'-content-type-snippet-count',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-content-posts-snippet-count'] = array(
			'name' => 'No. of Rich Snippet Posts',
			'id' => $shortname.'-content-posts-snippet-count',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-content-score'] = array(
			'name' => 'Content Score',
			'id' => $shortname.'-content-score',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		/********	END OF CONTENT	 **********/
		
		/********	SYSTEMS	 **********/
		$fields[$shortname.'-systems'] = array(
			'name' => 'Systems',
			'id' => $shortname.'-systems',
			'type' => 'heading',
			'category' => 'departments',
			'readonly' => true
		);
		
		$fields[$shortname.'-systems-content'] = array(
			'name' => 'Content',
			'id' => $shortname.'-systems-content',
			'type' => 'text',
			'group' => $shortname.'-systems',
			'readonly' => true
		);
		
		$fields[$shortname.'-systems-marketing'] = array(
			'name' => 'Marketing',
			'id' => $shortname.'-systems-marketing',
			'type' => 'text',
			'group' => $shortname.'-systems',
			'readonly' => true
		);
		
		$fields[$shortname.'-systems-sales'] = array(
			'name' => 'Sales',
			'id' => $shortname.'-systems-sales',
			'type' => 'text',
			'group' => $shortname.'-systems',
			'readonly' => true
		);
		
		$fields[$shortname.'-systems-fulfillment'] = array(
			'name' => 'Fulfillment',
			'id' => $shortname.'-systems-fulfillment',
			'type' => 'text',
			'group' => $shortname.'-systems',
			'readonly' => true
		);
		
		$fields[$shortname.'-systems-management'] = array(
			'name' => 'Management (Staff)',
			'id' => $shortname.'-systems-management',
			'type' => 'text',
			'group' => $shortname.'-systems',
			'readonly' => true
		);
		
		$fields[$shortname.'-systems-score'] = array(
			'name' => 'Management Score',
			'id' => $shortname.'-systems-score',
			'type' => 'text',
			'group' => $shortname.'-systems',
			'readonly' => true
		);
		/********	END OF SYSTEMS	 **********/
		
		/********	VALUATION	 **********/
		$fields[$shortname.'-valuation'] = array(
			'name' => 'Valuation',
			'id' => $shortname.'-valuation',
			'type' => 'heading',
			'category' => 'departments',
			'readonly' => true
		);
		
		$fields[$shortname.'-valuation-ttm'] = array(
			'name' => 'TTM - Trailing Twelve Months',
			'id' => $shortname.'-valuation-ttm',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-valuation-income'] = array(
			'name' => 'Income',
			'id' => $shortname.'-valuation-income',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-valuation-expenses'] = array(
			'name' => 'Expenses',
			'id' => $shortname.'-valuation-expenses',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-valuation-last-value'] = array(
			'name' => 'Last Value',
			'id' => $shortname.'-valuation-last-value',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-valuation-multi-revenue'] = array(
			'name' => 'Multiplier - Revenue',
			'id' => $shortname.'-valuation-multi-revenue',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-valuation-multi-income'] = array(
			'name' => 'Multiplier - Income',
			'id' => $shortname.'-valuation-multi-income',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-valuation-replacement'] = array(
			'name' => 'Replacement',
			'id' => $shortname.'-valuation-replacement',
			'type' => 'subheading',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-valuation-replacement-content'] = array(
			'name' => 'Replacement - Content',
			'id' => $shortname.'-valuation-replacement-content',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-valuation-replacement-technology'] = array(
			'name' => 'Replacement - Technology',
			'id' => $shortname.'-valuation-replacement-technology',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-valuation-replacement-community'] = array(
			'name' => 'Replacement - Community',
			'id' => $shortname.'-valuation-replacement-community',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-valuation-score'] = array(
			'name' => 'Valuation Score',
			'id' => $shortname.'-valuation-score',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
	$fields[$shortname.'-metrics'] = array(
		'name' => 'Metrics',
		'id' => $shortname.'-metrics',
		'type' => 'separator'
	);
	
		/********	 LINKS	 **********/
		$fields[$shortname.'-links'] = array(
			'name' => 'Links',
			'id' => $shortname.'-links',
			'type' => 'heading',
			'category' => 'metrics',
			'readonly' => true
		);
		
		$fields[$shortname.'-google'] = array(
			'name' => 'Google Backlinks',
			'id' => $shortname.'-google',
			'type' => 'text',
			'group' => $shortname.'-links',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-alexa'] = array(
			'name' => 'Alexa Backlinks',
			'id' => $shortname.'-alexa',
			'type' => 'text',
			'group' => $shortname.'-links',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-yahoo'] = array(
			'name' => 'Yahoo Backlinks',
			'id' => $shortname.'-yahoo',
			'type' => 'text',
			'group' => $shortname.'-links',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-majestic'] = array(
			'name' => 'Majestic Backlinks',
			'id' => $shortname.'-majestic',
			'type' => 'text',
			'group' => $shortname.'-links',
			'programmatic' => true,
			'readonly' => true
		);
		/********	 END OF LINKS	 **********/
		
		/********	 SUBSCRIBERS	 **********/
		$fields[$shortname.'-subscribers'] = array(
			'name' => 'Subscribers',
			'id' => $shortname.'-subscribers',
			'type' => 'heading',
			'category' => 'metrics',
			'readonly' => true
		);
		
		$fields[$shortname.'-facebook'] = array(
			'name' => 'Facebook',
			'id' => $shortname.'-facebook',
			'type' => 'text',
			'group' => $shortname.'-subscribers',
			'programmatic' => true,
			'readonly' => true,
			'followers' => true,
			'format' => 'meta',
			'meta_value' => $shortname.'-facebook-followers'
		);
		
		$fields[$shortname.'-twitter'] = array(
			'name' => 'Twitter',
			'id' => $shortname.'-twitter',
			'type' => 'text',
			'group' => $shortname.'-subscribers',
			'programmatic' => true,
			'readonly' => true,
			'followers' => true,
			'format' => 'meta',
			'meta_value' => $shortname.'-twitter-followers'
		);
		
		$fields[$shortname.'-youtube'] = array(
			'name' => 'Youtube',
			'id' => $shortname.'-youtube',
			'type' => 'text',
			'group' => $shortname.'-subscribers',
			'programmatic' => true,
			'readonly' => true,
			'followers' => true,
			'format' => 'meta',
			'meta_value' => $shortname.'-youtube-followers'
		);
		
		$fields[$shortname.'-googleplus'] = array(
			'name' => 'Google Plus',
			'id' => $shortname.'-googleplus',
			'type' => 'text',
			'group' => $shortname.'-subscribers',
			'programmatic' => true,
			'readonly' => true,
			'followers' => true,
			'format' => 'meta',
			'meta_value' => $shortname.'-googleplus-followers'
		);
		
		$fields[$shortname.'-linkedin'] = array(
			'name' => 'LinkedIn',
			'id' => $shortname.'-linkedin',
			'type' => 'text',
			'group' => $shortname.'-subscribers',
			'programmatic' => true,
			'readonly' => true,
			'followers' => true,
			'format' => 'meta',
			'meta_value' => $shortname.'-linkedin-followers'
		);
		
		$fields[$shortname.'-pinterest'] = array(
			'name' => 'Pinterest',
			'id' => $shortname.'-pinterest',
			'type' => 'text',
			'group' => $shortname.'-subscribers',
			'programmatic' => true,
			'readonly' => true,
			'followers' => true,
			'format' => 'meta',
			'meta_value' => $shortname.'-pinterest-followers'
		);
		
		$fields[$shortname.'-rss'] = array(
			'name' => 'RSS',
			'id' => $shortname.'-rss',
			'type' => 'text',
			'group' => $shortname.'-subscribers',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-email'] = array(
			'name' => 'Email',
			'id' => $shortname.'-email',
			'type' => 'text',
			'group' => $shortname.'-subscribers',
			'readonly' => true
		);
		
		$fields[$shortname.'-websites'] = array(
			'name' => 'Websites',
			'id' => $shortname.'-websites',
			'type' => 'text',
			'group' => $shortname.'-subscribers',
			'readonly' => true
		);
		/********	 END OF SUBSCRIBERS	 **********/
		
		/********	 BUZZ	 **********/
		$fields[$shortname.'-buzz'] = array(
			'name' => 'Buzz',
			'id' => $shortname.'-buzz',
			'type' => 'heading',
			'category' => 'metrics',
			'readonly' => true
		);
		
		$fields[$shortname.'-buzz-recent-comments'] = array(
			'name' => 'Recent Comments',
			'id' => $shortname.'-buzz-recent-comments',
			'type' => 'text',
			'group' => $shortname.'-buzz',
			'readonly' => true
		);
		
		$fields[$shortname.'-buzz-recent-posts'] = array(
			'name' => 'Recent Posts',
			'id' => $shortname.'-buzz-recent-posts',
			'type' => 'text',
			'group' => $shortname.'-buzz',
			'readonly' => true
		);
		
		$fields[$shortname.'-buzz-recent-shares'] = array(
			'name' => 'Recent Shares',
			'id' => $shortname.'-buzz-recent-shares',
			'type' => 'text',
			'group' => $shortname.'-buzz',
			'readonly' => true
		);
		
		$fields[$shortname.'-buzz-klout'] = array(
			'name' => 'Klout?',
			'id' => $shortname.'-buzz-klout',
			'type' => 'text',
			'group' => $shortname.'-buzz',
			'readonly' => true
		);
		/********	 END OF BUZZ	 **********/
		
		/********	 SHARES	  **********/
		$fields[$shortname.'-shares'] = array(
			'name' => 'Shares',
			'id' => $shortname.'-shares',
			'type' => 'heading',
			'category' => 'metrics',
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-site-googleplus'] = array(
			'name' => 'Google+ Site Shares',
			'id' => $shortname.'-shares-site-googleplus',
			'type' => 'text',
			'group' => $shortname.'-shares',
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-site-facebook'] = array(
			'name' => 'Facebook Site Shares',
			'id' => $shortname.'-shares-site-facebook',
			'type' => 'text',
			'group' => $shortname.'-shares',
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-site-twitter'] = array(
			'name' => 'Twitter Site Shares',
			'id' => $shortname.'-shares-site-twitter',
			'type' => 'text',
			'group' => $shortname.'-shares',
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-site-linkedin'] = array(
			'name' => 'LinkedIn Site Shares',
			'id' => $shortname.'-shares-site-linkedin',
			'type' => 'text',
			'group' => $shortname.'-shares',
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-googleplus'] = array(
			'name' => 'Google+ Home Shares',
			'id' => $shortname.'-shares-googleplus',
			'type' => 'text',
			'group' => $shortname.'-shares',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-facebook'] = array(
			'name' => 'Facebook Home Shares',
			'id' => $shortname.'-shares-facebook',
			'type' => 'text',
			'group' => $shortname.'-shares',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-twitter'] = array(
			'name' => 'Twitter Home Shares',
			'id' => $shortname.'-shares-twitter',
			'type' => 'text',
			'group' => $shortname.'-shares',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-linkedin'] = array(
			'name' => 'LinkedIn Home Shares',
			'id' => $shortname.'-shares-linkedin',
			'type' => 'text',
			'group' => $shortname.'-shares',
			'programmatic' => true,
			'readonly' => true
		);
		/********	 END OF SHARES	  **********/
		
		/********	 SCORES	  **********/
		$fields[$shortname.'-scores'] = array(
			'name' => 'Scores',
			'id' => $shortname.'-scores',
			'type' => 'heading',
			'category' => 'metrics',
			'readonly' => true
		);
		
		$fields[$shortname.'-moz-rank'] = array(
			'name' => 'MOZ',
			'id' => $shortname.'-moz-rank',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-scores-site'] = array(
			'name' => 'Site',
			'id' => $shortname.'-scores-site',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-scores-team'] = array(
			'name' => 'Team',
			'id' => $shortname.'-scores-team',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-scores-project'] = array(
			'name' => 'Project',
			'id' => $shortname.'-scores-project',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'readonly' => true
		);
		
		$fields[$shortname.'-scores-links'] = array(
			'name' => 'Links',
			'id' => $shortname.'-scores-links',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-scores-buzz'] = array(
			'name' => 'Buzz',
			'id' => $shortname.'-scores-buzz',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-scores-shares'] = array(
			'name' => 'Shares',
			'id' => $shortname.'-scores-shares',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-scores-framework'] = array(
			'name' => 'Framework',
			'id' => $shortname.'-scores-framework',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-scores-subscribers'] = array(
			'name' => 'Subscribers',
			'id' => $shortname.'-scores-subscribers',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-scores-authors'] = array(
			'name' => 'Authors',
			'id' => $shortname.'-scores-authors',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-scores-content'] = array(
			'name' => 'Content',
			'id' => $shortname.'-scores-content',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-scores-systems'] = array(
			'name' => 'Systems',
			'id' => $shortname.'-scores-systems',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-scores-valuation'] = array(
			'name' => 'Valuation',
			'id' => $shortname.'-scores-valuation',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-scores-ranks'] = array(
			'name' => 'Ranks',
			'id' => $shortname.'-scores-ranks',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-scores-authority'] = array(
			'name' => 'Authority Scores',
			'id' => $shortname.'-scores-authority',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'readonly' => true
		);
		
		$fields[$shortname.'-authority-level'] = array(
			'name' => 'Authority Level',
			'id' => $shortname.'-authority-level',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'readonly' => true
		);
		/********	 END OF SCORES	  **********/
		
		/********	 RANKS	 **********/
		$fields[$shortname.'-ranks'] = array(
			'name' => 'Ranks',
			'id' => $shortname.'-ranks',
			'type' => 'heading',
			'category' => 'metrics',
			'readonly' => true
		);
		
		$fields[$shortname.'-one-rank'] = array(
			'name' => 'Authority 1Rank',
			'id' => $shortname.'-one-rank',
			'type' => 'text',
			'group' => $shortname.'-ranks',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-alexa-rank'] = array(
			'name' => 'Alexa Rank',
			'id' => $shortname.'-alexa-rank',
			'type' => 'text',
			'group' => $shortname.'-ranks',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-compete-rank'] = array(
			'name' => 'Compete Rank',
			'id' => $shortname.'-compete-rank',
			'type' => 'text',
			'group' => $shortname.'-ranks',
			'programmatic' => true,
			'readonly' => true
		);
		
		$fields[$shortname.'-authority-rank'] = array(
			'name' => 'Authority Rank',
			'id' => $shortname.'-authority-rank',
			'type' => 'text',
			'group' => $shortname.'-ranks',
			'readonly' => true
		);
		
		$fields[$shortname.'-tachnorati-rank'] = array(
			'name' => 'Technorati Rank',
			'id' => $shortname.'-tachnorati-rank',
			'type' => 'text',
			'group' => $shortname.'-ranks',
			'readonly' => true
		);
		/********	 END OF RANKS	 **********/
	
	$cfields = get_option('wpa_metrics');
	$fields = wp_parse_args( $cfields, $fields);
	
	return $fields;
}

function wpas_get_metrics_categories(){
	$metrics = wpa_default_metrics();
	
	$categories = array();
	foreach($metrics as $fields){
		if('separator' == $fields['type']){
			$categories[] = $fields;
		}
	}
	
	return $categories;
}

function wpa_get_metrics_groups(){
	$metrics = wpa_default_metrics();
	
	$groups = array();
	foreach($metrics as $fields){
		if('heading' == $fields['type']){
			$groups[$fields['id']] = $fields;
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
		if($field['group'] == $group_id){
			if($field['type'] != 'subheading'){
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

function wpa_add_url_scheme( $url, $scheme = 'http://' ){
    if (parse_url($url, PHP_URL_SCHEME) === null) {
        return $scheme . $url;
    }
    return $url;
}

function wpa_get_tld( $url ){
	$urlData = parse_url( $url );
	$domain = $urlData['host'];
	if($domain != "") {
		preg_match('/[^.]+$/', $domain, $matches);
		$tld = $matches[0];
	}
	return $tld;
}

function wpa_get_host( $url ){
	$urlData = parse_url( $url );
	return $urlData['host'];
}

function wpas_get_social_counts($social, $url, $page){
	switch($social){
		case 'Twitter':
			return wpas_get_tweets($url);
		case 'Youtube':
			return '';
		case 'Facebook':
			return wpas_get_likes($page);
		case 'LinkedIn':
			return '';
		case 'Pinterest':
			return wpas_get_pinterest($url);
		case 'FlickR':
			return '';
		case 'Google+':
			return wpas_get_plusones($url);
		case 'RSS':
			return '';
	}
}

function wpas_get_tweets($url){
	$json_string = file_get_contents('http://urls.api.twitter.com/1/urls/count.json?url=' . $url);
	$json = json_decode($json_string, true);
	
	return intval( isset($json['count']) ? $json['count'] : 0 );
}

function wpas_get_likes($page) {
	$json_string = file_get_contents('http://graph.facebook.com/?ids=' . $page);
	$json = json_decode($json_string, true);
	
	return intval( isset($json[$page]['likes']) ? $json[$page]['likes'] : 0 );
}

function wpas_get_plusones($url) {
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"'.rawurldecode($url).'","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	
	$curl_results = curl_exec ($curl);
	curl_close ($curl);
	
	$json = json_decode($curl_results, true);
	
	return isset($json[0]['result']['metadata']['globalCounts']['count']) ? intval( $json[0]['result']['metadata']['globalCounts']['count'] ) : 0;
}

function wpas_get_pinterest($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://api.pinterest.com/v1/urls/count.json?url=' . $url);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	
	$cont = curl_exec($ch);
	if(curl_error($ch)){ die(curl_error($ch)); }
	
	$json_string = preg_replace('/^receiveCount\((.*)\)$/', "\\1", $cont);
	$json = json_decode($json_string, true);
	
	return isset($json['count'])?intval($json['count']):0;
}