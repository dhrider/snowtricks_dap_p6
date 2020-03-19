// assets/js/app.js

require('../css/app.css');

$(document).ready(function() {

    const scrollArrow = document.getElementById('scroll');
    const arrow = document.getElementById('arrow');
    let up = false;
    $(document).on('click', '#scroll', function (e) {
        e.preventDefault();
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

    let imageCount = $('form .image').length;
    $(document).on('click', '#add-image', function (e) {
        e.preventDefault();
        // on récupère la div d'id Billet
        let images = $('.images');
        // on définit le numéro du billet qui servira pour l'identifier
        let image = images.data('prototype').replace(/__name__/g,(images.data('index') + imageCount));
        let newImage = $('<div class="image input-group"></div>').html(image);
        let btnDelete = $('<div class="input-group-append delete-image ">'+
                                '<span class="input-group-text" id=""><i class="far fa-trash-alt"></i></span>' +
                          '</div>'
        );
        imageCount++;

        newImage.append(btnDelete);
        newImage.appendTo(images);
    });

    let linkCount = $('form .videoLink').length;
    $(document).on('click', '#add-link', function (e) {
        e.preventDefault();
        // on récupère la div d'id Billet
        let videoLinks = $('.videoLinks');
        // on définit le numéro du billet qui servira pour l'identifier
        let videoLink = videoLinks.data('prototype').replace(/__name__/g,(videoLinks.data('index')+ linkCount));
        let newVideoLink = $('<div class="videoLink input-group"></div>').html(videoLink);
        let btnDelete = $('<div class="input-group-append delete-videoLink">'+
                                '<span class="input-group-text" id=""><i class="far fa-trash-alt"></i></span>' +
                          '</div>'
        );
        linkCount++;

        newVideoLink.append(btnDelete);
        newVideoLink.appendTo(videoLinks);
    });

    $(document).on('click', '.delete-image', function(e) {
        e.preventDefault();
        let imageName = $(e.currentTarget).parent().find('.custom-file-label').text();
        document.getElementById(imageName).remove();
        $(e.target).closest('.image').remove();
    });

    $(document).on('click', '.delete-videoLink', function(e) {
        e.preventDefault();
        $(e.target).closest('.videoLink').remove();
    });

    $(document).on('change', '.images input[type=file]',  function (element) {
        let inputFile = element.currentTarget;
        $(inputFile).parent()
            .find('.custom-file-label')
            .html(inputFile.files[0].name);

        let preview = document.querySelector('#preview');
        const file = this.files[0];
        let reader = new FileReader();

        reader.addEventListener("load", function () {
            let image = new Image();
            image.height = 100;
            image.title = file.name;
            image.src = this.result;
            image.id = inputFile.files[0].name;
            preview.appendChild( image );
        }, false);

        reader.readAsDataURL(file);

    });


});

