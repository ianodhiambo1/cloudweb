<?php
require '../config/db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    exit("Unauthorised Access Error");
}
$user_id = $_SESSION['user_id'];

// Check if the user is not an author
if ($_SESSION['role'] != 'author') {
    header("HTTP/1.1 403 Forbidden");
    exit("Forbidden Access Error");
}

if(isset($_GET['id'])){
    $article_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //fetch article from database so as to delete article image
    $select = "SELECT * FROM `articles` WHERE article_id = '$article_id'";
    $result = mysqli_query($db_connect, $select);

    //ensure that only one record was fetched
    if(mysqli_num_rows($result) == 1){
        $article = mysqli_fetch_assoc($result);
        $img_name = $article['article_img'];
        $img_path = '../img_uploads/' . $img_name;

        if($img_path){
            unlink($img_path);

            //delete article from database

            $delete_article = "DELETE FROM `articles` WHERE article_id = '$article_id'";
            $delete_article_result = mysqli_query($db_connect, $delete_article);
            if($delete_article_result){
                header('location: manage-articles.php');
            }
        }
    }
}
?>