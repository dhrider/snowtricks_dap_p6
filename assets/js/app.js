// assets/js/app.js

require('../css/app.css');

$(document).ready(function() {
    // on récupère la div 'scroll' et la balise <a> contenant la flèche up/down
    const scrollArrow = document.getElementById('scroll')
    const arrow = document.getElementById('arrow')
    let up = false
    // à chaque click sur la flèche
    $(document).on('click', '#scroll', function (e) {
        if(!up) { // si la flèche est vers le bas en scroll bas et on change le sens de la flèche
            scrollArrow.setAttribute('href', '#tricks')
            scrollArrow.scrollIntoView(true)
            arrow.classList.remove('fa-chevron-down')
            arrow.classList.add('fa-chevron-up')
            up = true
        } else { // si la flèche est vers le haut en scroll bas et on change le sens de la flèche
            scrollArrow.setAttribute('href', '#home')
            scrollArrow.scrollIntoView(true)
            arrow.classList.remove('fa-chevron-up')
            arrow.classList.add('fa-chevron-down')
            up = false
        }
    });

    // à chaque click sur le bouton "Upload New Image" on crée un File input grâce à son prototype
    let imageCount = $('form .image').length;
    $(document).on('click', '#add-image', function (e) {
        e.preventDefault()
        // on récupère la div d'id Billet
        let images = $('.images')
        // on définit le numéro du billet qui servira pour l'identifier
        let image = images.data('prototype').replace(/__name__/g,(images.data('index') + imageCount))
        let newImage = $('<div class="image input-group"></div>').html(image)
        let btnDelete = $('<div class="input-group-append delete-image">'+
                                '<span class="input-group-text" id=""><i class="far fa-trash-alt"></i></span>' +
                          '</div>'
        );
        imageCount++

        newImage.append(btnDelete)
        newImage.appendTo(images)
    });

    // à chaque click sur le bouton "Add a new Link" on crée un Text input grâce à son prototype
    let linkCount = $('form .videoLink').length;
    $(document).on('click', '#add-link', function (e) {
        e.preventDefault()
        // on récupère la div d'id Billet
        let videoLinks = $('.videoLinks')
        // on définit le numéro du billet qui servira pour l'identifier
        let videoLink = videoLinks.data('prototype').replace(/__name__/g,(videoLinks.data('index')+ linkCount))
        let newVideoLink = $('<div class="videoLink input-group"></div>').html(videoLink)
        let btnDelete = $('<div class="input-group-append delete-videoLink">'+
                                '<span class="input-group-text" id=""><i class="far fa-trash-alt"></i></span>' +
                          '</div>'
        );
        linkCount++;

        newVideoLink.append(btnDelete)
        newVideoLink.appendTo(videoLinks)
    });

    // permet d'effacer l'input image sélectionné
    $(document).on('click', '.delete-image', function(e) {
        e.preventDefault()
        // on delete l'input
        $(e.target).closest('.image').remove()
    });

    $(document).on('click', '.delete-videoLink', function(e) {
        e.preventDefault()
        // on delete l'input
        $(e.target).closest('.videoLink').remove()
    });

    $(document).on('change', 'input[type=file]',  function (element) {
        // on récupère le nom du fichier dans le label de l'input (caché par Bootstrap 4)
        // et on l'affiche
        let inputFile = element.currentTarget
        $(inputFile).parent()
            .find('.custom-file-label')
            .html(inputFile.files[0].name)
    });

    // on récupère le bouton "show Medias"
    const h = document.getElementById('show_media')
    // on récupère la div contenant les médias
    const media = document.getElementById('media')
    // gestion du click : on cache le bouton et on affiche les médias
    $(document).on('click', '#show_media', function (e) {
        e.preventDefault()
        h.setAttribute('hidden', 'hidden')
        media.removeAttribute('hidden')
    })

    // on récupère un média Query
    const mq = window.matchMedia( "(max-width: 768px)" )

    // on cache les média quand la résolution est < 768px
    if (mq.matches) {
        media.setAttribute('hidden', 'hidden')
    } else {
        media.removeAttribute('hidden')
    }

});