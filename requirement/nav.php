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
<body ">
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
    {
        $loggedin=true;
    }
    else
    {
        $loggedin=false;
    };
    echo 
    '<div class="bg-blue-600  w-full h-16">
    <ul class="flex flex-row items-center justify-around text-white">
    <li><img src="./img/logo.png" alt="logo"></li>
    <li><a href="./welcome.php">Home</a></li>';
    if(!$loggedin)
    {
        echo
            '<li><a href="./login.php">Login</a></li>
            <li><a href="./register.php">Register</a></li>';
    }
            if($loggedin)
            {  
              echo '
              <li><a href="./logout.php">Logout</a></li>';
            }
        echo    
        '</ul>
    </div>';
    ?>
</body>
</html>