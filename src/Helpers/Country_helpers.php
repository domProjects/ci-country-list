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
    function countryDropdown($name, $options = '', $select = '')
    {
        if (! function_exists('form_dropdown'))
        {
            helper('form');
        }

        $countryList = lang('Country.list');
        $selectValue = empty($select) ? 'null' : $select;

        return form_dropdown($name, ['' => 'Select a country'] + $countryList, $selectValue, $options);
    }
}
