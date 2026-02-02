<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseDelHistory;
use App\Models\CourseEnrollment;
use App\Models\CourseHistory;
use App\Models\CourseStatus;
use App\Models\InstructorAnn;
use App\Models\InstructorEarning;
use App\Models\Lecture;
use App\Models\Media;
use App\Models\Section;
use App\Models\ResVideo;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;


class DashboardController extends Controller
{

    function validate_user($course_id)
    {
        return Course::where([['user_id', Auth::id()], ['id', $course_id]])->firstOrFail();
    }


    public function index() {
        return view("welcome");
    }
}
