import Request from '../utilis/request';
export function getPostComments(post_id, params) {
    return Request({
        url:base_url+'/comments/'+post_id,
        method:'get',
        params: params,
    })
}
export function addComment(data){
    return Request({
        url:base_url+'/comments',
        method:'post',
        data: data,
    })
}
export function updateComment(comment_id, data){
    return Request({
        url:base_url+'/comments/'+comment_id,
        method:'put',
        data: data,
    })
}
export function deleteComment(comment_id){
    return Request({
        url:base_url+'/comments/'+comment_id,
        method:'delete',
    })
}