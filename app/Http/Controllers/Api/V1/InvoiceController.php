<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceSubmitRequest;
use App\Http\Requests\InvoiseStoreRequest;
use App\Http\Requests\ShowInvoiceRequest;
use App\Http\Resources\InvoiceFullResource;
use App\Http\Resources\InvoiceShowResource;
use App\Models\Invoice;
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

    public function submitInvoice(InvoiceSubmitRequest $request, InvoiceServiceContract $service)
    {
        $data = $request->validated();
        $invoice = Invoice::findOrFail($data['id']);

        if (Gate::allows('submit-invoice', [$invoice])) {
            $service->submitInvoice($invoice);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = Invoice::findOrFail($id);

        return new InvoiceFullResource($invoice);
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
    public function update(InvoiseStoreRequest $request, InvoiceServiceContract $service, Invoice $invoice)
    {
        $data = $request->validated();

        if (Gate::allows('create-invoice', [$data])) {
            $invoice = $service->updateInvoice($data, $invoice);
        }
        
    }

    public function cancelInvoice(InvoiceSubmitRequest $request, InvoiceServiceContract $service){
        $data = $request->validated();
        $invoice = Invoice::findOrFail($data['id']);

        if (Gate::allows('submit-invoice', [$invoice])) {
            $service->cancelInvoice($invoice);
        }

        return response()->json(['success' => true]);
    }
}
