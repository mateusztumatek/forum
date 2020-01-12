import Request from '../utilis/request';
export function getRates(params) {
    return Request({
        url:base_url+'/rates',
        method:'get',
        params: params
    })
}
export function setRate(data) {
    return Request({
        url:base_url+'/rates',
        method:'post',
        data: data
    })
}
export function deleteRate(rate_id) {
    return Request({
        url:base_url+'/rates/'+rate_id,
        method:'delete',
    })
}