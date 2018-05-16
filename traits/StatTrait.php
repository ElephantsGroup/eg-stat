<?php

/**
 *
 * @name : eg-stat
 * @Version 1.0.0
 * @Author : Jalal Jaberi
 *
 */

namespace elephantsGroup\stat\traits;

use elephantsGroup\base\EGController;
use elephantsGroup\stat\models\Stat;

trait StatTrait
{
    protected function log()
    {
		// this trait can only be used in EGController objects
		if ($this instanceof EGController)
			Stat::setView($this->module->id, $this->id, $this->action->id);
    }
}