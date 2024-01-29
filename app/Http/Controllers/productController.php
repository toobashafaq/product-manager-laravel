<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\category;
use App\Models\User;
use Illuminate\Support\Facades\File;
class productController extends Controller
{
    //
    public function listProduct(){
        $user=auth()->user();
        $products=Product::orderBy('id','DESC')->get();
        $category=category::all();
        return view('manageProducts',compact('products','category','user'));
    }
    public function displayProduct(){
        $products=Product::orderBy('id','DESC')->get();
        return view('welcome',compact('products'));
    }

    public function addProduct(Request $request){
        $loginUser= auth()->user();
        $product=new Product;
        $product->name=$request->name;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->categoryId=$request->categoryId;
        $product->addedBy=$loginUser->id;

        

        if($request->hasfile('image')){
            $file=$request->file('image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('uploads/product-img',$filename);
            $product->imgName=$filename;
        }else{
            return $request;
            $product->imgName='';
        }
        $product->save();
        
        return 'product added';
    }

    public function editProduct($id){
         $id=\Crypt::decrypt($id);
         $product=Product::where('id',$id)->first();
         $category=category::all();
         return view('editProduct',compact('product','category')) ;
    }
    public function updateProduct(Request $request){
        // auth()->user();
        $id=$request->id;
        $product_to_be_updated=Product::where('id',$id)->first();
        $product_to_be_updated->name=$request->name;
        $product_to_be_updated->price=$request->price;
        $product_to_be_updated->description=$request->description;
        $product_to_be_updated->categoryId=$request->categoryId;

        if($request->hasfile('image')){
            $destination='uploads/product-img'.$product_to_be_updated->imgName;
            if(File::exists($destination)){
                File::delete($destination);
            }
            $file=$request->file('image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('uploads/product-img',$filename);
            $product_to_be_updated->imgName=$filename;
        }
        $product_to_be_updated->update();
        return redirect('manageProducts');
    }

    public function deleteProduct($id){
        $id=\Crypt::decrypt($id);
        $product=Product::where('id',$id)->first();
        $productImg=$product->imgName;
        $destination='uploads/product-img'.$productImg;
            if(File::exists($destination)){
                unlink($destination);
                return redirect('Product');
            }
        $product->delete();

        return redirect('manageProducts');
    }
}
