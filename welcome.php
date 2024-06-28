<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location:login.php");
    exit();
}
if(isset($_POST['delete'])) {
    include './requirement/dbconnect.php'; // Assuming you have dbconnect.php which contains database connection
    $email = $_SESSION['email'];

    $delSql = "DELETE FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $delSql);
    if($result) {
        header("location:login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/style.css">
    <title>Welcome></title>
</head>
<body class="flex flex-col items-center">
    <?php include './requirement/nav.php';?>
    <div class="flex justify-center items-center gap-2">
    <div>
        <p class="mt-2">Welcome - 
        <?php 
            include './requirement/dbconnect.php'; 
            $email = $_SESSION['email'];
            $userSql="SELECT name FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $userSql);
            if($result)
            {
                $row = mysqli_fetch_assoc($result);
                $name = $row['name'];
                echo $name;
            }
        ?>
        </p>
        <br>
        <br>
        <br>
        <br>
        <form method="post">
            <input type="submit" value="Delete My Account" name="delete" class="bg-red-700 text-white p-2">
        </form>
        <br>
    </div>
    <div class="w-96">
        <img src="./img/chat.jpg" alt="">
    </div>
    </div>
    
    
</body>
</html>
