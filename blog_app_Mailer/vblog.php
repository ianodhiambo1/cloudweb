<?php
include 'config/db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("HTTP/1.1 401 Unauthorized");
  exit("Unauthorised Access Error");
}
$user_id = $_SESSION['user_id'];



/*if(!isset($_SESSION['user_id'])){
  header('location:sign_in.php');
}
else if($_SESSION['role']=='author'){
    header('location:sign_in.php');
}
*/

//fetch articles from articles table
$select = "SELECT * FROM `articles` ORDER BY date_modified DESC LIMIT 4";
$selectedArticles = mysqli_query($db_connect, $select);

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
    </div>
    <div class="body">
      <header>
          <h1>Our Blog</h1>
      </header>
      <?php
        if(isset($error)){
            foreach($error as $error){
                echo '<span class="error-msg">'.$error.'</span>';
            }
        }
      ?>
      <div class="row">
        <div class="left-column">
          <?php while ($articles = mysqli_fetch_assoc($selectedArticles)) : ?>
            <?php
              $authorFName = "";
              $authorLname = "";

              $selectAuthor = mysqli_query($db_connect, "SELECT Fname, Lname FROM `users` WHERE user_id = '{$articles['user_id']}'");
              if(mysqli_num_rows($selectAuthor) > 0){
                $author = mysqli_fetch_assoc($selectAuthor);
                $authorFName = $author['Fname'];
                $authorLname = $author['Lname'];
                $author_full_name = $authorFName . ' ' . $authorLname;
              }
           ?>
            <div class="card">
              <h2><a href="view_blog.php?id=<?= $articles['article_id'] ?>" class="btn-blog"><?= $articles['article_title'] ?></a></h2>
              <h5><?= date("M d, Y - H:i a", strtotime($articles['date_modified']))?></h5>
              <img src="img_uploads/<?= $articles['article_img'] ?>">
              <h4></h4>
              <p> <?= strlen($articles['article_content']) > 300 ? substr($article['article_content'], 0, 300) . "..." :$articles['article_content'] ?></p>
              <h6>Article by: <?= $author_full_name?></h6>
            </div>
            <?php endwhile?>
        </div>
        <div class="right-column">
            <div class="card">
                <h2>Daily trends</h2>
                <img src="https://www.newtimes.co.rw/uploads/imported_images/files/main/articles/2020/12/21/the-kind-of-music-you-listen-to-determines-your-mood.jpg">
                <p>"Every day is a chance to discover new inspiration, embrace your style, and elevate your fashion game. Join us on this exciting journey as we bring you daily fashion insights, 
                    trends, and styling tips. Let's stay stylish together, one blog at a time!"</p>
            </div>
            <div class="card">
                <h3>Popular Post</h3>
                <div class="sidebar-images">
                    <img src="https://d3njjcbhbojbot.cloudfront.net/api/utilities/v1/imageproxy/https://images.ctfassets.net/wp1lcwdav1p1/2zlYPOQC0YLOnko9UtepFy/1fd4b3fb7308eecfeeac964a29ed6796/GettyImages-1174452698.jpg?w=1500&h=680&q=60&fit=fill&f=faces&fm=jpg&fl=progressive&auto=format%2Ccompress&dpr=1&w=1000&h=">
                    <img src="data:image/jpeg;base64,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">
                    <img src="https://c8.alamy.com/comp/M24F79/smiling-young-man-in-hoodie-looking-at-camera-and-smiling-while-standing-M24F79.jpg">
                </div>
            </div>
            <div class="card">
                <h3>Follow Us</h3>
                <div class="socials">
                    <i class="ri-instagram-line"></i>
                    <i class="ri-whatsapp-line"></i>
                    <i class="ri-twitter-line"></i>
                    <i class="ri-facebook-line"></i>
                </div>
            </div>
        </div>
      </div>
    </div>
  </body>
</html>