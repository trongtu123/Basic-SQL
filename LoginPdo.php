<?php
require 'database.php';

class LoginPDO
{
    public $error = array();
    private $data = array();

    public function checkBtnLogin()
    {
        if (!empty($_POST['btn_login'])) {
            return $this->checkValidate();
        }
    }

    public function checkValidate()
    {
        $mail = $_POST['mail'];
        $password = $_POST['password'];
        // validate mail
        if (empty($mail)) {
            $this->error['mail'] = 'Gmail không được để trống';
        } else {
            if (strlen($mail) > 255) {
                $this->error['mail'] = 'Gmail có độ dài khổng vượt quá giới hạn 255 ký tự';
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

        return $this->error;
    }

    public function setValueMail()
    {
        $error = $this->checkValidate();
        if (empty($error['mail'])) {
            $this->data['mail'] = $_POST['mail'];
        }

        return $this->data;
    }

    public function login($conn)
    {
        if (empty($this->checkValidate())) {
            $mail = $_POST['mail'];
            $password = md5($_POST['password']);
            if (isset($_POST['remember_me'])) {
                $remember_me = $_POST['remember_me'];
            }
            //Tạo Prepared Statement
            $sql = $conn->prepare('SELECT * from users WHERE mail = :mail');
            //Thiết lập kiểu dữ liệu trả về
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            //Gán giá trị và thực thi
            $sql->execute(array('mail' => $mail));
            
            //Hiển thị kết quả, vòng lặp sau đây sẽ dừng lại khi đã duyệt qua toàn bộ kết quả
            while ($row = $sql->fetch()) {
                $ouput = $row;
            }

            if ($password === $ouput['password']) {
                if ($remember_me == 'on') {
                    setcookie('is_login', true, time() + 3600, '/');
                    setcookie('mail', $mail, time() + 3600, '/');
                }

                $_SESSION['mail'] = $ouput['mail'];
                echo "Đăng nhập thành công";
            } else {
                echo "Đăng nhập thất bại";
            }
        }
    }
}

$login = new LoginPDO();
$error = $login->checkBtnLogin();
$setValue = $login->setValueMail();
$login->login($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <title>Login</title>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 mt-5">
                    <h4 class="text-center text-uppercase">Đăng Nhập người dùng</h4>
                    <form action="" method='POST'>
                        <div class="form-group">
                            <label class="mt-2" for="mail">Gmail: </label>
                            <input type="email" name="mail" id="mail" class="form-control" value="<?php echo $setValue['mail'] ?>">
                            <p class="text-danger" style="margin:0px;"><?php echo $error['mail'] ?></p>
                            <label class="mt-2" for="password">Mật khẩu: </label>
                            <input type="password" name="password" id="password" class="form-control">
                            <p class="text-danger" style="margin:0px;"><?php echo $error['password'] ?></p>
                            <input type="checkbox" name="remember_me" id="remember_me" class="mt-3">
                            <label for=" remember_me">Remember me</label>
                            <button type="submit" class="btn btn-info btn-block" name="btn_login" value="1">Đăng nhập</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
</body>

</html>