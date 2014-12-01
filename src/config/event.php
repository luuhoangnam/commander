<?php

/**
 * --------------------------------------------------------------------------
 * Description
 * --------------------------------------------------------------------------
 *
 * @author Nam Hoang Luu <nam@mbearvn.com>
 */

return [
    'listeners' => [
        'Nam.Core.Events.*' => [
            'Nam\Core\Commands\Listeners\VarDumpNotifier',
        ],
    ],
];
