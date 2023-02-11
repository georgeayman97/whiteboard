@extends('layouts.admin')


@section('content')

<div class="db-breadcrumb">
				<h4 class="breadcrumb-title">Course Requests</h4>
				<ul class="db-breadcrumb-list">
					<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
					<li>Requests</li>
                    <li>Course Requests</li>
				</ul>
			</div>
            
            <div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title col-12">
							<h4 class="col-6">Course Requests</h4>
						</div>
						<div class="widget-inner">


                            <div class="table-responsive">
                                <table class="table">
                                <thead>
                                    <tr>
                                        
                                        
                                        <th>ID</th>
                                        <th>USER NAME</th>
                                        <!-- <th>USER EMAIL</th> -->
                                        <th>COURSE NAME</th>
                                        <th>STATUS</th>
                                        <th>REQUEST DATE</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- we have automatic directives istead of this way -->
                                    <!-- php// foreach($categories as $category) : // : istead of '{'  -->
                                        
                                        @foreach($coursesAccesses as $coursesAccess)
                                            
                                    <tr>
                                        
                                        <td>{{ $coursesAccess->id }}</td>
                                        <td>{{ $coursesAccess->user->name }}</td>
                                        <td>{{ $coursesAccess->course->name }}</td>
                                        <td class="btn button-md green radius-xl" style="margin-top: 4px;">{{ $coursesAccess->status }}</td>
                                        <td>{{ $coursesAccess->created_at }}</td>
                                        <td><form action="{{ route('courseaccess.approve', $coursesAccess->id)}}" method="get">
                                            @csrf
                                            <button type="submit" class="btn green btn-sm">Approve</button>
                                        </form></td>
                                        <td><form action="{{ route('courseaccess.destroy', $coursesAccess->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn red btn-sm btn-danger">Delete</button>
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