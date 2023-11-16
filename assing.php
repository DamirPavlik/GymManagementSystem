<?php
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $trainer_id = $_POST['select_trainer'];
    $member_id = $_POST['select_member'];

    $sql = "UPDATE members SET trainer_id = '$trainer_id' WHERE member_id = $member_id";
    $run = $conn->query($sql);

    $_SESSION['success_message'] = "Uspesno ste dodelili trenera";
    header("location: admin_dashboard.php");
    exit();

}