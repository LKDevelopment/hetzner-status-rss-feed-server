<?php

namespace App\Http\Controllers\Web;

use App\Model\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeviceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('value')) {
            $devices = Device::where('id', 'LIKE', '%' . $request->get('value') . '%')->orWhere('description', 'LIKE', '%' . $request->get('value') . '%')->paginate(10);
        } else {
            $devices = [];
        }
        dd($devices);

        return view('web.devices.index', compact('devices'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device)
    {
        return view('web.devices.edit', compact('device'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device)
    {
        $data = $this->validate($request, [
            'type' => 'required',
            'description' => 'max:255',
        ]);
        $device->update($data);

        return redirect()->route('devices.index')->with('success', 'Gerät bearbeitet!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
