<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ServiceResource;
class ServiceController extends BaseController
{
  public function getServiceByCategory($id)
  {        

    try {
      \DB::beginTransaction();
      
      $service = Service::with('categories')->where('status','Active')
      ->where('category_id',$id)
      ->get();      
      \DB::commit();
      $services = ServiceResource::collection($service);      
      
      return $this->sendResponse('Service fetch successfully', $services);
    }
    catch (\Throwable $e)
    {
      \DB::rollback();
      return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
    }
  }

  public function getServiceDetail($id)
  {        
    try {
      \DB::beginTransaction();      
      $service = Service::with('categories')->where('status','Active')
      ->where('id',$id)
      ->get();      
      \DB::commit();
      $services = ServiceResource::collection($service);              
      if(!isset($services[0]->id)){
        return $this->sendError('Sorry! Service not available', 400);  
      }
      return $this->sendResponse('Service detail fetch successfully', $services);
    }
    catch (\Throwable $e)
    {
      \DB::rollback();
      return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
    }
  }


   public function searchService(Request $request)
  {        
    try {
      \DB::beginTransaction();      
      $service = Service::with('categories')->where('status','Active')
      // ->where('mobile', 'LIKE', "%".$request->mobile."%");
      ->where('name',   'LIKE',"%".$request->name."%")
      ->get();      
      \DB::commit();
      $services = ServiceResource::collection($service);              
      if(!isset($services[0]->id)){
        return $this->sendError('Sorry! Service not available', 400);  
      }
      return $this->sendResponse('Service detail fetch successfully', $services);
    }
    catch (\Throwable $e)
    {
      \DB::rollback();
      return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
    }
  }

}
