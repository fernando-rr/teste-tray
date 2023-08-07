import BaseRestService from "./BaseRestService";
import IVenda from "../models/interfaces/IVenda";

export default class VendasService extends BaseRestService<IVenda>
{
    getPath() {
        return '/vendas';
    }
}
