<?php

namespace App\Http\Controllers\Admin;

use App\News;
use App\Http\Resources\news\NewsAdminBasicResource;
use App\Http\Resources\news\NewsAdminFullResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    protected $news;

    public function __construct(News $news)
    {
        $this->middleware('UserComponentsCheck:news')->except('test');

        $this->news = $news;
    }

    public function allNews(Request $request)
    {
        $allNews = $this->news
            ->orderBy('posted_at', 'desc')
            ->get();

        return NewsAdminBasicResource::collection($allNews);
    }

    public function news(Request $request, News $news)
    {
        return new NewsAdminFullResource($news);
    }

    public function store(Request $request)
    {
        // Log::info($request);
        $validations = [
            'title' => 'required|unique:news|max:150',
            'thumbImage' => 'required_if:featured,1'
        ];

        $errors = [
            'title.required' => 'News title is required.',
            'title.unique' => 'The title has already been taken.',
            'title.max' => 'Title title must be 150 characters or less.',
            'thumbImage.required_if' => 'Thumbnail image is required. Please choose an image.'
        ];

        $this->validate($request, $validations, $errors);

        do {
            $id = str_random(14);
            $news = $this->news->find($id);
        } while ($news);

        $newNews = $this->news->create([
            'id' => $id,
            'title' => $request->title,
            'author' => $request->author,
            'featured' => $request->featured,
            'photo_album' => $request->photoAlbum,
            'content' => $request->content,
            'created_by' => $request->user()->id
        ]);

        if ($request->thumbImage) {
            $imageBase64 = explode(',', $request->thumbImage);
            if (count($imageBase64) > 1) {
                $imageBase64Decoded = base64_decode($imageBase64[1]);
                $image = $this->newsFilesDirectory($request->user()->id) . '/thumbnails/' . str_random(12) . '.png';
                Storage::put($image, $imageBase64Decoded);
                $newNews->update([
                    'thumb_image' => $image,
                ]);
            }
        }
    }

    public function update(Request $request, News $news)
    {
        // Log::info($request);
        $validations = [
            'title' => "required|unique:news,title,$news->id,id|max:150",
            'thumbImage' => 'required_if:featured,1'
        ];

        $errors = [
            'title.required' => 'News title is required.',
            'title.unique' => 'The title has already been taken.',
            'title.max' => 'Title title must be 150 characters or less.',
            'thumbImage.required_if' => 'Thumbnail image is required. Please choose an image.'
        ];

        $this->validate($request, $validations, $errors);

        $news->update([
            'title' => $request->title,
            'author' => $request->author,
            'featured' => $request->featured,
            'photo_album' => $request->photoAlbum,
            'content' => $request->content,
            'hidden' => $request->hidden
        ]);

        if ($request->thumbImage) {
            $imageBase64 = explode(',', $request->thumbImage);
            if (count($imageBase64) > 1) {
                $hasOldFeaturedThumbImage = Storage::exists($news->thumb_image);
                if ($hasOldFeaturedThumbImage) {
                    Storage::delete($news->thumb_image);
                }
                $imageBase64Decoded = base64_decode($imageBase64[1]);
                $image = $this->newsFilesDirectory($request->user()->id) . '/thumbnails/' . str_random(12) . '.png';
                Storage::put($image, $imageBase64Decoded);
                $news->update([
                    'thumb_image' => $image
                ]);
            }
        } else {
            if ($news->thumb_image) {
                Storage::delete($news->thumb_image);
                $news->update([
                    'thumb_image' => null,
                ]);
            }
        }
    }

    public function destroy(News $news)
    {
        // if ($news->thumb_image) {
        //     Storage::delete($news->thumb_image);
        // }

        $news->delete();
    }

    public function storeContentImage(Request $request)
    {
        // Log::info($request);
        $uploadedImage = $request->image->storeAs($this->newsFilesDirectory($request->user()->id), $request->image->getClientOriginalName());

        $response = [
            'link' => url(Storage::url($uploadedImage))
        ];

        return $response;
    }

    public function contentImages(Request $request)
    {
        $images = Storage::files($this->newsFilesDirectory($request->user()->id));

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

    private function newsFilesDirectory($folder)
    {
        return "public/user/$folder/images/news";
    }
}
