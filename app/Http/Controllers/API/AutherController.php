<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\auther;
use App\Http\Resources\AutherResource;

class AutherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = auther::latest()->get();
        return response()->json([AutherResource::collection($data), 'Các chương trình đã tìm nạp.']);
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

        $Auther = auther::create([
            'name' => $request->name,

         ]);
        
        return response()->json(['Chương trình được tạo thành công.', new AutherResource($Auther)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Auther = auther::find($id);
        if (is_null($Auther)) {
            return response()->json('Dữ liệu không tồn tại', 404); 
        }
        return response()->json([new AutherResource($Auther)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auther $Auther)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $Auther->name = $request->name;
        $Auther->save();
        
        return response()->json(['Chương trình được cập nhật thành công.', new AutherResource($Auther)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(auther $Auther)
    {
        $Auther->delete();

        return response()->json('Đã xóa chương trình thành công');
    }
}