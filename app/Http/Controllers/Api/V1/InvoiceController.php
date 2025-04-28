<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiseStoreRequest;
use App\Http\Requests\ShowInvoiceRequest;
use App\Http\Resources\InvoiceShowResource;
use App\Services\Invoices\InvoiceServiceContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ShowInvoiceRequest $request, InvoiceServiceContract $service)
    {

        $data = $request->validated();
        $invoices = $service->getInvoices($data);

        return InvoiceShowResource::collection($invoices);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiseStoreRequest $request, InvoiceServiceContract $service)
    {
        $data = $request->validated();

        if (Gate::allows('create-invoice', [$data])) {
            $invoice = $service->createInvoice($data);

            return $invoice;
        }
    }

    public function storeSubmittedInvoice(InvoiseStoreRequest $request, InvoiceServiceContract $service)
    {
        $data = $request->validated();

        if (Gate::allows('create-invoice', [$data])) {
            $invoice = $service->createAndSubmit($data);
        }

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
