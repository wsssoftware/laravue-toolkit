import IMask from "imask";
import MaskOptions from "./MaskOptions";


/**
 * This package uses IMaks library to create masks for input fields.
 * @link https://github.com/uNmAnNeR/imaskjs
 * @link https://imask.js.org/guide.html
 */
export default {
    document: function (el) {
        return IMask(el, MaskOptions.document());
    },
    cnpj: function (el) {
        return IMask(el, MaskOptions.cnpj());
    },
    cpf: function (el) {
        return IMask(el, MaskOptions.cpf());
    },
    zip: function (el) {
        return IMask(el, MaskOptions.zip());
    },
    generic_phone: function (el) {
        return IMask(el, MaskOptions.generic_phone());
    },
    national_phone: function (el) {
        return IMask(el, MaskOptions.national_phone());
    },
    phone: function (el) {
        return IMask(el, MaskOptions.phone());
    },
    cellphone: function (el) {
        return IMask(el, MaskOptions.cellphone());
    },
    currency: function (el) {
        return IMask(el, MaskOptions.currency());
    },
    number: function (el) {
        return IMask(el, MaskOptions.number());
    },
    percentage: function (el) {
        el.addEventListener("focusout", () => {
          el.value = el.value+"%";
        });
        return IMask(el, MaskOptions.number());
    },

}