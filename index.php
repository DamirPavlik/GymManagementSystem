<?php
require_once "config.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT admin_id, password FROM admins WHERE username = ?";

    $run = $conn->prepare($sql);
    $run->bind_param("s", $username);
    $run->execute();
    $result = $run->get_result();


    if($result->num_rows == 1){
        $admin = $result->fetch_assoc();
        if(password_verify($password, $admin['password'])){
            $_SESSION['admin_id'] = $admin['admin_id'];
            header("location: admin_dashboard.php");

            $conn->close();
            echo "Password je tacan";
        } else {
            $_SESSION['error'] = "Pogresna Lozinka";

            $conn->close();
            header("location: /gym_membership/");
            exit;
        }
    } else {
        $_SESSION['error'] = "Pogresan username";

        $conn->close();
        header("location: /gym_membership/");
        exit;
    }

}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
    if(isset($_SESSION['error'])){
        echo $_SESSION['error'] . '<br>';
        unset($_SESSION['error']);
    }
?>
<form action="" method="post">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" value="Login">
</form>
</body>
</html>
