<?php

namespace Controllers\User;

use Models\Watchlist;

class WatchlistController
{
    public function add()
    {
        // Chỉ start session khi chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        Watchlist::add($_SESSION["user_id"], $_POST["movie_id"]);

        // Redirect về trang trước
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit;
    }
    public function delete()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userId = $_SESSION["user_id"] ?? $_SESSION["user"]["id"];
    $movieId = $_POST["movie_id"];

    Watchlist::delete($userId, $movieId);

    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit;
}
public function toggle()
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    $userId = $_SESSION["user"]["id"];
    $movieId = $_POST["movie_id"];

    if (Watchlist::exists($userId, $movieId)) {
        Watchlist::delete($userId, $movieId);
        echo "removed";
    } else {
        Watchlist::add($userId, $movieId);
        echo "added";
    }
}

}
