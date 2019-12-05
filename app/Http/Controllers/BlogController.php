<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use DB;

class BlogController extends Controller
{
    public function index()
    {
       $blogs = Blog::all();
        return view('admin.blogs.allblog', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function changeStatus($id)
    {
         $data = Blog::find($id);
            if ($data->status == 0) {
                $data->status = 1;
            }
            else {
                $data->status = 0;
            }
        $data->update();
        return back()->with(['message', 'Feature statsu changed!']);
    }

    public function store(Request $request)
    {
        $status = $request->status ? 1 : 0;
        try {
            DB::beginTransaction();
            $insertid = Blog::insertGetId([
                'title'      =>  $request->title,
                'sort_description'=> substr($request->description, 0,80),
                'description'=>  $request->description,
                'status'     =>  $status
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/blog-image'),$imageName);

                Blog::where('id', $insertid)
                        ->update([
                            'blog_image' => $imageName
                        ]);
            }
                DB::commit();
            return back()->with(['message', 'Feature Added successfull']);
                        
        } catch (Exception $e) {
            DB::rollback();
            return back()->withErrors(['message', $e->errorInfo[2]]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Blog::find($id);
        return view('admin.blogs.showblog',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Blog::find($id);
        return view('admin.blogs.editblog',compact('data'));
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
        $status = $request->status ? 1 : 0;
       try {
            DB::beginTransaction();
            $updated = Blog::find($id);
                $updated->update([
                    'title'      =>  $request->title,
                    'sort_description'=> substr($request->description, 0,80),
                    'description'=>  $request->description,
                    'status'     =>  $status
                ]);

            if ($request->hasFile('image')) {

            if(!empty($updated->blog_image) && file_exists('images/blog-image/'.$updated->blog_image)){      
                unlink('images/blog-image/'.$updated->blog_image);
            }
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/blog-image'),$imageName);

                Blog::where('id', $updated->id)
                        ->update([
                            'blog_image' => $imageName
                        ]);
            }
                DB::commit();
            return back()->with(['message', 'Blog updated successfull']);
                        
        } catch (Exception $e) {
            DB::rollback();
            return back()->withErrors(['message', $e->errorInfo[2]]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Blog::find($id);
            if(!empty($data->blog_image) && file_exists('images/blog-image/'.$data->blog_image)){      
                unlink('images/blog-image/'.$data->blog_image);
            }
        $data->delete();
        return back()->with(['message', 'Blog Data Deleted']);
    }

    public function getblog()
    {
        return view('admin.blogs.addblog');
    }
}
