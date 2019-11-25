<?php
// include database and object files
//echo '<pre>';
//print_r( $_SERVER['REQUEST_URI']);

function __autoload($class){
    require_once "classes/$class.php";
}

// instantiate database and objects
$database = new Database();
$db = $database->getConnection();

$upload = new Upload($db);

 
// query products
//$stmt = $upload->readAll($from_record_num, $records_per_page);
//$num = $stmt->rowCount();

if($_POST){
 
    // set product property values
    $upload->img_title = $_POST['title'];
   
    $upload->img_description = $_POST['description'];
    $image = !empty($_FILES["image"]["name"])? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"]) : "";
    $upload->img_name = $image;
    $upload->img_temp = $_FILES['image']['tmp_name'];
    $upload->img_size = $_FILES['image']['size'];
 
    // create the product
  // echo "upload here".$upload->uploadFile();
   //die('i m uploading');
    if(empty($upload->uploadFile())){
        if($upload->create()){
        echo "<div class='alert alert-success'>File was updated.</div>";
        }// if unable to insert, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create product.</div>";
    }
    }else{
        echo $upload->uploadFile();
    }
 
    
}


?>

<!-- HTML form for creating a product -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
 
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>Title</td>
            <td><input type='text' name='title' class='form-control' /></td>
        </tr>
 
       
 
        <tr>
            <td>Description</td>
            <td><textarea name='description' class='form-control'></textarea></td>
        </tr>
 
        
        <tr>
            <td>Photo</td>
            <td><input type="file" name="image" /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Create</button>
            </td>
        </tr>
 
    </table>
</form>