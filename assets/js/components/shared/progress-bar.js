export const updateProgressBar = (value) => {
    const progressBarElement = document.querySelector('.progress')
    const progressBar = progressBarElement.querySelector('.progress-bar')

    progressBar.style.width = `${value}%`
    progressBar.innerHTML = `${value}%`
    progressBarElement.setAttribute('aria-valuenow', value)
}