@extends('admin.layouts.admin')

@section('content')
    @include('admin.components.content-header', ['title' => 'Счет № ' . $invoice->number])

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Данные счета</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Номер счета</label>
                                    <p class="form-control-plaintext">{{ $invoice->number }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Дата создания</label>
                                    <p class="form-control-plaintext">{{ $invoice->creation_date }}</p>

                                </div>
                                <div class="form-group">
                                    <label>Дата действия</label>
                                    <p class="form-control-plaintext">{{ $invoice->action_date }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Статус</label>
                                    <p class="form-control-plaintext">
                                        <span class="badge {{ App\Types\InvoiceStatus::getBadgeClass($invoice->status) }}">
                                            {{ App\Types\InvoiceStatus::getLabel($invoice->status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Тип</label>
                                    <p class="form-control-plaintext">{{ App\Types\InvoiceType::getLabel($invoice->type) }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Номер договора</label>
                                    <p class="form-control-plaintext">{{ $invoice->contract_number }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Дата договора</label>
                                    <p class="form-control-plaintext">{{ $invoice->contract_date }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Родительский счет</label>
                                    <p class="form-control-plaintext">
                                        @if ($invoice->parent_invoice)
                                            <a href="{{ route('invoice.show', $invoice->parent_invoice) }}">№
                                                {{ $invoice->parent_invoice->number }}</a>
                                        @else
                                            —
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Автор</label>
                                    <p class="form-control-plaintext">{{ optional($invoice->author)->full_name ?? '—' }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Подписант</label>
                                    <p class="form-control-plaintext">{{ optional($invoice->signatory)->full_name ?? '—' }}
                                    </p>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Сумма без НДС</label>
                                    <p class="form-control-plaintext">
                                        {{ number_format($invoice->total_wo_vat, 2, ',', ' ') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Сумма НДС</label>
                                    <p class="form-control-plaintext">{{ number_format($invoice->total_vat, 2, ',', ' ') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Итого</label>
                                    <p class="form-control-plaintext">{{ number_format($invoice->total, 2, ',', ' ') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card card-outline card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">Отправитель</h3>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>{{ optional($invoice->sender_company)->title ?? '—' }}</strong></p>
                                        <p>{{ optional($invoice->sender_company)->short_title ?? '—' }}</p>
                                        <p>{{ optional($invoice->sender_company)->address ?? '—' }}</p>
                                        <p>{{ optional($invoice->sender_company)->tax_id ?? '—' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-outline card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">Получатель</h3>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>{{ optional($invoice->recipient_company)->title ?? '—' }}</strong></p>
                                        <p>{{ optional($invoice->recipient_company)->short_title ?? '—' }}</p>
                                        <p>{{ optional($invoice->recipient_company)->address ?? '—' }}</p>
                                        <p>{{ optional($invoice->recipient_company)->tax_id ?? '—' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-outline card-info mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Товары / услуги</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
    
                                <table class="table table-bordered table-hover table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>Название</th>
                                            <th>Единица</th>
                                            <th>Количество</th>
                                            <th>Цена</th>
                                            <th>Стоимость</th>
                                            <th>Ставка НДС</th>
                                            <th>Сумма НДС</th>
                                            <th>Сумма с НДС</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $invoiceItems = $invoice->invoice_items instanceof \App\Types\InvoiceItemsList
                                            ? $invoice->invoice_items->toArray()
                                            : [];
                                        @endphp

                                        @foreach ($invoiceItems as $item)
                                            <tr>
                                                <td>{{ $item['name'] ?? '—' }}</td>
                                                <td>{{ $item['dimension'] ?? '—' }}</td>
                                                <td>{{ $item['count'] ?? '—' }}</td>
                                                <td>{{ number_format($item['price'] ?? 0, 2, ',', ' ') }}</td>
                                                <td>{{ number_format($item['cost'] ?? 0, 2, ',', ' ') }}</td>
                                                <td>{{ $item['vat_rate'] ?? '—' }}</td>
                                                <td>{{ number_format($item['vat_sum'] ?? 0, 2, ',', ' ') }}</td>
                                                <td>{{ number_format($item['cost_vat'] ?? 0, 2, ',', ' ') }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if (!empty($invoice->delivery_documents))
                            <div class="card card-outline card-warning">
                                <div class="card-header">
                                    <h3 class="card-title">Документы доставки</h3>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-bordered table-hover table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th>Тип документа</th>
                                                <th>Номер</th>
                                                <th>Дата</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoice->delivery_documents as $document)
                                                <tr>
                                                    <td>{{ $document['document_type'] ?? '—' }}</td>
                                                    <td>{{ $document['number'] ?? '—' }}</td>
                                                    <td>{{ $document['date'] ?? '—' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection