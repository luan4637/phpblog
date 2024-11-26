import moment from "moment";

export const formatDateMixin = {
    methods: {
        formatDate(dateString) {
            return moment(String(dateString)).format('YYYY-MM-DD hh:mm')
        }
    }
}