
<div class="top-slider">
<div id="diesSlider" class="owl-carousel">

               @php $categories = App\Helpers\Helper::getCategories(); @endphp
               @php $currentCategory=Request::segment(2);  @endphp
               @foreach($categories as $category)
               <div class="item">
                  <li class="dies-pic @if($category->slug==$currentCategory)active @endif">
                     <a href="{{url('products/'.$category->slug)}}">
                     <img src="{{URL::asset('uploads/category/'.$category->image)}}" alt=""/>
                     <span>{{strtoupper($category->title)}}</span> 
                     </a>
                  </li>
               </div>
               @endforeach
            </div>
</div>