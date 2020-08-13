<?php namespace App\Jobs;

use App\RetailerProduct;
use App\RetailerProductImage;
use App\RetailerProductOption;
use App\RetailerProductVariant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProductsDeleteJob implements ShouldQueue
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
        $product = $this->data;
        $retailer_product = RetailerProduct::where('shopify_product_id', $product->id)->first();

        RetailerProductOption::where('retailer_product_id', $retailer_product->id)->delete();
        RetailerProductImage::where('retailer_product_id', $retailer_product->id)->delete();
        RetailerProductVariant::where('retailer_product_id', $retailer_product->id)->delete();

        Log::critical($retailer_product->delete());
    }
}
