<?php
// models.php
require_once 'config.php';

/* --- THE LOAI --- */
function getAllGenres($pdo) {
    $stmt = $pdo->query("SELECT * FROM theloai ORDER BY tenloai");
    return $stmt->fetchAll();
}
function getGenre($pdo, $maloai) {
    $stmt = $pdo->prepare("SELECT * FROM theloai WHERE maloai = :m");
    $stmt->execute([':m'=>$maloai]);
    return $stmt->fetch();
}
function createGenre($pdo, $maloai, $tenloai) {
    $stmt = $pdo->prepare("INSERT INTO theloai (maloai, tenloai) VALUES (:m, :t)");
    return $stmt->execute([':m'=>$maloai, ':t'=>$tenloai]);
}
function updateGenre($pdo, $maloai, $tenloai) {
    $stmt = $pdo->prepare("UPDATE theloai SET tenloai = :t WHERE maloai = :m");
    return $stmt->execute([':t'=>$tenloai, ':m'=>$maloai]);
}
function deleteGenre($pdo, $maloai) {
    $stmt = $pdo->prepare("DELETE FROM theloai WHERE maloai = :m");
    return $stmt->execute([':m'=>$maloai]);
}

/* --- DAO DIEN --- */
function getAllDirectors($pdo) {
    $stmt = $pdo->query("SELECT * FROM daodien ORDER BY tendd");
    return $stmt->fetchAll();
}
function getDirector($pdo, $madd) {
    $stmt = $pdo->prepare("SELECT * FROM daodien WHERE madd = :id");
    $stmt->execute([':id'=>$madd]);
    return $stmt->fetch();
}
function createDirector($pdo, $tendd) {
    $stmt = $pdo->prepare("INSERT INTO daodien (tendd) VALUES (:t)");
    $stmt->execute([':t'=>$tendd]);
    return $pdo->lastInsertId();
}
function updateDirector($pdo, $madd, $tendd) {
    $stmt = $pdo->prepare("UPDATE daodien SET tendd = :t WHERE madd = :id");
    return $stmt->execute([':t'=>$tendd, ':id'=>$madd]);
}
function deleteDirector($pdo, $madd) {
    $stmt = $pdo->prepare("DELETE FROM daodien WHERE madd = :id");
    return $stmt->execute([':id'=>$madd]);
}

/* --- PHIM --- */
function countMovies($pdo, $filters=[]) {
    $where = [];
    $params = [];
    if (!empty($filters['q'])) {
        $where[] = "(tenphim LIKE :q OR mota LIKE :q)";
        $params[':q'] = "%{$filters['q']}%";
    }
    if (!empty($filters['maloai'])) { $where[] = "maloai = :maloai"; $params[':maloai'] = $filters['maloai']; }
    if (!empty($filters['madd'])) { $where[] = "madd = :madd"; $params[':madd'] = $filters['madd']; }
    if (!empty($filters['year'])) { $where[] = "namsx = :year"; $params[':year'] = (int)$filters['year']; }

    $sql = "SELECT COUNT(*) FROM phim" . (empty($where) ? '' : ' WHERE ' . implode(' AND ', $where));
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return (int)$stmt->fetchColumn();
}

function getMovies($pdo, $filters=[], $offset=0, $limit=10, $order='created_at DESC') {
    $where = [];
    $params = [];
    if (!empty($filters['q'])) {
        $where[] = "(p.tenphim LIKE :q OR p.mota LIKE :q)";
        $params[':q'] = "%{$filters['q']}%";
    }
    if (!empty($filters['maloai'])) { $where[] = "p.maloai = :maloai"; $params[':maloai'] = $filters['maloai']; }
    if (!empty($filters['madd'])) { $where[] = "p.madd = :madd"; $params[':madd'] = $filters['madd']; }
    if (!empty($filters['year'])) { $where[] = "p.namsx = :year"; $params[':year'] = (int)$filters['year']; }

    $sql = "SELECT p.*, d.tendd, t.tenloai
            FROM phim p
            LEFT JOIN daodien d ON p.madd = d.madd
            LEFT JOIN theloai t ON p.maloai = t.maloai";
    if (!empty($where)) $sql .= " WHERE " . implode(' AND ', $where);
    $sql .= " ORDER BY $order LIMIT :offset, :limit";
    $stmt = $pdo->prepare($sql);
    foreach ($params as $k=>$v) $stmt->bindValue($k, $v);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getMovie($pdo, $maphim) {
    $stmt = $pdo->prepare("SELECT * FROM phim WHERE maphim = :id");
    $stmt->execute([':id'=>$maphim]);
    return $stmt->fetch();
}

function createMovie($pdo, $data) {
    $sql = "INSERT INTO phim (tenphim, mota, namsx, thoiluong, gia, poster, madd, maloai)
            VALUES (:tenphim, :mota, :namsx, :thoiluong, :gia, :poster, :madd, :maloai)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':tenphim' => $data['tenphim'],
        ':mota' => $data['mota'],
        ':namsx' => $data['namsx'] ?: null,
        ':thoiluong' => $data['thoiluong'] ?: null,
        ':gia' => $data['gia'] ?: null,
        ':poster' => $data['poster'] ?: null,
        ':madd' => $data['madd'] ?: null,
        ':maloai' => $data['maloai'] ?: null,
    ]);
    return $pdo->lastInsertId(); // Trả về ID của bản ghi vừa thêm vào
}
    

function updateMovie($pdo, $maphim, $data) {
    $sql = "UPDATE phim SET tenphim=:tenphim, mota=:mota, namsx=:namsx, thoiluong=:thoiluong, gia=:gia, poster=:poster, madd=:madd, maloai=:maloai WHERE maphim=:id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':tenphim'=>$data['tenphim'],
        ':mota'=>$data['mota'],
        ':namsx'=>$data['namsx'] ?: null,
        ':thoiluong'=>$data['thoiluong'] ?: null,
        ':gia'=>$data['gia'] ?: null,
        ':poster'=>$data['poster'] ?: null,
        ':madd'=>$data['madd'] ?: null,
        ':maloai'=>$data['maloai'] ?: null,
        ':id'=>$maphim
    ]);
}

function deleteMovie($pdo, $maphim) {
    $stmt = $pdo->prepare("DELETE FROM phim WHERE maphim = :id");
    return $stmt->execute([':id'=>$maphim]);
}
