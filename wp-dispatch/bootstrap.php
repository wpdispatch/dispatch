<?php

namespace Dispatch;

use Dispatch\Provision\TGMpa as TGMpa;

use Dispatch\Config\Site as Site;
use Dispatch\Config\Context as Context;
use Dispatch\Config\Dashboard as Dashboard;
use Dispatch\Config\Menus as Menus;
use Dispatch\Config\Theme as Theme;
use Dispatch\Config\Media as Media;
use Dispatch\Config\CustomPostTypes as CustomPostTypes;
use Dispatch\Config\CustomTaxonomies as CustomTaxonomies;
use Dispatch\Config\General as General;
use Dispatch\Config\FewBricks as FewBricks;
use Dispatch\Functions\Assets as Assets;
use Dispatch\Functions\Search as Search;
use Dispatch\Plugins\YoastSEO as YoastSEO;
use Dispatch\Plugins\GForms as GForms;
use Dispatch\Plugins\FacetWP as FacetWP;
use Dispatch\Plugins\ACF as ACF;

require_once('autoloader.php');

define('DISPATCH_DOMAIN', 'dispatch');

/**
 * Provision
 */
new TGMpa;

if ( !class_exists('Timber') ) return;

/**
 * Timber
 */
new Site;
new Context;

/**
 * Config
 */
new Dashboard;
new Menus;
new CustomPostTypes;
new CustomTaxonomies;
new Theme;
new Media;
new General;
new FewBricks;

/**
 * Functions
 */
new Assets;
new Search;

/**
 * Plugins
 */
new YoastSEO;
new GForms;
new FacetWP;
new ACF;
