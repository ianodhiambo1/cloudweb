<?php 
require_once '../../config/db_connection.php';
require_once '../sendMail.php';

class Registration{
    private $db_connect;

    public function __construct($db_connect) {
        $this->db_connect = $db_connect;
    }

    public function registerUser($Fname, $Lname, $name, $email, $pass, $cpass, $role){
  
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $Fname = mysqli_real_escape_string($this->db_connect ,$_POST['Fname']);
            $Lname = mysqli_real_escape_string($this->db_connect, $_POST['Lname']);
            $name = mysqli_real_escape_string($this->db_connect, $_POST['username']);
            $email = mysqli_real_escape_string($this->db_connect, $_POST['email']);
            $pass = md5($_POST['password']);
            $cpass = md5($_POST['cpassword']);
            $role = ($_POST['role']);

            $token = bin2hex(random_bytes(32)); 
            $token_expiry = date("Y-m-d H:i:s", strtotime("+24 hours"));

            //retrieve data to confirm if user exists
            $select = "SELECT * FROM users WHERE email = '$email'";

            $result = mysqli_query($this->db_connect, $select);

            $error = array();

            if (mysqli_num_rows($result) > 0) {
                $error[] = 'User already exists!';
            } else {
                if ($pass != $cpass) {
                    $error[] = 'Password not matched!';
                } else {
                    $insert = "INSERT INTO users(Fname, Lname, username, email, password, role,  token, token_expiry, is_confirmed) VALUES ('$Fname', '$Lname', '$name', '$email', '$pass',  '$role', '$token', '$token_expiry', 0)";
                    if (mysqli_query($this->db_connect, $insert)) {
                        header('location: confirmation.php');
                    } else {
                        $error[] = 'Error while inserting data: ' . mysqli_error($this->db_connect);
                    }
                }
            }
            
            return $error;

        }
    }
}

$registration = new Registration($db_connect);

$errorMessages = $registration->registerUser($Fname, $Lname, $name, $email, $pass, $cpass, $role);

if(!empty($errorMessages)){
    foreach ($errorMessages as $error) {
        echo '<span class="error-msg">' . $error . '</span>';
    }
}

mysqli_close($db_connection);

?>