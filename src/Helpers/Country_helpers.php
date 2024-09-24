<?php

if (! function_exists('countryIsoCodeToName'))
{
    function countryIsoCodeToName($iso)
    {
        $isoTransform = strtoupper($iso);
        $countryList = lang('Country');

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
