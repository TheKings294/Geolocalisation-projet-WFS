export const addressAutoCompletion = async (value) => {
    const res = await fetch(`https://api-adresse.data.gouv.fr/search/?q=${value}&limit=10`)

    return await res.json()
}
export const getDepartement = async (value) => {
    const res = await fetch(`https://geo.api.gouv.fr/communes?codePostal=${value}&fields=departement`)

    return await res.json()
}