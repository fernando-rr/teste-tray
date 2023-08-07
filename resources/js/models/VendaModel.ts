import IVenda from "../services/interfaces/IVenda";
import VendedorModel from "./VendedorModel";

export default class VendaModel implements IVenda {
    comissao: number;
    created_at: string;
    email: string;
    id: number;
    nome: string;
    updated_at: string;
    valor: number;
    vendedor: VendedorModel;
}
