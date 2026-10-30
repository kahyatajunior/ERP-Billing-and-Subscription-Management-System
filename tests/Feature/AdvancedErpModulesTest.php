<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Organization;
use App\Models\ServicePlan;
use App\Models\Subscription;
use App\Services\Currency\CurrencyConversionService;
use App\Services\Subscriptions\SubscriptionLifecycleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvancedErpModulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_subscription_state_engine_allows_valid_transitions(): void
    {
        $organization = Organization::create([
            'name' => 'DataWorks Zambia',
            'currency' => 'ZMW',
            'tax_number' => 'ZW-1001',
            'timezone' => 'Africa/Lusaka',
        ]);

        $customer = Customer::create([
            'organization_id' => $organization->id,
            'name' => 'BlueStone Ltd',
            'customer_type' => 'business',
            'email' => 'billing@bluestone.co.zm',
            'status' => 'active',
        ]);

        $plan = ServicePlan::create([
            'organization_id' => $organization->id,
            'name' => 'Business Fiber',
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
            'starts_at' => now(),
            'next_billing_at' => now()->addMonth(),
        ]);

        $this->assertTrue(SubscriptionLifecycleService::canTransitionTo($subscription, 'pending_approval'));

        SubscriptionLifecycleService::transitionTo($subscription, 'pending_approval');

        $this->assertSame('pending_approval', $subscription->fresh()->status);
        $this->assertTrue(SubscriptionLifecycleService::canTransitionTo($subscription->fresh(), 'active'));

        $this->expectException(\InvalidArgumentException::class);
        SubscriptionLifecycleService::transitionTo($subscription->fresh(), 'expired');
    }

    public function test_currency_conversion_service_uses_exchange_rates(): void
    {
        $organization = Organization::create([
            'name' => 'Regional Holdings',
            'currency' => 'ZMW',
            'tax_number' => 'ZW-2022',
            'timezone' => 'Africa/Lusaka',
        ]);

        $currency = \App\Models\Currency::create([
            'organization_id' => $organization->id,
            'code' => 'USD',
            'name' => 'US Dollar',
            'symbol' => '$',
            'is_base' => false,
            'is_active' => true,
        ]);

        \App\Models\Currency::create([
            'organization_id' => $organization->id,
            'code' => 'ZMW',
            'name' => 'Zambian Kwacha',
            'symbol' => 'ZK',
            'is_base' => true,
            'is_active' => true,
        ]);

        \App\Models\ExchangeRate::create([
            'organization_id' => $organization->id,
            'source_currency' => 'USD',
            'target_currency' => 'ZMW',
            'rate' => 17.50,
            'effective_date' => now()->toDateString(),
            'source' => 'manual',
        ]);

        $this->assertSame(1750.0, CurrencyConversionService::convert(100, 'USD', 'ZMW', $organization));
    }
}
