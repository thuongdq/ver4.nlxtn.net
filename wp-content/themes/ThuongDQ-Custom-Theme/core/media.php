<?php
//full medium thumbnail 
add_theme_support( 'post-thumbnails' );
add_image_size('small',68,60, true);
add_image_size('smaller',48,37, true);

//get path thumbnail by post id
function media_get_path_image_from_post_id($post_id, $size ="thumbnail", $icon = ""){
  $post_thumbnail_url = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), $size,  $icon);
  return $post_thumbnail_url[0];
}

// get path thumbnail first in content post
function media_get_path_image_first_content_post($post_content = '', $size='thumbnail'){
  global $post, $posts;
  $content = $post->post_content;
  if($post_content != ''){
    $content = $post_content;
  }
  $first_img = '';
  ob_start();
  ob_end_clean();
  preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches );
  if ( isset( $matches[1][0] ) && $matches[1][0] ) {      // any image there?
    $postimage = $matches[1][0]; // we need the first one only!
  }
  if ( $postimage ) {
    $postimage_id = custom_get_attachment_id_from_url( $postimage );
    if(!empty($size)){
      $postthumb = wp_get_attachment_image_src( $postimage_id,$size);
      $postimage = $postthumb[0];
    }
    elseif ( false != wp_get_attachment_image_src( $postimage_id, 'thumbnail' ) ) {
      $postthumb = wp_get_attachment_image_src( $postimage_id, 'thumbnail' );
      $postimage = $postthumb[0];
    }else{
      $postthumb = wp_get_attachment_image_src( $postimage_id, 'full');
      $postimage = $postthumb[0];
    }
    return $postimage;
  }
}

function media_get_path_image_final($post_id, $post_content = "", $size ="thumbnail"){
  $image_src = media_get_path_image_from_post_id($post_id, $size);
  if($image_src == ""){
    $image_src = media_get_path_image_first_content_post( $post_content, $size);
    if($image_src == ""){
      $image_src = get_template_directory_uri()."/asset/app/img/no-image.png";
    }
  }
  return $image_src;
}


function media_view_image($post_id,$post_title = "", $post_content ="", $size="thumbnail", $class ="img-responsive", $attribute = "", $lazyload = false){
  $image_src = media_get_path_image_final($post_id, $post_content, $size);
  if($lazyload){
    return '
      <img data-original="'.$image_src.'" class="'.$class.'" '.$attribute.' alt="'.$post_title.'"/>
      <noscript>
          <img src="'.$image_src.'" class="'.$class.'" '.$attribute.' alt="'.$post_title.'">
      </noscript>
    ';
  }else{
    return '<img src="'.$image_src.'" class="'.$class.'" '.$attribute.' alt="'.$post_title.'">';
  }
}


function custom_get_attachment_id_from_url( $attachment_url = '' ) {

  global $wpdb;
  $attachment_id = false;

  // If there is no url, return.
  if ( '' == $attachment_url ) {
    return;
  }

  // Get the upload directory paths
  $upload_dir_paths = wp_upload_dir();

  // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
  if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

    // If this is the URL of an auto-generated thumbnail, get the URL of the original image
    $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

    // Remove the upload path base directory from the attachment URL
    $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

    // Finally, run a custom database query to get the attachment ID from the modified attachment URL
    $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

  }
  return apply_filters( 'custom_get_attachment_id_from_url', $attachment_id, $attachment_url );
} 

