<?php
namespace Controllers\User;

use Models\Watchlist;

class WatchlistController 
{
    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (empty($_SESSION["user"]["id"])) {
            header("Location: /login");
            exit;
        }

        if (empty($_POST["movie_id"])) {
            header("Location: " . ($_SERVER["HTTP_REFERER"] ?? "/"));
            exit;
        }

        Watchlist::add($_SESSION["user"]["id"], $_POST["movie_id"]);

        header("Location: " . ($_SERVER["HTTP_REFERER"] ?? "/"));
        exit;
    }

    public function delete()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (empty($_SESSION["user"]["id"])) {
            header("Location: /login");
            exit;
        }

        if (empty($_POST["movie_id"])) {
            header("Location: " . ($_SERVER["HTTP_REFERER"] ?? "/"));
            exit;
        }

        Watchlist::delete($_SESSION["user"]["id"], $_POST["movie_id"]);

        header("Location: " . ($_SERVER["HTTP_REFERER"] ?? "/"));
        exit;
    }

    public function toggle()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (empty($_SESSION["user"]["id"])) {
            echo "not_logged_in";
            return;
        }

        if (empty($_POST["movie_id"])) {
            echo "invalid";
            return;
        }

        $userId  = $_SESSION["user"]["id"];
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
