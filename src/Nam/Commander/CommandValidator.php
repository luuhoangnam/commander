<?php

namespace Nam\Commander;

/**
 * Interface CommandValidator
 *
 * @author  Nam Hoang Luu <nam@mbearvn.com>
 * @package Nam\Commander
 *
 */
interface CommandValidator
{
    /**
     * @param $command
     *
     * @return mixed
     */
    public function validate($command);
}
