<?php

namespace Array42\CatalogUrlPrefix\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{

    const XML_PATH_GENERATE_NONPREFIX_301_REDIRECT = 'catalog/seo/generate_nonprefix_301_redirect';
    const XML_PATH_PRODUCT_URL_PREFIX = 'catalog/seo/product_url_prefix';
    const PERMANENT_REDIRECT_ENTITY_TYPE = 'product-array42-301redirect';

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function getCatalogUrlPrefix($storeId = null): string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_PRODUCT_URL_PREFIX, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function isGenerateNonprefix301Redirect($storeId = null): bool
    {
        return (bool)$this->scopeConfig->getValue(self::XML_PATH_GENERATE_NONPREFIX_301_REDIRECT, ScopeInterface::SCOPE_STORE, $storeId);
    }

}
