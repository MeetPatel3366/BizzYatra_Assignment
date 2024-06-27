<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat App</title>
  <link rel="stylesheet" href="./src/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
      $loggedin=true; 
    } else {
      $loggedin=false;
    };
    echo
    '<div class="w-full bg-blue-700 h-16">
      <ul class="flex flex-row items-center justify-around text-white">
      <li><img src="./img/logo.png" alt="logo" class="pt-1"></li>';
      ; 
      if(!$loggedin) {
        echo
        '<li><a href="./login.php" class="hover:text-yellow-200 hover:border-2 hover:p-2 hover:border-neutral-200 font-bold">Login</a></li>
        <li><a href="./register.php" class="hover:text-yellow-200 hover:border-2 hover:p-2 hover:border-neutral-200 font-bold">Register</a></li>'; 
      } else {
        echo '<li><a href="./welcome.php" class="hover:text-yellow-200 hover:border-2 hover:p-2 hover:border-neutral-200 font-bold">Home</a></li>';
        echo '<li><a href="./friend.php" class="hover:text-yellow-200 hover:border-2 hover:p-2 hover:border-neutral-200 font-bold">My Friends</a></li>';
        echo '<li><a href="./addfriend.php" class="hover:text-yellow-200 hover:border-2 hover:p-2 hover:border-neutral-200 font-bold">Add Friends</a></li>';
        echo '<li><a href="./friendrequest.php" class="hover:text-yellow-200 hover:border-2 hover:p-2 hover:border-neutral-200 font-bold">Friend Requests</a></li>';
        echo '<li><a href="./chating.php" class="hover:text-yellow-200 hover:border-2 hover:p-2 hover:border-neutral-200 font-bold">Friend Message</a></li>';
        echo '<li><a href="./logout.php" class="hover:text-red-600 hover:border-2 hover:p-2 hover:border-neutral-200 font-bold">Logout</a></li>';
    }
      echo 
      '</ul>
    </div>';
  ?>
</body>
</html>
