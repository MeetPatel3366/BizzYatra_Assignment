<?php
session_start();

if(isset($_POST['remove_friend']))
{
include './requirement/dbconnect.php';
$current_user=$_SESSION['email'];
$friend=$_POST['friend'];

// $sql= "DELETE FROM `friend` WHERE `user_email`= '$current_user' AND `friend_email` ='$friend'";
$sql="DELETE FROM `friend` WHERE (`user_email` = '$current_user' AND `friend_email` ='$friend') OR (`user_email` = '$friend' AND `friend_email` ='$current_user')";

    $result=mysqli_query($conn,$sql);
    
    if($result)
    {
        echo "<p class='w-full text-center p-3 bg-slate-900 text-red-500'>remove friend successfully : $friend</p>";
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
    <title>Document</title>
</head>
<body class="flex flex-col items-center">
<?php include './requirement/nav.php'; ?>
<?php
include './requirement/dbconnect.php';
$current_user = $_SESSION['email'];
$accepted_friends = "SELECT `friend_email` FROM `friend` WHERE `user_email` = '$current_user' UNION SELECT `user_email` FROM `friend` WHERE `friend_email` = '$current_user';
";
$result = mysqli_query($conn, $accepted_friends);
$num = mysqli_num_rows($result);
if (mysqli_num_rows($result) > 0) {
    echo "<p class='font-bold'>My Friends: " . $num . "</p>";
    echo "<table class='border-separate text-xl'>";
    echo "<thead class='bg-slate-900 text-white font-bold'><tr><th class='py-3'>Friend Email</th><th class='py-3'>Action</th></tr></thead>";
    echo "<tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr class='bg-gray-200'>";
        echo "<td class='px-28'>" . $row['friend_email'] . "</td>";
        echo "<td>
                  <form method='post'>
                      <input type='hidden' name='friend' value='" . $row['friend_email'] . "'>
                      <input type='submit' value='Remove Friend' name='remove_friend' class='bg-red-700 mx-16 my-3 p-2 rounded text-white'>
                  </form>
              </td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "You have no friends yet.";
}
?>

</body>
</html>