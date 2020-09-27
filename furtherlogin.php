<?php
    $servername="localhost";
    $username="root";
    $password="sohammedewar";
    $dbname="Users";
    $conn=new mysqli($servername,$username,$password,$dbname);
    if($conn->connect_error){
      die("connection failed");
    }
    $status2=0;
    if($_SERVER['REQUEST_METHOD']=="POST"){
      $name=$_POST['Name'];
      $password1=$_POST['Password'];
      $mdp=md5($password1);
      $mdu=md5($name);
      $sql="SELECT * FROM usrpaswd;";
      $result=$conn->query($sql);
      if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          if($row['md5username']==$mdu){
            $status2=1;
            $accno=$row['mobnum'];
            $yourmail=$row['email'];
            break;
          }
        }
      }
      if($status2==1){
        $sql="SELECT * FROM usrpaswd;";
        $result=$conn->query($sql);
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){
            if($row['md5pass']==$mdp){
              $status2=2;
            }
          }
        }
      }
    }
    session_start();
?>
<html>
<title>Phone Book</title>
        <script src="dist/sweetalert.js"></script>
        <script src="dist/sweetalert.min.js"></script>
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
        <?php
          $_SESSION["Username"]=$name;
          $_SESSION["Accountno"]=$accno;
          $_SESSION["yourEmail"]=$yourmail;
        ?>
        <script type="text/javascript"> 
        var b = "<?php echo"$status2"?>";
        if(b==0){
        swal("Error!", "Invalid user name!", "warning");
        setTimeout(function(){
            window.location.replace('index.html');
         }, 750);
        }else if(b==1){
        swal("Error!", "Incorrect password!", "error");
        setTimeout(function(){
            window.location.replace('index.html');
         }, 750);
        }else if(b==2){
        swal("Success","Successfully logged in!", "success");
        setTimeout(function(){
            window.location.replace("afterlogin.php");
         }, 750);
        }
    </script>
    </body>
</html>