<?php
function showPublishedgallery_1($id)
{
	global $wpdb;
	$query=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."huge_itgallery_images where gallery_id = '%d' order by ordering ASC",$id);
	$images=$wpdb->get_results($query);
	$query=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."huge_itgallery_gallerys where id = '%d' order by id ASC",$id);
	$gallery=$wpdb->get_results($query);   
    $paramssld = '';
	return front_end_gallery($images, $paramssld, $gallery);
}
?>