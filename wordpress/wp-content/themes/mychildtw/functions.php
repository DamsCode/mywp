<?php


require_once("template/mywp_meta_box.php");



function twenty_twenty_child_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'main-css', get_stylesheet_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'twenty_twenty_child_theme_enqueue_styles' );

$metabox = new mywp_meta_box('test','je test un truc','page');

$metabox->add('name','Nom:');

function mywp_save_meta($post_id){

    if(!current_user_can("edit_post",$post_id)){
        return false;
    }

    if (wp_verify_nonce($_POST['test_nonce'],'test')){
        return false;
    }

    $value = $_POST['test'];
    $meta = 'test';
    if (!isset($_POST[$meta]) || defined('DOING_AJAX') && DOING_AJAX ){
        return false;
    }
    if (get_post_meta($post_id,"test")){
        update_post_meta($post_id,$meta,$value);
    }elseif ($value == ''){
        delete_post_meta($post_id,$meta);
    }
    else{
        add_post_meta($post_id,'test',$value);
    }
}
?>