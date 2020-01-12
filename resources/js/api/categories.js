import Request from '../utilis/request';
export function getCategories() {
    return Request({
        url:base_url+'/categories',
        method:'get',
    })
}
