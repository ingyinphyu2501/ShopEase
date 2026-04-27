<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    // direct product create page
    public function createPage() {
        $categories = Category::select('id','name')->get();
        return view('admin.product.createPage', compact('categories'));
    }

    // create product
    public function create(Request $request) {
        $this->checkValidation($request, 'create');

        $data = $this->getData($request);

        if( $request->hasFile('image') ) {
            $imgName =  uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move( public_path() . '/productImage/' , $imgName );
            $data['image'] = $imgName;
        }

        Product::create($data);

        Alert::success('Success Title', 'Product Created Successfully!');

        return back();
    }

    // display product list
    public function list( $action = 'default' ) {
        $products = Product::select('products.id','products.name','products.price','products.description','products.category_id','products.stock','products.image','categories.name as category_name')
                            ->leftJoin('categories', 'products.category_id', 'categories.id')
                            ->when($action == 'lowAmt', function($query) {
                                $query->where('products.stock', '<=', 3);
                            })
                            ->when(request('searchKey'), function($query) {
                                $query->whereAny(['products.name','products.price','categories.name'], 'like', '%'.request('searchKey').'%');
                            })
                            ->orderBy('products.created_at','desc')
                            ->get();

        return view('admin.product.list', compact('products'));
    }

    // delete product
    public function delete($id) {
        Product::where('id',$id)->delete();

        return back();
    }

    // edit product
    public function edit($id) {
        $product = Product::where('id',$id)->first();
        $categories = Category::select('id','name')->get();

        return view('admin.product.update', compact('product','categories'));
    }

    // update product
    public function update(Request $request) {
        $this->checkValidation($request, 'update');

        $data = $this->getData($request);
        $oldImage = $request->oldPhoto;

        if( $request->hasFile('image') ) {

            if( file_exists(public_path('productImage/'. $oldImage)) ) {
               unlink(public_path('productImage/'. $oldImage));
            }

            $imgName =  uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move( public_path() . '/productImage/' , $imgName );
            $data['image'] = $imgName;

        }else {
            $data['image'] = $oldImage;
        }

        Product::where('id',$request->productId)->update($data);

        Alert::success('Success Title', 'Product Updated Successfully!');

        return to_route('productList');
    }

    // get product data
    private function getData($request) {
        return [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->categoryId,
            'stock' => $request->stock,
        ];
    }

    // get product detail
    public function detail($id) {
        $product = Product::select('products.name','products.price','products.description','products.stock','products.image','products.updated_at','categories.name as category_name')
                        ->leftJoin('categories','products.category_id','categories.id')
                        ->where('products.id',$id)
                        ->first();

        return view('admin.product.detail', compact('product'));
    }

    // check validation
    private function checkValidation($request,$action) {
        $rules = [
            'name' => 'required|max:100|unique:products,name,'. $request->productId,
            'price' => 'required|numeric',
            'description' => 'required|max:1000',
            'categoryId' => 'required',
            'stock' => 'required|numeric',
        ];

        $rules['image'] = $action == 'create' ? 'required|file|mimes:jpg,jpeg,png,webp,svg,gif' : 'file|mimes:jpg,jpeg,png,webp,svg,gif';

        $message = [
            'name.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            'price.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            'description.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            'categoryId.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            'stock.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            'image.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်။'
        ];

        $request->validate($rules, $message);
    }
}
