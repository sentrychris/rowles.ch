<?php

namespace Rowles\Controllers;

use Pimple\Container;
use Rowles\Models\Blog;

/**
 * Static page controller class.
 */
class PageController extends Controller
{

    /** @var Blog $blog */
    protected Blog $blog;

    /**
     * BlogController constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->blog = new Blog($container);

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
        $data['posts'] = $this->blog->getAllPosts();

        return $this->setViewData($data)->render('home');
    }

    /**
     * Render the experience page.
     *
     * @param array $data
     * @return mixed
     */
    public function experience(array $data = [])
    {
        return $this->setViewData($data)->render('experience');
    }
}
