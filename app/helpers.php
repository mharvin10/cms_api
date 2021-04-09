<?php
function content_first_image($html){
    preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $html, $img);
    if (count($img) > 1) {
    	return $img[1];
    }
    return null;
}