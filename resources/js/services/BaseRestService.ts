import axios, { AxiosInstance, AxiosRequestConfig } from 'axios';
import IBaseModel from "../models/interfaces/IBaseModel";
import IPaginatedData from "./interfaces/IPaginatedData";

export default abstract class BaseRestService<T extends IBaseModel> {
    private readonly apiClient: AxiosInstance;

    constructor() {
        this.apiClient = axios.create({
            baseURL: 'http://localhost/api',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json'
            }
        });
    }

    /**
     * Retorna o caminho para o endpoint da API
     */
    protected abstract getPath(): string;

    /**
     * Busca todos os dados no sistema
     */
    public async get(params = {}): Promise<T[]> {
        const response = await this.apiClient.get<T[]>(this.getPath(), { params });
        return response.data;
    }

    /**
     * Busca os dados paginados
     */
    public async getPage(params = {}): Promise<IPaginatedData<T>> {
        const response = await this.apiClient.get<IPaginatedData<T>>(this.getPath(), { params });
        return response.data;
    }

    /**
     * Busca o registro pelo ID
     */
    public async find(id: number): Promise<T> {
        const response = await this.apiClient.get<T>(`${this.getPath()}${id}`);
        return response.data;
    }

    /**
     * Efetua o cadastro do registro
     */
    public async post(item: T): Promise<T> {
        const response = await this.apiClient.post<T>(this.getPath(), item);
        return response.data;
    }

    /**
     * Atualiza o registro
     */
    public async put(item: T): Promise<T> {
        const response = await this.apiClient.put<T>(`${this.getPath()}/${item.id}`, item);
        return response.data;
    }

    /**
     * Exclui o registro
     */
    public async delete(id: number): Promise<void> {
        const response = await this.apiClient.delete<void>(`${this.getPath()}/${id}`);
        return response.data;
    }
}
