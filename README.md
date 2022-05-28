## Product URL Prefix

This module adds a prefix to the product url<br>

After installing this, it's necessary to regenerate all the product URL for each store view.<br>
For that goal to be accomplished you can use the "elgentos/regenerate-catalog-urls" modules<br>

```sh
bin/magento regenerate:product:url -s all
````

#TODO
1. Config with the URL prefix per Store View with a default config already set as empty.
2. Generate the url without prefix as a 301 redirect to the URL with the prefix.<br>
Example: /bio-facelift to /product/bio-facelift
