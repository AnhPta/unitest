<?php

namespace App\Repositories\Branches;

trait PresentationTrait
{
	/**
	 * [getStatus description]
	 * @return [type] [description]
	 */
    public function getStatus()
    {
        return self::DISPLAY_STATUS[$this->status ?? self::ENABLE];
    }

    /**
     * [getType description]
     * @return [type] [description]
     */
    public function getType()
    {
        return self::DISPLAY_BRANCH[$this->type ?? self::NOT_MAIN];
    }
}
