import {PATH_FOR_IMAGE} from "./shared/constant.js";

export const popupBigMap = (Infos) => {
    const hour = JSON.parse(Infos.hourly)
    const message = `
        <b>${Infos.name}</b>
        <br>
        <img src="${PATH_FOR_IMAGE + Infos.img}" style="width: 150px; height: auto">
        <p>Address : ${Infos.address}</p>
        <p><b>Monday</b> : ${hour.Lundi.ouverture} : ${hour.Lundi.fermeture}</p>
        <p><b>Tuesday</b> : ${hour.Mardi.ouverture} : ${hour.Mardi.fermeture}</p>
        <p><b>Wednesday</b> : ${hour.Mercredi.ouverture} : ${hour.Mercredi.fermeture}</p>
        <p><b>Thursday</b> : ${hour.Jeudi.ouverture} : ${hour.Jeudi.fermeture}</p>
        <p><b>Friday</b> : ${hour.Vendredi.ouverture} : ${hour.Vendredi.fermeture}</p>
        <p><b>Saturday</b> : ${hour.Samedi.ouverture} : ${hour.Samedi.fermeture}</p>
        <p><b>Sunday</b> : ${hour.Dimanche.ouverture} : ${hour.Dimanche.fermeture}</p>
    `
    return message
}
export const colorMarker = () => {

}