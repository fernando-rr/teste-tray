import IBaseModel from "./IBaseModel";
import IBaseModelTimestamps from "./IBaseModelTimestamps";
import IVendedor from "./IVendedor";

export default interface IVenda extends IBaseModel, IBaseModelTimestamps {
    nome:     string;
    email:    string;
    valor:    number;
    comissao: number;
    vendedor: IVendedor;
}
