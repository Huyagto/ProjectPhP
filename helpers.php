<?php
// helpers.php
function e($s) {
    return htmlspecialchars($s ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function flash($msg) {
    if (!session_id()) session_start();
    $_SESSION['flash'] = $msg;
}
function get_flash() {
    if (!session_id()) session_start();
    $m = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $m;
}

// simple pagination helper: returns offset and limit and builds page links
function paginate($total, $perPage, $currentPage, $baseUrl) {
    $totalPages = max(1, ceil($total / $perPage));
    $currentPage = max(1, min($currentPage, $totalPages));
    $offset = ($currentPage - 1) * $perPage;
    $pages = [];
    for ($i = 1; $i <= $totalPages; $i++) {
        $pages[] = ['num'=>$i, 'url'=> $baseUrl . (strpos($baseUrl, '?')===false ? '?' : '&') . "page=$i", 'active'=>($i==$currentPage)];
    }
    return ['offset'=>$offset, 'limit'=>$perPage, 'pages'=>$pages, 'totalPages'=>$totalPages];
}
