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
    <title>Welcome - <?php echo $_SESSION['email'];?></title>
</head>
<body class="flex flex-col items-center">
    <?php include './requirement/nav.php';?>
    <p class="mt-2">Welcome - <?php echo $_SESSION['email'];?></p>
    <br>
    <br>

   




    <br>
    <br>
    <form method="post">
        <input type="submit" value="Delete My Account" name="delete" class="bg-red-700 text-white p-2">
    </form>
    <br>
    
</body>
</html>
