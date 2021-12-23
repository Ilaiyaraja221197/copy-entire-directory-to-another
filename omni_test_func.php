<?php
ini_set("display_errors",1);
$a="";
function omnichannel_create($data){
	//files move to source to destination
		
		//ini_set('max_execution_time', 300); //300 seconds = 5 minutes
		$src = $_SERVER['DOCUMENT_ROOT']."/ms-sso.zip";		
		$dst = $_SERVER['DOCUMENT_ROOT']."/".$data['company_name'];
			// Make sure source folder have sufficient permission to read files
  
		$unzip = unzip_folder($src, $dst);
		
		$path = $_SERVER['DOCUMENT_ROOT']."/".$data['company_name']."/ms-sso";
		$string_to_replace="https://omni.mconnectapps.com/ms-sso/";
        $replace_with="https://omni.mconnectapps.com/".$data['company_name']."/".$a."
        ms-sso/";
		
		multipleFileStrReplace($path,$string_to_replace,$replace_with);
			return "1";
		
		
    	
}
	



/*Multiple file str change */
function multipleFileStrReplace($path,$string_to_replace,$replace_with){
    
    $fileList = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);
    
    foreach ($fileList as $item) {
        if ($item->isFile()) {
            $file_contents = file_get_contents($item->getPathName());
            $file_contents = str_replace($string_to_replace,$replace_with,$file_contents);
            file_put_contents($item->getPathName(),$file_contents);
        }
    }
}

function unzip_folder($src,$dst){
	//extract zip file
	// Create new zip class
	$zip = new ZipArchive; 
	// Add zip filename which need
	// to unzip
	$zip->open($src);
	// Extracts to current directory
	$zip->extractTo($dst);

	$zip->close(); 

}

function zip_folder($src,$dst,$fname){
	 $rootPath = $_SERVER['DOCUMENT_ROOT']."/";

	// Initialize archive object
	$zip = new ZipArchive();
	$zip->open($fname, ZipArchive::CREATE | ZipArchive::OVERWRITE);

	// Create recursive directory iterator
	/** @var SplFileInfo[] $files */
	$files = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator($rootPath),
		RecursiveIteratorIterator::LEAVES_ONLY
	);

	foreach ($files as $name => $file)
	{
		// Skip directories (they would be added automatically)
		if (!$file->isDir())
		{
			// Get real and relative path for current file
			$filePath = $file->getRealPath();
			$relativePath = substr($filePath, strlen($rootPath) );

			// Add current file to archive
			$zip->addFile($filePath, $relativePath);
		}
	}
	// Zip archive will be created only after closing object
	$zip->close();

}

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

$string_to_replace = "https://omni.mconnectapps.com/ms-sso/";
$replace_with = "https://omni.mconnectapps.com/".$data['company_name']."/".$a."ms-sso/";
multipleFileStrReplace($dst,$string_to_replace,$replace_with);
