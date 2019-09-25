<?php
/**
 * The template for displaying full width pages.
 *
 * Template Name: Custom Game
 *
 * @package storefront
 */

get_header(); ?>
<?php
$args = array( 'post_type' => 'game-reviews', 'posts_per_page' => 10 );
$loop = new WP_Query( $args );
//echo "<pre>";print_r($loop);exit;
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<table>
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
<div class="container">
  <h2>Data</h2>
<form action="" enctype="multipart/form-data" method="POST" id="ajax-form">  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Data Value</h4>
        </div>
        <div class="modal-body">
          	<input type="text" name="title" id="title" placeholder="Title" value=""><br><br>
			<textarea id="msg" name="message" placeholder="Message"></textarea><br>
          	<input id="file" name="file" type="file"><br>

        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default frm_submit" data-dismiss="modal" value="Submit">
          <input type="hidden" class="hidden">
        </div>
      </div>
      
    </div>
  </div>
  
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.edit_button').click(function(){
			var id = $('.edit_button').attr('id');
			$('.hidden').val(id);
			$.ajax({  
	            url: ajax_select.ajax_url,  
	            method:"POST", 
	            data: {
	            	action : 'load_data',	
		            dataType :	$(this).serialize()
		        }, 
	            success:function(data){  
					var obj = JSON.parse(data);
					$.each( obj, function( key, value ) {
						if(key == 'title'){
							$('#title').val(value);
						}else{
							$('#msg').val(value);
						}
					});
	            }  
	        });
		});
		$('#ajax-form').click(function(){
			var id = $('.hidden').val();
			var title = $('#title').val();
			var msg = $('#msg').val();
			var input_data = $(this).serialize(); 
			$.ajax({  
	            url: ajax_insert.ajax_url,  
	            method:"POST", 
	            data: {
		            action: 'insert_data',
		            pid:id,
		            title:title,
		            msg: msg
		        }, 
	            success:function(data){  
	            	if(data){
	            		location.reload();
	            	}
		        }
			});
		});
	});

</script>
<?php
get_footer();
