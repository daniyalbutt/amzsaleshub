<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spending;

class SpendingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Spending::latest('date')->paginate(10);
        return view('marketing.spendings.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('marketing.spendings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'date'   => 'required|date',
            'type'   => 'required|in:0,1,2',
        ]);
        $request->request->add(['added_by' => auth()->user()->id]);
        Spending::create($request->all());
        return redirect()->back()->with('success', 'Spending Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Spending::where('id', $id)->first();
        if ($data == null) {
            return redirect()->back();
        } else {
            return view('marketing.spendings.edit', compact('data'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, Spending $spending)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'date'   => 'required|date',
            'type'   => 'required|in:0,1,2',
        ]);
        
        $spending->update($request->all());
        return redirect()->back()->with('success', 'Spending Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }

}
