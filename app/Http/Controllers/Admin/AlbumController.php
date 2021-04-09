<?php

namespace App\Http\Controllers\Admin;

use App\Album;
use App\Http\Resources\albums\AlbumAdminBasicResource;
use App\Http\Resources\albums\AlbumAdminFullResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AlbumController extends Controller
{
    protected $album;

    public function __construct(Album $album)
    {
        $this->album = $album;
    }

    public function albums(Request $request)
    {
        $album = $this->album->get();

        return AlbumAdminBasicResource::collection($album);
    }

    public function albumPhotos(Request $request, Album $album)
    {
        return new AlbumAdminFullResource($album);
    }

    public function store(Request $request)
    {
        $validations = [
            'title' => 'required|unique:albums'
        ];

        $errors = [
            'title.required' => 'Title is required',
            'title.unique' => 'This title has already been taken'
        ];

        $this->validate($request, $validations, $errors);

        do {
            $id = str_random(14);
            $album = $this->album->find($id);
        } while ($album);

        $this->album->create([
            'id' => $id,
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => $request->user()->id
        ]);
    }

    public function addPhotos(Request $request)
    {
        $album = $this->album->find($request->albumId);

        $file = Storage::put('public/photos', $request->file);

        do {
            $id = str_random(14);
            $photo = \App\Photo::find($id);
        } while ($photo);

        $album->photos()->create([
            'id' => $id,
            'src' => $file,
            'created_by' => $request->user()->id
        ]);
    }

    public function edit(Request $request, Album $album)
    {
        return new AlbumAdminFullResource($album);
    }

    public function update(Request $request, Album $album)
    {
        $validations = [
            'title' => "required|unique:albums,title,$album->id,id"
        ];

        $errors = [
            'title.required' => 'Title is required',
            'title.unique' => 'This title has already been taken'
        ];

        $this->validate($request, $validations, $errors);

        $album->update([
            'title' => $request->title,
            'description' => $request->description,
            'hidden' => $request->hidden
        ]);
    }

    public function destroy(Request $request, Album $album)
    {
        if ($request->confirm) {

            if ($request->deletePhotos) {
                $photos = $album->photos->map(function ($item, $key) {
                        return $item->src;
                    });
                Storage::delete($photos->all());
            }

            $album->photos()->delete();

            $album->delete();
        }
    }

    public function deleteAlbumPhoto(Request $request, Album $album)
    {
        if ($request->confirm) {
            $photo = $album->photos()->find($request->photoId);

            $photo->album()->dissociate();
            $photo->save();

            if ($request->deletePhoto) {
                Storage::delete($photo->src);
                $photo->delete();
            }
        }
    }
}
