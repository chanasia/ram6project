<?php
include_once('conn.php'); //เชื่อม database
session_start();
if (!isset($_SESSION['s'])) {
    header("Location: index.php");
}
if($_SESSION['s'] != 1){
    header("Location: index.php");
}

if (isset($_REQUEST['btn_success'])) {
    $namepj = $_REQUEST['pjname']; //เก็บหัวข้อโตรงงาน
    $makedate = $_REQUEST['makedate']; //เก็บปีที่จัดทำ
    $link = md5($namepj . $makedate); //สร้างชื่อไฟล์
    $checkpj = "SELECT * FROM `tbl_member` WHERE `link_pj` LIKE '$link'";
    $query3 = mysqli_query($conn, $checkpj);
    $haspj = mysqli_num_rows($query3);
    if ($haspj > 0){
        echo "<script>alert('มีโครงงานอยู่ในระบบแล้ว');history.back(1);</script>";
        die();
    }

    $valid_formats = array("doc", "docx", "pdf", "pptx"); //นามสกุลไฟล์
    $path = "files_project/";
    $count = 0;
    $message = array(); //เก็บข้อความ
    $dfname = array(); //เก็บชื่อไฟล์
    $fname = array(); //เก็บชื่อไฟล์ที่เปลี่ยนชื่อแล้ว
    $max_file_size = 1024 * 20000; //เก็บขนาดของไฟล์ที่มากสุด 10MB
    $hasfile = 0; //เก็บจำนวนไฟล์
    $fileSuc = false;


    foreach ($_FILES['files']['name'] as $f => $name) {
        if ($_FILES['files']['size'][$f] > 0) { //ไฟล์ที่อัพโหลดเสร็จแล้ว
            if ($_FILES['files']['error'][$f] == 4) { //เมื่อระบบ array file error
                die();
            }
            $hasfile++;
        }
    }
    //พบว่าไม่มีไฟล์จากหน้าเว็บ
    if ($hasfile < 1) {
        print '<script>';
        print 'alert("กรุณาแนบไฟล์อย่างน้อย 1 ไฟล์");history.back(1);';
        print '</script>';
        die();
    } elseif ($hasfile > 20) { //หากไฟล์มากว่า 20 ไฟล์
        print '<script>';
        print 'alert("เพิ่มไฟล์โครงงานไม่เกิน 20 ไฟล์");history.back(1);';
        print '</script>';
        die();
    }
    //ตรวจว่าไฟล์ได้ผ่านเงื่อนไขตามนี้หรือไม่
    // ขนาดไม่ได้เกิน 8MB
    // ไฟล์จะต้องเป็นนามสกุล docx, doc, pdf
    foreach ($_FILES['files']['name'] as $f => $name) {
        if ($_FILES['files']['size'][$f] > $max_file_size) { //ถ้าขนาดเกิน 8MB
            $message[] = "$name มีขนาดไฟล์มากกว่า " . ($max_file_size / 1024) . "";
            continue;
        } elseif (!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)) { //ถ้าไฟล์ไม่ใช่นามสกุล docx, doc, pdf
            $message[] = "$name นามสกุลไม่ถูกต้อง";
            continue;
        }
    }
    //ถ้าไม่ผ่านเงื่อนไขให้ทำการแสดง error ออกมา
    if (count($message) > 0) {
        foreach ($message as $t) {
            $txt .= $t . ' ';
        }
        print '<script>alert("' . $txt . '");history.back(1);</script>';
        die();
    } else { //ถ้าผ่านเงื่อนไข
        foreach ($_FILES['files']['name'] as $f => $name) {
            $ext = pathinfo($name, PATHINFO_EXTENSION); // เก็บนามสกุลไว้

            $fileName = $link . "_$f" . "." . $ext; //เปลื่ยนชื่อไฟล์เพื่อไม่ให้ซ้ำกับอันเก่า
            if (move_uploaded_file($_FILES["files"]["tmp_name"][$f], "files_project/" . $fileName)) { //เมื่อย้ายไฟล์เข้าฐานข้อมูลเสร็จแล้ว
                $count++;
                $fname[$f] = $fileName;
                $dfname[$f] = $name;
            }
        }
        $fileSuc = true;
    }

    if ($fileSuc) {
        $creator1 = $_REQUEST['creator1'];
        $creator2 = $_REQUEST['creator2'];
        $creator3 = $_REQUEST['creator3'];
        $level = $_REQUEST['level'];
        $branch = $_REQUEST['branch'];
        $round = $_REQUEST['round'];
        $teacher1 = $_REQUEST['teacher1'];
        $teacher2 = $_REQUEST['teacher2'];

        $sql = "INSERT INTO `tbl_member` (`id`, `name_pj`, `member_pj1`, `member_pj2`, `member_pj3`, `level`, `branch`, `round`, `makedate`, 
        `teacher1`, `teacher2`, `link_pj`) VALUES (NULL, '$namepj', '$creator1', '$creator2', '$creator3', '$level', '$branch', '$round', 
        '$makedate', '$teacher1', '$teacher2', '$link')";
        $q_pj = mysqli_query($conn, $sql);

        foreach ($fname as $i => $name) {
            $d = $dfname[$i];
            $sql2 = "INSERT INTO `tbl_pjdatabase` (`id`, `name_file`, `name_md5`, `link_pj`) VALUES (NULL, '$d', '$name', '$link')";
            $q_pj = mysqli_query($conn, $sql2);
        }
        echo "<script>alert('ได้เพิ่มโครงงานเสร็จแล้ว');</script>";
        $fileSuc = false;
    }
    header("Refresh:0");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มโครงงาน | เว็บจับเก็บฐานข้อมูล</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
        <style>
