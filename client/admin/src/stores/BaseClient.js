import axios, { Axios } from 'axios';
import { API_URL } from "@/config";

export const BaseClient = axios.create({
    baseURL: API_URL,
    headers: {
        // 'Content-type': 'application/json',
        'Accept': 'application/json'
    }
});
  
BaseClient.interceptors.request.use(async (config) => {
    let user = localStorage.getItem('user');
    if (user !== null) {
        user = JSON.parse(user);
        const token = user.token;
        config.headers['Authorization'] = `Bearer ${token}`;
    }
  
    return config;
});

BaseClient.interceptors.response.use(response => {
    return response;
}, error => {
    if (error.response.status === 401) {
        window.location.href = '/#/login';
    } else if (error.response.status === 403) {
        alert(error.response.data.message);
    }

    error.response.data.data = {};

    return error.response;
});