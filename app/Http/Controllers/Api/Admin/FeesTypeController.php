<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\FeeType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SebastianBergmann\Environment\Console;

class FeesTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return responseSuccess('feestype', FeeType::get());
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
            'name' => "required|unique:fee_types,name",
        ]);

        $feetype = FeeType::create([
            'name' => $request->name,
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $url = uploadFileToPublic($request->image, 'fees');
            $feetype->update(['image' => $url]);
        }

        return responseSuccess('feetype', $feetype, 'Feetype Created Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeeType $feetype)
    {
        $request->validate([
            'name' => "required|unique:fee_types,name,$feetype->id",
        ]);

        $feetype->update([
            'name' => $request->name,
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            deleteImage($feetype->image);
            $url = uploadFileToPublic($request->image, 'fees');
            $feetype->update(['image' => $url]);
        }

        return responseSuccess('feetype', $feetype, 'Feetype Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeeType $feetype)
    {
        $feetype->delete();

        return responseSuccess('', '', 'Feetype Deleted Successfully');
    }
}
