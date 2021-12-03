<?php
require 'database.php';

class RegisterPDO
{
    public $error = array();
    public $data = array();

    public function checkBtnRegister()
    {
        if (isset($_POST['btn_register'])) {
            return $this->checkValidate();
        }
    }

    public function checkValidate()
    {
        $mail = $_POST['mail'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        // validate mail
        if (empty($mail)) {
            $this->error['mail'] = 'Gmail không được để trống';
        } else {
            if (strlen($mail) > 255) {
                $this->error['mail'] = 'Gmail có độ dài khổng vượt quá giới hạn 255 ký tự';
            }
        }

        // valadite name
        if (empty($name)) {
            $this->error['name'] = 'Họ tên không được để trống';
        } else {
            if (!(strlen($name) >= 6 && strlen($name) <= 200)) {
                $this->error['name'] = 'Tài khoản phải có độ dài từ 6 đến 200 ký tự';
            }
        }

        // validate password
        if (empty($password)) {
            $this->error['password'] = 'Mật khẩu không được để trống';
        } else {
            if (strlen($password) >= 6 && strlen($password) <= 100) {
                $parttenPassword = "/^([A-Z]){1}([\w_\.!@#$%^&*()]+){5,31}$/";
                if (!preg_match($parttenPassword, $password)) {
                    $this->error['password'] = 'Mật khẩu Không đúng định dạng';
                }
            } else {
                $this->error['password'] = 'Mật khẩu phải có độ dài từ 6 đến 100 ký tự';
            }
        }

        // validate password_confirm
        if (empty($password_confirm)) {
            $this->error['password_confirm'] = 'Cần phải xác nhận mật khẩu';
        } else {
            if ($password !== $password_confirm) {
                $this->error['password_confirm'] = 'Mật khẩu đã nhập không giống ở trên';
            }
        }

        // validate password_confirm
        if (empty($address)) {
            $this->error['address'] = 'Địa chỉ không được để trông';
        }

        // validate name
        if (empty($phone)) {
            $this->error['phone'] = 'Số điện thoại không được để trống';
        } else {
            if (!(strlen($phone) >= 10 && strlen($phone) <= 20)) {
                $this->error['phone'] = 'Số điện thoại từ 10 đến 20 ký tự';
            }
        }

        return $this->error;
    }

    public function setValue()
    {
        $error = $this->checkValidate();
        if (empty($error['mail'])) {
            $this->data['mail'] = $_POST['mail'];
        }

        if (empty($error['name'])) {
            $this->data['name'] = $_POST['name'];
        }

        if (empty($error['phone'])) {
            $this->data['phone'] = $_POST['phone'];
        }

        if (empty($error['address'])) {
            $this->data['address'] = $_POST['address'];
        }

        return $this->data;
    }

    public function insertValue($conn)
    {
        if (empty($this->checkValidate())) {
            $mail = $_POST['mail'];
            $name = $_POST['name'];
            $password = md5($_POST['password']);
            $address = $_POST['address'];
            $phone = $_POST['phone'];

            $sql = $conn->prepare('INSERT INTO users (mail, name, password, address, phone) VALUES (?, ?, ?, ?, ?)');
            $ouput = array($mail, $name, $password, $address, $phone);

            if ($sql->execute($ouput)) {
                header("location:?mod=LoginPdo");
            }
        }
    }
}

$register = new RegisterPDO();
$error = $register->checkBtnRegister();
$setValue = $register->setValue();
$register->insertValue($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <title>Register</title>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 mt-5">
                    <h4 class="text-center text-uppercase">Đăng ký tài khoản người dùng</h4>
                    <form action="" method='POST'>
                        <div class="form-group">
                            <label class="mt-2" for="mail">Gmail: </label>
                            <input type="email" name="mail" id="mail" class="form-control" value="<?Php echo $setValue['mail'] ?>">
                            <p class="text-danger" style="margin:0px;"><?php echo $error['mail'] ?></p>
                            <label class="mt-2" for="name">Họ tên: </label>
                            <input type="name" name="name" id="name" class="form-control" value="<?Php echo $setValue['name'] ?>">
                            <p class="text-danger" style="margin:0px;"><?php echo $error['name'] ?></p>
                            <label class="mt-2" for="password">Mật khẩu: </label>
                            <input type="password" name="password" id="password" class="form-control">
                            <p class="text-danger" style="margin:0px;"><?php echo $error['password'] ?></p>
                            <label class="mt-2" for="password_confirm">Nhập mật khẩu: </label>
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                            <p class="text-danger" style="margin:0px;"><?php echo $error['password_confirm'] ?></p>
                            <label class="mt-2" for="address">Địa chỉ: </label>
                            <input type="text" name="address" id="address" class="form-control" value="<?Php echo $setValue['address'] ?>">
                            <p class="text-danger" style="margin:0px;"><?php echo $error['address'] ?></p>
                            <label class="mt-2" for="phone">Số điện thoại: </label>
                            <input type="text" name="phone" id="phone" class="form-control" value="<?Php echo $setValue['phone'] ?>">
                            <p class="text-danger" style="margin:0px;"><?php echo $error['phone'] ?></p>
                            <button type="submit" class="btn btn-info btn-block mt-5" name="btn_register" value="1">Đăng ký</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
</body>

</html>