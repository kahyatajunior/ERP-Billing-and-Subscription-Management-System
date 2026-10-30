@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="rounded bg-white p-5 shadow">
        <p class="text-sm text-slate-500">Customers</p>
        <p class="mt-2 text-3xl font-bold">{{ $customers }}</p>
    </div>
    <div class="rounded bg-white p-5 shadow">
        <p class="text-sm text-slate-500">Subscriptions</p>
        <p class="mt-2 text-3xl font-bold">{{ $subscriptions }}</p>
    </div>
    <div class="rounded bg-white p-5 shadow">
        <p class="text-sm text-slate-500">Invoices</p>
        <p class="mt-2 text-3xl font-bold">{{ $invoices }}</p>
    </div>
    <div class="rounded bg-white p-5 shadow">
        <p class="text-sm text-slate-500">Outstanding</p>
        <p class="mt-2 text-3xl font-bold">ZMW {{ number_format($outstanding, 2) }}</p>
    </div>
</div>
@endsection
