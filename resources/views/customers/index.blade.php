@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Customers</h1>
    <a href="{{ route('customers.create') }}" class="rounded bg-slate-900 px-4 py-2 text-white">New Customer</a>
</div>

<div class="overflow-hidden rounded bg-white shadow">
    <table class="min-w-full text-left">
        <thead class="bg-slate-100 text-sm uppercase text-slate-600">
            <tr>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Type</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Balance</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $customer)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $customer->name }}</td>
                    <td class="px-4 py-3">{{ ucfirst($customer->customer_type) }}</td>
                    <td class="px-4 py-3">{{ $customer->email }}</td>
                    <td class="px-4 py-3">ZMW {{ number_format($customer->statement_balance(), 2) }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('customers.statement', $customer) }}" class="text-indigo-600">Statement</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-500">No customers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $customers->links() }}
@endsection
