# ionic4_multipleMediafileUpload
ionic start fileMediya blank

 
npm i @ionic-native/media-capture
npm i @ionic-native/file
npm i @ionic-native/media
npm i @ionic-native/streaming-media
npm i @ionic-native/photo-viewer
npm i @ionic-native/image-picker
npm i @ionic-native/ionic-webview
npm i @ionic-native/file-path
 
ionic cordova plugin add cordova-plugin-media-capture
ionic cordova plugin add cordova-plugin-file
ionic cordova plugin add cordova-plugin-media
ionic cordova plugin add cordova-plugin-streaming-media
ionic cordova plugin add com-sarriaroman-photoviewer
ionic cordova plugin add cordova-plugin-telerik-imagepicker
ionic cordova plugin add cordova-plugin-ionic-webview
ionic cordova plugin add cordova-plugin-filepath
 
// For the imagepicker on Android we need a fix
cordova plugin add cordova-android-support-gradle-release

<?php

header('Access-Control-Allow-Origin: *');
$target_path = "uploads/";

$target_path = $target_path . basename( $_FILES['file']['name']);

if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
  // header('Content-type: application/json');
   $data = ['success' => true, 'message' => 'Upload and move success'];
   echo json_encode($data);
    
} else{
   // header('Content-type: application/json');
   $data = ['success' => false, 'message' => 'There was an error uploading the file,Upload and move success'];
   echo json_encode($data);
}
