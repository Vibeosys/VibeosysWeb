<?php

class TaxonomyMT
{	
	public static function wp_taxonomy_meta_tags_hooks()
	{
		$enabled_taxonomies = explode(',',get_option('wp_taxonomy_meta_tags_enabled'));
		foreach($enabled_taxonomies as $tax)
		{
			$tax = str_replace('[','',$tax);
			$tax = str_replace(']','',$tax);
			add_action($tax.'_add_form_fields','TaxonomyMT::taxonomy_add_custom_form_fields');
			add_action($tax.'_edit_form_fields','TaxonomyMT::taxonomy_edit_custom_form_fields');
			add_action('edited_'.$tax, 'TaxonomyMT::save_extra_taxonomy_fields');
			add_action('created_'.$tax, 'TaxonomyMT::save_extra_taxonomy_fields');
			add_action('admin_menu', 'TaxonomyMT::wp_taxonomy_meta_tags_create_menu');
			add_filter( 'wp_title', 'TaxonomyMT::do_wp_taxonomy_meta_tags_title', 10, 2);
			add_action ('wp_head','TaxonomyMT::wp_taxonomy_meta_tags_output');
		}
	}

	public static function taxonomy_add_custom_form_fields()
	{
	?>
		<div class="form-field">    
			<label for="wp_taxonomy_meta_tags[seo_meta_tag_title]"><?php _e('SEO Meta tag title', 'meta-tags'); ?></label>
			<input type="text" id="wp_taxonomy_meta_tags[seo_meta_tag_title]" name="wp_taxonomy_meta_tags[seo_meta_tag_title]" size="40" value="" />
			<p>This is the title meta of the taxonomy.</p>
		</div>
		<div class="form-field">    
			<label for="wp_taxonomy_meta_tags[seo_meta_tag_description]"><?php _e('SEO Meta tag description', 'meta-tags'); ?></label>
			<textarea cols="40" rows="5" id="wp_taxonomy_meta_tags[seo_meta_tag_description]" name="wp_taxonomy_meta_tags[seo_meta_tag_description]"></textarea>
			<p>This is the description meta of the taxonomy.</p>
		</div>
		<div class="form-field">    
			<label for="wp_taxonomy_meta_tags[seo_meta_tag_keywords]"><?php _e('SEO Meta tag keywords', 'meta-tags'); ?></label>
			<input type="text" id="wp_taxonomy_meta_tags[seo_meta_tag_keywords]" name="wp_taxonomy_meta_tags[seo_meta_tag_keywords]" size="40" value="" />
			<p>These are the keywords of the taxonomy, seperated by comma's.</p>
		</div>
		<div class="form-field" style="display:none;">    
			<label for="wp_taxonomy_meta_tags[seo_meta_tag_taxonomy]"><?php _e('Taxonomy', 'meta-tags'); ?></label>
			<input type="hidden" id="wp_taxonomy_meta_tags[seo_meta_tag_taxonomy]" name="wp_taxonomy_meta_tags[seo_meta_tag_taxonomy]" size="40" value="<?php echo $_GET['taxonomy'];?>" />
		</div>
        <div class="form-field">    
			<label for="wp_taxonomy_meta_tags[seo_meta_tag_featured_image]"><?php _e('Featured image', 'meta-tags'); ?></label>
			<input type="text" id="wp_taxonomy_meta_tags[seo_meta_tag_featured_image]" name="wp_taxonomy_meta_tags[seo_meta_tag_featured_image]" size="40" value="" />
            <p>URL to the featured image of the category.</p>
		</div>
		<div class="form-field">    
			<label for="wp_taxonomy_meta_tags[seo_meta_tag_robots]"><?php _e('SEO Meta tag robots', 'meta-tags'); ?></label>
			<select id="wp_taxonomy_meta_tags[seo_meta_tag_robots]" name="wp_taxonomy_meta_tags[seo_meta_tag_robots]">
				<option value="index, follow">Index, follow</option>
				<option value="index, nofollow">Index, no-follow</option>
				<option value="noindex, follow">No-index, follow</option>
				<option value="noindex, nofollow">No-index, no-follow</option>
			</select>
			<p>Search engine settings for the taxonomy.</p>
		</div>
	<?php 
	}
	
