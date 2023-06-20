<?php
// Headers
  header('Access-Control-Allow-Origin: *');
//   header('Content-Type: application/json');
if(isset($_FILES['imageUp']['name'])){
   // file name
   $filename = $_FILES['imageUp']['name'];

   // Location
   $location = 'uploads/images/'. $filename;

   // file extension
   $file_extension = pathinfo($location, PATHINFO_EXTENSION);
   $file_extension = strtolower($file_extension);

   // Valid extensions
   $valid_ext = array("pdf","doc","docx","jpg","png","jpeg");

   $response = 0;
   if(in_array($file_extension,$valid_ext)){
      // Upload file
      if(move_uploaded_file($_FILES['imageUp']['tmp_name'],$location)){
         $response = 1;
      } 
   }

   echo $response;
   exit;
}