<?php
require_once 'config.php';

if(!isset($_SESSION['admin_id'])){
    header('location: /gym_membership/');
}
$sql = "SELECT * FROM training_plans";
$run = $conn->query($sql);
$training_plans = $run->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
</head>

<?php if(isset($_SESSION['success_message'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php
        echo $_SESSION['success_message'];
        unset($_SESSION['success_message']);
    ?>
    <button type="submit" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif;?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Members list</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Trainer</th>
                            <th>Photo</th>
                            <th>Training Plan</th>
                            <th>Access Card</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $sql = "SELECT members.* ,
                                training_plans.name AS training_plan_name,
                                trainers.first_name AS trainer_first_name,
                                trainers.last_name AS trainer_last_name
                                FROM `members` 
                                LEFT JOIN `training_plans` ON members.training_plan_id = training_plans.plan_id
                                LEFT JOIN `trainers` ON trainers.trainer_id = members.trainer_id";
                         $run = $conn->query($sql);
                         $results = $run->fetch_all(MYSQLI_ASSOC);
                        foreach($results as $result): ?>
                            <tr>
                                <td><?= $result['first_name']?></td>
                                <td><?= $result['last_name']?></td>
                                <td><?= $result['email']?></td>
                                <td><?= $result['phone_number']?></td>
                                <td><?= $result['trainer_id']?></td>
                                <td><img style="width: 60px; height: 60px; object-fit: cover;" src="<?= $result['photo_path']?>" alt="Member Photo"></td>
                                <td><?= $result['training_plan_name']?></td>
                                <td><a href="<?= $result['access_card_pdf_path']?>" target="_blank">Access Card</a></td>
                                <td><?php
                                    $created_at = strtotime($result['created_at']);
                                    $new_date = date("F, jS Y", $created_at);
                                    echo $new_date;
                                    ?></td>
                                <td><button>Delete</button></td>
                            </tr>
                        <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-6">
                <h2>Register Member</h2>
                <form action="register_member.php" method="post" enctype="multipart/form-data">
                    First Name: <input type="text" class="form-control" name="first_name"><br>
                    Last Name: <input type="text" class="form-control" name="last_name"><br>
                    Email: <input type="email" class="form-control" name="email"><br>
                    Phone Number: <input type="text" class="form-control" name="phone_number"><br>
                    Training Plan:
                    <select name="training_plan_id" class="form-control">
                        <option value="" disabled selected>Training Plans</option>
                        <?php foreach ($training_plans as $plan): ?>
                        <option value="<?= $plan['plan_id']?>">
                            <?= $plan['name']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select> <br>
                    <input type="hidden" name="photo_path" id="photoPathInput">
                    <div id="dropzone-upload" class="dropzone"></div>
                    <input type="submit" value="Register Member" class="btn btn-primary mt-3">
                </form>
            </div>


            <div class="col-md-6"></div>



        </div>
    </div>

    <?php $conn->close(); ?>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        Dropzone.options.dropzoneUpload = {
            url: "upload_photo.php",
            paramName: "photo",
            maxFilesize: 20,
            acceptedFiles: "image/*",
            init: function() {
                this.on("success", function(file, response){
                    const jsonResponse = JSON.parse(response);
                    if (jsonResponse.success) {
                        document.getElementById('photoPathInput').value = jsonResponse.photo_path;
                    } else {
                        console.log(jsonResponse.error);
                    }
                });
            }
        }
    </script>

</body>
</html>
