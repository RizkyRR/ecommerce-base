<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function validation_errors($prefix = '', $suffix = '')
{
  if (FALSE === ($OBJ = &_get_validation_object())) {
    return '';
  }

  return $OBJ->error_string($prefix, $suffix);
}
