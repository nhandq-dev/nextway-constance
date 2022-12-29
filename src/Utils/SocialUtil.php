<?php

namespace App\Utils;

class SocialUtil
{
  const ACTIVE = true;
  const DEACTIVE = false;

  const TYPE_TEAM = 1;
  const TYPE_COMMUNITY = 2;

  const TYPE_TEAM_TEXT = 'Team';
  const TYPE_COMMUNITY_TEXT = 'Community';

  const SOCIAL_TYPE_MAPPING = [
    self::TYPE_TEAM => self::TYPE_TEAM_TEXT,
    self::TYPE_COMMUNITY => self::TYPE_COMMUNITY_TEXT,
  ];
}
