export default function (form) {
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
}
