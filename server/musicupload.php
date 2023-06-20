<?php
// Headers
  header('Access-Control-Allow-Origin: *');
//   header('Content-Type: application/json');
if(isset($_FILES['trackUp']['name'])){
   // file name
   $filename = $_FILES['trackUp']['name'];

   // Location
   $location = 'uploads/tracks/'. $filename;

   // file extension
   $file_extension = pathinfo($location, PATHINFO_EXTENSION);
   $file_extension = strtolower($file_extension);

   // Valid extensions
   $valid_ext = array("mp3");
   

   $response = 0;
   if(in_array($file_extension,$valid_ext)){
      // Upload file
      if(move_uploaded_file($_FILES['trackUp']['tmp_name'],$location)){
         $response = 1;
      } 
   }

   echo $response;
   exit;
}