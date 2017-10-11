<?php

namespace Dispatch\Config;

use Dispatch\Taxonomies\BlogCategories as BlogCategories;

class CustomTaxonomies {

    public function __construct() {

      new BlogCategories;

    }

}
