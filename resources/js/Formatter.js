
export default {
    datetime: function (datetime) {
        return new Date(datetime).toLocaleString();
    },
    date: function (date) {
        return new Date(date).toLocaleDateString();
    },
    integer: function (integer) {
        return new Intl.NumberFormat(navigator.language, {maximumFractionDigits: 0}).format(integer);
    },
    float: function (float) {
        return new Intl.NumberFormat(navigator.language, {maximumFractionDigits: 2}).format(float);
    }
}
