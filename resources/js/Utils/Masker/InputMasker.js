import Masker from "./Masker";
import Utils from "./Utils";


let InputMasker = function(elements) {
    this.elements = elements;
};

InputMasker.prototype.unbindElementToMask = function() {
    for (let i = 0, len = this.elements.length; i < len; i++) {
        this.elements[i].lastOutput = "";
        this.elements[i].onkeyup = false;
        this.elements[i].onkeydown = false;

        if (this.elements[i].value.length) {
            this.elements[i].value = this.elements[i].value.replace(/\D/g, '');
        }
    }
};

InputMasker.prototype.bindElementToMask = function(maskFunction) {
    let that = this,
        onType = function(e) {
            e = e || window.event;
            let source = e.target || e.srcElement;

            if (Utils.isAllowedKeyCode(e.keyCode)) {
                setTimeout(function() {
                    that.opts.lastOutput = source.lastOutput;
                    source.value = Masker[maskFunction](source.value, that.opts);
                    source.lastOutput = source.value;
                    if (source.setSelectionRange && that.opts.suffixUnit) {
                        source.setSelectionRange(source.value.length, (source.value.length - that.opts.suffixUnit.length));
                    }
                }, 0);
            }
        }
    ;
    for (let i = 0, len = this.elements.length; i < len; i++) {
        this.elements[i].lastOutput = "";
        this.elements[i].onkeyup = onType;
        if (this.elements[i].value.length) {
            this.elements[i].value = Masker[maskFunction](this.elements[i].value, this.opts);
        }
    }
};

InputMasker.prototype.maskNumber = function(opts) {
    this.opts = Utils.mergeNumberOptions(opts);
    this.bindElementToMask("toNumber");
};

InputMasker.prototype.maskInteger = function() {
    this.opts = {};
    this.bindElementToMask("toInteger");
};

InputMasker.prototype.maskAlphaNum = function() {
    this.opts = {};
    this.bindElementToMask("toAlphaNumeric");
};

InputMasker.prototype.maskPattern = function(pattern) {
    this.opts = {pattern: pattern};
    this.bindElementToMask("toPattern");
};

InputMasker.prototype.unMask = function() {
    this.unbindElementToMask();
};

InputMasker.prototype.maskDocument = function () {
    this.opts = {};
    this.bindElementToMask("toDocument");
}

InputMasker.prototype.maskCpf = function () {
    this.opts = {};
    this.bindElementToMask("toCpf");
}

InputMasker.prototype.maskCnpj = function () {
    this.opts = {};
    this.bindElementToMask("toCnpj");
}

InputMasker.prototype.maskZip = function () {
    this.opts = {};
    this.bindElementToMask("toZip");
}

InputMasker.prototype.maskPhone = function () {
    this.opts = {};
    this.bindElementToMask("toPhone");
}

InputMasker.prototype.maskCellphone = function () {
    this.opts = {};
    this.bindElementToMask("toCellphone");
}

InputMasker.prototype.maskNationalPhone = function () {
    this.opts = {};
    this.bindElementToMask("toNationalPhone");
}

InputMasker.prototype.maskGenericPhone = function () {
    this.opts = {};
    this.bindElementToMask("toGenericPhone");
}

InputMasker.prototype.maskPercentage = function () {
    this.opts = {};
    this.bindElementToMask("toPercentage");
}

export default InputMasker;
