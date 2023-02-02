<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\student;
use App\Http\Resources\StudentResource;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = student::latest()->get();
        return response()->json([StudentResource::collection($data), 'Các chương trình đã tìm nạp.']);
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
            'age' => 'required',
            'gender' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'class' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $Student = student::create([
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'class' => $request->class,

         ]);
        
        return response()->json(['Chương trình được tạo thành công.', new StudentResource($Student)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Student = student::find($id);
        if (is_null($Student)) {
            return response()->json('Dữ liệu không tồn tại', 404); 
        }
        return response()->json([new StudentResource($Student)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $Student)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $Student->name = $request->name;
        $Student->save();
        
        return response()->json(['Chương trình được cập nhật thành công.', new StudentResource($Student)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(student $Student)
    {
        $Student->delete();

        return response()->json('Đã xóa chương trình thành công');
    }
}