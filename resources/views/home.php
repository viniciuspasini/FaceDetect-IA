<?php $this->layout('template', ['title' => $title]) ?>

<dialog id="my_modal_1" class="modal">
    <div class="modal-box">

        <div class="img">

        </div>


        <div class="modal-action">
            <form method="dialog">
                <!-- if there is a button in form, it will close the modal -->
                <button class="btn">Close</button>
            </form>
        </div>
    </div>
</dialog>


<div class="hero bg-base-200 min-h-screen">
    <div class="hero-content">
        <div class="max-w-md">
            <form action="/facedetect" method="post" id="form" enctype="multipart/form-data">
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Pick a image</legend>
                    <input type="file" class="file-input" id="input-image"/>
                    <button class="btn btn-soft">
                        <span class="loading loading-spinner hidden"></span>
                        Face Detect
                    </button>
                </fieldset>
            </form>
        </div>
    </div>
</div>




