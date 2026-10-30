<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Organization;
use App\Models\ServicePlan;
use App\Models\Subscription;
use App\Models\User;
use App\Services\Billing\BillingEngineService;
use App\Services\Accounting\AccountingService;
use App\Services\Payments\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionBillingWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_subscription_invoice_payment_and_statement_workflow(): void
    {
        $organization = Organization::create([
            'name' => 'Zambia Connect Ltd',
            'currency' => 'ZMW',
            'tax_number' => '123456789',
            'timezone' => 'Africa/Lusaka',
        ]);

        $user = User::factory()->create([
            'organization_id' => $organization->id,
        ]);

        $customer = Customer::create([
            'organization_id' => $organization->id,
            'name' => 'Nawina Investments',
            'customer_type' => 'business',
            'email' => 'billing@nawina.com',
            'phone' => '+260955000000',
            'status' => 'active',
            'credit_limit' => 5000.00,
        ]);

        $plan = ServicePlan::create([
            'organization_id' => $organization->id,
            'name' => 'Business Fibre',
            'code' => 'BF-01',
            'billing_interval' => 'monthly',
            'price' => 1200.00,
            'tax_rate' => 0.16,
            'is_active' => true,
        ]);

        $subscription = Subscription::create([
            'organization_id' => $organization->id,
            'customer_id' => $customer->id,
            'service_plan_id' => $plan->id,
            'status' => 'draft',
            'starts_at' => now()->startOfMonth(),
            'next_billing_at' => now()->startOfMonth()->addMonth(),
        ]);

        $subscription->activate();

        $invoice = BillingEngineService::generateForSubscription($subscription);

        $this->assertSame('issued', $invoice->status);
        $this->assertEquals(1200.00, $invoice->subtotal);
        $this->assertEquals(192.00, $invoice->tax_total);
        $this->assertEquals(1392.00, $invoice->total);
        $this->assertSame($organization->id, $invoice->organization_id);

        $journal = AccountingService::recordInvoicePosting($invoice);
        $this->assertTrue($journal->lines()->sum('debit') == $journal->lines()->sum('credit'));

        $payment = PaymentService::recordPayment([
            'organization_id' => $organization->id,
            'customer_id' => $customer->id,
            'invoice_id' => $invoice->id,
            'amount' => 1392.00,
            'method' => 'bank_transfer',
            'reference' => 'PAY-1001',
            'paid_at' => now(),
        ]);

        $this->assertEquals(1392.00, (float) $payment->amount);
        $this->assertEquals(0.00, $customer->fresh()->statement_balance());

        $receivable = AccountingService::recordPaymentPosting($payment);
        $this->assertTrue($receivable->lines()->sum('debit') == $receivable->lines()->sum('credit'));

        $this->assertSame(0.00, (float) $customer->fresh()->statement_balance());
        $this->assertNotNull($customer->fresh()->latest_statement());
        $this->assertDatabaseHas('journal_entries', ['source_type' => Invoice::class]);
    }
}
