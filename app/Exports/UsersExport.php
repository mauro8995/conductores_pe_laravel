<?php

namespace App\Exports;

use App\Models\External\User_office;
use Maatwebsite\Excel\Concerns\FromArray;

class UsersExport implements FromArray
{


  protected $user;
  public function __construct(array $user)
    {
        $this->user = $user;
    }

    public function array(): array
    {
        return $this->user;
    }
}
