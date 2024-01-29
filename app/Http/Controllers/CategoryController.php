<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;

class CategoryController extends Controller
{
    //
    public function addCategory(Request $request)
    {
        $cat=new category;
        $cat->name=$request->name;
        if($request->hasfile('image')){
            $file=$request->file('image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('uploads/category_images',$filename);
            $cat->imgName=$filename;
        }else{
            return $request;
            $cat->imgName='';
        }
        $cat->save();
        
        return 'data inserted';
    }

    public function listCategory(){
        $Categories=category::orderBy('id','DESC')->get();
        return view('manageCategory',compact('Categories'));
    }

    public function fetchCategory(){     
        $category=category::orderBy('id','DESC')->get();
        return view('product',compact('category'));
    }

    public function editCategory($id){
        $id=\Crypt::decrypt($id);
        $catData=category::where('id',$id)->first();
        return view('editCategory',compact('catData'));
    }
    public function updateCategory(Request $request){
        $id=$request->id;
        $category_to_be_updated=category::where('id',$id)->first();
        $category_to_be_updated->name=$request->name;
        $pevious_img_name=$category_to_be_updated->imgName;
        if($request->hasfile('image')){
            $file=$request->file('image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('uploads/category_images',$filename);
            $category_to_be_updated->imgName=$filename;
        }
        $category_to_be_updated->save();
        return redirect('manageCategory');
    }

    public function deleteCategory($id){
        $id=\Crypt::decrypt($id);
        $delete=category::where('id',$id)->delete();
        return redirect()->back();
    }
}
