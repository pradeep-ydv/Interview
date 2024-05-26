<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner = Banner::orderBy('id', 'DESC')->get();
        return view('backend.banner.index')->with('banners', $banner);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'title' => 'string|required|max:50',
            'description' => 'string|nullable',
            'photo' => 'required',
            'status' => 'required|in:active,inactive',
        ]);
        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = Banner::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;

        if($request->hasfile('photo')){

            $image = $request->file('photo');
            $image_extention = $image->getClientOriginalExtension();
            $image_file= preg_replace('/\s+/', '', $slug).'.'.$image_extention;
            $image->move('storage/Banner/',$image_file);
            $data['photo'] = $image_file;
        }

       
        // return $slug;
        $status = Banner::create($data);
        if ($status) {
            session()->flash('success', 'Banner successfully added');
        } else {
            session()->flash('error', 'Error occurred while adding banner');
        }
        return redirect()->route('banner.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('backend.banner.edit')->with('banner', $banner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $this->validate($request, [
            'title' => 'string|required|max:50',
            'description' => 'string|nullable',
            'photo' => 'required',
            'status' => 'required|in:active,inactive',
        ]);
        $data = $request->all();
        $slug=Str::slug($request->title);
        $count=Banner::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        // return $slug;

        if($request->hasfile('photo')){

            $image_destination = 'storage/Banner/'.$banner->photo;
            if(File::exists($image_destination)){

                File::delete($image_destination);
            }
            $image = $request->file('photo');
            $image_extention = $image->getClientOriginalExtension();
            $image_file= preg_replace('/\s+/', '', $slug).time().'.'.$image_extention;
            $image->move('storage/Banner/',$image_file);
           $data['photo'] = $image_file;
        }


        $status = $banner->fill($data)->save();
        if ($status) {
            session()->flash('success', 'Banner successfully updated');
        } else {
            session()->flash('error', 'Error occurred while updating banner');
        }
        return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $status = $banner->delete();
        if ($status) {
            session()->flash('success', 'Banner successfully deleted');
        } else {
            session()->flash('error', 'Error occurred while deleting banner');
        }
        return redirect()->route('banner.index');
    }
}
