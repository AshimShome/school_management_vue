<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\ExpenseType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpenseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return responseSuccess('expensetype', ExpenseType::get());
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
            'name' => "required|unique:expense_types,name",
        ]);

        $expensetype = ExpenseType::create([
            'name' => $request->name,
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $url = uploadFileToPublic($request->image, 'expense');
            $expensetype->update(['image' => $url]);
        }

        return responseSuccess('expensetype', $expensetype, 'Expensetype Created Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseType $expensetype)
    {
        $request->validate([
            'name' => "required|unique:expense_types,name,$expensetype->id",
        ]);

        $expensetype->update([
            'name' => $request->name,
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            deleteImage($expensetype->image);
            $url = uploadFileToPublic($request->image, 'expense');
            $expensetype->update(['image' => $url]);
        }

        return responseSuccess('expensetype', $expensetype, 'Expensetype Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseType $expensetype)
    {
        $expensetype->delete();

        return responseSuccess('', '', 'Expensetype Deleted Successfully');
    }
}
