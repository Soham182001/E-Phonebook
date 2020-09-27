<?php
    session_start();
    $servername="localhost";
    $username="root";
    $password="sohammedewar";
    $dbname="Users";
    $conn=new mysqli($servername,$username,$password,$dbname);
    if($conn->connect_error){
      die("connection failed");
    }
    if(isset($_GET['delete'])){
        $accnum=$_SESSION["Accountno"];
        $number=$_GET['delete'];
    }
    $status=0;
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $acc=$_POST["accnt"];
        $pers=$_POST["person"];
        $sql="DELETE FROM alcontacts WHERE accountno='$acc' AND contactno='$pers'";
        if($conn->query($sql)===TRUE){
            $status=1;
        }else{
            $status=2;
        }
    }
?>
<html>
    <head>
        <title>Phone Book</title>
        <meta charset="utf-8">
		<!--the meta charset="utf-8" is used for HTML5-->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- ths thing is used for mobile-first-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="dist/sweetalert.js"></script>
        <link rel="stylesheet" href="dist/sweetalert.css">
        <script type="text/javascript">
            function deletee(){
                swal({
                    title:"Delete the contact",
                    imageUrl:"delete.png",
                    text:"Are you sure you want to delete the contact?",
                    text:"<form method = 'POST' action='<?php echo $_SERVER['PHP_SELF']; ?>'><input type='hidden' name='accnt' value='<?php echo $accnum;?>'><input type='hidden' name='person' value='<?php echo $number;?>'><br><br><input type='submit' class='btn btn-info' name='delete' value='Delete'></form>",
                    html: true,
                    showCancelButton:true,
                    showConfirmButton:false,
                    closeOnCancel:false,
                    confirmButtonClass: "btn-success",
                    cancelButtonClass: "btn-danger",
                },
                function(inputValue){
                    if(inputValue==false){
                        window.location.replace("afterlogin.php");    
                    }
                });
            }
        </script>    
    </head>
    <body style="background-color:rgba(180, 180, 180, 0.7);">
        <div>
		    <div class="mx-auto text-center">
                <button onclick="deletee()" class="btn btn-primary " style="display: inline-block; margin-left: auto; margin-right: auto; margin-top: 300px; padding: 50px; border-radius: 20px;">Delete Contact</button><br><br>
                <p><b>Click to delete the selected contact.<b></p>
		    </div>
        </div>
        <script type="text/javascript">
            var x=  "<?php echo "$status" ?>";
            if(x==1){
                swal({
                    title: "Contact Deleted",
                    text: "You will be soon redirected to mainpage...",
                    imageUrl:"checked.png",
                    showConfirmButton: false,
                });
                setTimeout(function(){
                    window.location.replace("afterlogin.php");
                }, 2000);
            }else if(x==2){
                swal({
                    title: "Contact Not Deleted",
                    imageUrl:"quit.png",
                    text: "You will be soon redirected to mainpage....",
                    showConfirmButton: false,
                });
                setTimeout(function(){
                    window.location.replace("afterlogin.php");
                }, 2000);
            }
        </script>
    </body>
</html>                                                                                                                                                                                                                          