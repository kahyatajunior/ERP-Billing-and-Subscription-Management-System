@extends('layouts.app')

@section('content')
<div class="rounded bg-white p-6 shadow">
    <h1 class="text-2xl font-bold">Statement for {{ $customer->name }}</h1>
    <p class="mt-2 text-slate-600">Current balance: ZMW {{ number_format($balance, 2) }}</p>

    <div class="mt-6 space-y-4">
        @foreach ($customer->invoices as $invoice)
            <div class="rounded border p-4">
                <div class="flex justify-between">
                    <span>{{ $invoice->invoice_number }}</span>
                    <span>ZMW {{ number_format($invoice->total, 2) }}</span>
                </div>
                <div class="mt-2 text-sm text-slate-600">Status: {{ $invoice->status }}</div>
            </div>
        @endforeach
    </div>
</div>
@endsection
