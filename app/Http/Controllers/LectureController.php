<?php

namespace App\Http\Controllers;

use App\Models\LectureUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LectureController extends Controller
{
    //
    public function unlockLecture(Request $request){
        $user = Auth::user();
        $unlockLecture = new LectureUser();
        $unlockLecture->lecture_id = $request->lectureId;
        $unlockLecture->user_id = $user->id;

        $user->coins-= 100;

        $user->save();
        $unlockLecture->save();
        return redirect('/modules/' . $request->lectureId);
    }
}
