<?php
include './requirement/dbconnect.php';
include './requirement/nav.php';

if(isset($_GET['code'])) {
    $verificationCode = $_GET['code'];
    // echo $verificationCode;
    $query = "UPDATE users SET verified='1' WHERE verificationCode= '$verificationCode'";

    $result = mysqli_query($conn, $query);
    
    if($result && mysqli_affected_rows($conn) > 0) {
        
        echo "<img src='./img/verification.png' width='50px'>";
        echo "<br>";
        echo "<p class='text-center font-bold'>Email verification successful ! You can now login.</p>";

    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Invalid verification code.";
}
?>
