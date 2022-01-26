<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\ProductPriceSize;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductEnquiry;
use App\Models\GeneralProduct;
use App\Models\CustomProduct;
use App\Models\DisplayProduct;
use App\Models\CustomCategory;
use File;


class ProductController extends BaseController
{
  ///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


  public function generalProductForm(Request $request)
  {
    $data['product'] = '';

    if ($request->id) {
      $product_id = $request->id;
      $general_product = GeneralProduct::where('product_id', $product_id)->first();
      $gp_id = $general_product->id;
      $data['variations'] = Product::select('products.*', 'general_products.*', 'products.id as pid')->leftJoin('general_products', 'products.id', 'general_products.product_id')->where('products.parent_id', $product_id)->get();
      $data['product'] = GeneralProduct::find($gp_id);
    }

    $data['product_category'] = Category::orderBy('id', 'asc')->pluck('title', 'id')->toArray();
    return view('admin.product.general-product-form')->with($data);
  }

  public function copyGeneralProductForm($product_id)
  {
    $general_product = GeneralProduct::where('product_id', $product_id)->first();
    $gp_id = $general_product->id;
    $data['product'] = GeneralProduct::find($gp_id);
    $data['product_category'] = Category::orderBy('id', 'asc')->pluck('title', 'id')->toArray();
    return view('admin.product.copy-general-product-form')->with($data);
  }

