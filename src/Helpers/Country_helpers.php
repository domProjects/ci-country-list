<?php

if (! function_exists('countryIsoCodeToName'))
{
    function countryIsoCodeToName(string $iso, string $list = 'Country.list')
    {
        $isoTransform = strtoupper($iso);
        $countryList = lang($list);

        if (array_key_exists($isoTransform, $countryList))
        {
            return $countryList[$isoTransform];
        }
        else
        {
            return $iso;
        }
    }
}
