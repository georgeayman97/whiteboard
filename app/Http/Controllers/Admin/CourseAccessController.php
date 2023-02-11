<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersEnrolledExport;
use App\Http\Controllers\Controller;
use App\Models\CourseAccess;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CourseAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id =  null)
    {
        $coursesAccesses = CourseAccess::all()->where('status','request')
        ->sortByDesc('created_at')->load('course','user');
        if($id == null){
            $coursesAccesses = CourseAccess::all()->where('status','request')
            ->sortByDesc('created_at')->load('course','user');
        }else{
            $coursesAccesses = CourseAccess::all()->where('status','request')->where('course_id',$id)
        ->sortByDesc('created_at')->load('course','user');
        }
        
        $success = session()->get('success');
        return view('admin.accounts.coursesRequest',[
            'coursesAccesses' => $coursesAccesses,
            'success' => $success,
        ]);
    }

    public function approve($id)
    {
        $coureseaccess = CourseAccess::findOrFail($id);
        
        if($coureseaccess) {
            $coureseaccess->status = CourseAccess::STATUS_ENROLLED;
            $coureseaccess->save();
        }
        return back()->with('success',"$coureseaccess->name Activated Successfully");
    }

    public function export() 
    {
        return Excel::download(new UsersEnrolledExport, 'Students.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coureseaccess = CourseAccess::findOrFail($id);
        $coureseaccess->delete();

        
        return back()->with('success',"$coureseaccess->name Deleted Successfully");
    }
    
}
