<?php

declare(strict_types=1);

namespace App\Models;

/**
 * @property int $id
 * @property string $tipo
 * @property float $valor
 * @property string|null $descricao
 * @property string $data_lancamento
 */
class TbLancamento extends BaseModel
{
    public static $table_name = 'tb_lancamentos';
}
