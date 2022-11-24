
const cpf = '###.###.###-##';
const cnpj = '##.###.###/####-##';

const phone = '(##) ####-####';
const simple_cellphone = '(##) # ####-####';
const cellphone = {mask: '(##) N ####-####', tokens: {'N': { pattern: /(9)/}}};
const simple_national_phone = '#### ### ####';
const national_phone = {mask: 'ZNZZ ### ####', tokens: {'N': { pattern: /([3589])/},'Z': { pattern: /(0)/}}};
const emergency_phone = '###';
const utility_phone = '####';

const recipes = {
    cpf,
    cnpj,
    document: [cpf, cnpj],
    phone,
    simple_cellphone,
    cellphone,
    simple_national_phone,
    national_phone,
    emergency_phone,
    utility_phone,
    generic_phone: [emergency_phone, utility_phone, phone, cellphone, national_phone],
    cep: '##.###-###',
}

export default recipes;

export function genericPhoneChooser(value) {
    let number = value.replace(/\D/g, '');
    if (number.startsWith('0300') || number.startsWith('0500') || number.startsWith('0800') || number.startsWith('0900')) {
       return simple_national_phone;
    } else if (number.length === 3) {
        return emergency_phone;
    } else if (number.length === 4) {
        return utility_phone;
    } else if (number.length === 10) {
        return phone;
    } else {
        return simple_cellphone;
    }
}

export function inputGenericPhoneChooser(value) {
    let recipe;
    let number = value.replace(/\D/g, '');
    if (number.startsWith('0300') || number.startsWith('0500') || number.startsWith('0800') || number.startsWith('0900')) {
        recipe = recipes.simple_national_phone;
    } else if (
        number.substring(0, 1) !== '0' &&
        number.substring(2, 3) === '9' &&
        number.length > 4
    ) {
        recipe = recipes.simple_cellphone;
    } else {
        recipe = [recipes.phone, recipes.emergency_phone, recipes.utility_phone];
    }
    return recipe;
}
