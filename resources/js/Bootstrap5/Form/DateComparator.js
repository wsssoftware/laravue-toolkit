export default {
    comparisonFieldLabel: undefined,
    comparisonField: undefined,
    comparisonType: undefined,
    types: ['gt', 'gte', 'lt', 'lte'],
    validate(component, event) {
        this.types.every(type => {
            if (component[type]) {
                this.comparisonType = type;
                this.comparisonFieldLabel = component.comparisonFieldLabel ?? component.formDataName;
                this.comparisonField = component[type];
                return false;
            }
            return true;
        });
        if (!this.comparisonType) {
            return;
        }
        let contextValue = this.getTimestamp(component.form[component.formDataName]);
        let comparisonValue = this.getTimestamp(component.form[this.comparisonField]);
        if (contextValue === null || comparisonValue === null) {
            return;
        }

        component.form.clearErrors(component.formDataName)
        if (this.comparisonType === 'gt' && contextValue <= comparisonValue) {
            component.form.setError(
                component.formDataName,
                `O campo "${component.label}" deve ser maior que o campo "${this.comparisonFieldLabel}"`
            );
            event.preventDefault();
        }
        if (this.comparisonType === 'gte' && contextValue < comparisonValue) {
            component.form.setError(
                component.formDataName,
                `O campo "${component.label}" deve ser maior ou igual que o campo "${this.comparisonFieldLabel}"`
            );
            event.preventDefault();
        }
        if (this.comparisonType === 'lt' && contextValue >= comparisonValue) {
            component.form.setError(
                component.formDataName,
                `O campo "${component.label}" deve ser menor que o campo "${this.comparisonFieldLabel}"`
            );
            event.preventDefault();
        }
        if (this.comparisonType === 'lte' && contextValue > comparisonValue) {
            component.form.setError(
                component.formDataName,
                `O campo "${component.label}" deve ser menor ou igual que o campo "${this.comparisonFieldLabel}"`
            );
            event.preventDefault();
        }
    },
    getTimestamp: function (value) {
        if (value === null || value === undefined || value === '') {
            return null;
        }
        return value.replace(/\D/g, '');
    }
}
