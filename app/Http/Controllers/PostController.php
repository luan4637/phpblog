<?php
namespace App\Http\Controllers;

use App\Core\Post\PostFilter;
use App\Core\Post\PostModel;
use App\Core\Post\PostRepositoryInterface;
use App\Http\Requests\Post\PostSaveRequest;
use App\Http\Requests\Post\PostDeleteRequest;
use App\Infrastructure\Persistence\RequestFilter\RequestFilterInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $this->postFilter->setRequest($request);

        /** @var \App\Infrastructure\Persistence\Pagination\PaginationResultInterface */
        $paginationResult = $this->postRepository->paginate($this->postFilter);

        return $this->responseSuccess($paginationResult);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request, int $id)
    {
        /** @var PostModel|null $post */
        $post = $this->postRepository->with(['categories', 'user'])->find($id);
        if (!$post) {
            return $this->responseFail('Item does not found');
        }
        return $this->responseSuccess($post);
    }

    /**
     * @param PostSaveRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(PostSaveRequest $request)
    {
        /** @var int $id */
        $id = $request->getId();
        /** @var PostModel $post */
        $post = new PostModel();
        if ($id) {
            $post = $this->postRepository->find($id);
            if (!$post) {
                return $this->responseFail('Item does not found');
            } elseif (!Gate::allows(['post-update'], $post)) {
                return $this->responseFail('Permission denied!');
            }
        } else {
            $post->setUserId(Auth::id());
        }
        $post->fill($request->validated());

        /** @var \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[]|array|null $picture */
        $picture = $request->file('picture');

        if ($picture) {
            /** @var string $pictureName */
            $pictureName = md5(date('Y-m-d H:i:s') . $picture->getClientOriginalName()) . '.' . $picture->extension();
            $picture->move('upload', $pictureName);
            $post->setPicture('/upload/' . $pictureName);
        }

        if ($post->save()) {
            $post->categories()->detach($post->categories);
            $post->categories()->attach($request->getCategories());
            
            return $this->responseSuccess($post);
        }

        return $this->responseFail('Something went wrong');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, int $id)
    {
        /** @var PostModel|null $post */
        $post = $this->postRepository->find($id);
        
        if (!$post) {
            return $this->responseFail('Item does not found');
        } elseif (!Gate::allows(['post-update'], $post)) {
            return $this->responseFail('Permission denied!');
        }

        if ($post->delete()) {
            return $this->responseSuccess($post);
        }

        return $this->responseFail('Something went wrong');
    }
}