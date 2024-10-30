<?php
/*
Plugin Name: Mindutopia User Thumbnails
Plugin URI: http://mindutopia.com
Description: This plugin gives you the ability to add user thumbnails to your wordpress users much like featured images on posts.
Author: Mindutopia
Version: 1.2
Author URI: http://mindutopia.com
License: GPL2
*/


/* 
	@Name: 		mindutopia_add_author_image
	@Purpose: 	add the field to the user edit screen
	@Params: 	$user [required] wp_user object
	@Returns: 	VOID ( html printed )
	@Hooked:	show_user_profile
	@Hooked:	edit_user_profile
*/

function mindutopia_add_author_image( $user ){
	wp_enqueue_media();
	$thumb_id = get_user_meta( $user->ID, '_user_thumbnail', 1 );
	
	?>
	<h2>Featured Image</h2>
	<table class="form-table">
		<tr>
			<th>User Thumbnail: </th>
			<td>
			<div id="user_thumb" class="user_thumb">
				<?php if( $thumb_id ){
					echo wp_get_attachment_image( $thumb_id, 'medium' );
				}   
				?>
			</div>
			<?php if( current_user_can('upload_files') ){ ?>
				<input type="hidden" name="_user_thumbnail" value="<?php echo $thumb_id; ?>"/>
				<a href="javascript:;" id="user-thumb-choose" data-holder="user_thumb" data-target="_user_thumbnail" class=" user-image-choose button-secondary">Choose</a>
				
				<?php  if( $thumb_id ){ ?>
					Remove? <input type="checkbox" name="remove_img_thumb" value="1"/>
				<?php } ?>
			<?php } ?>
			</td>
		</tr>
	</table>
	<style type="text/css">
		.user_thumb img{ width:150px; height: auto; }
	</style>
	
			<?php  if( current_user_can('upload_files') ){ ?>
	<script type="text/javascript">
		// Uploading files
	var file_frame;
	 
	  jQuery('.user-image-choose').live('click', function( event ){
		var target = jQuery(this).data('target');
		var holder = jQuery(this).data('holder');
	    event.preventDefault();
	 
	    // Create the media frame.
	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: "User Photo",
	      button: {
	        text: "Selected",
	      },
	      multiple: false  // Set to true to allow multiple files to be selected
	    });
	 
	    // When an image is selected, run a callback.
	    file_frame.on( 'select', function() {
	      // We set multiple to false so only get one image from the uploader
	      attachment = file_frame.state().get('selection').first().toJSON();
	      jQuery('input[name="' + target + '"]').val( attachment.id );
	      jQuery('#' + holder).html( '<img src="'+attachment.url+'" />' )
	    });
	 
	    // Finally, open the modal
	    file_frame.open();
	  });
	</script>
	<?php } 
}


/* 
	@Name: 		mindutopia_save_author_image
	@Purpose: 	save that user image
	@Params: 	$user_id  [required] int
	@Returns: 	void
	@Hooked:	personal_options_update
	@Hooked:	edit_user_profile_update
*/
function mindutopia_save_author_image( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	if(isset($_POST['_user_thumbnail'])){
		update_usermeta( $user_id, '_user_thumbnail', $_POST['_user_thumbnail'] );
	}
	if(isset($_POST['remove_img_thumb'] )){
		delete_usermeta( $user_id, '_user_thumbnail');
	}
}
/* 
	@Name: 		get_the_author_thumbnail
	@Purpose: 	get the user thumbnail image html.
	@Params: 	$user_id [required] int,
				$size string [optional] default thumbnail,
				$attr array [optional]
	@Returns: 	img html or false on not set.
*/
function get_the_author_thumbnail( $uid, $size = 'thumbnail', $attr = array() ){
	
	$thumb_id = get_user_meta( $uid, '_user_thumbnail', 1 );
	
	if( !$thumb_id ){
		return false;
	}
	else{
		return wp_get_attachment_image( $thumb_id, $size, null, $attr );
	}
}

/* 
	@Name: 		the_author_thumbnail
	@Purpose: 	get the user thumbnail image html.
	@Params: 	$user_id [required] int,
				$size string [optional] default thumbnail,
				$attr array [optional]
	@Returns: 	void ( html printed ) boolean (false) on fail
*/
function the_author_thumbnail( $uid, $size = 'thumbnail', $attr = array() ){
	
	if( ! has_author_thumbnail( $uid ) ){
		return false;
	}
	else{
		echo get_the_author_thumbnail( $uid, $size, $attr);
	}
}

/* 
	@Name: 		has_author_thumbnail
	@Purpose: 	whether or not the given user has a user thumbnail saved.
	@Params: 	$user_id [required] int,
	@Returns: 	img html or false on not set.
*/
function has_author_thumbnail( $user_id ){
	
	$thumb_id = get_user_meta( $uid, '_user_thumbnail', 1 );
	
	if( !$thumb_id ){
		return false;
	}
	else{
		return true;
	}
}

/* 
	@Name: 		mindutopia_replace_avatars
	@Purpose: 	filter in our author images over regular gravtars
	@Params: 	$img [required] str,
				$user_id [required] int,
				$size [required] int 
	@Returns: 	$img str
	@Hooked:	get_avatar
*/
function mindutopia_replace_avatars( $img, $_user, $size ){
	
	if( is_email( $_user ) ){
		$user = get_user_by( 'email', $_user );
		$user_id = $user->ID;
	}
	else{
		$user_id = $_user;
	}
	
	if( get_the_author_thumbnail( $user_id ) ){
		if( is_int($size) ){
			$size = array( $size, $size );
		}
		$img = get_the_author_thumbnail( $user_id, $size );
	}
	return $img;
}

add_filter( 'get_avatar', 'mindutopia_replace_avatars', 10, 3);

add_action( 'personal_options_update', 'mindutopia_save_author_image' );
add_action( 'edit_user_profile_update', 'mindutopia_save_author_image' );

add_action( 'show_user_profile', 'mindutopia_add_author_image' );
add_action( 'edit_user_profile', 'mindutopia_add_author_image' );

?>