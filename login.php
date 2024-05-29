<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./src/style.css">
</head>
<body class="flex w-full h-full flex-col items-center justify-center">
    <?php include './requirement/nav.php';?>
    
    <?php
    $login=false;
    $showError=false;
    
    if(isset($_POST['login']))
    {
        include './requirement/dbconnect.php';
        $email=$_POST['email'];
        $password=$_POST['password'];
        $exist=false;
    
            // $sql="select * from users where email='$email' AND password='$password'";
            $sql="select * from users where email='$email'";
            $result=mysqli_query($conn,$sql);
            $num=mysqli_num_rows($result);
            if($num==1)
            {
                while($row=mysqli_fetch_assoc($result))
                {
                    if(password_verify($password,$row['password']))
                    {
                        if($row['verified'] == 1)
                        {
                            $login=true;
                            session_start();
                            $_SESSION['loggedin']=true;
                            $_SESSION['email']=$email;
                            header("location:welcome.php");
                            exit();
                        }   
                        else {
                            echo "Your account is not verified yet. Please check your email.";
                        } 
                    }
                    else
                    {
                        $showError="Invalid Passowrd";
                    }
                }
            }
            else
            {
                $showError="User Not Found";
            }
            mysqli_close($conn);
    }
    ?>
    <?php
     if($login)
     {
        echo "<div><p>Your are logged in.</p></div>";
     }
     if($showError)
     {
        echo "<div><p>".$showError."</p></div>";
     }
    ?>
    <div class="flex w-80 bg-indigo-600 flex-col items-center mt-8 p-7 border rounded-lg">
    <h2 class=" font-bold text-2xl">Login</h2>
    <form method="post" action="login.php" class="flex flex-col gap-4 mt-8 font-medium">
        <div class="flex flex-col gap-2">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="enter your email" class="border rounded">
        </div>
        <div class="flex flex-col gap-2">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="enter your password" class="border rounded">
        </div>
        <input type="submit" value="Login" name="login" class="bg-sky-600 border rounded-md">
    </form>
    </div>
    <div>
    </div>

</body>
</html>