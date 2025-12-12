<?php
namespace Controllers\Admin;

use Services\MovieService;

class ApiController
{
   public function fetchMovies()

{
    header("Content-Type: application/json");

    $service = new \Services\MovieService();
    $service->fetchPopularMovies();

    echo json_encode(["message" => "Fetch thành công"]);
    exit;
}

}
