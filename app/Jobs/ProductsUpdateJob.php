<?php namespace App\Jobs;

use App\RetailerProduct;
use App\RetailerProductImage;
use App\RetailerProductOption;
use App\RetailerProductVariant;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProductsUpdateJob implements ShouldQueue
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
        $productOptions = $product->options;
        $productVariants = $product->variants;
        $productImages = $product->images;

        if ($retailer_product != null) {

            $retailer = User::where('name', $this->shopDomain)->first();
            if ($retailer != null) {
                $retailer_product->title = $product->title;
                $retailer_product->body_html = $product->body_html;
                $retailer_product->toShopify = true;
                $retailer_product->vendor = $product->vendor;
                $retailer_product->type = $product->product_type;
                $retailer_product->handle = $product->handle;
                $retailer_product->tags = $product->tags;
                $retailer_product->status = 1;
                $retailer_product->save();

                foreach ($productOptions as $productOption) {
                    $option = RetailerProductOption::where('retailer_product_id', $retailer_product->id)
                        ->where('position', $productOption->position)
                        ->first();
                    $option->retailer_product_id = $retailer_product->id;
                    $option->name = $productOption->name;
                    $option->position = $productOption->position;
                    $option->values = json_encode($productOption->values);
                    $option->save();
                }

                foreach ($productVariants as $product_variant) {

                    $retailer_product_variant = RetailerProductVariant::where('shopify_variant_id', $product_variant->id)
                        ->first();

                    $retailer_product_variant->grams = $product_variant->grams;
                    $retailer_product_variant->title = $product_variant->title;
                    $retailer_product_variant->sku = $product_variant->sku;
                    $retailer_product_variant->option1 = $product_variant->option1;
                    $retailer_product_variant->option2 = $product_variant->option2;
                    $retailer_product_variant->option3 = $product_variant->option3;
                    $retailer_product_variant->weight = $product_variant->weight;
                    $retailer_product_variant->weight_unit = $product_variant->weight_unit;
                    $retailer_product_variant->cost = $product_variant->price;
                    $retailer_product_variant->price = $product_variant->price;
                    $retailer_product_variant->quantity = $product_variant->inventory_quantity;
                    $retailer_product_variant->barcode = $product_variant->barcode;
                    $retailer_product_variant->shopify_image_id = $product_variant->image_id;

                    $retailer_product_variant->save();
                }

                foreach ($productImages as $productImage) {
                    $retailer_product_image = RetailerProductImage::where('shopify_image_id', $productImage->id)
                        ->first();

                    $retailer_product_image->alt = $productImage->alt;
                    $retailer_product_image->position = $productImage->position;
                    $retailer_product_image->height = $productImage->height;
                    $retailer_product_image->width = $productImage->width;
                    $retailer_product_image->src = $productImage->src;
                    $retailer_product_image->variant_ids = json_encode($productImage->variant_ids);

                    $retailer_product_image->save();

                    $checkHowManyVariantsAreLinkedWithImage = $productImage->variant_ids;
                    foreach ($checkHowManyVariantsAreLinkedWithImage as $shopify_variant_id) {
                        $localVariant = RetailerProductVariant::where('shopify_variant_id', $shopify_variant_id)->first();

                        $localVariant->retailer_product_image_id = $retailer_product_image->id;
                        $localVariant->src = $retailer_product_image->src;
                        $localVariant->shopify_image_id = $retailer_product_image->shopify_image_id;

                        //yes this image is linked with variant
                        $retailer_product_image->isVariant = true;
                        $retailer_product_image->save();
                        $localVariant->save();
                    }
                    $retailer_product_image->save();
                }

                //assign images to variants
                $retailer_product->save();
            }
        }

    }
}
