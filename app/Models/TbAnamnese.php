<?php

declare(strict_types=1);

namespace App\Models;

/**
 * @property int $id
 * @property int $cliente_id
 * @property string $descricao
 */
class TbAnamnese extends BaseModel
{
    public static $table_name = 'tb_anamneses';
    public static $belongs_to = [
        ['cliente', 'class_name' => TbCliente::class, 'foreign_key' => 'cliente_id'],
    ];
}
