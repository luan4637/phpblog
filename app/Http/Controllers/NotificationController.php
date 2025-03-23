<?php
namespace App\Http\Controllers;

use App\Core\User\UserFilter;
use App\Core\User\UserModel;
use App\Core\User\UserRepositoryInterface;
use App\Http\Requests\User\UserSaveRequest;
use App\Infrastructure\Persistence\Pagination\PaginationResult;
use App\Infrastructure\Persistence\RequestFilter\RequestFilterInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /** @var UserRepositoryInterface $userRepository */
    private UserRepositoryInterface $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @param int $id
     */
    public function index(Request $request)
    {
        /** @var int $userId */
        $userId = Auth::id();

        if ($userId) {
            $user = $this->userRepository->find($userId);
            $page = $request->get('page');
            $limit = $request->get('limit');
            $notifications = $user->notifications->skip(($page - 1) * $limit)->take($limit);
            
            return $this->responseSuccess(
                new PaginationResult($notifications->toArray(), $user->notifications->count())
            );
        }

        return $this->responseFail('Something went wrong');
    }
}