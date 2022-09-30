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
        /** 
         * ? Chức năng :Thêm danh mục sản phẩm
         * TODO Lấy tên danh mục từ client
         * * Lấy tên danh mục từ client
         * TODO Lấy hình ảnh danh mục từ client
         * * Lấy hình ảnh từ input file('image)
         * * Đổi đuôi file ảnh
         * * Đưa ảnh vào thư mục public/upload/product
         * TODO Thêm bản ghi vào cơ sở dữ liệu
         * * Lấy danh sách category
         * * Đếm số lượng của mảng 
         * * Cho biến i bằng 0  rồi vòng lặp i cho đến khi i bằng số lượng của mảng
         * * Gán biến lastIndex(id cuối cùng) bằng giá trị id   
         * * Lưu data với id +1
         */
        // TODO Lấy tên danh mục từ client
        $category_name = $request->category_name;   //*Lấy tên danh mục từ client
        // TODO Lấy hình ảnh danh mục từ client
        $get_image = $request->file('image');        // * Lấy hình ảnh từ  input file('image)
        $get_name_image = $get_image->getClientOriginalName();//* Đổi đuôi file ảnh
        $name_image = current(explode('.', $get_name_image));//* Đổi đuôi file ảnh
        $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();//* Đổi đuôi file ảnh
        $get_image->move('public/upload/product', $new_image); // * Đưa ảnh vào thư mục public/upload/product
        //TODO Thêm bản ghi vào cơ sở dữ liệu
        $list= $this->database->getReference('category/')->getValue(); //* Lấy danh sách category
        $count = count($list); //* Đếm số lượng của mảng
        $i=0; //* Cho biến i bằng 0 rồi vòng lặp i cho đến khi i bằng số lượng của mảng
        $lastIndex =0;
        foreach ($list as $value) //* Cho biến i bằng 0 rồi vòng lặp i cho đến khi i bằng số lượng của mảng
        {
            if(++$i === $count){
                $lastIndex= $value['id']; // * Gán biến lastIndex(id cuối cùng) bằng giá trị id
                $data =[
                'id'=> $lastIndex+1, //* Lưu data với id +1
                'category_name'=> $category_name ,
                'image_url'=>$new_image
                ];
         $this->database->getReference('category/'.$lastIndex+1)->set($data); //* Lưu data với id +1
        }
 }
    }
    public function edit(Request $request,$id){
         // TODO Lấy tên danh mục từ client
         $category_name = $request->category_name;   //*Lấy tên danh mục từ client
         // TODO Lấy hình ảnh danh mục từ client
         $get_image = $request->file('image');    // * Lấy hình ảnh từ  input file('image)
         if($get_image==null){
            $data =[
                'category_name'=> $category_name 
                ];
            $this->database->getReference('category/'.$id)->update($data);
         }else{
             $get_name_image = $get_image->getClientOriginalName();//* Đổi đuôi file ảnh
             $name_image = current(explode('.', $get_name_image));//* Đổi đuôi file ảnh
             $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();//* Đổi đuôi file ảnh
             $get_image->move('public/upload/product', $new_image); // * Đưa ảnh vào thư mục public/upload/product
             $data =[
                'category_name'=> $category_name ,
                'image_url'=>$new_image
                ];
             $this->database->getReference('category/'.$id)->update($data);
         }
    }
    public function delete(Request $request,$id){
        return response()->json($this->database->getReference('category/'.$id)->remove());
    }
    public function get_id(Request $request , $id){
        return response()->json($this->database->getReference('category/'.$id)->getValue());
        
    }
    public function show(Request $request){
        return response()->json($this->database->getReference('category/')->getValue());
    }
}