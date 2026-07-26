<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ActivityDetail;
use Illuminate\Http\Request;

class ActivityDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'start_time' => 'nullable',
            'end_time' => 'nullable|after:start_time',
            'location_detail' => 'nullable|string',
            'participant_requirements' => 'nullable|string',
            'map_link' => 'nullable|url',
            'contact_name' => 'nullable|string',
            'contact_phone' => 'nullable|string',
            'contact_role' => 'nullable|string',
        ]);

        ActivityDetail::where('activity_id', $validated['activity_id'])->delete();


        ActivityDetail::create($request->all());

        return redirect()->back()->with('success', 'Detail berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivityDetail $activityDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityDetail $activityDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityDetail $activityDetail)
    {
        $detail = ActivityDetail::findOrFail($activityDetail);

        $request->validate([
            'start_time' => 'nullable',
            'end_time' => 'nullable|after:start_time',
            'location_detail' => 'nullable|string',
            'map_link' => 'nullable|url',
            'contact_name' => 'nullable|string',
            'contact_phone' => 'nullable|string',
            'contact_role' => 'nullable|string',
        ]);

        $detail->update($request->all());

        return redirect()->back()->with('success', 'Detail berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityDetail $activityDetail)
    {
        //
    }
}
