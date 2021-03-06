<?php

namespace App\Http\Controllers\Api;

use App\Model\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 *
 */
class DeviceTrackingController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create_device(Request $request)
    {
        $this->validate($request, [
            'os' => 'required',
            'version' => 'required',
        ]);
        $device = Device::create([
            'os' => $request->get('os'),
            'version' => $request->get('version'),
            'app_version' => get_user_agent(),
        ]);

        return response()->json(['device_id' => $device->id]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Device $device
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_device(Request $request, Device $device)
    {
        $this->validate($request, [
            'os' => 'required',
            'version' => 'required',
        ]);
        $device->update([
            'os' => $request->get('os'),
            'version' => $request->get('version'),
            'app_version' => get_user_agent(),
        ]);

        return response()->json(['device_id' => $device->id]);
    }

    /**
     * @param \App\Model\Device $device
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function feature_flags(Device $device)
    {
        return response()->json(['feature_flags' => $device->feature_flags->merge([Device\FeatureFlag::where('key', '=', 'FEATURE_DEDICATED_RESOURCES')->first()])]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Device $device
     */
    public function create_track(Request $request, Device $device)
    {
        $this->validate($request, [
            'projects' => 'required',
            'access' => 'required',
        ]);
        $device->trackings()->create([
            'projects' => $request->get('projects'),
            'access' => $request->get('access'),
            'app_version' => get_user_agent(),
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Device $device
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function feature_track(Request $request, Device $device)
    {
        $data = $this->validate($request, [
            'feature_tracks' => 'required|json',
        ]);
        $data = json_decode($data['feature_tracks'], true);
        foreach ($data as $feature => $count) {
            $device->feature_tracking()->create(['feature' => $feature, 'value' => $count]);
        }

        return response()->json(['message' => 'ok']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Device $device
     * @return \Illuminate\Http\JsonResponse
     */
    public function feedback(Request $request, Device $device)
    {
        $data = $this->validate($request, [
            'rating' => 'required|numeric',
            'text' => 'max:512',
        ]);
        $data['current_version'] = get_user_agent();
        $device->feedback()->create($data);
        return response()->json(['message' => 'ok']);
    }
}
