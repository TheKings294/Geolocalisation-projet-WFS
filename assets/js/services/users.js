export const getUsers = async (page = 1) => {
    const res = await fetch(`index.php?component=users&action=users&page=${page}`, {
        headers: {
            'X-Requested-Width': 'XMLHttpRequest'
        }
    })

    return await res.json()
}

export const getNbPage = async () => {
    const res = await fetch(`index.php?component=users&action=page`, {
        headers: {
            'X-Requested-Width': 'XMLHttpRequest'
        }
    })

    return await res.json()
}

export const countPage = (total) => {
    return Math.ceil(total/15)
}