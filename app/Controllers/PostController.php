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

        $recent_posts = db()->query("select p.*, pd.* FROM posts p join post_description pd on p.id = pd.post_id 
        where pd.lang_id = ? order by p.created_at desc limit 2", [app()->get('lang')['id']])->get();

        // dump($recent_posts);

        return view('post/index', 
        [
            'title' => 'Список статей',
            'posts' => $posts,
            'recent_posts' => $recent_posts,
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

        // Для обработки всех постов в админ панели
        public function admin_index()
        {
            $posts = db()->query("select p.*, pd.* FROM posts p join post_description pd on p.id = pd.post_id 
            where pd.lang_id = ?", [app()->get('lang')['id']])->get();
    
            return view('admin/posts/index',
            [
                'title' => 'Список статей',
                'posts' => $posts,
            ],
        'admin');
        }

        // Уаление поста
        public function delete():void
        {
            $post_delete = db()->query("delete posts.*, post_description.* from posts join post_description 
            on posts.id = post_description.post_id where posts.slug = ?", [get_route_params('slug')])->get();
            if($post_delete) {
                response()->redirect('/admin/posts');
            }else{
                response()->redirect('/admin/posts');
                // session()->setFlash('admin', 'Deletion is not possible. There is no such article on the site!');
            }
        }

        public function create()
        {
            return view('admin/posts/create', [], 'admin');
        }
}
