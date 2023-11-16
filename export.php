<?php

require_once "config.php";

if (isset($_GET['what'])) {
    if ($_GET['what'] == "members") {

        $members_csv = $conn->query("SELECT member_id, first_name, last_name, email, phone_number, created_at FROM members");
        $filename = "members_data_" . date("d-m-Y") . ".csv";

        $file = fopen('php://memory', 'w');

        $fields = array("ID", "First Name", "Last Name", "Email", "Phone Number", "Created At");

        fputcsv($file, $fields);

        while ($member = $members_csv->fetch_assoc()) {
            $line_data = array($member['member_id'],$member['first_name'], $member['last_name'], $member['email'], $member['phone_number'], $member['created_at']);
            fputcsv($file, $line_data);
        }

        fseek($file, 0);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        fpassthru($file);

    } else if ($_GET['what'] == "trainers") {

        $trainer_csv = $conn->query("SELECT * FROM trainers");
        $filename = "trainers_data_" . date("d-m-Y") . ".csv";

        $file = fopen("php://temp", "w");

        $fields = array("ID", "First Name", "Last Name", "Email", "Phone Number", "Created At");

        fputcsv($file, $fields);
        while ($trainer = $trainer_csv->fetch_assoc()) {
            $line_data = array($trainer['trainer_id'], $trainer['first_name'], $trainer['last_name'], $trainer['email'], $trainer['phone_number'], $trainer['created_at']);
            fputcsv($file, $line_data);
        }
        fseek($file, 0);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        fpassthru($file);

    } else {
        echo "Ovaj export ne postoji,";
    }
}
