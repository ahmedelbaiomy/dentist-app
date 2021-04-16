<?php
namespace App\Library\Services;
use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
  
class DbHelperTools
{
    public function manageSchedule($data){
        $id=0;
        if (count($data)>0){
            $row = new Schedule();
            $id=(isset($data['id']))?$data['id']:0;
            if ($id > 0) {
                $row = Schedule::find ( $id );
            }
            $row->day = (isset($data['day']))?$data['day']:null;
            $row->slot = (isset($data['slot']))?$data['slot']:null;
            $row->doctor_id = (isset($data['doctor_id']))?$data['doctor_id']:null;
            $row->save ();
            $id = $row->id;
        }
        return $id;
    }
    public function generateDateRange($started_at,$ended_at,$slot_duration = 15)
    {
        $start_date = Carbon::createFromFormat('Y-m-d H:i',$started_at);
        $end_date = Carbon::createFromFormat('Y-m-d H:i',$ended_at);

        $dates = [];
        $slots = $start_date->diffInMinutes($end_date)/$slot_duration;

        //first unchanged time
        $dates[$start_date->toDateString()][]=$start_date->toTimeString();

        for($s = 1;$s <=$slots;$s++){

            $dates[$start_date->toDateString()][]=$start_date->addMinute($slot_duration)->toTimeString();

        }

        return $dates;
    }
    public function getTimeSlotsByDoctorDay($doctor_id,$day){
        $times = [];
        if($doctor_id>0){
            $rSlots = Schedule::where([['doctor_id',$doctor_id],['day',$day]])->pluck('slot')->toArray();
            if(count($rSlots)>0){
                foreach($rSlots as $slot){
                    $dt = Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$slot);
                    $times[]=$dt->format('H:i:s');
                }
            }
        }
        return $times;
    }      
}
