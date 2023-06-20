<?php
// Headers
  header('Access-Control-Allow-Origin: *');
//   header('Content-Type: application/json');
if(isset($_FILES['vidUp']['name'])){
   // file name
   $filename = $_FILES['vidUp']['name'];

   // Location
   $location = 'uploads/'. $filename;

   // file extension
   $file_extension = pathinfo($location, PATHINFO_EXTENSION);
   $file_extension = strtolower($file_extension);

   // Valid extensions
   $valid_ext = array("mp4", "mpg", "mov");

   $response = 0;
   if(in_array($file_extension,$valid_ext)){
      // Upload file
      if(move_uploaded_file($_FILES['vidUp']['tmp_name'],$location)){
         $response = 1;
      } 
   }

   echo $response;
   exit;
}