<?php

namespace App\Http\Controllers;

use App\Models\AppObject;
use Illuminate\Http\Request;

class FrontObjectController extends Controller
{
    // Show all objects
    public function index()
    {
        $objects = AppObject::where('active', true)->get();
        return view('objects.index', compact('objects'));
    }

    // Show one object
    public function show(AppObject $object)
    {
        return view('objects.show', compact('object'));
    }
}
