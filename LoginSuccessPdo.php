<?php
if (!isset($_SESSION['mail'])) {
    header("location:?mod=LoginPdo");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <title>LoginSuccessPdo</title>
</head>

<body>
    <div class="container text-center">
        <h2 class="text-success"><?php echo $_SESSION['mail'] ?></h2>
        <button><a href="?mod=logout">Đăng xuất</a></button>
    </div>
</body>

</html>