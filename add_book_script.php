<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css">

<title>Add Book Script</title>
</head>
<body>
<?php
    //check form submission
    if(isset($_POST['submit'])){
        $errors = [];
        if(empty($_POST['title'])){
            $errors[] = "Book title is required";
        }   
        else{
            $title = $_POST['title'];
        }

        if(isset($_FILES['uploadFile'])){
            $target_directory = "images/";
            $file_name = $_FILES['uploadFile']['name'];
            $file_size = $_FILES['uploadFile']['size'];
            $file_tmp_name = $_FILES['uploadFile']['tmp_name'];
            $file_type = $_FILES['uploadFile']['type'];
            $target_file = $target_directory . $file_name;
            $uploadOk = 0;
            //allowed file types
            $allowed = ['image/png', 'image/PNG', 'image/jpeg', 'image/JPEG', 'image/jpg','image/JPG'];

            if(in_array($file_type,$allowed)){
                //File Size
                if($file_size > 5000000){
                    $errors[] = "Maximum File Size exceeded. File cannot exceed 5MB";
                    $uploadOk = 1;
                }
                else{
                    if(move_uploaded_file($file_tmp_name,$target_file)){
                        echo "<div class = 'alert alert-success'>File Uploaded Successfully</div>";

                        $sql = "INSERT INTO books VALUES(NULL, $title, $target_file)";
                        $result = mysqli_query($dbc,$sql);
                        
                    }
                    else{
                        echo "<div class ='alert alert-danger'>Cannot upload the file. Err_Code: {$_FILES['uploadFile']['error']}
                        </div> ";
                    }
                }
            }
            else{
                $errors[] = "Invalid File Type. File cannot be uploaded";
                // exit();
                $uploadOk = 1;
            }


        }
    }
    else{
        echo "<div class = 'alert alert-danger'>Submit the form first!</div>";
    }
?>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>