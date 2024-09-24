<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog list with sidebar 1 - Ecofood HTML5 templates</title>
    <meta name="description" content="Ecofood theme template">
    <meta name="author" content="AuCreative">
    <meta name="keywords" content="Ecofood theme template">
    <!-- Stylesheets -->
    <link href="fonts/fonts.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/switcher.css" rel="stylesheet">
    <link href="css/colors/green.css" rel="stylesheet" id="colors">
    <link href="css/retina.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.png">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <script src="js/modernizr-custom.js"></script>
    <style>
        /* Lightbox Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            margin: 15% auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        .modal-content img {
            width: 100%;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 25px;
            color: #fff;
            font-size: 35px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Existing HTML Content -->
    <div class="page-content blog-list-page-1 p-t-40 p-b-100">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-pull-4">
                    <div class="blog-item-1">
                        <div class="blog-item-image">
                            <a href="#" onclick="openModal('images/blog-item-04.jpg'); return false;">
                                <img src="images/blog-item-04.jpg" alt="Make: A healthy and delicious St. Patrick’s day smoothie" />
                            </a>
                        </div>
                        <div class="blog-item-title">
                            <h3 class="title">
                                <a href="#">Make: A healthy and delicious St. Patrick’s day smoothie</a>
                            </h3>
                        </div>
                        <p class="blog-item-date">
                            <i class="fa fa-clock-o"></i>
                            <span>on April 28, 2017</span>
                        </p>
                        <p class="blog-item-content">Proin aliquet gravida nibh, in fringilla est eleifend et. Pellentesque hendrerit augue ut eros iaculis elementum. Donec porta efficitur lorem ut ultricies. Donec vulputate leo a enim dapibus sollicitudin. In sed mollis sapien, in congue nulla. Mauris lorem nulla, tincidunt suscipit purus eu, dapibus semper lacus.</p>
                    </div>
                    <!-- Other blog items -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="img01">
    </div>

    <!-- Scripts -->
    <script>
        function openModal(imgSrc) {
            var modal = document.getElementById("myModal");
            var modalImg = document.getElementById("img01");
            modal.style.display = "block";
            modalImg.src = imgSrc;
        }

        function closeModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }
    </script>
</body>

</html>