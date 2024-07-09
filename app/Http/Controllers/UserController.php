<?php
namespace App\Http\Controllers;

use App\Core\User\UserFilter;
use App\Core\User\UserModel;
use App\Core\User\UserRepositoryInterface;
use App\Http\Requests\User\UserSaveRequest;
use App\Infrastructure\Persistence\RequestFilter\RequestFilterInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /** @var UserRepositoryInterface $userRepository */
    private UserRepositoryInterface $userRepository;
    /** @var RequestFilterInterface $userFilter */
    private RequestFilterInterface $userFilter;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->userFilter = new UserFilter();
    }

    public function index(Request $request)
    {
        $this->userFilter->setRequest($request);
        /** @var \App\Infrastructure\Persistence\Pagination\PaginationResultInterface */
        $paginationResult = $this->userRepository->paginate($this->userFilter);

        return $this->responseSuccess($paginationResult);
    }

    public function get(Request $request, int $id)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return $this->responseFail('Item does not found');
        }

        return $this->responseSuccess($user);
    }

    public function save(UserSaveRequest $request)
    {
        /** @var int $id */
        $id = $request->getId();
        /** @var UserModel $user */
        $user = new UserModel();
        if ($id) {
            $user = $this->userRepository->find($id);
            if (!$user) {
                return $this->responseFail('Item does not found');
            }
        }
        $data = $request->validated();
        if (!$data['password']) {
            unset($data['password']);
        }
        $user->fill($data);

        if ($user->save()) {
            return $this->responseSuccess($user);
        }

        return $this->responseFail('Something went wrong');
    }
}