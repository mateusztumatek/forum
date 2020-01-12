import Request from '../utilis/request';
export function getTags() {
    return Request({
        url:base_url+'/tags',
        method:'get',
    })
}
