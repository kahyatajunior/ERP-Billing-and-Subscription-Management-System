@extends('layouts.app')

@section('content')
<div class="rounded bg-white p-6 shadow">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Invoice {{ $invoice->invoice_number }}</h1>
        <span class="rounded bg-slate-200 px-3 py-1 text-sm">{{ $invoice->status }}</span>
    </div>

    <div class="mt-4 grid grid-cols-2 gap-4 text-sm text-slate-600">
        <div>Customer: {{ $invoice->customer->name }}</div>
        <div>Issue date: {{ $invoice->issue_date->format('d M Y') }}</div>
        <div>Due date: {{ $invoice->due_date->format('d M Y') }}</div>
        <div>Total: ZMW {{ number_format($invoice->total, 2) }}</div>
    </div>

    <div class="mt-6">
        <h2 class="mb-3 text-lg font-semibold">Lines</h2>
        <table class="min-w-full text-left">
            <thead class="bg-slate-100 text-sm uppercase text-slate-600">
                <tr>
                    <th class="px-4 py-3">Description</th>
                    <th class="px-4 py-3">Amount</th>
                    <th class="px-4 py-3">Tax</th>
                    <th class="px-4 py-3">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->lines as $line)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $line->description }}</td>
                        <td class="px-4 py-3">ZMW {{ number_format($line->amount, 2) }}</td>
                        <td class="px-4 py-3">ZMW {{ number_format($line->tax_amount, 2) }}</td>
                        <td class="px-4 py-3">ZMW {{ number_format($line->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <form method="POST" action="{{ route('invoices.pay', $invoice) }}" class="mt-8 flex gap-3">
        @csrf
        <input type="hidden" name="method" value="bank_transfer">
        <input type="number" step="0.01" name="amount" placeholder="Payment amount" class="rounded border px-3 py-2" required>
        <input type="text" name="reference" placeholder="Payment ref" class="rounded border px-3 py-2" required>
        <button type="submit" class="rounded bg-emerald-600 px-4 py-2 text-white">Apply Payment</button>
    </form>
</div>
@endsection
