<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\book;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = book::latest()->get();
        return response()->json([BookResource::collection($data), 'Các chương trình đã tìm nạp.']);
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
            'author_id'=>'required',
            'category_id'=>'required',
            'publisher_id'=>'required',
            'status'=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $Book = book::create([
            'author_id' => $request->name,
            'category_id' => $request->category_id,
            'publisher_id' => $request->publisher_id,
            'status' => $request->status

         ]);
        
        return response()->json(['Chương trình được tạo thành công.', new BookResource($Book)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Book = book::find($id);
        if (is_null($Book)) {
            return response()->json('Dữ liệu không tồn tại', 404); 
        }
        return response()->json([new BookResource($Book)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $Book)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'author_id'=>'required',
            'category_id'=>'required',
            'publisher_id'=>'required',
            'status'=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $Book->name = $request->name;
        $Book->author_id = $request->author_id;
        $Book->category_id = $request->category_id;
        $Book->publisher_id = $request->publisher_id;
        $Book->status = $request->status;
        $Book->save();
        
        return response()->json(['Chương trình được cập nhật thành công.', new BookResource($Book)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(book $Book)
    {
        $Book->delete();

        return response()->json('Đã xóa chương trình thành công');
    }
}