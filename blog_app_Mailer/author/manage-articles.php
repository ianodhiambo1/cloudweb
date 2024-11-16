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
                        <p> <a href="../logout.php">Log out</a> </p>
                        </li>

                    </ul>
                </li>
            </div>
            <!-- <li><a href="#">Feedback</a></li> -->
        </ul>

    </nav>

    <section class="dashboard">
        <div class="container dashboard_container">
            <aside>
                <ul>
                    <li>
                        <a href="add_post.php"><i class='bx bx-notepad' ></i></i>
                        <h5>Add Post</h5>
                        </a>
                    </li>

                   <!-- <li>
                        <a href="edit_post.php"><i class='bx bx-pencil'></i>
                        <h5>Edit Post</h5>
                        </a>
                    </li>
                -->
                    <li>
                        <a href="manage-articles.php" class="active"><i class='bx bx-objects-vertical-center' ></i>
                        <h5>Manage Posts</h5>
                        </a>
                    </li>
                </ul>
            </aside>
            <main>
            <h2>Manage Articles</h2>
            <table>
                <thead>
                    <tr>
                        <th>Sr</th>
                        <th>Author Name</th>
                        <th>Article Title</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //Fetch articles from the database based on logged-in author

                    $selectArticles = mysqli_query($db_connect, "SELECT * FROM `articles` WHERE user_id = '$user_id' ORDER BY `article_id` DESC");

                    //Check if any articles exist
                    if(mysqli_num_rows($selectArticles) > 0){
                        $serial = 1; // Counter for serial number

                        //loop through each article and display in the table
                        while($article = mysqli_fetch_assoc($selectArticles)){
                            $authorFName = "";  //Variable to store author name
                            $authorLName = "";

                            //Fetch author name based on author_id
                            $selectAuthor = mysqli_query($db_connect, "SELECT Fname, Lname FROM `users` WHERE user_id = '{$article['user_id']}'");
                            if(mysqli_num_rows($selectAuthor) > 0){
                                $author = mysqli_fetch_assoc($selectAuthor);
                                $authorFName = $author['Fname'];
                                $authorLName = $author['Lname'];
                                $author_full_name = $authorFName . ' ' . $authorLName;
                            }

                            echo "<tr>";
                            echo "<td>{$serial}</td>";
                            echo "<td>{$author_full_name}</td>";
                            echo "<td>{$article['article_title']}</td>";
                            echo "<td><a href=\"edit_post.php?id={$article['article_id']}\" class=\"btn sm\">Edit</a></td>";
                            echo "<td><a href=\"delete_post.php?id={$article['article_id']}\" class=\"btn sm danger\">Delete</a></td>";
                            echo "</tr>";

                            $serial++; //Increment serial number

                        }

                    }else{
                        echo "<tr><td colspan='5'>No articles found!.</td></tr>";
                    }
                    ?>
                    
                </tbody>
            </table>
              
            </main>
            
        </div>

    </section>