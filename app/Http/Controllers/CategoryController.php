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

        return response()->json($paginationResult);
    }

    public function get(Request $request, int $id)
    {
        $category = $this->categoryRepository->find($id);

        if (!$category) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Item does not found'
            ]);
        }

        return response()->json($category);
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
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Item does not found'
                ]);
            }
        }
        $category->fill($request->validated());
        $category->setSlug(str_replace(' ', '-', $category->getName()));

        if ($category->save()) {
            return response()->json([
                'status' => 'success',
                'category' => $category
            ]);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Something went wrong'
        ]);
    }

    public function delete(CategoryDeleteRequest $request)
    {
        /** @var int $id */
        $id = $request->getId();

        /** @var CategoryModel|null $category */
        $category = $this->categoryRepository->find($id);
        if (!$category) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Item does not found'
            ]);
        }

        if ($category->delete()) {
            return response()->json([
                'status' => 'success',
                'category' => $category
            ]);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Something went wrong'
        ]);
    }
}