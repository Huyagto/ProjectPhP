<?php
namespace Controllers\User;

use Core\Controller;  
use Models\User;
use Models\Watchlist;

class ProfileController extends Controller
{
    private function requireLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Lấy đúng ID theo session hiện tại
        $userId = $_SESSION["user"]["id"] ?? null;

        if (!$userId) {
            return $this->redirect(BASE_URL . "/login");
        }

        return $userId;
    }

    public function index()
    {
        $userId = $this->requireLogin();

        $user   = User::find($userId);
        $movies = Watchlist::getByUser($userId);

        // Danh sách avatar
        $avatars = [
            "avatar_cartoon_1.png",
            "avatar_cartoon_2.png",
            "avatar_cartoon_3.png",
            "avatar_cartoon_4.png",
            "avatar_cartoon_5.png",
        ];

        return $this->view("user/profile", [
            "user"    => $user,
            "movies"  => $movies,
            "avatars" => $avatars
        ], layout: "profile");
    }

    public function updateAvatar()
    {
        $userId = $this->requireLogin();

        $avatar = $_POST["avatar"] ?? null;

        if ($avatar) {
            User::updateAvatar($userId, $avatar);

            if (session_status() === PHP_SESSION_NONE) session_start();

            // Update lại trong session
            $_SESSION["user"]["avatar"] = $avatar;
        }

        return $this->redirect(BASE_URL . "/user/profile");
    }

    public function updateInfo()
    {
        $userId = $this->requireLogin();

        $displayName = trim($_POST["display_name"] ?? "");
        $email       = trim($_POST["email"] ?? "");

        if ($displayName !== "" && $email !== "") {
            User::updateInfo($userId, $displayName, $email);

            if (session_status() === PHP_SESSION_NONE) session_start();

            // Update lại trong session
            $_SESSION["user"]["display_name"] = $displayName;
            $_SESSION["user"]["email"]        = $email;
        }

        return $this->redirect(BASE_URL . "/user/profile");
    }
}
