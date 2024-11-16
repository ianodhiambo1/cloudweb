
<?php 
require_once '../../config/db_connection.php';


class EmailConfirmation {
    private $db_connect;

    public function __construct($db_connect){
        $this->db_connect = $db_connect;

    }

    public function confirmEmail($token){
        $sql = "SELECT * FROM users WHERE token = ?";
        $stmt = $this->db_connect->prepare($sql);
    
        if ($stmt) {
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
    
                // Update the token to a new value "destroying it in a way"
                $newToken = bin2hex(random_bytes(32)); 
    
                $updateSql = "UPDATE users SET is_confirmed = 1, token = ? WHERE user_id = ?";
                $updateStmt = $this->db_connect->prepare($updateSql);
    
                if ($updateStmt) {
                    $updateStmt->bind_param("si", $newToken, $user['user_id']);
                    if ($updateStmt->execute()) {
                        return "Your email has been successfully confirmed. Proceed to log in";
                    } else {
                        return "Error confirming your email. Please try again later.";
                    }
                } else {
                    return "Error updating account status. Please try again later.";
                }
            } else {
                return "Invalid or expired confirmation link.";
            }
        } else {
            return "Database query error. Please try again later.";
        }
    }
}
    
if(isset($_GET['token'])){
    $token = $_GET['token'];
    $emailConfirmation = new EmailConfirmation($db_connect);
    $message = $emailConfirmation->confirmEmail($token);
}else{
    $message = "Invalid cofirmation link";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Confirmation</title>
</head>
<body>
    <div>
        <p><?php echo $message; ?></p>
        <?php
        //only show the link to the sign in page when the email confirmation was a success
        if(strpos($message, "successfully confirmed") !== false){
       echo '<p><a href="../../sign_in.php">Go to Login</a></p>';
        }
        ?>

    </div>
</body>
</html>
