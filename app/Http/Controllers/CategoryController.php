<?php
namespace App\Http\Controllers;

use App\Core\Category\CategoryFilter;
use App\Core\Category\CategoryModel;
use App\Core\Category\CategoryRepositoryInterface;
use App\Http\Requests\Category\CategorySaveRequest;
use App\Http\Requests\Category\CategoryDeleteRequest;
use App\Infrastructure\Persistence\RequestFilter\RequestFilterInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepositoryInterface $categoryRepository
     */
    private CategoryRepositoryInterface $categoryRepository;
    /**
     * @var RequestFilterInterface $categoryFilter
     */
    private RequestFilterInterface $categoryFilter;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryFilter = new CategoryFilter();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $this->categoryFilter->setRequest($request);

        /** @var \App\Infrastructure\Persistence\Pagination\PaginationResultInterface */
        $paginationResult = $this->categoryRepository->paginate($this->categoryFilter);

        return $this->responseSuccess($paginationResult);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request, int $id)
    {
        /** @var CategoryModel|null $category */
        $category = $this->categoryRepository->find($id);

        if (!$category) {
            return $this->responseFail('Item does not found');
        }

        return $this->responseSuccess($category);
    }

    /**
     * @param CategorySaveRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(CategorySaveRequest $request)
    {
        /** @var int $id */
        $id = $request->getId();
        /** @var CategoryModel $category */
        $category = new CategoryModel();
        if ($id) {
            $category = $this->categoryRepository->find($id);
            if (!$category) {
                return $this->responseFail('Item does not found');
            }
        }
        $category->fill($request->validated());
        $category->setSlug(str_replace(' ', '-', $category->getName()));

        if ($category->save()) {
            return $this->responseSuccess($category);
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
        /** @var CategoryModel|null $category */
        $category = $this->categoryRepository->find($id);
        if (!$category) {
            return $this->responseFail('Item does not found');
        }

        if ($category->delete()) {
            return $this->responseSuccess($category);
        }

        return $this->responseFail('Something went wrong');
    }
}