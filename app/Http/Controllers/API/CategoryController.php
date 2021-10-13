<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Service;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;


class CategoryController extends BaseController
{
    public function getAllCategory()
    {
        try {
            \DB::beginTransaction();
            $categories = Category::where('status','Active')->get();
            \DB::commit();
            return $this->sendResponse('Category fetch successfully',$categories);
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
        }        
    }
}
