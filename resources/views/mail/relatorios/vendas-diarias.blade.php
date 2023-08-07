<x-mail::message>
    Valor de vendas ({{ now()->format('d/m/Y') }}): {{ 'R$ ' . number_format($relatorioDiario->valorVendas, 2, ',', '.') }}
</x-mail::message>
