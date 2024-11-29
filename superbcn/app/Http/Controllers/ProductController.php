<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YourModel;

class ProductController extends Controller
{
    // Your CRUD methods here...
    public function index()
    {
        $items = YourModel::all();
        return view('your-view.index', compact('items'));
    }

    // ... rest of your methods ...
} 