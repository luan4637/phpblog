import { defineStore } from "pinia";
import { ref } from "vue";
import { io } from "socket.io-client";
import { SOCKET_URL } from '@/config';

export const useSocketStore = defineStore('socketStore', {
    state: () => ({
        socket: ref({}),
    }),
    actions: {
        initSocket() {
            if (this.socket.id == undefined) {
                this.socket = io.connect(SOCKET_URL, {});
            }
        },
    },
});
