<?php
include_once('conn.php'); //เชื่อม database
session_start();
if (!isset($_SESSION['s'])) {
    header("Location: index.php");
}
if($_SESSION['s'] != 1){
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ค้นหาโครงงาน | เว็บจับเก็บฐานข้อมูล</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
    <style>
body {
background-color: #FFFFAA
}
</style>
    <nav class="navbar navbar-expand-lg navbar-light bg-success">
        <div class="container"> <a class="navbar-brand" href="home.php"><img src="img/assets/home.png" width="30" height="30" alt="" class="d-inline-block align-top">&nbspเว็บไซต์จัดเก็บโครงงาน</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- เพิ่มเติม nav bar ได้ -->
                    <li class="nav-item"> <a class="nav-link" href="home.php">หน้าแรก <span class="sr-only">(current)</span></a></li>
                    <li class="nav-item active"> <a class="nav-link" href="search_pj.php">ค้นหาโครงงาน</a></li>
                    <li class="nav-item"> <a class="nav-link" href="insert_pj.php">เพิ่มโครงงาน</a></li>
                    <li class="nav-item"> <a class="nav-link" href="update_pj.php">ลบโครงงาน</a></li>
                </ul>

                <ul class="navbar-nav ml-auto">
                    <div class="form-inline my-2 my-lg-0">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">ยินดีต้อนรับ</a> &nbsp;|&nbsp;
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                เพิ่มเติม
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">ออกจากระบบ</a>
                            </div>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
    </nav>

    <div class="col-md-8 col-sm-6 mx-auto mt-5">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-inline">
                <label for="search_namepj" class="mr-2 col-form-label"><h5>กรอกข้อมูลหรือคำที่ต้องการค้นหา</h5></label>
                <style>
                    input[type=text],
                    select,
                    textarea {
                        padding: 10px;
                        border: 3px solid #ccc;
                        border-radius: 4px;
                        box-sizing: border-box;
                        resize: vertical;
                    }

                    label {
                        padding: 12px 12px 12px 0;
                        display: inline-block;
                    }

                    input[type=submit] {
                        background-color: #4CAF50;
                        color: white;
                        padding: 12px 20px;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;
                        float: right;
                    }
                </style>
                <input type="text" class="col-9 col-lg-7" name="search_namepj">
                <input type="submit" class="ml-3" value="ค้นหา">
            </div>

            <style>
                .button1 {
                    width: 50px;
                }
            </style>

            <div class="mt-3">
                <table class="table">
                    <thead class="bg-success">
                        <tr>
                            <th scope="col">ลำดับ</th>
                            <th scope="col" class="text-center">ชื่อโครงงาน</tth>
                            <th scope="col">เรียกดู</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!isset($_REQUEST['search_namepj'])) { // ถ้ายังไม่ได้ request จากค้นหา
                            $sql = "SELECT `id`,`name_pj`,`makedate` FROM `tbl_member`";
                            $query = mysqli_query($conn, $sql);
                            $i = 0;
                            while ($data = mysqli_fetch_array($query)) {
                                $i++;
                        ?>
                                <tr class="table-secondary">
                                    <th scope="row"><?php echo $i ?></th>
                                    <td><?php echo $data['name_pj'] ?></td>
                                    <td><a target="_blank" href="view.php?p=<?php echo $data['id'] ?>"><input type="button" value="ดู" class="button1"></a></td>
                                </tr>
                            <?php
                            }
                        } else {
                            $search = $_REQUEST['search_namepj'];
                            $sql = "SELECT * FROM `tbl_member` WHERE `name_pj` LIKE '%$search%'";
                            $query = mysqli_query($conn, $sql);
                            $i = 0;
                            while ($data = mysqli_fetch_array($query)) {
                                $i++;
                            ?>
                                <tr class="table-secondary">
                                    <th scope="row"><?php echo $i ?></th>
                                    <td><?php echo $data['name_pj'] ?></td>
                                    <td><a target="_blank" href="view.php?p=<?php echo $data['id'] ?>"><input type="button" value="ดู" class="button1"></a></td>
                                </tr>
                        <?php
                            }
                        } ?>
                    </tbody>
                </table>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>