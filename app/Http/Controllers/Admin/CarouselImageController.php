<?php

namespace App\Http\Controllers\Admin;

use App\CarouselImage;
use App\Http\Resources\carousel_images\CarouselImagesAdminBasicResource;
use App\Http\Resources\carousel_images\CarouselImagesAdminFullResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CarouselImageController extends Controller
{
    protected $carouselImage;

    public function __construct(CarouselImage $carouselImage)
    {
        $this->carouselImage = $carouselImage;
    }

    public function carouselImages()
    {
        $carouselImages = $this->carouselImage
            ->orderBy('created_at', 'desc')
            ->get();

        return CarouselImagesAdminBasicResource::collection($carouselImages);
    }

    public function carouselImage(Request $request, CarouselImage $carouselImage)
    {
        return new CarouselImagesAdminFullResource($carouselImage);
    }

    public function store(Request $request)
    {
        // Log::info($request);
        $validations = [
            'title' => 'required|max:150',
            'src' => 'required',
            'url' => 'required_if:link,1'
        ];

        $errors = [
            'title.required' => 'Title is required.',
            'title.max' => 'Title title must be 150 characters or less.',
            'src.required' => 'Carousel image is required. Please choose an image.',
            'url.required_if' => 'URL is required.'
        ];

        $this->validate($request, $validations, $errors);

        do {
            $id = str_random(14);
            $carouselImage = $this->carouselImage->find($id);
        } while ($carouselImage);

        $carouselImage = $this->carouselImage->create([
            'id' => $id,
            'title' => $request->title,
            'url' => $request->url,
            'created_by' => $request->user()->id
        ]);

        if ($request->src) {
            $imageBase64 = explode(',', $request->src);
            if (count($imageBase64) > 1) {
                $imageBase64Decoded = base64_decode($imageBase64[1]);
                $image = 'public/carousel/' . str_random(12) . '.png';
                Storage::put($image, $imageBase64Decoded);
                $carouselImage->update([
                    'src' => $image,
                ]);
            }
        }

        $this->afterStore($carouselImage);
    }

    public function update(Request $request, CarouselImage $carouselImage)
    {
        // Log::info($request);
        $validations = [
            'title' => 'required|max:150',
            'src' => 'required',
            'url' => 'required_if:link,1'
        ];

        $errors = [
            'title.required' => 'Title is required.',
            'title.max' => 'Title title must be 150 characters or less.',
            'src.required' => 'Carousel image is required. Please choose an image.',
            'url.required_if' => 'URL is required. Select content first.'
        ];

        $this->validate($request, $validations, $errors);

        $carouselImage->update([
            'title' => $request->title,
            'url' => $request->url,
        ]);

        if ($request->src) {
            $imageBase64 = explode(',', $request->src);
            if (count($imageBase64) > 1) {
                $hasOldCarouselImage = Storage::exists($carouselImage->src);
                if ($hasOldCarouselImage) {
                    Storage::delete($carouselImage->src);
                }
                $imageBase64Decoded = base64_decode($imageBase64[1]);
                $image = 'public/carousel/' . str_random(12) . '.png';
                Storage::put($image, $imageBase64Decoded);
                $carouselImage->update([
                    'src' => $image
                ]);
            }
        } else {
            if ($carouselImage->src) {
                Storage::delete($carouselImage->src);
                $carouselImage->update([
                    'src' => null,
                ]);
            }
        }
    }

    public function showOrHide(Request $request, CarouselImage $carouselImage)
    {
        $carouselImage->update([
            'hidden' => !$carouselImage->hidden
        ]);
    }

    public function destroy(CarouselImage $carouselImage)
    {
        $this->beforeDelete($carouselImage);

        if ($carouselImage->src) {
            Storage::delete($carouselImage->src);
        }

        $carouselImage->delete();
    }

    public function moveUp(Request $request, CarouselImage $carouselImage)
    {
        $nextCarouselImage = $this->carouselImage
            ->where('disposition', '=', $carouselImage->disposition - 1)
            ->first();

        if ($nextCarouselImage) {
            $carouselImage->disposition = $carouselImage->disposition - 1;
            $carouselImage->save();
            $nextCarouselImage->disposition = $nextCarouselImage->disposition + 1;
            $nextCarouselImage->save();
        }
    }

    public function moveDown(Request $request, CarouselImage $carouselImage)
    {
        $nextCarouselImage = $this->carouselImage
            ->where('disposition', '=', $carouselImage->disposition + 1)
            ->first();

        if ($nextCarouselImage) {
            $carouselImage->disposition = $carouselImage->disposition + 1;
            $carouselImage->save();
            $nextCarouselImage->disposition = $nextCarouselImage->disposition - 1;
            $nextCarouselImage->save();
        }
    }

    private function afterStore($newCarouselImage)
    {
        $newCarouselImage->disposition = 1;
        $newCarouselImage->save();

        $otherCarouselImages = $this->carouselImage
            ->where('id', '<>', $newCarouselImage->id)
            ->where('disposition', '<>', NULL)
            ->get();

        foreach ($otherCarouselImages as $item) {
            $item->disposition = $item->disposition + 1;
            $item->save();
        }
    }

    private function beforeDelete($toBeDeletedCarouselImage)
    {
        $otherCarouselImages = $this->carouselImage
            ->where('id', '<>', $toBeDeletedCarouselImage->id)
            ->where('disposition', '>', $toBeDeletedCarouselImage->disposition)
            ->get();

        foreach ($otherCarouselImages as $item) {
            $item->disposition = $item->disposition - 1;
            $item->save();
        }
    }
}