	public static function taxonomy_edit_custom_form_fields($term)
	{
		$tax_id = $term->term_id;
		$tax_meta = get_option( $_GET['taxonomy']."_$tax_id" );?>
		<tr class="form-field">
			<th valign="top" scope="row">
				<label for="wp_taxonomy_meta_tags[seo_meta_tag_title]"><?php _e('SEO Meta tag title', 'meta-tags'); ?></label>
			</th>
			<td>
				<input type="text" id="wp_taxonomy_meta_tags[seo_meta_tag_title]" name="wp_taxonomy_meta_tags[seo_meta_tag_title]" value="<?php if(esc_attr($tax_meta['seo_meta_tag_title']))
				{
					echo esc_attr($tax_meta['seo_meta_tag_title']);
				}
				else
				{
					echo '';
				}
				?>" />
				<p class="description">This is the title meta of the taxonomy.</p>
			</td>
		</tr>
		<tr class="form-field">
			<th valign="top" scope="row">
				<label for="wp_taxonomy_meta_tags[seo_meta_tag_description]"><?php _e('SEO Meta tag description', 'meta-tags'); ?></label>
			</th>
			<td>
				<textarea class="large-text" cols="40" rows="5" id="wp_taxonomy_meta_tags[seo_meta_tag_description]" name="wp_taxonomy_meta_tags[seo_meta_tag_description]"><?php if(esc_attr($tax_meta['seo_meta_tag_description']))
				{
					echo esc_attr($tax_meta['seo_meta_tag_description']);
				}
				else
				{
					echo '';
				}
				?></textarea>
				<p class="description"> is the description meta of the taxonomy.</p>
			</td>
		</tr>
		<tr class="form-field">
			<th valign="top" scope="row">
				<label for="wp_taxonomy_meta_tags[seo_meta_tag_keywords]"><?php _e('SEO Meta tag keywords', 'meta-tags'); ?></label>
			</th>
			<td>
				<input type="text" id="wp_taxonomy_meta_tags[seo_meta_tag_keywords]" name="wp_taxonomy_meta_tags[seo_meta_tag_keywords]" size="40" value="<?php if(esc_attr($tax_meta['seo_meta_tag_keywords']))
				{
					echo esc_attr($tax_meta['seo_meta_tag_keywords']);
				}
				else
				{
					echo '';
				}
				?>" />
				<p class="description">These are the keywords of the taxonomy, seperated by comma's.</p>
			</td>
		</tr>
        <tr class="form-field">
			<th valign="top" scope="row">
				<label for="wp_taxonomy_meta_tags[seo_meta_tag_featured_image]"><?php _e('Featured image', 'meta-tags'); ?></label>
			</th>
			<td>
				<input type="text" id="wp_taxonomy_meta_tags[seo_meta_tag_featured_image]" name="wp_taxonomy_meta_tags[seo_meta_tag_featured_image]" size="40" value="<?php if(esc_attr($tax_meta['seo_meta_tag_featured_image']))
				{
					echo esc_attr($tax_meta['seo_meta_tag_featured_image']);
				}
				else
				{
					echo '';
				}
				?>" />
				<p class="description">This is the URL to the featured image of the category.</p>
			</td>
		</tr>    
		<tr style="display:none;" class="form-field">
			<th valign="top" scope="row">
				<label for="wp_taxonomy_meta_tags[seo_meta_tag_taxonomy]"><?php _e('Taxonomy', 'meta-tags'); ?></label>
			</th>
			<td>
				<input type="hidden" id="wp_taxonomy_meta_tags[seo_meta_tag_taxonomy]" name="wp_taxonomy_meta_tags[seo_meta_tag_taxonomy]" size="40" value="<?php if(esc_attr($tax_meta['seo_meta_tag_taxonomy']))
				{
					echo esc_attr($tax_meta['seo_meta_tag_taxonomy']);
				}
				else
				{
					echo $_GET['taxonomy'];
				}
				?>" />
			</td>
		</tr>
		<tr class="form-field">
			<th valign="top" scope="row">
				<label for="wp_taxonomy_meta_tags[seo_meta_tag_robots]"><?php _e('SEO Meta tag robots', 'meta-tags'); ?></label>
			</th>
			<td>
				<select id="wp_taxonomy_meta_tags[seo_meta_tag_robots]" name="wp_taxonomy_meta_tags[seo_meta_tag_robots]">
				<?php
				if(esc_attr($tax_meta['seo_meta_tag_robots']) == 'index, follow')
				{
					?><option selected="selected" value="index, follow">Index, follow</option><?php
				}
				else
				{
					?><option value="index, follow">Index, follow</option><?php
				}
				?>
				<?php
				if(esc_attr($tax_meta['seo_meta_tag_robots']) == 'index, nofollow')
				{
					?><option selected="selected" value="index, nofollow">Index, no-follow</option><?php
				}
				else
				{
					?><option value="index, nofollow">Index, no-follow</option><?php
				}
				?>
				<?php
				if(esc_attr($tax_meta['seo_meta_tag_robots']) == 'noindex, follow')
				{
					?><option selected="selected" value="noindex, follow">No-index, follow</option><?php
				}
				else
				{
					?><option value="noindex, follow">No-index, follow</option><?php
				}
				?>
				<?php
				if(esc_attr($tax_meta['seo_meta_tag_robots']) == 'noindex, nofollow')
				{
					?><option selected="selected" value="noindex, nofollow">No-index, no-follow</option><?php
				}
				else
				{
					?><option value="noindex, nofollow">No-index, no-follow</option><?php
				}
				?>
				</select>
				<p class="description">Search engine settings for the taxonomy.</p>
			</td>
		</tr>
	<?php
	}
	
