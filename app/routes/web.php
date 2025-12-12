   <?php
   use Core\Route;

   /* ==================================
      PUBLIC ROUTES (Không cần đăng nhập)
   ================================== */

   Route::get("", "HomeController@index");
   Route::get("home", "HomeController@index");

   /* Movie xem chi tiết (public) */
   Route::get("movie/{id}", "User/MovieController@detail");

   /* Search (public) */
   Route::get("search", "User/MovieController@search");


   /* ==================================
      USER ROUTES (đã đăng nhập)
   ================================== */

   /* Trang chủ user */
   Route::get("user/home", "User\\HomeController@index");
   Route::get("user/movies", "User\\HomeController@index");

   /* Chi tiết phim và tìm kiếm khi user đăng nhập */
   Route::get("user/movie/{id}", "User\\MovieController@detail");
   Route::get("user/search", "User\\MovieController@search");

   /* Profile */
   Route::get("user/profile", "User\\ProfileController@index");
   Route::post("user/profile/update", "User\\ProfileController@updateInfo");
   Route::post("user/profile/avatar", "User\\ProfileController@updateAvatar");

   /* Watchlist */
   Route::post("watchlist/add", "User\\WatchlistController@add");
   Route::post("watchlist/delete", "User\\WatchlistController@delete");
   Route::post("watchlist/toggle", "User\\WatchlistController@toggle");


   /* ==================================
      AUTH ROUTES
   ================================== */
   Route::get("login", "AuthController@showLogin");
   Route::post("login", "AuthController@login");
   Route::get("register", "AuthController@showRegister");
   Route::post("register", "AuthController@register");
   Route::get("logout", "AuthController@logout");


   /* ==================================
      ADMIN ROUTES (middleware = admin)
   ================================== */
   Route::get("admin", "Admin\\DashboardController@index", "admin");

   /* ADMIN MOVIES */
   Route::get("admin/movies", "Admin\\MovieController@index", "admin");
   Route::get("admin/movies/create", "Admin\\MovieController@create", "admin");
   Route::post("admin/movies/store", "Admin\\MovieController@store", "admin");
   Route::get("admin/movies/edit/{id}", "Admin\\MovieController@edit", "admin");
   Route::post("admin/movies/update/{id}", "Admin\\MovieController@update", "admin");
   Route::get("admin/movies/delete/{id}", "Admin\\MovieController@delete", "admin");

   /* ADMIN CATEGORIES */
   Route::get("admin/categories", "Admin\\CategoryController@index", "admin");
   Route::get("admin/categories/create", "Admin\\CategoryController@create", "admin");
   Route::post("admin/categories/store", "Admin\\CategoryController@store", "admin");
   Route::get("admin/categories/edit/{id}", "Admin\\CategoryController@edit", "admin");
   Route::post("admin/categories/update/{id}", "Admin\\CategoryController@update", "admin");
   Route::get("admin/categories/delete/{id}", "Admin\\CategoryController@delete", "admin");

   /* ADMIN AUTHORS */
   Route::get("admin/authors", "Admin\\AuthorController@index", "admin");
   Route::get("admin/authors/create", "Admin\\AuthorController@create", "admin");
   Route::post("admin/authors/store", "Admin\\AuthorController@store", "admin");
   Route::get("admin/authors/edit/{id}", "Admin\\AuthorController@edit", "admin");
   Route::post("admin/authors/update/{id}", "Admin\\AuthorController@update", "admin");
   Route::get("admin/authors/delete/{id}", "Admin\\AuthorController@delete", "admin");

   /* ADMIN USERS */
   Route::get("admin/users", "Admin\\UserController@index", "admin");
   Route::get("admin/users/create", "Admin\\UserController@create", "admin");
   Route::post("admin/users/store", "Admin\\UserController@store", "admin");
   Route::get("admin/users/edit/{id}", "Admin\\UserController@edit", "admin");
   Route::post("admin/users/update/{id}", "Admin\\UserController@update", "admin");
   Route::get("admin/users/delete/{id}", "Admin\\UserController@delete", "admin");

