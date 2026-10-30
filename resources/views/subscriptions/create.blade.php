@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl rounded bg-white p-6 shadow">
    <h1 class="mb-6 text-2xl font-bold">Create Subscription</h1>
    <form method="POST" action="{{ route('subscriptions.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="mb-1 block font-medium">Organization</label>
            <select name="organization_id" class="w-full rounded border px-3 py-2">
                @foreach ($organizations as $organization)
                    <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-1 block font-medium">Customer</label>
            <select name="customer_id" class="w-full rounded border px-3 py-2">
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-1 block font-medium">Plan</label>
            <select name="service_plan_id" class="w-full rounded border px-3 py-2">
                @foreach ($plans as $plan)
                    <option value="{{ $plan->id }}">{{ $plan->name }} (ZMW {{ number_format($plan->price, 2) }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-1 block font-medium">Start Date</label>
            <input type="date" name="starts_at" class="w-full rounded border px-3 py-2" required>
        </div>
        <button type="submit" class="rounded bg-slate-900 px-4 py-2 text-white">Create</button>
    </form>
</div>
@endsection