	public static function wp_taxonomy_meta_tags_create_menu()
	{
		add_options_page('WP Meta Tags Settings', 'WP Meta Tags Settings', 'administrator', __FILE__, 'TaxonomyMT::wp_taxonomy_meta_tags_settings_page',plugins_url('/images/icon.png', __FILE__));
	
		add_action( 'admin_init', 'TaxonomyMT::wp_taxonomy_meta_tags_settings' );
	}
	
	public static function wp_taxonomy_meta_tags_settings()
	{
		register_setting( 'wp_taxonomy_meta_tags-group', 'wp_taxonomy_meta_tags_enabled' );
	}
	
	public static function wp_taxonomy_meta_tags_settings_page()
	{
	?>
	<div class="wrap theme-options">
		<div class="icon32" id="icon-options-general"><br /></div>
		<h2>WP Meta Tags Settings</h2>
		<form method="post" class="tax-meta-settings-form" action="options.php">
			<?php settings_fields('wp_taxonomy_meta_tags-group');?>
			<div class="postbox metabox-holder">
				<h3 class="hndle"><?php _e('WP Taxonomy Meta Tags by Seo.uk.net','tax-meta');?></h3>
				<div class="inside">
					<div class="setting-panel">
				
  <p>
						
							<?php $wp_taxonomy_meta_tags_enabled = get_option('wp_taxonomy_meta_tags_enabled'); ?>
							<?php _e('Enabled for the following taxonomies:','tax-meta');?><br />
							<?php
							$args = array(
							  'public'   => true,
							  '_builtin' => false
							  
							); 
							$taxonomies = get_taxonomies($args);
							array_push($taxonomies,'category');
							array_push($taxonomies,'post_tag');
							$enabled_taxonomies = get_option('wp_taxonomy_meta_tags_enabled');
							$enabled_taxonomies = str_replace('[','',$enabled_taxonomies);
							$enabled_taxonomies = str_replace(']','',$enabled_taxonomies);
							$checked_taxonomies = explode(',',$enabled_taxonomies);	
							foreach($taxonomies as $tax)
							{
								$checked = '';
								if(in_array($tax,$checked_taxonomies))
								{
									$checked = 'checked="checked"';
								}
								?>
								<label>
								<input <?php echo $checked;?> class="wp_tax_meta_tags_enable" value="[<?php echo $tax;?>]" type="checkbox" />
								  <?php echo $tax;?></label><br />
								<?php
							}
							?>
							</select>
							
							<?php $wp_taxonomy_meta_tags_enabled = get_option('wp_taxonomy_meta_tags_enabled'); ?>
							<input type="hidden" id="wp_taxonomy_meta_tags_enabled" name="wp_taxonomy_meta_tags_enabled" value="<?php echo $wp_taxonomy_meta_tags_enabled;?>" />
							<script>
							jQuery('.wp_tax_meta_tags_enable').change(function()
							{
								if(jQuery('#wp_taxonomy_meta_tags_enabled').val().indexOf(jQuery(this).prop('value')) > -1)
								{
									var new_enabled = jQuery('#wp_taxonomy_meta_tags_enabled').prop('value');
									new_enabled = new_enabled.replace(jQuery(this).prop('value')+',','');
									new_enabled = new_enabled.replace(jQuery(this).prop('value'),'');
									jQuery('#wp_taxonomy_meta_tags_enabled').prop('value',new_enabled);
								}
								else if(jQuery('#wp_taxonomy_meta_tags_enabled').prop('value') == '')
								{
									jQuery('#wp_taxonomy_meta_tags_enabled').prop('value',jQuery(this).prop('value')+',');
								}
								else
								{
									jQuery('#wp_taxonomy_meta_tags_enabled').prop('value',jQuery('#wp_taxonomy_meta_tags_enabled').prop('value')+jQuery(this).prop('value')+',');
								}
							});
							</script>
						</p>
					</div>
			  </div>
			</div>
		 <p><strong>Visit your Post(s) or Page(s) to modify your meta tags.</strong></p>
			<input type="hidden" value="1" />
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save settings','tax-meta'); ?>" />
			</p>
		</form>
	</div>
	
	<?php
	}
	
