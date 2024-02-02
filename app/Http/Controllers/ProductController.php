<?php

namespace App\Http\Controllers;

use App\Models\Product;

use App\Http\Requests\StoreProductRequest;

use App\Http\Requests\UpdateProductRequest;

use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function getData(): JsonResponse {

        $products = DB::table('product')

        -> select('types.type', 'subtypes.id_type', 'subtypes.subtype', 'products.*')

        -> join('subtypes', 'products.id_subtype', '=', 'subtypes.id')
       
        -> join('types', 'subtypes.id_type', '=', 'types.id')

        -> orderBy('products.id')

        -> get();

        $subproducts = DB::table('subproducts')

        -> select('id', 'id_product', 'subproduct', 'price', 'img')

        -> get();

        // El use ($subproducts) me permite acceder a esta variable desde el ambito de la funcion.

        $productsWithSubproducts = $products -> map (function ($product) use ($subproducts) {

            $filteredSubproducts = $subproducts -> where ('id_product', $product -> id) -> values() -> all();
        
            # Genera una key dentro de product con el nombre subproducts que generar un array.

            $product -> subproducts = $filteredSubproducts;
        
            return $product;

        });

        return response() -> json($productsWithSubproducts);

    }

    public function getSales(): JsonResponse {

        $sales = DB::table('sales')

        -> select('products.product', 'subproducts.subproduct', 'types.type', 'subtypes.subtype', 'products.id', 'sales.*')

        -> join('subproducts', 'sales.id_subproduct', '=', 'subproducts.id')

        -> join('products', 'sales.id_product', '=', 'products.id')

        -> join('subtypes', 'products.id_subtype', '=', 'subtypes.id')
       
        -> join('types', 'subtypes.id_type', '=', 'types.id')

        -> orderBy('products.id')

        -> get();

        return response() -> json($sales);

    }

    public function getSalesById(Request $request): JsonResponse {

        $sales = DB::table('sales')

        -> select('products.product', 'subproducts.subproduct', 'types.type', 'subtypes.subtype', 'products.id', 'sales.*')

        -> join('subproducts', 'sales.id_subproduct', '=', 'subproducts.id')

        -> join('products', 'sales.id_product', '=', 'products.id')

        -> join('subtypes', 'products.id_subtype', '=', 'subtypes.id')
       
        -> join('types', 'subtypes.id_type', '=', 'types.id')

        -> orderBy('products.id')

        -> where('sales.id_user', '=', $request -> id_user)
        
        -> get();

        return response() -> json($sales);

    }

    public function getTypes(): JsonResponse {

        try {

            $types = DB::table('types') -> select('id', 'type') -> get();
    
            return response() -> json($types);

        } catch (\Throwable $th) {

            return response() -> json($th);

        }

    }

    public function getSubtypes(): JsonResponse {

        try {

            $subtypes = DB::table('subtypes') -> select('id', 'id_type', 'subtype') -> get();
    
            return response() -> json($subtypes);

        } catch (\Throwable $th) {

            return response() -> json($th);

        }

    }

    public function getProducts(): JsonResponse {

        try {

            $products = DB::table('products') -> select('id', 'id_type', 'id_subtype', 'product', 'img', 'price') -> get();
    
            return response() -> json($products);

        } catch (\Throwable $th) {

            return response() -> json($th);

        }

    }

    public function getSubproducts(): JsonResponse {

        try {

            $subproducts = DB::table('subproducts') -> select('id', 'id_product', 'subproduct', 'price', 'img') -> get();
    
            return response() -> json($subproducts);

        } catch (\Throwable $th) {

            return response() -> json($th);

        }

    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {

        try {

            $dbconnect = DB::connection()->getPDO();

            $dbname = DB::connection()->getDatabaseName();

            return response($dbname, 200);

        } catch(\Exception $e) {

            return response($e, 500);

        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

}
