<?php

namespace App\Http\Controllers\Admin;

use App\CalendarDate;
use App\Http\Resources\calendar_dates\CalendarDateAdminBasicResource;
use App\Http\Resources\calendar_dates\CalendarDateAdminFullResource;
use App\Http\Resources\calendar_dates\EventAdminBasicResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CalendarDateController extends Controller
{
    protected $calendarDate;

    public function __construct(CalendarDate $calendarDate)
    {
        $this->calendarDate = $calendarDate;
    }

    public function store(Request $request)
    {
        // Log::info($request);
        $validations = [
            'date' => 'required|date',
            'type' => 'required',
            'title' => 'required|max:150'
        ];

        $errors = [
            'date.required' => 'Date is required.',
            'type.required' => 'This field is required.',
            'title.required' => 'News title is required.',
            'title.max' => 'Title title must be 150 characters or less.'
        ];

        $this->validate($request, $validations, $errors);

        do {
            $id = str_random(14);
            $calendarDate = $this->calendarDate->find($id);
        } while ($calendarDate);

        $this->calendarDate->create([
            'id' => $id,
            'calendar_date' => $request->date,
            'type' => $request->type,
            'holiday_type' => $request->holidayType,
            'title' => $request->title,
            'details' => $request->details,
            'created_by' => $request->user()->id
        ]);
    }

    public function monthHolidaysAndEvents(Request $request, $month)
    {   
        $calendarDates = $this->calendarDate
            ->where('calendar_date', 'like', $month . '%')
            ->orderBy('calendar_date')
            ->get();

        return CalendarDateAdminBasicResource::collection($calendarDates);
    }

    public function events(Request $request)
    {   
        $events = $this->calendarDate
            ->where('type', 'event')
            ->orderBy('calendar_date')
            ->get();

        return EventAdminBasicResource::collection($events);
    }

    public function calendarDate(Request $request, CalendarDate $calendarDate)
    {
        return new CalendarDateAdminFullResource($calendarDate);
    }

    public function update(Request $request, CalendarDate $calendarDate)
    {
        // Log::info($request);
        $validations = [
            'date' => 'required',
            'type' => 'required',
            'title' => 'required|max:150'
        ];

        $errors = [
            'date.required' => 'Date is required.',
            'type.required' => 'This field is required.',
            'title.required' => 'News title is required.',
            'title.max' => 'Title title must be 150 characters or less.'
        ];

        $this->validate($request, $validations, $errors);

        $calendarDate->update([
            'calendar_date' => $request->date,
            'type' => $request->type,
            'holiday_type' => $request->holidayType,
            'title' => $request->title,
            'details' => $request->details,
        ]);
    }

    public function destroy(CalendarDate $calendarDate)
    {
        $calendarDate->delete();
    }

    public function storeContentImage(Request $request)
    {
        // Log::info($request);
        $uploadedImage = $request->image->storeAs($this->calendarFilesDirectory($request->user()->id), $request->image->getClientOriginalName());

        $response = [
            'link' => url(Storage::url($uploadedImage))
        ];

        return $response;
    }

    public function contentImages(Request $request)
    {
        $images = Storage::files($this->calendarFilesDirectory($request->user()->id));

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

    private function calendarFilesDirectory($folder)
    {
        return "public/user/$folder/images/calendar";
    }
}
