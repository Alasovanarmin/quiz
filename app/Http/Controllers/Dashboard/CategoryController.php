<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create()
    {
        return view('dashboard.category.create');
    }

    public function index()
    {
        $categories = Category::query()
            ->orderByDesc('id')
            ->get();
        return view('dashboard.category.index',compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
        ]);

        Category::query()
            ->create([
                'name' => $request->name
            ]);

        return redirect()->route('dashboard.categories')->with('success', 'Category successfully created');
    }

    public function edit($id , Request $request)
    {
        $category = Category::query()
            ->where('id',$id)
            ->first();
        return view('dashboard.category.edit',compact('category'));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
        ]);

        Category::query()
            ->where('id',$id)
            ->update([
                'name'=>$request->name
            ]);

        return redirect()->route('dashboard.categories')->with('success',"Category successfully updated");
    }

    public function delete($id)
    {
        Category::query()
            ->where('id',$id)
            ->delete();

        return redirect()->route('dashboard.categories')->with('success',"Category successfully deleted");
    }
}
