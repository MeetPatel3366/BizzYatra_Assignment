<?php
include './requirement/nav.php';
// Include database connection
include './requirement/dbconnect.php';

if(isset($_GET['code'])) {
    $verificationCode = $_GET['code'];
    echo $verificationCode;
    $query = "UPDATE users SET verified='1' WHERE verificationCode= '$verificationCode'";

    $result = mysqli_query($conn, $query);
    
    if($result && mysqli_affected_rows($conn) > 0) {
        
        echo "Email verification successful ! You can now login.";

    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Invalid verification code.";
}
?>
