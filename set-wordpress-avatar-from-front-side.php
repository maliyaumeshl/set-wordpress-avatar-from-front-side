<?php
//first install Wp User Avatar plugin and than use this code

$uploadedfile = $_FILES['Passport_Size_Image_Uplode'];
$upload_overrides = array( 'test_form' => false );
$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
if(isset($_FILES['Passport_Size_Image_Uplode']) && !empty($_FILES['Passport_Size_Image_Uplode']['name'])){
    if ( $movefile && !isset( $movefile['error'] ) ) {
        $file = $movefile['file'];
        $url = $movefile['url'];
        $type = $movefile['type'];
        $attachment = array(
            'post_mime_type' => $type ,
            'post_title' => $upload_name,
            'post_content' => 'Image for '.$upload_name,
            'post_status' => 'inherit'
        );
        $attach_id=wp_insert_attachment( $attachment, $file, 0);
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        wp_update_attachment_metadata( $attach_id, $attach_data );
    } else {
    echo $movefile['error'];
    }
}
delete_metadata('post', null, '_wp_attachment_wp_user_avatar', get_current_user_id(), true);
update_user_meta(get_current_user_id(), '_wp_attachment_wp_user_avatar', $attach_id);
update_user_meta(get_current_user_id(), $wpdb->get_blog_prefix($blog_id) . 'user_avatar', $attach_id);
?>
