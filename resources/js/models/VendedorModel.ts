import IVendedor from "../models/interfaces/IVendedor";

export default class VendedorModel implements IVendedor {
    comissao: number;
    created_at: string;
    email: string;
    id: number;
    nome: string;
    updated_at: string;
}
