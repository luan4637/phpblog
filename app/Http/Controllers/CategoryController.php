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

    public function index(Request $request)
    {
        $this->categoryFilter->setRequest($request);

        /** @var \App\Infrastructure\Persistence\Pagination\PaginationResultInterface */
        $paginationResult = $this->categoryRepository->paginate($this->categoryFilter);

        return $this->responseSuccess($paginationResult);
    }

    public function get(Request $request, int $id)
    {
        $category = $this->categoryRepository->find($id);

        if (!$category) {
            return $this->responseFail('Item does not found');
        }

        return $this->responseSuccess($category);
    }

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

    public function delete(CategoryDeleteRequest $request)
    {
        /** @var int $id */
        $id = $request->getId();

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