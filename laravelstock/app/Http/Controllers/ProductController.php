<?php

namespace App\Http\Controllers;

use App\Models\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Throwable;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return (config('global.pro_status')[0]);
        //อ่านข้อมูล
        $products = Product::latest()->paginate(2);

        return view('backend.pages.products.index',compact('products'))->with('i',(request()->input('page',1)-1)*2);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.products.create');

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // echo $request->input('product_name');
        // echo $request->product_barcode;
        echo "<pre>";
        print_r($request->all());
        echo "</pre>";

        $rules = [
            'product_name' => 'required',
            'product_barcode' => 'required|integer|digits:13|unique:products',
            'product_qty' => 'required',
            'product_price' => 'required',
            'product_category' => 'required'
        ];

        $messages = [
            'required' => 'ฟิลด์ :attribute นี้จำเป็น',
            'integer' => 'ฟิลด์นี้ต้องเป็นตัวเลขเท่านั้น',
            'digits' => 'ฟิลด์ :attribute ต้องเป็นตัวเลขความยาว :digits หลัก',
            'unique' => 'รายการนี้มีอยู่แล้วในตาราง (ห้ามซ้ำ)'
        ];

        $validator = Validator::make($request->all(), $rules,$messages);

        if($validator->fails()){ // ตรวจสอบไม่ผ่าน
            return redirect()->back()->withErrors($validator)->withInput();
        }else{

            $product_data = array(
                'product_name'=>$request->product_name,
                'product_detail'=>$request->product_detail,
                'product_barcode'=>$request->product_barcode,
                'product_qty'=>$request->product_qty,
                'product_price'=>$request->product_price,
                'product_category'=>$request->product_category,
                'product_status'=>$request->product_status,
                'create_at'=> NOW(),
                'updated_at'=>NOW()
            );
            //upload product image
            try{
                $image = $request->file('product_image');
                // เช็คว่ามีการเลือกไฟล์ภาพเข้ามาหรือไม่
                if(!empty($image)){
                    $file_name = "product_".time().".".$image->getClientOriginalExtension();
                    if($image->getClientOriginalExtension() == "jpg" or $image->getClientOriginalExtension() == "png"){
                        $manager = new ImageManager(new Driver());
                        $imgWidth = 300;
                        $folderupload = "assets/images/products";
                        $path = $folderupload."/".$file_name;

                        // upload to folder products
                        $img = $manager->read($image->getRealPath());

                        if($img->width() > $imgWidth){
                            $img->resize($imgWidth, null, function($constraint){
                                $constraint->aspectRatio();
                            });
                        }

                        $img->save($path);
                        $product_data['product_image'] = $file_name;
                    }else{
                        return redirect()->route('products.create')->withErrors($validator)->withInput()->with('status','<div class="alert alert-danger">ไฟล์ภาพไม่รองรับ อนุญาติเฉพาะ .jpg และ .png</div>');
                    }
                }
            }catch (Throwable $e) {
                print_r($e->getMessage());
                return false;
            }

            $status = Product::create($product_data);
            return redirect()->route('products.create')->with('success','Add new product success');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('backend.pages.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('backend.pages.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return redirect()->route('products.index')->with('update_success','Update product success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success','Delete product success');
    }
}
