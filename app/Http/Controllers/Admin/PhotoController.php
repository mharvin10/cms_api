<?php

namespace App\Http\Controllers\Admin;

use App\Photo;
use App\Http\Resources\photos\PhotoAdminFullResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PhotoController extends Controller
{
    public function edit(Request $request, Photo $photo)
    {
        // Log::info($photo);
        return new PhotoAdminFullResource($photo);
    }

    public function updateCaption(Request $request, Photo $photo)
    {
        $photo->update([
            'caption' => $request->caption
        ]);
    }

}
