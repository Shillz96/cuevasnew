<?php
/**
 * Class WCLSI_Data_Transformer
 * Handles data transformation between WooCommerce and Lightspeed formats
 */
class WCLSI_Data_Transformer {
    private const DEFAULT_CURRENCY = 'USD';
    private const DEFAULT_TAX_RATE = 0.0;
    private const DEFAULT_WEIGHT_UNIT = 'lbs';

    /**
     * Transform WooCommerce product to Lightspeed format
     * @param WC_Product $product WooCommerce product
     * @return array Lightspeed product data
     */
    public function wc_to_ls_product(WC_Product $product): array {
        return [
            'description' => $product->get_name(),
            'shortDescription' => $product->get_short_description(),
            'customSku' => $product->get_sku(),
            'upc' => $product->get_meta('_upc'),
            'price' => $this->format_price($product->get_regular_price()),
            'salePrice' => $this->format_price($product->get_sale_price()),
            'cost' => $this->format_price($product->get_cost()),
            'weight' => $this->format_weight($product->get_weight()),
            'weightUnit' => self::DEFAULT_WEIGHT_UNIT,
            'tax' => $this->format_tax($product),
            'category' => $this->get_category_data($product),
            'images' => $this->get_image_data($product),
            'attributes' => $this->get_attribute_data($product),
            'inventory' => $this->get_inventory_data($product)
        ];
    }

    /**
     * Transform Lightspeed product to WooCommerce format
     * @param array $ls_product Lightspeed product data
     * @return array WooCommerce product data
     */
    public function ls_to_wc_product(array $ls_product): array {
        return [
            'name' => $ls_product['description'] ?? '',
            'short_description' => $ls_product['shortDescription'] ?? '',
            'sku' => $ls_product['customSku'] ?? '',
            'regular_price' => $this->parse_price($ls_product['price'] ?? 0),
            'sale_price' => $this->parse_price($ls_product['salePrice'] ?? 0),
            'manage_stock' => true,
            'stock_quantity' => $ls_product['inventory']['quantity'] ?? 0,
            'weight' => $this->parse_weight($ls_product['weight'] ?? 0),
            'tax_status' => $this->parse_tax_status($ls_product['tax'] ?? []),
            'tax_class' => $this->parse_tax_class($ls_product['tax'] ?? []),
            'category_ids' => $this->parse_categories($ls_product['category'] ?? []),
            'images' => $this->parse_images($ls_product['images'] ?? []),
            'attributes' => $this->parse_attributes($ls_product['attributes'] ?? [])
        ];
    }

    /**
     * Format price for Lightspeed
     * @param string|float $price Price to format
     * @return float Formatted price
     */
    private function format_price($price): float {
        return (float) number_format((float) $price, 2, '.', '');
    }

    /**
     * Parse price from Lightspeed
     * @param float $price Price to parse
     * @return string Formatted price
     */
    private function parse_price(float $price): string {
        return number_format($price, 2, '.', '');
    }

    /**
     * Format weight for Lightspeed
     * @param string|float $weight Weight to format
     * @return float Formatted weight
     */
    private function format_weight($weight): float {
        return (float) number_format((float) $weight, 2, '.', '');
    }

    /**
     * Parse weight from Lightspeed
     * @param float $weight Weight to parse
     * @return string Formatted weight
     */
    private function parse_weight(float $weight): string {
        return number_format($weight, 2, '.', '');
    }

    /**
     * Format tax data for Lightspeed
     * @param WC_Product $product WooCommerce product
     * @return array Tax data
     */
    private function format_tax(WC_Product $product): array {
        return [
            'tax' => $product->get_tax_status() === 'taxable' ? self::DEFAULT_TAX_RATE : 0,
            'taxClass' => $product->get_tax_class()
        ];
    }

    /**
     * Parse tax status from Lightspeed
     * @param array $tax_data Tax data
     * @return string Tax status
     */
    private function parse_tax_status(array $tax_data): string {
        return ($tax_data['tax'] ?? 0) > 0 ? 'taxable' : 'none';
    }

    /**
     * Parse tax class from Lightspeed
     * @param array $tax_data Tax data
     * @return string Tax class
     */
    private function parse_tax_class(array $tax_data): string {
        return $tax_data['taxClass'] ?? '';
    }

    /**
     * Get category data for Lightspeed
     * @param WC_Product $product WooCommerce product
     * @return array Category data
     */
    private function get_category_data(WC_Product $product): array {
        $categories = [];
        foreach ($product->get_category_ids() as $category_id) {
            $category = get_term($category_id, 'product_cat');
            if ($category) {
                $categories[] = [
                    'categoryID' => $category_id,
                    'name' => $category->name
                ];
            }
        }
        return $categories;
    }

    /**
     * Parse categories from Lightspeed
     * @param array $categories Category data
     * @return array Category IDs
     */
    private function parse_categories(array $categories): array {
        $category_ids = [];
        foreach ($categories as $category) {
            if (isset($category['categoryID'])) {
                $category_ids[] = $category['categoryID'];
            }
        }
        return $category_ids;
    }

    /**
     * Get image data for Lightspeed
     * @param WC_Product $product WooCommerce product
     * @return array Image data
     */
    private function get_image_data(WC_Product $product): array {
        $images = [];
        $image_ids = $product->get_gallery_image_ids();
        array_unshift($image_ids, $product->get_image_id());

        foreach ($image_ids as $image_id) {
            $image_url = wp_get_attachment_image_url($image_id, 'full');
            if ($image_url) {
                $images[] = [
                    'imageID' => $image_id,
                    'url' => $image_url
                ];
            }
        }

        return $images;
    }

    /**
     * Parse images from Lightspeed
     * @param array $images Image data
     * @return array Image URLs
     */
    private function parse_images(array $images): array {
        $image_urls = [];
        foreach ($images as $image) {
            if (isset($image['url'])) {
                $image_urls[] = $image['url'];
            }
        }
        return $image_urls;
    }

    /**
     * Get attribute data for Lightspeed
     * @param WC_Product $product WooCommerce product
     * @return array Attribute data
     */
    private function get_attribute_data(WC_Product $product): array {
        $attributes = [];
        foreach ($product->get_attributes() as $attribute) {
            $attributes[] = [
                'name' => $attribute->get_name(),
                'value' => $attribute->get_options()
            ];
        }
        return $attributes;
    }

    /**
     * Parse attributes from Lightspeed
     * @param array $attributes Attribute data
     * @return array WooCommerce attributes
     */
    private function parse_attributes(array $attributes): array {
        $wc_attributes = [];
        foreach ($attributes as $attribute) {
            if (isset($attribute['name'], $attribute['value'])) {
                $wc_attributes[] = [
                    'name' => $attribute['name'],
                    'options' => (array) $attribute['value']
                ];
            }
        }
        return $wc_attributes;
    }

    /**
     * Get inventory data for Lightspeed
     * @param WC_Product $product WooCommerce product
     * @return array Inventory data
     */
    private function get_inventory_data(WC_Product $product): array {
        return [
            'quantity' => $product->get_stock_quantity(),
            'reorderPoint' => $product->get_low_stock_amount(),
            'reorderAmount' => $product->get_backorders_allowed() ? 1 : 0
        ];
    }
} 