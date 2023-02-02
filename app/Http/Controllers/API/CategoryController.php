<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\category;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = category::latest()->get();
        return response()->json([CategoryResource::collection($data), 'Các chương trình đã tìm nạp.']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $Category = category::create([
            'name' => $request->name,

         ]);
        
        return response()->json(['Chương trình được tạo thành công.', new CategoryResource($Category)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Category = category::find($id);
        if (is_null($Category)) {
            return response()->json('Dữ liệu không tồn tại', 404); 
        }
        return response()->json([new CategoryResource($Category)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $Category)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $Category->name = $request->name;
        $Category->save();
        
        return response()->json(['Chương trình được cập nhật thành công.', new CategoryResource($Category)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $Category)
    {
        $Category->delete();

        return response()->json('Đã xóa chương trình thành công');
    }
}