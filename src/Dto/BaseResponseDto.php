<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class BaseResponseDto
{
  #[Assert\NotBlank()]
  #[Assert\Collection(['code', 'message'])]
  public $status;
}
