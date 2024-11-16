<?php
include 'config/db_connection.php';
session_start();

 if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($db_connect, $_POST['email']);
    $pass = md5($_POST['password']);

    $select = "SELECT * FROM `users` WHERE email = '$email' && password = '$pass'";
    $result = mysqli_query($db_connect, $select);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        if($row['is_confirmed'] == 1){
            if($row['role'] == 'author'){
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['role'] = $row['role'];
                header('location:author/manage-articles.php');
                exit;

            }else if($row['role'] == 'user'){
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['role'] = $row['role'];
                header('location:vblog.php');
                exit;
            }
        }else{
            $error[] = 'Your email has not been  confirmed. Please check your email and confirm your registration.';
        }
        
    }else{
        $error[] = 'incorrect email or password';
    }
 };

include 'navigations/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        
            <section class="reg01">
                <div class="combined">
                    
                    <div class="contained">
                        <h2>Login Here</h2>

                        <?php
                        if(isset($error)){
                            foreach($error as $error){
                                echo '<span class="error-msg">'.$error.'</span>';
                            }
                        }
                        ?>
            
                        <form  action="" method="post">
                            
                            <div class="form-group">
                                <input type="email" name="email"required>
                                <span></span>
                                <label>Email</label>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password"required>
                                <span></span>
                                <label>Password</label>
                            </div>

                            <input type="submit" name="submit" value="Login">
                            <div class="login-link">
                                <p>don't have an account? <a href="sign_up.php">Sign-up here</a></p>
                            </div>
                        </form>
                        
                    </div>
                    <div class="hoodie-img01">
                    <img src="https://xcdn.next.co.uk/COMMON/Items/Default/Default/ItemImages/AltItemZoom/259837s.jpg">
                    </div>
                </div>        
            </section>
        
    </div>

</body>
</html>