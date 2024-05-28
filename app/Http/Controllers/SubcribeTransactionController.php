<?php

namespace App\Http\Controllers;

use App\Models\SubcribeTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubcribeTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $transactions = SubcribeTransaction::with('user')->orderByDesc('id')->get();
        return view('admin.transactions.index', compact('transactions'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SubcribeTransaction $subcribeTransaction)
    {
        //
        return view('admin.transactions.show', compact('subcribeTransaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubcribeTransaction $subcribeTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubcribeTransaction $subcribeTransaction)
    {
        //
        DB::transaction(function () use ($subcribeTransaction) {
            $subcribeTransaction->update([
                'is_paid' =>true,
                'subcription_start_date' => Carbon::now(),
            ]);
        });

        return redirect()->route('admin.subcribe_transactions.show',$subcribeTransaction);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubcribeTransaction $subcribeTransaction)
    {
        //
    }
}
