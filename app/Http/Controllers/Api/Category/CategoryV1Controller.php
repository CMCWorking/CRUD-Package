<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryAPIRequest;
use App\Models\Category;
use App\Transformer\CategoryTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryV1Controller extends Controller
{
    use Helpers;

    public function __construct(Category $category)
    {
        // $this->middleware('auth:sanctum');
        $this->category = $category;
        $this->page = 10;
    }

    /**
     * It returns a paginated list of categories, using the `CategoryTransformer` to transform the data
     *
     * @return A paginated list of categories.
     */
    public function index(Request $request)
    {
        $categories = $this->category->filter($request->all())->get();
        return response()->json($categories);
    }

    /**
     * It returns a single category
     *
     * @param id The ID of the category to show
     *
     * @return A single category
     */
    public function show($id)
    {
        // $category = $this->category->find($id);
        // if (!$category) {
        //     return $this->response->errorNotFound('Category not found');
        // }

        // return $this->response->item($category, new CategoryTransformer());
        $category = $this->category->find($id);
        return response()->json($category);
    }

    /**
     * It creates a new category and returns a success message
     *
     * @param CategoryAPIRequest request The request object.
     */
    public function store(CategoryAPIRequest $request)
    {
        $category = $this->category->create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'description' => $request->input('description'),
        ]);

        return response()->json('Category created successfully');
    }

    /**
     * It updates the category with the given id
     *
     * @param Request request The request object.
     * @param id The id of the category to be updated.
     *
     * @return An array with a message.
     */
    public function update(Request $request, $id)
    {
        $category = $this->category->find($id);

        $category->update([
            'name' => $request->name,
            'slug' => $request->slug ? $request->slug : Str::slug($request->name),
            'description' => $request->description,
            'image' => $request->image,
            'parent_id' => $request->parent_id,
            'status' => $request->status,
            'keywords' => $request->keywords,
        ]);

        return response()->json('Category updated successfully');
    }

    /**
     * It deletes a category by its ID
     *
     * @param id The ID of the category to be deleted.
     *
     * @return A JSON response with a message.
     */
    public function destroy($id)
    {
        $category = $this->category->find($id);

        $category->delete();

        return response()->json('Category deleted successfully');
    }

    public function search(Request $request)
    {
        $categories = $this->category->filter()->paginate($request->paginate ?? $this->page);

        if (count($categories) < 1) {
            return $this->response->errorNotFound('Category not found');
        }

        return $this->response->paginator($categories, new CategoryTransformer());
    }
}
