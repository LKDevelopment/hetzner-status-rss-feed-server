<?php

namespace App\Http\Controllers\Web;

use App\Events\NewStatusMeldungArrived;
use App\Model\Message;
use App\StatusMeldung;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Messages extends Controller
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
        $messages = Message::onlyParents()->paginate();

        return view('web.messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.messages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'title_de' => 'required',
            'description_de' => 'required',
            'affected_de' => 'required',
            'permalink_de' => 'required',
            'title_en' => 'required',
            'description_en' => 'required',
            'affected_en' => 'required',
            'permalink_en' => 'required',
            'category' => 'required',
            'start' => 'required',
        ]);
        $data['type'] = $data['category'];
        Message::create($data);
        foreach (['de', 'en'] as $language) {
            $message = StatusMeldung::create([
                'title' => $data['title_'.$language],
                'text' => $data['description_'.$language].'<br />'.$data['affected_'.$language],
                'category' => $data['category'],
                'date_time' => $data['start'],
                'permalink' => $data['permalink_'.$language],
                'language' => $language,

            ]);
            //event(new NewStatusMeldungArrived($message));
        }

        return redirect()->route('messages.index')->with('success', 'Angelegt');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
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
     * @param  int $id
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
