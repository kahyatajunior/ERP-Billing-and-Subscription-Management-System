@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Invoices</h1>
</div>

<div class="overflow-hidden rounded bg-white shadow">
    <table class="min-w-full text-left">
        <thead class="bg-slate-100 text-sm uppercase text-slate-600">
            <tr>
                <th class="px-4 py-3">Invoice</th>
                <th class="px-4 py-3">Customer</th>
                <th class="px-4 py-3">Total</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invoices as $invoice)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $invoice->invoice_number }}</td>
                    <td class="px-4 py-3">{{ $invoice->customer->name }}</td>
                    <td class="px-4 py-3">ZMW {{ number_format($invoice->total, 2) }}</td>
                    <td class="px-4 py-3">{{ $invoice->status }}</td>
                    <td class="px-4 py-3"><a href="{{ route('invoices.show', $invoice) }}" class="text-indigo-600">View</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-500">No invoices found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $invoices->links() }}
@endsection
