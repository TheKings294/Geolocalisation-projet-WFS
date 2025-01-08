export const getUerInfo = async (id) => {
    const res = await fetch(`index.php?component=form-user&action=get&id=${id}`, {
        headers: {
            'X-Requested-Width': 'XMLHttpRequest'
        }
    })
    return res.json()
}
export const setUserInfo = async (id, form) => {
    const data = new FormData(form)
    const res = await fetch(`index.php?component=form-user&action=edit&id=${id}`, {
        headers: {
            'X-Requested-Width': 'XMLHttpRequest'
        },
        method: 'POST',
        body: data
    })
    return res.json()
}
export const setUser = async (form) => {
    const data = new FormData(form)
    const res = await fetch(`index.php?component=form-user&action=new`, {
        headers: {
            'X-Requested-Width': 'XMLHttpRequest'
        },
        method: 'POST',
        body: data
    })
    return res.json()
}