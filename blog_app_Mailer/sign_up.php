
<?php 
include 'navigations/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-up page</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="main">
            <section class="reg01">
                <div class="combined01">
                    
                    <div class="contained">
                        <h2>SIGN UP</h2>

                        <?php
                        if(isset($error)){
                            foreach($error as $error){
                                echo '<span class="error-msg">'.$error.'</span>';
                            }
                        }
                        ?>

                        <?php 
                        //check if 'msg' parameter is set in the URL
                        if (isset($_GET['msg'])){
                            $msg = $_GET['msg'];
                            echo '<P class="success-msg">' . htmlspecialchars($msg) . '</p>';
                        }
                        ?>
            <form action="src/RegProcesses/process_signup.php" method="post">

                           <div class="form-group">
                                <input type="text" name="Fname" required>
                                <span></span>
                                <label>First name</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="Lname" required>
                                <span></span>
                                <label>Last name</label>
                            </div>
                            <div class="form-group">
                                <input type="text" name="username" required>
                                <span></span>
                                <label>Username</label>
                            </div>
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
                            <div class="form-group">                                    
                                <input type="password" name="cpassword"required>
                                <span></span>
                                <label>Confirm Password</label>
                            </div>
                            <div class="form-group">
                                <select name="role">
                                    <option value="user">user</option>
                                    <option value="author">author</option>
                                </select>
                            </div>
                            <input type="submit" name="submit" value="Sign Up">
                            <div class="login-link">
                                <p>Already have an account? <a href="sign_in.php">Log-in here</a></p>
                            </div>
                        </form>
                        
                    </div>
                    <div class="hoodie-img01">
                    <img src="https://images.sportsdirect.com/images/imgzoom/53/53602403_xxl.jpg">
                    </div>
                </div>        
            </section>
        </div>
    </div>

</body>
</html>