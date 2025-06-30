# Product URL Prefix

## Purpose

The `magento2-catalogurlprefix` module adds a custom prefix to all product URLs in your Magento 2 store. This is useful for SEO purposes, for organizing catalog URLs, or for distinguishing product URLs from other entities in your Magento installation. The prefix can be configured per store view.

## Installation

You can install this module using one of the two methods below:

### 1. Manual Copy (app/code)

1. **Download or clone the module into your Magento installation:**
   ```sh
   git clone https://github.com/burlacu-web/magento2-catalogurlprefix.git app/code/Array42/CatalogUrlPrefix
   ```
2. **Enable the module:**
   ```sh
   bin/magento module:enable Array42_CatalogUrlPrefix
   bin/magento setup:upgrade
   bin/magento cache:flush
   ```

### 2. Composer

1. **Require the module using Composer:**
   ```sh
   composer require array42/module-catalogurlprefix
   ```
2. **Enable the module:**
   ```sh
   bin/magento module:enable Array42_CatalogUrlPrefix
   bin/magento setup:upgrade
   bin/magento cache:flush
   ```

## Configuration

1. Go to the Magento Admin Panel.
2. Navigate to `Stores` > `Configuration` > `Catalog` > `Catalog` > `Search Engine Optimization`.
3. Set the desired prefix in the **Product URL Prefix** field.

## Usage

- After installing and configuring the prefix, you **must** regenerate all product URLs for each store view to apply the new prefix.
- It is recommended to use the [elgentos/regenerate-catalog-urls](https://github.com/elgentos/regenerate-catalog-urls) module (not the Magento core command) to regenerate product URLs:

   ```sh
   bin/magento regenerate:product:url
   ```

- The module will:
  - Add the configured prefix to all product URLs.
  - Optionally create 301 redirects from old URLs (without the prefix) to the new URLs, depending on configuration. Default is "Yes".

## Notes

- Make sure to flush your Magento cache and reindex after regeneration for the changes to take effect.
- Test product URLs in the frontend to confirm the prefix is correctly applied.

---
**Module developed by [Array42](https://github.com/Array42).**
