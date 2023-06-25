<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use BalajiDharma\LaravelAdminCore\Actions\User\CreateProduct;
use BalajiDharma\LaravelAdminCore\Actions\User\UpdateProduct;
use BalajiDharma\LaravelAdminCore\Requests\StoreProductRequest;
use BalajiDharma\LaravelAdminCore\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:product list', ['only' => ['index', 'show']]);
        $this->middleware('can:product create', ['only' => ['create', 'store']]);
        $this->middleware('can:product edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:product delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $products = (new Product())->newQuery();

        if (request()->has('search')) {
            $products->where('designation', 'like', '%' . request()->input('search') . '%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $products->orderBy($attribute, $sort_order);
        } else {
            $products->latest();
        }

        $user = Auth::user();

        if (!$user->hasRole(['admin', 'super-admin'])) {
            $products->where('user_id', $user->id);
        }

        $products = $products->with('user')->paginate(20)->appends(request()->query());
        $users = User::all()->pluck("name", "id");

        return Inertia::render('Admin/Product/Index', [
            'users' => $users,
            'products' => $products,
            'filters' => request()->only('search'),
            'can' => [
                'create' => Auth::user()->can('product create'),
                'edit' => Auth::user()->can('product edit'),
                'delete' => Auth::user()->can('product delete'),
            ]
        ]);
    }

    public function show(Product $product)
    {
        return Inertia::render('Admin/Product/Show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $product = User::all()->pluck("designation","id");

        return Inertia::render('Admin/Product/Create', [
            'products' => $product,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreProductRequest  $request
     * @param  CreateProduct  $createProduct
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,)
    {
        $validatedData = $request->validate([
            'designation' => 'required',
            'specification' => 'required',
            'unite' => 'required',
            'quantite' => 'required|numeric',
            'prix_unitaire' => 'required|numeric',
            'montant' => 'required|numeric',
        ]);

        $validatedData['user_id'] = Auth::user()->id;

        $product = Product::create($validatedData);

        return redirect()->route('product.index')
            ->with('message', __('Product created successfully.'));
    }

    public function edit(Product $product)
    {
        return Inertia::render('Admin/Product/Edit', [
            'product' => $product,
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @param  UpdateProduct  $updateProduct
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product, UpdateProduct $updateProduct)
    {
         $updateProduct->handle((object) $request->all(), $product);

        return redirect()->route('product.index')
                        ->with('message', __('Product updated successfully.'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        // Ajoutez ici le code pour rediriger vers la page de l'index des produits ou vers la page de confirmation de suppression
        return redirect()->route('product.index');
    }

    public function getProductCount()
    {
        $productCount = Product::count();
        return response()->json($productCount);
    }
}
