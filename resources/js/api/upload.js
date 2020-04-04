import Request from '../utilis/request';
export function upload(data, path) {
    return Request({
        url:base_url+'/upload/'+path,
        method:'post',
        data: data
    })
}
export function getUploads(data) {
    return Request({
        url: base_url+'/admin/media/files',
        method: 'post',
        data: data
    })
}