/**
 * inspired on:
 * @see https://github.com/vanilla-masker/vanilla-masker
 */

import Utils from './Utils';
import InputMasker from './InputMasker';

let Masker = function(el) {
    if (!el) {
        throw new Error("Masker: There is no element to bind.");
    }
    let elements = ("length" in el) ? (el.length ? el : []) : [el];
    return new InputMasker(elements);
};

Masker.toNumber = function(value, opts) {
    opts = Utils.mergeNumberOptions(opts);
    if (typeof value === 'number') {
        let multiplier = Math.pow(10, opts.precision);
        value = Math.floor(value * multiplier) / multiplier;
    }
    value = String(value);
    if (opts.allowEmpty && value === "") {
        return "";
    }
    if (opts.zeroCents) {
        opts.lastOutput = opts.lastOutput || "";
        let zeroMatcher = ("("+ opts.separator +"[0]{0,"+ opts.precision +"})");
        let zeroRegExp = new RegExp(zeroMatcher, "g");
        let digitsLength = value.toString().replace(/\D/g, "").length || 0;
        let lastDigitLength = opts.lastOutput.toString().replace(/\D/g, "").length || 0;

        value = value.toString().replace(zeroRegExp, "");
        if (digitsLength < lastDigitLength) {
            value = value.slice(0, value.length - 1);
        }
    }
    let number = value.toString();
    // if separator is in string, make sure we zero-pad to respect it
    let separatorIndex = number.indexOf(opts.separator);
    let missingZeros = (opts.precision - (number.length - separatorIndex - 1));

    if (separatorIndex !== -1 && (missingZeros > 0) ) {
        number = number + ('0' * missingZeros);
    }

    number = number.replace(/\D/g, "");

    let clearDelimiter = new RegExp("^(0|\\"+ opts.delimiter +")")
    let clearSeparator = new RegExp("(\\"+ opts.separator +")$")
    let money = number.substring(0, number.length - opts.moneyPrecision)
    let masked = money.substring(0, money.length % 3)
    let cents = new Array(opts.precision + 1).join("0");

    money = money.substring(money.length % 3, money.length);
    for (let i = 0, len = money.length; i < len; i++) {
        if (i % 3 === 0) {
            masked += opts.delimiter;
        }
        masked += money[i];
    }
    masked = masked.replace(clearDelimiter, "");
    masked = masked.length ? masked : "0";
    let signal = "";
    if(opts.showSignal === true) {
        signal = value < 0 || (value.startsWith && value.startsWith('-')) ? "-" :  "";
    }
    if (!opts.zeroCents) {
        let beginCents = Math.max(0, number.length - opts.precision);
        let centsValue = number.substring(beginCents, beginCents + opts.precision);
        let centsLength = centsValue.length;
        let centsSliced = (opts.precision > centsLength) ? opts.precision : centsLength;

        cents = (cents + centsValue).slice(-centsSliced);
    }
    let output = opts.unit + signal + masked + opts.separator + cents;
    return output.replace(clearSeparator, "") + opts.suffixUnit;
};

