import axios from 'axios';

// Create axios instance
const service = axios.create({
    baseURL: process.env.MIX_BASE_API,
    timeout: 10000, // Request timeout
    withCredentials: true
});

// Request intercepter
service.interceptors.request.use(
    config => {
        config.headers['is_ajax'] = true;
        return config;
    },
    error => {
        // Do something with request error
        Promise.reject(error);
    }
);

// response pre-processing
service.interceptors.response.use(
    response => {
        if(response.data && response.data.redirect_link) window.location.href = response.data.redirect_link;
        return response.data;
    },
    error => {


        return Promise.reject(error);
    },
);

export default service;
