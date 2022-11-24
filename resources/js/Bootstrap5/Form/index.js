export {default as ActionButtons} from './ActionButtons.vue'
export {default as CheckboxDefault} from './CheckboxDefault.vue'
export {default as DateDefault} from './DateDefault.vue'
export {default as DatetimeDefault} from './DatetimeDefault.vue'
export {default as InputDefault} from './InputDefault.vue'
export {default as SelectDefault} from './SelectDefault.vue'
export {default as SmartSelect} from './SmartSelect.vue'
export {default as TextareaDefault} from './TextareaDefault.vue'
export {default as TimeDefault} from './TimeDefault.vue'
export {default as ToggleButton} from './ToggleButton.vue'


export const addInertiaFormEvent = function (form) {
    if (form.hasChanged) {
        return
    }
    form.oldSubmit = form.submit;
    form.submit = (method, url, options) => {
        let event = new Event('inertia-submit', {
            cancelable: true,
            detail: { form: form }
        });
        if (!document.dispatchEvent(event)) {
            return;
        }
        form.oldSubmit(method, url, options)
    }
    form.hasChanged = true;
    console.log('changed');
}
