<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\PageSection;
use App\Models\PageCategory;
use App\Models\Cms;
use App\Models\Setting;
use App\Models\Category;
use App\Models\ProductPriceSize;
use App\Models\OrderStatus;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use App\Models\GeneralProduct;
use App\Models\MedalPrice;
use Auth;


class Helper
{

  public static function checkTest()
  {
    return 'hello';
  }


  public static function getPageSection($slug)
  {
    $page = Cms::where('slug', $slug)->first();
    return $page;
  }


  public static function getSetting($key)
  {
    $setting = Setting::where('setting_key', $key)->first();
    return $setting->setting_value;
  }

  public static function adminCan($module, $can)
  {
    return Auth()->guard('admin')->user()->can($module, $can);
  }

  public static function getCategories()
  {
    $categories = Category::where('status', 1)->orderBy('title', 'asc')->get();
    return $categories;
  }

  public static function getOrderStatus()
  {
    $status = OrderStatus::where('status', 1)->orderBy('id', 'asc')->get();
    return $status;
  }

  public static function getProductPriceSize($product_id)
  {
    $price_size = ProductPriceSize::where('product_id', $product_id)->where('price', '!=', '')->first();
    return $price_size;
  }

  public static function getProductSize($product_id)
  {
    $data = GeneralProduct::where('product_id', $product_id)->first();
    return $data->size . ' INCH' ?? '';
  }

  public static function setProductSize($product_id)
  {
    $data = GeneralProduct::where('product_id', $product_id)->first();
    return $data->size ?? '';
  }

  public static function getOrderItems($order_id)
  {
    $data = OrderItem::select('general_products.*', 'order_items.*', 'order_items.quantity as item_quantity')->leftJoin('general_products', 'general_products.product_id', 'order_items.product_id')->where('order_id', $order_id)->get();
    return $data;
  }

  public static function getOrderAddress($order_id)
  {
    $data = OrderAddress::where('order_id', $order_id)->where('address_type', 'billing')->first();
    return $data;
  }

  public static function userOrderItemCount($user_id)
  {
    $orderCount = OrderItem::where('user_id', $user_id)->count();
    return $orderCount;
  }

  public static function getMedalPriceBySize($medal_size)
  {
    $medal = MedalPrice::where('medal_size', $medal_size)->first();
    return $medal->medal_price;
  }
}
