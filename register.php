<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./src/style.css">
</head>
<body class="flex w-full h-full flex-col items-center justify-center">
    <?php include './requirement/nav.php'; ?>
    <?php
    $showError=false;
    $showAlert=false;

    function generateVerificationCode() {
        return rand(1,10000);
    }

    if(isset($_POST['register']))
    {
        include './requirement/dbconnect.php';
        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $hash=password_hash($password, PASSWORD_DEFAULT); 
        // password_hash: This is a PHP function used for hashing passwords.
        // $password: This is the plaintext password that you want to hash.
        // PASSWORD_DEFAULT: This is a constant that specifies the default hashing algorithm to be used. 
        $verificationCode = generateVerificationCode();

        //check where this username exists
        $existSql="select * from users where email='$email'";
        $result=mysqli_query($conn,$existSql);
        // $result: This variable stores the result of the query execution.
        // mysqli_query(connection, query)
        // $result contains either true or false
        $numExistRows=mysqli_num_rows($result);
        // check how many rows were returned by the executed SQL query stored in $result
        if($numExistRows>0)
        {
            $exist=true;
            $showError="email is already exists";
        }
        else
        {
            $exist=false;
            if(($password==$cpassword))
            {
                $sql="INSERT INTO `users`( `email`, `name`, `password`, `date`, `verificationCode`,`verified`) VALUES  ('$email', '$name', '$hash', current_timestamp(),'$verificationCode','0')";
                $result=mysqli_query($conn,$sql);
                if($result)
                {
                    $showAlert=true;
                }
                $to = $email;
                $subject = "Verify Your Email";
                $message = "$name , Click the link below to verify your email:\n\n";
                $message .= "http://localhost/bizzYatra/Phase2_CRUD/BizzYatra_Assignment/verify.php?code=$verificationCode";
                $headers = "From: bestsquad11111@gmail.com";
        
                mail($to, $subject, $message, $headers);
        
                $showAlert ="Registration successful! Please check your email to verify your account.";
            }
            else
            {
                $showError="Password do not match.";
            }
        }
        mysqli_close($conn);
    }
    ?>
    <?php
     if($showAlert)
     {
        echo "<div><p>".$showAlert."</p></div>";
     }
     if($showError)
     {
        echo "<div><p>".$showError."</p></div>";
     }
    ?>
    <div class="flex w-80 bg-indigo-600 flex-col items-center mt-8 p-7 border rounded-lg font-medium">
    <h2 class=" font-bold text-2xl">Register</h2>
    <form method="post" action="register.php" class="flex flex-col gap-4 mt-8">
        <div class="flex flex-col gap-2">
        <label for="name">Name</label>
        <input type="name" name="name" id="name" placeholder="enter your name" maxlength="50" class="border rounded">
        </div>
        <div class="flex flex-col gap-2">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="enter your email" maxlength="50" class="border rounded">
        </div>
        <div class="flex flex-col gap-2">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="enter your password" maxlength="8" class="border rounded">
        </div>
        <div class="flex flex-col gap-2">
        <label for="cpassword">Confirm Password</label>
        <input type="password" name="cpassword" id="cpassword" placeholder="enter again password" class="border rounded">
        </div>
        <p>Make sure to type a same password</p>
        <input type="submit" value="Register" name="register" class="bg-sky-600 border rounded-md">
    </form>
    </div>
    <div>
    </div>
</body>
</html>