<?php
namespace App\Http\Controllers;

use App\Core\Post\PostFilter;
use App\Core\Post\PostModel;
use App\Core\Post\PostRepositoryInterface;
use App\Core\User\UserRepositoryInterface;
use App\Http\Requests\Post\PostSaveRequest;
use App\Http\Requests\Post\PostDeleteRequest;
use App\Infrastructure\Persistence\RequestFilter\RequestFilterInterface;
use App\Notifications\PostCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * @var PostRepositoryInterface $postRepository
     */
    private PostRepositoryInterface $postRepository;
    /**
     * @var UserRepositoryInterface $userRepository
     */
    private UserRepositoryInterface $userRepository;
    /**
     * @var RequestFilterInterface $postFilter
     */
    private RequestFilterInterface $postFilter;

    /**
     * @param PostRepositoryInterface $postRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        PostRepositoryInterface $postRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $this->postFilter->setRequest($request);

        /** @var \App\Infrastructure\Persistence\Pagination\PaginationResultInterface */
        $paginationResult = $this->postRepository->search($this->postFilter);

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
            Storage::put($pictureName, $picture->getContent());
            $post->setPicture(Storage::url($pictureName));
        }

        if ($post->save()) {
            $post->categories()->detach($post->categories);
            $post->categories()->attach($request->getCategories());

            // if (!$id) {
                $users = $this->userRepository->getAll();
                Notification::send($users, new PostCreated($post));
            // }
            
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