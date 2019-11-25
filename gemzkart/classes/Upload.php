<?php
class Upload{
    
     // database connection and table name
     private $conn;
     private $table_name = "image";
  
     // object properties
     public $img_id;
     public $img_title;
     public $img_name;
     public $img_url;
     public $img_description;
     public $img_temp;
     public $img_size;
    
  
     public function __construct($db){
         $this->conn = $db;
     }
    // will upload image file to server
        function uploadFile(){
        
            $result_message="";
        //print_r($this);die('i m here');
            // now, if image is not empty, try to upload the image
            if($this->img_name){
              //  die('i m here ');
                // sha1_file() function is used to make a unique file name
                $target_directory = "uploads/";
                $target_file = $target_directory . $this->img_name;
                $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
        
                // error message is empty
                $file_upload_error_messages="";
                // make sure that file is a real image
               // die('i m here 1');
                $check = getimagesize($this->img_temp);
                if($check!==false){
                    // submitted file is an image
                   // die('i m here 2');
                }else{
                    $file_upload_error_messages.="<div>Submitted file is not an image.</div>";
                }
                
                // make sure certain file types are allowed
                $allowed_file_types=array("jpg", "jpeg", "png", "gif");
                if(!in_array(strtolower($file_type), $allowed_file_types)){
                    //die('i m here 2');
                    $file_upload_error_messages.="<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                }
                
                // make sure file does not exist
                if(file_exists($target_file)){//die('i m here 32');
                    $file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
                }
                
                // make sure submitted file is not too large, can't be larger than 1 MB
                if($this->img_size > (1024000)){//die('i m here 22');
                    $file_upload_error_messages.="<div>Image must be less than 1 MB in size.</div>";
                }
                
                // make sure the 'uploads' folder exists
                // if not, create it
                if(!is_dir($target_directory)){
                    mkdir($target_directory, 0777, true);
                }
               
               // If the file is valid, we will upload the file to server. Specifically, in the "uploads" folder. If there's any error, we will return it to be shown to the user.

               // Place the following code after the previous section's code.

                // if $file_upload_error_messages is still empty
                if(empty($file_upload_error_messages)){//die("i am here 3");
                    // it means there are no errors, so try to upload the file
                    if(move_uploaded_file($this->img_temp, $target_file)){
                        // it means photo was uploaded
                       // die("i am here 4");
                      // return true;
                    }else{//die("i am here 5");
                       // return false;
                        $result_message.="<div class='alert alert-danger'>";
                            $result_message.="<div>Unable to upload photo.</div>";
                            $result_message.="<div>Update the record to upload photo.</div>";
                        $result_message.="</div>";
                    }
                }
                
                // if $file_upload_error_messages is NOT empty
                else{
                    // it means there are some errors, so show them to user
                    $result_message.="<div class='alert alert-danger'>";
                        $result_message.="{$file_upload_error_messages}";
                        $result_message.="<div>Update the record to upload photo.</div>";
                    $result_message.="</div>";
                }
        
            }
        
            return $result_message;
        }
        public function create(){
           // print_r($this);die('i m here');
        // insert query
                    $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    title=:title, file_url=:file_url, description=:description, created=:created";

            $stmt = $this->conn->prepare($query);

            // posted values
            $this->img_title=htmlspecialchars(strip_tags($this->img_title));
            $this->img_name=htmlspecialchars(strip_tags($this->img_name));
            $this->img_description=htmlspecialchars(strip_tags($this->img_description));
            

            // to get time-stamp for 'created' field
            $this->timestamp = date('Y-m-d H:i:s');

            // bind values 
            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
                    $link = "https"; 
                else
                    $link = "http"; 
                
                // Here append the common URL characters. 
                $link .= "://"; 
                
                // Append the host(domain name, ip) to the URL. 
                $link .= $_SERVER['HTTP_HOST']; 
                
                // Append the requested resource location to the URL 
                $uriArr = explode("/", $_SERVER['REQUEST_URI']);
                $link .= "/".$uriArr[1]."/uploads/"; 
                $link .= $this->img_name;
            $stmt->bindParam(":title", $this->img_title);
            $stmt->bindParam(":file_url", $link);
            $stmt->bindParam(":description", $this->img_description);
            $stmt->bindParam(":created", $this->timestamp);
            //$stmt->debugDumpParams();
            if($stmt->execute()){
            return true;
            }else{
            return false;
            }
       
        }
       
}


?>