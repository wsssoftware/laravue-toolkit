/**
 * Inspired on:
 * @see https://github.com/dm4t2/vue-currency-input/blob/master/src/useCurrencyInput.ts
 */

import { NumberInput,  NumberInputOptions, NumberInputValue } from 'intl-number-input'
import { ComponentPublicInstance, computed, ComputedRef, getCurrentInstance, Ref, ref, watch } from 'vue'

const findInput = (el: HTMLElement | null) => (el?.matches('input') ? el : el?.querySelector('input')) as HTMLInputElement

export function useNumberInput(options: NumberInputOptions, autoEmit?: boolean) {
    let numberInput: NumberInput | null
    const inputRef: Ref<HTMLInputElement | ComponentPublicInstance | null> = ref(null)
    const formattedValue = ref<string | null>(null)
    const numberValue = ref<number | null>(null)

    const vm = getCurrentInstance()
    const emit = vm?.emit || vm?.proxy?.$emit?.bind(vm?.proxy)
    const props = (vm?.props || vm?.proxy?.$props) as Record<string, unknown>
    const lazyModel = (vm?.attrs.modelModifiers as Record<string, boolean>)?.lazy
    const modelValue: ComputedRef<number | null> = computed(() => props?.['modelValue'] as number)
    const inputEvent = 'update:modelValue'
    const changeEvent = lazyModel ? 'update:modelValue' : 'change'

    watch(inputRef, (value) => {
        if (value) {
            const el = findInput((value as ComponentPublicInstance)?.$el ?? value)
            if (el) {
                numberInput = new NumberInput({
                    el,
                    options,
                    onInput: (value: NumberInputValue) => {
                        if (!lazyModel && autoEmit !== false && modelValue.value !== value.number) {
                            emit?.(inputEvent, value.number)
                        }
                        numberValue.value = value.number
                        formattedValue.value = value.formatted
                    },
                    onChange: (value: NumberInputValue) => {
                        emit?.(changeEvent, value.number)
                    }
                })
                numberInput.setValue(modelValue.value)
            } else {
                console.error('No input element found. Please make sure that the "inputRef" template ref is properly assigned.')
            }
        } else {
            numberInput = null
        }
    })

    return {
        inputRef,
        numberValue,
        formattedValue,
        setValue: (value: number | null) => numberInput?.setValue(value),
        setOptions: (options: NumberInputOptions) => numberInput?.setOptions(options)
    }
}
