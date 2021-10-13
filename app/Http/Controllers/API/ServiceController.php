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
}
