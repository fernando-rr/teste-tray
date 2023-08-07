<?php

namespace App\Rules;

use App\Services\VendaService;

class CriarVendasMassaRule extends ArrayValidationRule
{
    protected function getRules(): array
    {
        return VendaService::getCreateRules();
    }
}
