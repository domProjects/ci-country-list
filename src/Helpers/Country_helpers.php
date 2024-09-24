<?php

if (! function_exists('countryIsoToName'))
{
    function countryIsoToName(string $iso)
    {
        $isoTransform = strtoupper($iso);
        $countryList = lang('Country.list');

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

if (! function_exists('countryDropdown'))
{
    /*
     * https://codeigniter.com/user_guide/helpers/form_helper.html#form_dropdown
     */
    function countryDropdown($name, $extra = '', $selected = '')
    {
        if (! function_exists('form_dropdown'))
        {
            helper('form');
        }

        $options = lang('Country.list');
        $selectedValue = empty($selected) ? 'null' : $selected;

        return form_dropdown($name, ['' => lang('Country.selectCountry')] + $options, $selectedValue, $extra);
    }
}
