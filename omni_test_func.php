<?php
ini_set("display_errors",1);
$a="";

function copy_folder($src, $dst) { 
   
    // open the source directory
    $dir = opendir($src); 
   
    // Make the destination directory if not exist
	if (!file_exists($dst)) {
		mkdir($dst, 0777, true);
	}
    
   
    // Loop through the files in source directory
    foreach (scandir($src) as $file) { 
   
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) 
            { 
   
                // Recursively calling custom copy function
                // for sub directory 
                copy_folder($src . '/' . $file, $dst . '/' . $file); 
   
            } 
            else { 
                copy($src . '/' . $file, $dst . '/' . $file); 
            } 
        } 
    } 
   
    closedir($dir);
	//if(closedir($dir)==true){return "1";}else{return "0";}
} 


$data['company_name'] = "ms-sso-test";
echo $src = $_SERVER['DOCUMENT_ROOT']."/tests/ms-sso";		
echo $dst = $_SERVER['DOCUMENT_ROOT']."/tests".$a."/".$data['company_name']."/ms-sso";
copy_folder($src, $dst);


