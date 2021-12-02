<?php
session_start();
if (isset($_SESSION['s'])){
    if($_SESSION['s'] == 1){
        header("Location: home.php");
    }
    if($_SESSION['s'] == 2){
        header("Location: homeu.php");
    }
}

if(isset($_POST['submit'])){
    //admin pass: ram6project2020
    $basep = "f949c8ab7289dff120232544d534a66d"; //เข้ารหัส md5(ram6)
    $baseu = "ram6";
    
    
    //user pass: ram6user
    $uPass = "2b3fcccf2cdab1282b843551de254466";
    $uUser = "user";
    
    $user = $_POST['username'];
    $hashp = md5($_POST['password']);

    if($user == $baseu && $hashp == $basep){
        $_SESSION['s'] = 1;
        header("Location: home.php");
    }elseif($user == $uUser && $hashp == $uPass){
        $_SESSION['s'] = 2;
        header("Location: homeu.php");
    }else{
        echo "<script>alert('ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าเข้าสู่ระบบ | เว็บจับเก็บฐานข้อมูล</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-success">
        <div class="container"> <a class="navbar-brand" href="index.php"><img src="img/assets/home.png" width="30" height="30" alt="" class="d-inline-block align-top">&nbspเว็บไซต์จัดเก็บโครงงาน</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- เพิ่มเติม nav bar ได้ -->

                </ul>

                <ul class="navbar-nav ml-auto">
                    <form class="form-inline my-2 my-lg-0">
                    </form>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto mt-5">
                <div class="card">
                    <form action="" method="POST">
                        <div class="card-header text-center">
                            เข้าสู่ระบบเว็บไซต์
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="username" class="col-sm-3 col-form-label">ชื่อผู้ใช้งาน</label>
                                <div class="col-9">
                                    <input type="text" id="username" name="username" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-3 col-form-label">รหัสผ่าน</label>
                                <div class="col-9">
                                    <input type="password" id="password" name="password" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <input type="submit" name="submit" class="btn btn-success" value="เข้าสู่ระบบ">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>