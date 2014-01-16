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
		
		$fields[$shortname.'-name'] = array(
			'name' => 'Name',
			'id' => $shortname.'-name',
			'type' => 'text',
			'group' => $shortname.'-site',
			'readonly' => true
		);
		
		$fields[$shortname.'-domain'] = array(
			'name' => 'Domain',
			'id' => $shortname.'-domain',
			'type' => 'text',
			'group' => $shortname.'-site',
			'desc' => 'by Site Auditor',
			'readonly' => true
		);
		
		$fields[$shortname.'-date'] = array(
			'name' => 'Date Founded',
			'id' => $shortname.'-date',
			'type' => 'text',
			'group' => $shortname.'-site',
			'desc' => 'by Site Auditor',
			'readonly' => true
		);
		
		$fields[$shortname.'-thumbnail'] = array(
			'name' => 'Image URL',
			'id' => $shortname.'-thumbnail',
			'type' => 'upload',
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
			'readonly' => true
		);
		
		$fields[$shortname.'-location'] = array(
			'name' => 'Server Location',
			'id' => $shortname.'-location',
			'type' => 'text',
			'group' => $shortname.'-site',
			'desc' => 'by Site Auditor',
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
		
		$fields[$shortname.'-language'] = array(
			'name' => 'Language',
			'id' => $shortname.'-language',
			'type' => 'text',
			'group' => $shortname.'-site',
			'desc' => 'by Site Auditor',
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
		
		$fields[$shortname.'-site-runner'] = array(
			'name' => 'Site Runner',
			'id' => $shortname.'-site-runner',
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
		
		$fields[$shortname.'-framework-themes'] = array(
			'name' => 'Themes / Frameworks',
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
		
		$fields[$shortname.'-framework-scripts'] = array(
			'name' => 'Scripts',
			'id' => $shortname.'-framework-scripts',
			'type' => 'subheading',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-scripts-paid'] = array(
			'name' => 'Paid',
			'id' => $shortname.'-framework-scripts-paid',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-scripts-free'] = array(
			'name' => 'Free',
			'id' => $shortname.'-framework-scripts-free',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-scripts-custom'] = array(
			'name' => 'Custom',
			'id' => $shortname.'-framework-scripts-custom',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-services'] = array(
			'name' => 'Services',
			'id' => $shortname.'-framework-services',
			'type' => 'subheading',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-services-problem'] = array(
			'name' => 'Problem',
			'id' => $shortname.'-framework-services-problem',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-services-solution'] = array(
			'name' => 'Solution Pairs',
			'id' => $shortname.'-framework-services-solution',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-vendors'] = array(
			'name' => 'Vendors',
			'id' => $shortname.'-framework-vendors',
			'type' => 'subheading',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-vendors-problem'] = array(
			'name' => 'Problem',
			'id' => $shortname.'-framework-vendors-problem',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		
		$fields[$shortname.'-framework-vendors-solution'] = array(
			'name' => 'Solution Pairs',
			'id' => $shortname.'-framework-vendors-solution',
			'type' => 'text',
			'group' => $shortname.'-framework',
			'readonly' => true
		);
		/**********		END OF FRAMEWORK 	***********/
		
		/**********		CONTENT 	***********/
		$fields[$shortname.'-content'] = array(
			'name' => 'Content',
			'id' => $shortname.'-content',
			'type' => 'heading',
			'category' => 'departments',
			'readonly' => true
		);
		
		$fields[$shortname.'-topical-directory'] = array(
			'name' => 'Topical Directory Location',
			'id' => $shortname.'-topical-directory',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-onsite-seo'] = array(
			'name' => 'On Site SEO',
			'id' => $shortname.'-onsite-seo',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-visibility-gwt'] = array(
			'name' => 'Visibility GWT',
			'id' => $shortname.'-visibility-gwt',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-load-page-speed'] = array(
			'name' => 'Load Time / Page Speed',
			'id' => $shortname.'-load-page-speed',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-keywords-ranking'] = array(
			'name' => 'Keywords Ranking',
			'id' => $shortname.'-keywords-ranking',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-duplicate-content'] = array(
			'name' => 'Duplicate Content',
			'id' => $shortname.'-duplicate-content',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-post-count'] = array(
			'name' => 'Post Count',
			'id' => $shortname.'-post-count',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-word-count'] = array(
			'name' => 'Word Count',
			'id' => $shortname.'-word-count',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-micro-formats'] = array(
			'name' => 'Micro-Formats / Rich Snippets',
			'id' => $shortname.'-micro-formats',
			'type' => 'subheading',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-micro-formats-posts'] = array(
			'name' => 'Number of Posts',
			'id' => $shortname.'-micro-formats-posts',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-micro-formats-types'] = array(
			'name' => 'Number of Types',
			'id' => $shortname.'-micro-formats-types',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-onpage'] = array(
			'name' => 'On Page',
			'id' => $shortname.'-onpage',
			'type' => 'subheading',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-onpage-meta'] = array(
			'name' => 'Meta',
			'id' => $shortname.'-onpage-meta',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-onpage-title'] = array(
			'name' => 'Title',
			'id' => $shortname.'-onpage-title',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-onpage-description'] = array(
			'name' => 'Description',
			'id' => $shortname.'-onpage-description',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-user-content'] = array(
			'name' => 'User Content',
			'id' => $shortname.'-user-content',
			'type' => 'subheading',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-user-content-bios'] = array(
			'name' => 'Author Bios',
			'id' => $shortname.'-user-content-bios',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-user-content-bios'] = array(
			'name' => 'Author Bios',
			'id' => $shortname.'-user-content-bios',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-user-content-bylines'] = array(
			'name' => 'Author Bylines',
			'id' => $shortname.'-user-content-bylines',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		
		$fields[$shortname.'-user-content-page'] = array(
			'name' => 'Author Page',
			'id' => $shortname.'-user-content-page',
			'type' => 'text',
			'group' => $shortname.'-content',
			'readonly' => true
		);
		/********	END OF CONTENT	 **********/
		
		/********	PRODUCTS	 **********/
		$fields[$shortname.'-products'] = array(
			'name' => 'Products',
			'id' => $shortname.'-products',
			'type' => 'heading',
			'category' => 'departments',
			'readonly' => true
		);
		
		$fields[$shortname.'-brands'] = array(
			'name' => 'Brands',
			'id' => $shortname.'-brands',
			'type' => 'text',
			'group' => $shortname.'-products',
			'readonly' => true
		);
		
		$fields[$shortname.'-reports'] = array(
			'name' => 'Reports',
			'id' => $shortname.'-reports',
			'type' => 'text',
			'group' => $shortname.'-products',
			'readonly' => true
		);
		
		$fields[$shortname.'-books'] = array(
			'name' => 'Books',
			'id' => $shortname.'-books',
			'type' => 'text',
			'group' => $shortname.'-products',
			'readonly' => true
		);
		
		$fields[$shortname.'-shows'] = array(
			'name' => 'Shows',
			'id' => $shortname.'-shows',
			'type' => 'text',
			'group' => $shortname.'-products',
			'readonly' => true
		);
		
		$fields[$shortname.'-courses'] = array(
			'name' => 'Courses',
			'id' => $shortname.'-courses',
			'type' => 'text',
			'group' => $shortname.'-products',
			'readonly' => true
		);
		
		$fields[$shortname.'-events'] = array(
			'name' => 'Events',
			'id' => $shortname.'-events',
			'type' => 'text',
			'group' => $shortname.'-products',
			'readonly' => true
		);
		/********	END OF PRODUCTS 	**********/
		
		/********	SALES	 **********/
		$fields[$shortname.'-sales'] = array(
			'name' => 'Sales',
			'id' => $shortname.'-sales',
			'type' => 'heading',
			'category' => 'departments',
			'readonly' => true
		);
		
		$fields[$shortname.'-sales-revenue'] = array(
			'name' => 'Product Sales Revenue',
			'id' => $shortname.'-sales-revenue',
			'type' => 'text',
			'group' => $shortname.'-sales',
			'readonly' => true
		);
		
		$fields[$shortname.'-advertising-revenue'] = array(
			'name' => 'Advertising / Sponsor Revenue',
			'id' => $shortname.'-advertising-revenue',
			'type' => 'text',
			'group' => $shortname.'-sales',
			'readonly' => true
		);
		
		$fields[$shortname.'-affiliate-revenue'] = array(
			'name' => 'Affiliate Revenue',
			'id' => $shortname.'-affiliate-revenue',
			'type' => 'text',
			'group' => $shortname.'-sales',
			'readonly' => true
		);
		
		$fields[$shortname.'-other-revenue'] = array(
			'name' => 'Other Revenue',
			'id' => $shortname.'-other-revenue',
			'type' => 'text',
			'group' => $shortname.'-sales',
			'readonly' => true
		);
		
		$fields[$shortname.'-total-revenue'] = array(
			'name' => 'Total Revenue',
			'id' => $shortname.'-total-revenue',
			'type' => 'text',
			'group' => $shortname.'-sales',
			'readonly' => true
		);
		/********	END OF SALES	 **********/
		
		/********	SYSTEMS AND TOOLS	 **********/
		$fields[$shortname.'-systems-tools'] = array(
			'name' => 'Systems and Tools',
			'id' => $shortname.'-systems-tools',
			'type' => 'heading',
			'category' => 'departments',
			'readonly' => true
		);
		
		$fields[$shortname.'-email-marketing'] = array(
			'name' => 'Email Marketing',
			'id' => $shortname.'-email-marketing',
			'type' => 'text',
			'group' => $shortname.'-systems-tools',
			'readonly' => true
		);
		
		$fields[$shortname.'-generated-content'] = array(
			'name' => 'User Generated Content',
			'id' => $shortname.'-generated-content',
			'type' => 'text',
			'group' => $shortname.'-systems-tools',
			'readonly' => true
		);
		
		$fields[$shortname.'-joint-ventures'] = array(
			'name' => 'Advertising / Joint Ventures',
			'id' => $shortname.'-joint-ventures',
			'type' => 'text',
			'group' => $shortname.'-systems-tools',
			'readonly' => true
		);
		
		$fields[$shortname.'-system-management'] = array(
			'name' => 'Team / Staff / Vendors / Contractors',
			'id' => $shortname.'-system-management',
			'type' => 'text',
			'group' => $shortname.'-systems-tools',
			'readonly' => true
		);
		/********	END OF SYSTEMS AND TOOLS	 **********/
		
		/********	VALUATION	 **********/
		$fields[$shortname.'-valuation'] = array(
			'name' => 'Valuation',
			'id' => $shortname.'-valuation',
			'type' => 'heading',
			'category' => 'departments',
			'readonly' => true
		);
		
		$fields[$shortname.'-models'] = array(
			'name' => 'Models',
			'id' => $shortname.'-models',
			'type' => 'subheading',
			'group' => $shortname.'-valuation',
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
		
		$fields[$shortname.'-trailing-12-months'] = array(
			'name' => 'Trailing Twelve Months',
			'id' => $shortname.'-trailing-12-months',
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
		
		$fields[$shortname.'-net-income'] = array(
			'name' => 'Income',
			'id' => $shortname.'-net-income',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-revenue-sharing'] = array(
			'name' => 'Revenue Sharing',
			'id' => $shortname.'-revenue-sharing',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-equity-sharing'] = array(
			'name' => 'Equity Sharing',
			'id' => $shortname.'-equity-sharing',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-last-value'] = array(
			'name' => 'Last Value',
			'id' => $shortname.'-last-value',
			'type' => 'subheading',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-last-value-multiple'] = array(
			'name' => 'Multiple',
			'id' => $shortname.'-last-value-multiple',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-last-value-income'] = array(
			'name' => 'Income',
			'id' => $shortname.'-last-value-income',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-last-value-revenue'] = array(
			'name' => 'Revenue',
			'id' => $shortname.'-last-value-revenue',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-current-value'] = array(
			'name' => 'Current Value',
			'id' => $shortname.'-current-value',
			'type' => 'subheading',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-current-value-multiple'] = array(
			'name' => 'Multiple',
			'id' => $shortname.'-current-value-multiple',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-current-value-income'] = array(
			'name' => 'Income',
			'id' => $shortname.'-current-value-income',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-current-value-revenue'] = array(
			'name' => 'Revenue',
			'id' => $shortname.'-current-value-revenue',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-projected-value'] = array(
			'name' => 'Projected Value',
			'id' => $shortname.'-current-value',
			'type' => 'subheading',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-projected-value-multiple'] = array(
			'name' => 'Multiple',
			'id' => $shortname.'-projected-value-multiple',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-projected-value-income'] = array(
			'name' => 'Income',
			'id' => $shortname.'-projected-value-income',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		
		$fields[$shortname.'-projected-value-revenue'] = array(
			'name' => 'Revenue',
			'id' => $shortname.'-projected-value-revenue',
			'type' => 'text',
			'group' => $shortname.'-valuation',
			'readonly' => true
		);
		/********	END OF VALUATION	 **********/
	
	$fields[$shortname.'-metrics'] = array(
		'name' => 'Metrics',
		'id' => $shortname.'-metrics',
		'type' => 'separator'
	);
	
		/********	AUDIENCE	 **********/
		$fields[$shortname.'-audience'] = array(
			'name' => 'Audience',
			'id' => $shortname.'-audience',
			'type' => 'heading',
			'category' => 'metrics',
			'readonly' => true
		);
		
		$fields[$shortname.'-traffic'] = array(
			'name' => 'Traffic',
			'id' => $shortname.'-traffic',
			'type' => 'subheading',
			'group' => $shortname.'-audience',
			'readonly' => true
		);
		
		$fields[$shortname.'-traffic-daily-average'] = array(
			'name' => 'Daily Average',
			'id' => $shortname.'-traffic-daily-average',
			'type' => 'text',
			'group' => $shortname.'-audience',
			'readonly' => true
		);
		
		$fields[$shortname.'-traffic-daily-max'] = array(
			'name' => 'Daily Max',
			'id' => $shortname.'-traffic-daily-max',
			'type' => 'text',
			'group' => $shortname.'-audience',
			'readonly' => true
		);
		
		$fields[$shortname.'-traffic-monthly-average'] = array(
			'name' => 'Monthly Average',
			'id' => $shortname.'-traffic-monthly-average',
			'type' => 'text',
			'group' => $shortname.'-audience',
			'readonly' => true
		);
		
		$fields[$shortname.'-traffic-monthly-max'] = array(
			'name' => 'Monthly Max',
			'id' => $shortname.'-traffic-monthly-max',
			'type' => 'text',
			'group' => $shortname.'-audience',
			'readonly' => true
		);
		
		$fields[$shortname.'-demographics'] = array(
			'name' => 'Demographics',
			'id' => $shortname.'-demographics',
			'type' => 'subheading',
			'group' => $shortname.'-audience',
			'readonly' => true
		);
		
		$fields[$shortname.'-demographics-gender'] = array(
			'name' => 'Male / Female',
			'id' => $shortname.'-demographics-gender',
			'type' => 'text',
			'group' => $shortname.'-audience',
			'readonly' => true
		);
		
		$fields[$shortname.'-demographics-age'] = array(
			'name' => 'Age',
			'id' => $shortname.'-demographics-age',
			'type' => 'text',
			'group' => $shortname.'-audience',
			'readonly' => true
		);
		
		$fields[$shortname.'-demographics-education'] = array(
			'name' => 'Education',
			'id' => $shortname.'-demographics-education',
			'type' => 'text',
			'group' => $shortname.'-audience',
			'readonly' => true
		);
		
		$fields[$shortname.'-demographics-income'] = array(
			'name' => 'Income',
			'id' => $shortname.'-demographics-income',
			'type' => 'text',
			'group' => $shortname.'-audience',
			'readonly' => true
		);
		
		$fields[$shortname.'-demographics-location'] = array(
			'name' => 'Location',
			'id' => $shortname.'-demographics-location',
			'type' => 'text',
			'group' => $shortname.'-audience',
			'readonly' => true
		);
		/********	 END OF AUDIENCE	 **********/
		
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
			'readonly' => true
		);
		
		$fields[$shortname.'-alexa'] = array(
			'name' => 'Alexa Backlinks',
			'id' => $shortname.'-alexa',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-yahoo'] = array(
			'name' => 'Yahoo Backlinks',
			'id' => $shortname.'-yahoo',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-majestic'] = array(
			'name' => 'Majestic Backlinks',
			'id' => $shortname.'-majestic',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-links-average'] = array(
			'name' => 'Average',
			'id' => $shortname.'-links-average',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-external-links'] = array(
			'name' => 'External Link',
			'id' => $shortname.'-external-links',
			'type' => 'subheading',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-external-referalls'] = array(
			'name' => 'Referalls',
			'id' => $shortname.'-external-referalls',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-external-listings'] = array(
			'name' => 'Listings',
			'id' => $shortname.'-external-listings',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-external-nofollow'] = array(
			'name' => 'No-Follow',
			'id' => $shortname.'-external-nofollow',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-external-dofollow'] = array(
			'name' => 'Do-Follow',
			'id' => $shortname.'-external-dofollow',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-external-in-shares'] = array(
			'name' => 'In-Shares',
			'id' => $shortname.'-external-in-shares',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-external-TextImage'] = array(
			'name' => 'Text, Image',
			'id' => $shortname.'-external-TextImage',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-external-broken'] = array(
			'name' => 'Broken',
			'id' => $shortname.'-external-broken',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-internal-links'] = array(
			'name' => 'Internal Link',
			'id' => $shortname.'-internal-links',
			'type' => 'subheading',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-internal-levels'] = array(
			'name' => 'Levels',
			'id' => $shortname.'-internal-levels',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-internal-404'] = array(
			'name' => '404',
			'id' => $shortname.'-internal-404',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		
		$fields[$shortname.'-internal-broken'] = array(
			'name' => 'Broken',
			'id' => $shortname.'-internal-broken',
			'type' => 'text',
			'group' => $shortname.'-links',
			'readonly' => true
		);
		/********	 END OF LINKS	 **********/
		
		/********	 COMMUNITY	 **********/
		$fields[$shortname.'-community'] = array(
			'name' => 'Community',
			'id' => $shortname.'-community',
			'type' => 'heading',
			'category' => 'metrics',
			'readonly' => true
		);
		
		$fields[$shortname.'-marketing-department'] = array(
			'name' => 'Marketing Department',
			'id' => $shortname.'-marketing-department',
			'type' => 'text',
			'group' => $shortname.'-community',
			'readonly' => true
		);
		
		$fields[$shortname.'-network-subscribers'] = array(
			'name' => 'Network Subscribers',
			'id' => $shortname.'-network-subscribers',
			'type' => 'subheading',
			'group' => $shortname.'-community',
			'readonly' => true
		);
		
		$fields[$shortname.'-network-websites'] = array(
			'name' => 'Websites',
			'id' => $shortname.'-network-websites',
			'type' => 'text',
			'group' => $shortname.'-community',
			'readonly' => true
		);
		
		$fields[$shortname.'-email'] = array(
			'name' => 'Email',
			'id' => $shortname.'-email',
			'type' => 'text',
			'group' => $shortname.'-community',
			'readonly' => true
		);
		
		$fields[$shortname.'-rss'] = array(
			'name' => 'RSS',
			'id' => $shortname.'-rss',
			'type' => 'text',
			'group' => $shortname.'-community',
			'readonly' => true
		);
		
		$fields[$shortname.'-facebook'] = array(
			'name' => 'Facebook',
			'id' => $shortname.'-facebook',
			'type' => 'text',
			'group' => $shortname.'-community',
			'readonly' => true,
			'followers' => true
		);
		
		$fields[$shortname.'-googleplus'] = array(
			'name' => 'Google Plus',
			'id' => $shortname.'-googleplus',
			'type' => 'text',
			'group' => $shortname.'-community',
			'readonly' => true,
			'followers' => true
		);
		
		$fields[$shortname.'-twitter'] = array(
			'name' => 'Twitter',
			'id' => $shortname.'-twitter',
			'type' => 'text',
			'group' => $shortname.'-community',
			'readonly' => true,
			'followers' => true
		);
		
		$fields[$shortname.'-pinterest'] = array(
			'name' => 'Pinterest',
			'id' => $shortname.'-pinterest',
			'type' => 'text',
			'group' => $shortname.'-community',
			'readonly' => true,
			'followers' => true
		);
		
		$fields[$shortname.'-linkedin'] = array(
			'name' => 'LinkedIn',
			'id' => $shortname.'-linkedin',
			'type' => 'text',
			'group' => $shortname.'-community',
			'readonly' => true,
			'followers' => true
		);
		
		$fields[$shortname.'-reach-subcribers'] = array(
			'name' => 'Reach - Subscribers of Subscribers',
			'id' => $shortname.'-reach-subcribers',
			'type' => 'subheading',
			'group' => $shortname.'-community',
			'readonly' => true
		);
		
		$fields[$shortname.'-klout'] = array(
			'name' => 'Klout',
			'id' => $shortname.'-klout',
			'type' => 'text',
			'group' => $shortname.'-community',
			'readonly' => true
		);
		
		$fields[$shortname.'-kred'] = array(
			'name' => 'Kred',
			'id' => $shortname.'-kred',
			'type' => 'text',
			'group' => $shortname.'-community',
			'readonly' => true
		);
		
		$fields[$shortname.'-empire'] = array(
			'name' => 'Empire',
			'id' => $shortname.'-empire',
			'type' => 'text',
			'group' => $shortname.'-community',
			'readonly' => true
		);
		
		$fields[$shortname.'-buzz-mentions'] = array(
			'name' => 'Buzz - Brand Mentions',
			'id' => $shortname.'-buzz-mentions',
			'type' => 'subheading',
			'group' => $shortname.'-community',
			'readonly' => true
		);
		
		$fields[$shortname.'-buzz-now'] = array(
			'name' => 'Now',
			'id' => $shortname.'-buzz-now',
			'type' => 'text',
			'group' => $shortname.'-community',
			'readonly' => true
		);
		
		$fields[$shortname.'-buzz-today'] = array(
			'name' => 'Today',
			'id' => $shortname.'-buzz-today',
			'type' => 'text',
			'group' => $shortname.'-community',
			'readonly' => true
		);
		
		$fields[$shortname.'-buzz-week'] = array(
			'name' => 'This Week',
			'id' => $shortname.'-buzz-week',
			'type' => 'text',
			'group' => $shortname.'-community',
			'readonly' => true
		);
		
		$fields[$shortname.'-buzz-month'] = array(
			'name' => 'This Month',
			'id' => $shortname.'-buzz-month',
			'type' => 'text',
			'group' => $shortname.'-community',
			'readonly' => true
		);
		
		$fields[$shortname.'-buzz-year'] = array(
			'name' => 'This Year',
			'id' => $shortname.'-buzz-year',
			'type' => 'text',
			'group' => $shortname.'-community',
			'readonly' => true
		);
		/********	 END OF COMMUNITY	 **********/
		
		/********	 ENGAGEMENT 	**********/
		$fields[$shortname.'-engagement'] = array(
			'name' => 'Engagement',
			'id' => $shortname.'-engagement',
			'type' => 'heading',
			'category' => 'metrics',
			'readonly' => true
		);
		
		$fields[$shortname.'-bounce-rate'] = array(
			'name' => 'Bounce Rate',
			'id' => $shortname.'-bounce-rate',
			'type' => 'text',
			'group' => $shortname.'-engagement',
			'readonly' => true
		);
		
		$fields[$shortname.'-time-on-site'] = array(
			'name' => 'Time on Site',
			'id' => $shortname.'-time-on-site',
			'type' => 'text',
			'group' => $shortname.'-engagement',
			'readonly' => true
		);
		
		$fields[$shortname.'-pages-visited'] = array(
			'name' => 'Pages Visited',
			'id' => $shortname.'-pages-visited',
			'type' => 'text',
			'group' => $shortname.'-engagement',
			'readonly' => true
		);
		
		$fields[$shortname.'-comments'] = array(
			'name' => 'Comments - User Posts',
			'id' => $shortname.'-comments',
			'type' => 'text',
			'group' => $shortname.'-engagement',
			'readonly' => true
		);
		/********	 END OF ENGAGEMENT 	**********/
	
		/********	 SOCIAL/SHARES	  **********/
		$fields[$shortname.'-social'] = array(
			'name' => 'Social / Shares',
			'id' => $shortname.'-social',
			'type' => 'heading',
			'category' => 'metrics',
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-googleplus'] = array(
			'name' => 'Google Plus',
			'id' => $shortname.'-shares-googleplus',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-facebook'] = array(
			'name' => 'Facebook Shares',
			'id' => $shortname.'-shares-facebook',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-likes-facebook'] = array(
			'name' => 'Facebook Likes',
			'id' => $shortname.'-likes-facebook',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-twitter'] = array(
			'name' => 'Twitter',
			'id' => $shortname.'-shares-twitter',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-pinterest'] = array(
			'name' => 'Pinterest',
			'id' => $shortname.'-shares-pinterest',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-shares-linkedin'] = array(
			'name' => 'LinkedIn',
			'id' => $shortname.'-shares-linkedin',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-social-site'] = array(
			'name' => 'Site',
			'id' => $shortname.'-social-site',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		
		$fields[$shortname.'-page-total'] = array(
			'name' => 'Page Total',
			'id' => $shortname.'-page-total',
			'type' => 'text',
			'group' => $shortname.'-social',
			'readonly' => true
		);
		/********	 END OF SOCIAL/SHARES	  **********/
		
		/********	 SCORES	  **********/
		$fields[$shortname.'-scores'] = array(
			'name' => 'Scores',
			'id' => $shortname.'-scores',
			'type' => 'heading',
			'category' => 'metrics',
			'readonly' => true
		);
		
		$fields[$shortname.'-points-summary'] = array(
			'name' => 'Summary of Points Total',
			'id' => $shortname.'-points-summary',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'readonly' => true
		);
		
		$fields[$shortname.'-each-department'] = array(
			'name' => 'Each Department',
			'id' => $shortname.'-each-department',
			'type' => 'text',
			'group' => $shortname.'-scores',
			'readonly' => true
		);
		/********	 END OF SCORES	  **********/
		
		/********	 TRUST	  **********/
		$fields[$shortname.'-trust'] = array(
			'name' => 'Trust',
			'id' => $shortname.'-trust',
			'type' => 'heading',
			'category' => 'metrics',
			'readonly' => true
		);
		
		$fields[$shortname.'-moz-stats'] = array(
			'name' => 'MOZ Stats',
			'id' => $shortname.'-moz-stats',
			'type' => 'text',
			'group' => $shortname.'-trust',
			'readonly' => true
		);
		
		$fields[$shortname.'-ows-stats'] = array(
			'name' => 'Onewebsite Stats',
			'id' => $shortname.'-ows-stats',
			'type' => 'text',
			'group' => $shortname.'-trust',
			'readonly' => true
		);
		/********	 END OF TRUST	  **********/
	
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