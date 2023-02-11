@extends('layouts.admin')


@section('content')

<div class="db-breadcrumb">
				<h4 class="breadcrumb-title">Course Requests</h4>
				<ul class="db-breadcrumb-list">
					<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
					<li>Requests</li>
                    <li>Course Enrollment</li>
				</ul>
			</div>
            
            <div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title col-12">
                            <div class="form-row">
                            <h4 class="col-11">Course Enrollment</h4>
                            <a class="btn btn-primary" href="{{ route('export.enrolled') }}" role="button">Export</a>
                            </div>
						</div>
						<div class="widget-inner">


                            <div class="table-responsive">
                                <table class="table">
                                <thead>
                                    <tr>
                                        
                                        
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>EMAIL ADDRESS</th>
                                        <th>MOBILE NUMBER</th>
                                        <th>STATUS</th>
                                        <th>ENROLLMENT DATE</th>
                                        <th>VIEWS</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- we have automatic directives istead of this way -->
                                    <!-- php// foreach($categories as $category) : // : istead of '{'  -->
                                        
                                        @foreach($enrollment as $enroll)
                                            
                                    <tr>
                                        
                                        <td>{{ $enroll->user->id }}</td>
                                        <td>{{ $enroll->user->name }}</td>
                                        <td>{{ $enroll->user->email }}</td>
                                        <td>{{ $enroll->user->mobile }}</td>
                                        @if($enroll->status == 'enrolled')
                                        <td class="btn button-md green radius-xl" style="margin-top: 4px;">{{ $enroll->status }}</td>
                                        @else
                                        <td class="btn button-md red radius-xl" style="margin-top: 4px;">{{ $enroll->status }}</td>
                                        @endif
                                        <td>{{ $enroll->updated_at }}</td>
                                        <td>{{ $usersviews[$enroll->user->id] ?? 0}}</td>
                                        @if($enroll->status == 'enrolled')
                                        <td><form action="{{ route('accounts.disable', $enroll->id)}}" method="get">
                                            @csrf
                                            <button type="submit" class="btn red btn-sm btn-danger">Disable</button>
                                        </form></td>
                                        @else
                                        <td><form action="{{ route('accounts.enroll', $enroll->id)}}" method="get">
                                            @csrf
                                            <button type="submit" class="btn green btn-sm">Enroll</button>
                                        </form></td>
                                        @endif
                                        <!-- <td><form action="{{ route('usertracking.counter', ['user_id' => $enroll->user->id,
                                                    'course_id'=>$enroll->course_id])}}" method="get">
                                            @csrf
                                            <button type="submit" class="btn red btn-sm btn-danger">Views</button>
                                        </form></td> -->
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