  public function saveGeneralProduct(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|max:255',
      'category_id' => 'required',
      'status' => 'required',
    ]);

    if (isset($request->product_id)) {
      $product = Product::find($request->product_id);
      $general = GeneralProduct::where('product_id', $request->product_id)->first();
      $general_product = GeneralProduct::find($general->id);
      if ($product->parent_id == 0) {
        $parent_id = 0;
      } else {
        $parent_id = $product->parent_id;
      }
      $msg = 'Product updated successfully';
    } else {
      $product = new Product;
      $general_product = new GeneralProduct;
      $parent_id = 0;
      $msg = 'Product saved successfully';
    }

    $product->name = $request->name;
    $product->product_type = 1;
    $product->parent_id = $parent_id;
    $product->save();
    $product_id = $product->id;
    $general_product->product_id = $product_id;
    $general_product->category_id = $request->category_id;
    $general_product->name = $request->name;
    if ($request->name) {
      $general_product->slug = Str::slug($request->name, '-') . '-' . time();
    }

    $general_product->quantity = 10;
    $general_product->description = $request->description;

    if ($files = $request->file('featured_img')) {

      $request->validate([
        'featured_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);

      if (\File::exists(public_path('uploads/products/' . $request->old_featured_img))) {
        \File::delete(public_path('uploads/products/' . $request->old_featured_img));
      }
      $imageName = time() . '.' . $request->featured_img->extension();
      $request->featured_img->move(public_path('uploads/products/'), $imageName);
      $general_product->featured_img = $imageName;
    }
    $general_product->price = $request->price;
    $general_product->size = $request->size;
    $general_product->status = $request->status;
    $general_product->save();

    return redirect()->back()->with('msg', $msg);
  }

  public function saveCopyGeneralProduct(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|max:255',
      'category_id' => 'required',
      'status' => 'required',
    ]);

    $product = new Product;
    $general_product = new GeneralProduct;
    $msg = 'Variation saved successfully';
    $product->name = $request->name;
    $product->product_type = 1;
    $product->parent_id = $request->product_id;
    $product->save();
    $product_id = $product->id;
    $general_product->product_id = $product_id;
    $general_product->category_id = $request->category_id;
    $general_product->name = $request->name;
    $general_product->slug = Str::slug($request->name, '-') . '-' . time();
    $general_product->quantity = 10;
    $general_product->description = $request->description;
    $general_product->featured_img = $request->featured_img;
    $general_product->price = $request->price;
    $general_product->size = $request->size;
    $general_product->status = $request->status;
    $general_product->save();
    return redirect('auth/edit-general-product/' . $request->product_id)->with('msg', $msg);
  }

  public function generalProductList()
  {
    $data['products'] = Product::leftJoin('general_products', 'general_products.product_id', 'products.id')->where('products.product_type', 1)->where('products.parent_id', 0)->where('general_products.name', '!=', '')->orderBy('products.name', 'asc')->paginate(10);
    return view('admin.product.general-product-list')->with($data);
  }


  public function customProductForm(Request $request)
  {
    $data['product'] = '';
    if ($request->id) {
      $data['product_images'] = ProductImage::where('product_id', $request->id)->get();
      $product_id = $request->id;
      $custom_product = CustomProduct::where('product_id', $product_id)->first();
      $data['product_id'] = $request->id;
      $cp_id = $custom_product->id;
      $data['product'] = CustomProduct::find($cp_id);
    }

    $data['product_category'] = CustomCategory::orderBy('id', 'asc')->pluck('title', 'id')->toArray();
    return view('admin.product.custom-product-form')->with($data);
  }

  public function saveCustomProduct(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|max:255',
      'category_id' => 'required',
      'status' => 'required',
    ]);


    // dd($request->id);
    if (isset($request->id)) {
      $product = Product::find($request->id);
      $delete_price = ProductPriceSize::where('product_id', $request->id)->delete();
      $custom = CustomProduct::where('product_id', $request->id)->first();
      $custom_product = CustomProduct::find($custom->id);
      $msg = 'Product updated successfully';
    } else {
      $product = new Product;
      $custom_product = new CustomProduct;
      $msg = 'Product saved successfully';
    }

    $product->name = $request->name;
    $product->product_type = 2;
    $product->save();
    $product_id = $product->id;
    $custom_product->product_id = $product_id;
    $custom_product->category_id = $request->category_id;
    $custom_product->name = $request->name;
    $custom_product->slug = Str::slug($request->name, '-') . '-' . time();
    $custom_product->quantity = 10;
    $custom_product->description = $request->description;

    if ($files = $request->file('featured_img')) {
      $request->validate([
        'featured_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);

      if (\File::exists(public_path('uploads/products/' . $request->old_featured_img))) {
        \File::delete(public_path('uploads/products/' . $request->old_featured_img));
      }
      $imageName = time() . '.' . $request->featured_img->extension();
      $request->featured_img->move(public_path('uploads/products/'), $imageName);
      $custom_product->featured_img = $imageName;
    }

    $custom_product->status = $request->status;
    $custom_product->save();


    // if($request->hasfile('image'))
    // {
    //   foreach($request->file('image') as $file)
    //   {
    //    $rand_number = rand(1111,9999);
    //    $name = $rand_number.time().'.'.$file->extension();
    //    $file->move(public_path().'/uploads/products/', $name);  

    //    $product_image= new ProductImage();
    //    $product_image->file_name=$name;
    //    $product_image->product_id=$product_id;
    //    $product_image->save();

    //  }
    // }


    return redirect()->back()->with('msg', $msg);
  }

  public function customProductList()
  {
    $data['products'] = Product::leftJoin('custom_products', 'custom_products.product_id', 'products.id')->orderBy('products.id', 'desc')->where('products.product_type', 2)->paginate(10);
    return view('admin.product.custom-product-list')->with($data);
  }

  public function displayProductForm(Request $request)
  {
    $data['product'] = '';
    if ($request->id) {
      $data['product_images'] = ProductImage::where('product_id', $request->id)->get();
      $product_id = $request->id;
      $display_product = DisplayProduct::where('product_id', $product_id)->first();
      $data['size_prices'] = ProductPriceSize::where('product_id', $product_id)->where('price', '!=', '')->get();
      $ds_id = $display_product->id;
      $data['product'] = DisplayProduct::find($ds_id);
    }

    $data['product_category'] = CustomCategory::orderBy('id', 'asc')->pluck('title', 'id')->toArray();
    return view('admin.product.display-product-form')->with($data);
  }

  public function saveDisplayProduct(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|max:255',
      'status' => 'required',
    ]);


    // dd($request->id);
    if (isset($request->id)) {
      $product = Product::find($request->id);
      $delete_price = ProductPriceSize::where('product_id', $request->id)->delete();
      $display = DisplayProduct::where('product_id', $request->id)->first();
      $display_product = DisplayProduct::find($display->id);
      $msg = 'Product updated successfully';
    } else {
      $product = new Product;
      $display_product = new DisplayProduct;
      $msg = 'Product saved successfully';
    }


    $product->name = $request->name;
    $product->product_type = 3;
    $product->save();


    $product_id = $product->id;
    $display_product->product_id = $product_id;
    $display_product->name = $request->name;
    $display_product->slug = Str::slug($request->name, '-') . '-' . time();
    $display_product->quantity = 10;
    $display_product->description = $request->description;

    if ($files = $request->file('featured_img')) {
      $request->validate([
        'featured_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);

      if (\File::exists(public_path('uploads/products/' . $request->old_featured_img))) {
        \File::delete(public_path('uploads/products/' . $request->old_featured_img));
      }
      $imageName = time() . '.' . $request->featured_img->extension();
      $request->featured_img->move(public_path('uploads/products/'), $imageName);
      $display_product->featured_img = $imageName;
    }

    $display_product->status = $request->status;
    $display_product->save();

    return redirect()->back()->with('msg', $msg);
  }

  public function displayProductList()
  {
    $data['products'] = Product::leftJoin('display_products', 'display_products.product_id', 'products.id')->where('products.product_type', 3)->orderBy('products.id', 'desc')->paginate(10);
    return view('admin.product.display-product-list')->with($data);
  }


  public function displayOrder()
  {
    $data['enq'] = ProductEnquiry::orderBy('id', 'desc')->paginate(10);
    return view('admin.product.product-enquiry')->with($data);
  }


  public function deleteProduct(Request $request)
  {
    $id = $request->id;
    $row = Product::find($id);
    // if (\File::exists(public_path('uploads/products/' . $row->featured_img))) {
    //   \File::delete(public_path('uploads/products/' . $row->featured_img));
    // }
    $delData = Product::where('id', $id)->delete();
    $prd = GeneralProduct::where('product_id', $id)->delete();
    $prd = CustomProduct::where('product_id', $id)->delete();
    $prd = DisplayProduct::where('product_id', $id)->delete();
    $prd = ProductPriceSize::where('product_id', $id)->delete();
    return response()->json(['msg' => 'deleted']);
  }


  public function deleteProductImage(Request $request)
  {
    $id = $request->id;
    $row = ProductImage::find($id);
    if (\File::exists(public_path('uploads/products/' . $row->file_name))) {
      \File::delete(public_path('uploads/products/' . $row->file_name));
    }
    $delData = ProductImage::where('id', $id)->delete();
    return redirect()->back()->with('msg', 'Product Image deleted successfully');
  }

  public function searchProducts(Request $request)
  {
    $keyword = $request->keyword;
    $data['products'] = Product::leftJoin('general_products', 'general_products.product_id', 'products.id')->where('products.product_type', 1)->where('products.parent_id', 0)->where('general_products.name', '!=', '')->where('general_products.name', 'like', '%' . $keyword . '%')->orderBy('products.name', 'asc')->paginate(10);
    return view('admin.product.general-product-list')->with($data);
  }
}
