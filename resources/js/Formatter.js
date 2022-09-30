
export default {
    currency: function (value, currency = 'USD') {
        let currencyFormatter = Intl.NumberFormat(navigator.language, {
            style: "currency",
            currency: currency,
        });
        return currencyFormatter.format(value);
    },
    datetime: function (datetime) {
        if (datetime === null || datetime === undefined) {
            return '';
        }
        return new Date(datetime).toLocaleString();
    },
    date: function (date) {
        if (date === null || date === undefined) {
            return '';
        }
        return new Date(date).toLocaleDateString();
    },
    integer: function (integer) {
        return new Intl.NumberFormat(navigator.language, {maximumFractionDigits: 0}).format(integer);
    },
    float: function (float) {
        return new Intl.NumberFormat(navigator.language, {maximumFractionDigits: 2}).format(float);
    }
}
