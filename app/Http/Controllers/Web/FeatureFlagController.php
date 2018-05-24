<?php

namespace App\Http\Controllers\Web;

use App\Model\Device\FeatureFlag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeatureFlagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $featureFlags = FeatureFlag::paginate(20);

        return view('web.feature_flags.index', compact('featureFlags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.feature_flags.create');
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
        $data = $this->validate($request, [
            'key' => 'required|unique:feature_flags',
            'min_build' => 'required',
            'description' => 'required',
        ]);
        FeatureFlag::create($data);

        return redirect()->route('feature_flags.index')->with('success', 'Angelegt');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeatureFlag $featureFlag)
    {
        $featureFlag->devices()->detach();
        $featureFlag->delete();

        return redirect()->route('feature_flags.index')->with('success', 'Gelöscht');
    }
}
