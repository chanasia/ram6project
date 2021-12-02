<?php 
include_once('conn.php'); //เชื่อม database
session_start();
if ($_SESSION['s'] == null) {
    header("Location: index.php");
}
if (!isset($_GET['p'])) {
    header("Location: home.php");
    die();
}
if (!isset($_GET['link'])) {
    header("Location: home.php");
    die();
}
$page = $_GET['p'];
$link = $_GET['link'];
$sql = "DELETE FROM `tbl_member` WHERE `tbl_member`.`id` = $page";
$sql2 = "DELETE FROM `tbl_pjdatabase` WHERE `tbl_pjdatabase`.`link_pj` = '$link'";
$sql3 = "SELECT * FROM `tbl_pjdatabase` WHERE `link_pj` LIKE '$link'";
$query = mysqli_query($conn,$sql);
$query3 = mysqli_query($conn,$sql3);
while($data = mysqli_fetch_array($query3)){
    $fname = $data['name_md5'];
    @unlink("files_project/$fname");
}
$query2 = mysqli_query($conn,$sql2);
echo "<script>alert('ได้ลบโครงงานออกจากระบบแล้ว');
location.href = 'update_pj.php';</script>";
?>