	public static function save_extra_taxonomy_fields($term_id)
	{
		if(isset($_POST['wp_taxonomy_meta_tags']))
		{
			$tax_id = $term_id;
			$taxonomy = $_POST['wp_taxonomy_meta_tags']['seo_meta_tag_taxonomy'];
			$tax_meta = get_option( "$taxonomy_$tax_id");
			$tax_keys = array_keys($_POST['wp_taxonomy_meta_tags']);
			foreach($tax_keys as $info)
			{
				if(isset($_POST['wp_taxonomy_meta_tags'][$info]))
				{
					$tax_meta[$info] = $_POST['wp_taxonomy_meta_tags'][$info];
				}
			}
			update_option($_POST['wp_taxonomy_meta_tags']['seo_meta_tag_taxonomy']."_$tax_id", $tax_meta);
		}
	}
	
	public static function wp_taxonomy_meta_tags_output($term)
	{
		global $wp_query;
		
		if(is_category())
		{
			$current_id = get_cat_id(single_cat_title('',false));
			$tax_meta = get_option( "category_$current_id" );
			
			if(esc_attr($tax_meta['seo_meta_tag_featured_image']) != '')
			{
				echo '<meta property="og:image" content="'.esc_attr($tax_meta['seo_meta_tag_featured_image']).'"/>';
			}
			
			if(esc_attr($tax_meta['seo_meta_tag_description']) != '')
			{
				echo '<meta name="description" content="'.esc_attr($tax_meta['seo_meta_tag_description']).'" />'."\r\n";
			}
			if(esc_attr($tax_meta['seo_meta_tag_keywords']) != '')
			{
				echo '<meta name="keywords" content="'.esc_attr($tax_meta['seo_meta_tag_keywords']).'" />'."\r\n";
			}
			if(esc_attr($tax_meta['seo_meta_tag_robots']) != '')
			{
				echo '<meta name="robots" content="'.esc_attr($tax_meta['seo_meta_tag_robots']).'" />'."\r\n";
			}			
			
		}
		if(is_tag())
		{
			$current_id = get_query_var('tag_id');
			$tax_meta = get_option( "post_tag_$current_id" );
			
			
			if(esc_attr($tax_meta['seo_meta_tag_featured_image']) != '')
			{
				echo '<meta property="og:image" content="'.esc_attr($tax_meta['seo_meta_tag_featured_image']).'"/>';
			}
			if(esc_attr($tax_meta['seo_meta_tag_description']) != '')
			{
				echo '<meta name="description" content="'.esc_attr($tax_meta['seo_meta_tag_description']).'" />'."\r\n";
			}
			if(esc_attr($tax_meta['seo_meta_tag_keywords']) != '')
			{
				echo '<meta name="keywords" content="'.esc_attr($tax_meta['seo_meta_tag_keywords']).'" />'."\r\n";
			}
			if(esc_attr($tax_meta['seo_meta_tag_robots']) != '')
			{
				echo '<meta name="robots" content="'.esc_attr($tax_meta['seo_meta_tag_robots']).'" />'."\r\n";
			}
		}
		if(is_tax())
		{
			$term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			$tax_meta = get_option( $term->taxonomy."_".$term->term_id);
			
			if(esc_attr($tax_meta['seo_meta_tag_featured_image']) != '')
			{
				echo '<meta property="og:image" content="'.esc_attr($tax_meta['seo_meta_tag_featured_image']).'"/>';
			}
			if(esc_attr($tax_meta['seo_meta_tag_description']) != '')
			{
				echo '<meta name="description" content="'.esc_attr($tax_meta['seo_meta_tag_description']).'" />'."\r\n";
			}
			if(esc_attr($tax_meta['seo_meta_tag_keywords']) != '')
			{
				echo '<meta name="keywords" content="'.esc_attr($tax_meta['seo_meta_tag_keywords']).'" />'."\r\n";
			}
			if(esc_attr($tax_meta['seo_meta_tag_robots']) != '')
			{
				echo '<meta name="robots" content="'.esc_attr($tax_meta['seo_meta_tag_robots']).'" />'."\r\n";
			}
		}
	}
	
