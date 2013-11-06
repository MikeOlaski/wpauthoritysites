<?php
/*
 * BB Builder Sidebar
 */

?><aside id="sidebar">
    <div id="custom_survey_taker" class="widget widget_custom_survey">
        <h3><?php _e('Survey Taker Details'); ?></h3>
        
        <div class="custom_widget_content">
            <form class="wpa_survey_form" name="survey_taker" action="" method="">
                <div class="field-group">
                    <label for="survey_fname"><?php _e('First Name', 'wpa'); ?></label>
                    <input type="text" name="wpa_survey[first_name]" id="survey_fname" class="regular-text" />
                </div>
                
                <div class="field-group">
                    <label for="survey_lname"><?php _e('Last Name', 'wpa'); ?></label>
                    <input type="text" name="wpa_survey[last_name]" id="survey_lname" class="regular-text" />
                </div>
                
                <div class="field-group">
                    <label for="survey_email"><?php _e('Email Address', 'wpa'); ?></label>
                    <input type="text" name="wpa_survey[email]" id="survey_email" class="regular-text" />
                </div>
                
                <div class="field-group">
					<label for="survey_role"><?php _e('Role', 'wpa'); ?></label>
                    <select name="wpa_survey[role]" id="survey_role" class="regular-select">
                        <option value="">Select a Role</option><?php
						get_dropdown_roles();
                    ?></select>
                </div>
                
                <div class="field-group">
                    <input type="submit" class="alignright" name="survey_taker_btn" value="Submit" />
                    <div class="clear"></div>
                </div>
            </form>
        </div>
    </div>
    
    <div id="custom_survey_depts" class="widget widget_custom_depts">
        <h3><?php _e('Department Templates'); ?></h3>
        
        <div class="custom_widget_content">
            <form name="" action="" method="post">
                <div class="field-group">
                    <select name="departments" id="wpa_departments" class="regular-select">
                        <option value="-1">Select a Department</option>
                    </select>
                    <div class="clear"></div>
                </div>
                
                <div class="field-group">
                    <ul id="bb_dept_templates" class="ui-sortable"><?php
						global $post;
						
						$excludes = array();
						$deptObj = wp_get_post_terms( $post->ID, 'site-department', array(
							'orderby' => 'name',
							'order' => 'ASC'
						));
						
						foreach($deptObj as $dep){
							$excludes[] = $dep->term_id;
						}
						
						$depts = get_terms( 'site-department', array(
							'orderby'       => 'count',
							'order'         => 'ASC',
							'hide_empty'    => false,
							'number'		=> 10,
							'exclude'		=> $excludes
						));
						
						foreach( $depts as $dept ){
							?><li class="ui-state-default">
                                <div>
                                    <span class="wpa_move_icon"></span>
                                    <span class="hand"><?php echo $dept->name;
										if($dept->description){
											?><i class="wpa_info_icon" title="<?php echo $dept->description; ?>"></i><?php
										}
                                    ?></span>
                                    
                                    <div class="alignleft wpa-column">
                                        <div class="value_scale ui-form-slider" id="<?php echo $dept->slug ?>-ui-slider"></div>
                                        <input name="departments[value][<?php echo $dept->slug ?>]" class="value_scale ui-text-field" type="text" id="<?php echo $dept->slug ?>-ui-id" value="0%">
                                    </div>
                                    
                                    <div class="alignleft wpa-column">
                                        <div class="work_scale ui-form-slider" id="<?php echo $dept->slug ?>-ui-slider"></div>
                                        <input name="departments[work][<?php echo $dept->slug ?>]" class="work_scale ui-text-field" type="text" id="<?php echo $dept->slug ?>-ui-id" value="0%">
                                    </div>
                                    
                                    <div class="alignleft wpa-column">
                                        <div class="influence_scale ui-form-slider" id="<?php echo $dept->slug ?>-ui-slider"></div><input name="departments[influence][<?php echo $dept->slug ?>]" class="influence_scale ui-text-field" type="text" id="<?php echo $dept->slug ?>-ui-id" value="0%">
                                    </div>
                                    
                                    <a class="ui-remove-button" href="">Remove Department</a>
                                    <div class="clear"></div>
                                </div>
                            </li><?php
						}
					?></ul>
                </div>
                
                <div class="field-group">
                    <input type="submit" name="survey_taker_btn" value="Submit" />
                </div>
            </form>
        </div>
    </div>
</aside>