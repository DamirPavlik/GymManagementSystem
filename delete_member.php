<?php

require_once 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member_id = $_POST['member_id'];
    $sql = "DELETE FROM members WHERE member_id = ?";
    $result = $conn->prepare($sql);
    $result->bind_param('i', $member_id);
    $message = "";

    if ($result->execute()) {
        $message = "Member Deleted";
    } else {
        $message = "Member not deleted";
    }

    $_SESSION['success_message'] = $message;
    header('location: /gym_membership/admin_dashboard.php');
}
