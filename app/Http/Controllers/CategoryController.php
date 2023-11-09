<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
public function category_create(){
    $category=Category::all();

    return view('category',compact('category'));
}

public function category_store(Request $request){

    $category=$request->category;
    $description=$request->description;
    $categoryCol=new Category();
    $categoryCol->nameCategory= $category;
    if($description){
    $categoryCol->description= $description;
    }

    $categoryCol->save();

    return back()->with('SuccessProductArticle','Category ajouté avec succès ! ');
}

public function category_update_create($id){
    $category=Category::find($id);
    return view('categoryUpdate',compact('category'));
}

public function category_update(Request $request,$id){

    $category=$request->category;
    $description=$request->description;
    $categoryCol= Category::find($id);
    $categoryCol->nameCategory= $category;
    if($description){
    $categoryCol->description= $description;
    }

    $categoryCol->save();

    return redirect()->route('category_create')->with('SuccessProductArticle','Category modifié avec succès ! ');
}

public function category_delete($id){
    $categoryCol=Category::find($id);
    $result=$categoryCol->delete();
     if($result){
        return redirect()->route('category_create')->with('errorCategory','Category supprimé avec succès !');
     }
}

}
