<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $site_url
 * @property string $name
 * @property string $last_name
 * @property string $company_name
 * @property string $email
 * @property string $password
 */
class Company extends Model
{
    use HasFactory, HasApiTokens;
}
