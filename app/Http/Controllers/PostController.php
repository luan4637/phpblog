<?php
namespace App\Http\Controllers;

use App\Core\Post\PostFilter;
use App\Core\Post\PostModel;
use App\Core\Post\PostRepositoryInterface;
use App\Http\Requests\Post\PostSaveRequest;
use App\Http\Requests\Post\PostDeleteRequest;
use App\Infrastructure\Persistence\RequestFilter\RequestFilterInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @var PostRepositoryInterface $postRepository
     */
    private PostRepositoryInterface $postRepository;
    /**
     * @var RequestFilterInterface $postFilter
     */
    private RequestFilterInterface $postFilter;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
        $this->postFilter = new PostFilter();
    }

    public function index(Request $request)
    {
        $this->postFilter->setRequest($request);

        /** @var \App\Infrastructure\Persistence\Pagination\PaginationResultInterface */
        $paginationResult = $this->postRepository->paginate($this->postFilter);

        return response()->json($paginationResult);
    }

    public function get(Request $request, int $id)
    {
        $post = $this->postRepository->find($id);
        if (!$post) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Item does not found'
            ]);
        }
        return response()->json($post);
    }

    public function save(PostSaveRequest $request)
    {
        /** @var int $id */
        $id = $request->getId();
        /** @var PostModel $post */
        $post = new PostModel();
        if ($id) {
            $post = $this->postRepository->find($id);
            if (!$post) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Item does not found'
                ]);
            }
        }
        $post->fill($request->validated());
        $post->setSlug(str_replace(' ', '-', $post->getTitle()));
        $post->setUserId(1);

        $picture = $request->file('picture');
        if ($picture) {
            $pictureName = md5(date('Y-m-d H:i:s') . $picture->getClientOriginalName()) . '.' . $picture->extension();
            $picture->move('upload', $pictureName);
            $post->setPicture('/upload/' . $pictureName);
        }

        if ($post->save()) {
            $post->categories()->attach($request->getCategories());
            
            return response()->json([
                'status' => 'success',
                'post' => $post
            ]);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Something went wrong'
        ]);
    }

    public function delete(PostDeleteRequest $request)
    {
        /** @var int $id */
        $id = $request->getId();

        /** @var PostModel|null $post */
        $post = $this->postRepository->find($id);
        if (!$post) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Item does not found'
            ]);
        }

        if ($post->delete()) {
            return response()->json([
                'status' => 'success',
                'post' => $post
            ]);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Something went wrong'
        ]);
    }
}