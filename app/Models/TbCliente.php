<?php

declare(strict_types=1);

namespace App\Models;

/**
 * @property int $id
 * @property string $nome
 * @property string|null $email
 * @property string|null $telefone
 */
class TbCliente extends BaseModel
{
    public static $table_name = 'tb_clientes';
    public static $has_many = [
        ['anamneses', 'class_name' => TbAnamnese::class, 'foreign_key' => 'cliente_id'],
        ['atendimentos', 'class_name' => TbAtendimento::class, 'foreign_key' => 'cliente_id'],
    ];
}
