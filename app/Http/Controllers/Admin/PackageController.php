<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function index()
    {
        $pageTitle = 'Packages';
        $packages = Package::orderBy('created_at', 'desc')->paginate(getPaginate());
        return view('admin.packages.index', compact('pageTitle', 'packages'));
    }

    public function create()
    {
        $pageTitle = 'Add new';
        return view('admin.packages.create', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order' => 'numeric',
            'name' => 'required',
            'attr.*' => 'required',
            'price' => 'required',
            'status' => 'required',
        ]);
        $package = new Package;
        $package->name = $request->name;
        $package->price = $request->price;
        $package->attributes = json_encode($request->attr);
        $package->is_featured = $request->is_featured;
        $package->status = $request->status;
        if($package->save()){
            $notify[] = ['success', 'Package has been added successfully'];
            return redirect()->route('admin.packages.index')->withNotify($notify);
        }else{
           $notify[] = ['error', 'Something went wrong!'];
           return back()->withNotify($notify);
        }

    }

    public function edit(Package $package){
        $pageTitle = 'Edit '. $package->name;
        return view('admin.packages.edit', compact('pageTitle', 'package'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'order' => 'numeric',
            'name' => 'required',
            'attr.*' => 'required',
            'price' => 'required',
            'status' => 'required',
        ]);
        $package->name = $request->name;
        $package->price = $request->price;
        $package->attributes = json_encode($request->attr);
        $package->is_featured = $request->is_featured;
        $package->status = $request->status;
        if($package->save()){
            $notify[] = ['success', 'Package has been updated successfully'];
            return redirect()->route('admin.packages.index')->withNotify($notify);
        }else{
            $notify[] = ['error', 'Something went wrong!'];
            return back()->withNotify($notify);
        }
    }
}