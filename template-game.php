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
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array(
    'post_type' => 'game-reviews',
    'orderby' => 'title',
    'order' => 'ASC',
    'posts_per_page' => 20,
    'paged' => $paged
);

$the_query = new WP_Query($args);
//echo "<pre>";print_r($loop);exit;
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="container">
<div class="row">
	<input type='button' class="add_button" data-toggle="modal" data-target="#myAddModal" value="Add">
<table class="table">
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
</div>
<div class="container">
  <h2>Data</h2>
<form method="post" id="ajax_form" name="ajax_form" enctype="multipart/form-data">  
	<input type="hidden" name="action" id="action" value="update_data">
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
          	<input id="g_file" name="game_file" type="file"><br>
          	<div class="game_image"><img src="" alt="image"></div>

        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default frm_submit" data-dismiss="modal" value="Submit">
          <input type="hidden" class="hidden" name="hidden_game" id="hidden_game_id">
        </div>
      </div>
      
    </div>
  </div>
  </form>
<form method="post" id="ajax_add_form" name="ajax_add_form" enctype="multipart/form-data">  
	
  <div class="modal fade" id="myAddModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Data Value</h4>
        </div>
        <div class="modal-body">
          	<input type="text" name="title" id="custom_title" placeholder="Title" value=""><br><br>
			<textarea id="custom_msg" name="message" placeholder="Message"></textarea><br>
          	<input id="game_file" name="games_file" type="file"><br>
          	

        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default form_submit" data-dismiss="modal" value="Submit">
        </div>
      </div>
    </div>
  </div>
  </form>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.frm_submit').click(function(){
			var id = $("#hidden_game_id").val();
			var fd = new FormData();
			var title = $('#title').val();
			var msg = $('#msg').val();
		    var file = jQuery(document).find('#g_file');
		    var caption = jQuery(document).find('input[name=game_file]');
		    var individual_file = file[0].files[0];
		    fd.append("file", individual_file);
		    var individual_capt = caption.val();
		    fd.append("id", id);  
		    fd.append("title", title);  
		    fd.append("msg", msg);  
		    fd.append("caption", individual_capt);  
		    fd.append('action', 'update_data'); 
			jQuery.ajax({
		        type: 'POST',
		        url: ajax_update.ajax_url,
		        data: fd,
		        contentType: false,
		        processData: false,
		        success: function(response){
		        	if(response){
		        		//location.reload();	
		        	}
		        }
		    });
		});
		$('.edit_button').click(function(){
			var id = $(this).attr('id');
			$('.hidden').val(id);
			$.ajax({  
	            url: ajax_select.ajax_url,
	            method:"POST", 
	            data: {
	            	pid: id,
	            	action : 'load_data'
		        }, 
	            success:function(data){  
					var obj = JSON.parse(data);
					$.each( obj, function( key, value ) {
						if(key == 'title'){
							$('#title').val(value);
						}if(key == 'content'){
							$('#msg').val(value);
						}else{
							$('.game_image img').attr('src', value);
						}
					});
	            }  
	        });
		});
		
		$('.form_submit').click(function(){
			var fd = new FormData();
			var title = $('#custom_title').val();
			var msg = $('#custom_msg').val();
		    var file = jQuery(document).find('#game_file');
		    console.log(file);
		    var caption = jQuery(document).find('input[name=games_file]');
		    var individual_file = file[0].files[0];
		    fd.append("file", individual_file);
		    var individual_capt = caption.val();
		    fd.append("title", title);  
		    fd.append("msg", msg);  
		    fd.append("caption", individual_capt);  
		    fd.append('action', 'update_data'); 
			jQuery.ajax({
		        type: 'POST',
		        url: ajax_update.ajax_url,
		        data: fd,
		        contentType: false,
		        processData: false,
		        success: function(response){
		        	if(response){
		        		//location.reload();	
		        	}
		        }
		    });
		});
	});

</script>
<?php
get_footer();

