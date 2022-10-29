import IMask from "imask";
import MaskOptions from "./MaskOptions";


/**
 * This package uses IMaks library to create masks for input fields.
 * @link https://github.com/uNmAnNeR/imaskjs
 * @link https://imask.js.org/guide.html
 */
export default {
    onlyDigits: function (payload) {
        if (typeof payload !== 'string') {
            payload = payload.toString();
        }
        return payload.replace(/\D/g, "");
    },
    document: function (document) {
        document = this.onlyDigits(document);
        return IMask.pipe(document, MaskOptions.document());
    },
    cnpj: function (cnpj) {
        cnpj = this.onlyDigits(cnpj);
        return IMask.pipe(cnpj, MaskOptions.cnpj());
    },
    cpf: function (cpf) {
        cpf = this.onlyDigits(cpf);
        return IMask.pipe(cpf, MaskOptions.cpf());
    },
    zip: function (zip) {
        zip = this.onlyDigits(zip);
        return IMask.pipe(zip, MaskOptions.zip());
    },
    generic_phone: function (phone) {
        phone = this.onlyDigits(phone);
        return IMask.pipe(phone, MaskOptions.generic_phone());
    },
    national_phone: function (phone) {
        phone = this.onlyDigits(phone);
        return IMask.pipe(phone, MaskOptions.national_phone());
    },
    phone: function (phone) {
        phone = this.onlyDigits(phone);
        return IMask.pipe(phone, MaskOptions.phone());
    },
    cellphone: function (cellphone) {
        cellphone = this.onlyDigits(cellphone);
        return IMask.pipe(cellphone, MaskOptions.cellphone());
    },
    currency: function (number) {
        return IMask.pipe(number, MaskOptions.currency());
    },
    number: function (number) {
        return IMask.pipe(number, MaskOptions.number());
    },
    percentage: function (number) {
        return IMask.pipe(number, MaskOptions.number())+"%";
    },

}