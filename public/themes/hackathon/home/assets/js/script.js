// Select Upload-Area
const uploadArea = document.querySelector('#uploadArea');

// Select Drop-Zone Area
const dropZoon = document.querySelector('#dropZoon');

// Loading Text
const loadingText = document.querySelector('#loadingText');

// Select File Input 
const fileInput = document.querySelector('#fileInput');

// Select Preview Image
const previewImage = document.querySelector('#previewImage');

// File-Details Area
const fileDetails = document.querySelector('#fileDetails');

// Uploaded File
const uploadedFile = document.querySelector('#uploadedFile');

// Uploaded File Info
const uploadedFileInfo = document.querySelector('#uploadedFileInfo');

// Uploaded File Name
const uploadedFileName = document.querySelector('.uploaded-file__name');

// Uploaded File Icon
// const uploadedFileIconText = document.querySelector('.uploaded-file__icon-text');

// Uploaded File Counter
const uploadedFileCounter = document.querySelector('.uploaded-file__counter');

// ToolTip Data
const toolTipData = document.querySelector('.upload-area__tooltip-data');

// Önişleme resimlerinin haritası
const fileTypeToImageMap = {
    'image/jpeg': 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a7/PNG_transparency_demonstration_1.png/1200px-PNG_transparency_demonstration_1.png', // JPEG
    'image/png': 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a7/PNG_transparency_demonstration_1.png/1200px-PNG_transparency_demonstration_1.png', // PNG
    'image/gif': 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e6/GIF_example_animation.gif/640px-GIF_example_animation.gif', // GIF
    'application/x-httpd-php': 'https://www.php.net/images/logos/php-logo.svg', // PHP
    'text/plain': 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Text-file-icon.svg/1200px-Text-file-icon.svg.png', // TXT
    'application/javascript': 'https://www.svgrepo.com/show/303206/javascript-logo.svg', // JS
    'text/javascript': 'https://www.svgrepo.com/show/303206/javascript-logo.svg', // JS (alternatif)

};

// When (drop-zone) has (dragover) Event 
dropZoon.addEventListener('dragover', function (event) {
    event.preventDefault();
    dropZoon.classList.add('drop-zoon--over');
});

// When (drop-zone) has (dragleave) Event 
dropZoon.addEventListener('dragleave', function () {
    dropZoon.classList.remove('drop-zoon--over');
});

// When (drop-zone) has (drop) Event 
dropZoon.addEventListener('drop', function (event) {
    event.preventDefault();
    dropZoon.classList.remove('drop-zoon--over');
    const file = event.dataTransfer.files[0];
    uploadFile(file);
});

// When (drop-zone) has (click) Event 
dropZoon.addEventListener('click', function () {
    fileInput.click();
});

// When (fileInput) has (change) Event 
fileInput.addEventListener('change', function (event) {
    const file = event.target.files[0];
    uploadFile(file);
});

// Upload File Function
function uploadFile(file) {
    const fileReader = new FileReader();
    const fileSize = file.size;

    // Dosya Türü
    let fileType = file.type;

    // Eğer file.type boşsa, uzantıya göre varsayılan bir tür belirle
    if (!fileType) {
        if (file.name.endsWith('.php')) {
            fileType = 'application/x-httpd-php';
        } else if (file.name.endsWith('.txt')) {
            fileType = 'text/plain';
        } else if (file.name.endsWith('.js')) {
            fileType = 'application/javascript';
        }
    }

    // Eğer dosya geçerliyse devam et
    if (fileValidate(fileType, fileSize)) {
        dropZoon.classList.add('drop-zoon--Uploaded');
        loadingText.style.display = "block";
        previewImage.style.display = 'none';
        uploadedFile.classList.remove('uploaded-file--open');
        uploadedFileInfo.classList.remove('uploaded-file__info--active');

        // Önişleme resmini belirle
        const previewImageSrc = fileTypeToImageMap[fileType] || 'path/to/default-logo.png';
        previewImage.setAttribute('src', previewImageSrc);

        fileReader.addEventListener('load', function () {
            setTimeout(function () {
                uploadArea.classList.add('upload-area--open');
                loadingText.style.display = "none";
                previewImage.style.display = 'block';
                fileDetails.classList.add('file-details--open');
                uploadedFile.classList.add('uploaded-file--open');
                uploadedFileInfo.classList.add('uploaded-file__info--active');
            }, 500);

            uploadedFileName.innerHTML = file.name;

            // Call Function progressMove();
            progressMove();
        });

        // Read (file) As Data Url 
        fileReader.readAsDataURL(file);
    }
}

// Progress Counter Increase Function
function progressMove() {
    let counter = 0;
    setTimeout(() => {
        let counterIncrease = setInterval(() => {
            if (counter === 100) {
                clearInterval(counterIncrease);
            } else {
                counter += 10;
                uploadedFileCounter.innerHTML = `${counter}%`;
            }
        }, 100);
    }, 600);
}

// Simple File Validate Function
function fileValidate(fileType, fileSize) {
    const allowedTypes = Object.keys(fileTypeToImageMap); // Haritadan türleri al
    let isValidType = allowedTypes.includes(fileType);
    if (!isValidType) {
        alert('Lütfen geçerli bir dosya yüklediğinizden emin olun.');
        return false; // Geçersiz dosya türü
    }

    if (fileSize > 2000000) { // 2MB
        alert('Dosya boyutunuz 2 megabayt veya daha az olmalıdır.');
        return false; // Fazla büyük dosya
    }

    // uploadedFileIconText.innerHTML = fileType.split('/')[1]; // 'text/plain' -> 'plain'
    return true; // Dosya geçerli
}

$(document).ready(function () {
    $('#resultContainer').hide();
    const url = window.location.pathname;

    const urlParts = url.split('/');

    const lessonId = urlParts[urlParts.length - 1];


    $('#uploadButton').click(function () {
        var fileInput = $('#fileInput')[0].files[0];
        $('#loading-animation').show();
        $(this).prop("disabled", true); 

        if (fileInput) {
            var reader = new FileReader();

            reader.onload = function (event) {
                var fileContent = event.target.result;
                $.ajax({
                    url: '/src/Ajax/hackathon/home/AiAjax.php',
                    type: 'POST',
                    data: {
                        fileContent: fileContent,
                        idContent: lessonId
                    },
                    success: function (response) {
                        $('#resultContainer').show();
                        $(".result").html(response.analysis);
                        $('#loading-animation').hide()
                        console.log('Kod analiz sonucu:', response);
                    },
                    error: function (xhr, status, error) {
                        console.error('Hata:', error);
                    },
                    complete: function () {
                        // AJAX işlemi tamamlandığında butonu tekrar enable et
                        $('#uploadButton').prop("disabled", false); // Butonu yeniden aktif hale getir
                    }
                });
            };

            reader.readAsText(fileInput);
        } else {
            alert("Lütfen bir dosya seçin.");
            // Hata durumunda butonu tekrar enable et
            $('#uploadButton').prop("disabled", false); // Butonu yeniden aktif hale getir
        }
    });
});