<?php
namespace Models;

class Watchlist {
    public static function add($user_id, $movie_id) {
    global $pdo;

    // Kiểm tra tồn tại
    $check = $pdo->prepare("SELECT id FROM watchlist WHERE user_id = ? AND movie_id = ?");
    $check->execute([$user_id, $movie_id]);

    if ($check->fetch()) {
        return true; // có rồi thì thôi
    }

    // Thêm mới
    $stm = $pdo->prepare("INSERT INTO watchlist (user_id, movie_id) VALUES (?, ?)");
    return $stm->execute([$user_id, $movie_id]);
}
public static function exists($user_id, $movie_id)
{
    global $pdo;

    $stm = $pdo->prepare("SELECT id FROM watchlist WHERE user_id = ? AND movie_id = ?");
    $stm->execute([$user_id, $movie_id]);

    return $stm->fetch() ? true : false;
}


    public static function getByUser($user_id) {
        global $pdo;

        $stm = $pdo->prepare("
            SELECT movies.* 
            FROM watchlist 
            JOIN movies ON movies.id = watchlist.movie_id
            WHERE watchlist.user_id = ?
        ");
        $stm->execute([$user_id]);
        return $stm->fetchAll();
    }
    public static function delete($user_id, $movie_id)
{
    global $pdo;

    $stm = $pdo->prepare("DELETE FROM watchlist WHERE user_id = ? AND movie_id = ?");
    return $stm->execute([$user_id, $movie_id]);
}

}
