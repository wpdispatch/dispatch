<?php

namespace Dispatch\Taxonomies;

use Timber\Timber;
use Timber\Term as TimberTerm;

class Term extends TimberTerm {

    protected static $this_taxonomy = 'category';

    public static function this_taxonomy() {
        return static::$this_taxonomy;
    }

}
