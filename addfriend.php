<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location:login.php");
    exit();
}
if (isset($_POST['add_friend'])) {
    include './requirement/dbconnect.php';
    $sender = $_SESSION['email'];
    $receiver = $_POST['email'];
    $status = "pending";
    
    // Check if a friend request has already been sent
    $checkRequest = "SELECT * FROM `friend_request_receive` WHERE `sender`='$sender' AND `reciver`='$receiver'";
    $checkResult = mysqli_query($conn, $checkRequest);
    
    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        // Friend request already sent
        echo "<p class='w-full text-center p-3 bg-slate-900 text-yellow-500'>Friend request already sent to : $receiver</p>";
    } else {
        // Send friend request
        $sql = "INSERT INTO `friend_request_receive` (`sender`, `reciver`, `status`, `time`) VALUES ('$sender', '$receiver','$status', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        
        if ($result) {
            echo "<p class='w-full text-center p-3 bg-slate-900 text-green-500'>Friend request sent to : $receiver</p>";
        }
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
    $current_user = $_SESSION['email'];
    $allUsers = "SELECT * FROM `users` WHERE `email`!='$current_user'";
    $result = mysqli_query($conn, $allUsers);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        $n=0;
        echo "<p class='font-bold'>ALL Users : </p>";
        echo "<table class='border-separate text-xl'>";
        echo "<thead class='bg-slate-900 text-white font-bold'><tr><th class='py-3'>Email</th><th class='py-3'>Action</th></tr></thead>";
        echo "<tbody >";
        while ($row = mysqli_fetch_assoc($result)) {
            
            // Check if the user is already friends
            $checkFriend = "SELECT * FROM `friend` WHERE (`user_email` = '$current_user' AND `friend_email` = '{$row['email']}') 
                OR (`user_email` = '{$row['email']}' AND `friend_email` = '$current_user')";
            $checkFriendResult = mysqli_query($conn, $checkFriend);

            if ($checkFriendResult && mysqli_num_rows($checkFriendResult) > 0) {
                continue;
            }
            $n=$n+1;
            
            echo "<tr class='bg-gray-200'>";
            echo "<td class='px-28'>" . $row['email'] . "</td>";
            echo "<td>
                    <form method='post'>
                        <input type='hidden' name='email' value='" . $row['email'] . "'>";
                        // Check if friend request already sent
                        $checkRequestSql = "SELECT * FROM `friend_request_receive` WHERE `sender`='$current_user' AND `reciver`='" . $row['email'] . "'";
                        $checkRequestResult = mysqli_query($conn, $checkRequestSql);
                        if ($checkRequestResult && mysqli_num_rows($checkRequestResult) > 0) {
                            // Friend request already sent
                            echo "<input type='submit' value='Pending' disabled class='bg-gray-500 mx-16 my-3 p-2 rounded text-white'>";
                        } else {
                            // Friend request not sent
                            echo "<input type='submit' value='Add Friend' name='add_friend' class='bg-blue-700 mx-16 my-3 p-2 rounded text-white'>";
                        }
            echo "</form>
                </td>";
            echo "</tr>";
        }
        echo $n;
        echo "</tbody>";
        echo "</table>";
    }
?>
</body>
</html>
