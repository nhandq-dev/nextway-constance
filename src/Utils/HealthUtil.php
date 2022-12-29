<?php

namespace App\Utils;

class HealthUtil
{
  const HEALTH_EXCELLENT = 'Excellent';
  const HEALTH_GOOD = 'Good';
  const HEALTH_FAIR = 'Fair';
  const HEALTH_POOR = 'Poor';

  const HEALTH_EXCELLENT_POINT = 4;
  const HEALTH_GOOD_POINT = 3;
  const HEALTH_FAIR_POINT = 2;
  const HEALTH_POOR_POINT = 1;

  const HEALTH_STATUS_MAPPING = [
    self::HEALTH_EXCELLENT_POINT => self::HEALTH_EXCELLENT,
    self::HEALTH_GOOD_POINT => self::HEALTH_GOOD,
    self::HEALTH_FAIR_POINT => self::HEALTH_FAIR,
    self::HEALTH_POOR_POINT => self::HEALTH_POOR,
  ];
}
