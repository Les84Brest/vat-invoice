<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\InvoiceFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiseStoreRequest;
use App\Http\Requests\ShowInvoiceRequest;
use App\Models\Invoice;
use App\Services\Invoices\InvoiceServiceContract;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ShowInvoiceRequest $request, InvoiceServiceContract $service)
    {

        $data = $request->validated();

        $invoices = $service->getInvoices($data);

        return $invoices;
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
    public function store(InvoiseStoreRequest $request)
    {
        $data = $request->validated();

        $invoice = Invoice::create($data);

        return $invoice;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
