<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersEnrolledExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return ["User Name", "Course Name" , "Status"];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $enrolled = Session::get('enrolledUsers');
        foreach($enrolled as $enroll){
            $enroll->user_id = $enroll->user->name;
            $enroll->course_id = $enroll->course->name;
        }
        return $enrolled;
    }
    
}
