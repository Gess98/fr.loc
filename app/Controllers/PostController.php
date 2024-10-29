<?php

namespace App\Controllers;

use App\Models\User;
use PDOException;
use PHPFramework\Pagination;

class PostController extends BaseController
{

    // Для обработки всех постов
    public function index()
    {
        // dump(app()->get('lang'));

        $posts = db()->query("select p.*, pd.* FROM posts p join post_description pd on p.id = pd.post_id 
        where pd.lang_id = ?", [app()->get('lang')['id']])->get();

        // dump($posts);

        return view('post/index', 
        [
            'title' => 'Список статей',
            'posts' => $posts,
        ]);
    }

    // Для обработки одного поста
    public function post()
    {
        $post = db()->query("select posts.*, post_description.* from posts 
        join post_description
        on posts.id = post_description.post_id where posts.slug = ? and post_description.lang_id = ?", [
            get_route_params('slug'),
            app()->get('lang')['id']
        ])->get();

        return view('post/post', 
        [
            'title' => 'Статья',
            'post' => $post,
        ]);
    }
}
