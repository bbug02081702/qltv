<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\publisher;
use App\Http\Resources\PublisherResource;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Publisher::latest()->get();
        return response()->json([PublisherResource::collection($data), 'Các chương trình đã tìm nạp.']);
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

        $Publisher = publisher::create([
            'name' => $request->name,

         ]);
        
        return response()->json(['Chương trình được tạo thành công.', new PublisherResource($Publisher)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Publisher = publisher::find($id);
        if (is_null($Publisher)) {
            return response()->json('Dữ liệu không tồn tại', 404); 
        }
        return response()->json([new PublisherResource($Publisher)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, publisher $Publisher)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $Publisher->name = $request->name;
        $Publisher->save();
        
        return response()->json(['Chương trình được cập nhật thành công.', new PublisherResource($Publisher)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(publisher $Publisher)
    {
        $Publisher->delete();

        return response()->json('Đã xóa chương trình thành công');
    }
}