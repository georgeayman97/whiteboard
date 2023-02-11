<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Course;
use App\Models\Session;
use App\Models\CourseAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CoursesAccessController extends Controller
{
    // Getting all Courses at the begining of the app
    public function index(Request $request) {
        
        $user = Auth::guard('sanctum')->user();
        $courses = Course::latest()->with('doctor')->where('subject_id',$request->subject_id)->get();

        foreach($courses as $course){
            // $path = getcwd().'\uploads'.'\\'.$course->image_path;
            // $path = Response::download($path);
            $course->instructor_name = $course->doctor['name'];
            $course->image_path = 'http://medicalonlineacademy.com/uploads/'.$course->image_path;
            $course->setAttribute('sessions_count', Course::find($course->id)->sessions->count());
            $user_enrolled_in = CourseAccess::where('user_id',$user->id)->where('status','enrolled')->get()->pluck('course_id');
            unset($course['doctor']);
        }
        if($user->status == 'active' && isset($courses[0])){
            return Response::json([
                'courses' => $courses,
                'user_enrolled_in', $user_enrolled_in
            ], 200);
        }else if(!isset($courses[0])){
            return Response::json([
                'message' => 'Sorry there is no courses for this User year',
            ], 401);
        }else{
            return Response::json([
                'message' => 'Sry this User not active yet please contact support',
            ], 401);
        }
        

    }

    public function show(Request $request) {

        $request->validate([
            'course_id' => ['required'],
        ]);
        $user = Auth::guard('sanctum')->user();
        $course = Course::findOrFail($request->course_id);
        $course->image_path = 'http://medicalonlineacademy.com/uploads/'.$course->image_path;
        $course->instructor_name = User::where('id',$course->instructor_name)->pluck('name')->first();
        
        $ifenrolled = CourseAccess::where('user_id',$user->id)->where('course_id',$request->course_id)->get()->pluck('status')->contains('enrolled');


        $sessions = Session::where('course_id',$request->course_id)
        ->select('id', 'name')->get()->sortByDesc('created_at');
    
        return Response::json([
            'course' => $course,
            'sessions' => $sessions,
            'if_enrolled' =>$ifenrolled
        ], 200);
    }

    public function store(Request $request){

        $request->validate([
            'course_id' => ['required'],
        ]);
        $user = Auth::guard('sanctum')->user();
        if(Course::find($request->course_id)){
            $course = Course::findOrFail($request->course_id);
            if($course->status == 'active'){
                
                $coursesRequestedByUser = User::find($user->id)->CourseAccesses->pluck('course_id');
                foreach($coursesRequestedByUser as $cc){
                    if($cc == $request->course_id){
                        return Response::json([
                            'message' => 'Sorry you cant request this course any more',
                        ], 401);
                    }
                }
                
                $courseRequest = CourseAccess::create([
                    'course_id' => $request->course_id,
                    'user_id' => $user->id,
                    'status' => CourseAccess::STATUS_REQUEST
                ], 200);
                return Response::json([
                    'message' => 'Your request submitted successfully with number: '. $courseRequest->id,
                    'course_name' => $course->name
                ], 401);
                
                
            }
        }
        return Response::json([
            'message' => 'Sorry you cant request this course',
        ], 401);
    }

    
}