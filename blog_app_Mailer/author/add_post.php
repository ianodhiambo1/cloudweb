<?php
include '../config/db_connection.php';
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



if(isset($_POST['submit'])){
    $author_name = filter_var($_POST['author_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['article_title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_var($_POST['article_text'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $img = $_FILES['img'];

    // Form validation and error handling

    // Check if author exists
    $select = "SELECT * FROM `users` WHERE user_id = '$user_id' && username = '$author_name'";
    $result = mysqli_query($db_connect, $select);

    if(mysqli_num_rows($result) <= 0){
        $error[] = "Author does not exist!";
    }

    // Validate form fields
    if(empty($title)){
        $error[] = "Enter post title";
    }

    if(empty($content)){
        $error[] = "Enter post body";
    }

    if(empty($img['name'])){
        $error[] = "Choose post thumbnail";
    }

    // File validation
    if(!empty($img['name'])){
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = pathinfo($img['name'], PATHINFO_EXTENSION);

        if(!in_array($extension, $allowed_files)){
            $error[] = "File should be PNG, JPG, or JPEG";
        }

        if($img['size'] > 2_000_000){
            $error[] = "File size is too big!";
        }
    }

    // Handle errors
    if(!empty($error)){
        $_SESSION['add_post_data'] = $_POST;
        $_SESSION['add_post_error'] = $error;
        header('location: add_post.php');
        die();
    }

    // Process the image and insert data into the database
    $time = time();
    $img_name = $time . $img['name'];
    $img_tmp_name = $img['tmp_name'];
    $img_destination_path = '../img_uploads/' . $img_name;

    if(move_uploaded_file($img_tmp_name, $img_destination_path)){
        // Image upload successful
        $insert = mysqli_query($db_connect, "INSERT INTO `articles` (user_id, article_title, article_content, article_img)
        VALUES ($user_id, '$title', '$content', '$img_name')") or die('Query failed');

        if($insert){
            $error[] = "New post added successfully";
            header('location: manage-articles.php');
            die();
        } else {
            $error[] = " Article insertion failed";
        }
    } else {
        $error[] = "Image upload failed";
    }

};
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
                <li></li>

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
                <form action="" method="POST" enctype="multipart/form-data">
                    <label for="author_name">Username:</label>
                    <input type="text" id="author_name" name="author_name" required>

                    <label for="article_title">Article Title:</label>
                    <input type="text" id="article_title" name="article_title" required>

                    <label for="article_text">Article Text:</label>
                    <textarea id="article_text" name="article_text" rows="10" required></textarea>

                    <div class="form_control inline">
                        <input type="checkbox" id="publish" value="1" name="publish"checked>
                        <label for="publish" ></label>
                    </div>
                    <div class="form_control">
                        <label for="img"> Add Image </label>
                        <input type="file" id="img" name="img">
                    </div>
                    <input type="submit" name="submit" value="Upload Post" class="btn">
                </form>
            </div>
    </body>
</html>

