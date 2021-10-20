<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\BannerMultiple;
use App\Models\BannerSingle;
use App\Http\Resources\BannerSingleResource;
use App\Http\Resources\BannerMultipleResource;

class BannerController extends BaseController
{
    public function fetchSingleBanner()
    {
     try
     {
         $banner = BannerSingle::where('status','Active')->get();
         if($banner){
           $data = BannerSingleResource::collection($banner);
           return $this->sendResponse('Single Banner fetch successfully.',$data);
       } else {
        return $this->sendError('UNAUTHORIZE ACCESS', 200);
    }
}
catch (\Throwable $e)
{
    return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);
}
}

public function fetchMultipleBanner()
{
 try
 {
     $banner = BannerMultiple::where('status','Active')->get();
     if($banner){
       $data = BannerMultipleResource::collection($banner);
       return $this->sendResponse('Multiple Banner fetch successfully.',$data);
   } else {
    return $this->sendError('UNAUTHORIZE ACCESS', 200);
}
}
catch (\Throwable $e)
{
    return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);
}
}


}