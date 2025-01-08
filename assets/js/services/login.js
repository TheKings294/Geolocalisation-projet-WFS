export const login = async (form) => {
    const data = new FormData(form)

    const res = await fetch('index.php', {
        method: 'POST',
        body: data,
        headers: {
            'X-Requested-Width': 'XMLHttpRequest'
        }
    })
    return await res.json()
}