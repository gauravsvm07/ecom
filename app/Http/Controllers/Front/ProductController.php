<?php

namespace App\Http\Controllers\Front;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductEnquiry;
use App\Models\ProductPriceSize;
use App\Models\CustomCategory;
use App\Models\Banner;
use App\Models\GeneralProduct;
use Hash;
use Response;
use Auth;
use Illuminate\Routing\Controller as BaseController;

class ProductController extends BaseController
{
	///use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function searchProducts(Request $request)
	{
		$keyword = $request->keyword;

		$data['products'] = Product::leftJoin('general_products', 'products.id', 'general_products.product_id')->orderBy('general_products.name', 'asc')->where('product_type', 1)->where('parent_id', 0)->where('general_products.status', 1)->where('general_products.name', 'like', '%' . $keyword . '%')->paginate(20);
		return view('front.products')->with($data);
	}

	public function products(Request $request)
	{
		$data['products'] = Product::leftJoin('general_products', 'products.id', 'general_products.product_id')->orderBy('general_products.name', 'asc')->where('product_type', 1)->where('parent_id', 0)->where('general_products.status', 1)->paginate(20);
		return view('front.products')->with($data);
	}

	public function categoryProducts($slug)
	{
		$category = Category::where('slug', $slug)->first();
		$category_id = $category->id;
		$data['products'] = Product::leftJoin('general_products', 'products.id', 'general_products.product_id')->orderBy('general_products.name', 'asc')->where('product_type', 1)->where('parent_id', 0)->where('general_products.status', 1)->where('general_products.category_id', $category_id)->paginate(20);
		return view('front.products')->with($data);
	}

	public function productDetails($slug)
	{
		$data['product'] = Product::select('products.id as product_id', 'general_products.*')->leftJoin('general_products', 'products.id', 'general_products.product_id')->where('product_type', 1)->where('general_products.status', 1)->where('general_products.slug', $slug)->first();

		if ($data['product']) {
			$product_id = $data['product']->product_id;
			$pdata = Product::where('id', $product_id)->first();
			$parent_id = $pdata->parent_id;
			if ($parent_id == 0) {
				$data['product_price_size'] = Product::select('products.id as product_id', 'general_products.*')->leftJoin('general_products', 'products.id', 'general_products.product_id')->where('product_type', 1)->where('general_products.status', 1)->where('products.id', $product_id)->orWhere('products.parent_id', $product_id)->orderBY('size', 'asc')->get();
			} else {
				$data['product_price_size'] = Product::select('products.id as product_id', 'general_products.*')->leftJoin('general_products', 'products.id', 'general_products.product_id')->where('product_type', 1)->where('general_products.status', 1)->where('products.id', $parent_id)->orWhere('products.parent_id', $parent_id)->orderBY('size', 'asc')->get();
			}

			return view('front.product-details')->with($data);
		} else {
			dd('Data not found');
		}
	}


	public function displayProducts(Request $request)
	{
		$data['banners'] = Banner::where('status', 1)->where('banner_type', 'display')->orderBy('id', 'asc')->get();
		$data['products'] = Product::leftJoin('display_products', 'products.id', 'display_products.product_id')->orderBy('display_products.name', 'asc')->where('products.product_type', 3)->where('display_products.status', 1)->paginate(20);
		return view('front.display-products')->with($data);
	}


	public function displayProductDetails($slug)
	{

		$data['product'] = Product::select('display_products.*', 'products.id as pid')->leftJoin('display_products', 'products.id', 'display_products.product_id')->where('product_type', 3)->where('display_products.status', 1)->where('display_products.slug', $slug)->first();
		$data['other_products'] = Product::leftJoin('display_products', 'products.id', 'display_products.product_id')->orderBy('display_products.name', 'asc')->where('products.product_type', 3)->where('display_products.status', 1)->where('display_products.slug', '!=', $slug)->get();

		if ($data['product']) {
			$product_id = $data['product']->pid;
			$data['product_images'] = ProductImage::where('product_id', $product_id)->get();
			$data['product_price_size'] = ProductPriceSize::where('product_id', $product_id)->where('price', '!=', '')->where('size', '!=', '')->get();
			//dd(count($data['product_price_size']));
			return view('front.display-product-details')->with($data);
		} else {
			dd('Data not found');
		}
	}



	public function customCategory(Request $request)
	{
		$data['banners'] = Banner::where('status', 1)->where('banner_type', 'custom')->orderBy('id', 'asc')->get();
		$data['categories'] = CustomCategory::where('status', 1)->get();
		return view('front.custom-category')->with($data);
	}

	public function customCategoryProducts($slug)
	{
		$data['category'] = CustomCategory::where('slug', $slug)->first();
		$category_id = $data['category']->id;
		//dd($category_id);
		$data['products'] = Product::leftJoin('custom_products', 'products.id', 'custom_products.product_id')->orderBy('custom_products.name', 'asc')->where('product_type', 2)->where('custom_products.status', 1)->where('custom_products.category_id', $category_id)->paginate(20);
		return view('front.custom-products')->with($data);
	}

	public function customProductDetails($slug)
	{
		$data['product'] = Product::select('custom_products.*', 'products.id as pid')->leftJoin('custom_products', 'products.id', 'custom_products.product_id')->where('product_type', 2)->where('custom_products.status', 1)->where('custom_products.slug', $slug)->first();
		if ($data['product']) {
			$product_id = $data['product']->pid;
			$data['product_images'] = ProductImage::where('product_id', $product_id)->get();
			$data['product_price_size'] = ProductPriceSize::where('product_id', $product_id)->where('price', '!=', '')->where('size', '!=', '')->get();
			//dd(count($data['product_price_size']));
			return view('front.custom-product-details')->with($data);
		} else {
			dd('Data not found');
		}
	}

	public function getPriceSize(Request $request)
	{
		$pid = $request->id;
		$data = GeneralProduct::where('product_id', $pid)->first();
		return Response()->json(['price' => $data->price, 'size' => $data->size, 'product_id' => $pid, 'success' => true]);
		//$price = $data->
	}


	public function saveProductEnquiry(Request $request)
	{
		$product = new ProductEnquiry();
		$product->enq_type = $request->enq_type;
		$product->name = $request->name;
		$product->email_id = $request->email;
		$product->mobile = $request->mobile;
		$product->product_name = $request->product_name;
		$product->product_price = $request->product_price;
		$product->product_size = $request->product_size;
		$product->product_quantity = $request->product_quantity;

		$product->size = $request->size;
		$product->border = $request->border;
		$product->shape = $request->shape;

		if ($files = $request->file('image')) {
			$imageName = time() . '.' . $request->image->extension();
			$request->image->move(public_path('uploads/enquiry/'), $imageName);
			$product->image = $imageName;
		}

		$product->save();
		return redirect()->back()->with('msg', 'Inquiry send successfully.');
	}
}
