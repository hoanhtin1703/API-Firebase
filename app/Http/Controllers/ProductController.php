<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
class ProductController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = app('firebase.database');
    
    }
    public function create(Request $request){
        /** 
         * ? Chức năng :Thêm sản phẩm
         * TODO Lấy dữ liệu sản phẩm  từ client
         * * Lấy dữ liệu client
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
        // TODO Lấy dữ liệu sản phẩm  từ client
        $product_name = $request->product_name;  
        $product_quantity = $request->product_quantity; 
        $category_price = $request->category_price; 
        $product_description = $request->product_description; 
        $category_id = $request->category_id; 
        $product_rateStar = $request->product; 
      
        // TODO Lấy hình ảnh danh mục từ client
        $get_image = $request->file('image');        // * Lấy hình ảnh từ  input file('image)
        $get_name_image = $get_image->getClientOriginalName();//* Đổi đuôi file ảnh
        $name_image = current(explode('.', $get_name_image));//* Đổi đuôi file ảnh
        $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();//* Đổi đuôi file ảnh
        $get_image->move('public/upload/product', $new_image); // * Đưa ảnh vào thư mục public/upload/product
       // TODO Lấy danh mục hình ảnh sản phẩm từ client
      
            // $data1 = [];
if($request->hasfile('images'))
 {
    $get_library = $request->file('images');
for ($i = 0; $i < count($get_library); $i++) {
    $image = $get_library[$i];
    $get_name_image = $image->getClientOriginalName();
    $name_image1 = current(explode('.', $get_name_image));
    $new_library_image =  $name_image1 . rand(0, 99) . '.' . $image->getClientOriginalExtension();
    $image->move('public/upload/product', $new_library_image);
    $library_image[] = $new_library_image;
    }
 }
        
        //TODO Thêm bản ghi vào cơ sở dữ liệu
        $list= $this->database->getReference('product/')->getValue(); //* Lấy danh sách category
        $count = count($list); //* Đếm số lượng của mảng
        $i=0; //* Cho biến i bằng 0 rồi vòng lặp i cho đến khi i bằng số lượng của mảng
        $lastIndex =0;
        foreach ($list as $value) //* Cho biến i bằng 0 rồi vòng lặp i cho đến khi i bằng số lượng của mảng
        {
            if(++$i === $count){
                $lastIndex= $value['id']; // * Gán biến lastIndex(id cuối cùng) bằng giá trị id
                $data =[
                'id'=> $lastIndex+1, //* Lưu data với id +1
                'product_name' => $product_name,
                'product_image'=> $new_image,
                'product_quantity' => $product_quantity,
                'category_price' => $category_price,
                'product_description' => $product_description,
                'product_sold' => 0,
                'category_id' => $category_id,
                'product_rateStar'=> $product_rateStar,
                'image_library' => json_encode($library_image),
                ];
         $this->database->getReference('product/'.$lastIndex+1)->set($data); //* Lưu data với id +1
        }
 }
    }
    public function edit(Request $request,$id){
            // TODO Lấy dữ liệu sản phẩm  từ client
            $product_name = $request->product_name;  
            $product_quantity = $request->product_quantity; 
            $category_price = $request->category_price; 
            $product_description = $request->product_description; 
            $category_id = $request->category_id; 
            $product_rateStar = $request->product; 
         // TODO Lấy hình ảnh danh mục từ client
         $get_image = $request->file('image');    // * Lấy hình ảnh từ  input file('image)
         $get_library = $request->file('images');
         if($get_image==null)
         {
            if($get_library==null)
            {
                $data =[
                    'product_name' => $product_name,
                    'product_quantity' => $product_quantity,
                    'category_price' => $category_price,
                    'product_description' => $product_description,
                    'product_sold' => 0,
                    'category_id' => $category_id,
                    'product_rateStar'=> $product_rateStar,
                   
                    ];
                 $this->database->getReference('product/'.$id)->update($data);
            }
            else
            {
                if($request->hasfile('images'))
                {
                $current_file =  $this->database->getReference('product/'.$id.'/image_library')->getValue();
                $data = explode(",",str_replace(array('[',']','?','!','%','@','"'),'',$current_file));
                for ($i=0; $i < count($data); $i++) { 
                    $path = 'public/upload/product';
                    unlink($path.'/'.$data[$i]);
                }
                    $get_library = $request->file('images');
                for ($i = 0; $i < count($get_library); $i++) {
                    $image = $get_library[$i];
                    $get_name_image = $image->getClientOriginalName();
                    $name_image1 = current(explode('.', $get_name_image));
                    $new_library_image =  $name_image1 . rand(0, 99) . '.' . $image->getClientOriginalExtension();
                    $image->move('public/upload/product', $new_library_image);
                    $library_image[] = $new_library_image;
                    }
                $data =[
                    'product_name' => $product_name,
                    'product_quantity' => $product_quantity,
                    'category_price' => $category_price,
                    'product_description' => $product_description,
                    'product_sold' => 0,
                    'category_id' => $category_id,
                    'product_rateStar'=> $product_rateStar,
                    'image_library' => json_encode($library_image),
                    ];
                $this->database->getReference('product/'.$id)->update($data);
            }
            }
         }
         else 
         {
            $current_file =  $this->database->getReference('product/'.$id.'/product_image')->getValue();
                // $data = explode(",",str_replace(array('[',']','?','!','%','@','"'),'',$current_file));
                    $path = 'public/upload/product';
                    unlink($path.'/'.$current_file);
             $get_name_image = $get_image->getClientOriginalName();//* Đổi đuôi file ảnh
             $name_image = current(explode('.', $get_name_image));//* Đổi đuôi file ảnh
             $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();//* Đổi đuôi file ảnh
             $get_image->move('public/upload/product', $new_image); // * Đưa ảnh vào thư mục public/upload/product
             $data =[
                'product_name' => $product_name,
                'product_quantity' => $product_quantity,
                'category_price' => $category_price,
                'product_description' => $product_description,
                'product_sold' => 0,
                'category_id' => $category_id,
                'product_rateStar'=> $product_rateStar,
                'product_image'=> $new_image,
                ];
             $this->database->getReference('product/'.$id)->update($data);
         }
         
    }
    public function delete(Request $request,$id){
        return response()->json($this->database->getReference('product/'.$id)->remove());
    }
    public function get_id(Request $request , $id){
        return response()->json($this->database->getReference('product/'.$id)->getValue());
        
    }
    public function show(Request $request){
        return response()->json($this->database->getReference('product/')->getValue());
    }
   
}
