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
        $brands = auth()->user()->brands;
        $query = Spending::with('brand')->latest('date');
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }
        $data = $query->paginate(10);
        $data->appends($request->all());
        return view('marketing.spendings.index', compact('data', 'brands'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand = Auth()->user()->brands;
        return view('marketing.spendings.create', compact('brand'));
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
            'brand_id' => 'required'
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
        $brands = Auth()->user()->brands;
        if ($data == null) {
            return redirect()->back();
        } else {
            return view('marketing.spendings.edit', compact('data', 'brands'));
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
            'brand_id' => 'required'
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
