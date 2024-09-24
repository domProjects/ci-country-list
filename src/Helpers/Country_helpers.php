<?php

if (! function_exists('countryIsoToName'))
{
    function countryIsoToName(string $iso, string $list = 'Country.list')
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
