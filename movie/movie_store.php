<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models.php';

// Kiểm tra nếu có dữ liệu từ form gửi tới
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $tenphim = $_POST['tenphim'];
    $mota = $_POST['mota'];
    $namsx = $_POST['namsx'];
    $thoiluong = $_POST['thoiluong'];
    $gia = $_POST['gia'];
    $maloai = $_POST['maloai'];
    $madd = $_POST['madd'];

    // Xử lý upload poster
    $poster = null;
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] == 0) {
        $poster = $_FILES['poster']['name'];
        // Di chuyển file lên thư mục uploads
        move_uploaded_file($_FILES['poster']['tmp_name'], __DIR__ . '/../uploads/' . $poster);
    }

    // Gọi hàm thêm phim vào cơ sở dữ liệu
    $result = createMovie($pdo, [
        'tenphim' => $tenphim,
        'mota' => $mota,
        'namsx' => $namsx,
        'thoiluong' => $thoiluong,
        'gia' => $gia,
        'maloai' => $maloai,
        'madd' => $madd,
        'poster' => $poster
    ]);

    // Nếu thêm thành công, chuyển hướng về trang index
    if ($result) {
        header('Location: ../index.php');
        exit;
    } else {
        echo "Có lỗi xảy ra trong quá trình thêm phim.";
    }
}
?>
