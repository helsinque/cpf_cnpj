<?php

namespace Validators;

/**
 * Interface ValidatorsInterface.
 *
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com">
 */
interface ValidatorsInterface
{
	/**
     * Validate method.
     *
     * @param string $value
     */
	public function validate($value);
}