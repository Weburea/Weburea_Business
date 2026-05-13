<?php
$h = file_get_contents('c:/xampp/htdocs/Weburea_Agency/dashboard/dashboard-work.php'); 
$m = []; 
foreach(['work-id','title','description','year','industry','project_direction','categories','sort_order','status','service_id','pricing_id','image','comparison_image','additional_images','client_logo_light','client_logo_dark','project_overview','project_challenge','challenge_points','testimonial_text','testimonial_author','testimonial_role','meta_title','meta_description','meta_keywords'] as $id) { 
    if(strpos($h, 'id="'.$id.'"') === false) $m[]=$id; 
} 
print_r($m);
