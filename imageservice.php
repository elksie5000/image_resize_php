
<html>
<head><!-- Latest compiled and minified CSS & JS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script src="//code.jquery.com/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script></head>
<body>
    <div class="container-fluid">
    
<?php
//header("Content-type: image/jpg");
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 'On');  //On or Off

//recursive traversal of directions from a base $dir
function getDirContents($dir, &$results = array()){
    global $output_html;
	//Scan all files in directory
    $files = scandir($dir);
	//Loop through
    foreach($files as $key => $value){
        $path = $dir.DIRECTORY_SEPARATOR.$value;
		//if file path is not directory, append path otherwise start another level of recursion.
		if(!is_dir($path)) {
            $results[] = $path;
        } else if($value != "." && $value != "..") {
            getDirContents($path, $results[$path]);
            $results[] = $path;

        }
    }

    return $results;
}


 // Avoid any external dependency
if(!function_exists('__clean')) {
    function __clean($s, $len){
        if(!isset($s)) return null;
        $s = substr($s, 0, $len);
        if(ini_get('gpc_magic_quotes') != 1) $s = addslashes($s);
        $s = escapeshellcmd($s);
        return $s;
    }
}



//Check for path  and size in uri



$size = 'medium';
$uri = "imagesv2";

$result = getDirContents($uri);
foreach($result as $key => $values){
    //extract folder names and print with header tags
    $exploded = explode("/", $key);
        if ( isset($exploded[1])) {
            echo "<h2>$exploded[1]</h2>";
    }
    //https://stackoverflow.com/a/2630032/386861
    //Used to avoid "Warning: Invalid argument supplied for foreach()"
    //PATH is the URL of the directory of images
    if (is_array($values) || is_object($values)){
        foreach($values as $value){
            $thumb_path = "http://ec2-34-244-174-183.eu-west-1.compute.amazonaws.com/images.php?path=$value&size=thumbnail";
			$default_path = "PATH";
            echo "<a href=\"$default_path\"><img src=\"$thumb_path\"></a>";
        }
    }


    
}

?>
        
    </div>
</body>
</html>



