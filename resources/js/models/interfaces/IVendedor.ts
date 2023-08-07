import IBaseModel from "./IBaseModel";
import IBaseModelTimestamps from "./IBaseModelTimestamps";

export default interface IVendedor extends IBaseModel, IBaseModelTimestamps {
    nome:     string;
    email:    string;
    comissao: number;
}
