<?php

namespace Services;

class Operations {
    
    public function limitString(string $limit, string $text) : string
    {
        if (strlen($text) <= $limit) {
            return $text;
        }
	$return = substr($text, 0, $limit);
	if (strpos($text, ' ') === false) {
            return $return . '...';
        }
	return preg_replace('/\w+$/', '', $return) . '...';
    }
}
