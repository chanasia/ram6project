<?php
include_once('conn.php');
session_start();
if ($_SESSION['s'] == null) {
    header("Location: index.php");
}
if (!isset($_GET['p'])) {
    header("Location: home.php");
    die();
}
$page = $_GET['p'];
$sql = "SELECT * FROM `tbl_member` WHERE `id` = $page";
$query = mysqli_query($conn, $sql);

$data = mysqli_fetch_array($query);

$namepj = $data['name_pj'];
$member1 = $data['member_pj1'];
$member2 = $data['member_pj2'];
$member3 = $data['member_pj3'];
$level = $data['level'];
$branch = $data['branch'];
$round = $data['round'];
$makedate = $data['makedate'];
$teacher1 = $data['teacher1'];
$teacher2 = $data['teacher2'];
$link = $data['link_pj'];

$sql2 = "SELECT * FROM `tbl_pjdatabase` WHERE `link_pj` LIKE '$link'";
$query2 = mysqli_query($conn, $sql2);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $namepj; ?> | เว็บจับเก็บฐานข้อมูล</title>
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
                    <li class="nav-item"> <a class="nav-link" href="index.php">หน้าแรก</a></li>
                    <li class="nav-item"> <a class="nav-link" href="search_pj.php">ค้นหาโครงงาน</a></li>
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

    <div class="row">
        <div class="col-md-8 col-sm-6 mx-auto mt-5">
            <div class="card">
                <div class="card-header text-center">
                    <h4>ข้อมูลโครงงานของ: <?php echo $namepj ?></h4>
                </div>
                <div class="card-body">
                    <div class="text-left"><h5>รหัสโครงงาน: <?php echo $link ?></h5></div>
                    <div class="text-right">
                        <h5>ปีที่จัดทำ: <?php echo $makedate ?> | รอบ: <?php echo $round ?></h5>
                    </div>
                    <div class="text-right">
                        <h5>แผนก: <?php echo $branch ?></h5>
                    </div>
                </div>
                <div class="card-header text-center">
                    <h4>รายชื่อผู้จัดทำ</h4>
                </div>
                <div class="card-body">
                    <h5>1. <?php echo $member1 . " " . $level ?></h5>
                    <?php
                    if ($member2 != "") {
                        echo "<h5>2. $member2 $level</h5>";
                    }
                    if ($member3 != "") {
                        echo "<h5>3. $member3 $level</h5>";
                    }
                    ?>
                </div>
                <div class="card-header text-center">
                    <h4>อาจารย์ที่ปรึกษา</h4>
                </div>
                <div class="card-body">
                    <h5>1. <?php echo $teacher1 ?></h5>
                    <?php
                    if ($teacher2 != "") {
                        echo "<h5>2. $teacher2 $level</h5>";
                    }
                    ?>
                </div>
                <div class="card-header text-center">
                    <h4>ไฟล์โครงงาน</h4>
                </div>
                <table class="table" >
                    <thead class="bg-success">
                        <tr>
                            <th scope="col">ลำดับ</th>
                            <th scope="col" class="text-center">ชื่อไฟล์โครงงาน</th>
                            <th scope="col" class="text-center">ดาวน์โหลดไฟล์</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        while ($data2 = mysqli_fetch_array($query2)) {
                            $i++;
                        ?>
                            <tr class="table-secondary">
                                <th scope="row"><?php echo $i ?></th>
                                <td><?php echo $data2['name_file'] ?></td>
                                <td class="d-flex justify-content-center"><a target="_blank" href="files_project/<?php echo $data2['name_md5'] ?>" download><input type="button" value="โหลด" class="button1"></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>