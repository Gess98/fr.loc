<?php

namespace App\Controllers;

use App\Models\User;
use PDOException;
use PHPFramework\Pagination;

class PostController extends BaseController
{

    public function index()
    {
        // dump(app()->get('lang'));

        $posts = db()->query("select p.*, pd.* FROM posts p join post_description pd on p.id = pd.post_id 
        where pd.lang_id = ?", [app()->get('lang')['id']])->get();

        dump($posts);

        return view('post/index', 
        [
            'title' => 'Список статей',
            'posts' => $posts,
        ]);
    }
}
