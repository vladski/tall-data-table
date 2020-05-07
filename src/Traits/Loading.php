<?php

namespace Tanthammar\TallDataTable\Traits;

/**
 * Trait Loading.
 */
trait Loading
{
    /**
     * Loading.
     */

    /**
     * Whether or not to show a loading indicator when searching.
     *
     * @var bool
     */
    public $loadingIndicator = true;

    /**
     * The loading message that gets displayed.
     *
     * @var string
     */
    public $loadingMessage;
}
