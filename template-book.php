<?php
/**
 * The template for displaying full width pages.
 *
 * Template Name: Custom Book Page
 *
 * @package storefront
 */

get_header(); ?>
<?php
$args = array( 'post_type' => 'book-reviews', 'posts_per_page' => 10 );
$loop = new WP_Query( $args );
//echo "<pre>";print_r($loop);exit;
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<div class="container">
<table class="table table-bordered">
<img src="<?php echo get_template_directory_uri();?>/template-parts/LoaderIcon.gif" id="loaderIcon" style="display:none" />
	<thead>
		<tr>
			<td>Title</td>
			<td>Description</td>
			<td>Image</td>
			<td>Action</td>
		</tr>
	</thead>
<tbody>
<?php
while ( $loop->have_posts() ) {
	$loop->the_post();
	
	?>
	<tr>
		<td class="title"><?php echo the_title();?></td>
		<td class="desc"><?php echo the_content();?></td>
		<td class="image"><?php echo the_post_thumbnail();?></td>
		<td>
            <input type='button' class="edit_button" id="<?php echo the_ID(); ?>" data-toggle="modal" data-target="#myModal" value="edit">
            <input type='button' class="save_button" id="<?php echo the_ID(); ?>" value="save">
            <input type='button' class="delete_button" id="<?php echo the_ID(); ?>" value="delete">
        </td>
	</tr>
<?php
} 

?>
</tbody>
</table>
</div>

<?php
get_footer();
?>