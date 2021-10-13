<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\TimeSlot;
use App\Http\Resources\TimeSlotResource;

class TimeSlotController extends BaseController
{
    public function getAllTimeSlot()
    {
        try {
            \DB::beginTransaction();
            $timeslots = TimeSlot::where('status','Active')->get();
            \DB::commit();
            if(isset($timeslots[0]->id)){                
            $timeslot = TimeSlotResource::collection($timeslots);      
            return $this->sendResponse('Slot fetch successfully',$timeslot);
        }else{            
            return $this->sendError('Slot Not available yet now', 400);  
        }
    }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
        }        
    }
}
