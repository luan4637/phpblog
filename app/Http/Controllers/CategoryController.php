<?php
namespace App\Http\Controllers;

use App\Core\Category\CategoryFilter;
use App\Core\Category\CategoryRepositoryInterface;
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
}