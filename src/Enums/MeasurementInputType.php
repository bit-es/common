<?php

namespace Bites\Common\Enums;

enum MeasurementInputType: string
{
    case ToggleButtons = 'ToggleButtons';
    case TextInput = 'TextInput';
    case DatePicker = 'DatePicker';
    case TimePicker = 'TimePicker';
    case DateTimePicker = 'DateTimePicker';
    case Select = 'Select';
    case ColorPicker = 'ColorPicker';
    case Slider = 'Slider';
    case ScanCode = 'ScanCode';
}
