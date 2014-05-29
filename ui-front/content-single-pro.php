<?php if (!defined('ABSPATH')) die('No direct access allowed!');
/**
* @package Jobs +
* @author Arnold Bailey
* @since version 1.0
* @license GPL2+
*/

global $post, $Jobs_Plus_Core, $wp_roles;

$add_pro = false;
$editing = false;
//Are we adding a Listing?
if ($post->ID == $Jobs_Plus_Core->add_pro_page_id) {
	$add_pro = true;
	$post = $Jobs_Plus_Core->get_default_custom_post('jbp_pro');
	setup_postdata($post);
	$link = add_query_arg('edit', 1, get_permalink($post->ID) );
	$editing = false;
}
elseif (get_query_var('edit')) { //Or are we editing a listing?
	$editing = current_user_can( EDIT_PRO, $post->ID);
	$link = get_permalink($post->ID);
}

wp_enqueue_script('jobs-plus');
wp_enqueue_script('jquery-ui-dialog');
wp_enqueue_style('jqueryui-editable');
wp_enqueue_script('jqueryui-editable');
wp_enqueue_script('jqueryui-editable-ext');

//var_dump( $editing );
//var_dump( current_user_can( EDIT_PRO, $post->ID) );
?>


<div class="pro-profile-wrapper group">

	<div class="group">
		<?php if(dynamic_sidebar('pro-widget') ) : else: endif; ?>
	</div>
	<?php echo do_action('jbp_error'); ?>
	<?php echo do_action('jbp_notice'); ?>

	<form action="" method="POST" id="custom-fields-form" >
		<?php wp_nonce_field('verify'); ?>
		<input type="hidden" name="post_id" value="<?php echo $post->ID; ?>" />
		<input type="hidden" name="data[ID]" value="<?php echo $post->ID; ?>" />
		<input type="hidden" name="jbp-pro-update" value="save" />


		<?php if(post_type_supports('jbp_pro','title') ): ?>
		<?php endif; ?>

		<div class="pro-content">
			<div class="pro-pad group">

				<div class="pro-content-wrapper pro-tagline show-on-edit">
					<h2 class="subheader1 pro-content-editable pro-title"><?php esc_html_e('Title: ', JBP_TEXT_DOMAIN); ?>
						<span class="editable editable-title"
							data-type="text"
							data-onblur="submit"
							data-name="post_title"
							data-savenochange = "true"
							data-emptytext="<?php esc_attr_e('No Title', JBP_TEXT_DOMAIN); ?>"
							data-value="<?php echo esc_attr( get_the_title() ); ?>"
							data-emptyclass="editable-required"
							data-original-title="<?php esc_attr_e('Enter the Title', JBP_TEXT_DOMAIN); ?>">
						</span>
					</h2>
				</div>

				<div class="pro-content-wrapper pro-profile">
					<p class="subheader1 pro-content-editable pro-tagline">
						<span class="editable pro-tagline"
							data-type="text"
							data-name="_ct_jbp_pro_Tagline"
							data-mode="popup"
							data-emptytext="<?php esc_attr_e('Your Tagline', JBP_TEXT_DOMAIN); ?>"
							data-original-title="<?php esc_attr_e('Tagline', JBP_TEXT_DOMAIN); ?>"
							data-value="<?php echo esc_attr(do_shortcode('[ct id="_ct_jbp_pro_Tagline"]') ); ?>"
							>
						</span>
					</p>
					<label class="pro-content-editable pro-name">
						<span class="editable editable-firstlast"
							data-type="firstlast"
							data-name="_ct_jbp_pro_First_Last"
							data-emptytext="<?php esc_attr_e('Your Name', JBP_TEXT_DOMAIN); ?>"
							data-value="<?php echo esc_attr(do_shortcode('[ct id="_ct_jbp_pro_First_Last"]') ); ?>"
							data-original-title="<?php echo esc_attr('Enter Your First and Last Name', JBP_TEXT_DOMAIN); ?>">
						</span>
						<?php printf(' is a member since %s', date("M Y", strtotime(get_the_author_meta('user_registered') ) ) ); ?>
					</label>
					<label for="company" class="pro-content-editable pro-company">
						<strong><?php esc_html_e('Company: ', JBP_TEXT_DOMAIN); ?></strong>
						<span class="editable"
							id="company"
							data-type="link"
							data-name="_ct_jbp_pro_Company_URL"
							data-emptytext="<?php esc_attr_e('Your Company', JBP_TEXT_DOMAIN); ?>"
							data-link-label="<?php esc_attr_e('Company:', JBP_TEXT_DOMAIN); ?>"
							data-link-placeholder="<?php esc_attr_e('Company Name', JBP_TEXT_DOMAIN); ?>"
							data-url-placeholder="<?php esc_attr_e('www.company.com', JBP_TEXT_DOMAIN); ?>"
							data-value="<?php echo esc_attr(do_shortcode('[ct id="_ct_jbp_pro_Company_URL"]') ); ?>"
							data-original-title="<?php esc_attr_e('Company and URL', JBP_TEXT_DOMAIN); ?>">
						</span>
					</label>
					<label class="pro-content-editable pro-location">
						<strong><?php esc_html_e('Location: ', JBP_TEXT_DOMAIN); ?></strong>
						<span class="editable"
							data-type="select"
							data-name="_ct_jbp_pro_Location"
							data-emptytext="<?php esc_attr_e('Your Location', JBP_TEXT_DOMAIN); ?>"
							data-value="<?php echo esc_attr(do_shortcode('[ct id="_ct_jbp_pro_Location"]') ); ?>"
							data-source="<?php echo esc_attr(JBP_PLUGIN_URL . 'data/countries.json');?>"
							data-original-title="<?php esc_attr_e('Enter Location from dropdown', JBP_TEXT_DOMAIN); ?>"
						><?php echo esc_html(do_shortcode('[ct id="_ct_jbp_pro_Location"]') ); ?></span>
					</label>
					<label class="pro-content-editable pro-contact-email">
						<strong><?php esc_html_e('Contact Email: ', JBP_TEXT_DOMAIN); ?></strong>
						<span class="editable"
							data-type="text"
							data-mode="popup"
							data-name="_ct_jbp_pro_Contact_Email"
							data-emptytext="<?php esc_attr_e('Your contact email', JBP_TEXT_DOMAIN); ?>"
							data-value="<?php echo esc_attr(do_shortcode('[ct id="_ct_jbp_pro_Contact_Email"]')); ?>"
							data-label="<?php esc_attr_e('Contact Email', JBP_TEXT_DOMAIN ); ?>"
							data-emptyclass="editable-required"
							data-original-title="<?php esc_attr_e('Contact email', JBP_TEXT_DOMAIN); ?>">
						</span>
					</label>
					<label class="pro-rate-me">
						<strong><?php esc_html_e('Rate me: ', JBP_TEXT_DOMAIN); ?></strong>
						<?php echo do_shortcode('[jbp-rate-this]'); ?>
					</label>
					<?php if(current_user_can(EDIT_PRO, $post->ID) ): ?>
					<span class="pro-edit"><button type="button" id="toggle-pro-edit" class="pro-button pro-edit-button hide-on-edit"><?php esc_html_e('Edit', JBP_TEXT_DOMAIN); ?></button></span>
					<?php endif; ?>
				</div>

				<?php if(post_type_supports('jbp_pro','editor') ): ?>
				<div class="pro-content-wrapper pro-biography">

					<h2 class="pro-content-editable pro-biography"><?php esc_html_e('Biography', JBP_TEXT_DOMAIN); ?></h2>
					<div class="editable"
						data-type="textarea"
						data-name="post_content"
						data-mode="popup"
						data-emptytext="<?php esc_attr_e('Tell us about yourself', JBP_TEXT_DOMAIN); ?>"
						data-original-title="<?php esc_attr_e('Biography Description', JBP_TEXT_DOMAIN); ?>"
					><?php echo $this->make_clickable(strip_tags(get_the_content() ) ); ?></div>
				</div>
				<?php endif; ?>

				<?php if(post_type_supports('jbp_pro','excerpt') ): ?>
				<div class="pro-content-wrapper pro-excerpt">
					<h2 class="pro-content-editable pro-excerpt "><?php esc_html_e('Excerpt', JBP_TEXT_DOMAIN); ?></h2>
					<div class="editable"
						data-type="textarea"
						data-name="post_excerpt"
						data-mode="popup"
						data-emptytext="<?php esc_attr_e('Tell us about yourself', JBP_TEXT_DOMAIN); ?>"
						data-original-title="<?php esc_attr_e('Short Excerpt', JBP_TEXT_DOMAIN); ?>"
					><?php echo $this->make_clickable(strip_tags(get_the_excerpt() ) ); ?></div>
				</div>
				<?php endif; ?>

				<div class="pro-content-wrapper pro-portfolio">
					<h2 class="pro-content-editable  pro-portfolio"><?php esc_html_e('Portfolio', JBP_TEXT_DOMAIN); ?></h2>
					<?php echo do_shortcode('[jbp-expert-portfolio]'); ?>
				</div>

				<?php if(post_type_supports('jbp_pro','custom-fields') ): ?>
				<div>
					<?php
					//Any custom fields not already handled
					echo do_shortcode(
					'[custom_fields_input style="editfield"]
					[ct_filter not="true"]
					_ct_jbp_pro_Tagline,
					_ct_jbp_pro_First_Last,
					_ct_jbp_pro_Company_URL,
					_ct_jbp_pro_Location,
					_ct_jbp_pro_Contact_Email,
					_ct_jbp_pro_Social,
					_ct_jbp_pro_Portfolio,
					_ct_jbp_pro_Skills,
					[/ct_filter]
					[/custom_fields_input]');
					?>
				</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="pro-left">
			<?php if (current_user_can('promote_user') && current_user_can(EDIT_PROS) ): ?>
			<div class="pros-certifed show-on-edit">
				<div id="jbp_certified_form">
					<input type="hidden" name="action" value="set_jbp_certified" />
					<input type="hidden" name="jbp_certified" value="0" />
					<input type="hidden" name="user_id" value="<?php echo $post->post_author ?>" />
					<label style="line-height: 1em;" ><input id="jbp_certified" type="checkbox" value="1" name="jbp_certified" <?php checked( $this->is_certified($post->post_author) ); ?> /> <?php esc_html_e('IS CERTIFIED?', JBP_TEXT_DOMAIN); ?>
						<br /><?php echo 'User ID: ' . $post->post_author; ?>
					</label>
				</div>
			</div>
			<?php endif; ?>

			<?php echo do_shortcode('[jbp-expert-gravatar]'); ?>
			<div class="hide-on-edit pro-contact">
				<?php echo do_shortcode('[jbp-expert-contact-btn class="pro-contact"]'); ?>
			</div>

			<?php if(current_user_can(EDIT_PROS) ): ?>
			<div class="show-on-edit">
				<?php if($Jobs_Plus_Core->get_setting('pro->moderation->publish') ): ?>
				<div class="pro-go-public">
					<button type="submit" id="pro-publish" name="data[post_status]" value="publish" class="toggle-pro-save pro-go-public-button" ><?php esc_html_e('Save', JBP_TEXT_DOMAIN); ?></button>
				</div>
				<?php endif; ?>

				<?php if( !$Jobs_Plus_Core->get_setting('pro->moderation->publish') ): ?>
				<div class="pro-go-public">
					<button type="submit" id="pro-pending" name="data[post_status]" value="pending" class="toggle-pro-save pro-go-public-button" ><?php esc_html_e('Review', JBP_TEXT_DOMAIN); ?></button>
				</div>
				<?php endif; ?>

				<?php if($Jobs_Plus_Core->get_setting('pro->moderation->draft') ): ?>
				<div class="pro-go-public">
					<button type="submit" id="pro-draft" name="data[post_status]" value="draft" class="toggle-pro-save pro-go-public-button" ><?php esc_html_e('Draft', JBP_TEXT_DOMAIN); ?></button>
				</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<div class="pro-content-wrapper">
				<h2 class="pro-content-editable pro-social"><?php esc_html_e('Social', JBP_TEXT_DOMAIN); ?></h2>
				<?php echo do_shortcode('[jbp-expert-social]'); ?>
			</div>
			<div class="pro-content-wrapper">
				<h2 class="pro-content-editable pro-skills"><?php esc_html_e('Skills', JBP_TEXT_DOMAIN); ?></h2>
				<?php echo do_shortcode('[jbp-expert-skills]'); ?>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	jQuery(document).ready( function($) {
		//Setup Globals
		jbpAddPro = <?php echo $add_pro ? 'true':'false'; ?>;
		jbpPopupEnabled = <?php echo ($editing || $add_pro) ? 'true':'false'; ?>;
		canEditPro = <?php echo current_user_can(EDIT_PRO, $post->ID ) ? 'true' : 'false'; ?>;


		jbpEditableDefaults();
		$.fn.editable.defaults.pk = '<?php the_ID(); ?>';
		$.fn.editable.defaults.url = '<?php echo admin_url('/admin-ajax.php'); ?>';
		$.fn.editable.defaults.params = {'action': 'jbp_pro', '_wpnonce': '<?php echo wp_create_nonce('jbp_pro');?>'};

		var $editables = $('.editable'); //Get a list of editable fields

		$('#jbp_certified').on('change', function( e ) {
			e.preventDefault();
			$.ajax( {
				url: '<?php echo admin_url('/admin-ajax.php'); ?>',
				type: 'post',
				data: $('#jbp_certified_form input').serialize()
			});
		});

		$editables.on('hidden', function(e, reason){
			if(reason === 'save' || reason === 'nochange' || reason === 'cancel') {
				var $next = $editables.eq( ($editables.index(this) + 1) % $editables.length );

				if( jbpAddPro && $(this).attr('data-name') == 'post_title') {
					if( reason === 'cancel') {
						window.history.go(-1);
						jbp_create_dialog(
						"<?php esc_html_e('Canceling Profile', JBP_TEXT_DOMAIN); ?>",
						"<?php esc_html_e('Canceling Profile,<br />Please Wait', JBP_TEXT_DOMAIN); ?>",
						{
							dialogClass: 'dialogcenter',
							height: 150,
							modal: true
						});
					} else {
						window.location = '<?php echo $link ?>';
						jbp_create_dialog(
						"<?php esc_html_e('Creating Profile', JBP_TEXT_DOMAIN); ?>",
						"<?php esc_html_e('Creating Your Profile, Please Wait', JBP_TEXT_DOMAIN); ?>",
						{
							dialogClass: 'dialogcenter',
							height: 150,
							modal: true
						});
					}
				} else {
					if( jbpAddPro ) {
						setTimeout(function() { $next.editable('show'); }, 300);
					}
				}
			}
		});

		//Toggle whether edit or popup
		$('#toggle-pro-edit').click( function(){ jbpPopup(); });

		$('#custom-fields-form').submit( function( e ){
			var result = jbp_required_dialog( e,
			"<?php esc_html_e('Required Fields', JBP_TEXT_DOMAIN); ?>",
			"<?php esc_html_e('<p>Please complete the required fields</p>', JBP_TEXT_DOMAIN); ?>"
			);
			return result;
		});

		jbpPopup();
		jbpFirstField($editables);

	});

</script>