	public static function do_wp_taxonomy_meta_tags_title($title, $sep)
	{
		global $wp_query;
		if(!$sep)
		{
			$sep = '|';
		}
		$enabled_taxonomies = get_option('wp_taxonomy_meta_tags_enabled');
		$enabled_taxonomies = str_replace('[','',$enabled_taxonomies);
		$enabled_taxonomies = str_replace(']','',$enabled_taxonomies);
		$checked_taxonomies = explode(',',$enabled_taxonomies);	
	
		if(is_category())
		{
			if(in_array('category',$checked_taxonomies))
			{
				$current_id = get_cat_id(single_cat_title('',false));
				$tax_meta = get_option( "category_$current_id" );
				if(esc_attr($tax_meta['seo_meta_tag_title']) != '')
				{
					$title = esc_attr($tax_meta['seo_meta_tag_title']).' '.$sep.' ';
				}
			}
		}
		if(is_tag())
		{
			if(in_array('post_tag',$checked_taxonomies))
			{
				$current_id = get_query_var('tag_id');
				$tax_meta = get_option( "post_tag_$current_id" );
				
				if(esc_attr($tax_meta['seo_meta_tag_title']) != '')
				{
					$title = esc_attr($tax_meta['seo_meta_tag_title']).' '.$sep.' ';
				}
			}
		}
		if(is_tax())
		{
			$term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			if(in_array($term->taxonomy,$checked_taxonomies))
			{
				$tax_meta = get_option( $term->taxonomy."_".$term->term_id);
				
				if(esc_attr($tax_meta['seo_meta_tag_title']) != '')
				{
					$title = esc_attr($tax_meta['seo_meta_tag_title']).' '.$sep.' ';
				}
			}
		}
		return $title;
	}
}