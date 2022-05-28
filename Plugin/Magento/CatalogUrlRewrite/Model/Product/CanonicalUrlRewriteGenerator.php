<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Array42\CatalogUrlPrefix\Plugin\Magento\CatalogUrlRewrite\Model\Product;

use Array42\CatalogUrlPrefix\Model\Config;
use Magento\Catalog\Model\Product;
use Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator;
use Magento\UrlRewrite\Service\V1\Data\UrlRewriteFactory;

class CanonicalUrlRewriteGenerator
{
    /**
     * @var ProductUrlPathGenerator
     */
    protected ProductUrlPathGenerator $productUrlPathGenerator;

    /**
     * @var UrlRewriteFactory
     */
    protected UrlRewriteFactory $urlRewriteFactory;

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * @param ProductUrlPathGenerator $productUrlPathGenerator
     * @param UrlRewriteFactory $urlRewriteFactory
     * @param Config $config
     */
    public function __construct(
        ProductUrlPathGenerator $productUrlPathGenerator,
        UrlRewriteFactory $urlRewriteFactory,
        Config $config
    ) {
        $this->productUrlPathGenerator = $productUrlPathGenerator;
        $this->urlRewriteFactory = $urlRewriteFactory;
        $this->config = $config;
    }

    /**
     * @param \Magento\CatalogUrlRewrite\Model\Product\CanonicalUrlRewriteGenerator $subject
     * @param $urls
     * @param $storeId
     * @param Product $product
     * @return mixed
     */
    public function afterGenerate(
        \Magento\CatalogUrlRewrite\Model\Product\CanonicalUrlRewriteGenerator $subject,
        $urls,
        $storeId,
        Product $product
    ): array {

        $productPrefixUrl = $this->config->getCatalogUrlPrefix($storeId);

        if (!$productPrefixUrl && $this->config->isGenerateNonprefix301Redirect($storeId)) return $urls;

        $requestPath = $this->productUrlPathGenerator->getUrlPathWithSuffix($product, $storeId);
        $targetPath = $requestPath;

        // Removes the prefix from the prefixed URL which is the "old" URL/original magento product URL
        if (substr($requestPath, 0, strlen($productPrefixUrl)) == $productPrefixUrl) {
            $requestPath = substr($requestPath, strlen($productPrefixUrl));
        }

        // If the request url is the same as the target url, if because there is no prefix, so it doesn't need to create a 301 redirect
        if ($requestPath === $targetPath) return $urls;

        $urlnew = $this->urlRewriteFactory->create()
            // did this so this rewrite is not used on the category list
            ->setEntityType(Config::PERMANENT_REDIRECT_ENTITY_TYPE)
            ->setEntityId($product->getId())
            ->setRequestPath($requestPath)
            ->setTargetPath($targetPath)
            ->setRedirectType(301)
            ->setStoreId($storeId);

        return [
            ...$urls,
            $urlnew
        ];
    }
}

