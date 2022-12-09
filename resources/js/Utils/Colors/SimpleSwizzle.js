'use strict';

const isArrayish = function isArrayish(obj) {
    if (!obj || typeof obj === 'string') {
        return false;
    }

    return obj instanceof Array || Array.isArray(obj) ||
        (obj.length >= 0 && (obj.splice instanceof Function ||
            (Object.getOwnPropertyDescriptor(obj, (obj.length - 1)) && obj.constructor.name !== 'String')));
};

let concat = Array.prototype.concat;
let slice = Array.prototype.slice;

let swizzle = function swizzle(args) {
    let results = [];

    for (let i = 0, len = args.length; i < len; i++) {
        let arg = args[i];

        if (isArrayish(arg)) {
            // http://jsperf.com/javascript-array-concat-vs-push/98
            results = concat.call(results, slice.call(arg));
        } else {
            results.push(arg);
        }
    }

    return results;
};

swizzle.wrap = function (fn) {
    return function () {
        return fn(swizzle(arguments));
    };
};

export default swizzle;
