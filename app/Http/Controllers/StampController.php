<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Rest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthorRequest;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class StampController extends Controller
{
    public function index()
    {   $authuser = Auth::user();
        return view('index', ['authuser' => $authuser]);
        
    }

//勤怠開始処理
    public function stamp(Request $request) {
     
        $id = Auth::id();
        $dt = new Carbon();
        $date = $dt->toDateString();
        $time = $dt->toDateTimeString(); 


        //Attendanceテーブルから、・ログイン中のuser_id・$dateの日付が合致する一番最初のレコードを取得
        $attendance = Attendance::where('user_id', $id)->where('date', $date)->first();
        

        $oldAttendance = Attendance::where('user_id', $id)->latest()->first();
        $oldAttendanceDay = "";
        $newAttendance = Carbon::today();


        //user_idとdateが存在していれば(同日に一回出勤していれば)、エラーを返す
        if (!empty($attendance->user_id) && (!empty($attendance->date))) {
            return redirect()->back()->with('result', '本日はすでに勤務を開始しています');
        }


        if ($oldAttendance) {
            $oldAttendanceDate = new Carbon($oldAttendance->punchIn);
            $oldAttendanceDay = $oldAttendanceDate->startOfDay();
        }

        //同日かつ退勤を押していない状態で出勤が押されてもエラーを返す
        if (($oldAttendanceDay == $newAttendance) && (empty($oldAttendance->punchOut))) {
            return redirect()->back()->with('result', 'すでに勤務を開始しています');
        }

        //attendanceテーブルに登録
        Attendance::create([
            'user_id' => $id,
            'date' => $date,
            'start_time' => $time,
        ]);

        return redirect('/')->with('result', '勤務を開始しました');
    

    }

//退勤処理
public static function stamped() {
       $id = Auth::id();
        $dt = new Carbon();
        $date = $dt->toDateString();
        $time = $dt->toDateTimeString();
        $attendance = Attendance::where('user_id', $id)->where('date', $date)->first();
         
        $attendance_id = $attendance->id;
        $rest = Rest::where('attendance_id', $attendance_id)->whereNull('end_time')->where('date', $date)->first();
       
        if (!empty($attendance)) {
            $attendance->update(['end_time' => $time]);
            
            return redirect('/')->with('result', '休憩を終了しました');
        } else {
            return redirect()->back()->with('result', '休憩が開始されていないか、勤務が終了されています');
        }

    
      }

      //休憩開始処理
    public function rest(Request $request)   {
     
        $id = Auth::id();
        $dt = new Carbon();
        $date = $dt->toDateString();
        $time = $dt->toDateTimeString(); 
        $attendance = Attendance::where('user_id', $id)->where('date', $date)->latest()->first();
        $nostart_time =
        Attendance::where('user_id', $id)->where('date', $date)->whereNull('start_time')->first();
          Rest::create([
             'attendance_id' => $id,
            'date' => $date,
            'start_time' => $time,
        ]);
        return redirect('/')->with('my_status', '退勤打刻が完了しました');
    }
      

//休憩終了処理
    public function rested(Request $request)
    {
        $id = Auth::id();
        $dt = new Carbon();
        $date = $dt->toDateString();
        $time = $dt->toDateTimeString();
        $attendance = Attendance::where('user_id', $id)->where('date', $date)->first();
         
        $attendance_id = $attendance->id;
        $rest = Rest::where('attendance_id', $attendance_id)->whereNull('end_time')->where('date', $date)->first();
       
        if (!empty($rest)) {
            $rest->update(['end_time' => $time]);
            
            return redirect('/')->with('result', '休憩を終了しました');
        } else {
            return redirect()->back()->with('result', '休憩が開始されていないか、勤務が終了されています');
        }

       
    }    

    public function attendance(Request $request)
    {   $id = Auth::id();
        $dt = new Carbon();
        $date = $dt->toDateString();
        $time = $dt->toDateTimeString();
   
     
       $rests = Rest::where('attendance_id',$id)->get();
       
       
        
       $attendances = Attendance::simplePaginate(5)->all();
      $rests = Rest::paginate(5);


       

       return view('attendance', ['attendances' => $attendances]);
        }
   
   



      
  





    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}

