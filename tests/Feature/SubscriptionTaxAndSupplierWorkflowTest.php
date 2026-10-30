<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Organization;
use App\Models\ServicePlan;
use App\Models\Subscription;
use App\Models\Supplier;
use App\Models\SupplierInvoice;
use App\Services\Accounting\AccountingService;
use App\Services\Tax\TaxEngine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTaxAndSupplierWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_subscription_lifecycle_transitions_are_allowed(): void
    {
        $organization = Organization::create([
            'name' => 'Zambia Connect Ltd',
            'currency' => 'ZMW',
            'tax_number' => '123456789',
            'timezone' => 'Africa/Lusaka',
        ]);

        $customer = Customer::create([
            'organization_id' => $organization->id,
            'name' => 'Nimbus Telecom',
            'customer_type' => 'business',
            'email' => 'ops@nimbus.zm',
            'status' => 'active',
            'credit_limit' => 2000,
        ]);

        $plan = ServicePlan::create([
            'organization_id' => $organization->id,
            'name' => 'Starter Fibre',
            'code' => 'SF-01',
            'billing_interval' => 'monthly',
            'price' => 900.00,
            'tax_rate' => 0.16,
            'is_active' => true,
        ]);

        $subscription = Subscription::create([
            'organization_id' => $organization->id,
            'customer_id' => $customer->id,
            'service_plan_id' => $plan->id,
            'status' => 'draft',
            'starts_at' => now(),
            'next_billing_at' => now()->addMonth(),
        ]);

        $this->assertTrue($subscription->canTransitionTo('active'));
        $subscription->transitionTo('active');
        $this->assertSame('active', $subscription->status);

        $this->assertTrue($subscription->canTransitionTo('suspended'));
        $subscription->transitionTo('suspended');
        $this->assertSame('suspended', $subscription->status);

        $this->assertTrue($subscription->canTransitionTo('active'));
        $subscription->transitionTo('active');
        $this->assertSame('active', $subscription->status);

        $this->assertTrue($subscription->canTransitionTo('cancelled'));
        $subscription->transitionTo('cancelled');
        $this->assertSame('cancelled', $subscription->status);
    }

    public function test_tax_engine_calculates_tax_and_exemptions(): void
    {
        $organization = Organization::create([
            'name' => 'Zambia Connect Ltd',
            'currency' => 'ZMW',
            'tax_number' => '123456789',
            'timezone' => 'Africa/Lusaka',
        ]);

        $category = \App\Models\TaxCategory::create([
            'organization_id' => $organization->id,
            'name' => 'VAT',
            'code' => 'VAT',
            'is_active' => true,
        ]);

        $rate = \App\Models\TaxRate::create([
            'organization_id' => $organization->id,
            'tax_category_id' => $category->id,
            'rate' => 0.16,
            'effective_from' => now()->subMonth(),
            'effective_to' => now()->addYear(),
            'is_active' => true,
        ]);

        $result = TaxEngine::calculate(1000.00, $rate);
        $this->assertEquals(160.00, $result['tax_amount']);
        $this->assertEquals(1160.00, $result['total']);

        $exemptResult = TaxEngine::calculate(1000.00, null, true);
        $this->assertEquals(0.00, $exemptResult['tax_amount']);
        $this->assertEquals(1000.00, $exemptResult['total']);
    }

    public function test_supplier_invoice_posting_updates_accounts_payable_balances(): void
    {
        $organization = Organization::create([
            'name' => 'Zambia Connect Ltd',
            'currency' => 'ZMW',
            'tax_number' => '123456789',
            'timezone' => 'Africa/Lusaka',
        ]);

        $supplier = Supplier::create([
            'organization_id' => $organization->id,
            'name' => 'Lusaka Internet Works',
            'email' => 'accounts@liw.zm',
            'status' => 'active',
        ]);

        $invoice = SupplierInvoice::create([
            'organization_id' => $organization->id,
            'supplier_id' => $supplier->id,
            'invoice_number' => 'SUP-1001',
            'issue_date' => now(),
            'due_date' => now()->addDays(14),
            'subtotal' => 1500.00,
            'tax_total' => 240.00,
            'total' => 1740.00,
            'status' => 'approved',
        ]);

        $journal = AccountingService::recordSupplierInvoicePosting($invoice);

        $this->assertTrue($journal->lines()->sum('debit') == $journal->lines()->sum('credit'));
        $this->assertDatabaseHas('journal_entries', ['source_type' => SupplierInvoice::class, 'reference' => 'SUP-1001']);

        $payment = AccountingService::recordSupplierPaymentPosting($invoice, 1740.00, 'bank_transfer');
        $this->assertTrue($payment->lines()->sum('debit') == $payment->lines()->sum('credit'));
    }
}
