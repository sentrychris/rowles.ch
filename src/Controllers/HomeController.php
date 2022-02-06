<?php

namespace Rowles\Controllers;

use Pimple\Container;
use Rowles\Models\Blog;

/**
 * Page controller class.
 */
class HomeController extends Controller
{

    /** @var Blog $blog */
    // protected Blog $blog;

    /**
     * HomeController constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        // $this->blog = new Blog($container);

        parent::__construct($container);
    }

    /**
     * Render the home page.
     *
     * @param array $data
     * @return mixed
     */
    public function home(array $data = [])
    {
        // $data['posts'] = $this->blog->getAllPosts();

        return $this->setViewData($data)->render('home');
    }
}
