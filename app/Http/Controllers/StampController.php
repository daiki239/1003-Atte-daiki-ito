<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StampController extends Controller
{
    public function index()
    {   $authuser = Auth::user();
        return view('index', ['authuser' => $authuser]);
        
    }


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


public function stamped(Request $request) {
      $id = Auth::id();
        $dt = new Carbon();
        $date = $dt->toDateString();
        $time = $dt->toDateTimeString();


        
        $attendance = Attendance::where('user_id', $id)->whereNull('end_time')->where('date', $date)->first();

        $total_break_time = Rest::where('break_out');


        
        if (!empty($attendance)) {
            $attendance->update(['end_time' => $time, 'toral_break_time' => $rest_id]);
            return redirect('/')->with('result', '勤務を終了しました');
        } else {
            return redirect()->back()->with('result', '勤務が開始されていないか、勤務が終了されています');
        }

        
    }


    public function rest(Request $request)  {
        $latestWorkTime = Work_Time::where('user_id', $request->user_id)->latest()->first();
        $latestBreakTime = Break_Time::where('work__time_id', $latestWorkTime->id)->latest()->first();
        if($latestWorkTime->start_time && !($latestWorkTime->end_time)) {
            if(empty($latestBreakTime->break_in)) {
                $data = [
                    'break_in' => Carbon::now(),
                ];
                Break_Time::create([
                    'user_id' => $latestWorkTime->user_id,
                    'work__time_id' => $latestWorkTime->id,
                    'break_in' => $data['break_in'],
                ]);
                return redirect()->back();
            }elseif($latestBreakTime->break_in && $latestBreakTime->break_out) {
                $data = [
                    'break_in' => Carbon::now(),
                ];
                Break_Time::create([
                    'user_id' => $latestWorkTime->user_id,
                    'work__time_id' => $latestWorkTime->id,
                    'break_in' => $data['break_in'],
                ]);
                return redirect()->back();
            }
        }
        return redirect()->back()->with('message', '休憩開始が実行できません');
    }
    
      
      

    public function rested(Request $request) {
        $latestWorkTime = Work_Time::where('user_id', $request->user_id)->latest()->first();
        $latestBreakTime = Break_Time::where('work__time_id', $latestWorkTime->id)->latest()->first();
        $latestWorkStart = new Carbon($latestWorkTime->start_time);
        $oldDay = $latestWorkStart->copy()->startOfDay();
        $addDay = $oldDay->copy()->addDay();
        $today = Carbon::today();
        $now = Carbon::now();

        if($latestBreakTime->break_in && empty($latestBreakTime->break_out)) {
            if($addDay == $today){
                $workStart = new Carbon($latestWorkTime->start_time);
                $endOfDay = new Carbon($oldDay->copy()->endOfDay());
                
                $latestBreakTime->update([
                'work__time_id' => $latestBreakTime->work__time_id,
                'break_out' => $endOfDay,
                ]);
                $breakTimes = Break_Time::where('work__time_id', $latestWorkTime->id)->get();
                $diffStayHours = $workStart->diffInHours($endOfDay);
                $diffStayMinutes = $workStart->diffInMinutes($endOfDay);
                $diffStaySeconds = $workStart->diffInSeconds($endOfDay);
                foreach($breakTimes as $breakTime){
                    $breakStart = new Carbon($breakTime->break_in);
                    $breakEnd = new Carbon($breakTime->break_out);
                    $diffBreakHours[] = $breakStart->diffInHours($breakEnd);
                    $diffBreakMinutes[] = $breakStart->diffInMinutes($breakEnd);
                    $diffBreakSeconds[] = $breakStart->diffInSeconds($breakEnd);
                }
                $totalBreakHours = array_sum($diffBreakHours);
                $totalBreakMinutes = array_sum($diffBreakMinutes);
                $totalBreakSeconds = array_sum($diffBreakSeconds);

                $workTimeHours = $diffStayHours - $totalBreakHours;
                $workTimeMinutes = $diffStayMinutes - $totalBreakMinutes;
                $workTimeSeconds = $diffStaySeconds - $totalBreakSeconds;

                $totalHoursWorked = $oldDay->copy()->setTime($workTimeHours, $workTimeMinutes, $workTimeSeconds);
                $totalBreakTime = $oldDay->copy()->setTime($totalBreakHours, $totalBreakMinutes, $totalBreakSeconds);
                $date = [
                        'date' => $oldDay,
                        'end_time' => $endOfDay,
                        'total_hours_worked' => $totalHoursWorked,
                        'total_break_time' => $totalBreakTime,
                ];
                $this->validate($request, $date, Work_Time::$rules);
                $latestWorkTime->update([
                    'user_id' => $request->user_id,
                    'date' => $date['date'],
                    'end_time' => $date['end_time'],
                    'total_hours_worked' => $date['total_hours_worked'],
                    'total_break_time' => $date['total_break_time'],
                ]);
                $items = [
                        'date' => $today,
                        'start_time' => $today,
                ];
                $this->validate($request, $items, Work_Time::$rules);
                Work_Time::create([
                    'user_id' => $request->user_id,
                    'date' => $items['date'],
                    'start_time' => $items['start_time'],
                ]);

                $moreLatestWorkTime = Work_Time::where('user_id', $request->user_id)->latest()->first();
                Break_Time::create([
                    'user_id' => $moreLatestWorkTime->user_id,
                    'work__time_id' => $moreLatestWorkTime->id,
                    'break_in' => $today,
                    'break_out' => $now,
                ]);
                return redirect()->back();
            }else {
                $latestBreakTime->update([
                'work__time_id' => $latestBreakTime->work__time_id,
                'break_out' => Carbon::now(),
                ]);
                return redirect()->back();
            }
        }else {
            return redirect()->back()->with('message', '休憩終了が実行できません');
        }
    
    }


public function attendance(Request $request)
    {
          $attendances = Attendance::all();
        return view('attendance', ['attendances' => $attendances]);
    }

}