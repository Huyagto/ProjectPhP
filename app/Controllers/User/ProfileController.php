<?php
namespace Controllers\User;

use Core\Controller;  
use Models\User;
use Models\Watchlist;

class ProfileController extends Controller
{
    public function index() 
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Nên thống nhất session user_id
        $userId = $_SESSION["user"]["id"] ?? $_SESSION["user_id"];

        // Lấy thông tin user
        $user = User::find($userId);

        // Lấy danh sách phim
        $movies = Watchlist::getByUser($userId);

        return $this->view("user/profile", [
            "user" => $user,
            "movies" => $movies
        ]);
    }

    public function updateAvatar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION["user"]["id"];
        $avatarFile = $_POST["avatar"];

        if ($avatarFile) {
            User::updateAvatar($userId, $avatarFile);
            $_SESSION["user"]["avatar"] = $avatarFile;
        }

        return $this->redirect(BASE_URL . "/user/profile");
    }

    public function updateInfo()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION["user"]["id"];

        $displayName = $_POST["display_name"];
        $email = $_POST["email"];

        User::updateInfo($userId, $displayName, $email);

        $_SESSION["user"]["display_name"] = $displayName;
        $_SESSION["user"]["email"] = $email;

        return $this->redirect(BASE_URL . "/user/profile");
    }
}
