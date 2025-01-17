<div>
    <h1 class="text-center mb-3">Map of Sell Point</h1>
</div>
<div class="map" style="height: 600px;" id="map">

</div>
<script src="./assets/js/components/shared/map.js" type="module"></script>
<script src="./assets/js/services/http-request.js" type="module"></script>
<script src="./assets/js/components/map.js" type="module"></script>
<script type="module">
    import {setMap, setMarker, setPolygon, setView} from "./assets/js/components/shared/map.js";
    import {request} from "./assets/js/services/http-request.js";
    import {popupBigMap} from "./assets/js/components/map.js";

    document.addEventListener('DOMContentLoaded', async () => {
        const sellPoint = await request('sell-point', 'get')
        const departement = await request('map', 'get_departments')
        setMap(47.16, 4.68, 6)
        for (let i = 0; i < sellPoint.result.length; i++) {
            const message = popupBigMap(sellPoint.result[i])

            let color = '#27742d'
            if(sellPoint.result[i].group_id !== null) {
                color = sellPoint.result[i].color
            }

            setMarker(message, parseFloat(sellPoint.result[i].coordonate_y), parseFloat(sellPoint.result[i].coordonate_x), color)
        }
        for (let i = 0; i < departement.result.length; i++) {
            console.log('nom', departement.result[i].name, 'json', JSON.parse(departement.result[i].polygon_json));
            setPolygon(JSON.parse(departement.result[i].polygon_json))
        }
        setView(47.16, 4.68, 6)
    })
</script>