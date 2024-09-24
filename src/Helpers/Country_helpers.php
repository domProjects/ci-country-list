<?php

if (! function_exists('countryIsoToName'))
{
    /**
     * @param string    $iso    code ISO
     */
    function countryIsoToName(string $iso): string
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
    /**
     * @source https://codeigniter.com/user_guide/helpers/form_helper.html#form_dropdown
     *
     * @param string        $name     Field name
     * @param array|string  $extra    Extra attributes to be added to the tag either as an array or a literal string
     * @param array|string  $selected List of fields to mark with the selected attribute
     */
    function countryDropdown(string $name, $extra = '', $selected = ''): string
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
