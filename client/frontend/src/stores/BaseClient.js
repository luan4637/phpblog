import axios, { Axios } from 'axios';
import { API_URL } from "@/config";

export const BaseClient = axios.create({
    baseURL: API_URL,
    headers: {
        'Accept': 'application/json'
    }
});

/*
BaseClient.interceptors.request.use(async (config) => {
    const token = localStorage.getItem('token');
    if (token !== null && token !== 'requesting') {
        config.headers['Authorization'] = `Bearer ${token}`;
    } else {
        if (token === null) {
            axios.get(API_URL + '/login').then((response) => {
                if (response.data.status == 'success') {
                    localStorage.setItem('token', response.data.data.token);
                    window.location.reload()
                }
            });
        }

        localStorage.setItem('token', 'requesting');
    }

    return config;
});
*/
