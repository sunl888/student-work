<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 16:14
 */

namespace App\Transformers;

use App\Service\ValidatePermission;
use League\Fractal\TransformerAbstract;

class Transformer extends TransformerAbstract
{
    use ValidatePermission;
}