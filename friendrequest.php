<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location:login.php");
    exit();
}
if(isset($_POST['accept_friend'])) {
    include './requirement/dbconnect.php'; 
    $current_user = $_SESSION['email'];
    $requsted_email = $_POST['sender_email']; 
    $user_name="";
    $friend_name="";

    $userSql="SELECT name FROM users WHERE email='$current_user'";
    $result = mysqli_query($conn, $userSql);
    if($result)
    {
        $row = mysqli_fetch_assoc($result);
        $user_name = $row['name'];
    }
    $friendSql="SELECT name FROM users WHERE email='$requsted_email'";
    $result = mysqli_query($conn, $friendSql);
    if($result)
    {
        $row = mysqli_fetch_assoc($result);
        $friend_name = $row['name'];
    }

    $sql="INSERT INTO `friend`(`user_name`, `friend_name`, `user_email`, `friend_email`) VALUES  ('$user_name','$friend_name','$current_user', '$requsted_email')";
    $result=mysqli_query($conn,$sql);

    if($result)
    {   
        $dsql="DELETE FROM `friend_request_receive` WHERE `sender`='$requsted_email' AND `reciver`='$current_user'";
        $dresult=mysqli_query($conn,$dsql);
        if($dresult)
        {
        echo "<p class='w-full text-center p-3 bg-slate-900 text-green-500'>Accepted friend request from: $friend_name</p>";  
        }
    }
} 

if(isset($_POST['reject_friend'])) {
    include './requirement/dbconnect.php'; 
    $requsted_email = $_POST['sender_email']; 
    $current_user = $_SESSION['email'];
    $user_name="";
    $friend_name="";

    $userSql="SELECT name FROM users WHERE email='$current_user'";
    $result = mysqli_query($conn, $userSql);
    if($result)
    {
        $row = mysqli_fetch_assoc($result);
        $user_name = $row['name'];
    }
    $friendSql="SELECT name FROM users WHERE email='$requsted_email'";
    $result = mysqli_query($conn, $friendSql);
    if($result)
    {
        $row = mysqli_fetch_assoc($result);
        $friend_name = $row['name'];
    }

    $sql="DELETE FROM `friend_request_receive` WHERE `sender`='$requsted_email' AND `reciver`='$current_user'";
    $result=mysqli_query($conn,$sql);
    
    if($result)
    {
        echo "<p class='w-full text-center p-3 bg-slate-900 text-red-500'>reject friend request from: $friend_name</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body class="flex flex-col items-center">
<?php include './requirement/nav.php';?>
<?php
    include './requirement/dbconnect.php';
    $current_user=$_SESSION['email'];
    $received_request="SELECT DISTINCT sender_name,sender FROM `friend_request_receive` WHERE `reciver`='$current_user'";
    $result=mysqli_query($conn,$received_request);
    $num = mysqli_num_rows($result);
    if($num>0)
    {
        echo "<p class='font-bold'>Received Requests : " .$num ."</p>";
        echo "<table class='border-separate text-xl'>";
        echo "<thead class='bg-slate-900 text-white font-bold '><tr><th class='py-3'>From</th><th colspan='2' class='py-3'>Action</th></tr></thead>";
        echo "<tbody >";
        while($row = mysqli_fetch_assoc($result)) {
        echo "<tr class='bg-gray-200'>";
        echo "<td class='px-28'>" . $row['sender_name'] . "</td>";
        echo "<form method='post'>";
        echo "<input type='hidden' name='sender_email' value='".$row['sender']."' >";
        echo "<td>";
        echo "<input type='submit' value='Accept' name='accept_friend' class='bg-blue-700 p-2 mx-16 my-3 text-white rounded'>";
        echo "</td>";
        echo "<td>";
        echo "<input type='submit' value='Reject' name='reject_friend' class='bg-red-700 p-2 mx-16 text-white rounded'>";
        echo "<td>";
        echo "</form>";
        echo "</tr>";
        echo "</tbody>";
    }
    }
    ?>
</body>
</html>