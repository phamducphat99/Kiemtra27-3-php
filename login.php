<?php
session_start();

$servername = "localhost";
$username = "root";
$password = ""; 
$database = "ten_cua_database";

// Tạo kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xử lý thông tin đăng nhập từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn dữ liệu từ bảng user
    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    // Kiểm tra kết quả truy vấn
    if ($result->num_rows == 1) {
        // Đăng nhập thành công
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['Id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['role'] = $row['role'];

        // Chuyển hướng đến trang chính sau khi đăng nhập thành công
        header("Location: connect.php");
    } else {
        // Đăng nhập thất bại
        echo "Tên đăng nhập hoặc mật khẩu không chính xác.";
    }
}

// Đóng kết nối
$conn->close();
?>
