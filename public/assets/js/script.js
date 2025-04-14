window.onload = function () {

    let form = document.querySelector('#form')
    let fileField = document.querySelector('#input-image')
    let my_modal_1= document.querySelector('#my_modal_1')
    let button = document.querySelector('.btn')
    let spinner = document.querySelector('.loading-spinner')
    let divImg = document.querySelector('.img')


    form.onsubmit = (event) => {
        event.preventDefault()

        let formData = new FormData();
        formData.append('imagem', fileField.files[0]);  // Here fileField is the input file reference

        xmlHttpPost('/facedetect', () => {

            beforeSend(() => {
                spinner.classList.remove('hidden')
                button.classList.add('btn-disabled')
            })

            success(() => {
                spinner.classList.add('hidden')
                button.classList.remove('btn-disabled')

                let response = JSON.parse(xhttp.responseText)

                divImg.innerHTML = `<img src="${response.file}" alt="" id="image-detect">`

                my_modal_1.showModal()
            })

        }, formData)

    }

}




