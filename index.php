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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลัก | เว็บจับเก็บฐานข้อมูล</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
        <!-- แทบต่างๆ -->
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
                        <a href="login.php"><input type="button" name="login" class="btn btn-light" value="เข้าสู่ระบบ"></a>&nbsp
                    </form>
                </ul>
            </div>
        </div>
    </nav>

    <img src="img/assets/Web.png" alt="Italian Trulli" class="img-fluid">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>