
/**
 * This package uses IMaks library to create masks for input fields.
 * @link https://github.com/uNmAnNeR/imaskjs
 * @link https://imask.js.org/guide.html
 */
export default {
    document: function () {
        return {
            mask: [
                {mask: '000.000.000-00'},
                {mask: '00.000.000/0000-00'},
                {mask: '000.000.000/0000-00'}
            ],
        };
    },
    cnpj: function () {
        return {
            mask: [
                {mask: '00.000.000/0000-00'},
                {mask: '000.000.000/0000-00'}
            ],
        };
    },
    cpf: function () {
        return {
            mask: '000.000.000-00'
        };
    },
    zip: function () {
        return {
            mask: '00.000-000'
        };
    },
    generic_phone: function () {
        return {
            mask: [
                {
                    index: 1,
                    mask: '000'
                },
                {
                    index: 1,
                    mask: '0000'
                },
                {
                    index: 3,
                    mask: '0000 000 0000'
                },
                {
                    index: 4,
                    mask: '(00) 0000-0000'
                },
                {
                    index: 5,
                    mask: '(00) {9} 0000-0000',
                },
            ],
            dispatch: function (appended, dynamicMasked) {
                let number = (dynamicMasked.value + appended).replace(/\D/g, '');
                let size = number.length;
                return dynamicMasked.compiledMasks.find((m) => {
                    if (size === 3 && m.index === 1) {
                        return true;
                    }
                    if (size === 4 && m.index === 2) {
                        return true;
                    }
                    if (['0300', '0500', '0800', '0900'].includes(number.slice(0, 4)) && m.index === 3) {
                        return true;
                    }
                    if (size <= 10 && m.index === 4) {
                        return true;
                    }
                    if (size > 10 && m.index === 5) {
                        return true;
                    }
                });
            }
        };
    },
    national_phone: function () {
        return {
            mask: '0000 000 0000'
        };
    },
    phone: function () {
        return {
            mask: '(00) 0000-0000'
        };
    },
    cellphone: function () {
        return {
            mask: '(00) {9} 0000-0000',
        };
    },
    currency: function () {
        return {
            mask: 'SYMBOLNUMBER',
            blocks: {
                SYMBOL: {
                    mask: '{R$}'
                },
                NUMBER: {
                    mask: Number,
                    scale: 2,  // digits after point, 0 for integers
                    signed: true,  // disallow negative
                    thousandsSeparator: '.',  // any single char
                    padFractionalZeros: true,  // if true, then pads zeros at end to the length of scale
                    normalizeZeros: true,  // appends or removes zeros at ends
                    radix: ',',  // fractional delimiter
                    mapToRadix: ['.'],  // symbols to process as radix
                }
            }
        };
    },
    number: function () {
        return {
            mask: Number,
            scale: 2,  // digits after point, 0 for integers
            signed: true,  // disallow negative
            thousandsSeparator: '.',  // any single char
            padFractionalZeros: true,  // if true, then pads zeros at end to the length of scale
            normalizeZeros: true,  // appends or removes zeros at ends
            radix: ',',  // fractional delimiter
            mapToRadix: ['.'],  // symbols to process as radix
        };
    },

}
