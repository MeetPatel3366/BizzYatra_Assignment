<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location:login.php");
    exit();
}
include './requirement/dbconnect.php';

$current_user = $_SESSION['email'];
$user_name="";

$userSql="SELECT name FROM users WHERE email='$current_user'";
$result = mysqli_query($conn, $userSql);
if($result)
{
    $row = mysqli_fetch_assoc($result);
    $user_name = $row['name'];
}

if(isset($_POST['msg']) && isset($_POST['name']) && isset($_POST['friend'] )) {
    $msg = $_POST['msg'];
    $user_email = $current_user;  
    $friend_name=$_POST['friend'];
    $friend_email=$femail;
    

    $sql = "INSERT INTO chat (`user_name`, `friend_name`, `message`, `user_email`, `friend`, `time`) VALUES ('$user_name','$friend_name','$msg','$user_email', '$friend_email',current_timestamp())";
    mysqli_query($conn, $sql);
    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
    <link rel="stylesheet" href="./src/my.css">
    <title>Document</title>
</head>
<body>
<?php include './requirement/nav.php';?>
<?php include './requirement/dbconnect.php';?>

<div class="flex flex-row gap-2 m-2 h-fit" id="main">
    <div>
<?php

$current_user = $_SESSION['email'];

$accepted_friends = "SELECT `friend_email`,`friend_name` FROM `friend` WHERE `user_email` = '$current_user' UNION SELECT `user_email`,`user_name` FROM `friend` WHERE `friend_email` = '$current_user'";

$result = mysqli_query($conn, $accepted_friends);
$num = mysqli_num_rows($result);
if (mysqli_num_rows($result) > 0) {
    echo "<p class='font-bold'>My Friends: " . $num . "</p>";
    echo "<table class='border-separate text-xl'>";
    echo "<thead class='bg-slate-900 text-white font-bold'><tr><th class='py-3'>Friend Name</th></tr></thead>";
    echo "<tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr class='bg-gray-200'>";

        echo "<td>
                  <form method='post'>
                      <input type='hidden' name='friend' value='" . $row['friend_name'] . "'>
                      <input type='submit' value='".$row['friend_name']."' name='friend' class='bg-sky-700 mx-16 my-3 p-2 rounded font-bold'>
                    </form>
                  </td>";
                  echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}
?>
</div>
<div class="w-full">
<div id="msg_box" class="overflow-auto p-2 bg-slate-800 h-[78vh] flex flex-col">
<?php
if(isset($_POST['friend'])) {
    $uname = $_SESSION['email'];
    $friend = $_POST['friend'];
    $show = "SELECT * FROM chat WHERE (user_name='$user_name' AND friend_name='$friend') OR (user_name='$friend' AND friend_name='$user_name')";
    $result = mysqli_query($conn, $show);
    echo "<div class=' text-white relative mb-6 h-fit chat-container' id='msgs' >";
    echo "<p class='sticky top-0 z-10 mt-5 font-bold bg-slate-800 text-white text-2xl p-2 text-center rounded-md'>".$friend."</p>";
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        $row = mysqli_num_rows($result);
        if ($row > 0) { 
            while ($row = mysqli_fetch_assoc($result)) {
                if($row['user_email'] != $_SESSION['email'])
                {
                    // echo "<br><b><div class='inline-block text-right  bg-blue-500  p-2 m-5 rounded absolute >" . $row['uname'] . " : </b> " . $row['message'] . "<br>" . $row['time'] . "</div><br><br>";
                    echo "<br><br><div class='bg-blue-500 inline-block text-right m-5 p-2 rounded absolute text-white '>";
                    echo $row['user_name']."<br>" ;
                    echo $row['message']."<br>" ;
                    echo $row['time']."<br>";
                    echo "</div><br><br>";
                    echo "<br>";
                }
                else
                {
                    // echo "<br><b><div class='text-white  mb-2 bg-green-500 inline-block  p-2 m-5 rounded absolute right-6'>" . $row['uname'] . " : </b> " . $row['message'] . "<br>" . $row['time'] . "</div><br><br>";
                    echo "<br><b><div class='bg-green-500 inline-block p-2 m-5 text-white rounded absolute right-6 mb-2'>";
                    echo  $row['user_name']."<br></b>" ;
                    echo $row['message']."<br>" ;
                    echo $row['time']."<br>";
                    echo "</div><br><br>";
                    echo "<br>";
                }
                
            }
        } else {
            echo "No messages found.";
        }
    }
    echo "<br>";
    echo "<br>";
    if(isset($_POST['friend']))
    { 
    echo'<div class="fixed p-3 bg-slate-900 mb-3 inset-x-0 bottom-0 w-full text-right text-black">
            <input type="text" id="msg" class="border rounded p-2 w-[40vw] " placeholder="Enter Message">
            <input type="button" id="btn" name="send" value="Send" class="bg-sky-600 border rounded-md p-2 font-bold">
        </div>';
    }}
    // echo "</div>"; 
    
    ?>
    </div>
</div>
 
 <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
 <script>
     var conn = new WebSocket('ws://localhost:8081');
     let name = "<?php echo $user_name?>";
     let friend = "<?php echo $_POST['friend']?>";
     let time=new Date().toLocaleTimeString();
    conn.onopen = function(e) {
        console.log("Connection established!");
        conn.send(JSON.stringify({
            type:'register',
            name:name,
            friend:friend
        }));
    };

    conn.onmessage = function(e) {
        let getData = JSON.parse(e.data);
        let time = new Date().toLocaleTimeString(); // Assuming 'time' is defined
        console.log(getData);
        let h = '<div class="text-white bg-blue-500 w-fit p-3 ml-4 rounded-lg"><b>' + getData.name + '</b>: ' + getData.msg + '<br>' + time + '</div><br>';
        // let html = '<b>' + getData.name + '</b>: ' + getData.msg + '<br>';
        $('#msgs').append(h);
    };



    jQuery('#btn').click(function(e) {
        let msg = jQuery('#msg').val();
        let name = "<?php echo $user_name?>";
        let friend = "<?php echo $_POST['friend']?>";
      
        let content = { 
            type:'message',
            msg: msg, 
            name: name,
            friend: friend,
        };
        conn.send(JSON.stringify(content));
        
        $.ajax({
            url: 'chating.php',
            type: 'POST',
            data: { msg: msg, name: name,friend: friend},
            success: function(response) {
                console.log("messsage sent");
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        });
        let html = "<br><div class='text-white inline-block w-fit bg-green-500 h-fit p-2 mb-2 rounded absolute right-7'>" +"<b>" + name + ":</b> " + msg + "<br>" + time +"</div><br><br><br>";

        $('#msgs').append(html);         
    }); 
    
</script>
</div>
</div>

</body>
</html>
