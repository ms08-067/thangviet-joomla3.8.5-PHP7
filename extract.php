<?php
$script_filename = $_SERVER['SCRIPT_FILENAME'];
$current_path =  substr($script_filename,0,(strrpos($script_filename,"/")+1));
$zip = new ZipArchive;
if ($zip->open('thangviet.zip') === TRUE) {
    $zip->extractTo($current_path);
    $zip->close();
    echo 'ok';
} else {
    echo 'failed';
}
?>