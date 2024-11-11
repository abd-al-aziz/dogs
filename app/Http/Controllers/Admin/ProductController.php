<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(){

        $pageTitle = 'All Products';
        $products = Product::with(['category','productImages'])->orderBy('id','desc')->paginate(getPaginate(20));
        return view('admin.products.index',compact('products','pageTitle'));
     }

     public function create (){
        $pageTitle ='Add Product';
        $categories = Category::where('status',1)->get();

        return view('admin.products.create',compact('pageTitle','categories'));
     }

     public function store(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required',
            'category_id' => 'required',
            'quantity' => 'required',
            'images.*' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);
      

        $product = new Product();
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->quantity = $request->quantity;

        $product->short_desc = $request->short_desc;
        $product->status = 1;

        if( $request->is_featured){
            Product::where('is_featured',1)->update(['is_featured'=> 0]);
            $product->is_featured = $request->is_featured;
        }

        $product->save();


        foreach ($request->images as $image) {
            $productImage = new ProductImage();
            $productImage->product_id = $product->id;


            if ($image->isValid()) {

                try {
                    $imagePath = fileUploader($image, getFilePath('product'), getFileSize('product'));
                    $productImage->image = $imagePath;
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload your image'];
                    return back()->withNotify($notify);
                }

               $productImage->save();

            }

        }

           $notify[] = ['success', 'Product has been  created successfully'];
           return back()->withNotify($notify);

     }

     public function edit($id){
        $pageTitle = 'Update';
        $product = Product::find($id);
        $productImage = ProductImage::where('product_id', $id)->get();
        $categories = Category::where('status',1)->get();
        return view('admin.products.edit',compact('pageTitle','productImage','categories','product'));
     }

     public function update(Request $request, $id){

        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required',
            'category_id' => 'required',
            'quantity' => 'required',
            'images.*' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        $product = Product::findOrFail($id);
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->quantity = $request->quantity;

        $product->short_desc = $request->short_desc;
        $product->status = $request->status ? 1: 0;
        if( $request->is_featured){
            Product::where('is_featured',1)->update(['is_featured'=> 0]);
            $product->is_featured = $request->is_featured;
        }
        $product->save();


        if ($request->hasFile('images')) {

            foreach ($request->images as $image) {
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;


                if ($image->isValid()) {

                    try {
                        $imagePath = fileUploader($image, getFilePath('product'), getFileSize('product'));
                        $productImage->image = $imagePath;
                    } catch (\Exception $exp) {
                        $notify[] = ['error', 'Couldn\'t upload your image'];
                        return back()->withNotify($notify);
                    }

                   $productImage->save();

                }

            }

        }
        $notify[] = ['success', 'Product has been  updated successfully'];
        return back()->withNotify($notify);

     }


     public function imageRemove(Request $request){
        $request->validate([
          'id' => 'required'
      ]);

      $image =  ProductImage::findOrFail($request->id);

      $path  = getFilePath('product').'/'.$image->image;
      fileManager()->removeFile($path);
      $image->delete();

      $notify[] = ['success','Product Image has been deleted'];
      return back()->withNotify($notify);

    }



}
