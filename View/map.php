<div>
    <h1 class="text-center mb-3">Map of Sell Point</h1>
</div>
<div class="map" style="height: 600px;" id="map">

</div>
<script src="./assets/js/components/shared/map.js" type="module"></script>
<script src="./assets/js/services/http-request.js" type="module"></script>
<script src="./assets/js/components/map.js" type="module"></script>
<script type="module">
    import {setMap, setMarker} from "./assets/js/components/shared/map.js";
    import {request} from "./assets/js/services/http-request.js";
    import {popupBigMap, colorMarker} from "./assets/js/components/map.js";

    document.addEventListener('DOMContentLoaded', async () => {
        const sellPoint = await request('sell-point', 'get')
        setMap(47.16, 4.68, 6)
        const colorTab = await colorMarker()
        for (let i = 0; i < sellPoint.result.length; i++) {
            const message = popupBigMap(sellPoint.result[i])
            let color
            if(colorTab.some(item => Object.keys(item).some(key => key === sellPoint.result[i].group_name))) {
                let groupName = sellPoint.result[i].group_name
                color = colorTab.find(item => item.hasOwnProperty(groupName))?.[groupName]
            } else {
                color = '#27742d'
            }
            setMarker(message, parseFloat(sellPoint.result[i].coordonate_y), parseFloat(sellPoint.result[i].coordonate_x), color)
        }
    })
</script>