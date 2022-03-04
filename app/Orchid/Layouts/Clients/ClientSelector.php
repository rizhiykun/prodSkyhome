<?php

namespace App\Orchid\Layouts\Clients;

use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Listener;

class ClientSelector extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncEsimatesdata';

    /**
     * @return Layout[]
     */
    protected function layouts(): array
    {
        return [];
    }
}
