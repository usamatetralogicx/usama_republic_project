<?php namespace App\Jobs;

use App\LineItem;
use App\RetailerOrder;
use App\RetailerProductVariant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrdersUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Shop's myshopify domain
     *
     * @var string
     */
    public $shopDomain;

    /**
     * The webhook data
     *
     * @var object
     */
    public $data;

    /**
     * Create a new job instance.
     *
     * @param string $shopDomain The shop's myshopify domain
     * @param object $data The webhook data (JSON decoded)
     *
     * @return void
     */
    public function __construct($shopDomain, $data)
    {
        $this->shopDomain = $shopDomain;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::critical('Order update web hook: ' . json_encode($this->data));
        $order = $this->data;

        Log::critical($order->id);

        $newOrder = RetailerOrder::where('shopify_order_id', $order->id)->first();

        Log::critical(json_encode($newOrder));

        $newOrder->shopify_order_id = $order->id;
        $newOrder->email = $order->email;
        $newOrder->line_items = json_encode($order->line_items);
        $newOrder->closed_at = $order->closed_at;
        $newOrder->shopify_created_at = $order->created_at;
        $newOrder->shopify_updated_at = $order->updated_at;
        $newOrder->number = $order->number;
        $newOrder->note = $order->note;
        $newOrder->token = $order->token;
        $newOrder->gateway = $order->gateway;
        $newOrder->total_price = floatval($order->total_price);
        $newOrder->subtotal_price = floatval($order->subtotal_price);
        $newOrder->total_weight = $order->total_weight;
        $newOrder->total_tax = $order->total_tax;
        $newOrder->taxes_included = $order->taxes_included;
        $newOrder->financial_status = $order->financial_status;
        $newOrder->confirmed = $order->confirmed;
        $newOrder->currency = $order->currency;
        $newOrder->total_discounts = $order->total_discounts;
        $newOrder->total_line_items_price = floatval($order->total_line_items_price);
        $newOrder->buyer_accepts_marketing = $order->buyer_accepts_marketing;
        $newOrder->cancelled_at = $order->cancelled_at;
        $newOrder->name = $order->name;
        $newOrder->referring_site = $order->referring_site;
        $newOrder->landing_site = $order->landing_site;
        $newOrder->cancel_reason = $order->cancel_reason;
        $newOrder->total_price_usd = floatval($order->total_price_usd);
        $newOrder->user_id = $order->user_id;
        $newOrder->phone = $order->phone;
        $newOrder->app_id = $order->app_id;
        $newOrder->order_number = $order->order_number;
        $newOrder->payment_gateway_names = json_encode($order->payment_gateway_names);
        $newOrder->fulfillment_status = $order->fulfillment_status;
        $newOrder->processing_method = $order->processing_method;
        $newOrder->tax_lines = json_encode($order->tax_lines);
        $newOrder->contact_email = $order->contact_email;
        $newOrder->order_status_url = $order->order_status_url;
        $newOrder->total_line_items_price_set = json_encode($order->total_line_items_price_set);
        $newOrder->total_price_set = json_encode($order->total_price_set);
        $newOrder->shipping_lines = json_encode($order->shipping_lines);
        if (isset($order->billing_address)) {
            $newOrder->billing_address = json_encode($order->billing_address);
        }
        if (isset($order->shipping_address)) {
            $newOrder->shipping_address = json_encode($order->shipping_address);
        }
        if (isset($order->fulfillments)) {
            $newOrder->fulfillments = json_encode($order->fulfillments);
        }
        if (isset($order->customer)) {
            $newOrder->customer = json_encode($order->customer);
            $newOrder->full_name = $order->customer->first_name . ' ' . $order->customer->last_name;
        } else {
            $newOrder->full_name = 'No Customer';
        }
        $newOrder->sync_status = true;
        $newOrder->save();

        foreach (json_decode($newOrder->line_items, true) as $item) {
//                        dd($item);else {

            $lineItem = LineItem::where('shopify_line_item_id', $item['id'])->first();
            $variant_for_linking = RetailerProductVariant::where('shopify_variant_id', $item['variant_id'])->first();

            if ($variant_for_linking != null) {
                $lineItem->retailer_product_variant_id = RetailerProductVariant::where('shopify_variant_id', $item['variant_id'])->first()->id;
            }

            $lineItem->shopify_variant_id = $item['variant_id'];
            $lineItem->title = $item['title'];
            $lineItem->quantity = $item['quantity'];
            $lineItem->variant_title = $item['variant_title'];
            $lineItem->sku = $item['sku'];
            $lineItem->vendor = $item['vendor'];
            $lineItem->fulfillment_service = $item['fulfillment_service'];
            $lineItem->requires_shipping = $item['requires_shipping'];
            $lineItem->taxable = $item['taxable'];
            $lineItem->gift_card = $item['gift_card'];
            $lineItem->name = $item['name'];
            $lineItem->properties = json_encode($item['properties']);
            $lineItem->fulfillable_quantity = $item['fulfillable_quantity'];
            $lineItem->price = floatval($item['price']);
            $lineItem->fulfillment_status = $item['fulfillment_status'];
            $lineItem->save();
        }
    }
}
