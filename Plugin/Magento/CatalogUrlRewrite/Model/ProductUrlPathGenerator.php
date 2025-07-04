<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Array42\CatalogUrlPrefix\Plugin\Magento\CatalogUrlRewrite\Model;

use Closure;
use Array42\CatalogUrlPrefix\Model\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ProductUrlPathGenerator
{

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * @param Config $config;
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * @param \Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator $subject
     * @param Closure $proceed
     * @param $product
     * @param null $category
     * @return mixed|string
     */
    public function aroundGetUrlPath(
        \Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator $subject,
        Closure $proceed,
        $product,
        $category = null
    ) {
        $urlPath = $proceed($product, $category);
        return $category === null ? $this->getUrlPathWithPrefix($urlPath, $product->getStoreId()) : $urlPath;
    }

    /**
     * @param $urlPath
     * @param $storeId
     * @return string
     */
    public function getUrlPathWithPrefix($urlPath, $storeId): string
    {
        $productPrefixUrl = $this->config->getCatalogUrlPrefix($storeId);
        if (substr($urlPath, 0, strlen($productPrefixUrl)) == $productPrefixUrl) {
            return $urlPath; // No need to add prefix if it already exists
        }

        return $this->config->getCatalogUrlPrefix($storeId) . $urlPath;
    }
}

