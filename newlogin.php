<?php
    $servername="localhost";
    $username="root";
    $password="sohammedewar";
    $dbname="Users";
    $conn=new mysqli($servername,$username,$password,$dbname);
    if($conn->connect_error){
        die("connection failed");
    }
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $username1=$_POST['username'];
        $password1=$_POST['Password'];
        $confpass=$_POST['confpass'];
        $mobnum=$_POST['mobnumb'];
        $mail=$_POST['Mailid'];
        $status=0;
        $sql="SELECT * FROM usrpaswd;";
        $result=$conn->query($sql);
        if($result->num_rows > 0){
            while($row=$result->fetch_assoc()){
                if($row["username"]==$username1){
                    $status=3;
                }
            }
        }
        $sql="SELECT * FROM usrpaswd;";
        $result = $conn->query($sql);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                if($row["mobnum"]==$mobnum){
                    $status=8;
                }
            }
        }
        if($status!=3 && $status!=8){
            if(empty($username1)){
                $status=4;
            }
            elseif(empty($password1)){
                $status=5;
            }
            elseif(empty($confpass)){
                $status=6;
            }
            if($status==0){
                if($password1!=$confpass){
                    $status=2;
                }else{
                    if($status==0){
                        $mdpass=md5($password1);
                        $md5mobnum=md5($mobnum);
                        $md5user=md5($username1);
                        $sql="INSERT INTO usrpaswd(username,md5pass,mobnum,md5username,md5mobnum,email) VALUES('$username1','$mdpass','$mobnum','$md5user','$md5mobnum','$mail')";
                        if($conn->query($sql)===TRUE){
                            $status=1;
                        }else{
                            $status=7;
                        }
                    }
                }
            }
        }
    }
    $conn->close();
?>
<html>
    <head lang="en">
        <title>Phone Book</title>
        <script src="dist/sweetalert.js"></script>
        <link rel="stylesheet" href="newlogin.css">
        <link rel="stylesheet" href="dist/sweetalert.css">
        <meta charset="utf-8">
		<!--the meta charset="utf-8" is used for HTML5-->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- ths thing is used for mobile-first-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <header>
            <img src="icon.png" width="150px" height="150px">
            <sup><h3 class="heading">New User<br> Sign Up</h3></sup>
        </header> 
        <form method = "post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
            <div class="user">
                <img src="user-shape.png" height="15px" width="15px">
                <span>: </span>
                <input type="text" class="inputu" name="username" placeholder="Username">
            </div>
            <br>
            <div class="user">
                <img src="contact.png" height="15px" width="15px">
                <span>: </span>
                <input type="text" class="inputu" name="mobnumb" placeholder="Mobile Number">
            </div>
            <br>
            <div class="user">
                <img src="email.png" height="15px" width="15px">
                <span>: </span>
                <input type="text" class="inputu" name="Mailid" placeholder="E-mail">
            </div>
            <br>
            <div class="user">
                <img src="key.png" height="15px" width="15px">
                <span>: </span>
                <input type="password" class="inputu" name="Password" placeholder="Password">
            </div>
            <br>
            <div class="user">
                <img src="key.png" height="15px" width="15px">
                <span>: </span>
                <input type="password" class="inputu" name="confpass" placeholder="Confirm Password">
            </div>
            <br>
            <input class="ctrusr btnone" type="submit" name="createuser" value="Create User">
        </form>
        <button class="ctrusr btntwo" onclick="document.location='index.html'">LOGIN</button>
        <h1><script type="text/javascript"> 
            var x = "<?php echo "$status"?>";
            if(x==1){
                swal("Success!", "Your account has been created", "success");
            }else if(x==2){
                swal("Error!", "Both password doesn't match", "error");
            }else if(x==3){
                swal("Sorry!", "Username already taken.", "info");
            }else if(x==4){
                swal("Error!", "Username can't be empty." , "info");
            }else if(x==5){
                swal("Error!", "Password can't be empty.", "warning");
            }else if(x==6){
                swal("Error!", "Please verify your password", "error");
            }else if(x==7){
                swal("Error!", "Something went wrong.", "info");
            }else if(x==8){
                swal("Sorry!", "Mobile number is already registered.", "info");
            }
        </script></h1>
    </body>
</html>
