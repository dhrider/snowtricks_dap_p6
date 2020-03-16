// assets/js/app.js

require('../css/app.css');

$(document).ready(function() {

    const scrollArrow = document.getElementById('scroll');
    const arrow = document.getElementById('arrow');
    let up = false;
    $(document).on('click', '#scroll', function (e) {
        if(!up) {
            scrollArrow.setAttribute('href', '#tricks');
            scrollArrow.scrollIntoView(true);
            arrow.classList.remove('fa-chevron-down');
            arrow.classList.add('fa-chevron-up');
            up = true;
        } else {
            scrollArrow.setAttribute('href', '#home');
            scrollArrow.scrollIntoView(true);
            arrow.classList.remove('fa-chevron-up');
            arrow.classList.add('fa-chevron-down');
            up = false;
        }
    });

    let mediaCount = $('form .media').length;
    $(document).on('click', '#add-media', function (e) {
        e.preventDefault();
        // on récupère la div d'id Billet
        let medias = $('.medias');
        // on définit le numéro du billet qui servira pour l'identifier
        let media = medias.data('prototype').replace(/__name__/g,(medias.data('index')+ mediaCount));
        let newMedia = $('<div class="media"></div>').html(media);
        let btnDelete = $('<a class="btn btn-danger delete-media btn-sm" href="#"><i class="far fa-trash-alt"></i></a>');
        mediaCount++;

        newMedia.append(btnDelete);
        newMedia.appendTo(medias);
    });

    $(document).on('click', '.delete-media', function(e) {
        e.preventDefault();
        $(e.target).closest('.media').remove();
    });

    $(document).on('change', '.custom-file-input', function(e) {
        e.preventDefault();
        let inputFile = e.currentTarget;
        console.log($(inputFile).parent())
        $(inputFile).parent()
            .find('.custom-file-label')
            .html(inputFile.files[0].name);
    });

    /*$('.medias').on('change', function () {
        let preview = document.querySelector('#preview');
        let files   = document.querySelector('input[type=file]').files;

        function readAndPreview(file) {

            // Veillez à ce que `file.name` corresponde à nos critères d’extension
            if ( /\.(jpe?g|png|gif)$/i.test(file.name) ) {
                let reader = new FileReader();

                reader.addEventListener("load", function () {
                    let image = new Image();
                    image.height = 100;
                    image.title = file.name;
                    image.src = this.result;
                    preview.appendChild( image );
                }, false);

                reader.readAsDataURL(file);
            }

        }

        if (files) {
            [].forEach.call(files, readAndPreview);
        }
    })*/


});

