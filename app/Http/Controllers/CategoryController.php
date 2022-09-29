<?php

namespace App\Http\Controllers;
use DataTables;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
class CategoryController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = app('firebase.database');
    
    }
    public function create(Request $request){
        $category_name = $request->category_name;
        $list= $this->database->getReference('category/')
        ->getValue();
       $count = count($list);
       $i=0;
       $lastIndex =0;
        foreach ($list as  $value) {
            if(++$i === $count)
            {
                 $lastIndex= $value['id'];
            
                 $data =[
                     'id'=> $lastIndex+1,
                     'category_name'=> $category_name 
             ];      
            $this->database->getReference('category/'.$lastIndex+1)->set($data);
            }
          
        }
//         $id_AI = $request->id;
//         $category_name = $request->category_name;
//         $data =[
//             'id'=> $id_AI,
//             'category_name'=> $category_name 
            
//     ];
//    $this->database->getReference('category/'.$id_AI)->set($data);
// dd(count($list));
    }
    public function edit(Request $request){
        
    }
    public function delete(Request $request){
        
    }
    public function get_id(Request $request){
        
    }
    public function show(Request $request){
        return response()->json($this->database->getReference('category/')
        ->orderByChild('id')
       
        ->getValue());
    }
    // public function  getdata(Request $request){
    //     if ($request->ajax()) {
    //         $data =response()->json($this->database->getReference('category')
    //         ->getValue());
    //         return DataTables::of($data)
    //                 ->addIndexColumn()
    //                 ->addColumn('action', function($row){
    //                        $btn = '<a class="btn btn btn-success btn-sm mr-1"  href="javascript:void(0)">Xem Chi Tiêt </a>';
    //                        $btn =  $btn.'<a class="btn btn-primary btn-sm " data-bs-toggle="modal" data-bs-target="#staticBackdrop" title="sua"onclick="return tintuc('.$row->id.')"  href="javascript:void(0)">Sửa</a>';
    //                        $btn = $btn.' <a onclick="return xoatintuc('.$row->id.')" href="javascript:void(0)" class="btn btn-danger btn-sm ">Xóa</a>';
    
    //                         return $btn;
    //                 })
    //                 ->rawColumns(['action'])
    //                 ->make(true);
    //     }
    //     return view("pages.AddCategory");
    // }
}
