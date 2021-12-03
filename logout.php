<?php
// xóa session 
unset($_SESSION['mail']);
// Chuyển hướng trang
header("location:?mod=LoginPdo");
