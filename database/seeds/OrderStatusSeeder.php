<?php

use App\SupplierFinancialStatus;
use App\SupplierFulfilmentStatus;
use App\SupplierOrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order_statuses = [
            'open',
            'closed',
            'cancelled',
            'any',
        ];

        $order_financial_statuses = [
            'authorized',
            'pending',
            'paid',
            'partially_paid',
            'refunded',
            'voided',
            'partially_refunded',
            'any',
            'unpaid',
        ];

        $order_fulfillment_statuses = [
            'shipped',
            'partial',
            'unshipped',
            'any',
            'unfulfilled',
        ];


        foreach ($order_statuses as $order_status) {
            SupplierOrderStatus::firstOrCreate(['name' => $order_status]);
        }

        foreach ($order_financial_statuses as $order_financial_status) {
            SupplierFinancialStatus::firstOrCreate(['name' => $order_financial_status]);
        }

        foreach ($order_fulfillment_statuses as $order_fulfillment_status) {
            SupplierFulfilmentStatus::firstOrCreate(['name' => $order_fulfillment_status]);
        }
    }
}
