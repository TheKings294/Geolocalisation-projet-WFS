export const toast = (text, level) => {
    const ToastElement = document.getElementById('mytoast')
    const toast = new bootstrap.Toast(ToastElement)

    document.querySelector('.toast').classList.remove('text-bg-success')
    document.querySelector('.toast').classList.add(level)
    document.querySelector('.toast-body').innerHTML = text
    toast.show()
}