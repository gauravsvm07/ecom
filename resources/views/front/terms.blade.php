@extends('layouts.default-inner')
@section('content')
@section('title', 'Terms and Conditions')

      
      <section class="membership-wrapper">
         <div class="container">
            <div class="row justify-content-center mb-5">
               <div class="col-md-10">
                  <h3 class="heading-big text-center">{{$terms->title}}</h3>
                 
                  
               </div>
            </div>
            <hr>
         </div>
         <div class="container">
            <div class="row align-items-center mt-5">
               
               <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="blog-info">
                      <h5>{{$terms->sub_title}}</h5><br><br>
                     {!! $terms->description !!}
                  </div>
               </div>
            </div>


            
            
            
         </div>
      </section>
      @stop
