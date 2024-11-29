<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\YourModel;

class YourController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
    // ... rest of your controller methods remain the same ...
} 