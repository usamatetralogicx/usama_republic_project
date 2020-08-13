<?php namespace App\Jobs;

use App\Option;
use App\Product;
use App\ProductImage;
use App\ProductVariants;
use App\RetailerProduct;
use App\RetailerProductImage;
use App\RetailerProductOption;
use App\RetailerProductVariant;
use App\User;
use http\Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OhMyBrew\ShopifyApp\Models\Shop;

class ProductsCreateJob implements ShouldQueue
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

        //create a product in local database
        $checkIfThisProductAlreadyExists = RetailerProduct::where('shopify_product_id', $product->id)
            ->first();
        if ($checkIfThisProductAlreadyExists == null && $checkIfThisProductAlreadyExists->supplier_id == null) {

            //its a new product fetch it
            $newProduct = new Product();
            Log::info('Its new Product');

            $newProduct->shopify_product_id = $product->id;
            $newProduct->title = $product->title;
            $newProduct->body_html = $product->body_html;
            $newProduct->vendor = $product->vendor;
            $newProduct->type = $product->product_type;

            $newProduct->handle = $product->handle;
            $newProduct->tags = $product->tags;
            $newProduct->supplier_id = Auth::id();
            $newProduct->save();

            $first = 0;
            foreach ($product->variants as $variant) {

                //storing info at product level
                if ($first == 0) {
                    $newProduct->cost = floatval($variant->price);
                    $newProduct->price = floatval($variant->price);
                    $newProduct->grams = $variant->grams;
                    $newProduct->barcode = $variant->barcode;
                    $newProduct->sku = $variant->sku;
                    $first++;
                }

                //creating a local product variant
                $newVariant = new ProductVariants();

                $newVariant->product_id = $newProduct->id; //linked newly coming product from shopify with local
                $newVariant->shopify_variant_id = $variant->id; //variant id from shopify
                $newVariant->title = $variant->title;
                $newVariant->cost = floatval($variant->price); // price of supplier product is the cost for retailer
                $newVariant->price = floatval($variant->price); // price of supplier product is the cost for retailer
                $newVariant->sku = $variant->sku;
                $newVariant->option1 = $variant->option1;
                $newVariant->option2 = $variant->option2;
                $newVariant->option3 = $variant->option3;
                $newVariant->weight = $variant->weight;
                $newVariant->weight_unit = $variant->weight_unit;
                $newVariant->grams = $variant->grams;
                $newVariant->shopify_image_id = $variant->image_id;


                $newVariant->save();
            }

            //storing product level images
            $index = 0;
            foreach ($product->images as $image) {
                //storing first image as product main image
                if ($index == 0) {
                    $newProduct->image = $image->src;
                    $index++;
                }

                //creating local image object
                $product_image = new ProductImage();

                $product_image->shopify_image_id = $image->id; //coming from shopify
                $product_image->product_id = $newProduct->id;
                $product_image->alt = $image->alt;
                $product_image->height = $image->height;
                $product_image->width = $image->width;
                $product_image->position = $image->position;
                $product_image->src = $image->src;
                $product_image->variants_ids = json_encode($image->variant_ids);
                $product_image->isVariant = false;

                $product_image->save();

                //link image with variants
                $checkHowManyVariantsAreLinkedWithImage = $image->variant_ids;
                foreach ($checkHowManyVariantsAreLinkedWithImage as $shopify_variant_id) {
                    $localVariant = ProductVariants::where('shopify_variant_id', $shopify_variant_id)->first();

                    $localVariant->image_id = $product_image->id;
                    $localVariant->src = $product_image->src;
                    $localVariant->shopify_image_id = $product_image->shopify_image_id;

                    //yes this image is linked with variant
                    $product_image->isVariant = true;
                    $product_image->save();
                    $localVariant->save();
                }
            }

            //storing variants options and values in PRODUCT table
            for ($i = 0; $i < count($product->options); $i++) {
                if ($i == 0) {
                    $newProduct->option1 = $product->options[$i]->name;
                    $newProduct->value1 = json_encode($product->options[$i]->values);
                } else if ($i == 1) {
                    $newProduct->option2 = $product->options[$i]->name;
                    $newProduct->value2 = json_encode($product->options[$i]->values);
                } else if ($i == 2) {
                    $newProduct->option3 = $product->options[$i]->name;
                    $newProduct->value3 = json_encode($product->options[$i]->values);
                }
            }

            foreach ($product->options as $product_option) {
                $option = new Option();
                $option->name = $product_option->name;
                $option->product_id = $newProduct->id;
                $option->position = $product_option->position;
                $option->values = json_encode($product_option->values);
                $option->save();
            }

            $newProduct->fromShopify = true; //is this product coming from shopify?
            $newProduct->save();

            $retailer = User::where('name', $this->shopDomain)->first();
            $productOptions = json_decode(json_encode($product->options), true);
            $product_variants = json_decode(json_encode($product->variants), true);

            $productImages = json_decode(json_encode($product->images), true);

            if ($productImages == null) {

                sleep(5); //wait for 5 seconds to call again the API
                //in case images does not comes with webhook
                $shop = Shop::where('shopify_domain', $this->shopDomain)->first();
                $key = '493982815366070b63472ba943c82ba9';
                $secret = '0f9a385390100b0c4179fb9ddcd3206c';
                $sh = App::make('ShopifyAPI', ['API_KEY' => $key, 'API_SECRET' => $secret, 'SHOP_DOMAIN' => $shop->shopify_domain, 'ACCESS_TOKEN' => $shop->shopify_token]);

                try {
                    $call = $sh->call(['URL' => '/admin/api/2020-01/products/' . $product->id . '.json', 'METHOD' => 'GET']);

                    $response = json_decode(json_encode($call->product), true);
                    $productImages = $response['images'];
                    $image = $response['image'];

                } catch (Exception $e) {

                    $call = $e->getMessage();
                    Log::critical(json_encode($call));
                }

            }

            if ($retailer != null) {
                $retailer_product = new RetailerProduct(); //create new retailer product
                $retailer_product->product_id = $newProduct->id;
                $retailer_product->shopify_product_id = $product->id;
                $retailer_product->retailer_id = $retailer->id;
                $retailer_product->title = $product->title;
                $retailer_product->body_html = $product->body_html;
                $retailer_product->toShopify = true;
                $retailer_product->vendor = $product->vendor;
                if (isset($productOptions[0])) {
                    $retailer_product->option1 = $productOptions[0]['name'];
                    $retailer_product->value1 = json_encode($productOptions[0]['values']);

                }
                if (isset($productOptions[1])) {
                    $retailer_product->option2 = $productOptions[1]['name'];
                    $retailer_product->value2 = json_encode($productOptions[1]['values']);

                }
                if (isset($productOptions[2])) {
                    $retailer_product->option3 = $productOptions[2]['name'];
                    $retailer_product->value3 = json_encode($productOptions[2]['values']);

                }
                if (isset($product_variants[0])) {
                    $retailer_product->cost = floatval($product_variants[0]['price']);
                    $retailer_product->price = floatval($product_variants[0]['price']);
                    $retailer_product->sku = $product_variants[0]['sku'];
                    $retailer_product->barcode = $product_variants[0]['barcode'];
                    $retailer_product->grams = $product_variants[0]['grams'];

                }
                if (isset($image)) {
                    $retailer_product->image = $image['src'];
                } else if (isset($productImages[0])) {
                    $retailer_product->image = $productImages[0]['src'];
                }

                $retailer_product->type = $product->product_type;
                $retailer_product->handle = $product->handle;
                $retailer_product->tags = $product->tags;
                $retailer_product->status = 1;
                $retailer_product->save();

                foreach ($productOptions as $productOption) {
                    $option = new RetailerProductOption();
                    $option->retailer_product_id = $retailer_product->id;
                    $option->name = $productOption['name'];
                    $option->position = $productOption['position'];
                    $option->values = json_encode($productOption['values']);
                    $option->save();
                }

                foreach ($product_variants as $product_variant) {

                    $retailer_product_variant = new RetailerProductVariant();

                    $retailer_product_variant->retailer_product_id = $retailer_product->id;
                    $retailer_product_variant->grams = $product_variant['grams'];
                    $retailer_product_variant->title = $product_variant['title'];
                    $retailer_product_variant->sku = $product_variant['sku'];
                    $retailer_product_variant->option1 = $product_variant['option1'];
                    $retailer_product_variant->option2 = $product_variant['option2'];
                    $retailer_product_variant->option3 = $product_variant['option3'];
                    $retailer_product_variant->weight = $product_variant['weight'];
                    $retailer_product_variant->weight_unit = $product_variant['weight_unit'];
                    $retailer_product_variant->cost = floatval($product_variant['price']);
                    $retailer_product_variant->price = floatval($product_variant['price']);
                    $retailer_product_variant->quantity = $product_variant['inventory_quantity'];
                    $retailer_product_variant->barcode = $product_variant['barcode'];
                    $retailer_product_variant->shopify_image_id = $product_variant['image_id'];
                    $retailer_product_variant->shopify_variant_id = $product_variant['id'];
                    $retailer_product_variant->local_shopify_variant_id = $product_variant['id'];

                    $retailer_product_variant->save();
                }

                foreach ($productImages as $productImage) {
                    $retailer_product_image = new RetailerProductImage();
                    $retailer_product_image->retailer_product_id = $retailer_product->id;
                    $retailer_product_image->retailer_product_variant_id = $retailer_product_variant->id;
                    $retailer_product_image->shopify_image_id = $productImage['id'];

                    $retailer_product_image->alt = $productImage['alt'];
                    $retailer_product_image->position = $productImage['position'];
                    $retailer_product_image->height = $productImage['height'];
                    $retailer_product_image->width = $productImage['width'];
                    $retailer_product_image->src = $productImage['src'];
                    $retailer_product_image->variant_ids = json_encode($productImage['variant_ids']);

                    $retailer_product_image->save();

                    $checkHowManyVariantsAreLinkedWithImage = $productImage['variant_ids'];
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
