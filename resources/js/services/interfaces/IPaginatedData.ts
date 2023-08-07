import IBaseModel from "./IBaseModel";

export default interface IPaginatedData <T extends IBaseModel> {
    current_page: number;
    last_page:    number;
    per_page:     number;
    total:        number;
    data:         Array<T>;
}
