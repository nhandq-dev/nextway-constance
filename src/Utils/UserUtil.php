<?php

namespace App\Utils;

class UserUtil
{
  const USER_ACTIVE = 'Active';
  const USER_INACTIVE = 'Inactive';

  const ACTIVE = 1;
  const INACTIVE = 0;

  const USER_STATUS_MAPPING = [
    self::INACTIVE => self::USER_INACTIVE,
    self::ACTIVE => self::USER_ACTIVE,
  ];

  // Role
  const ROLE_ADMIN = 'ROLE_ADMIN';
  const ROLE_USER = 'ROLE_USER';
  const ROLE_ADMIN_TITLE = 'Admin User';
  const ROLE_USER_TITLE = 'User';

  const ROLE_TITLE_MAPPING = [
    self::ROLE_ADMIN => self::ROLE_ADMIN_TITLE,
    self::ROLE_USER => self::ROLE_USER_TITLE,
  ];

  public static function isAdminRole($user)
  {
    return $user->getRoleId() === self::ROLE_ADMIN;
  }

  public static function isUserRole($user)
  {
    return $user->getRoleId() === self::ROLE_USER;
  }

  const ADMIN_DEFAULT_ROUTE = 'admin_dashboard_route';
}
