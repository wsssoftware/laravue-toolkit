const DIGIT = '9';
const ALPHA = 'A';
const ALPHA_NUM = 'S';
const BY_PASS_KEYS = [9, 16, 17, 18, 36, 37, 38, 39, 40, 91, 92, 93];
const isAllowedKeyCode = function (keyCode) {
    for (let i = 0, len = BY_PASS_KEYS.length; i < len; i++) {
        if (keyCode === BY_PASS_KEYS[i]) {
            return false;
        }
    }
    return true;
};
const mergeNumberOptions = function (opts) {
    opts = opts || {};
    opts = {
        allowEmpty: opts.allowEmpty,
        delimiter: opts.delimiter || ".",
        lastOutput: opts.lastOutput,
        precision: opts.hasOwnProperty("precision") ? opts.precision : 2,
        separator: opts.separator || ",",
        showSignal: opts.showSignal,
        suffixUnit: opts.suffixUnit && (" " + opts.suffixUnit.replace(/\s/g, '')) || "",
        unit: opts.unit && (opts.unit.replace(/\s/g, '') + " ") || "",
        zeroCents: opts.zeroCents
    };
    opts.moneyPrecision = opts.zeroCents ? 0 : opts.precision;
    return opts;
};
const addPlaceholdersToOutput = function (output, index, placeholder) {
    for (; index < output.length; index++) {
        if (output[index] === DIGIT || output[index] === ALPHA || output[index] === ALPHA_NUM) {
            output[index] = placeholder;
        }
    }
    return output;
};

export default {
    DIGIT: DIGIT,
    ALPHA: ALPHA,
    ALPHA_NUM: ALPHA_NUM,
    BY_PASS_KEYS: BY_PASS_KEYS,
    isAllowedKeyCode: isAllowedKeyCode,
    mergeNumberOptions: mergeNumberOptions,
    addPlaceholdersToOutput: addPlaceholdersToOutput,
};
