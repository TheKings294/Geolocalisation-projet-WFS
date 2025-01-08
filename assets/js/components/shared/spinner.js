export const activeSpinner = () => {
    const spinner = document.querySelector('#spinner')
    spinner.classList.remove('d-none')
}
export const disabledSpinner = () => {
    const spinner = document.querySelector('#spinner')
    spinner.classList.add('d-none')
}