export const request = async (component, action, who = null, sens = null, page = 1, form = null, methode) => {
    let url = `index.php?component=${component}&action=${action}`
    let data = null
    if(action !== null && sens !== null) {
        url += `&page=${page}&who=${who}&sens=${sens}`
    }
    if(form !== null) {
        data = form
    }
    const res = await fetch(url, {
        method: methode,
        headers: {
            'X-Requested-Width': 'XMLHttpRequest'
        },
        body: data
    })
    if(res.ok) {
        return await res.json()
    }
    return res.error()
}