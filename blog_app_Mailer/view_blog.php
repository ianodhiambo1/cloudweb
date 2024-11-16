<?php
include 'config/db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    exit("Unauthorised Access Error");
}
$user_id = $_SESSION['user_id'];

if(isset($_GET['id'])){
    $article_id = $_GET['id'];

    $selectArticle = mysqli_query($db_connect, "SELECT * FROM `articles` WHERE article_id = '$article_id'") or die("query failed");

    if(mysqli_num_rows($selectArticle) > 0){
        $article = mysqli_fetch_assoc($selectArticle);
    }else{
        header('location: vblog.php');
        echo $error[] = "Article not found";
    }

    

}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF=8">
      <title>Hoodie Stores</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
      <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  </head>
  <body>
    <div class="nav-bar">
      <nav>
        <label class="logo">Stylish</label>
        <ul class="navlist">
          <!-- <li><a href="index.html">Home</a></li> -->
            <li><a href="#">Home</a></li>
            <!--<li><a href="#">BLOG</a></li> -->
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">About</a></li>

            <li>&nbsp</li>
          <div class="li-prophile">

            <li>
              <?php
              $select = mysqli_query($db_connect, "SELECT * FROM `users` WHERE user_id = '$user_id'") 
              or die('query failed');

              if(mysqli_num_rows($select) > 0){
                $fetch = mysqli_fetch_assoc($select);
              }
              
              ?>
              <div class="username">
              <img style="max-width: 100%; height = auto;"src="./img/user.png" class="profile" alt="">
              <h3><?php echo $fetch['username']; ?></h3>
              
            </div>
              <ul>
              <?php if($_SESSION['role'] == 'author'){?>
              <li class="sub-item">
                  <span class="material-symbols-outlined">Dashboard</span>
                  <p>
                    
                    <a href="author/manage-articles.php">Dashboard</a>
                  
                  <p>
                </li>
                <?php } ?>

                <li class="sub-item">
                <span class="material-symbols-outlined">logout</span>
                <p> <a href="logout.php">Log out</a> <p>
                </li>

              </ul>
            </li>
          </div>
          <!-- <li><a href="#">Feedback</a></li> -->
        </ul>

      </nav>

<div class="section01">
            <div class="container01">
                <div class="content-section">
                    <div class="title" >
                        <h1><?= $article['article_title'] ?></h1>
                    </div>
                    <div class="content">
                        <?php
                        $authorFName = "";
                        $authorLname = "";
          
                        $selectAuthor = mysqli_query($db_connect, "SELECT Fname, Lname FROM `users` WHERE user_id = '{$article['user_id']}'");
                        if(mysqli_num_rows($selectAuthor) > 0){
                          $author = mysqli_fetch_assoc($selectAuthor);
                          $authorFName = $author['Fname'];
                          $authorLname = $author['Lname'];
                          $author_full_name = $authorFName . ' ' . $authorLname;
                        }
                        ?>

                        <h3>Article by: <?= $author_full_name ?></h3><br>
                        <h5><?= date("M d, Y - H:i a", strtotime($article['date_modified']))?></h5>
                           
                        <p><?= $article['article_content'] ?></p>
                       <!-- <div class="button">
                          <a href="#">Read More</a>
                        </div>
                        -->
                    </div>
                    <div class="socials">
                        <i class="ri-instagram-line"></i>
                        <i class="ri-whatsapp-line"></i>
                        <i class="ri-twitter-line"></i>
                        <i class="ri-facebook-line"></i>
                    </div>
                </div> 
                <div class="img-section">
                 <img src="img_uploads/<?= $article['article_img'] ?>" >
                </div>
            </div>
        </div>