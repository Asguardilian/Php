<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Alteramos para true, pois a autorização deve ser verificada
        // em um nível superior (ex: no Controller ou via Gates/Policies)
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 1. Validação do ID do Cliente (Deve existir na tabela 'customers')
            'customer_id' => [
                'required', 
                'integer', 
                'exists:customers,id'
            ],

            // 2. Validação da lista de Itens do Pedido (Deve ser um array e obrigatório)
            'order_items' => [
                'required', 
                'array', 
                'min:1' // Garante que há pelo menos um item no pedido
            ],

            // 3. Validação do ID do Produto em cada item
            'order_items.*.product_id' => [
                'required', 
                'integer', 
                'exists:products,id'
            ],

            // 4. Validação da Quantidade em cada item
            'order_items.*.quantity' => [
                'required', 
                'integer', 
                'min:1'
            ],

            // 5. Validação do status (Obrigatório e deve ser uma string)
            // Em projetos mais robustos, usaríamos 'in:pendente,pago,cancelado'
            'status' => [
                'required', 
                'string'
            ],
        ];
    }
    
    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        // Nomes customizados para os campos na mensagem de erro
        return [
            'customer_id' => 'Cliente',
            'order_items' => 'Itens do Pedido',
            'order_items.*.product_id' => 'ID do Produto',
            'order_items.*.quantity' => 'Quantidade',
            'status' => 'Status do Pedido',
        ];
    }

}