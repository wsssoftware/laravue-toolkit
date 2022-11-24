
import { mask } from 'maska'
import recipes from './recipes'
import {genericPhoneChooser} from './recipes'

export default {
    cpf: (value) => mask(value, recipes.cpf),
    cnpj: (value) => mask(value, recipes.cnpj),
    document: (value) => {
        let document = value.length > 11 ? recipes.cnpj : recipes.cpf;
        return mask(value, document)
    },
    phone:  (value) => mask(value, recipes.phone),
    cellphone:  (value) => mask(value, recipes.simple_cellphone),
    national_phone:  (value) => mask(value,  recipes.simple_national_phone),
    emergency_phone:  (value) => mask(value, recipes.emergency_phone),
    utility_phone:  (value) => mask(value, recipes.utility_phone),
    generic_phone: (value) => mask(value, genericPhoneChooser(value)),
    cep: (value) => mask(value, recipes.cep),
}

