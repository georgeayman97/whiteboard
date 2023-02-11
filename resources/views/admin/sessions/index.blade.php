@extends('layouts.admin')


@section('content')

<div class="db-breadcrumb">
				<h4 class="breadcrumb-title">Sessions</h4>
				<ul class="db-breadcrumb-list">
					<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
					<li>Course Name</li>
                    <li>Sessions</li>
				</ul>
			</div>
           
            <div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
                    
					<div class="widget-box">
                    <div class="form-row">
                <div class="wc-title col-md-11">
							<h4 class="col-6">Your Sessions For <span>{{$course->name}}</span></h4>
                            
                </div>
                <div class="wc-title col-md-1">
                <a class="btn btn-primary" href="{{ route('sessions.create', $course->id)}}" role="button">
                    <i class="fa fa-plus"> Sessions</i></a>
                </div>
                
            </div>
                            
                            
                            
						<div class="widget-inner">
                        

                            <div class="table-responsive">
                                <table class="table">
                                <thead>
                                    <tr>
                                        
                                        <th>LOOB</th>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>DESCRIPTION</th>
                                        <th>COURSE NAME</th>
                                        <th>STATUS</th>
                                        <th>CREATED AT</th>
                                        <th>Action</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- we have automatic directives istead of this way -->
                                    <!-- php// foreach($categories as $category) : // : istead of '{'  -->
                                        @foreach($sessions as $session)
                                    
                                    <tr>
                                        
                                        <td>{{ $loop->first?'First':($loop->last?'Last':$loop->iteration)}}</td>
                                        <td>{{ $session->id }}</td>
                                        <td>{{ $session->name }}</td>
                                        <td>{{ $session->description }}</td>
                                        <td>{{ $course->name }}</td>
                                        @if($session->status == "disabled")
                                        <td class="btn button-md red radius-xl text-center" style="margin-top: 4px;">{{ $session->status }}</td>
                                        @else
                                        <td class="btn button-md green radius-xl text-center" style="margin-top: 4px;">{{ $session->status }}</td>
                                        @endif
                                        <td>{{ $session->created_at }}</td>
                                        @if($session->status == 'active')
                                        <td><a href="{{ route('sessions.changeStatus', $session->id)}}" class="btn btn-sm btn-dark">Disable</a></td>
                                        @else
                                        <td><a href="{{ route('sessions.changeStatus', $session->id)}}" class="btn btn-sm btn-dark">Activate</a></td>
                                        @endif
                                        <td><a href="{{ route('sessions.edit', $session->id)}}" class="btn btn-sm btn-dark">Edit</a></td>
                                        <td><form action="{{ route('sessions.destroy', $session->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form></td>
                                    </tr>
                                    @endforeach
                                    <!-- php// endforeach // istead of '}'  -->
                                </tbody>
                                </table>
                            </div>


                        </div>
					</div>
				</div>
				<!-- Your Profile Views Chart END-->
			</div>

@endsection