Masker.toPattern = function(value, opts) {
    let pattern = (typeof opts === 'object' && !Array.isArray(opts) ? opts.pattern : opts);
    if (Array.isArray(pattern)) {
        if (pattern.length === 0) {
            return value;
        }
        if (pattern.length === 1) {
            pattern = pattern.splice(0, 1)[0];
        } else {
            pattern.sort(function(a, b){
                return a.length - b.length;
            });
            let newPattern = undefined;
            pattern.forEach(function(p) {
                if (value.length <= p.replaceAll(/[^A|9|S]/g, '').length) {
                    newPattern = newPattern || p;
                }
            })
            if (newPattern === undefined) {
                newPattern = pattern.slice(-1)[0] ;
            }
            pattern = newPattern;
        }
    }

    let patternChars = pattern.replace(/\W/g, '');
    let output = pattern.split("");
    let values = value.toString().replace(/\W/g, "");
    let charsValues = values.replace(/\W/g, '');
    let index = 0;
    let i;
    let outputLength = output.length;
    let placeholder = (typeof opts === 'object' ? opts.placeholder : undefined);
    for (i = 0; i < outputLength; i++) {
        // Reached the end of input
        if (index >= values.length) {
            if (patternChars.length === charsValues.length) {
                return output.join("");
            }
            else if ((placeholder !== undefined) && (patternChars.length > charsValues.length)) {
                return Utils.addPlaceholdersToOutput(output, i, placeholder).join("");
            }
            else {
                break;
            }
        }
        // Remaining chars in input
        else{
            if ((output[i] === Utils.DIGIT && values[index].match(/[0-9]/)) ||
                (output[i] === Utils.ALPHA && values[index].match(/[a-zA-Z]/)) ||
                (output[i] === Utils.ALPHA_NUM && values[index].match(/[0-9a-zA-Z]/))) {
                output[i] = values[index++];
            } else if (output[i] === Utils.DIGIT || output[i] === Utils.ALPHA || output[i] === Utils.ALPHA_NUM) {
                if(placeholder !== undefined){
                    return Utils.addPlaceholdersToOutput(output, i, placeholder).join("");
                }
                else{
                    return output.slice(0, i).join("");
                }
                // exact match for a non-magic character
            } else if (output[i] === values[index]) {
                index++;
            }

        }
    }
    return output.join("").substring(0, i);
};

Masker.toInteger = function(value) {
    return value.toString().replace(/(?!^-)[^0-9]/g, "");
};

Masker.toAlphaNumeric = function(value) {
    return value.toString().replace(/[^a-z0-9 ]+/i, "");
};

Masker.toDocument = function (value) {
    value = value.toString().replace(/(?!^-)[^0-9]/g, "");
  return Masker.toPattern(value, ['999.999.999-99', '99.999.999/9999-99']);
};

Masker.toCpf = function (value) {
    value = value.toString().replace(/(?!^-)[^0-9]/g, "");
  return Masker.toPattern(value, '999.999.999-99');
};

Masker.toCnpj = function (value) {
    value = value.toString().replace(/(?!^-)[^0-9]/g, "");
  return Masker.toPattern(value, '99.999.999/9999-99');
};

Masker.toZip = function (value) {
    value = value.toString().replace(/(?!^-)[^0-9]/g, "");
  return Masker.toPattern(value, '99.999-999');
};

Masker.toPhone = function (value) {
    value = value.toString().replace(/(?!^-)[^0-9]/g, "");
  return Masker.toPattern(value, '(99) 9999-9999');
};

Masker.toCellphone = function (value) {
    value = value.toString().replace(/(?!^-)[^0-9]/g, "");
  return Masker.toPattern(value, '(99) 9 9999-9999');
};

Masker.toNationalPhone = function (value) {
    value = value.toString().replace(/(?!^-)[^0-9]/g, "");
  return Masker.toPattern(value, '9999 999 9999');
};

Masker.toGenericPhone = function (value) {
    value = value.toString().replace(/(?!^-)[^0-9]/g, "");
    if (value.length <= 3) {
        return Masker.toPattern(value, '999');
    }
    else if (value.length <= 4) {
        return Masker.toPattern(value, '9999');
    }
    else if (['0300', '0500', '0800', '0900'].includes(value.slice(0, 4))) {
        return Masker.toPattern(value, '9999 999 9999');
    }
    else if (value.length <= 10) {
        return Masker.toPattern(value, '(99) 9999-9999');
    }
    else {
        return Masker.toPattern(value, '(99) 9 9999-9999');
    }
};

Masker.toPercentage = function (value, opts) {
    opts = opts || {};
    opts = {
        suffixUnit: '%',
    };
    value = value.toString().replace(/(?!^-)[^0-9]/g, "");
    return Masker.toNumber(value, opts);
};

export default Masker;
