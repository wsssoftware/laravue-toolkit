export default (el, binding) => {
    if (binding.value !== binding.oldValue) {
        let debounce = (fn, delay) => {
            let timeoutID = null
            return function () {
                clearTimeout(timeoutID)
                let args = arguments
                let that = this
                timeoutID = setTimeout(function () {
                    fn.apply(that, args)
                }, delay)
            }
        }

        el.oninput = debounce(function (evt) {
            el.dispatchEvent(new Event('change'))
        }, parseInt(binding.value) || 500)
    }
}
