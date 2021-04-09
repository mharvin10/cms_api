<?php

namespace App\Http\Controllers\Admin;

use App\Announcement;
use App\Http\Resources\announcements\AnnouncementAdminBasicResource;
use App\Http\Resources\announcements\AnnouncementAdminFullResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AnnouncementController extends Controller
{
    protected $announcement;

    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    public function announcements()
    {
        $announcements = $this->announcement
            ->orderBy('posted_at', 'desc')
            ->get();

        return AnnouncementAdminBasicResource::collection($announcements);
    }

    public function announcement(Request $request, Announcement $announcement)
    {
        return new AnnouncementAdminFullResource($announcement);
    }

    public function store(Request $request)
    {
        $validations = [
            'title' => 'required|max:150'
        ];

        $errors = [
            'title.required' => 'Title is required.',
            'title.max' => 'Title title must be 150 characters or less.'
        ];

        $this->validate($request, $validations, $errors);

        do {
            $id = str_random(14);
            $announcement = $this->announcement->find($id);
        } while ($announcement);

        $this->announcement->create([
            'id' => $id,
            'title' => $request->title,
            'content' => $request->content,
            'created_by' => $request->user()->id
        ]);
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validations = [
            'title' => 'required|max:150'
        ];

        $errors = [
            'title.required' => 'Title is required.',
            'title.max' => 'Title title must be 150 characters or less.'
        ];

        $this->validate($request, $validations, $errors);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'hidden' => $request->hidden,
        ]);
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
    }

    public function storeContentImage(Request $request)
    {
        // Log::info($request);
        $uploadedImage = $request->image->storeAs($this->announcementFilesDirectory($request->user()->id) . '/images/announcement', $request->image->getClientOriginalName());

        $response = [
            'link' => url(Storage::url($uploadedImage))
        ];

        return $response;
    }

    public function contentImages(Request $request)
    {
        $images = Storage::files($this->announcementFilesDirectory($request->user()->id) . '/images/announcement');

        $images_obj = [];

        foreach ($images as $key => $value) {
            $images_obj [] = [
            'url' => url(Storage::url($value)),
            // 'url' => asset('img/sample_cart/39-iceland_money30029.jpg'),
            // thumb: "http://exmaple.com/thumbs/photo1.jpg",
            // 'tag' => 'General'
            ];
        }

        return $images_obj;
    }

    public function deleteContentImage(Request $request)
    {
        $src = explode('storage/', $request->src);

        Storage::delete('public/'.$src[1]);
    }

    public function storeContentFile(Request $request)
    {
        $uploadedFile = $request->file->storeAs($this->announcementFilesDirectory($request->user()->id) . '/files/announcement', $request->file->getClientOriginalName());

        $response = [
            'link' => url(Storage::url($uploadedFile))
        ];

        return $response;
    }

    private function announcementFilesDirectory($folder)
    {
        return "public/user/$folder";
    }
}
