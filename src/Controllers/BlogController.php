<?php

namespace Rowles\Controllers;

use Klein\Request;
use Klein\Response;
use Pimple\Container;
use Rowles\Models\Blog;

/**
 * Blog controller class.
 */
class BlogController extends Controller
{
    /** @var Blog $blog */
    protected Blog $blog;

    /** @var array $views */
    protected static array $views = [
        'create' => 'blog/create',
        'edit'   => 'blog/edit',
        'home'   => 'blog/home',
        'view'   => 'blog/view',
    ];

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
     * View blog home page.
     *
     * @param array $data
     * @return mixed
     */
    public function home(array $data = [])
    {
        $data['posts'] = $this->blog->getAllPosts();

        return $this->setViewData($data)->render(static::$views[__FUNCTION__]);
    }

    /**
     * View a blog post.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function view(int $id, array $data = [])
    {
        $data['post'] = $this->blog->getPost($id);
        $data['title'] = $data['post']['title'];

        return $this->setViewData($data)->render(static::$views[__FUNCTION__]);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data = [])
    {
        return $this->setViewData($data)->render(static::$views[__FUNCTION__]);
    }

    /**
     * Edit a blog post.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function edit(int $id, array $data = [])
    {
        $data['post'] = $this->blog->getPost($id);
        $data['title'] = $data['post']['title'];

        return $this->setViewData($data)->render(static::$views[__FUNCTION__]);
    }

    /**
     * Submit a new blog post.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function submit(Request $request, Response $response): Response
    {
        if ($request->param('id')) {
            // TODO Detect when caller is ajax method
            if ($this->blog->setAttributes($request->params())->update()) {
                $return = ['msg' => 'Blog post successfully updated!', 'status' => 'success'];
            } else {
                $return = ['msg' => 'Error! Could not update blog post.', 'status' => 'error'];
            }
        } else {
            if ($this->blog->setAttributes($request->params())->save()) {
                $return = ['msg' => 'Blog post successfully created!', 'status' => 'success'];
            } else {
                $return = ['msg' => 'Error! Could not create blog post.', 'status' => 'error'];
            }
        }

        // TODO add proper redirects with flash session
        return $response->json($return);
    }

    /**
     * Delete a blog post.
     *
     * @param Request $request
     * @param Response $response
     * @return Response $response
     */
    public function delete(Request $request, Response $response): Response
    {
        $id = $request->param('id');
        if ($this->blog->delete($id)) {
            $return = ['msg' => 'Blog post successfully deleted!', 'status' => 'success'];
        } else {
            $return = ['msg' => 'Error! Could not delete blog post.', 'status' => 'error'];
        }

        return $response->json($return);
    }
}
