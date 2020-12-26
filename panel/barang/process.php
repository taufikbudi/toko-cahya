<?php

$file_max_weight = 20000; //limit the maximum size of file allowed (20Mb)

$ok_ext = array('jpg','png','gif','jpeg'); // allow only these types of files

$destination = '../../foto/'; // where our files will be stored



// PHP sets a global variable $_FILES['file'] which containes all information on the file
// The $_FILES['file'] is also an array, so to have the file name we're supposed to write $_FILES['file']['name']
// To shorten that I added the following line. With that I could just do $file['name']
$file = $_FILES['fupload'];


$filename = explode(".", $file["name"]); 


$file_name = $file['name']; // file original name

$file_name_no_ext = isset($filename[0]) ? $filename[0] : null; // File name without the extension

$file_extension = $filename[count($filename)-1];

$file_weight = $file['size'];

$file_type = $file['type'];
?>