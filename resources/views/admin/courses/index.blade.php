@extends('layouts.admin')


@section('content')
            <div class="db-breadcrumb">
				<h4 class="breadcrumb-title">Courses</h4>
				<ul class="db-breadcrumb-list">
					<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
					<li>Courses</li>
				</ul>
			</div>
<div class="shop-content_wrapper">
                        
            <div class="container-fluid">
                <div class="row">

                    @if(auth()->user()->role == 'admin')
                    <div class="col-lg-3 col-md-5 order-2 order-lg-1 order-md-1">
                        <div class="uren-sidebar-catagories_area">
                            <div class="category-module uren-sidebar_categories">
                                <div class="category-module_heading">
                                    <h5>Doctors</h5>
                                </div>
                                <div class="module-body">
                                    <ul class="module-list_item">
                                        
                                        <li>
                                            <a href="/admin/filtering/courses?doctor={{ '' }}&{{ http_build_query(request()->except('doctor','page')) }}">All Doctors</a>
                                            @for($i = 0 ; $i < count($doctors) ; $i++)
                                            <a href="/admin/filtering/courses?doctor={{ $doctors[$i][0] }}&{{ http_build_query(request()->except('doctor','page')) }}">{{$doctors[$i][1]}} <span>{{$doctors[$i][2]}}</span></a>
                                            @endfor

                                            <!-- <a class="active" href="javascript:void(0)">Shop <span>(18)</span></a> -->
                                            <!-- <ul class="module-sub-list_item">
                                                <li>
                                                    <a href="javascript:void(0)">Brakes & Rotors <span>(8)</span></a>
                                                    <a href="javascript:void(0)">Lighting <span>(8)</span></a>
                                                    <a href="javascript:void(0)">Perfomance <span>(13)</span></a>
                                                    <a href="javascript:void(0)">Wheels & Tires <span>(13)</span></a>
                                                </li>
                                            </ul> -->
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="uren-sidebar_categories">
                                <div class="uren-categories_title">
                                    <h5>Years</h5>
                                </div>
                                <ul class="sidebar-checkbox_list">
                                            
                                    <li>
                                        <a href="/admin/filtering/courses?course_year={{ '' }}&{{ http_build_query(request()->except('course_year','page')) }}">All Years</a>
                                    </li>
                                    @for($i = 0 ; $i < count($years) ; $i++)
                                    <li>
                                        <a @if(isset( $currentYear) && $currentYear == $years[$i][0]) class="active" @endif 
                                        href="/admin/filtering/courses?course_year={{ $years[$i][0] }}&{{ http_build_query(request()->except('course_year','page')) }}">{{$years[$i][0]}} <span>{{$years[$i][1]}}</span></a>
                                    </li>
                                    @endfor
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="col-lg-9 col-md-7 order-1 order-lg-2 order-md-2">
                        <div class="shop-toolbar">
                            <!-- <div class="product-view-mode">
                                <a class="grid-1" data-target="gridview-1" data-toggle="tooltip" data-placement="top" title="1">1</a>
                                <a class="grid-2" data-target="gridview-2" data-toggle="tooltip" data-placement="top" title="2">2</a>
                                <a class="active grid-3" data-target="gridview-3" data-toggle="tooltip" data-placement="top" title="3">3</a>
                                <a class="grid-4" data-target="gridview-4" data-toggle="tooltip" data-placement="top" title="4">4</a>
                                <a class="grid-5" data-target="gridview-5" data-toggle="tooltip" data-placement="top" title="5">5</a>
                                <a class="list" data-target="listview" data-toggle="tooltip" data-placement="top" title="List"><i class="fa fa-th-list"></i></a>
                            </div> -->
                            <!-- <div class="product-item-selection_area">
                                <div class="product-short">
                                    <label class="select-label">Short By:</label>
                                    <select class="myniceselect nice-select">
                                        <option value="1">Default</option>
                                        <option value="2">Name, A to Z</option>
                                        <option value="3">Name, Z to A</option>
                                        <option value="4">Price, low to high</option>
                                        <option value="5">Price, high to low</option>
                                        <option value="5">Rating (Highest)</option>
                                        <option value="5">Rating (Lowest)</option>
                                        <option value="5">Model (A - Z)</option>
                                        <option value="5">Model (Z - A)</option>
                                    </select>
                                </div>
                                <div class="product-showing">
                                    <label class="select-label">Show:</label>
                                    <select class="myniceselect short-select nice-select">
                                        <option value="1">15</option>
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                    </select>
                                </div>
                            </div> -->
                        </div>
                        <div class="wc-title">
							<h4>Your Courses</h4>
						</div>
                        <div class="shop-product-wrap grid gridview-2 img-hover-effect_area row">

                        @foreach($courses as $course)
                            <div class="col-lg-4">
                                <div class="product-slide_item">
                                    <div class="inner-slide">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href="{{ route('sessions.show', $course->id)}}">
                                                    <img class="primary-img" style="width:100%; height:32em;" src="{{ $course->image_url }}" >
                                                    <div class="secondary-img" style="text-align: center; background-color: rgba(0, 0, 0, .3); height:inherit; width:100%; margin-top: 20px;">
                                                        <h3 style="color: white;">Dr. {{ $course->doctor->name }}</h3>
                                                        <h4 style="color: white;">Description</h4>
                                                        <p style="color: white;">{{ $course->description }}</p>
                                                    </div>
                                                    
                                                    <!-- <img class="secondary-img" alt="{{ $course->description }}" style="left: 1em; text-align:right ; background-color: rgba(0, 0, 0, .3); height:inherit; width:inherit; margin-top: 20px;"> -->
                                                </a>
                                                @if($course->status == "active")
                                                <div class="sticker">
                                                    <span class="sticker" style="background-color: #5FDBA7;">{{ $course->status }}</span>
                                                </div>
                                                @else
                                                <div class="sticker">
                                                    <span class="sticker" style="background-color: red;">{{ $course->status }}</span>
                                                </div>
                                                @endif
                                                <div>
                                                    <span class="badge badge-secondary" >{{ $course->course_year }}</span>
                                                </div>
                                                <div class="add-actions">
                                                    <ul>
                                                        <li><a style="height:3.5em; width: 7em;" class="uren-add_cart" href="{{ route('sessions.create', $course->id)}}" data-toggle="tooltip" data-placement="top" title="Add new Session"><i
                                                            class="fa fa-plus"> Sessions</i></a>
                                                        </li>
                                                        <li><a style="height:3.5em; width: 5em;" class="uren-add_cart" href="{{ route('courses.edit', $course->id)}}" data-toggle="tooltip" data-placement="top" title="Edit Course"><i
                                                            class="fa fa-edit"> Edit</i></a>
                                                        </li>
                                                        <li><a style="height:3.5em; width: 7em;" class="uren-add_cart" href="{{ route('accounts.enrolled', $course->id)}}" data-toggle="tooltip" data-placement="top" title="Add new Course"><i
                                                            class="fa fa-users">Enrolled</i></a>
                                                        </li>
                                                        <li><a style="height:3.5em; width: 7em;" class="uren-add_cart" href="{{ route('courseaccess.requests', $course->id)}}" data-toggle="tooltip" data-placement="top" title="Add new Course"><i
                                                            class="fa fa-users">Requests</i></a>
                                                        </li>
                                                        <li><form class="uren-add_cart" action="{{ route('courses.destroy', $course->id)}}"  method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" style="background-color:red; height:3.5em; width: 3em; border-radius: 6px;" class="uren-add_cart" data-toggle="tooltip" data-placement="top" title="Delete Course"><i
                                                            class="fa fa-remove"></i></button>
                                                        </form></li>
                                                        <!-- <li><a style="background-color:red; height:3.5em; width: 3em;" class="uren-add_cart" href="" data-toggle="tooltip" data-placement="top" title="Delete Course"><i
                                                            class="fa fa-remove"></i></a>
                                                        </li> -->
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-desc_info">
                                                    <!-- <div class="rating-box">
                                                        <ul>
                                                            <li><i class="ion-android-star"></i></li>
                                                            <li><i class="ion-android-star"></i></li>
                                                            <li><i class="ion-android-star"></i></li>
                                                            <li class="silver-color"><i class="ion-android-star"></i>
                                                            </li>
                                                            <li class="silver-color"><i class="ion-android-star"></i>
                                                            </li>
                                                        </ul>
                                                    </div> -->
                                                    <h6 style="margin-top: 5px;"><a class="fa product-name" href="{{ route('sessions.show', $course->id)}}" >{{ $course->name }}</a></h6>
                                                    <div class="price-box">
                                                        <span class="new-price">EGP {{ $course->price }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-slide_item">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <a href="single-product.html">
                                                <img class="primary-img" src="{{ $course->image_url }}" >
                                                <img class="secondary-img" alt="{{ $course->name }}" >
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-desc_info">
                                                <div class="rating-box">
                                                    <ul>
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li class="silver-color"><i class="ion-android-star"></i>
                                                        </li>
                                                        <li class="silver-color"><i class="ion-android-star"></i>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <h6><a class="product-name" href="{{ route('sessions.show', $course->id)}}">{{ $course->name }}</a></h6>
                                                <div class="price-box">
                                                    <span class="new-price">$150.00</span>
                                                </div>
                                                <div class="product-short_desc">
                                                    <p>{{ $course->name }}</p>
                                                </div>
                                            </div>

                                            <div class="add-actions">
                                                <ul>
                                                    <li><a class="uren-add_cart" href="" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="ion-bag"></i></a>
                                                    </li>
                                                    <li><a class="uren-wishlist" href="" data-toggle="tooltip" data-placement="top" title="Add To Wishlist"><i
                                                        class="ion-android-favorite-outline"></i></a>
                                                    </li>
                                                    <li><a class="uren-add_compare" href="" data-toggle="tooltip" data-placement="top" title="Compare This Product"><i
                                                        class="ion-android-options"></i></a>
                                                    </li>
                                                    <li class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter"><a href="" data-toggle="tooltip" data-placement="top" title="Quick View"><i
                                                        class="ion-android-open"></i></a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        @endsection