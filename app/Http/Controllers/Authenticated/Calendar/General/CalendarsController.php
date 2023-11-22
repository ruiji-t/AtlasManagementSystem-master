<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show(){
        // time():現時刻　→今月分のカレンダーとする
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    // 予約機能
    public function reserve(Request $request){

        DB::beginTransaction();
        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;

            // dd($getDate);
            $reserveDays = array_filter(array_combine($getDate, $getPart));

             foreach($reserveDays as $key => $value){

                // reserve_settingsテーブルの初期データの作成
                if(is_null(ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first())){
                    ReserveSettings::create([
                            'setting_reserve' => $key,
                            'setting_part' => $value,
                    ]);
                }

                $reserve_settings = ReserveSettings::where('setting_reserve', $key)
                ->where('setting_part', $value)
                ->first();
                // dd($reserve_settings);
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    // 予約のキャンセル機能
    public function delete(Request $request){
        DB::beginTransaction();
        try{
            $reserveDate = $request->input('reserve_date');
            $reservePart = $request->input('reserve_part');

            $reserve_deleting = ReserveSettings::where('setting_reserve',$reserveDate)
            ->where('setting_part',$reservePart)
            ->first();

            // reserve_settingsテーブルの'limit_users'をインクリメント
            $reserve_deleting->increment('limit_users');
            // reserve_setting_usersテーブルの対象レコードを削除
            $reserve_deleting->users()->detach(Auth::id());

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

}
