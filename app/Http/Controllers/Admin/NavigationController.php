<?php

namespace App\Http\Controllers\Admin;

use App\Navigation;
use App\Http\Resources\navigations\MainMenuAdminBasicResource;
use App\Http\Resources\navigations\MainMenuAdminFullResource;
use App\Http\Resources\navigations\LinkAdminBasicResource;
use App\Http\Resources\navigations\LinkAdminFullResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class NavigationController extends Controller
{
    protected $navigation;

    public function __construct(Navigation $navigation)
    {
        $this->navigation = $navigation;
    }

    public function mainMenus()
    {
        $mainMenus = $this->navigation
            ->where('type', 'main')
            ->get();

        return MainMenuAdminFullResource::collection($mainMenus);
    }

    public function updateMainMenus(Request $request)
    {
        foreach($request->mainMenus as $menu) {
            $this->navigation->find($menu['id'])->update([
                'page_node_id' => $menu['page_node_id'],
                'hidden' => $menu['hidden']
            ]);
        }
    }

    public function links(Request $request)
    {
        $links = $this->navigation
            ->where('type', 'link')
            ->get();

        return LinkAdminBasicResource::collection($links);
    }

    public function link(Request $request, Navigation $link)
    {
        return new LinkAdminFullResource($link);
    }

    public function storeLink(Request $request)
    {
        // Log::info($request);
        $validations = [
            'title' => 'required|max:100',
            'url' => 'required|url'
        ];

        $errors = [
            'title.required' => 'Title is required.',
            'title.max' => 'Title title must be 100 characters or less.',
            'url.required' => 'URL is required.',
            'url.url' => 'Please input a valid URL.'
        ];

        $this->validate($request, $validations, $errors);

        $link = $this->navigation->create([
            'title' => $request->title,
            'url' => $request->url,
            'hidden' => $request->hidden,
            'created_by' => $request->user()->id
        ]);

        if ($request->thumbImage) {
            $imageBase64 = explode(',', $request->thumbImage);
            if (count($imageBase64) > 1) {
                $imageBase64Decoded = base64_decode($imageBase64[1]);
                $image = 'public/msc/images/thumbnails/' . str_random(12) . '.png';
                Storage::put($image, $imageBase64Decoded);
                $link->update([
                    'thumb_image' => $image,
                ]);
            }
        }

        $this->afterStore($link);
    }

    public function updateLink(Request $request, Navigation $link)
    {
        // Log::info($request);
        $validations = [
            'title' => 'required|max:100',
            'url' => 'required|url'
        ];

        $errors = [
            'title.required' => 'Title is required.',
            'title.max' => 'Title title must be 100 characters or less.',
            'url.required' => 'URL is required.',
            'url.url' => 'Please input a valid URL.'
        ];

        $this->validate($request, $validations, $errors);

        $link->update([
            'title' => $request->title,
            'url' => $request->url,
            'hidden' => $request->hidden,
        ]);

        if ($request->thumbImage) {
            $imageBase64 = explode(',', $request->thumbImage);
            if (count($imageBase64) > 1) {
                $hasOldCarouselImage = Storage::exists($link->thumb_image);
                if ($hasOldCarouselImage) {
                    Storage::delete($link->thumb_image);
                }
                $imageBase64Decoded = base64_decode($imageBase64[1]);
                $image = 'public/msc/images/thumbnails/' . str_random(12) . '.png';
                Storage::put($image, $imageBase64Decoded);
                $link->update([
                    'thumb_image' => $image
                ]);
            }
        } else {
            if ($link->thumb_image) {
                Storage::delete($link->thumb_image);
                $link->update([
                    'thumb_image' => null,
                ]);
            }
        }
    }

    public function destroyLink(Request $request, Navigation $link)
    {
        $this->beforeDelete($link);

        if ($link->thumb_image) {
            Storage::delete($link->thumb_image);
        }

        $link->delete();
    }

    public function moveUp(Request $request, Navigation $link)
    {
        $nextLink = $this->navigation
            ->where('disposition', '=', $link->disposition - 1)
            ->first();

        if ($nextLink) {
            $link->disposition = $link->disposition - 1;
            $link->save();
            $nextLink->disposition = $nextLink->disposition + 1;
            $nextLink->save();
        }
    }

    public function moveDown(Request $request, Navigation $link)
    {
        $nextLink = $this->navigation
            ->where('disposition', '=', $link->disposition + 1)
            ->first();

        if ($nextLink) {
            $link->disposition = $link->disposition + 1;
            $link->save();
            $nextLink->disposition = $nextLink->disposition - 1;
            $nextLink->save();
        }
    }

    private function afterStore($link)
    {
        $link->disposition = 1;
        $link->save();

        $otherLinks = $this->navigation
            ->where('id', '<>', $link->id)
            ->where('type', 'link')
            ->where('disposition', '<>', NULL)
            ->get();

        foreach ($otherLinks as $item) {
            $item->disposition = $item->disposition + 1;
            $item->save();
        }
    }

    private function beforeDelete($toBeDeletedLink)
    {
        $otherLinks = $this->navigation
            ->where('id', '<>', $toBeDeletedLink->id)
            ->where('type', 'link')
            ->where('disposition', '>', $toBeDeletedLink->disposition)
            ->get();

        foreach ($otherLinks as $item) {
            $item->disposition = $item->disposition - 1;
            $item->save();
        }
    }
}
