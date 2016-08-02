<?php

namespace App\Core\Helpers;

class Calendar
{
    protected static $includedHeadData = false;

    public static function render($name, $value = '')
    {
        self::includeHeadData();
        if (empty($value) || $value == '0000-00-00' || $value == '0000-00-00 00:00:00') {
            $showValue = '';
            $value = '';
        } else {
            $showValue = date('d/m/Y', strtotime($value));
        }
        ?>
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <input type="text" class="form-control pull-right date" value="<?php echo $showValue; ?>">
            <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
        </div>
        <?php
    }

    public static function includeHeadData()
    {
        if (self::$includedHeadData) {
            return;
        }
        $head = Head::getInstance();
        $head->appendStyle('/assets/plugins/datepicker/datepicker3.css');
        $head->appendScript('/assets/plugins/datepicker/bootstrap-datepicker.js');
        //$head->appendMainScript('/assets/plugins/timepicker/bootstrap-timepicker.min.js');
        $head->appendScript('/core/js/calendar.js');
        self::$includedHeadData = true;
    }
}