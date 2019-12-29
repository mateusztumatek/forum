import Request from '../utilis/request';
export function login(data) {
    return Request({
        url:base_url+'/login',
        method:'post',
        data: data,
    })
}
export function register(data) {
    return Request({
        url:base_url+'/register',
        method:'post',
        data: data,
    })
}
export function updateUser(user_id, data) {
    return Request({
        url: base_url+'/user/'+user_id+'/update',
        data: data,
        method: 'post'
    })
}

