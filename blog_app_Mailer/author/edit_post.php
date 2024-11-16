<?php
include '../config/db_connection.php';
session_start();


// Check if the user is not logged in
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

$error = array();

  //fetch the data from the database if set
  if(isset($_GET['id'])){
   $article_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
   $selectArticle = "SELECT * FROM `articles` WHERE article_id = '$article_id'";
   $result = mysqli_query($db_connect, $selectArticle);
   $article = mysqli_fetch_assoc($result);

  }else{
    header('location: manage-articles.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF=8">
      <title>Hoodie Stores</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="../css/post_form.css">
      <link rel="stylesheet" type="text/css" href="../css/style.css">
      <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
      <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  </head>
    <body>
      <nav>
            <label class="logo">Stylish</label>
            <ul class="navlist">
                <!-- <li><a href="index.html">Home</a></li> -->
                <li><a href="#">Home</a></li>
                <!--<li><a href="#">BLOG</a></li> -->
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">About</a></li>
        
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
                            <img style="max-width: 100%; height = auto;"src="../img/user.png" class="profile" alt="">
                            <h3><?php echo $fetch['username']; ?></h3>
                            
                        </div>
                        <ul>
                            <?php if ($_SESSION['role'] == 'author'){?>
                            <li class="sub-item">
                                <span class="material-symbols-outlined">post</span>
                                <p> 
                                
                                <a href="../vblog.php">Posts</a>
                                
                                </p>
                            </li>
                             <?php } ?>

                            <li class="sub-item">
                            <span class="material-symbols-outlined">logout</span>
                            <p> <a href="../logout.php">Log out</a> <p>
                            </li>

                        </ul>
                    </li>
                </div>
                    <!-- <li><a href="#">Feedback</a></li> -->
            </ul>

        </nav>

        
        <div class="form-container">
            <h2>Add Post</h2>
                <?php
                    if(isset($error)){
                        foreach($error as $error){
                            echo '<span class="error-msg">'.$error.'</span>';
                        }
                    }
                ?>
            <form action="edit_post_logic.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $article['article_id'] ?>">
                <input type="hidden" name="previous_img_name" value="<?= $article['article_img'] ?>">
                <!--  <label for="author_name">Author's Full Name:</label>
                <input type="text" id="author_name" name="author_name" required>
                -->
                <label for="article_title">Article Title:</label>
                <input type="text" id="article_title" name="article_title" value="<?= $article['article_title'] ?>" required>

                <label for="article_text">Article Text:</label>
                <textarea id="article_text" name="article_text" rows="10" required><?= $article['article_content'] ?></textarea>


                <div class="form_control inline">
                    <input type="checkbox" id="publish" value="1" name="publish"checked>
                    <label for="publish" ></label>
                </div>
                <div class="form_control">
                    <label for="img"> Change Image </label>
                    <input type="file" id="img" name="img">
                </div>
                <input type="submit" name="submit" value="Update Post" class="btn">
            </form>
        </div>
    </body>
</html>


