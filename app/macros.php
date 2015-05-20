<?php

Response::macro('xml', function(array $vars, $status = 200, array $header = [], $rootElement = 'Response', $xml = null)
{
    if (is_null($xml)) {
        $xml = new SimpleXMLElement('<'.$rootElement.'/>');
    }

    foreach ($vars as $key => $value) {
        if (is_array($value)) {
            Response::xml($value, $status, $header, $rootElement, $xml->addChild($key));
        } else {
            if( preg_match('/^@.+/', $key) ) {
                $attributeName = preg_replace('/^@/', '', $key);
                $xml->addAttribute($attributeName, $value);
            } else {
                $xml->addChild($key, $value);
            }
        }
    }

    if (empty($header)) {
        $header['Content-Type'] = 'text/xml';
    }

    return Response::make($xml->asXML(), $status, $header);
});
?>