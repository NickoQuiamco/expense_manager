<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\exp_sales;
use App\Models\exp_categories;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exp_categories = exp_categories::orderBy('created_at', 'DESC')->get();
        $expenses = exp_sales::orderBy('created_at', 'DESC')->with('category')->get();
        $auth = Auth::user();
        return Inertia::render('ExpensesManagement', [ 'expenses'=>$expenses, 'exp_categories'=>$exp_categories, 'role_id'=>$auth->role_id ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expense = new exp_sales;
        $expense->amount = $request->amount;
        $expense->entry_date = $request->entry_date;
        $expense->category_id = $request->category_id;
        $expense->save();
        return redirect('ExpensesManagement');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $expense = exp_sales::find($id);
        $expense->amount = $request->amount;
        $expense->entry_date = $request->entry_date;
        $expense->category_id = $request->category_id;
        $expense->saved();
        return redirect('ExpensesManagement');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        exp_sales::find($id)->delete();
        return redirect('ExpensesManagement');
    }
}
