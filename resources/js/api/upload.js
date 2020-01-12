import Request from '../utilis/request';
export function upload(data, path) {
    return Request({
        url:base_url+'/upload/'+path,
        method:'post',
        data: data
    })
}
