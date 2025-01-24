<div class="mt-3 mb-3">
    <?php require './_partials/progress-bar.html'?>
</div>
<div class="mt-3" id="form-sell-point">
    <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button
            class="nav-link active text-warning nav-form"
            id="nav-gene-info-tab"
            data-bs-toggle="tab"
            data-bs-target="#nav-home"
            type="button"
            role="tab"
            aria-controls="nav-home"
            aria-selected="true"
            disabled>
            General Information
        </button>
        <button
            class="nav-link text-warning nav-form"
            id="nav-hour-tab"
            data-bs-toggle="tab"
            data-bs-target="#nav-profile"
            type="button"
            role="tab"
            aria-controls="nav-profile"
            aria-selected="false"
            disabled>
            Hourly
        </button>
        <button
            class="nav-link text-warning nav-form"
            id="nav-img-tab"
            data-bs-toggle="tab"
            data-bs-target="#nav-contact"
            type="button"
            role="tab"
            aria-controls="nav-contact"
            aria-selected="false"
            disabled>
            Image
        </button>
    </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
            <form id="form1">
                <div class="row mb-3">
                    <div class="col">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col">
                        <label for="manager-name" class="form-label">Manager Name</label>
                        <input type="text" class="form-control" id="manager-name" name="manager-name" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-8">
                        <label for="siret-number" class="form-label">SIRET</label>
                        <input type="text" class="form-control" id="siret-number" name="siret" required>
                    </div>
                    <div class="col">
                        <label class="form-label">Search by siret number</label>
                        <button class="btn btn-success form-control text-warning" id="sirene-api-btn" type="button" title="Hover message" disabled>SIRET API</button>
                    </div>
                </div>

                <div class=" row mb-3">
                    <div class="col-auto">
                        <label for="groupe-name" class="form-label mb-4">Group Name</label>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" aria-label="Default select example" id="groupList" name="groupe-name">
                            <option selected class="list-item" value="null">--Group--</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="button" id="modal-open" class="btn btn-success text-warning">Create an group</button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" required data-x="" data-y="" data-dep="">
                </div>
                <div class="map" id="map" style="height: 300px">

                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
            <form id="form2">
                <div class="row mb-3">
                    <h4 class="text-warning">Monday</h4>
                    <div class="col">
                        <label for="monday-start" class="form-label">Open</label>
                        <input type="time" class="form-control form-control-sm time" id="monday-start" name="monday-start">
                    </div>
                    <div class="col">
                        <label for="monday-stop" class="form-label">Close</label>
                        <input type="time" class="form-control form-control-sm time" id="monday-stop" name="monday-stop">
                    </div>
                </div>
                <div class="row mb-3">
                    <h4 class="text-warning">Tuesday</h4>
                    <div class="col">
                        <label for="tuesday-start" class="form-label">Open</label>
                        <input type="time" class="form-control form-control-sm time" id="tuesday-start" name="tuesday-start">
                    </div>
                    <div class="col">
                        <label for="tuesday-stop" class="form-label">Close</label>
                        <input type="time" class="form-control form-control-sm time" id="tuesday-stop" name="tuesday-stop">
                    </div>
                </div>
                <div class="row mb-3">
                    <h4 class="text-warning">Wednesday</h4>
                    <div class="col">
                        <label for="wednesday-start" class="form-label">Open</label>
                        <input type="time" class="form-control form-control-sm time" id="wednesday-start" name="wednesday-start">
                    </div>
                    <div class="col">
                        <label for="wednesday-stop" class="form-label">Close</label>
                        <input type="time" class="form-control form-control-sm time" id="wednesday-stop" name="wednesday-stop">
                    </div>
                </div>
                <div class="row mb-3">
                    <h4 class="text-warning">Thursday</h4>
                    <div class="col">
                        <label for="thursday-start" class="form-label">Open</label>
                        <input type="time" class="form-control form-control-sm time" id="thursday-start" name="thursday-start">
                    </div>
                    <div class="col">
                        <label for="thursday-stop" class="form-label">Close</label>
                        <input type="time" class="form-control form-control-sm time" id="thursday-stop" name="thursday-stop">
                    </div>
                </div>
                <div class="row mb-3">
                    <h4 class="text-warning">Friday</h4>
                    <div class="col">
                        <label for="friday-start" class="form-label">Open</label>
                        <input type="time" class="form-control form-control-sm time" id="friday-start" name="friday-start">
                    </div>
                    <div class="col">
                        <label for="friday-stop" class="form-label">Close</label>
                        <input type="time" class="form-control form-control-sm time" id="friday-stop" name="monday-stop">
                    </div>
                </div>
                <div class="row mb-3">
                    <h4 class="text-warning">Saturday</h4>
                    <div class="col">
                        <label for="saturday-start" class="form-label">Open</label>
                        <input type="time" class="form-control form-control-sm time" id="saturday-start" name="saturday-start">
                    </div>
                    <div class="col">
                        <label for="saturday-stop" class="form-label">Close</label>
                        <input type="time" class="form-control form-control-sm time" id="saturday-stop" name="monday-stop">
                    </div>
                </div>
                <div class="row mb-3" id="sunday">
                    <h4 class="text-warning">Sunday</h4>
                    <div class="col">
                        <label for="sunday-start" class="form-label">Open</label>
                        <input type="time" class="form-control form-control-sm time" id="sunday-start" name="sunday-start">
                    </div>
                    <div class="col">
                        <label for="sunday-stop" class="form-label">Close</label>
                        <input type="time" class="form-control form-control-sm time" id="sunday-stop" name="sunday-stop">
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
            <form id="form3" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="img" class="form-label">Image</label>
                    <input class="form-control" type="file" id="img" name="img" required>
                </div>
                <div class="mb-3" id="img-view">

                </div>
                <div class="mb-3">
                    <button type="button" id="form-btn" class="btn btn-success text-warning">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="d-flex justify-content-between mt-4">
    <button class="btn btn-success text-warning" id="prev-btn" disabled>Previous</button>
    <button class="btn btn-success text-warning" id="next-btn">Next</button>
</div>
<script src="./assets/js/components/form-sell-point.js" type="module"></script>
<script type="module">
    import {formSPFuntion, editSellPointFonction} from "./assets/js/components/form-sell-point.js";

    document.addEventListener('DOMContentLoaded', () => {
        const url = new URL(window.location.href);
        const params = url.searchParams;
        if(params.has('action') && params.get('action') === "get") {
            editSellPointFonction(params.get('id'))
        } else if (params.has('action') && params.get('action') === "new") {
            formSPFuntion()
        }
    })
</script>