export const request = async (component, action, who = null, sens = null, page = 1) => {
    let url = `index.php?component=${component}&action=${action}`
    if(action !== null && sens !== null) {
        url += `&page=${page}&who=${who}&sens=${sens}`
    }
    const res = await fetch(url, {
        headers: {
            'X-Requested-Width': 'XMLHttpRequest'
        }
    })
    if(res.ok) {
        return await res.json()
    }
    return res.error()
}