body {
background-color: #FFFFAA
}
</style>
    <nav class="navbar navbar-expand-lg navbar-light bg-success">
        <div class="container"> <a class="navbar-brand" href="index.php"><img src="img/assets/home.png" width="30" height="30" alt="" class="d-inline-block align-top">&nbspเว็บไซต์จัดเก็บโครงงาน</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- เพิ่มเติม nav bar ได้ -->
                    <li class="nav-item"> <a class="nav-link" href="home.php">หน้าแรก <span class="sr-only">(current)</span></a></li>
                    <li class="nav-item"> <a class="nav-link" href="search_pj.php">ค้นหาโครงงาน</a></li>
                    <li class="nav-item active"> <a class="nav-link" href="#">เพิ่มโครงงาน</a></li>
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

    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-md-8 col-sm-6 mx-auto mt-5">
                <div class="card">
                    <div class="card-header text-center">
                        รายละเอียดโครงงาน
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="pjname" class="mx-auto col-form-label">ชื่อโครงงาน</label>
                            <input type="text" id="pjname" name="pjname" class="form-control" required>
                        </div>
                        <div class="form-group row">
                            <label class="mx-auto col-form-label">ชื่อผู้จัดทำ</label>
                            <input type="text" id="creator1" name="creator1" class="form-control" placeholder="ผู้จัดทำคนที่ 1" required>&nbsp;
                            <input type="text" id="creator2" name="creator2" class="form-control" placeholder="ผู้จัดทำคนที่ 2">&nbsp;
                            <input type="text" id="creator3" name="creator3" class="form-control" placeholder="ผู้จัดทำคนที่ 3">
                        </div>
                        <div class="form-inline">
                            <label for="level">ระดับชั้น</label>
                            <select class="form-control ml-1" id="level" name="level">
                                <option>ปวช.3/1</option>
                                <option>ปวช.3/2</option>
                                <option>ปวช.3/3</option>
                                <option>ปวช.3/4</option>
                                <option>ปวช.3/5</option>
                                <option>ปวช.3/6</option>
                                <option>ปวช.3/7</option>
                                <option>ปวช.3/8</option>
                                <option>ปวส.2/1</option>
                                <option>ปวส.2/2</option>
                                <option>ปวส.2/3</option>
                                <option>ปวส.2/4</option>
                                <option>ปวส.2/5</option>
                                <option>ปวส.2/6</option>
                                <option>ปวส.2/7</option>
                                <option>ปวส.2/8</option>
                            </select>

                            <label for="branch" class="ml-1 col-form-label">แผนก</label>
                            <select class="form-control ml-1" id="branch" name="branch">
                                <option>สาขางานยานยนต์</option>
                                <option>สาขางานไฟฟ้ากำลัง</option>
                                <option>สาขางานอิเล็กทรอนิกส์</option>
                                <option>สาขางานเทคนิคคอมพิวเตอร์</option>
                                <option>สาขางานคอมพิวเตอร์ธุรกิจ</option>
                                <option>สาขางานอิเล็กทรอนิกส์อุตสาหกรรม</option>
                                <option>สาขางานคอมพิวเตอร์ซอฟแวร์</option>
                            </select>
                        </div>&nbsp;
                        <div class="form-inline">
                            <label for="round" class="ml-2 col-form-label">รอบ</label>
                            <select class="form-control ml-4" id="round" name="round">
                                <option>เช้า</option>
                                <option>บ่าย</option>
                            </select>

                            <label for="makedate" class="ml-2 col-form-label">ปีทีจัดทำ</label>
                            <input type="text" id="makedate" name="makedate" class="form-control ml-3" placeholder="ตัวอย่าง 1/2561" required>
                        </div>
                        <div class="form-group row">
                            <label class="mx-auto col-form-label">อาจารย์ที่ปรึกษา</label>
                            <input type="text" id="teacher1" name="teacher1" class="form-control" placeholder="อาจารย์คนที่ 1" required>&nbsp;
                            <input type="text" id="teacher2" name="teacher2" class="form-control" placeholder="อาจารย์คนที่ 2">
                        </div>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>


                <div class="card mt-5">
                    <div class="card-header text-center">
                        ไฟล์โครงงาน
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="suggestion" class="ml-auto">ไฟล์โครงงานไม่เกิน  20 ไฟล์</label>
                            <textarea class="col-sm-12" name="opFile" id="opFile" style="height: 123px;" disabled></textarea>
                            <div class="form-inline">
                                <input type="file" name="files[]" id="pjFile" class="ml-3 mt-3" multiple>
                                <input type="button" class="mt-3 pull-right" value="ยกเลิก" onclick="clearValue();">
                                <script>
                                    function clearValue() {
                                        $("#pjFile").val('');
                                        document.getElementById('opFile').innerHTML = "";
                                    }
                                </script>
                            </div>
                            <script>
                                const inpFile = document.getElementById('pjFile');
                                var fileList = "";
                                inpFile.addEventListener("change", function() {
                                    const pdfFile = new Array(this.files);
                                    var lengthFile = pdfFile[0].length;
                                    console.log(pdfFile);
                                    if (lengthFile < 20) {
                                        for (let i = 0; i < lengthFile; i++) {
                                            fileList += pdfFile[0][i].name + "\n";
                                            console.log(pdfFile[0][i]);
                                        }
                                        console.log(fileList);
                                        document.getElementById('opFile').innerHTML = fileList;
                                        fileList = "";
                                    } else {
                                        fileList = "";
                                        clearValue();
                                    }
                                });
                            </script>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" name="btn_success" value="ยืนยัน" class="btn-success">
                    </div>
                </div>
            </div>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>