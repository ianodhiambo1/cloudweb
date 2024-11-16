<?php
include '../config/db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    exit("Unauthorised Access Error");
}
$user_id = $_SESSION['user_id'];
$article_id = $_SESSION['article_id'];
// Check if the user is not an author
if ($_SESSION['role'] != 'author') {
    header("HTTP/1.1 403 Forbidden");
    exit("Forbidden Access Error");
}
//check if button is clicked and perform needed validations
if(isset($_POST['submit'])){
    $article_id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_img_name = filter_var($_POST['previous_img_name'],
    FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $article_title = filter_var($_POST['article_title'],
    FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $article_text = filter_var($_POST['article_text'],
    FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $img = $_FILES['img'];

    //check and validate input fields
    if(!$article_title){
        $error[] = "Couldn't update post. Invalid form data on the edit post page";
    }elseif(!$article_text){
        $error[] = "Couldn't update post. Invalid form data on the edit post page";
    }else{
        //delete existing image if new one is set
        if($img['name']){
            $previuos_img_path = '../img_uploads/' . $previous_img_name;
            if($previuos_img_path){
                unlink($previuos_img_path);
            }

            //update and rename the new image
            $time = time(); //make each image name upload using current timestamp
            $img_name = $time . $img['name'];
            $img_tmp_name = $img['tmp_name'];
            $img_destination_path = '../img_uploads/' . $img_name;

            //ensure that the file is an image
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = explode('.', $img_name);
            $extension = end($extension);
            
            if(in_array($extension, $allowed_files)){
                //validate image size
                if($img['size'] < 2000000){
                    //upload image
                    move_uploaded_file($img_tmp_name, $img_destination_path);
                } else{
                    $error[] = "Couldn't update article. Image size is too big. Should be less than 2mb";
                }
            } else{
                $error[] = "Couldn't update article. Image should be png, jpg or jpeg";
            }

        }
    }

    if(empty($error)){
        //set image name if a new was uploaded, else keep the old name
        $img_to_insert = $img_name ?? $previous_img_name;

        $query = "UPDATE `articles` SET article_title = '$article_title', article_content = '$article_text', article_img = '$img_to_insert' WHERE article_id = '$article_id'";
        $result = mysqli_query($db_connect, $query);
        if($result){
            header('location: manage-articles.php');
        }
    }




}

?>