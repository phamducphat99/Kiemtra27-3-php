<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dữ liệu nhân viên</title>
<H1>THÔNG TIN NHÂN VIÊN</H1>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    .gender-image {
        width: 30px;
        height: auto;
    }
</style>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "ql_nhansu";

// Tạo kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xác định trang hiện tại
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

// Số nhân viên trên mỗi trang
$employees_per_page = 5;

// Tính offset cho truy vấn SQL
$offset = ($page - 1) * $employees_per_page;

// Truy vấn dữ liệu từ bảng nhân viên với giới hạn và phân trang
$sql = "SELECT * FROM nhanvien LIMIT $offset, $employees_per_page";
$result = $conn->query($sql);

// Kiểm tra số dòng dữ liệu trả về
if ($result->num_rows > 0) {
    // In tiêu đề bảng
    echo "<table>";
    echo "<tr><th>ID</th><th>Tên</th><th>Giới Tính</th><th>Nơi Sinh</th><th>Mã Phòng</th></tr>";
    
    // In dữ liệu từ mỗi dòng kết quả
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Ma_NV"]. "</td>";
        echo "<td>" . $row["Ten_NV"]. "</td>";
        echo "<td>";
        // Kiểm tra giới tính và chèn hình ảnh tương ứng
        if(strtolower($row["Phai"]) == "nu") {
            echo '<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR1EBW4fW8n0ZqxsfHLVECEHF_mu5hDgHibUA&usqp=CAU" alt="Woman" class="gender-image">';
        } else {
            echo '<img src="https://vnn-imgs-a1.vgcloud.vn/image1.ictnews.vn/_Files/2020/03/17/trend-avatar-1.jpg" alt="Man" class="gender-image">';
        }
        echo "</td>";
        echo "<td>" . $row["Noi_Sinh"]. "</td>";
        echo "<td>" . $row["Ma_Phong"]. "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "Không có nhân viên nào";
}

// Tính số trang
$sql_total = "SELECT COUNT(*) AS total FROM nhanvien";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_employees = $row_total['total'];
$total_pages = ceil($total_employees / $employees_per_page);

// Hiển thị link phân trang
echo "<div>";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='?page=$i'>$i</a> ";
}
echo "</div>";

// Đóng kết nối
$conn->close();
?>

</body>
</html>
