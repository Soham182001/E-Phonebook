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
    $accno=$_SESSION["Accountno"];
    $status=0;
    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        $newaddname=$_POST["newname"];
        $newaddcontact=$_POST["newcontact"];
        $newaddemail=$_POST["newemail"];
        $md5name=md5($newaddname);
        $md5contact=md5($newaddcontact);
        $sql = "SELECT * FROM alcontacts";
        $result = $conn->query($sql);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                if($row["accountno"]==$accno){
                    if($row["md5pername"]==$md5name){
                        $status=1;
                        break;
                    }
                }
            }
        }
        if($status==0){
            $sql = "SELECT * FROM alcontacts";
            $result = $conn->query($sql);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    if($row["accountno"]==$accno){
                        if($row["contactno"]==$newaddcontact){
                            $status=2;
                            break;
                        }
                    }
                }
            }   
        }
        if($status==0){
            $sql="INSERT INTO alcontacts(accountno,pername,contactno,emailid,md5pername,md5contact) VALUES('$accno','$newaddname','$newaddcontact','$newaddemail','$md5name','$md5contact')";
            if($conn->query($sql)===TRUE){
                $status=3;
            }else{
                $status=4;
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head lang="en">
        <title>Phone Book</title>
        <script src="dist/sweetalert.js"></script>
        <script src="dist/sweetalert.min.js"></script>
        <link rel="stylesheet" href="afterloginstyle.css">
        <link rel="stylesheet" href="dist/sweetalert.css">
        <meta charset="utf-8">
		<!--the meta charset="utf-8" is used for HTML5-->
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- ths thing is used for mobile-first-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            var Newname;
            var Phonenumber;
            var Email;
            function logout(){
                swal({
                    title: "Logging Out ...",
                    imageUrl: "logout.png",
                    closeOnConfirm:true,
                    showConfirmButton:false,
                });
                setTimeout(function(){
                    window.location.replace("logout.php");
                }, 750);
            }
            function addcontact(){
                swal({
                    title: "Add Friend",
                    text: "Create your new contact here.",
                    imageUrl: 'user-shape.png',
                    type: "input",
                    inputPlaceholder: "Name of new friend",
                    showCancelButton: true,
                    confirmButtonText: "Create!",
                    confirmButtonClass: "btn-success",
                    closeOnConfirm: false,
                },
                function(inputValue) {
                    if(inputValue === false)return false;
                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false
                    }
                    Newname=inputValue;
                    swal({
                        title: "",
                        text: "Enter the contact number.",
                        imageUrl: 'phone.png',
                        type: "input",
                        inputPlaceholder: "Contact number",
                        showCancelButton: true,
                        confirmButtonText: "Go ahead !",
                        confirmButtonClass: "btn-success",
                        closeOnConfirm: false,
                    },
                    function(inputValue){
                        if(inputValue === false)return false;
                        if(inputValue === ""){
                            swal.showInputError("You need to write something!");
                            return false
                        }
                        if(inputValue.length!=10){
                            swal.showInputError("Incorrect Length!");
                            return false
                        }
                        if(isNaN(inputValue)){
                            swal.showInputError("Contact number cant be characters!");
                                return false
                        }
                        Phonenumber=inputValue;
                        swal({
                            title: "",
                            text: "Enter email if exists.",
                            imageUrl: "gmail.png",
                            type : "input",
                            showCancelButton: true,
                            closeOnConfirm: false,
                            inputPlaceholder: "Enter email-id",
                            confirmButtonClass: "btn-success",
                            confirmButtonText : "Here we go!",                                
                            closeOnCancel: true,
                        },
                        function(inputValue){
                            Email=inputValue;
                            swal({
                                title:"Confirm Your Contact",
                                showCancelButton: true,
                                showConfirmButton: false,
                                cancelButtonClass: "btn-danger",
                                text:"<form method='POST' action='<?php echo $_SERVER['PHP_SELF']; ?>'> <label style='font-size=10px'>Name : </label><input type='text' id='NewName' name='newname' style='border: none' style='border-bottom: 2px solid black' ><br> <label style='font-size=10px'>Contact : </label><input type='text' id='friendcontact' name='newcontact' style='border: none' style='border-bottom: 2px solid black' ><br> <label style='font-size=10px'>Email-id : </label><input type='text' id='emailll' name='newemail' style='border: none' style='border-bottom: 2px solid black'><br> <input type='submit' id='create' value='Create' class='btn btn-success'></form>",
                                html: true,
                            });
                            document.getElementById("friendcontact").value=Phonenumber;
                            document.getElementById("emailll").value=Email;
                            document.getElementById("NewName").value=Newname;
                        });
                    });
                });
            }
        </script>
    </head>
    <body style="margin-left: 10px; margin-right: 10px;">
        <div class="container-fluid p-3 my-3 bg-primary text-white">
            <h1 class="title" style="text-align: center;">E - PhoneBook</h1>
            <blockquote class="blockquote"><p style="font-size: 15px;">Connect With Friends<br></p></blockquote>
            <blockquote class="blockquote-reverse"><button onclick="logout()" class="btn btn-primary">Logout <span class="glyphicon glyphicon-log-out"></span></button></blockquote>
            <p><span class="glyphicon glyphicon-phone-alt"></span> Contacts &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="glyphicon glyphicon-user"></span> Friends Info &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
        </div>
        <div class="container page-header">
            <div  class="jumbotron">
                <h4>Welcome!</h4>
                <p style="font-size: 14px"><?php echo $_SESSION["Username"]."<br>".$_SESSION["Accountno"]."<br>".$_SESSION["yourEmail"] ?></p>
            </div>
        </div>
        <div class="container page-header">
            <div class="container">
                <button onclick="addcontact()" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>&nbsp; ADD CONTACT</button>
            </div>
            <br>
        </div>
        <style>
            .edit{
                background-color: Transparent;
                background-repeat:no-repeat;
                border: none;
                cursor:pointer;
                overflow: hidden;
            }
        </style>
        <script type="text/javascript">
            var x = "<?php echo "$status"?>";
            if(x==1){
                swal("Error","Name already existed!","error");
                location.reload();
            }
            else if(x==2){
                swal("Error","Contact number already existed !","error");
                location.reload();
            }
            else if(x==3){
                swal("Done","Contact successfully added","info");
                location.reload();
            }
            else if(x==4){
                swal("Error","Something went wrong !","info");
                location.reload();
            }
        </script>
        <div class="container page-header">
            <?php 
            $totalcon=0;
                $sql = "SELECT * FROM alcontacts";
                $result = $conn->query($sql);
                if($result->num_rows>0){
                    while($row=$result->fetch_assoc()){
                        if($row["accountno"]==$accno){
                            $totalcon++;    
                        }
                    }
                }
                echo "<a href='#'>Total contacts $nbsp<span class='badge'>".$totalcon."</span></a>";
            ?>
        </div>
        <div class="container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact No.</th>
                        <th>Email-id</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM alcontacts";
                        $result = $conn->query($sql);
                        if($result->num_rows>0){
                            while($row=$result->fetch_assoc()){
                                if($row["accountno"]==$accno){?>
                                    <tr><td><?php echo $row["pername"] ?></td> <td><?php echo $row["contactno"] ?></td><td><?php echo $row["emailid"] ?></td> <td><a href="update.php?update=<?php echo $row['contactno']; ?>"><span class='glyphicon glyphicon-pencil'></span></a></td><td><a href="delete.php?delete=<?php echo $row['contactno'] ?>"><span class="glyphicon glyphicon-trash"></span></a></td></tr>
                        <?php }}}?>
                </tbody>
            </table>
        </div>
    </body>
</html>
