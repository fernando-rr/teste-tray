import BaseRestService from "./BaseRestService";
import IVendedor from "../models/interfaces/IVendedor";

export default class VendedoresService extends BaseRestService<IVendedor>
{
    protected getPath() {
        return '/vendedores';
    }
}
