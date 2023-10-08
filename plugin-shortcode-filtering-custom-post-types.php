<?php

/*
 * Plugin Name:       Filtering Custom Posts - shortcode
 * Plugin URI:        https://github.com/kedmar20/custom-plugin-shortcode-wp-filtering
 * Description:       This is custom shortcode with filtering funcionality response to custom post types.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            kedmar20
 * Author URI:        https://github.com/kedmar20
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       custom-post-grid
 */

 // shortcode to take the data from database and display as a table
function filtering_posts_shortcode(){

ob_start();
	
$categories22 = get_categories(array('taxonomy'=>'category'));
print_r($categories22);	
?>
	<div style="color:red; font-weight:700">sdfsdfsd</div>
	<div style="color:green; font-weight:700"><?php echo $categories22; ?></div>

	<form method="GET">
			<select name="orderby" id="orderby">
<?php
		foreach ($categories22 as $categ22) : 
?>	
		<option value="<?php echo $categ22->slug; ?>" name="<?php echo $categ22->slug; ?>"  <?php echo selected($_GET['orderby'], $categ22->slug); ?>>
			<?php echo $categ22->slug; ?>
		</option>					

		<?php 
			$category_id = $categ22->cat_ID;
			endforeach; ?>							
			</select>
			<button type="submit">Suchen</button>
	</form>			

<?php  	

$uriSegments = explode("=", parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY));
$lastUriSegment = array_pop($uriSegments);
echo $lastUriSegment; //returns bar

print_r($category_id);
$query = new WP_Query(array('category_name'=>$lastUriSegment));

	if($query->have_posts()){
		
		while ($query->have_posts()) { 
			$query->the_post();
			?>
			<div class="wrapper">
				<div class="home-card">
					<h3 style="color:blue; font-weight:700"><?php echo get_the_title(); ?></h3>
					<div style="color:black; font-weight:400"><?php echo wp_trim_words(get_the_content(),40, '...'); ?></div>
					<a style="color:red; font-weight:500" href="<?php echo get_the_permalink(); ?>"><?php echo get_the_permalink(); ?></a>
				</div>
			</div>
		<?php }
	}
	wp_reset_postdata();
?>

<?php
	return  ob_get_clean();
}

add_shortcode('filtering_posts_shortcode','filtering_posts_shortcode');