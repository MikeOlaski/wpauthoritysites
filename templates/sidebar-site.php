<?php
/**
 * The Sidebar containing the main widget area.
 */

?><div id="secondary" class="widget-area" role="complementary">
	<?php if ( ! dynamic_sidebar( 'sidebar-site' ) ) : ?>

        <aside id="site-reports" class="widget">
            <h3 class="widget-title">
				<?php _e( 'Sold at Public Auction', 'awp' ); ?>
            	<span class="bid-count"></span>
            </h3>
            
            <table class="form-table summary">
                <tr>
                    <th scope="row">Started:</th>
                    <td align="right">8 months ago</td>
                </tr>
                <tr>
                    <th scope="row">Completed:</th>
                    <td align="right">8 months ago</td>
                </tr>
            </table>
            
            <div class="info">
            	<p>This information is provided as a short-cut to help you with due diligence checks on the site listed.</p>
                <p>Checkout the Flippa blgo for helpful <a href="#">Website Due Diligence Tips.</a></p>
            </div>
            
            <div class="export-report">
            	<h4>Purchase a Due Diligence Report</h4>
                <p>Turpis et, nascetur urna nec placerat cras sociis nunc diam tristique platea nec et, a porttitor, pellentesque, sociis, integer pid mus? Cum massa augue porta sagittis ultricies, porta mattis tristique.</p>
                <a href="#" class="btn awp-report">Get Your Report</a>
            </div>
            
            <div class="info">
            	<p>The values in this reposrt are collected at listing time, so it's possible they may have changed slightly since then. Click on the associated links for the most up-to-date information.</p>
            </div>
        </aside>

    <?php endif; // end sidebar widget area ?>
</div><!-- #secondary .widget-area -->