<?php

namespace App\Utils;

class DatetimeUtil
{
  const MINUTE = 'm';
  const HOUR = 'h';
  const SECONDS = 's';

  const STANDARD_TIMEZONE = 'Asia/Dubai';
  const STANDARD_TIMEZONE_TEXT = '(GMT+4:00) Abu Dhabi, Muscat (Gulf Standard Time)';
  const DATE_FORMAT = 'd/m/Y';
  const DATETIME_FORMAT = 'd/m/Y h:i A';
  const YMD_TIME_FORMAT = 'Y-m-d H:i:s';
  const YMD_TIME_FORMAT_2 = 'Y-m-d H:i A';
  const MDY_TIME_FORMAT = 'm/d/Y H:i:s';
  const DMY_TIME_FORMAT = 'd/m/Y H:i:s';
  const GM_DATETIME_FORMAT = 'Y-m-d\TH:i:s\Z';
  const CLIENT_FORMAT_DATEPICKER = 'mm/dd/yyyy hh:ii';
  const DATE_FORMAT_DATEPICKER = 'm/d/y';
  const CLIENT_TRANSFORM_DATEPICKER = 'm/d/Y H:i';
  const FULL_DATETIME_FORMAT = 'd M Y H:i:s A';
  const DAY_MONTH_FORMAT = 'd M';
  const MONTH_DAY_FORMAT = 'M d';
  const MONTH_YEAR_FORMAT = 'M Y';
  const MDY_FORMAT = 'm/d/Y';

  const YMD_FORMAT = 'Y-m-d';
  const TIME_FORMAT = 'h:i A';
  const HOUR_MINUTE_FORMAT = 'h:i';
  const TIME_FORMAT_24H = 'H:i';
  const MYSQL_FORMAT = 'Y-m-d H:i:s';

  const INVOICE_DATE_FORMAT = 'F d, Y';

  const TIME_START_OF_DAY = '00:00:00';
  const TIME_END_OF_DAY = '23:59:59';
  const ONE_HOUR_SECONDS = 3600;
  const ONE_DAY_MINUTES = 1440;
  const ONE_DAY_SECONDS = 86400;
  const ONE_YEAR_SECONDS = self::ONE_DAY_SECONDS * 356;

  const DAY_IN_WEEK = [1 => 'monday', 2 => 'tuesday', 3 => 'wednesday', 4 => 'thursday', 5 => 'friday', 6 => 'saturday', 7 => 'sunday'];
  const CARBON_DAY_IN_WEEK = [0 => 'sunday', 1 => 'monday', 2 => 'tuesday', 3 => 'wednesday', 4 => 'thursday', 5 => 'friday', 6 => 'saturday'];

  const POSITION_MAPPING = [
    1 => 'first',
    2 => 'second',
    3 => 'third',
    4 => 'fourth',
    5 => 'fifth',
  ];

  public static function getTimeStampFromDatetime($strDate, $fromFormat = self::YMD_TIME_FORMAT, $convertToStartDate = false)
  {
    $date = \DateTime::createFromFormat($fromFormat, $strDate);

    if (empty($date)) {
      return '';
    }

    if ($convertToStartDate) {
      $date->modify('today');
    }

    return $date->getTimestamp();
  }
}
