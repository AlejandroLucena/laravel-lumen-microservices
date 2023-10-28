<?php

namespace App\Http\Controllers;

use Exception;
use Modules\Post\Infrastructure\Controller\CreatePostController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Post\Infrastructure\Controller\DeletePostController;
use Modules\Post\Infrastructure\Controller\FindAllPostsController;
use Modules\Post\Infrastructure\Controller\FindPostByIdController;
use Modules\Post\Infrastructure\Controller\UpdatePostController;

class PostController extends Controller
{
    public function __construct(
        private readonly CreatePostController $createPostController,
        private readonly UpdatePostController $updatePostController,
        private readonly DeletePostController $deletePostController,
        private readonly FindAllPostsController $findAllPostsController,
        private readonly FindPostByIdController $findPostByIdController,
    ) {
        //
    }

    public function store(Request $request)
    {
        try {
            $this->createPostController->__invoke($request);

            return response()->json("Entity Created", Response::HTTP_CREATED);
        } catch (Exception $e) {

            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $this->updatePostController->__invoke($request, $id);

            return response()->json("Entity Updated", Response::HTTP_ACCEPTED);
        } catch (Exception $e) {

            return response()->json($e->getMessage(), $e->getCode());
        }
    }
    public function delete(int $id)
    {
        try {
            $this->deletePostController->__invoke($id);

            return response()->json("Entity Deleted", Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {

            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function get()
    {
        try {
            $response = $this->findAllPostsController->__invoke();

            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {

            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function find(int $id)
    {
        try {
            $response = $this->findPostByIdController->__invoke($id);

            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {

            return response()->json($e->getMessage(), $e->getCode());
        }
    }
}
