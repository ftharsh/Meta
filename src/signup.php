<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Meta Search Engine </title>
    <link rel="stylesheet" href="index.css"/>
</head>
<body>
    <nav>
        <div class="logo">
            <h1  class="rtmse"> <a href="index.html"><b>Real-time Meta Search</b></a></h1>
        </div>
        <ul>
            <li><a href="#"> Home </a></li>
            <li><a href="#"> About </a></li>
            <button class="sign-btn"><a href="signup.php"> Sign-up </a></button>
            <button class="sign-btn"><a href="login.php"> Log-in </a></button>
        </ul>
    </nav>
    <main>
        <h1 class="signup-text"> Sign-Up  <br></h1>
		<form method="post" action="signup.php">
            <div class="signup-form">
                <br><br><h3>Name:<br>
                <input class="input-bar"  name="name"  type="text" placeholder="Name ">
                <br><br>Username:<br>
                <input  class="input-bar"  name="uname"  type="text"  placeholder="Username ">
                <br><br>Password:<br>
                <input class="input-bar"  name="password"  type="password"  placeholder="Password ">
                <br><br>Confirm Password :<br>
                <input  class="input-bar"   name="cpassword"  type="password"   placeholder="Re-Enter Password ">
                <br><br> <br> <button class="signup-button" type=submit><b>Sign-Up</button>  
                <button class="reset-form"><a href="signup.php">Reset</a></b></button>
            </div>
            <div class="phpresults">
            <?php
                include 'dbconnect.php';
                    if($_SERVER["REQUEST_METHOD"]=="POST"){
                        $name=$_POST['name'];
                        $usernamee=$_POST['uname'];
                        $passwordd=$_POST['password'];
                        $cpassword=$_POST['cpassword'];
                        $x=1;
                        if(!empty($name) && !empty($usernamee) && !empty($passwordd) && !empty($cpassword)){
                        if($cpassword==$passwordd){
                            try{
                            $query="INSERT INTO users 
                                    VALUES('$name','$usernamee','$passwordd','$cpassword')";
                                    $results=mysqli_query($conn,$query);
                            }
                            catch(mysqli_sql_exception $e){
                                    if($e->getCode()==1062){ //1062 is error code for duplicacy
                                        $x=0;
                                        echo"<h4> ❌ Username Already Exists !  </h4>";
                                    }
                                    
                                    /*if(!mysqli_query($conn,$query))
                                    {
                                        echo"<h4> Username Already Exists  : </h4>";

                                    }
                                    else{
                                    $results=mysqli_query($conn,$query);
                                echo "<h4> Registration Successful </h4> ";
                        }*/

                        }
                        if($x==1){
                            echo "<h4> ✅ Registration Successful ! </h4>";
                        }
                    }
                        else{
                            echo "<h4> ❓ Password Did not match ! <h4>";
                        }
                    }
                    else{
                        echo" <h4> ❗Please Enter correct details <h4>";
                    }
                }
                ?>
                </div>
            </main>

</body>
</html>