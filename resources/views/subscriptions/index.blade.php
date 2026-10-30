@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Subscriptions</h1>
    <a href="{{ route('subscriptions.create') }}" class="rounded bg-slate-900 px-4 py-2 text-white">New Subscription</a>
</div>

<div class="overflow-hidden rounded bg-white shadow">
    <table class="min-w-full text-left">
        <thead class="bg-slate-100 text-sm uppercase text-slate-600">
            <tr>
                <th class="px-4 py-3">Customer</th>
                <th class="px-4 py-3">Plan</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Starts</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($subscriptions as $subscription)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $subscription->customer->name }}</td>
                    <td class="px-4 py-3">{{ $subscription->servicePlan->name }}</td>
                    <td class="px-4 py-3">{{ $subscription->status }}</td>
                    <td class="px-4 py-3">{{ $subscription->starts_at?->format('d M Y') }}</td>
                    <td class="px-4 py-3 space-x-3">
                        <form action="{{ route('subscriptions.activate', $subscription) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-emerald-600">Activate</button>
                        </form>
                        <form action="{{ route('subscriptions.generate-invoice', $subscription) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-indigo-600">Generate Invoice</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-500">No subscriptions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $subscriptions->links() }}
@endsection
