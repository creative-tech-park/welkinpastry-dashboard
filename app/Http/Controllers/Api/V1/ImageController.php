<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function downloadImage($filename)
    {
        if (Storage::exists($filename)) {
            return Storage::download($filename);
        }

        return abort(404, 'Image not found.');
    }
}
