<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function set_slug($text)
{
  // ganti bukan huruf atau angka dengan -
  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

  // trim 
  $text = trim($text, '-');

  // menterjemahkan
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // huruf kecil
  $text = strtolower($text);

  // hapus karakter yang tidak diperlukan
  $text = preg_replace('~[^-\w]+~', '', $text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}
