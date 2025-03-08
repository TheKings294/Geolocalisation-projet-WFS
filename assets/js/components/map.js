import {PATH_FOR_IMAGE} from "./shared/constant.js";
import {request} from "../services/http-request.js";

export const popupBigMap = (Infos) => {
    const hour = JSON.parse(Infos.hourly)
    const message = `
        <b>${Infos.name}</b>
        <br>
        <img src="${PATH_FOR_IMAGE + Infos.img}" style="width: 150px; height: auto">
        <p>Address : ${Infos.address}</p>
        <p><b>Monday</b> : ${hour[0].Lundi.ouverture} : ${hour[0].Lundi.fermeture}</p>
        <p><b>Tuesday</b> : ${hour[1].Mardi.ouverture} : ${hour[1].Mardi.fermeture}</p>
        <p><b>Wednesday</b> : ${hour[2].Mercredi.ouverture} : ${hour[2].Mercredi.fermeture}</p>
        <p><b>Thursday</b> : ${hour[3].Jeudi.ouverture} : ${hour[3].Jeudi.fermeture}</p>
        <p><b>Friday</b> : ${hour[4].Vendredi.ouverture} : ${hour[4].Vendredi.fermeture}</p>
        <p><b>Saturday</b> : ${hour[5].Samedi.ouverture} : ${hour[5].Samedi.fermeture}</p>
        <p><b>Sunday</b> : ${hour[6].Dimanche.ouverture} : ${hour[6].Dimanche.fermeture}</p>
    `
    return message
}